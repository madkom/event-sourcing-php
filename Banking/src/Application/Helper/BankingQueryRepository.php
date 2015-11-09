<?php

namespace Madkom\ES\Banking\Application\Helper;

/**
 * Class BankingQueryRepository
 * @package Madkom\ES\Banking\Application\Helper
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
interface BankingQueryRepository
{

    /**
     * Return account by id
     *
     * @param $ID
     *
     * @return array
     */
    public function getById($ID);

    /**
     * Return account by client id
     *
     * @param $clientID
     *
     * @return array
     */
    public function getByClientID($clientID);

    /**
     * Return account history
     *
     * @param $ID
     *
     * @return array
     */
    public function getHistory($ID);

    /**
     * Returns account by client id
     *
     * @param $clientID
     *
     * @return array
     */
    public function getHistoryByClientID($clientID);

}