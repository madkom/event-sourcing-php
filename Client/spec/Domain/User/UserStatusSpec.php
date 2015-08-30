<?php

namespace spec\Dgafka\ES\Client\Domain\User;

use Dgafka\ES\Client\Domain\User\UserStatus;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class UserStatusSpec
 *
 * @package spec\Dgafka\ES\Client\Domain\User
 * @mixin UserStatus
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class UserStatusSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith(UserStatus::ACTIVE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Dgafka\ES\Client\Domain\User\UserStatus');
    }

    function it_should_check_if_user_is_active()
    {
        $this->isActive()->shouldReturn(true);
    }

    function it_should_return_false_if_user_is_inactive()
    {
        $this->beConstructedWith(UserStatus::BLOCKED);
        $this->isActive()->shouldReturn(false);
        $this->status()->shouldReturn(UserStatus::BLOCKED);
    }

    function it_should_throw_exception_when_wrong_status_is_passed()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('__construct', ['test']);
    }


    function it_should_change_user_status()
    {
        $status = $this->changeStatus(UserStatus::BLOCKED);

        $status->isActive()->shouldReturn(false);
        $status->status()->shouldReturn(UserStatus::BLOCKED);

        $this->isActive()->shouldReturn(true);
        $this->status()->shouldReturn(UserStatus::ACTIVE);
    }


    function it_should_check_equality()
    {
        $this->equals(UserStatus::ACTIVE)->shouldReturn(true);
        $this->equals(UserStatus::BLOCKED)->shouldReturn(false);
    }

}
