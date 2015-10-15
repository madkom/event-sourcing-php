<?php

namespace Madkom\ES\Banking\Application\API;

/**
 * Class Banking - Provides clean interface to other companies
 * @package Madkom\ES\Banking\Application\API
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
interface Banking
{

    /**
     * Creates account
     *
     * @param string $clientID
     *
     * @return void
     */
    public function createAccount($clientID);

    /**
     * Activates account
     *
     * @param string $accountID
     *
     * @return void
     */
    public function activateAccount($accountID);

    /**
     * Deactivates account
     *
     * @param string $accountID
     *
     * @return void
     */
    public function deactivateAccount($accountID);

    /**
     * Transfer money out to chosen account
     *
     * @param string $fromAccount
     * @param string $toAccount
     * @param int    $money
     *
     * @return void
     */
    public function transferOut($fromAccount, $toAccount, $money);

    /**
     * Transfer money in to chosen account
     *
     * @param $fromAccount
     * @param $toAccount
     * @param $money
     *
     * @return void
     */
    public function transferIn($fromAccount, $toAccount, $money);

}