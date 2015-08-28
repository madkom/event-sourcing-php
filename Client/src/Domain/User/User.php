<?php

namespace Dgafka\ES\Client\Domain\User;

use Broadway\EventSourcing\EventSourcedAggregateRoot;

/**
 * User in Client System
 *
 * Class User
 * @package Dgafka\ES\Client\Domain\User
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class User extends EventSourcedAggregateRoot
{

    private $userInformation;

    public function __construct(UserInformation $userInformation)
    {

    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        // TODO: Implement getAggregateRootId() method.
    }

}
