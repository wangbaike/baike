<?php

header("Content-type: text/html; charset=utf-8");
/**
 * 设置警告级别
 */
error_reporting(E_ALL);
/**
 * 定义框架程序路径
 */
define('BASE_PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
/**
 * 定义系统根路径
 */
define('APP_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'baike' . DIRECTORY_SEPARATOR);
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




