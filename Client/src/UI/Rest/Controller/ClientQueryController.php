<?php

namespace Dgafka\ES\Client\UI\Rest\Controller;

use Dgafka\ES\Client\Application\API\ClientQuery;
use Phalcon\Mvc\Controller;

/**
 * Class ClientController
 * @package Dgafka\ES\Client\UI\Rest\Controller
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class ClientQueryController extends Controller
{

    /**
     * Return all clients
     *
     * @return array
     */
    public function getAllAction()
    {
        /** @var ClientQuery $clientQueryAPI */
        $clientQueryAPI = $this->getDI()->get('clientQueryAPI');

        $this->response->setJsonContent(['data' => $clientQueryAPI->getAll()]);
        $this->response->send();
    }

    /**
     * Return one client
     *
     * @return array
     * @throws \Exception
     */
    public function getByIDAction()
    {
        $id = $this->request->get('id');

        if(!$this->request->has('id')) {
            throw new \Exception('You need to pass id parameter.');
        }

        /** @var ClientQuery $clientQueryAPI */
        $clientQueryAPI = $this->getDI()->get('clientQueryAPI');

        $this->response->setJsonContent(['data' => $clientQueryAPI->getById($id)]);
        $this->response->send();
    }

}