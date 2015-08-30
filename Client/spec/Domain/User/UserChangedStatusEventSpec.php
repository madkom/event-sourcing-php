<?php

namespace spec\Dgafka\ES\Client\Domain\User;

use Dgafka\ES\Client\Domain\User\UserStatus;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class UserChangedStatusSpec
 *
 * @package spec\Dgafka\ES\Client\Domain\User
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class UserChangedStatusEventSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith(UserStatus::ACTIVE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Dgafka\ES\Client\Domain\User\UserChangedStatusEvent');
    }

    function it_should_return_status_it_was_created_with()
    {
        $this->status()->shouldReturn(UserStatus::ACTIVE);
    }

}
