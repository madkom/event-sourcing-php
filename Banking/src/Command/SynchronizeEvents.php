<?php

namespace Madkom\ES\Banking\Command;

use Madkom\EventStore\Client\Application\Api\EventStore;
use Madkom\EventStore\Client\Infrastructure\InMemoryLogger;
use Madkom\EventStore\Client\Infrastructure\ReactStream;
use React\EventLoop\Factory;
use React\SocketClient\Connector;

/**
 * Class SynchronizeEvents
 * @package Madkom\ES\Banking\Command
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class SynchronizeEvents
{

    public function __construct()
    {

    }

    public function run()
    {
        $loop = Factory::create();
        $dnsResolverFactory = new \React\Dns\Resolver\Factory();
        $dns  = $dnsResolverFactory->create(null, $loop);

        $connector = new Connector($loop, $dns);
//        $connector->create()
    }

}