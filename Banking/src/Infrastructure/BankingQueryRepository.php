<?php

namespace Madkom\ES\Banking\Infrastructure;

use Doctrine\ORM\EntityManager;
use Madkom\ES\Banking\UI\Bundle\App\DoctrineEntityManager;

/**
 * Class BankingQueryRepository
 * @package Madkom\ES\Banking\Infrastructure
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class BankingQueryRepository implements \Madkom\ES\Banking\Application\Helper\BankingQueryRepository
{

    /** @var  EntityManager */
    private $doctrineEntityManager;

    public function __construct()
    {
        $this->doctrineEntityManager = DoctrineEntityManager::getInstance();
    }

    /**
     * @inheritDoc
     */
    public function getById($ID)
    {
        $connection = $this->doctrineEntityManager->getConnection();

        $pstmt = $connection->prepare("SELECT accountid_id, clientid_id, money_amount, active FROM account WHERE accountid_id = :accountID");
        $pstmt->execute([':accountID' => $ID]);

        return $pstmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @inheritDoc
     */
    public function getByClientID($clientID)
    {
        $connection = $this->doctrineEntityManager->getConnection();

        $pstmt = $connection->prepare("SELECT accountid_id, clientid_id, money_amount, active FROM account WHERE clientid_id = :clientID");
        $pstmt->execute([':clientID' => $clientID]);

        return $pstmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @inheritDoc
     */
    public function getHistory($ID)
    {
        $connection = $this->doctrineEntityManager->getConnection();

        $pstmt = $connection->prepare("SELECT transfers FROM account WHERE accountid_id = :accountID");
        $pstmt->execute([':accountID' => $ID]);

        return $pstmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @inheritDoc
     */
    public function getHistoryByClientID($clientID)
    {
        $connection = $this->doctrineEntityManager->getConnection();

        $pstmt = $connection->prepare("SELECT transfers FROM account WHERE clientid_id = :clientID");
        $pstmt->execute([':clientID' => $clientID]);

        return $pstmt->fetch(\PDO::FETCH_ASSOC);
    }


}