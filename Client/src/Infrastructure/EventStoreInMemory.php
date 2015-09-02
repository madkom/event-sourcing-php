<?php

namespace Dgafka\ES\Client\Infrastructure;

use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainEventStreamInterface;
use Broadway\EventStore\EventStoreInterface;

/**
 * Class EventStoreInMemory
 * @package Dgafka\ES\Client\Infrastructure
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class EventStoreInMemory implements EventStoreInterface
{

    private $storage = [];

    /**
     * @param mixed $id
     *
     * @return DomainEventStreamInterface
     *
     * @throws \Exception
     */
    public function load($id)
    {
        if(!array_key_exists($id, $this->storage)) {
            throw new \Exception('Aggregate with ' . $id . ' doesn\'t exists');
        }

        return new DomainEventStream($this->storage[$id]);
    }

    /**
     * @param mixed                      $id
     * @param DomainEventStreamInterface $eventStream
     */
    public function append($id, DomainEventStreamInterface $eventStream)
    {
        foreach($eventStream->getIterator() as $event) {
            $this->storage[$id->ID()][] = $event;
        }
    }

}