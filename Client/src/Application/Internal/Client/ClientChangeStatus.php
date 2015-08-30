<?php

namespace Dgafka\ES\Client\Application\Internal\Client;

/**
 * Class ClientChangeStatus
 *
 * @package Dgafka\ES\Client\Application\Internal\Client
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class ClientChangeStatus
{

	/** @var string  */
	private $ID;

	/** @var string  */
	private $status;

	/**
	 * @param string $ID
	 * @param string $status
	 */
	public function __construct($ID, $status)
	{
		$this->ID     = $ID;
		$this->status = $status;
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
	public function status()
	{
		return $this->status;
	}

}