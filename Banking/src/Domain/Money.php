<?php

namespace Madkom\ES\Banking\Domain;

use Madkom\ES\Banking\Domain\DomainException;

/**
 * Class Money - Normally it would be in SharedKernel
 * @package Madkom\ES\Banking\Domain\Account
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Money
{

    /** @var int  */
    private $amount;

    /**
     * @param int $amount
     *
     * @throws DomainException
     */
    public function __construct($amount)
    {
        if(!is_int($amount)) {
            throw new DomainException("Can't create money, when no integer passed");
        }

        $this->amount = $amount;
    }

    /**
     * Amount of money
     *
     * @return int
     */
    public function amount()
    {
        return $this->amount;
    }

    /**
     * Add to money object
     *
     * @param Money $money
     *
     * @return self
     */
    public function add(Money $money)
    {
        return new self($this->amount() + $money->amount());
    }


    /**
     * Subtracts money
     *
     * @param Money $money
     *
     * @return self
     */
    public function subtract(Money $money)
    {
        return new self($this->amount() - $money->amount());
    }

    /**
     * Checks, if money amount is equal or more than passed value
     *
     * @param Money $money
     *
     * @return bool
     */
    public function moreOrEqualThan(Money $money)
    {
        return $this->amount() >= $money->amount();
    }

    /**
     * Checks if money amount equals passed value
     *
     * @param Money $money
     *
     * @return bool
     */
    public function equals(Money $money)
    {
        return $this->amount() === $money->amount();
    }

}
