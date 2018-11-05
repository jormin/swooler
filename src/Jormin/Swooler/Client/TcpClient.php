<?php
/**
 * Created by PhpStorm.
 * User: Jormin
 * Date: 2018/10/31
 * Time: 2:04 PM
 */

namespace Jormin\Swooler\Client;

use Jormin\Swooler\Base\BaseClient;

class TcpClient extends BaseClient
{

    /**
     * @var \swoole_client
     */
    protected $client;

    /**
     * @var int 是否同步，SwooleClient专用
     */
    protected $isSync;

    /**
     * @var int flag，SwooleClient专用
     */
    protected $flag;

    /**
     * TcpClient constructor.
     * @param $host
     * @param $port
     * @param int|string $isSync
     * @param float $timeout
     * @param int $flag
     */
    public function __construct($host, $port, $isSync = SWOOLE_SOCK_ASYNC, $timeout = 0.1, $flag = 0)
    {
        parent::__construct($host, $port, self::CLIENT_TCP);
        $this->isSync = $isSync;
        $this->timeout = $timeout;
        $this->flag = $flag;
        $this->client = new \swoole_client(SWOOLE_SOCK_TCP, $this->isSync);
        $this->client->on('Connect', [$this, 'onConnect']);
        $this->client->on('Receive', [$this, 'onReceive']);
        $this->client->on('Error', [$this, 'onError']);
        $this->client->on('Close', [$this, 'onClose']);
    }

    /**
     * 连接上服务端
     * @param \swoole_client $client
     */
    public function onConnect(\swoole_client $client){
        $this->debugLog('连接服务端成功');
        $socket = $client->getsockname();
        $this->debugLog('Host:'.$socket['host']);
        $this->debugLog('Port:'.$socket['port']);
        $this->debugLog('');

        // TODO 连接服务端成功
    }

    /**
     * 收到服务端消息
     * @param \swoole_client $client
     * @param string $data
     */
    public function onReceive(\swoole_client $client, string $data){
        $this->debugLog('收到服务端消息:'.$data);
        $this->debugLog('');

        $this->send();
    }

    /**
     * 客户端出错
     * @param \swoole_client $client
     */
    public function onError(\swoole_client $client){
        $this->debugLog('客户端出错:');
        $this->debugLog('错误码:'.$client->errCode);
        $this->debugLog('');

        // TODO 客户端出错
    }

    /**
     * 客户端断开连接
     * @param \swoole_client $client
     */
    public function onClose(\swoole_client $client){
        $this->debugLog('已断开与服务端的连接');
        $this->debugLog('');

        // TODO 客户端断开连接
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

    /**
     * 连接服务器
     */
    public function connect(){
        if(!$this->client->connect($this->host, $this->port, $this->timeout, $this->flag)){
            $this->log('连接服务端失败');
            $this->log('');
        }
    }
}