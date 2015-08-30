<?php

namespace Dgafka\ES\Client\Domain\User;

/**
 * Interface UserRepository - Repository for user, which handles read/writes
 *
 * @package Dgafka\ES\Client\Domain\User
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
interface UserRepository
{

	/**
	 * @param User $user
	 *
	 * @return void
	 */
	public function save(User $user);

	/**
	 * @param UserID $userID
	 *
	 * @return null|User
	 */
	public function find(UserID $userID);

}