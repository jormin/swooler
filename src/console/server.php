<?php

namespace console;

use Jormin\Swooler\Tcp\TcpServer;

require_once __DIR__.'/index.php';

$client = new TcpServer('127.0.0.1', 9999);
$client->start();
