<?php

namespace Dgafka\ES\Client\Domain\User;

use Dgafka\ES\Client\SharedKernel\Domain\DomainEvent;

/**
 * Class UserChangedData
 *
 * @package Dgafka\ES\Client\Domain\User
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class UserChangedDataEvent implements DomainEvent
{

	/** @var string  */
	private $name;

	/** @var string  */
	private $surname;

	/**
	 * @param string $name
	 * @param string $surname
	 */
	public function __construct($name, $surname)
	{
		$this->name     = $name;
		$this->surname  = $surname;
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