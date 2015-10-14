<?php

namespace Madkom\ES\Banking\Domain\Account;

use Madkom\ES\Banking\Domain\DomainException;

/**
 * Class TransferType
 * @package Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class TransferType
{

    /** Transfer was sent to another account */
    const SENT = 0;
    /** Transfer was received from another account */
    const RECEIVED = 1;
    /** Transfer was received as a bonus */
    const BONUS = 2;

    /** @var string  */
    private $type;

    /**
     * @param string $type
     */
    public function __construct($type)
    {
        $this->setType($type);
    }

    /**
     * Sets type of class
     *
     * @param string $type
     *
     * @throws DomainException
     */
    private function setType($type)
    {
        $selfRfl = new \ReflectionClass($this);
        $constants = $selfRfl->getConstants();

        foreach($constants as $constant)  {
            if($constant === $type) {
                $this->type = $type;
                return;
            }
        }

        throw new DomainException("Passed transfer type is wrong {$type}.");

    }

}
