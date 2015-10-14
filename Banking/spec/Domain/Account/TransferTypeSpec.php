<?php

namespace spec\Madkom\ES\Banking\Domain\Account;

use Madkom\ES\Banking\Domain\Account\TransferType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class TransferTypeSpec
 * @package spec\Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin TransferType
 */
class TransferTypeSpec extends ObjectBehavior
{

    public function let()
    {
        $this->beConstructedWith(TransferType::RECEIVED);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\ES\Banking\Domain\Account\TransferType');
    }

    public function it_should_throw_exception_if_wrong_typed_passed_for_creation()
    {
        $this->shouldThrow('\Madkom\ES\Banking\Domain\DomainException')->during('__construct', [-1]);
        $this->shouldThrow('\Madkom\ES\Banking\Domain\DomainException')->during('__construct', [4]);
    }

}
