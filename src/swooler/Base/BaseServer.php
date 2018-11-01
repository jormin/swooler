<?php
/**
 * Created by PhpStorm.
 * User: Jormin
 * Date: 2018/11/1
 * Time: 4:24 AM
 */

namespace Jormin\Swooler\Base;

class BaseServer extends BaseObject
{

    const SERVER_TCP = 'TCP';
    const SERVER_HTTP = 'HTTP';
    const SERVER_WEBSOCKET = 'WEBSOCKET';
    const SERVER_REDIS = 'REDIS';

    /**
     * @var \swoole_server
     */
    protected $server;

    /**
     * @var string 主机
     */
    protected $host;

    /**
     * @var int 端口
     */
    protected $port;

    /**
     * @var string 服务类型
     */
    protected $serverType;

    /**
     * @var int Worker数量
     */
    protected $workerNum;

    /**
     * @var int Task Worker 数量
     */
    protected $taskWorkerNum;

    /**
     * @var bool 是否以守护进程方式启动服务
     */
    protected $daemonize;

    /**
     * BaseServer constructor.
     * @param string $host
     * @param int $port
     * @param string $serverType
     * @param int $workerNum
     * @param int $taskWorkerNum
     * @param bool $daemonize
     */
    public function __construct($host="0.0.0.0", $port=8080, $serverType='tcp', $workerNum=2, $taskWorkerNum=2, $daemonize=false)
    {
        $this->host = $host;
        $this->port = $port;
        $this->serverType = $serverType;
        $this->workerNum = $workerNum;
        $this->taskWorkerNum = $taskWorkerNum;
        $this->daemonize = $daemonize;

        switch (strtoupper($this->serverType)){
            case 'HTTP':
                $serverClass = \swoole_http_server::class;
                break;
            case 'WEBSOCKET':
                $serverClass = \swoole_websocket_server::class;
                break;
            case 'REDIS':
                $serverClass = \swoole_redis_server::class;
                break;
            default:
                $serverClass = \swoole_server::class;
                break;
        }
        $this->server = new $serverClass($this->host, $this->port);
        $this->server->set([
            'task_worker_num' => $this->taskWorkerNum,
            'worker_num' => $this->workerNum,
            'daemonize' => $this->daemonize
        ]);

        $this->server->on('Start', [$this, 'onStart']);
        $this->server->on('Shutdown', [$this, 'onShutdown']);
        $this->server->on('ManagerStart', [$this, 'onManagerStart']);
        $this->server->on('ManagerStop', [$this, 'onManagerStop']);
        $this->server->on('WorkerStart', [$this, 'onWorkerStart']);
        $this->server->on('WorkerStop', [$this, 'onWorkerStop']);
        $this->server->on('WorkerError', [$this, 'onWorkerError']);
        $this->server->on('Task', [$this, 'onTask']);
        $this->server->on('Finish', [$this, 'onFinish']);
        $this->server->on('Close', [$this, 'onClose']);
        // Http 和 Redis server 不需要监听 Receive
        if($serverClass === \swoole_server::class){
            $this->server->on('Receive', [$this, 'onReceive']);
        }
        // Http server 不需要监听 Connect
        if($serverClass !== \swoole_http_server::class){
            $this->server->on('Connect', [$this, 'onConnect']);
        }
        // Http server 需要监听 Request
        if($serverClass === \swoole_http_server::class){
            $this->server->on('Request', [$this, 'onRequest']);
        }
        // Http server 需要监听 HandShake、Open 及 Message
        if($serverClass === \swoole_websocket_server::class){
            // 如果用户自定义了 onHandShake，则不会触发 onOpen
            if(method_exists(get_class($this), 'onHandShake')){
                $this->server->on('HandShake', [$this, 'onHandShake']);
            }else{
                $this->server->on('Open', [$this, 'onOpen']);
            }
            $this->server->on('Message', [$this, 'onMessage']);
        }

    }

    /**
     * @return \swoole_server
     */
    public function getServer(): \swoole_server
    {
        return $this->server;
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
     * @return string
     */
    public function getServerType(): string
    {
        return $this->serverType;
    }

    /**
     * @return int
     */
    public function getWorkerNum(): int
    {
        return $this->workerNum;
    }

    /**
     * @return int
     */
    public function getTaskWorkerNum(): int
    {
        return $this->taskWorkerNum;
    }

    /**
     * @return bool
     */
    public function isDaemonize(): bool
    {
        return $this->daemonize;
    }

    /**
     * 启动服务
     */
    public function start(){
        $this->server->start();
    }

    /**
     * 服务端启动成功
     * @param \swoole_server $server
     */
    public function onStart(\swoole_server $server){
        $this->debugLog('服务端启动成功');
        $this->debugLog('Host:'.$server->host);
        $this->debugLog('Port:'.$server->port);
        $this->debugLog('Master pid:'.$server->master_pid);
        $this->debugLog('');

        // TODO 服务端启动成功
    }

    /**
     * 服务端正常关闭
     * @param \swoole_server $server
     */
    public function onShutdown(\swoole_server $server){
        $this->debugLog('服务端正常关闭');
        $this->debugLog('');

        // TODO 服务端正常关闭
    }

    /**
     * 客户端连接
     * @param \swoole_server $server
     * @param int $fd
     * @param int $reactorId
     */
    public function onConnect(\swoole_server $server, int $fd, int $reactorId){
        $this->debugLog('客户端连接上了');
        $this->debugLog('FD:'.$fd);
        $this->debugLog('Reactor id:'.$reactorId);
        $this->debugLog('');

        // TODO 客户端连接
    }

    /**
     * 收到消息
     * @param \swoole_server $server
     * @param int $fd
     * @param int $reactorId
     * @param string $data
     */
    public function onReceive(\swoole_server $server, int $fd, int $reactorId, string $data){
        $this->debugLog('收到消息');
        $this->debugLog('FD:'.$fd);
        $this->debugLog('Reactor id:'.$reactorId);
        $this->debugLog('Message:'.$data);
        $this->debugLog('');

        // TODO 收到消息

    }

    /**
     * 客户端断开连接
     * @param \swoole_server $server
     * @param $fd
     * @param $reactorId
     */
    public function onClose(\swoole_server $server, $fd, $reactorId){
        $this->debugLog('客户端断开连接');
        $this->debugLog('FD:'.$fd);
        $this->debugLog('Reactor id:'.$reactorId);
        $this->debugLog('');

        // TODO 客户端断开连接
    }

    /**
     * 管理进程启动
     * @param \swoole_server $server
     */
    public function onManagerStart(\swoole_server $server){
        $this->debugLog('管理进程成功启动');
        $this->debugLog('Manager pid:'.$server->manager_pid);
        $this->debugLog('');

        // TODO 管理进程启动
    }

    /**
     * 管理进程关闭
     * @param \swoole_server $server
     */
    public function onManagerStop(\swoole_server $server){
        $this->debugLog('管理进程关闭');
        $this->debugLog('Manager pid:'.$server->manager_pid);
        $this->debugLog('');

        // TODO 管理进程关闭
    }

    /**
     * Worker启动
     * @param \swoole_server $server
     * @param int $workerId
     */
    public function onWorkerStart(\swoole_server $server, int $workerId){
        if($workerId >= $server->setting['worker_num']){
            $processName = 'task_worker_'.$workerId;
        }else{
            $processName = 'event_worker_'.$workerId;
        }
        swoole_set_process_name($processName);
        $this->debugLog('Worker '.$processName.' 启动');
        $this->debugLog('');

        // TODO Worker 启动
    }

    /**
     * Worker 退出
     * @param \swoole_server $server
     * @param int $workerId
     */
    public function onWorkerStop(\swoole_server $server, int $workerId){
        $this->debugLog('Worker '.$workerId.' 关闭');
        $this->debugLog('');

        // TODO Worker 退出
    }

    /**
     * Worker错误
     * @param \swoole_server $server
     * @param int $workerId
     * @param int $workerPid
     * @param int $exitCode
     * @param int $signal
     */
    public function onWorkerError(\swoole_server $server, int $workerId, int $workerPid, int $exitCode, int $signal){
        $this->debugLog('Worker '.$workerId.' 出现错误');
        $this->debugLog('Worker pid:'.$workerPid);
        $this->debugLog('Exit code:'.$exitCode);
        $this->debugLog('Signal:'.$signal);
        $this->debugLog('');

        // TODO Worker 错误
    }

    /**
     * 投递任务
     * @param \swoole_server $server
     * @param int $taskId
     * @param int $srcId
     * @param mixed $data
     */
    public function onTask(\swoole_server $server, int $taskId, int $srcId, mixed $data){
        $this->debugLog('投递任务');
        $this->debugLog('任务ID:'.$taskId);
        $this->debugLog('来源WorkerID:'.$srcId);
        $this->debugLog('数据:'.json_encode($data));
        $this->debugLog('');

        // TODO 投递任务
    }

    /**
     * 任务执行完毕
     * @param \swoole_server $server
     * @param int $taskId
     * @param mixed $data
     */
    public function onFinish(\swoole_server $server, int $taskId, mixed $data){
        $this->debugLog('任务执行完毕');
        $this->debugLog('任务ID:'.$taskId);
        $this->debugLog('数据:'.json_encode($data));
        $this->debugLog('');

        // TODO 任务执行完毕
    }

    /**
     * 接收到请求(Http和Websocket Server设置)
     * @param \swoole_http_request $request
     * @param \swoole_http_response $response
     */
    public function onRequest(\swoole_http_request $request, \swoole_http_response $response){
        $this->debugLog('接收到请求');
        $this->debugLog('FD:'.$request->fd);
        $this->debugLog('Header:'.json_encode($request->header));
        $this->debugLog('Cookie:'.json_encode($request->cookie));
        $this->debugLog('RawContent:'.$request->rawContent());
        $this->debugLog('Get:'.json_encode($request->get));
        $this->debugLog('Post:'.json_encode($request->post));
        $this->debugLog('Server:'.json_encode($request->server));
        $this->debugLog('Files:'.json_encode($request->files));
        $this->debugLog('');

        // TODO 接收到请求(Http和Websocket Server设置)
    }

    /**
     * 建立连接并完成握手(Websocket Server设置)
     * @param \swoole_websocket_server $server
     * @param \swoole_http_request $request
     */
    public function onOpen(\swoole_websocket_server $server, \swoole_http_request $request){
        $this->debugLog('建立连接并完成握手');
        $this->debugLog('FD:'.$request->fd);
        $this->debugLog('Header:'.json_encode($request->header));
        $this->debugLog('Cookie:'.json_encode($request->cookie));
        $this->debugLog('RawContent:'.$request->rawContent());
        $this->debugLog('Get:'.json_encode($request->get));
        $this->debugLog('Post:'.json_encode($request->post));
        $this->debugLog('Server:'.json_encode($request->server));
        $this->debugLog('Files:'.json_encode($request->files));
        $this->debugLog('');

        // TODO 建立连接并完成握手(Websocket Server设置)
    }

    /**
     * 接收到消息(Websocket Server设置)
     * @param \swoole_websocket_server $server
     * @param \swoole_websocket_frame $frame
     */
    public function onMessage(\swoole_websocket_server $server, \swoole_websocket_frame $frame){
        $this->debugLog('建立连接并完成握手');
        $this->debugLog('FD:'.$frame->fd);
        $this->debugLog('Opcode:'.$frame->opcode);
        $frame->opcode === WEBSOCKET_OPCODE_TEXT && $this->debugLog('Data:'.$frame->data);
        $this->debugLog('Finish:'.$frame->finish);
        $this->debugLog('');

        // TODO 接收到消息(Websocket Server设置)
    }

}