<?php
/**
 * Created by PhpStorm.
 * User: Jormin
 * Date: 2018/11/1
 * Time: 4:06 AM
 */

namespace Jormin\Swooler\Server;

use Jormin\Swooler\Base\BaseServer;

class WebsocketServer extends BaseServer
{

    /**
     * @var
     */
    protected $openCallback;

    /**
     * @var
     */
    protected $messageCallback;

    /**
     * WebsocketServer constructor.
     * @param string $host
     * @param int $port
     * @param null $openCallback
     * @param null $messageCallback
     * @param int $workerNum
     * @param int $taskWorkerNum
     * @param bool $daemonize
     */
    public function __construct($host = "0.0.0.0", $port = 8080, $openCallback=null, $messageCallback=null, $workerNum = 2, $taskWorkerNum = 2, $daemonize = false)
    {
        parent::__construct($host, $port, self::SERVER_WEBSOCKET, $workerNum, $taskWorkerNum, $daemonize);
        $this->openCallback = $openCallback;
        $this->messageCallback = $messageCallback;
    }

    /**
     * 连接成功并且握手成功
     * @param \swoole_websocket_server $server
     * @param \swoole_http_request $request
     */
    public function onOpen(\swoole_websocket_server $server, \swoole_http_request $request)
    {
        parent::onOpen($server, $request);
        $server->push($request->fd, 'hello '.$request->fd);
        if($this->openCallback){
            call_user_func($this->openCallback, $request);
        }
    }

    /**
     * 收到消息
     * @param \swoole_websocket_server $server
     * @param \swoole_websocket_frame $frame
     */
    public function onMessage(\swoole_websocket_server $server, \swoole_websocket_frame $frame)
    {
        parent::onMessage($server, $frame);
        $server->push($frame->fd, '收到消息:'.$frame->data);
        if($this->messageCallback){
            call_user_func($this->messageCallback, $frame);
        }
    }

}