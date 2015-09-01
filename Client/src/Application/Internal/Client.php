<?php

namespace Dgafka\ES\Client\Application\Internal;

use Dgafka\ES\Client\Application\Internal\Client\ClientBecomeVIPCommand;
use Dgafka\ES\Client\Application\Internal\Client\ClientChangeDataCommand;
use Dgafka\ES\Client\Application\Internal\Client\ClientChangeStatus;
use Dgafka\ES\Client\Application\Internal\Client\ClientRegistrationCommand;
use Dgafka\ES\Client\Application\Service\UUIDGenerator;
use Dgafka\ES\Client\Domain\User\User;
use Dgafka\ES\Client\Domain\User\UserData;
use Dgafka\ES\Client\Domain\User\UserID;
use Dgafka\ES\Client\Domain\User\UserRepository;

/**
 * Class Client -
 * Objects should be created inside domain factory,
 * but for example purpose, they are created in application layer
 *
 * You may wonder, why application layer is not tested.
 * Well in practice it should be, but the most important thing to test it Domain Layer.
 * If you don't have much time, you can omit unit testing App Layer and do some integration tests or none.
 *
 * API Layer may come with enormous amount of histories to test, so think twice, if you want to spend much time testing it.
 *
 * @package Dgafka\ES\Client\Application\Internal
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
class Client implements \Dgafka\ES\Client\Application\API\Client
{

	/** @var UserRepository  */
	private $userRepository;

	/** @var  UUIDGenerator */
	private $uuidGenerator;

	/**
	 * @param UUIDGenerator  $generator
	 * @param UserRepository $userRepository
	 */
	public function __construct(UUIDGenerator $generator, UserRepository $userRepository)
	{
		$this->uuidGenerator  = $generator;
		$this->userRepository = $userRepository;
	}

	/**
	 * Registers user
	 *
	 * @param ClientRegistrationCommand $command
	 *
	 * @return string
	 */
	public function register(ClientRegistrationCommand $command)
	{
		$userID = new UserID($this->uuidGenerator->generateUUID());
		$user = User::register($userID, new UserData($command->name(), $command->surname()));


		$this->userRepository->save($user);

		return $userID->ID();
	}

	/**
	 * Changes client data
	 *
	 * @param ClientChangeDataCommand $command
	 *
	 * @return void
	 */
	public function changeBasicData(ClientChangeDataCommand $command)
	{
		$user = $this->userRepository->find(new UserID($command->ID()));

		$user->changeUserData(new UserData($command->name(), $command->surname()));

		$this->userRepository->save($user);
	}

	/**
	 * Changes client status
	 *
	 * @param ClientChangeStatus $command
	 *
	 * @return void
	 */
	public function changeStatus(ClientChangeStatus $command)
	{
		$user = $this->userRepository->find(new UserID($command->ID()));

		$user->changeStatus($command->status());

		$this->userRepository->save($user);
	}

	/**
	 * Client becomes VIP
	 *
	 * @param ClientBecomeVIPCommand $command
	 *
	 * @return void
	 */
	public function becomeVIP(ClientBecomeVIPCommand $command)
	{
		$user = $this->userRepository->find(new UserID($command->ID()));

		$user->becomeVIP();

		$this->userRepository->save($user);
	}

}