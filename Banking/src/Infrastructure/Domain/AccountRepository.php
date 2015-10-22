<?php

namespace Madkom\ES\Banking\Infrastructure\Domain;

use Doctrine\DBAL\LockMode;
use Madkom\ES\Banking\Application\Internal\AggregateNotFoundException;
use Madkom\ES\Banking\Domain\Account\Account;
use Madkom\ES\Banking\Domain\Account\AccountID;
use Madkom\ES\Banking\Domain\Account\ClientID;
use Madkom\ES\Banking\UI\Bundle\App\DoctrineEntityManager;

/**
 * Class AccountRepository
 * @package Madkom\ES\Banking\Domain\Infrastructure\Domain
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class AccountRepository implements \Madkom\ES\Banking\Domain\Account\AccountRepository
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
    public function getByID(AccountID $accountID)
    {
        /** @var Account $account */
        $account = $this->entityManager->getRepository('Madkom\ES\Banking\Domain\Account\Account')->find($accountID->ID());
        if(is_null($account)) {
            throw new AggregateNotFoundException("Not found account with id " . $accountID->ID());
        }

//        $this->entityManager->lock($account, LockMode::OPTIMISTIC, $account->version());
        return $account;
    }

    /**
     * @inheritDoc
     */
    public function getByClientID(ClientID $clientID)
    {
        return $this->entityManager->getRepository('Madkom\ES\Banking\Domain\Account\Account')->findOneBy(array('clientID.ID' => $clientID->ID()));
    }

    /**
     * @inheritDoc
     */
    public function save(Account $account)
    {
//        You may ask what about transactions. You should place them in Application layer. For demo purpose it's here
        try {
            $this->entityManager->beginTransaction();

            $this->entityManager->persist($account);
            $this->entityManager->flush();

            $this->entityManager->commit();
        }catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

}