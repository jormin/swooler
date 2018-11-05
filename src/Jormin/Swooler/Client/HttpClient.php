<?php
/**
 * Created by PhpStorm.
 * User: Jormin
 * Date: 2018/11/1
 * Time: 5:51 AM
 */

namespace Jormin\Swooler\Client;


use Jormin\Swooler\Base\BaseClient;

class HttpClient extends BaseClient
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
     * HttpClient constructor.
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
    }

    /**
     * @param null $callback
     */
    public function connect($callback=null){
        $this->client->connect([
            'host' => $this->host,
            'port' => $this->port,
            'user' => $this->user,
            'password' => $this->password,
            'database' => $this->database,
            'charset' => $this->charset,
            'timeout' => $this->timeout
        ], $callback);
    }

}