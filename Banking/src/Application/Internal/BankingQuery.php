<?php

namespace Madkom\ES\Banking\Application\Internal;

use Madkom\ES\Banking\Application\Helper\BankingQueryRepository;

/**
 * Class BankingQuery
 * @package Madkom\ES\Banking\Application\Internal
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class BankingQuery implements \Madkom\ES\Banking\Application\API\BankingQuery
{

    /**
     * @var BankingQueryRepository
     */
    private $bankingQueryRepository;

    /**
     * @param BankingQueryRepository $bankingQueryRepository
     */
    public function __construct(BankingQueryRepository $bankingQueryRepository)
    {
        $this->bankingQueryRepository = $bankingQueryRepository;
    }

    /**
     * @inheritDoc
     */
    public function getAccount($accountID)
    {
        return $this->bankingQueryRepository->getById($accountID);
    }

    /**
     * @inheritDoc
     */
    public function getAccountByClientID($clientID)
    {
        return $this->bankingQueryRepository->getByClientID($clientID);
    }

    /**
     * @inheritDoc
     */
    public function getHistory($accountID)
    {
        return $this->bankingQueryRepository->getHistory($accountID);
    }

    /**
     * @inheritDoc
     */
    public function getHistoryByClientID($clientID)
    {
        return $this->bankingQueryRepository->getHistoryByClientID($clientID);
    }

}