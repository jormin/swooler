<?php

namespace console;

use Jormin\Swooler\Client\WebsocketClient;

require_once __DIR__.'/index.php';

$client = new WebsocketClient('0.0.0.0', 9999);
$client->connect();
