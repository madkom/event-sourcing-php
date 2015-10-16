<?php

namespace Madkom\ES\Banking\Domain\Infrastructure\Domain;

use Madkom\ES\Banking\Domain\Account\Account;
use Madkom\ES\Banking\Domain\Account\AccountID;

/**
 * Class AccountRepository
 * @package Madkom\ES\Banking\Domain\Infrastructure\Domain
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class AccountRepository implements \Madkom\ES\Banking\Domain\Account\AccountRepository
{

    /**
     * @inheritDoc
     */
    public function getByID(AccountID $accountID)
    {
        // TODO: Implement getByID() method.
    }

    /**
     * @inheritDoc
     */
    public function save(Account $account)
    {
        // TODO: Implement save() method.
    }

}