<?php
/**
 * Created by PhpStorm.
 * User: Jormin
 * Date: 2018/10/31
 * Time: 2:09 PM
 */

namespace Jormin\Swooler\Traits;

trait LogTrait
{

    /**
     * 打印日志
     * @param $msg string $msg 消息日志
     * @param bool $debug 是否调试日志，调试日志仅在开启调试模式后才会打印
     */
    public function log($msg, $debug=false){
        if(!($debug && DEBUG)){
            return;
        }
        echo date('Y-m-d H:i:s').' '.$msg.PHP_EOL;
    }

    /**
     * 打印调试日志
     * @param $msg string $msg 消息日志
     */
    public function debugLog($msg){
        $this->log($msg, true);
    }

}