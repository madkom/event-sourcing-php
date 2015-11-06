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

//Turn off on production
header('Access-Control-Allow-Origin: *');

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
            '/banking/transferout',
            [
                'controller' => 'banking',
                'action'     => 'transferOut'
            ], ['POST']
        );

        $router->add(
            '/banking/accountbyid',
            [
                'controller' => 'banking-query',
                'action'     => 'getAccountByID'
            ], ['GET']
        );

        $router->add(
            '/banking/accountbyclientid',
            [
                'controller' => 'banking-query',
                'action'     => 'getAccountByClientID'
            ], ['GET']
        );

        $router->add(
            '/banking/transfers',
            [
                'controller' => 'banking-query',
                'action'     => 'getTransfers'
            ], ['GET']
        );

        return $router;
    });

    // Handle the request
    $application = new Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}