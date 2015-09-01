<?php

namespace Dgafka\ES\Client\Domain\User;

use Broadway\Domain\AggregateRoot;

/**
 * Interface UserRepository - Repository for user, which handles read/writes
 *
 * @package Dgafka\ES\Client\Domain\User
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
interface UserRepository
{

	/**
	 * @param AggregateRoot $user
	 *
	 * @return void
	 */
	public function save(AggregateRoot $user);

	/**
	 * @param UserID $userID
	 *
	 * @return null|User
	 */
	public function find(UserID $userID);

}