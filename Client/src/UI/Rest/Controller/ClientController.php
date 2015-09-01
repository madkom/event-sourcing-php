<?php

namespace Dgafka\ES\Client\UI\Rest\Controller;

use Dgafka\ES\Client\Application\Internal\Client\ClientBecomeVIPCommand;
use Dgafka\ES\Client\Application\Internal\Client\ClientChangeDataCommand;
use Dgafka\ES\Client\Application\Internal\Client\ClientChangeStatus;
use Dgafka\ES\Client\Application\Internal\Client\ClientRegistrationCommand;
use Phalcon\Mvc\Controller;

/**
 * Class ClientController
 * @package Dgafka\ES\Client\UI\Rest\Controller
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class ClientController extends Controller
{

    /**
     * Registers new client
     *
     * @throws \Exception
     */
    public function registerAction()
    {

        if(!$this->request->has('name') || !$this->request->has('surname')) {
            throw new \Exception('Missing one parameters name or surname');
        }

        $name    = $this->request->get('name');
        $surname = $this->request->get('surname');

        /** @var \Dgafka\ES\Client\Application\API\Client $client */
        $client = $this->di->get('clientAPI');
        $id = $client->register(new ClientRegistrationCommand($name, $surname));

        $this->response->setJsonContent(['id' => $id]);
        $this->response->send();
    }

    /**
     * Changes client data.
     *
     * @throws \Exception
     */
    public function changeDataAction()
    {
        if(!$this->request->has('id') || !$this->request->has('name') || !$this->request->has('surname')) {
            throw new \Exception('Missing one parameters id or name or surname');
        }

        $id      = $this->request->get('id');
        $name    = $this->request->get('name');
        $surname = $this->request->get('surname');

        /** @var \Dgafka\ES\Client\Application\API\Client $client */
        $client = $this->di->get('clientAPI');
        $client->changeBasicData(new ClientChangeDataCommand($id, $name, $surname));

        $this->response->setStatusCode(204);
        $this->response->send();
    }

    /**
     * Changes user status
     *
     * @throws \Exception
     */
    public function changeStatusAction()
    {
        if(!$this->request->has('id') || !$this->request->has('status')) {
            throw new \Exception('Missing one parameters id or status');
        }

        $id     = $this->request->get('id');
        $status = $this->request->get('status');

        /** @var \Dgafka\ES\Client\Application\API\Client $client */
        $client = $this->di->get('clientAPI');
        $client->changeStatus(new ClientChangeStatus($id, $status));
    }

    /**
     * Makes user VIP
     *
     * @throws \Exception
     */
    public function makeVIPAction()
    {
        if(!$this->request->has('id')) {
            throw new \Exception('Missing one parameter id');
        }

        $id     = $this->request->get('id');

        /** @var \Dgafka\ES\Client\Application\API\Client $client */
        $client = $this->di->get('clientAPI');
        $client->becomeVIP(new ClientBecomeVIPCommand($id));
    }



}