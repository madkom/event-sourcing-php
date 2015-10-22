<?php

namespace Madkom\ES\Banking\Domain\Account;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class AccountID
 * @package Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @ExclusionPolicy("NONE")
 */
class AccountID
{

    /**
     * @var string
     *
     * @Type("string")
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
