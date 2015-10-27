<?php

namespace Madkom\ES\Banking\Application\API;

/**
 * Interface BankingQuery
 * @package Madkom\ES\Banking\Application\API
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
interface BankingQuery
{

    /**
     * Returns account information
     *
     * @param string $accountID
     *
     * @return array
     */
    public function getAccount($accountID);

    /**
     * Returns account information by client id
     *
     * @param $clientID
     *
     * @return mixed
     */
    public function getAccountByClientID($clientID);

    /**
     * @param $accountID
     *
     * @return mixed
     */
    public function getHistory($accountID);


}