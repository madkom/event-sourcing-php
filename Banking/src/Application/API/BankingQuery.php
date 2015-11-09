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
     * @return array
     */
    public function getAccountByClientID($clientID);

    /**
     * Returns account's history
     *
     * @param $accountID
     *
     * @return array
     */
    public function getHistory($accountID);

    /**
     * Returns account's history by client id
     *
     * @param $clientID
     *
     * @return array
     */
    public function getHistoryByClientID($clientID);

}