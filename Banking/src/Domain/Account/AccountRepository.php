<?php

namespace Madkom\ES\Banking\Domain\Account;

/**
 * Interface AccountRepository
 * @package Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
interface AccountRepository
{

    /**
     * Retrieves account from data store
     *
     * @param AccountID $accountID
     *
     * @return Account
     */
    public function getByID(AccountID $accountID);

    /**
     * Saves account
     *
     * @param Account $account
     *
     * @return void
     */
    public function save(Account $account);

}
