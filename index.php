<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//注册自动加载类机制
if (!function_exists('BaikeClassLoader')) {
    require __DIR__ . DIRECTORY_SEPARATOR . 'baike' . DIRECTORY_SEPARATOR . 'BaikeClassLoader.php';
}
error_reporting(E_ALL);

use baike\Init;

Init::main();



