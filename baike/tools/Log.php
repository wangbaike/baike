<?php

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           Log.php
 * @package		Netbeans 8.0.2
 * @author		wbk
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-5-1 17:28:01
 */

namespace baike\tools;

/**
 * Description of Log
 */
class Log
{

    /**
     * 日志信息级别 错误
     * @var int 
     */
    public static $ERROR = 0;

    /**
     * 日志信息级别 警告
     * @var int 
     */
    public static $WARNING = 1;

    /**
     * 日志信息级别 正常
     * @var int 
     */
    public static $NORMAL = 2;

    /**
     * 添加日志记录
     * @param string $msg 日志信息
     * @param int $level 日志等级
     * @param string $logFile 日志文件
     */
    public static function add($msg, $level = 0, $logFile = 'logs')
    {
        $dirPath = APP_PATH . 'data' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . date('Ymd');
        if (!is_dir($dirPath)) {
            mkdir($dirPath);
        }
        $filePath = $dirPath . DIRECTORY_SEPARATOR . $logFile . '.log';
        $prevStr = '';
        switch ($level) {
            case self::$ERROR:
                $prevStr .= "[Error]";
                break;
            case self::$WARNING:
                $prevStr .= "[Warning]";
                break;
            case self::$NORMAL:
                $prevStr .= "[Normal]";
                break;
            default:
                break;
        }
        $prevStr .= date('Y-m-d H:i:s') . "\n";
        $logString = '';
        if (is_array($msg) || is_object($msg)) {
            $logString = var_export($msg, true);
        } else {
            $logString = $msg;
        }
        $handle = fopen($filePath, 'a+');
        fwrite($handle, $prevStr . $logString . "\n");
        fclose($handle);
    }

}
