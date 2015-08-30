<?php

namespace spec\Dgafka\ES\Client\Domain\User;

use Dgafka\ES\Client\Domain\User\UserBecameVIPEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class UserBecameVIPEventSpec
 *
 * @package spec\Dgafka\ES\Client\Domain\User
 * @mixin UserBecameVIPEvent
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class UserBecameVIPEventSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith('identity');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Dgafka\ES\Client\Domain\User\UserBecameVIPEvent');
    }

    function it_should_return_id()
    {
        $this->ID()->shouldReturn('identity');
    }

}
