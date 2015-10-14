<?php

namespace spec\Madkom\ES\Banking\Domain\Account;

use Madkom\ES\Banking\Domain\Account\AccountID;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class AccountIDSpec
 * @package spec\Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin AccountID
 */
class AccountIDSpec extends ObjectBehavior
{

    /** @var  AccountID */
    private $accountID;

    function let($accountID)
    {
        $this->accountID = $accountID;
        $this->beConstructedWith($accountID);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Madkom\ES\Banking\Domain\Account\AccountID');
    }

}
