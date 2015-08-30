<?php

namespace Dgafka\ES\Client\Domain\User;

/**
 * Class UserBecameVIPEvent
 *
 * @package Dgafka\ES\Client\Domain\User
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class UserBecameVIPEvent
{

    /** @var  string */
    private $userID;

    /**
     * @param string $userID
     */
    public function __construct($userID)
    {
        $this->userID = $userID;
    }

    /**
     * @return string
     */
    public function ID()
    {
        return $this->userID;
    }
}
