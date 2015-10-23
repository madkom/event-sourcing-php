<?php

namespace Madkom\ES\Banking\Domain\Account;

use Madkom\ES\Banking\Domain\DomainEvent;

/**
 * Class MoneyTransferredEvent
 * @package Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class MoneyTransferredEvent implements DomainEvent
{

    /** @var string  */
    private $fromAccountID;

    /** @var string  */
    private $toAccountID;

    /** @var string  */
    private $moneyAmount;

    /** @var string  */
    private $dateTime;

    /**
     * @param string $fromAccountID
     * @param string $toAccountID
     * @param int    $moneyAmount
     * @param string $dateTime
     */
    public function __construct($fromAccountID, $toAccountID, $moneyAmount, $dateTime)
    {
        $this->fromAccountID = $fromAccountID;
        $this->toAccountID   = $toAccountID;
        $this->moneyAmount   = $moneyAmount;
        $this->dateTime      = $dateTime;
    }

}
