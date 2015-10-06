<?php

require('../vendor/autoload.php');

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Dgafka\ES\Client\Infrastructure\EventStoreInMemory;
use Dgafka\ES\Client\Infrastructure\UserFactory;
use Dgafka\ES\Client\Infrastructure\UserRepositoryEventSourced;
use Dgafka\ES\Client\Infrastructure\UUIDGenerator;
use \Dgafka\ES\Client\Application\Internal\Client;

try {
    // Create a DI
    $di = new FactoryDefault();

    $di->setShared('clientAPI', function(){
        return new Client(new UUIDGenerator(), new UserRepositoryEventSourced(
            new \Dgafka\ES\Client\Infrastructure\EventStoreAtom(),
            'Dgafka\ES\Client\Domain\User\User',
            new UserFactory()
        ));
    });

    // Setup the view component
    $di->set('view', function () {
        $view = new View();
        return $view;
    });

    $di->set('dispatcher', function(){
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setDefaultNamespace("Dgafka\\ES\\Client\\UI\\Rest\\Controller");
        return $dispatcher;
    });

    $di->set('router', function(){

        $router = new \Phalcon\Mvc\Router();
        $router->add(
            '/register',
            [
                'controller' => 'client',
                'action'     => 'register'
            ], ['POST']
        );
        $router->add(
            '/changedata',
            [
                'controller' => 'client',
                'action'     => 'changeData'
            ], ['PUT']
        );
        $router->add(
            '/changestatus',
            [
                'controller' => 'client',
                'action'     => 'changeStatus'
            ], ['PUT']
        );
        $router->add(
            '/makevip',
            [
                'controller' => 'client',
                'action'     => 'makeVIP'
            ], ['PUT']
        );

        return $router;
    });

    // Handle the request
    $application = new Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}