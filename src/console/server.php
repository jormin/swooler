<?php

namespace console;

use Jormin\Swooler\Server\WebsocketServer;

require_once __DIR__.'/index.php';

// 由Docker映射出去端口，这里监听IP一定要注意写 0.0.0.0，否则外部客户端连接会出现未收到握手消息前就断开连接
$webSocketClient = new WebsocketServer('0.0.0.0', 9999);
$webSocketClient->start();
