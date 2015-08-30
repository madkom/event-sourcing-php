<?php

namespace Dgafka\ES\Client\Application\Internal\Client;

/**
 * Class ClientBecomeVIPCommand
 *
 * @package Dgafka\ES\Client\Application\Internal\Client
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class ClientBecomeVIPCommand
{

	/** @var string  */
	private $ID;

	/**
	 * @param string $ID
	 */
	public function __construct($ID)
	{
		$this->ID = $ID;
	}

	/**
	 * @return string
	 */
	public function ID()
	{
		return $this->ID;
	}

}