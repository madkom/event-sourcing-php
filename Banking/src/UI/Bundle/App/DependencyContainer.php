<?php

namespace Madkom\ES\Banking\UI\Bundle\App;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class DependencyContainer
 * @package Madkom\ES\Banking\UI\Bundle\App
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class DependencyContainer
{

    /**
     * @var ContainerBuilder
     */
    private static $diContainer;

    /**
     * Returns symfony container
     *
     * @return ContainerBuilder
     */
    public static function getInstance()
    {

        if(!isset(self::$diContainer)) {
            $containerBuilder = new ContainerBuilder();
            $loader = new XmlFileLoader($containerBuilder, new FileLocator(__DIR__ . '/../Resources/config/dicontainer'));
            $loader->load('services.xml');
            self::$diContainer = $containerBuilder;

            //on Production you would probably cache the container here
        }


        return self::$diContainer;
    }

}