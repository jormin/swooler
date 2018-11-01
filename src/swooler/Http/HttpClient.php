<?php
/**
 * Created by PhpStorm.
 * User: Jormin
 * Date: 2018/11/1
 * Time: 5:51 AM
 */

namespace Jormin\Swooler\Http;


use Jormin\Swooler\Base\BaseClient;

class HttpClient extends BaseClient
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
    }

}