<?php

$entityManager = $entityManager = \Madkom\ES\Banking\UI\Bundle\App\DoctrineEntityManager::getInstance();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);