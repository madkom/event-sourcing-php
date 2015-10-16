<?php
require('../vendor/autoload.php');

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array('../src/UI/Bundle/Configuration/Doctrine');
$isDevMode = true;

$dbParams = array(
    'driver'    => 'pdo_pgsql',
    'user'      => 'postgres',
    'password'  => 'mypassword',
    'dbname'    => 'banking'
);

$config = Setup::createXMLMetadataConfiguration($paths, $isDevMode);
$config->addCustomStringFunction('JSONB_AG', 'Boldtrn\JsonbBundle\Query\JsonbAtGreater');
$config->addCustomStringFunction('JSONB_HGG', 'Boldtrn\JsonbBundle\Query\JsonbHashGreaterGreater');
$config->addCustomStringFunction('JSONB_EX', 'Boldtrn\JsonbBundle\Query\JsonbExistence');

$entityManager = EntityManager::create($dbParams, $config);
$connection       = $entityManager->getConnection();
$databasePlatform = $connection->getDatabasePlatform();
$databasePlatform->registerDoctrineTypeMapping('jsonb', 'Boldtrn\JsonbBundle\Types\JsonbArrayType');

$tmp = new \Madkom\ES\Banking\UI\Worker\External\SynchronizeEvents();
$tmp->run();