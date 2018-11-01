<?php

namespace console;

use Jormin\Swooler\Tcp\TcpClient;

require_once __DIR__.'/index.php';

$client = new TcpClient('127.0.0.1', 9999);
$client->connect();
