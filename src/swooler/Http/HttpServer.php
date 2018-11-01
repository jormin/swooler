<?php
/**
 * Created by PhpStorm.
 * User: Jormin
 * Date: 2018/11/1
 * Time: 5:23 AM
 */

namespace Jormin\Swooler\Http;

use Jormin\Swooler\Base\BaseServer;

class HttpServer extends BaseServer
{

    /**
     * HttpServer constructor.
     * @param string $host
     * @param int $port
     * @param int $workerNum
     * @param int $taskWorkerNum
     * @param bool $daemonize
     */
    public function __construct($host = "0.0.0.0", $port = 8080, $workerNum = 2, $taskWorkerNum = 2, $daemonize = false)
    {
        parent::__construct($host, $port, self::SERVER_HTTP, $workerNum, $taskWorkerNum, $daemonize);
    }

    /**
     * 收到请求
     * @param \swoole_http_request $request
     * @param \swoole_http_response $response
     */
    public function onRequest(\swoole_http_request $request, \swoole_http_response $response)
    {
        parent::onRequest($request, $response);
    }

}