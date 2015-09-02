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

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * String representation of object
	 * @link http://php.net/manual/en/serializable.serialize.php
	 * @return string the string representation of the object or null
	 */
	public function serialize()
	{
		return ['userID' => $this->userID, 'name' => $this->name, 'surname' => $this->surname];
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Constructs the object
	 * @link http://php.net/manual/en/serializable.unserialize.php
	 *
	 * @param string $serialized <p>
	 *                           The string representation of the object.
	 *                           </p>
	 *
	 * @return void
	 */
	public function unserialize($serialized)
	{
		$this->userID = $serialized['userID'];
		$this->name   = $serialized['name'];
		$this->surname = $serialized['surname'];
	}


}
