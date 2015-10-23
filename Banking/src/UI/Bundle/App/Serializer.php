<?php

namespace Madkom\ES\Banking\UI\Bundle\App;

use Doctrine\Common\Annotations\AnnotationRegistry;
use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\SerializerBuilder;

/**
 * Class Serializer
 * @package Madkom\ES\Banking\UI\Bundle\App
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Serializer
{

    /** @var \JMS\Serializer\Serializer  */
    private static $instance;

    /**
     * @return \JMS\Serializer\Serializer
     */
    public static function getInstance()
    {

        if(!isset(self::$instance)) {
            self::$instance = self::getSerializer();
        }

        return self::$instance;
    }

    /**
     * @return \JMS\Serializer\Serializer
     */
    private static function getSerializer()
    {
        AnnotationRegistry::registerFile(__DIR__ . '/../../../../vendor/jms/serializer/src/JMS/Serializer/Annotation/ExclusionPolicy.php');
        AnnotationRegistry::registerFile(__DIR__ . '/../../../../vendor/jms/serializer/src/JMS/Serializer/Annotation/Type.php');

        $serializerBuilder = SerializerBuilder::create();
        $serializerBuilder->setCacheDir('/tmp');
        //For production it should be false
        $serializerBuilder->setDebug(true);

        return $serializerBuilder->build();
    }

}