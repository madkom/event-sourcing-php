<?php

namespace spec\Dgafka\ES\Client\Domain\User;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserInformationSpec extends ObjectBehavior
{

    public function let()
    {
        $this->beConstructedWith('Antonio', 'Magusta');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Dgafka\ES\Client\Domain\User\UserInformation');
    }

    public function it_should_return_values_it_was_created_with()
    {
        $this->name()->shouldReturn('Antonio');
        $this->surname()->shouldReturn('Magusta');
    }

}
