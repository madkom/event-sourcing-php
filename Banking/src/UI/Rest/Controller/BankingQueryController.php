<?php

namespace Madkom\ES\Banking\UI\Rest\Controller;

use Madkom\ES\Banking\Application\API\BankingQuery;
use Madkom\ES\Banking\UI\Bundle\App\DependencyContainer;
use Phalcon\Mvc\Controller;

/**
 * Class BankingQueryController
 * @package Madkom\ES\Banking\UI\Rest\Controller
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class BankingQueryController extends Controller
{

    /**
     * Returns account
     *
     * @throws \Exception
     */
    public function getAccountByIDAction()
    {
        if(!$this->request->has('id')) {
            throw new \Exception('Missing one parameter account `id`');
        }
        $id = $this->request->get('id');

        $diContainer = DependencyContainer::getInstance();

        /** @var BankingQuery $queryAPI */
        $queryAPI = $diContainer->get('banking.query.api');

        $this->response->setJsonContent(['data' => $queryAPI->getAccount($id)]);
        $this->response->send();

    }

    /**
     * Returns account
     *
     * @throws \Exception
     */
    public function getAccountByClientIDAction()
    {
        if(!$this->request->has('id')) {
            throw new \Exception('Missing one parameters client `id`');
        }
        $id = $this->request->get('id');

        $diContainer = DependencyContainer::getInstance();

        /** @var BankingQuery $queryAPI */
        $queryAPI = $diContainer->get('banking.query.api');

        $this->response->setJsonContent(['data' => $queryAPI->getAccountByClientID($id)]);
        $this->response->send();

    }

    /**
     * Returns transfers for account
     *
     * @throws \Exception
     */
    public function getTransfersAction()
    {
        if(!$this->request->has('id')) {
            throw new \Exception('Missing one parameters account `id`');
        }
        $id = $this->request->get('id');

        $diContainer = DependencyContainer::getInstance();

        /** @var BankingQuery $queryAPI */
        $queryAPI = $diContainer->get('banking.query.api');

        $transfers = $queryAPI->getHistory($id);
        if($transfers) {
            $transfers = json_decode($transfers['transfers']);
        }

        $this->response->setJsonContent(['data' => $transfers]);
        $this->response->send();

    }

    /**
     * Return transfer by client
     *
     * @throws \Exception
     */
    public function getTransfersByClientIDAction()
    {
        if(!$this->request->has('client_id')) {
            throw new \Exception('Missing one parameters account `client_id`');
        }
        $clientID = $this->request->get('client_id');

        $diContainer = DependencyContainer::getInstance();

        /** @var BankingQuery $queryAPI */
        $queryAPI = $diContainer->get('banking.query.api');

        $transfers = $queryAPI->getHistoryByClientID($clientID);
        if($transfers) {
            $transfers = json_decode($transfers['transfers']);
        }

        $this->response->setJsonContent(['data' => $transfers]);
        $this->response->send();
    }

}