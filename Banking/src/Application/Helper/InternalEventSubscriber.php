<?php

namespace Madkom\ES\Banking\Application\Helper;

use Madkom\ES\Banking\Domain\DomainEvent;
use Madkom\ES\Banking\Domain\DomainEventSubscriber;
use Madkom\ES\Banking\UI\Bundle\App\Serializer;
use Pheanstalk\Pheanstalk;

/**
 * Class InternalEventSubscriber
 * @package Dgafka\ES\Client\Application\Helper
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class InternalEventSubscriber implements DomainEventSubscriber
{

    /**
     * @inheritDoc
     */
    public function handle(DomainEvent $event)
    {

        $serializer = Serializer::getInstance();

        $eventToSend =
            [
                'class' => get_class($event),
                'data'  => $event
            ];

        $serializedData = $serializer->serialize($eventToSend, 'json');


        $pheanstalk = new Pheanstalk('bankingqueue');
        $pheanstalk
            ->useTube('eventtube')
            ->put($serializedData);

    }

}