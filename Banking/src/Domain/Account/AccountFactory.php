<?php

namespace Madkom\ES\Banking\Domain\Account;

use Madkom\ES\Banking\Domain\Money;

/**
 * Class AccountFactory
 * @package Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class AccountFactory
{

    /**
     * Creates new account
     *
     * @param AccountID $accountID
     * @param ClientID  $clientID
     *
     * @return Account
     */
    public function create(AccountID $accountID, ClientID $clientID)
    {
        return new Account($accountID, $clientID, new Money(100), true);
    }

}
