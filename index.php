<?php

//注册自动加载类机制
if (!function_exists('BaikeClassLoader')) {
    require __DIR__ . DIRECTORY_SEPARATOR . 'baike' . DIRECTORY_SEPARATOR . 'BaikeClassLoader.php';
}

use baike\Init;

/**
 * 设置警告级别
 */
error_reporting(E_ALL);
/**
 * 定义当前系统路径
 */
define('APP_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
/**
 * 定义系统文件夹路径
 */
define('SYS_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'baike' . DIRECTORY_SEPARATOR);
/**
 * 初始化系统
 */
Init::main();



