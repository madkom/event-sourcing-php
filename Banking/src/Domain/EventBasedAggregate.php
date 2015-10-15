<?php

namespace Madkom\ES\Banking\Domain;

/**
 * Interface EventBasedAggregate
 * @package Madkom\ES\Banking\Domain
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
interface EventBasedAggregate
{

    /**
     * Returns uncommitted events
     *
     * @return array|DomainEvent[]
     */
    public function getUncommittedEvents();

}