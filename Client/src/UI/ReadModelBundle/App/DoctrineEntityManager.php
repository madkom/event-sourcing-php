<?php

namespace Dgafka\ES\Client\UI\ReadModelBundle\App;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Class DoctrineEntityManager
 * @package Madkom\ES\Banking\UI\Bundle\App
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
final class DoctrineEntityManager
{

    /** @var  EntityManager */
    private static $instance;

    /**
     * Singleton
     */
    private function __construct()
    {

    }

    /**
     * Returns Doctrine Entity Manager
     *
     * @return EntityManager
     */
    public static function getInstance()
    {
        if(!isset(self::$instance)) {
            self::$instance = self::getEntityManager();
        }

        return self::$instance;
    }

    /**
     * Returns new instance of entity manager
     *
     * @return EntityManager
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     */
    private static function getEntityManager()
    {
        $paths = array(__DIR__ . '/../Resources/config/doctrine');
        $isDevMode = true;

        $dbParams = array(
            'host'      => 'readdb',
            'driver'    => 'pdo_pgsql',
            'user'      => 'postgres',
            'password'  => 'mypassword',
            'dbname'    => 'postgres'
        );

        $config = Setup::createXMLMetadataConfiguration($paths, $isDevMode);

        $entityManager    = EntityManager::create($dbParams, $config);

        return $entityManager;
    }

}