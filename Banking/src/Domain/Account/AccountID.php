<?php

namespace Madkom\ES\Banking\Domain\Account;

/**
 * Class AccountID
 * @package Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class AccountID
{

    /**
     * @var string
     */
    private $accountID;

    /**
     * @param string $accountID
     */
    public function __construct($accountID)
    {

        $this->accountID = $accountID;
    }

}
