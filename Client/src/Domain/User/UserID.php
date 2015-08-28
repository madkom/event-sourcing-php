<?php

namespace Dgafka\ES\Client\Domain\User;

/**
 * Class UserID
 * @package Dgafka\ES\Client\Domain\User
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class UserID
{

    /** @var  string */
    private $ID;

    /**
     * @param $ID
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