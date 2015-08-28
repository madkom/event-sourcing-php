<?php

namespace spec\Dgafka\ES\Client\Domain\User;

use Broadway\Domain\DomainMessage;
use Dgafka\ES\Client\Domain\User\User;
use Dgafka\ES\Client\Domain\User\UserData;
use Dgafka\ES\Client\Domain\User\UserID;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class UserSpec
 *
 * @package spec\Dgafka\ES\Client\Domain\User
 * @mixin User
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class UserSpec extends ObjectBehavior
{

    /** @var  self */
    private $instance;

    function let(UserID $userID, UserData $userData)
    {

        $userID->ID()->willReturn('2');
        $userData->name()->willReturn('Alfred');
        $userData->surname()->willReturn('Makulma');

        $this->instance = self::register($userID, $userData);
        $this->instance->shouldHaveType('Dgafka\ES\Client\Domain\User\User');

        $this->instance->getAggregateRootId()->shouldHaveType('Dgafka\ES\Client\Domain\User\UserID');
        $this->instance->getAggregateRootId()->ID()->shouldReturn('2');

        $domainIterator = $this->instance->getUncommittedEvents()->getIterator();
        /** @var DomainMessage $domainMessage */
        $domainMessage = $domainIterator->offsetGet(0);
        $domainMessage->getPayload()->shouldHaveType('Dgafka\ES\Client\Domain\User\UserRegisteredEvent');
        $domainMessage->getPayload()->name()->shouldReturn('Alfred');
        $domainMessage->getPayload()->surname()->shouldReturn('Makulma');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Dgafka\ES\Client\Domain\User\User');
    }

    function it_should_change_user_data(UserData $userData)
    {
        $userData->name()->willReturn('Alfred');
        $userData->surname()->willReturn('Mad');

        $this->instance->changeUserData($userData);

        $domainIterator = $this->instance->getUncommittedEvents()->getIterator();
        /** @var DomainMessage $domainMessage */
        $domainMessage = $domainIterator->offsetGet(0);
        $domainMessage->getPayload()->shouldHaveType('Dgafka\ES\Client\Domain\User\UserChangedDataEvent');
        $domainMessage->getPayload()->name()->shouldReturn('Alfred');
        $domainMessage->getPayload()->surname()->shouldReturn('Mad');
    }

}
