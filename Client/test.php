<?php
require('vendor/autoload.php');

use EventStore\EventStore;
use EventStore\WritableEvent;
use EventStore\WritableEventCollection;

$es = new EventStore('http://' . getenv('ES_PORT_2113_TCP_ADDR') . ':' . getenv('ES_PORT_2113_TCP_PORT'));

$event1 = WritableEvent::newInstance('someType', ['test' => 1], ['author' => 'test']);
$event2 = WritableEvent::newInstance('someType2', ['test' => 3], ['author' => 'test']);

$collection = new WritableEventCollection([
     $event1, $event2
]);

$es->writeToStream('testStream', $collection);

$iterator = $es->forwardStreamFeedIterator('testStream');

foreach($iterator as $entry) {
    print_r($entry->getEntry());
    print_r($entry->getEvent());
}

//$es->