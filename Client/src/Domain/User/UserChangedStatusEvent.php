<?php

namespace Dgafka\ES\Client\Domain\User;

/**
 * Class UserChangedStatus
 *
 * @package Dgafka\ES\Client\Domain\User
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class UserChangedStatusEvent
{

    /** @var  string User status */
    private $status;

    /**
     * @param string $status
     */
    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function status()
    {
        return $this->status;
    }

}
