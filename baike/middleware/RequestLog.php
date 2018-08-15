<?php

namespace baike\middleware;

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           RequestLog.php
 * @package		Netbeans 8.0.2
 * @author		wbk
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-5-1 19:21:24
 */
use baike\framework\tools\Log;
use baike\framework\tools\InputParam;

/**
 * Description of RequestLog
 */
class RequestLog extends Middleware
{

    public static function record()
    {
        $server = InputParam::server();
        $msgArr = [];
        //服务器端
        $msgArr[] = $server['SERVER_PROTOCOL'];
        $msgArr[] = $server['REQUEST_METHOD'];
        $msgArr[] = $server['REQUEST_URI'];
        $msgArr[] = $server['QUERY_STRING'];
        $msgArr[] = (isset($server['SERVER_NAME']) ? $server['SERVER_NAME'] : $server['SERVER_ADDR']) . ':' . $server['SERVER_PORT'];
        //客户端
        $msgArr[] = $server['REMOTE_ADDR'] . ':' . $server['REMOTE_PORT'];
        $msgArr[] = $server['HTTP_USER_AGENT'];
        $msgArr[] = isset($server['HTTP_REFERER']) ? $server['HTTP_REFERER'] : '--';
        Log::add(implode("\t", $msgArr), Log::$NORMAL, 'request_log');
    }

}
