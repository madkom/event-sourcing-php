<?php

namespace Dgafka\ES\Client\Infrastructure;

use Broadway\Domain\DateTime;
use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainEventStreamInterface;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use Broadway\EventStore\EventStoreInterface;
use Dgafka\ES\Client\Domain\User\User;
use Dgafka\ES\Client\Domain\User\UserID;
use EventStore\EventStore;
use EventStore\Exception\StreamNotFoundException;
use EventStore\WritableEvent;
use EventStore\WritableEventCollection;
use JMS\Serializer\SerializerBuilder;

class EventStoreAtom implements EventStoreInterface
{

    /** @var EventStore  */
    private $eventStore;

    public function __construct()
    {
        $this->eventStore = new EventStore('http://' . getenv('ES_PORT_2113_TCP_ADDR') . ':' . getenv('ES_PORT_2113_TCP_PORT'));
    }

    /**
     * @param mixed $id
     *
     * @return DomainEventStreamInterface
     *
     * @throws \Exception
     */
    public function load($id)
    {
        try{
//            Not production ready. It should use memento pattern
            $streamFeed = $this->eventStore->openStreamFeed($id);
            $this->eventStore->navigateStreamFeed($streamFeed, \EventStore\StreamFeed\LinkRelation::FIRST());

            $aggregateEvents = [];
            while(!empty($streamFeed)) {

                foreach($streamFeed->getEntries() as $entry) {
                    $event = $this->eventStore->readEvent($entry->getEventUrl());
                    $data  = $event->getData();

                    $type = str_replace('.', '\\', $data['type']);
                    $reproducedDomainEventRfl = new \ReflectionClass($type);
                    $reproducedDomainEvent = $reproducedDomainEventRfl->newInstanceWithoutConstructor();
                    $reproducedDomainEvent->unserialize($data['payload']);

                    $domainMessage = new DomainMessage(
                        new UserID($data['uuid']),
                        $data['playhead'],
                        new Metadata($data['metadata']),
                        $reproducedDomainEvent,
                        DateTime::fromString($data['recorded_on'])
                    );

                    array_unshift($aggregateEvents, $domainMessage);
                }

                $streamFeed = $this->eventStore->navigateStreamFeed($streamFeed, \EventStore\StreamFeed\LinkRelation::NEXT());
            }



            return new DomainEventStream($aggregateEvents);

        }catch (StreamNotFoundException $e) {
            throw new \Exception('Aggregate with ' . $id . ' doesn\'t exists');
        }
    }

    /**
     * @param mixed                      $id
     * @param DomainEventStreamInterface $eventStream
     */
    public function append($id, DomainEventStreamInterface $eventStream)
    {
        $eventsToSave = [];


        /** @var DomainMessage $domainMessage */
        foreach($eventStream->getIterator() as $domainMessage) {
            $event['uuid']     = $domainMessage->getId()->ID();
            $event['playhead'] = $domainMessage->getPlayhead();
            $event['metadata'] = $domainMessage->getMetadata()->serialize();
            $event['payload']  = $domainMessage->getPayload()->serialize();
            $event['recorded_on'] = $domainMessage->getRecordedOn()->toString();
            $event['type']     = $domainMessage->getType();

            $eventsToSave[] = WritableEvent::newInstance($domainMessage->getType(), $event, $domainMessage->getMetadata()->serialize());
        }

        //If any event arrived. There are actions, which doesn't create events
        if(isset($domainMessage)) {
            $eventsCollection = new WritableEventCollection($eventsToSave);

            $this->eventStore->writeToStream($domainMessage->getId()->ID(), $eventsCollection);
        }
    }

}