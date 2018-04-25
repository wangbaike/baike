<?php

header("Content-type: text/html; charset=utf-8");
/**
 * 设置警告级别
 */
error_reporting(E_ALL);
/**
 * 定义前端路径
 */
define('WEB_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
/**
 * 定义程序目录
 */
define('APP_PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'baike' . DIRECTORY_SEPARATOR);
/**
 * 加载全局脚本
 */
require APP_PATH . DIRECTORY_SEPARATOR . 'bootstrap.php';
/**
 * 加载路由
 */
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Route.php';
/**
 * 初始化系统
 */
Route::main();




