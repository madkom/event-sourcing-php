<?php

namespace Dgafka\ES\Client\Application\Internal\Client;

/**
 * Class ClientChangeDataCommand
 *
 * @package Dgafka\ES\Client\Application\Internal\Client
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class ClientChangeDataCommand
{

	/** @var string  */
	private $ID;

	/** @var string  */
	private $name;

	/** @var string  */
	private $surname;

	/**
	 * @param string $ID
	 * @param string $name
	 * @param string $surname
	 */
	public function __construct($ID, $name, $surname)
	{
		$this->ID       = $ID;
		$this->name     = $name;
		$this->surname  = $surname;
	}

	/**
	 * @return string
	 */
	public function ID()
	{
		return $this->ID;
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