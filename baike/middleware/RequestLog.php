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
use baike\tools\Log;
use baike\tools\InputParam;

/**
 * Description of RequestLog
 */
class RequestLog extends Middleware
{

    public static function record()
    {
        Log::add(InputParam::get(), Log::$NORMAL, 'requestLog');
    }

}
