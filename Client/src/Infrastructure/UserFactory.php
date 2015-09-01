<?php

namespace Dgafka\ES\Client\Infrastructure;


use Broadway\Domain\DomainEventStreamInterface;
use Broadway\EventSourcing\AggregateFactory\AggregateFactoryInterface;
use Dgafka\ES\Client\Domain\User\User;

class UserFactory implements AggregateFactoryInterface
{

    /**
     * @param string                     $aggregateClass the FQCN of the Aggregate to create
     * @param DomainEventStreamInterface $domainEventStream
     *
     * @return \Broadway\EventSourcing\EventSourcedAggregateRoot
     */
    public function create($aggregateClass, DomainEventStreamInterface $domainEventStream)
    {
        $user = new User();
        $user->initializeState($domainEventStream);

        return $user;
    }


}