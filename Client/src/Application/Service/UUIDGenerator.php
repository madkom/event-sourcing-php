<?php

namespace Dgafka\ES\Client\Application\Service;

/**
 * Interface UUIDGenerator - generator uuid for client
 *
 * @package Dgafka\ES\Client\Application\Service
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
interface UUIDGenerator
{

	/**
	 * @return string
	 */
	public function generateUUID();

}