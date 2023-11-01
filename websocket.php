<?php

use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\MessageComponentInterface;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require_once __DIR__ . "/vendor/autoload.php";

$chat = new class implements MessageComponentInterface {
    protected SplObjectStorage $connections;

    public function __construct()
    {
        $this->connections = new SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->connections->attach($conn);
        echo "New Connection" . PHP_EOL;
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        $conn->send("Error: {$e->getMessage()}");
        echo "Error: {$e->getMessage()}" . PHP_EOL;
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->connections->detach($conn);
        echo "Connection Closed" . PHP_EOL;
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "New Message " . (string) $msg . PHP_EOL;
        /** @var ConnectionInterface $connection */
        foreach ($this->connections as $connection) {
            if ($connection === $from) {
                continue;
            }

            $connection->send((string) $msg);
        }
    }
};

$server = IoServer::factory(new HttpServer(new WsServer($chat)), 8002);

$server->run();