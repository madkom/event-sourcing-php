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

    /** @var  UserID */
    private $userID;

    /** @var  UserData */
    private $userData;

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return $this->userID;
    }

    /**
     * Registers new user
     *
     * @param UserID   $userID
     * @param UserData $userInformation
     *
     * @return static
     */
    public static function register(UserID $userID, UserData $userInformation)
    {
        $user = new static();

        $user->apply(new UserRegisteredEvent($userID->ID(), $userInformation->name(), $userInformation->surname()));

        return $user;
    }


    /**
     * Changes user data
     *
     * @param UserData $userData
     */
    public function changeUserData(UserData $userData)
    {
        $this->apply(new UserChangedDataEvent($userData->name(), $userData->surname()));
    }

    /**
     * Applies user registered event
     *
     * @param UserRegisteredEvent $userRegisteredEvent
     */
    protected function applyUserRegisteredEvent(UserRegisteredEvent $userRegisteredEvent)
    {
        $this->userID    = new UserID($userRegisteredEvent->userID());
        $this->userData  = new UserData($userRegisteredEvent->name(), $userRegisteredEvent->surname());
    }

    /**
     * Applies user changed data event
     *
     * @param UserChangedDataEvent $userChangedData
     */
    protected function applyUserChangedData(UserChangedDataEvent $userChangedData)
    {
        $this->userData = new UserData($userChangedData->name(), $userChangedData->surname());
    }

}
