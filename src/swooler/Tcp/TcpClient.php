<?php
/**
 * Created by PhpStorm.
 * User: Jormin
 * Date: 2018/10/31
 * Time: 2:04 PM
 */

namespace Jormin\Swooler\Tcp;

use Jormin\Swooler\Base\BaseClient;

class TcpClient extends BaseClient
{

    /**
     * TcpClient constructor.
     * @param $host
     * @param $port
     * @param int $isSync
     * @param float $timeout
     * @param int $flag
     */
    public function __construct($host, $port, $isSync = SWOOLE_SOCK_ASYNC, $timeout = 0.1, $flag = 0)
    {
        parent::__construct($host, $port, SWOOLE_SOCK_TCP, $isSync, $timeout, $flag);
    }

    /**
     * 收到服务端消息
     * @param \swoole_client $client
     * @param string $data
     */
    public function onReceive(\swoole_client $client, string $data)
    {
        parent::onReceive($client, $data);
        $this->send();
    }

    /**
     * 发送消息
     */
    public function send(){
        fwrite(STDOUT, date('Y-m-d H:i:s').' 请输入要发送给服务端的消息:');
        $message = trim(fgets(STDIN));
        $this->log('发送消息:'.$message);
        $this->client->send($message);
        $this->log('');
    }
}