<?php
/**
 * Created by PhpStorm.
 * User: Jormin
 * Date: 2018/11/1
 * Time: 4:26 AM
 */

namespace Jormin\Swooler\Base;


class BaseClient extends BaseObject
{

    /**
     * @var \swoole_client
     */
    protected $client;

    /**
     * @var string 主机
     */
    protected $host;

    /**
     * @var int 端口
     */
    protected $port;

    /**
     * @var int 服务类型
     */
    protected $sockType;

    /**
     * @var int 是否同步
     */
    protected $isSync;

    /**
     * @var float 超时时间
     */
    protected $timeout;

    /**
     * @var int flag
     */
    protected $flag;

    /**
     * BaseClient constructor.
     * @param $host
     * @param $port
     * @param int $sockType
     * @param int $isSync
     * @param float $timeout
     * @param int $flag
     */
    public function __construct($host, $port, $sockType=SWOOLE_SOCK_TCP, $isSync = SWOOLE_SOCK_ASYNC, $timeout=0.1, $flag=0)
    {
        $this->host = $host;
        $this->port = $port;
        $this->sockType = $sockType;
        $this->isSync = $isSync;
        $this->timeout = $timeout;
        $this->flag = $flag;

        $this->client = new \swoole_client($this->sockType, $this->isSync);
        $this->client->on('Connect', [$this, 'onConnect']);
        $this->client->on('Receive', [$this, 'onReceive']);
        $this->client->on('Error', [$this, 'onError']);
        $this->client->on('Close', [$this, 'onClose']);
    }

    /**
     * @return \swoole_client
     */
    public function getClient(): \swoole_client
    {
        return $this->client;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return int
     */
    public function getSockType(): int
    {
        return $this->sockType;
    }

    /**
     * @return int
     */
    public function getisSync(): int
    {
        return $this->isSync;
    }

    /**
     * @return float
     */
    public function getTimeout(): float
    {
        return $this->timeout;
    }

    /**
     * @return int
     */
    public function getFlag(): int
    {
        return $this->flag;
    }

    /**
     * 连接
     */
    public function connect(){
        if(!$this->client->connect($this->host, $this->port, $this->timeout, $this->flag)){
            $this->log('连接服务端失败');
            $this->log('');
        }
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

        // TODO 收到服务端消息
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
}