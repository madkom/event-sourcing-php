<?php

namespace Madkom\ES\Banking\UI\Worker\External;

use Madkom\EventStore\Client\Application\Api\EventStore;
use Madkom\EventStore\Client\Domain\Socket\Data\StreamEventAppeared;
use Madkom\EventStore\Client\Domain\Socket\Data\SubscribeToStream;
use Madkom\EventStore\Client\Domain\Socket\Message\Credentials;
use Madkom\EventStore\Client\Domain\Socket\Message\MessageType;
use Madkom\EventStore\Client\Domain\Socket\Message\SocketMessage;
use Madkom\EventStore\Client\Infrastructure\InMemoryLogger;
use Madkom\EventStore\Client\Infrastructure\ReactStream;
use React\EventLoop\Factory;
use React\SocketClient\Connector;
use React\Stream\Stream;

/**
 * Class SynchronizeEvents
 * @package Madkom\ES\Banking\Command
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class SynchronizeEvents
{

    /**
     * Runs synchronization with eventstore
     */
    public function run()
    {
        preg_match('#nameserver ([^\s]*)$#',file_get_contents('/etc/resolv.conf'), $matches);

        if(!array_key_exists(1, $matches)) {
            throw new \Exception("Can't find DNS server");
        }
        $dnsServerIP = $matches[1];

        $loop = Factory::create();
        $dnsResolverFactory = new \React\Dns\Resolver\Factory();
        $dns  = $dnsResolverFactory->create($dnsServerIP, $loop);
        $dns->resolve('eventstore')->then(function($ip) use ($loop, $dns){

            $connector = new Connector($loop, $dns);
            $resolvedConnection = $connector->create($ip, 1113);

            $resolvedConnection->then(function(Stream $stream){
                $eventStore = new EventStore(new ReactStream($stream), new InMemoryLogger());

                $eventStore->addAction(MessageType::STREAM_EVENT_APPEARED, function(SocketMessage $message){
                    /** @var StreamEventAppeared $streamEventAppeared */
                    $streamEventAppeared = $message->getData();
                    $eventRecord = $streamEventAppeared->getEvent()->getEvent();

                    if(!($eventRecord->getEventStreamId() === '$stats-0.0.0.0:2113')) {

                        /**
                         * array(6) {
                        ["uuid"]=>
                        string(36) "03fe6ee4-73d2-11e5-ac20-c6e3e99b27b4"
                        ["playhead"]=>
                        int(35)
                        ["metadata"]=>
                        array(0) {
                        }
                        ["payload"]=>
                        array(2) {
                        ["name"]=>
                        string(4) "test"
                        ["surname"]=>
                        string(6) "dasdas"
                        }
                        ["recorded_on"]=>
                        string(32) "2015-10-19T13:02:24.536870+00:00"
                        ["type"]=>
                        string(49) "Dgafka.ES.Client.Domain.User.UserChangedDataEvent"
                        }

                         */
                        $data = json_decode($eventRecord->getData(), true);
                        $aggregateID = $data['uuid'];

                        $diContainer = \Madkom\ES\Banking\UI\Bundle\App\DependencyContainer::getInstance();
                        /** @var \Madkom\ES\Banking\Application\API\Banking $bankingAPI */
                        $bankingAPI = $diContainer->get('banking.api');

                        if($data['type'] == 'Dgafka.ES.Client.Domain.User.UserRegisteredEvent') {
                            $bankingAPI->createAccount($aggregateID);
                        }

//                        die('>>>' . $data['type']);
//                        var_dump($data, $data['type']);


//                        $bankingAPI->createAccount($aggregateID);

                    }
                });

                $eventStore->run();

                $socketData = new SubscribeToStream();
                $socketData->setResolveLinkTos(false);
                $socketData->setEventStreamId('');

                $eventStore->sendMessage(new SocketMessage(
                    new MessageType(MessageType::SUBSCRIBE_TO_STREAM),
                    null,
                    $socketData,
                    new Credentials('admin', 'changeit')
                ));

            });

        });

        $loop->run();
    }

}

require('../../../../vendor/autoload.php');
$tmp = new \Madkom\ES\Banking\UI\Worker\External\SynchronizeEvents();
$tmp->run();