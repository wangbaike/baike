<?php

function BaikeClassLoader($class)
{
    if (0 === stripos($class, 'baike\\')) {
        $path = str_replace('baike\\', '\\', $class);
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
        $file = __DIR__ . DIRECTORY_SEPARATOR . $path . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
}

spl_autoload_register('BaikeClassLoader');
