<?php

namespace Madkom\ES\Banking\Domain\Account;

use Madkom\ES\Banking\Domain\Money;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Transfer
 * @package Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @ExclusionPolicy("NONE")
 */
class Transfer
{

    /**
     * @var TransferType
     *
     * @Type("Madkom\ES\Banking\Domain\Account\TransferType")
     */
    private $transferType;
    /**
     * @var AccountID
     *
     * @Type("Madkom\ES\Banking\Domain\Account\AccountID")
     */
    private $collaboratingID;
    /**
     * @var Money
     *
     * @Type("Madkom\ES\Banking\Domain\Money")
     */
    private $money;
    /**
     * @var \DateTime
     *
     * @Type("DateTime")
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
