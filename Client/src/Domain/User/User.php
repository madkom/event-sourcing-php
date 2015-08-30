<?php

namespace Dgafka\ES\Client\Domain\User;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Dgafka\ES\Client\SharedKernel\Domain\DomainException;

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

    /** @var  UserStatus user status */
    private $status;

    /** @var  bool */
    private $vipStatus;

    /**
     * Construct user
     */
    public function __construct()
    {
        $this->status    = new UserStatus(UserStatus::ACTIVE);
        $this->vipStatus = false;
    }

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
     *
     * @throws DomainException
     */
    public function changeUserData(UserData $userData)
    {
        if(!$this->status->isActive()) {
            throw new DomainException('Can\' change user data, because user is not active.');
        }
        $this->apply(new UserChangedDataEvent($userData->name(), $userData->surname()));
    }

    /**
     * Change user status
     *
     * @param string $status
     */
    public function changeStatus($status)
    {

        if($this->status->equals($status)) {
            return;
        }

        $this->apply(new UserChangedStatusEvent($status));
    }

    /**
     * Make use VIP
     */
    public function becomeVIP()
    {
        if(!$this->status->isActive()) {
            throw new DomainException('Can\' change user data, because user is not active.');
        }

        if($this->vipStatus) {
            //We don't need to push event, since nothing will change
            return;
        }

        $this->apply(new UserBecameVIPEvent($this->userID->ID()));
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
    protected function applyUserChangedDataEvent(UserChangedDataEvent $userChangedData)
    {
        $this->userData = new UserData($userChangedData->name(), $userChangedData->surname());
    }

    /**
     * Applies user change status event
     *
     * @param UserChangedStatusEvent $userChangedStatus
     */
    protected function applyUserChangedStatusEvent(UserChangedStatusEvent $userChangedStatus)
    {
        $this->status = $this->status->changeStatus($userChangedStatus->status());
    }

    /**
     * Applies user became VIP event
     *
     * @param UserBecameVIPEvent $userBecameVIPEvent
     */
    protected function applyUserBecameVIPEvent(UserBecameVIPEvent $userBecameVIPEvent)
    {
        $this->vipStatus = true;
    }

}
