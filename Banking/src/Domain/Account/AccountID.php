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
    private $ID;

    /**
     * @param string $ID
     */
    public function __construct($ID)
    {

        $this->ID = $ID;
    }

    /**
     * Returns account's ID
     *
     * @return string
     */
    public function ID()
    {
        return $this->ID;
    }

}
