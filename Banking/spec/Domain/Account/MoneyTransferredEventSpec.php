<?php

namespace spec\Madkom\ES\Banking\Domain\Account;

use Madkom\ES\Banking\Domain\Account\MoneyTransferredEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class MoneyTransferredEventSpec
 * @package spec\Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin MoneyTransferredEvent
 */
class MoneyTransferredEventSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith('123', '321', 22, '2015-01-01');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\ES\Banking\Domain\Account\MoneyTransferredEvent');
    }
}
