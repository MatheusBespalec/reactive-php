<?php

$socket = stream_socket_server("tcp://localhost:8000", $errorCode, $errorMessage);

$con = stream_socket_accept($socket);

$sleepTime = rand(1, 5);
sleep($sleepTime);
fwrite($con, "Resposta do socket após {$sleepTime} segundos");