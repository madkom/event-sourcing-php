<?php

namespace Dgafka\ES\Client\Infrastructure;

use Dgafka\ES\Client\Application\API\ClientQuery;
use Dgafka\ES\Client\UI\ReadModelBundle\App\DoctrineEntityManager;

/**
 * Class ClientQueryService
 * @package Dgafka\ES\Client\Infrastructure
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class ClientQueryRepository implements \Dgafka\ES\Client\Application\Service\ClientQueryRepository
{

    /** @var \Doctrine\ORM\EntityManager  */
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = DoctrineEntityManager::getInstance();
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        $connection = $this->entityManager->getConnection();
        $pstmt = $connection->executeQuery("SELECT * FROM client");

        $pstmt->execute();

        $result = $pstmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;

    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        $connection = $this->entityManager->getConnection();
        $pstmt = $connection->prepare("SELECT * FROM client WHERE userid_id = :id;");
        $pstmt->execute([':id' => $id]);

        $result = $pstmt->fetch(\PDO::FETCH_ASSOC);

        return $result;

    }

}