<?php

namespace spec\Dgafka\ES\Client\Domain\User;

use Dgafka\ES\Client\Domain\User\UserRegisteredEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class UserRegisteredEventSpec
 *
 * @package spec\Dgafka\ES\Client\Domain\User
 * @mixin UserRegisteredEvent
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class UserRegisteredEventSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith('identity', 'Alfred', 'Maluto');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Dgafka\ES\Client\Domain\User\UserRegisteredEvent');
    }

    public function it_should_return_values_it_was_created_with()
    {
        $this->userID()->shouldReturn('identity');
        $this->name()->shouldReturn('Alfred');
        $this->surname()->shouldReturn('Maluto');
    }

}
