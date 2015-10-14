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

    function let(ClientID $clientID)
    {
        $this->beConstructedWith($clientID, 100);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\ES\Banking\Domain\Account\ClientID');
    }



}
