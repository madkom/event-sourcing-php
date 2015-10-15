<?php
require('../vendor/autoload.php');


$tmp = new \Madkom\ES\Banking\UI\Worker\External\SynchronizeEvents();
$tmp->run();