<?php

namespace Madkom\ES\Banking\Domain\Account;

use Madkom\ES\Banking\Domain\Money;

/**
 * Class TransferFactory
 * @package Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class TransferFactory
{

    /**
     * Creates new transfer
     *
     * @param int          $transferType
     * @param AccountID    $collaborator
     * @param Money        $money
     *
     * @return Transfer
     */
    public function create($transferType, AccountID $collaborator, Money $money)
    {
        return new Transfer(new TransferType($transferType), $collaborator,  $money, new \DateTime());
    }

}
