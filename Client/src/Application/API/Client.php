<?php

namespace Dgafka\ES\Client\Application\API;


use Dgafka\ES\Client\Application\Internal\Client\ClientBecomeVIPCommand;
use Dgafka\ES\Client\Application\Internal\Client\ClientChangeDataCommand;
use Dgafka\ES\Client\Application\Internal\Client\ClientChangeStatus;
use Dgafka\ES\Client\Application\Internal\Client\ClientRegistrationCommand;

/**
 * Interface Client - API for outside clients, without internal behaviour.
 *
 * @package Dgafka\ES\Client\Application\API
 * @author Dariusz Gafka <dgafka.mail@gmail.com>
 */
interface Client
{

	/**
	 * Registers client
	 *
	 * @param ClientRegistrationCommand $command
	 *
	 * @return string - New created ID
	 */
	public function register(ClientRegistrationCommand $command);

	/**
	 * Changes client data
	 *
	 * @param ClientChangeDataCommand $command
	 *
	 * @return void
	 */
	public function changeBasicData(ClientChangeDataCommand $command);

	/**
	 * Changes client status
	 *
	 * @param ClientChangeStatus $command
	 *
	 * @return void
	 */
	public function changeStatus(ClientChangeStatus $command);

	/**
	 * Client becomes VIP
	 *
	 * @param ClientBecomeVIPCommand $command
	 *
	 * @return void
	 */
	public function becomeVIP(ClientBecomeVIPCommand $command);

}