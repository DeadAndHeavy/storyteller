<?php

namespace App\Core\Service;

use \Hoa\Websocket\Client as WebSocketClient;
use \Hoa\Socket\Client as SocketClient;

class WebSocketService
{
    protected $client;

    public function connect()
    {
        if (is_null($this->client)) {
            $this->client = new WebSocketClient(
                new SocketClient('ws://' . config('websocket.server_ip') . ':' . config('websocket.server_port'))
            );
            $this->client->connect();
        }

        return $this->client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function send($message)
    {
        $this->client->send($message);
    }
}