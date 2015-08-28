<?php

namespace spec\Dgafka\ES\Client\Domain\User;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class UserDataSpec
 *
 * @package spec\Dgafka\ES\Client\Domain\User
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class UserDataSpec extends ObjectBehavior
{

    public function let()
    {
        $this->beConstructedWith('Antonio', 'Magusta');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Dgafka\ES\Client\Domain\User\UserData');
    }

    public function it_should_return_values_it_was_created_with()
    {
        $this->name()->shouldReturn('Antonio');
        $this->surname()->shouldReturn('Magusta');
    }

}
