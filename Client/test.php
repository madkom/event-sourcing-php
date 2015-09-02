<?php
require('vendor/autoload.php');

use EventStore\EventStore;
use EventStore\WritableEvent;
use EventStore\WritableEventCollection;

$es = new EventStore('http://' . getenv('ES_PORT_2113_TCP_ADDR') . ':' . getenv('ES_PORT_2113_TCP_PORT'));

$event1 = WritableEvent::newInstance('someType', ['test' => 10, 'yep' => ['test'=>'dat']], ['author' => 'test']);
$event2 = WritableEvent::newInstance('someType2', ['test' => 30, 'bla' => 'egg'], ['author' => 'test']);

$collection = new WritableEventCollection([
     $event1, $event2
]);

//$es->writeToStream('testStream', $collection);
//$streamFeed = new \EventStore\StreamFeed\StreamFeed([]);

$streamFeed = $es->openStreamFeed('testStream');
$streamFeed = $es->navigateStreamFeed($streamFeed, \EventStore\StreamFeed\LinkRelation::LAST());

while(!empty($streamFeed->getEntries())) {
    $streamFeed = $es->navigateStreamFeed($streamFeed, \EventStore\StreamFeed\LinkRelation::PREVIOUS());

    foreach($streamFeed->getEntries() as $entry) {
        var_dump($es->readEvent($entry->getEventUrl())->getData());
    }
}

//$streamFeed = \EventStore\StreamFeed\StreamFeedIterator::forward($es, 'testStream');
//$streamFeed = $es->forwardStreamFeedIterator('testStream');

//$es->navigateStreamFeed($streamFeed, \EventStore\StreamFeed\LinkRelation::FIRST)
//$es->navigateStreamFeed($streamFeed, \EventStore\StreamFeed\LinkRelation::FIRST);

//echo $iterator->key();
//$iterator->forward()
//$iterator->next();
//var_dump($iterator->current());

//foreach($iterator as $entry) {
//    print_r($entry);
//    print_r($entry->getEntry());
//    print_r($entry->getEvent());
//}

//$es->