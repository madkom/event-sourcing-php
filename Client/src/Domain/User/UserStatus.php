<?php

namespace Dgafka\ES\Client\Domain\User;

/**
 * Class UserStatus
 *
 * @package Dgafka\ES\Client\Domain\User
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class UserStatus
{

	/**
	 * User is active
	 */
	const ACTIVE  = 0;

	/**
	 * User is blocked
	 */
	const BLOCKED = 1;

	/** @var  string status */
	private $status;

	/**
	 * @param string $status
	 */
    public function __construct($status)
    {
		$this->setStatus($status);
    }

	/**
	 * Checks if user is active
	 *
	 * @return bool
	 */
    public function isActive()
    {
		return $this->status === self::ACTIVE;
    }

	/**
	 * @return string
	 */
	public function status()
	{
		return $this->status;
	}

	/**
	 * @param $status
	 *
	 * @return self
	 */
	public function changeStatus($status)
	{
		return new self($status);
	}

	/**
	 * @param string $status
	 *
	 * @return bool
	 */
	public function equals($status)
	{
		return $this->status === $status;
	}

	/**
	 * Sets user status
	 *
	 * @param $status
	 */
	private function setStatus($status)
	{
		$rflClass  = new \ReflectionClass($this);
		$constants = $rflClass->getConstants();

		foreach($constants as $constant) {
			if($constant === $status) {
				$this->status = $status;
				return;
			}
		}

		throw new \InvalidArgumentException("Passed status {$status} is not available");

	}

}
