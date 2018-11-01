<?php
/**
 * Created by PhpStorm.
 * User: Jormin
 * Date: 2018/11/1
 * Time: 4:06 AM
 */

namespace Jormin\Swooler\WebSocket;

use Jormin\Swooler\Base\BaseServer;

class WebsocketServer extends BaseServer
{

    /**
     * WebsocketServer constructor.
     * @param string $host
     * @param int $port
     * @param int $workerNum
     * @param int $taskWorkerNum
     * @param bool $daemonize
     */
    public function __construct($host = "0.0.0.0", $port = 8080, $workerNum = 2, $taskWorkerNum = 2, $daemonize = false)
    {
        parent::__construct($host, $port, self::SERVER_WEBSOCKET, $workerNum, $taskWorkerNum, $daemonize);
    }

    /**
     * 连接成功并且握手成功
     * @param \swoole_websocket_server $server
     * @param \swoole_http_request $request
     */
    public function onOpen(\swoole_websocket_server $server, \swoole_http_request $request)
    {
        parent::onOpen($server, $request);
    }

    /**
     * 收到消息
     * @param \swoole_websocket_server $server
     * @param \swoole_websocket_frame $frame
     */
    public function onMessage(\swoole_websocket_server $server, \swoole_websocket_frame $frame)
    {
        parent::onMessage($server, $frame);
    }

}