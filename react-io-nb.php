<?php
use React\EventLoop\Loop;
use React\Stream\DuplexResourceStream;
use React\Stream\ReadableResourceStream;

require_once __DIR__ . "/vendor/autoload.php";

$loop = Loop::get();
$streamList = [
    new ReadableResourceStream(stream_socket_client("tcp://localhost:8000")),
    new ReadableResourceStream(fopen("file1.txt", "r")),
    new ReadableResourceStream(fopen("file2.txt", "r")),
];

$http = new DuplexResourceStream(stream_socket_client("tcp://localhost:8080"));
$http->write("GET /http-server.php HTTP/1.1\r\n\r\n");
$http->on("data", function (string $data) {
    $requestBodyPosition = strpos($data, "\r\n\r\n");
    echo substr($data, $requestBodyPosition + 4);
}); 

foreach ($streamList as $stream) {
    $stream->on("data", function (string $data) {
        echo $data . PHP_EOL;
    });
}


$loop->run();