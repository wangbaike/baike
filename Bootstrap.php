<?php

/**
 * 自动加载函数，以根目录为起始目录，加载里面的包
 * @param string $class 需要加载的类库
 */
function baikeClassLoader($class)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = dirname(__DIR__) . DIRECTORY_SEPARATOR . $path . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
//    if (0 === stripos($class, 'cli\\')) {
//        $path = str_replace('cli\\', '\\', $class);
//        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
//        $file = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'cli' . $path . '.php';
//        if (file_exists($file)) {
//            require_once $file;
//        }
//    }
}

spl_autoload_register('baikeClassLoader');
