<?php
/**
 * Created by PhpStorm.
 * User: Jormin
 * Date: 2018/10/31
 * Time: 1:51 PM
 */

namespace Jormin\Swooler\Tcp;

use Jormin\Swooler\Base\BaseServer;

class TcpServer extends BaseServer {

    /**
     * TcpServer constructor.
     * @param string $host
     * @param int $port
     * @param int $workerNum
     * @param int $taskWorkerNum
     * @param bool $daemonize
     */
    public function __construct($host = "0.0.0.0", $port = 8080, $workerNum = 2, $taskWorkerNum = 2, $daemonize = false)
    {
        parent::__construct($host, $port, self::SERVER_TCP, $workerNum, $taskWorkerNum, $daemonize);
    }

    /**
     * 客户端连接
     * @param \swoole_server $server
     * @param int $fd
     * @param int $reactorId
     */
    public function onConnect(\swoole_server $server, int $fd, int $reactorId){
        parent::onConnect($server, $fd, $reactorId);
        $this->send($fd, '你好，客户端【'.$fd.'】');
    }

    /**
     * 收到消息
     * @param \swoole_server $server
     * @param int $fd
     * @param int $reactorId
     * @param string $data
     */
    public function onReceive(\swoole_server $server, int $fd, int $reactorId, string $data)
    {
        parent::onReceive($server, $fd, $reactorId, $data);
        $this->send($fd, '你好，客户端【'.$fd.'】, 服务端收到了你的消息:'.$data);
    }

    /**
     * Worker启动
     * @param \swoole_server $server
     * @param int $workerId
     */
    public function onWorkerStart(\swoole_server $server, int $workerId){
        parent::onWorkerStart($server, $workerId);
    }

    /**
     * 发送消息
     * @param $fd
     * @param $data
     */
    public function send($fd, $data){
        if(!$this->server->send($fd, $data)){
            $this->debugLog('发送消息失败');
        }else{
            $this->debugLog('发送消息成功，消息：'.$data);
        }
    }

}