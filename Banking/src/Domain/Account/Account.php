<?php

namespace Madkom\ES\Banking\Domain\Account;

use Madkom\ES\Banking\Domain\DomainException;
use Madkom\ES\Banking\Domain\Money;

/**
 * Class Account
 * @package Madkom\ES\Banking\Application\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Account
{

    /** @var ClientID  */
    private $clientID;

    /** @var Money  */
    private $money;

    /** @var  array|Transfer[] */
    private $transfers;

    /** @var  bool Account status - active not active */
    private $active;

    /**
     * @param ClientID $clientID
     * @param Money    $money
     * @param bool     $active
     */
    public function __construct(ClientID $clientID, Money $money, $active)
    {
        $this->clientID = $clientID;
        $this->money    = $money;
        $this->active = $active;
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
            throw new DomainException("Can't transfer money out when ");
        }

        $this->money = $this->money->subtract($money);
        $this->transfers[] = $transferFactory->create(TransferType::SENT, $toAccount, $money);
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
        $this->transfers[] = $transferFactory->create(TransferType::RECEIVED, $fromAccount, $money);
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
     * Is account active
     *
     * @return bool
     */
    private function isActive()
    {
        return $this->active;
    }

}
