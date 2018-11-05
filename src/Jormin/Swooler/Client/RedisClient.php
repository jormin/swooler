<?php
/**
 * Created by PhpStorm.
 * User: Jormin
 * Date: 2018/11/3
 * Time: 12:12 AM
 */

namespace Jormin\Swooler\Client;

use Jormin\Swooler\Base\BaseClient;

class RedisClient extends BaseClient
{

    /**
     * @var \swoole_redis
     */
    protected $redis;

    /**
     * @var string 数据库连接密码
     */
    protected $password;

    /**
     * @var int 数据库
     */
    protected $database;

    /**
     * RedisClient constructor.
     * @param $host
     * @param $port
     * @param null $password
     * @param int $database
     * @param float $timeout
     */
    public function __construct($host, $port, $password=null, $database=0, $timeout=1.5)
    {
        parent::__construct($host, $port, self::CLIENT_WEBSOCKET);
        $this->password = $password;
        $this->database = $database;
        $this->timeout = $timeout;
        $this->redis = new \swoole_redis([
            'timeout' => $this->timeout,
            'password' => $this->password,
            'database' => $this->database
        ]);
    }

    /**
     * 断开服务端连接
     * @param \swoole_redis $redis
     */
    public function onClose(\swoole_redis $redis){
        $this->debugLog('已断开服务端连接');
        $this->debugLog('');

        // TODO 连接服务端成功
    }

    /**
     * 收到消息
     * @param \swoole_redis $redis
     * @param array $message
     */
    public function onMessage(\swoole_redis $redis, array $message)
    {
        $this->debugLog('收到服务端消息');
        $this->debugLog('Message:'.json_encode($message));
        $this->debugLog('');
    }

    /**
     * @param null $callback
     */
    public function connect($callback=null){
        $this->redis->connect($this->host, $this->port, $callback ?? function(){
                $this->debugLog('连接服务器成功');
                $this->debugLog('');
            });
    }

    /**
     * 订阅
     * @param $topic
     * @param $fd
     */
    public function subscribe($topic, $fd){
        $this->redis->subscribe($topic);
        $this->redis->sadd('channel_'.$topic, $fd);
    }

    /**
     * 取消订阅
     * @param $topic
     * @param $fd
     */
    public function unsubscribe($topic, $fd){
        $this->redis->unsubscribe($topic);
        $this->redis->srem('channel_'.$topic, $fd);
    }

    /**
     * 发布消息
     * @param $topic
     * @param $message
     * @param $fd
     */
    public function publish($topic, $message, $fd){
        $this->redis->publish('channel_'.$topic, json_encode(['fd'=>$fd, 'message'=>$message]));
    }

    /**
     * 自动调用
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        $this->redis->$name($arguments);
    }
}