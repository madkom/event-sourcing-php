<?php

namespace Dgafka\ES\Client\Domain\User;

/**
 * Class UserInformation
 * @package Dgafka\ES\Client\Domain\User
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class UserData
{

    /** @var  string */
    private $name;

    /** @var  string */
    private $surname;

    /**
     * @param string $name
     * @param string $surname
     */
    public function __construct($name, $surname)
    {
        $this->name    = $name;
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function surname()
    {
        return $this->surname;
    }

}
