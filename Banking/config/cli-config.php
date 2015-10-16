<?php

$paths = array('../src/UI/Bundle/Configuration/Doctrine');
$isDevMode = true;

$dbParams = array(
    'host'      => 'database',
    'driver'    => 'pdo_pgsql',
    'user'      => 'postgres',
    'password'  => 'mypassword',
    'dbname'    => 'postgres'
);

$config = \Doctrine\ORM\Tools\Setup::createXMLMetadataConfiguration($paths, $isDevMode);
$config->addCustomStringFunction('JSONB_AG', 'Boldtrn\JsonbBundle\Query\JsonbAtGreater');
$config->addCustomStringFunction('JSONB_HGG', 'Boldtrn\JsonbBundle\Query\JsonbHashGreaterGreater');
$config->addCustomStringFunction('JSONB_EX', 'Boldtrn\JsonbBundle\Query\JsonbExistence');
\Doctrine\DBAL\Types\Type::addType('jsonb', '\Boldtrn\JsonbBundle\Types\JsonbArrayType');

$entityManager    = \Doctrine\ORM\EntityManager::create($dbParams, $config);
$connection       = $entityManager->getConnection();
$databasePlatform = $connection->getDatabasePlatform();
$databasePlatform->registerDoctrineTypeMapping('jsonb', 'jsonb');

// Any way to access the EntityManager from  your application
$em = $entityManager;

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));