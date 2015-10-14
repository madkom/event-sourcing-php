<?php

namespace spec\Madkom\ES\Banking\Domain\Account;

use Madkom\ES\Banking\Domain\Account\AccountID;
use Madkom\ES\Banking\Domain\Account\TransferType;
use Madkom\ES\Banking\Domain\Money;
use Madkom\ES\Banking\Domain\Account\Transfer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class TransferSpec
 * @package spec\Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Transfer
 */
class TransferSpec extends ObjectBehavior
{

    function let(AccountID $collaboratingAccount, Money $money, \DateTime $dateTime)
    {
        $transferType = new TransferType(TransferType::RECEIVED);
        $this->beConstructedWith($transferType, $collaboratingAccount, $money, $dateTime);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\ES\Banking\Domain\Account\Transfer');
    }

}
