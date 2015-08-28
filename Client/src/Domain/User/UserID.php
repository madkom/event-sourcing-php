<?php

namespace Dgafka\ES\Client\Domain\User;
use Dgafka\ES\Client\SharedKernel\Domain\ID;

/**
 * Class UserID
 * @package Dgafka\ES\Client\Domain\User
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class UserID implements ID
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