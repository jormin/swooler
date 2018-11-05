<?php
/**
 * Created by PhpStorm.
 * User: Jormin
 * Date: 2018/11/3
 * Time: 12:06 AM
 */

namespace Jormin\Swooler\Client;

use Jormin\Swooler\Base\BaseClient;

class MySQLClient extends BaseClient
{

    /**
     * @var \swoole_mysql
     */
    protected $client;

    /**
     * @var string 数据库账号
     */
    protected $username;

    /**
     * @var string 数据库连接密码
     */
    protected $password;

    /**
     * @var string 数据库
     */
    protected $database;

    /**
     * @var string 指定字符集
     */
    protected $charset;

    /**
     * MySQLClient constructor.
     * @param $host
     * @param $port
     * @param string $username
     * @param $password
     * @param $database
     * @param string $charset
     * @param float $timeout
     */
    public function __construct($host, $port, $username, $password, $database, $charset='utf8', $timeout=1.0)
    {
        parent::__construct($host, $port, self::CLIENT_WEBSOCKET);
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->charset = $charset;
        $this->timeout = $timeout;
        $this->client = new \swoole_mysql();
    }

    /**
     * 断开服务端连接
     * @param \swoole_mysql $mysql
     */
    public function onClose(\swoole_mysql $mysql){
        $this->debugLog('已断开服务端连接');
        $this->debugLog('');

        // TODO 连接服务端成功
    }

    /**
     * 连接服务器
     * @param null $callback
     */
    public function connect($callback=null){
        $this->client->connect([
            'host' => $this->host,
            'port' => $this->port,
            'user' => $this->username,
            'password' => $this->password,
            'database' => $this->database,
            'charset' => $this->charset,
            'timeout' => $this->timeout
        ], $callback ?? function(){
                $this->debugLog('连接服务器成功');
                $this->debugLog('');
            });
    }

}