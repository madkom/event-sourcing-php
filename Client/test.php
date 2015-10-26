<?php
require('vendor/autoload.php');



$em = \Dgafka\ES\Client\UI\ReadModelBundle\App\DoctrineEntityManager::getInstance();

$user = $em->getRepository('Dgafka\ES\Client\Domain\User\User')->find('4eade95a-7bd5-11e5-90ca-627bf05f50ea');

$user = new \Dgafka\ES\Client\Domain\User\User();
$user->register(new \Dgafka\ES\Client\Domain\User\UserID('2'), new \Dgafka\ES\Client\Domain\User\UserData('test', 'bla'));
$em->persist($user);