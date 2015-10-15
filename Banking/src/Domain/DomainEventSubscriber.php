<?php

namespace Madkom\ES\Banking\Domain;

/**
 * Interface DomainEventSubscriber
 * @package Madkom\ES\Banking\Domain
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
interface DomainEventSubscriber
{

    /**
     * @param DomainEvent $event
     *
     * @return mixed
     *
     */
    public function handle(DomainEvent $event);

}