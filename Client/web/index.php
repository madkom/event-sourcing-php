<?php

require('../vendor/autoload.php');

use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;

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
        $dispatcher->setDefaultNamespace("Dgafka\\ES\\Client\\UI\\Rest\\Controller");
        return $dispatcher;
    });

    $di->set('router', function(){

        $router = new \Phalcon\Mvc\Router();
        $router->add(
            '/about',
            [
                'namespace'  => 'Dgafka\\ES\\Client\\UI\\Rest\\Controller',
                'controller' => 'index',
                'action'     => 'test'
            ]
        );

        return $router;
    });

    // Handle the request
    $application = new Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}