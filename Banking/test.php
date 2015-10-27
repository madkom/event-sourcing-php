<?php
require('vendor/autoload.php');



$tmp = new \Madkom\ES\Banking\Infrastructure\BankingQueryRepository();

var_dump($tmp->getHistory("1b9dcd54-7c99-11e5-b8c9-2ec669f5b73b"));