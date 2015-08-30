<?php

namespace Dgafka\ES\Client\Infrastructure;

use Rhumsaa\Uuid\Uuid;

/**
 * Class UUIDGenerator
 *
 * @package Dgafka\ES\Client\Infrastructure
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class UUIDGenerator implements \Dgafka\ES\Client\Application\Service\UUIDGenerator
{

	/**
	 * @return string
	 */
	public function generateUUID()
	{
		$uuid = Uuid::uuid1();
		return $uuid->toString();
	}

}