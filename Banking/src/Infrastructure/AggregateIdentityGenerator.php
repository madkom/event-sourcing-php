<?php

namespace Madkom\ES\Banking\Domain\Infrastructure;

use Rhumsaa\Uuid\Uuid;

/**
 * Class AggregateIdentityGenerator
 * @package Madkom\ES\Banking\Domain\Infrastructure
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class AggregateIdentityGenerator
{

    /**
     * Returns new generated id
     *
     * @return string
     */
    public static function generateID()
    {
        $uuid = Uuid::uuid1();
        return $uuid->toString();
    }

}