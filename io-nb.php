<?php

$streamList = [
    stream_socket_client("tcp://localhost:8080"),
    stream_socket_client("tcp://localhost:8000"),
    fopen("file1.txt", "r"),
    fopen("file2.txt", "r"),
];

fwrite($streamList[0], "GET /http-server.php HTTP/1.1" . PHP_EOL . PHP_EOL);

/*
// Sync

foreach ($streamList as $stream) {
    echo stream_get_contents($stream);
    fclose($stream);
}

*/
// Async

foreach ($streamList as $stream) {
    stream_set_blocking($stream, false);
}

do {
    // echo "while" . PHP_EOL;
    $streamListCopy = $streamList;
    $countStreams = stream_select($streamListCopy, $write, $except, 0, 200000);

    if ($countStreams === 0) {
        continue;
    }

    foreach ($streamListCopy as $key => $stream) {
        echo stream_get_contents($stream);
        fclose($stream);
        unset($streamList[$key]);
    }
} while (!empty($streamList));