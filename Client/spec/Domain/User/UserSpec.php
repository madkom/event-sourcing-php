<?php

namespace spec\Dgafka\ES\Client\Domain\User;

use Dgafka\ES\Client\Domain\User\UserID;
use Dgafka\ES\Client\Domain\User\UserInformation;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSpec extends ObjectBehavior
{

    public function let(UserID $userID, UserInformation $userInformation)
    {
        $this->beConstructedWith($userID, $userInformation);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Dgafka\ES\Client\Domain\User\User');
    }
}
