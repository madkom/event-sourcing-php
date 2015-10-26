<?php

$entityManager = \Dgafka\ES\Client\UI\ReadModelBundle\App\DoctrineEntityManager::getInstance();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);