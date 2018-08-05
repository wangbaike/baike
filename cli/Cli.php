<?php

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           cli.php
 * @package		Netbeans 8.0.2
 * @author		wbk
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-4-25 21:17:02
 */
header("Content-type: text/html; charset=utf-8");
/**
 * 设置警告级别
 */
error_reporting(E_ALL);
/**
 * 定义程序目录
 */
define('APP_PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'baike' . DIRECTORY_SEPARATOR);
/**
 * 加载全局脚本
 */
require APP_PATH . 'framework' . DIRECTORY_SEPARATOR . 'Bootstrap.php';

use baike\framework\exception\BaiException;
use baike\framework\exception\Errcode;
use baike\framework\tools\Log;

try {
    //脚本参数检测
    if (!isset($argv[1])) {
        throw new BaiException('not find class to run');
    }
    //GET参数传入
    $pathArr = $argv;
    if (count($pathArr) > 2) {
        foreach ($pathArr as $key => $val) {
            if ($key < 2) {
                continue;
            }
            if ($key % 2 === 0) {
                $_GET[$val] = isset($pathArr[$key + 1]) ? $pathArr[$key + 1] : '';
            } else {
                continue;
            }
        }
    }
    //查找要操作的文件
    $className = str_ireplace('/run', '', $argv[1]);
    $method = 'run';
    $classPath = 'cli\\' . str_ireplace("/", "\\", $className);
    $obj = new ReflectionClass($classPath);
    if ($obj->hasMethod($method)) {
        $instance = new ReflectionMethod($classPath, $method);
        $instance->invoke(new $classPath());
    } else {
        throw new BaiException(Errcode::$methodNotFind);
    }
} catch (Exception $e) {
    Log::add($e->getFile() . ' on line ' . $e->getLine() . ' -> ' . $e->getCode() . ':' . $e->getMessage(), Log::$ERROR, Log::$FRAMEWORK_ERROR);
}

