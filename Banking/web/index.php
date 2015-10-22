<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require(__DIR__ . '/../vendor/autoload.php');

$entityManager = \Madkom\ES\Banking\UI\Bundle\App\DoctrineEntityManager::getInstance();

//$accountFactory = new \Madkom\ES\Banking\Domain\Account\AccountFactory();
//$account = $accountFactory->create(new \Madkom\ES\Banking\Domain\Account\AccountID('dsad'), new \Madkom\ES\Banking\Domain\Account\ClientID('2'));
//$entityManager->persist($account);
//$entityManager->flush();
//

//
$accountRepository = new \Madkom\ES\Banking\Infrastructure\Domain\AccountRepository();
$diContainer = \Madkom\ES\Banking\UI\Bundle\App\DependencyContainer::getInstance();

/** @var \Madkom\ES\Banking\Application\API\Banking $bankingAPI */
$bankingAPI = $diContainer->get('banking.api');

//$bankingAPI->activateAccount('2');


//$accountFactory = new \Madkom\ES\Banking\Domain\Account\AccountFactory();
//$account = $accountFactory->create(new \Madkom\ES\Banking\Domain\Account\AccountID(13), new \Madkom\ES\Banking\Domain\Account\ClientID('5'));
//$account->credit(new \Madkom\ES\Banking\Domain\Account\TransferFactory(), new \Madkom\ES\Banking\Domain\Account\AccountID('3'), new \Madkom\ES\Banking\Domain\Money(200));
//
//$accountRepository->save($account);

$account = $accountRepository->getByID(new \Madkom\ES\Banking\Domain\Account\AccountID('13'));

$account->credit(new \Madkom\ES\Banking\Domain\Account\TransferFactory(), new \Madkom\ES\Banking\Domain\Account\AccountID('3'), new \Madkom\ES\Banking\Domain\Money(200));

$accountRepository->save($account);

