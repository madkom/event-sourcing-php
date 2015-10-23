<?php

namespace Madkom\ES\Banking\Application\Internal;

use Madkom\ES\Banking\Application\Helper\InternalEventSubscriber;
use Madkom\ES\Banking\Domain\Account\AccountFactory;
use Madkom\ES\Banking\Domain\Account\AccountID;
use Madkom\ES\Banking\Domain\Account\AccountRepository;
use Madkom\ES\Banking\Domain\Account\ClientID;
use Madkom\ES\Banking\Domain\Account\TransferFactory;
use Madkom\ES\Banking\Domain\DomainEventPublisher;
use Madkom\ES\Banking\Infrastructure\AggregateIdentityGenerator;
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
//        In most cases you would probably want to inject DIContainer here and retrieve necessary objects. It will be more lightweight
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
        $clientID = new ClientID($clientID);

        if($this->accountRepository->getByClientID($clientID)) {
            throw new \InvalidArgumentException("Can't create two accounts for {$clientID}");
        }

        $account = $this->accountFactory->create(new AccountID(AggregateIdentityGenerator::generateID()), $clientID);

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

        //For internal events.
        $this->domainEventPublisher->subscribe(new InternalEventSubscriber(), 'Madkom\ES\Banking\Domain\Account\MoneyTransferredEvent');
        foreach($account->getUncommittedEvents() as $event) {
            $this->domainEventPublisher->publish($event);
        }

    }

}