<?php

namespace Dgafka\ES\Client\SharedKernel\Domain;

/**
 * Interface ID - Represents entity identity
 *
 * @package Dgafka\ES\Client\SharedKernel\Domain
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
interface ID
{

	/**
	 * @return string
	 */
	public function ID();

}