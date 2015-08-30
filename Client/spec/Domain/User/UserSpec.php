<?php

namespace spec\Dgafka\ES\Client\Domain\User;

use Broadway\Domain\DomainMessage;
use Dgafka\ES\Client\Domain\User\User;
use Dgafka\ES\Client\Domain\User\UserData;
use Dgafka\ES\Client\Domain\User\UserID;
use Dgafka\ES\Client\Domain\User\UserStatus;
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

    function it_should_change_user_status()
    {
        $this->instance->changeStatus(UserStatus::ACTIVE);

        $domainIterator = $this->instance->getUncommittedEvents()->getIterator();
        /** @var DomainMessage $domainMessage */
        $domainMessage = $domainIterator->offsetGet(0);
        $domainMessage->getPayload()->shouldHaveType('Dgafka\ES\Client\Domain\User\UserChangedStatusEvent');
        $domainMessage->getPayload()->status()->shouldReturn(UserStatus::ACTIVE);
    }

    function it_should_throw_exception_if_user_changes_data_while_status_in_not_active(UserData $userData)
    {
        $this->instance->changeStatus(UserStatus::BLOCKED);
        $this->instance->shouldThrow('Dgafka\ES\Client\SharedKernel\Domain\DomainException')->during('changeUserData', [$userData]);
    }

    function it_should_change_user_to_vip()
    {
        $this->instance->becomeVIP();

        $domainIterator = $this->instance->getUncommittedEvents()->getIterator();
        /** @var DomainMessage $domainMessage */
        $domainMessage = $domainIterator->offsetGet(0);
        $domainMessage->getPayload()->shouldHaveType('Dgafka\ES\Client\Domain\User\UserBecameVIPEvent');
        $domainMessage->getPayload()->ID()->shouldReturn('2');
    }

    function it_should_dissallow_user_become_VIP_if_blocked()
    {
        $this->instance->changeStatus(UserStatus::BLOCKED);
        $this->instance->shouldThrow('\Dgafka\ES\Client\SharedKernel\Domain\DomainException')->during('becomeVIP');
    }

}
