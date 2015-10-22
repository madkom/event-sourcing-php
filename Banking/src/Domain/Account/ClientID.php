<?php

namespace Madkom\ES\Banking\Domain\Account;

/**
 * Class ClientID
 * @package Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class ClientID
{

    /** @var  string */
    private $ID;

    /**
     * @param string $ID
     */
    public function __construct($ID)
    {
        $this->ID = $ID;
    }

    /**
     * @return string
     */
    public function ID()
    {
        return $this->ID;
    }

}
