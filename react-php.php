<?php
use React\EventLoop\Loop;

require_once __DIR__ . "/vendor/autoload.php";

// $eventLoop = Loop::get();
// $eventLoop->addPeriodicTimer(1, function() {
//     echo "1 second" . PHP_EOL;
// });

// $eventLoop->run();

Loop::addPeriodicTimer(1, function () {
    echo "1 second" . PHP_EOL;
});