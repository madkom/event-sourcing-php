<?php

namespace Madkom\ES\Banking\Domain\Infrastructure\Domain;

use Madkom\ES\Banking\Domain\DomainEvent;
use Madkom\ES\Banking\Domain\DomainEventSubscriber;

/**
 * Class DomainEventPublisher
 * @package Madkom\ES\Banking\Domain\Infrastructure\Domain
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class DomainEventPublisher implements \Madkom\ES\Banking\Domain\DomainEventPublisher
{

    /** @var array|DomainEventSubscriber[][] */
    private $subscribers = [];

    /**
     * @inheritDoc
     */
    public function subscribe(DomainEventSubscriber $domainEventSubscriber, $eventType)
    {
        $this->subscribers[$eventType][] = $domainEventSubscriber;
    }

    /**
     * @inheritDoc
     */
    public function publish(DomainEvent $event)
    {
        $eventType = get_class($event);

        if(!array_key_exists($eventType, $this->subscribers)) {
            return;
        }

        foreach($this->subscribers[$eventType] as $subscriber) {
            $subscriber->handle($event);
        }

    }

}