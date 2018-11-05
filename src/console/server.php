<?php

namespace console;

use Jormin\Swooler\Server\WebsocketServer;

require_once __DIR__.'/index.php';

$webSocketClient = new WebsocketServer('127.0.0.1', 666);
$webSocketClient->start();
