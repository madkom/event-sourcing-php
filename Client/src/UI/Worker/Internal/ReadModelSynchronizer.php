<?php

namespace Dgafka\ES\Client\UI\Worker\Internal;

require(__DIR__ . '/../../../../vendor/autoload.php');

use Dgafka\ES\Client\Domain\User\User;
use Dgafka\ES\Client\Domain\User\UserData;
use Dgafka\ES\Client\Domain\User\UserID;
use Dgafka\ES\Client\Domain\User\UserStatus;
use Dgafka\ES\Client\UI\ReadModelBundle\App\DoctrineEntityManager;
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
 * Class ReadModelSynchronizer
 * @package Dgafka\ES\Client\UI\Worker\Internal
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class ReadModelSynchronizer
{

    /** @var \Doctrine\ORM\EntityManager  */
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = DoctrineEntityManager::getInstance();
    }

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

                        $data = json_decode($eventRecord->getData(), true);
                        $aggregateID = $data['uuid'];

                        $user = $this->entityManager->getRepository('Dgafka\ES\Client\Domain\User\User')->find($aggregateID);


                        //You would probably want to use strategy pattern here
                        if ($data['type'] == 'Dgafka.ES.Client.Domain.User.UserRegisteredEvent') {
                            $user = new User();

                            $rflClass = new \ReflectionClass($user);
                            $userIDProp = $rflClass->getProperty('userID');
                            $userDataProp = $rflClass->getProperty('userData');

                            $userIDProp->setAccessible(true);
                            $userDataProp->setAccessible(true);

                            $userIDProp->setValue($user, new UserID($aggregateID));
                            $userDataProp->setValue($user, new UserData($data['payload']['name'], $data['payload']['surname']));

                        }elseif  ($user && $data['type'] == 'Dgafka.ES.Client.Domain.User.UserChangedStatusEvent'){

                            $rflClass = new \ReflectionClass($user);
                            $statusProp = $rflClass->getProperty('status');

                            $statusProp->setAccessible(true);

                            $statusProp->setValue($user, new UserStatus($data['payload']['status']));

                        }elseif  ($user && $data['type'] == 'Dgafka.ES.Client.Domain.User.UserChangedDataEvent'){

                            $rflClass = new \ReflectionClass($user);
                            $userDataProp = $rflClass->getProperty('userData');

                            $userDataProp->setAccessible(true);

                            $userDataProp->setValue($user, new UserData($data['payload']['name'], $data['payload']['surname']));

                        }elseif  ($user && $data['type'] == 'Dgafka.ES.Client.Domain.User.UserBecameVIPEvent'){

                            $rflClass = new \ReflectionClass($user);
                            $vipStatusProp = $rflClass->getProperty('vipStatus');

                            $vipStatusProp->setAccessible(true);

                            $vipStatusProp->setValue($user, true);

                        }

                        if($user) {
                            $this->entityManager->persist($user);
                            $this->entityManager->flush();
                        }
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

$worker = new ReadModelSynchronizer();
$worker->run();