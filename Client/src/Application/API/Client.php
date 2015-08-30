<?php

namespace Dgafka\ES\Client\Application\API;


use Dgafka\ES\Client\Application\Internal\ClientBecomeVIPCommand;
use Dgafka\ES\Client\Application\Internal\ClientChangeDataCommand;
use Dgafka\ES\Client\Application\Internal\ClientChangeStatus;
use Dgafka\ES\Client\Application\Internal\ClientRegistrationCommand;

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
	 * @return void
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