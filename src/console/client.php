<?php

namespace console;

use Jormin\Swooler\Client\WebsocketClient;

require_once __DIR__.'/index.php';

$client = new WebsocketClient('127.0.0.1', 666);
$client->connect();
