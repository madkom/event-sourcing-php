<?php
require(__DIR__ . '/../vendor/autoload.php');

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array(__DIR__ . '/../src/UI/Bundle/Configuration/Doctrine');
$isDevMode = true;

$dbParams = array(
    'host'      => 'database',
    'driver'    => 'pdo_pgsql',
    'user'      => 'postgres',
    'password'  => 'mypassword',
    'dbname'    => 'postgres'
);

$config = Setup::createXMLMetadataConfiguration($paths, $isDevMode);
$config->addCustomStringFunction('JSONB_AG', 'Boldtrn\JsonbBundle\Query\JsonbAtGreater');
$config->addCustomStringFunction('JSONB_HGG', 'Boldtrn\JsonbBundle\Query\JsonbHashGreaterGreater');
$config->addCustomStringFunction('JSONB_EX', 'Boldtrn\JsonbBundle\Query\JsonbExistence');
\Doctrine\DBAL\Types\Type::addType('jsonb', '\Boldtrn\JsonbBundle\Types\JsonbArrayType');

$entityManager    = EntityManager::create($dbParams, $config);
$connection       = $entityManager->getConnection();
$databasePlatform = $connection->getDatabasePlatform();
$databasePlatform->registerDoctrineTypeMapping('jsonb', 'jsonb');

$accountFactory = new \Madkom\ES\Banking\Domain\Account\AccountFactory();
$account = $accountFactory->create(new \Madkom\ES\Banking\Domain\Account\AccountID('dsad'), new \Madkom\ES\Banking\Domain\Account\ClientID('2'));
$entityManager->persist($account);
$entityManager->flush();

$tmp = new \Madkom\ES\Banking\UI\Worker\External\SynchronizeEvents();
$tmp->run();