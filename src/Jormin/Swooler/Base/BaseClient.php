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

    const CLIENT_TCP = 'TCP';
    const CLIENT_HTTP = 'HTTP';
    const CLIENT_WEBSOCKET = 'WEBSOCKET';
    const CLIENT_REDIS = 'REDIS';
    const CLIENT_MYSQL = 'MYSQL';

    /**
     * @var mixed
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
     * @var float 超时时间，SwooleClient、SwooleMysql和SwooleRedis使用
     */
    protected $timeout;

    /**
     * @var string 客户端类型
     */
    protected $clientType;

    /**
     * BaseClient constructor.
     * @param $host
     * @param $port
     * @param string $clientType
     */
    public function __construct($host, $port, $clientType='TCP')
    {
        $this->host = $host;
        $this->port = $port;
        $this->clientType = strtoupper($clientType);
    }
}