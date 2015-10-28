<?php
require('vendor/autoload.php');



$tmp = new \Madkom\ES\Banking\Infrastructure\BankingQueryRepository();

var_dump(json_decode($tmp->getHistory("06d24fc8-7d41-11e5-8ee5-f433906f8976")['transfers']));