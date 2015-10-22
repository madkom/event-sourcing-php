<?php

namespace spec\Madkom\ES\Banking\Domain\Account;

use Madkom\ES\Banking\Domain\Account\ClientID;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ClientIDSpec
 * @package spec\Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin ClientID
 */
class ClientIDSpec extends ObjectBehavior
{

    function let()
    {
        $clientID = '100';
        $this->beConstructedWith($clientID);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\ES\Banking\Domain\Account\ClientID');
    }

    function it_should_return_id()
    {
        $this->ID()->shouldReturn('100');
    }

}
