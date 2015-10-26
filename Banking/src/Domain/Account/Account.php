<?php

namespace Madkom\ES\Banking\Domain\Account;

use Doctrine\Common\Collections\ArrayCollection;
use Madkom\ES\Banking\Domain\DomainEvent;
use Madkom\ES\Banking\Domain\DomainException;
use Madkom\ES\Banking\Domain\EventBasedAggregate;
use Madkom\ES\Banking\Domain\Money;

/**
 * Class Account
 * @package Madkom\ES\Banking\Application\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Account implements EventBasedAggregate
{

    /** @var  AccountID */
    private $accountID;

    /** @var ClientID  */
    private $clientID;

    /** @var Money  */
    private $money;

    /** @var  ArrayCollection|Transfer[] */
    private $transfers;

    /** @var  bool Account status - active not active */
    private $active;

    /** @var array|DomainEvent[] */
    private $uncommitedEvents = [];

    /** @var  int */
    private $version;

    /**
     * @param AccountID $accountID
     * @param ClientID  $clientID
     * @param Money     $money
     * @param bool      $active
     * @param int       $version
     */
    public function __construct(AccountID $accountID, ClientID $clientID, Money $money, $active, $version)
    {
        $this->accountID = $accountID;
        $this->clientID = $clientID;
        $this->money    = $money;
        $this->active = $active;
        $this->version = $version;
        $this->transfers = new ArrayCollection();
    }

    /**
     * Debit money from account
     *
     * @param TransferFactory $transferFactory
     * @param AccountID       $toAccount
     * @param Money           $money
     *
     * @throws DomainException
     */
    public function debit(TransferFactory $transferFactory, AccountID $toAccount, Money $money)
    {
        if(!$this->money->moreOrEqualThan($money)) {
            throw new DomainException("Not enough money to make a transfer.");
        }

        if(!$this->isActive()) {
            throw new DomainException("Can't transfer money out when account is not activated.");
        }

        $this->money = $this->money->subtract($money);

        $this->transfers = clone $this->transfers;
        $this->transfers->add($transferFactory->create(TransferType::SENT, $toAccount, $money));

        $dateTime = new \DateTime();
        $this->uncommitedEvents[] = new MoneyTransferredEvent($this->accountID->ID(), $toAccount->ID(), $money->amount(), $dateTime->format('Y-m-d H:i:s'));
    }

    /**
     * It credit account
     *
     * @param TransferFactory $transferFactory
     * @param AccountID       $fromAccount
     * @param Money           $money
     */
    public function credit(TransferFactory $transferFactory, AccountID $fromAccount, Money $money)
    {
        $this->money = $this->money->add($money);

        //doctrine tracking policy checks if object === object. Since it's object it always sees it as unchanged
        //http://stackoverflow.com/questions/11084209/how-to-force-doctrine-to-update-array-type-fields
        $this->transfers = clone $this->transfers;
        $this->transfers->add($transferFactory->create(TransferType::RECEIVED, $fromAccount, $money));
    }

    /**
     * Activates account
     */
    public function activate()
    {
        $this->active = true;
    }

    /**
     * Deactivates account
     */
    public function deactivate()
    {
        $this->active = false;
    }

    /**
     * Return aggregate version
     *
     * @return int
     */
    public function version()
    {
        return $this->version;
    }

    /**
     * Is account active
     *
     * @return bool
     */
    private function isActive()
    {
        return $this->active;
    }

    /**
     * @return array|DomainEvent[]
     */
    public function getUncommittedEvents()
    {
        $events = $this->uncommitedEvents;
        $this->uncommitedEvents = [];

        return $events;
    }

}
