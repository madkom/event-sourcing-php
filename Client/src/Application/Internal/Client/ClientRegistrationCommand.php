<?php

namespace Dgafka\ES\Client\Application\Internal\Client;

/**
 * Class ClientRegistrationCommand
 *
 * @package Dgafka\ES\Client\Application\Internal\Client
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class ClientRegistrationCommand
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