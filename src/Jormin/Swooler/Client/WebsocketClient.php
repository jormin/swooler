<?php
/**
 * Created by PhpStorm.
 * User: Jormin
 * Date: 2018/11/1
 * Time: 5:48 AM
 */

namespace Jormin\Swooler\Client;


use Jormin\Swooler\Base\BaseClient;

class WebsocketClient extends BaseClient
{

    /**
     * @var \swoole_http_client
     */
    protected $client;

    /**
     * @var bool 是否启用SSL/TLS隧道加密
     */
    protected $ssl;

    /**
     * WebsocketClient constructor.
     * @param $host
     * @param $port
     * @param bool $ssl
     * @param float $timeout
     */
    public function __construct($host, $port, $ssl=false, $timeout=0.5)
    {
        parent::__construct($host, $port, self::CLIENT_WEBSOCKET);
        $this->ssl = $ssl;
        $this->timeout = $timeout;
        $this->client = new \swoole_http_client($this->host, $this->port);
        $this->client->on('Message', [$this, 'onMessage']);
        $this->client->on('Close', [$this, 'onClose']);
    }

    /**
     * 连接服务器
     */
    public function connect(){
        $this->client->upgrade('/', function (\swoole_http_client $client) {
            print_r($client->body);
        });
    }

    /**
     * 收到服务端消息
     * @param \swoole_http_client $client
     * @param \swoole_websocket_frame $frame
     */
    public function onMessage(\swoole_http_client $client, \swoole_websocket_frame $frame)
    {
        $this->debugLog('收到服务端消息:');
        $this->debugLog('FD:'.$frame->fd);
        $this->debugLog('Opcode:'.$frame->opcode);
        $frame->opcode === WEBSOCKET_OPCODE_TEXT && $this->debugLog('Data:'.$frame->data);
        $this->debugLog('Finish:'.$frame->finish);
        $this->debugLog('');
        $this->send();
    }

    /**
     * 客户端断开连接
     * @param \swoole_http_client $client
     */
    public function onClose(\swoole_http_client $client){
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
        $this->client->push($message);
        $this->log('');
    }

}