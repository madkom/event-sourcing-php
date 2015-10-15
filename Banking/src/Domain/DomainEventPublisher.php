<?php

namespace Madkom\ES\Banking\Domain;

use Dgafka\ES\Client\SharedKernel\Domain\DomainEvent;

/**
 * Interface DomainEventPublisher
 * @package Madkom\ES\Banking\Domain
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
interface DomainEventPublisher
{

    /**
     * Publishes domain event to all listing subscribers
     *
     * @param DomainEvent $event
     *
     * @return void
     */
    public function publish(DomainEvent $event);

    /**
     * Subscribes to type of event
     *
     * @param DomainEventSubscriber $domainEventSubscriber
     * @param string                $eventType
     *
     * @return mixed
     */
    public function subscribe(DomainEventSubscriber $domainEventSubscriber, $eventType);

}