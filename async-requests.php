<?php
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;


require_once __DIR__ ."/vendor/autoload.php";

$client = new Client();

/*
// Sync
$response1 = $client->get("localhost:8080/http-server.php");
$response2 = $client->get("localhost:8000/http-server.php");

echo "Resposta 1 : {$response1->getBody()->getContents()}";
echo "Resposta 2 : {$response2->getBody()->getContents()}";
*/

// Async
$promisse1 = $client->getAsync("localhost:8080/http-server.php");
$promisse2 = $client->getAsync("localhost:8000/http-server.php");

$responses = Utils::unwrap([$promisse1, $promisse2]);

echo "Resposta 1 : {$responses[0]->getBody()->getContents()}";
echo "Resposta 2 : {$responses[1]->getBody()->getContents()}";