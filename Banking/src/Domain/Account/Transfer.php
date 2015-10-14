<?php

namespace Madkom\ES\Banking\Domain\Account;

use Madkom\ES\Banking\Domain\Account\AccountID;
use Madkom\ES\Banking\Domain\Money;

/**
 * Class Transfer
 * @package Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Transfer
{

    /**
     * @var TransferType
     */
    private $transferType;
    /**
     * @var AccountID
     */
    private $collaboratingID;
    /**
     * @var Money
     */
    private $money;
    /**
     * @var \DateTime
     */
    private $date;


//    @TODO user data as snapshoot, when read model will be finished
    /**
     * @param TransferType $transferType
     * @param AccountID    $collaboratingID
     * @param Money        $money
     * @param \DateTime    $date
     */
    public function __construct(TransferType $transferType, AccountID $collaboratingID, Money $money, \DateTime $date)
    {
        $this->transferType = $transferType;
        $this->collaboratingID = $collaboratingID;
        $this->money = $money;
        $this->date = $date;
    }
}
