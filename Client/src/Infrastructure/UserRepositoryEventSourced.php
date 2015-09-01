<?php

namespace Dgafka\ES\Client\Infrastructure;

use Assert\Assertion;
use Broadway\Domain\AggregateRoot;
use Broadway\Domain\DomainEventStream;
use Broadway\EventSourcing\AggregateFactory\AggregateFactoryInterface;
use Broadway\EventSourcing\EventStreamDecoratorInterface;
use Broadway\EventStore\EventStoreInterface;
use Broadway\EventStore\EventStreamNotFoundException;
use Broadway\Repository\AggregateNotFoundException;
use Broadway\Repository\RepositoryInterface;
use Dgafka\ES\Client\Domain\User\User;
use Dgafka\ES\Client\Domain\User\UserID;
use Dgafka\ES\Client\Domain\User\UserRepository;

/**
 * Class UserRepositoryInMemory
 * @package Dgafka\ES\Client\Infrastructure
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class UserRepositoryEventSourced implements UserRepository, RepositoryInterface
{

    private $eventStore;
    private $aggregateClass;
    private $eventStreamDecorators = array();
    private $aggregateFactory;

    /**
     * @param EventStoreInterface             $eventStore
     * @param string                          $aggregateClass
     * @param AggregateFactoryInterface       $aggregateFactory
     * @param EventStreamDecoratorInterface[] $eventStreamDecorators
     */
    public function __construct(
        EventStoreInterface $eventStore,
        $aggregateClass,
        AggregateFactoryInterface $aggregateFactory,
        array $eventStreamDecorators = array()
    ) {
        $this->assertExtendsEventSourcedAggregateRoot($aggregateClass);

        $this->eventStore            = $eventStore;
        $this->aggregateClass        = $aggregateClass;
        $this->aggregateFactory      = $aggregateFactory;
        $this->eventStreamDecorators = $eventStreamDecorators;
    }

    /**
     * @param UserID $userID
     *
     * @return null|User
     */
    public function find(UserID $userID)
    {
        return $this->load($userID->ID());
    }

    /**
     * @param AggregateRoot $aggregate
     *
     * @return void
     */
    public function save(AggregateRoot $aggregate)
    {
        // maybe we can get generics one day.... ;)
        Assertion::isInstanceOf($aggregate, $this->aggregateClass);

        $domainEventStream = $aggregate->getUncommittedEvents();
        $eventStream       = $this->decorateForWrite($aggregate, $domainEventStream);
        $this->eventStore->append($aggregate->getAggregateRootId(), $eventStream);
    }

    /**
     * Loads an aggregate from the given id.
     *
     * @param mixed $id
     *
     * @return AggregateRoot
     *
     * @throws AggregateNotFoundException
     */
    public function load($id)
    {
        try {
            $domainEventStream = $this->eventStore->load($id);

            return $this->aggregateFactory->create($this->aggregateClass, $domainEventStream);
        } catch (EventStreamNotFoundException $e) {
            throw AggregateNotFoundException::create($id, $e);
        }
    }

    private function decorateForWrite(AggregateRoot $aggregate, DomainEventStream $eventStream)
    {
        $aggregateType       = $this->getType();
        $aggregateIdentifier = $aggregate->getAggregateRootId();

        foreach ($this->eventStreamDecorators as $eventStreamDecorator) {
            $eventStream = $eventStreamDecorator->decorateForWrite($aggregateType, $aggregateIdentifier, $eventStream);
        }

        return $eventStream;
    }

    private function assertExtendsEventSourcedAggregateRoot($class)
    {
        Assertion::subclassOf(
            $class,
            'Broadway\EventSourcing\EventSourcedAggregateRoot',
            sprintf("Class '%s' is not an EventSourcedAggregateRoot.", $class)
        );
    }

    private function getType()
    {
        return $this->aggregateClass;
    }

}