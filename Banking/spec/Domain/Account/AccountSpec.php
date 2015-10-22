<?php

namespace spec\Madkom\ES\Banking\Domain\Account;

use Madkom\ES\Banking\Domain\Account\Account;
use Madkom\ES\Banking\Domain\Account\AccountID;
use Madkom\ES\Banking\Domain\Account\ClientID;
use Madkom\ES\Banking\Domain\Account\TransferFactory;
use Madkom\ES\Banking\Domain\Account\TransferType;
use Madkom\ES\Banking\Domain\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class AccountSpec
 * @package spec\Madkom\ES\Banking\Application\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Account
 */
class AccountSpec extends ObjectBehavior
{
    /** @var  Money */
    private $accountMoney;

    function let(AccountID $accountID, ClientID $clientID, Money $money)
    {
        $this->accountMoney = $money;
        $accountID->ID()->willReturn('2');

        $this->beConstructedWith($accountID, $clientID, $money, true, 1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\ES\Banking\Domain\Account\Account');
    }

    function it_should_debit_account(TransferFactory $transferFactory, Money $money, AccountID $accountID)
    {
        $this->accountMoney->moreOrEqualThan($money)->willReturn(true);
        $this->accountMoney->subtract($money)->shouldBeCalledTimes(1);

        $accountID->ID()->willReturn('5');
        $money->amount()->willReturn(100);

        $transferFactory->create(TransferType::SENT, $accountID, $money)->shouldBeCalledTimes(1);

        $this->debit($transferFactory, $accountID, $money);
        $uncommittedEvents = $this->getUncommittedEvents();
        $uncommittedEvents->shouldHaveCount(1);
        $uncommittedEvents[0]->shouldHaveType('Madkom\ES\Banking\Domain\Account\MoneyTransferredEvent');

        $uncommittedEvents = $this->getUncommittedEvents();
        $uncommittedEvents->shouldHaveCount(0);
    }

    function it_should_not_debit_if_not_enough_money(TransferFactory $transferFactory, Money $money, AccountID $accountID)
    {
        $this->accountMoney->moreOrEqualThan($money)->willReturn(false);

        $this->shouldThrow('Madkom\ES\Banking\Domain\DomainException')->during('debit', [$transferFactory, $accountID, $money]);
    }

    function it_should_credit(TransferFactory $transferFactory, Money $money, AccountID $accountID)
    {
        $this->accountMoney->add($money)->shouldBeCalledTimes(1);

        $transferFactory->create(TransferType::RECEIVED, $accountID, $money)->shouldBeCalledTimes(1);

        $this->credit($transferFactory, $accountID, $money);
    }

    function it_should_not_debit_when_not_active(TransferFactory $transferFactory, Money $money, AccountID $accountID)
    {
        $this->accountMoney->moreOrEqualThan($money)->willReturn(true);

        $this->deactivate();
        $this->shouldThrow('Madkom\ES\Banking\Domain\DomainException')->during('debit', [$transferFactory, $accountID, $money]);

        $this->activate();
        $this->accountMoney->subtract($money)->shouldBeCalledTimes(1);
        $money->amount()->willReturn(5);
        $accountID->ID()->willReturn('100');

        $transferFactory->create(TransferType::SENT, $accountID, $money)->shouldBeCalledTimes(1);

        $this->debit($transferFactory, $accountID, $money);
    }

}
