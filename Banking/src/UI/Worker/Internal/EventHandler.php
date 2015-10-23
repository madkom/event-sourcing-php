<?php

namespace Madkom\ES\Banking\UI\Worker\Internal;

require(__DIR__ . '/../../../../vendor/autoload.php');

use Pheanstalk\Pheanstalk;

/**
 * Class EventHandler - Based on beanstalkd. Is responsible for handling internal events.
 * @package Madkom\ES\Banking\UI\Worker\Internal
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class EventHandler
{

    /** @var Pheanstalk  */
    private $pheanstalkd;

    public function __construct()
    {
        $this->pheanstalkd = new Pheanstalk('bankingqueue');
    }

    /**
     * Retrieves jobs
     */
    public function run()
    {
        while(true) {

            $job = $this->pheanstalkd
                ->watch('eventtube')
                ->ignore('default')
                ->reserve();

            if($job) {
                $data = json_decode($job->getData(), true);

                if($data['class'] == "Madkom\\ES\\Banking\\Domain\\Account\\MoneyTransferredEvent") {

                    $diContainer = \Madkom\ES\Banking\UI\Bundle\App\DependencyContainer::getInstance();
                    /** @var \Madkom\ES\Banking\Application\API\Banking $bankingAPI */
                    $bankingAPI = $diContainer->get('banking.api');

                    $bankingAPI->transferIn($data['data']['from_account_i_d'], $data['data']['to_account_i_d'], $data['data']['money_amount']);

                    $this->pheanstalkd->delete($job);
                }

            }

        }
    }

}

$eventHandler = new EventHandler();
$eventHandler->run();