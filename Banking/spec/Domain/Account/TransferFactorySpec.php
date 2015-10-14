<?php

namespace spec\Madkom\ES\Banking\Domain\Account;

use Madkom\ES\Banking\Domain\Account\AccountID;
use Madkom\ES\Banking\Domain\Account\TransferFactory;
use Madkom\ES\Banking\Domain\Account\TransferType;
use Madkom\ES\Banking\Domain\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class TransferFactorySpec
 * @package spec\Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin TransferFactory
 */
class TransferFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\ES\Banking\Domain\Account\TransferFactory');
    }

    function it_should_create_new_transfer(AccountID $collaborator, Money $money)
    {
        $this->create(TransferType::SENT, $collaborator, $money);
    }

}
