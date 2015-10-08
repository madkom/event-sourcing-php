<?php
require('../vendor/autoload.php');


$tmp = new \Madkom\ES\Banking\Worker\SynchronizeEvents();
$tmp->run();