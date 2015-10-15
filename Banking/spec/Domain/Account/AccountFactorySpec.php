<?php

namespace spec\Madkom\ES\Banking\Domain\Account;

use Madkom\ES\Banking\Domain\Account\AccountID;
use Madkom\ES\Banking\Domain\Account\ClientID;
use Madkom\ES\Banking\Domain\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class AccountFactorySpec
 * @package spec\Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class AccountFactorySpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\ES\Banking\Domain\Account\AccountFactory');
    }

    function it_should_create_account(AccountID $accountID, ClientID $clientID)
    {
        $this->create($accountID, $clientID)->shouldHaveType('Madkom\ES\Banking\Domain\Account\Account');
    }

}
