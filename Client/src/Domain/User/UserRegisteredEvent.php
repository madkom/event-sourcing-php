<?php

namespace Dgafka\ES\Client\Domain\User;

use Dgafka\ES\Client\SharedKernel\Domain\DomainEvent;

/**
 * Class UserRegisteredEvent
 *
 * @package Dgafka\ES\Client\Domain\User
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class UserRegisteredEvent implements DomainEvent
{

	/** @var string */
	private $userID;

	/** @var string  */
	private $name;

	/** @var string  */
	private $surname;

	/**
	 * @param string $userID
	 * @param string $name
	 * @param string $surname
	 */
	public function __construct($userID, $name, $surname)
	{
		$this->userID  = $userID;
		$this->name    = $name;
		$this->surname = $surname;
	}

	/**
	 * @return string
	 */
    public function userID()
    {
		return $this->userID;
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
