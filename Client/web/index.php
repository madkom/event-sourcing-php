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
        $view->setContent('works');
        return $view;
    });

    $di->set('url', function () {
        $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    });

    $di->set('dispatcher', function(){
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setDefaultNamespace("Dgafka\\ES\\Client\\UI\\Rest\\Controller");
        return $dispatcher;
    });

    $router = new \Phalcon\Mvc\Router();
    $router->add(
        '/test',
        [
            'controller' => 'IndexController',
            'action'     => 'action'
        ]
    );
    $router->handle();

    // Handle the request
    $application = new Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}