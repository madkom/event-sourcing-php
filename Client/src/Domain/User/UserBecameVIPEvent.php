<?php

namespace Dgafka\ES\Client\Domain\User;

use Dgafka\ES\Client\SharedKernel\Domain\DomainEvent;

/**
 * Class UserBecameVIPEvent
 *
 * @package Dgafka\ES\Client\Domain\User
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class UserBecameVIPEvent implements DomainEvent
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

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return ['userID' => $this->userID];
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        $this->userID = $serialized['userID'];
    }


}
