<?php
require(__DIR__ . '/../vendor/autoload.php');

use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Dgafka\ES\Client\Infrastructure\EventStoreInMemory;
use Dgafka\ES\Client\Infrastructure\UserFactory;
use Dgafka\ES\Client\Infrastructure\UserRepositoryEventSourced;
use Dgafka\ES\Client\Infrastructure\UUIDGenerator;
use \Dgafka\ES\Client\Application\Internal\Client;

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


//$entityManager = \Madkom\ES\Banking\UI\Bundle\App\DoctrineEntityManager::getInstance();
//
////$accountFactory = new \Madkom\ES\Banking\Domain\Account\AccountFactory();
////$account = $accountFactory->create(new \Madkom\ES\Banking\Domain\Account\AccountID('dsad'), new \Madkom\ES\Banking\Domain\Account\ClientID('2'));
////$entityManager->persist($account);
////$entityManager->flush();
////
//
////
//$accountRepository = new \Madkom\ES\Banking\Infrastructure\Domain\AccountRepository();
//$diContainer = \Madkom\ES\Banking\UI\Bundle\App\DependencyContainer::getInstance();
//
///** @var \Madkom\ES\Banking\Application\API\Banking $bankingAPI */
//$bankingAPI = $diContainer->get('banking.api');
//
////$bankingAPI->activateAccount('2');
//
//
////$accountFactory = new \Madkom\ES\Banking\Domain\Account\AccountFactory();
////$account = $accountFactory->create(new \Madkom\ES\Banking\Domain\Account\AccountID(13), new \Madkom\ES\Banking\Domain\Account\ClientID('5'));
////$account->credit(new \Madkom\ES\Banking\Domain\Account\TransferFactory(), new \Madkom\ES\Banking\Domain\Account\AccountID('3'), new \Madkom\ES\Banking\Domain\Money(200));
////
////$accountRepository->save($account);
//
//$account = $accountRepository->getByID(new \Madkom\ES\Banking\Domain\Account\AccountID('13'));
//
//$account->credit(new \Madkom\ES\Banking\Domain\Account\TransferFactory(), new \Madkom\ES\Banking\Domain\Account\AccountID('3'), new \Madkom\ES\Banking\Domain\Money(200));
//
//$accountRepository->save($account);
//


try {
    // Create a DI
    $di = new FactoryDefault();

    // Setup the view component
    $di->set('view', function () {
        $view = new View();
        return $view;
    });

    $di->set('dispatcher', function(){
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setDefaultNamespace("Madkom\\ES\\Banking\\UI\\Rest\\Controller");
        return $dispatcher;
    });

    $di->set('router', function(){

        $router = new \Phalcon\Mvc\Router();
        $router->add(
            '/transferout',
            [
                'controller' => 'banking',
                'action'     => 'transferOut'
            ], ['POST']
        );

        return $router;
    });

    // Handle the request
    $application = new Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}