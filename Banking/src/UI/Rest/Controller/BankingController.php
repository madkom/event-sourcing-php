<?php

namespace Madkom\ES\Banking\UI\Rest\Controller;

use Phalcon\Mvc\Controller;

/**
 * Class BankingController
 * @package Madkom\ES\Banking\UI\Rest\Controller
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class BankingController extends Controller
{

    /**
     *  Transfers money to choosen account
     *
     * @throws \Exception
     */
    public function transferOutAction()
    {
        if(!$this->request->has('from_account') || !$this->request->has('to_account') || !$this->request->has('money_amount')) {
            throw new \Exception('Missing one parameters from_account or to_account or money_amount');
        }

        $fromAccount = $this->request->get('from_account');
        $toAccount   = $this->request->get('to_account');
        $moneyAmount = (int)$this->request->get('money_amount');


        $diContainer = \Madkom\ES\Banking\UI\Bundle\App\DependencyContainer::getInstance();
        /** @var \Madkom\ES\Banking\Application\API\Banking $bankingAPI */
        $bankingAPI = $diContainer->get('banking.api');

        $bankingAPI->transferOut($fromAccount, $toAccount, $moneyAmount);
    }

}