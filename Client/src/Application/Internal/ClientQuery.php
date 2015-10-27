<?php

namespace Dgafka\ES\Client\Application\Internal;

use Dgafka\ES\Client\Application\Service\ClientQueryRepository;
use Dgafka\ES\Client\Application\Service\ClientQueryService;
use Dgafka\ES\Client\UI\ReadModelBundle\App\DoctrineEntityManager;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Class ClientQuery
 * @package Dgafka\ES\Client\Application\Internal
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class ClientQuery implements \Dgafka\ES\Client\Application\API\ClientQuery
{
    /**
     * @var ClientQueryRepository
     */
    private $clientQueryRepository;

    /**
     * @param ClientQueryRepository $clientQueryRepository
     */
    public function __construct(ClientQueryRepository $clientQueryRepository)
    {
        $this->clientQueryRepository = $clientQueryRepository;
    }


    /**
     * @inheritDoc
     */
    public function getAll()
    {
        return $this->clientQueryRepository->getAll();
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        return $this->clientQueryRepository->getById($id);
    }

}