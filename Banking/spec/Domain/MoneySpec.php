<?php

namespace spec\Madkom\ES\Banking\Domain;

use Madkom\ES\Banking\Domain\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class MoneySpec
 * @package spec\Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class MoneySpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith(1000);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\ES\Banking\Domain\Money');
    }

    function it_should_throw_exception_when_not_int_passed()
    {
        $this->shouldThrow('Madkom\ES\Banking\Domain\DomainException')->during('__construct', ['22']);
        $this->shouldThrow('Madkom\ES\Banking\Domain\DomainException')->during('__construct', [1.222]);
        $this->shouldThrow('Madkom\ES\Banking\Domain\DomainException')->during('__construct', [new \stdClass()]);
    }

    function it_should_add_money(Money $money)
    {
        $money->amount()->willReturn(10);

        $moneyResult = $this->add($money);
        $moneyResult->shouldHaveType('Madkom\ES\Banking\Domain\Money');
        $moneyResult->amount()->shouldReturn(1010);
        $moneyResult->shouldNotBe($money);
        $moneyResult->shouldNotBe($money);
    }

    function it_should_subtract_money(Money $money)
    {
        $money->amount()->willReturn(900);

        $moneyResult = $this->subtract($money);
        $moneyResult->shouldHaveType('Madkom\ES\Banking\Domain\Money');
        $moneyResult->amount()->shouldReturn(100);
        $moneyResult->shouldNotBe($money);
        $moneyResult->shouldNotBe($this);
    }

    function it_should_check_if_has_more_or_equal_than_passed_amount(Money $money)
    {
        $money->amount()->willReturn(100);
        $this->moreOrEqualThan($money)->shouldReturn(true);

        $money->amount()->willReturn(1000);
        $this->moreOrEqualThan($money)->shouldReturn(true);

        $money->amount()->willReturn(10000);
        $this->moreOrEqualThan($money)->shouldReturn(false);
    }

    function it_should_check_if_user_has_equal_amount(Money $money)
    {
        $money->amount()->willReturn(100);
        $this->equals($money)->shouldReturn(false);

        $money->amount()->willReturn(1000);
        $this->equals($money)->shouldReturn(true);
    }

}
