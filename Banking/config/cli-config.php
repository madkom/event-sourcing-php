<?php

$paths = array(__DIR__ . '/../src/UI/Bundle/Configuration/Doctrine');
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

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);