<?php

namespace Madkom\ES\Banking\Application\Internal;

use Madkom\ES\Banking\Domain\Account\AccountFactory;
use Madkom\ES\Banking\Domain\Account\AccountID;
use Madkom\ES\Banking\Domain\Account\AccountRepository;
use Madkom\ES\Banking\Domain\Account\ClientID;
use Madkom\ES\Banking\Domain\Account\TransferFactory;
use Madkom\ES\Banking\Domain\DomainEventPublisher;
use Madkom\ES\Banking\Domain\Infrastructure\AggregateIdentityGenerator;
use Madkom\ES\Banking\Domain\Money;

/**
 * Class Banking
 * @package Madkom\ES\Banking\Application\Internal
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Banking implements \Madkom\ES\Banking\Application\API\Banking
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;
    /**
     * @var AccountFactory
     */
    private $accountFactory;
    /**
     * @var TransferFactory
     */
    private $transferFactory;
    /**
     * @var DomainEventPublisher
     */
    private $domainEventPublisher;

    /**
     * @param AccountRepository    $accountRepository
     * @param DomainEventPublisher $domainEventPublisher
     * @param AccountFactory       $accountFactory
     * @param TransferFactory      $transferFactory
     */
    public function __construct(AccountRepository $accountRepository, DomainEventPublisher $domainEventPublisher, AccountFactory $accountFactory, TransferFactory $transferFactory)
    {
        $this->accountRepository = $accountRepository;
        $this->accountFactory = $accountFactory;
        $this->transferFactory = $transferFactory;
        $this->domainEventPublisher = $domainEventPublisher;
    }

    /**
     * Creates account
     *
     * @param string $clientID
     *
     * @return void
     */
    public function createAccount($clientID)
    {
        $account = $this->accountFactory->create(new AccountID(AggregateIdentityGenerator::generateID()), new ClientID($clientID));

        $this->accountRepository->save($account);
    }

    /**
     * Activates account
     *
     * @param string $accountID
     *
     * @return void
     */
    public function activateAccount($accountID)
    {
        $account = $this->accountRepository->getByID(new AccountID($accountID));
        $account->activate();

        $this->accountRepository->save($account);
    }

    /**
     * Deactivates account
     *
     * @param string $accountID
     *
     * @return void
     */
    public function deactivateAccount($accountID)
    {
        $account = $this->accountRepository->getByID(new AccountID($accountID));
        $account->deactivate();

        $this->accountRepository->save($account);
    }

    /**
     * Transfer money out to chosen account
     *
     * @param string $fromAccount
     * @param string $toAccount
     * @param int    $money
     *
     * @return void
     */
    public function transferOut($fromAccount, $toAccount, $money)
    {
        $account = $this->accountRepository->getByID(new AccountID($fromAccount));

        $account->debit($this->transferFactory, new AccountID($toAccount), new Money($money));

        $this->accountRepository->save($account);

        foreach($account->getUncommittedEvents() as $event) {
            $this->domainEventPublisher->publish($event);
        }
    }

    /**
     * Transfer money in to chosen account
     *
     * @param $fromAccount
     * @param $toAccount
     * @param $money
     *
     * @return void
     */
    public function transferIn($fromAccount, $toAccount, $money)
    {
        $account = $this->accountRepository->getByID(new AccountID($toAccount));

        $account->credit($this->transferFactory, new AccountID($fromAccount), new Money($money));

        $this->accountRepository->save($account);
    }

}