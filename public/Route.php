<?php

use baike\tools\InputParam; //全局输入加载
use baike\configs\Errcode; //加载异常代码库
use baike\libs\BaiException; //加载异常类

/**
 * 系统路由
 * @author Administrator
 */

class Route
{

    /**
     * 控制器所在目录，如果有多个
     * @var type 
     */
    private static $controllerPath = 'controller';

    public static function main()
    {
        try {
            list($className, $method) = self::getClass();
            $classPath = "\baike\\" . self::$controllerPath . DIRECTORY_SEPARATOR . $className;
            if (class_exists($classPath)) {
                $obj = new ReflectionClass($classPath);
                if ($obj->hasMethod($method)) {
                    $instance = new ReflectionMethod($classPath, $method);
                    $instance->invoke(new $classPath());
                } else {
                    throw new BaiException(Errcode::$methodNotFind);
                }
            } else {
                throw new BaiException(Errcode::$classNotFind);
            }
        } catch (BaiException $exc) {
            header("Content-type: text/html; charset=utf-8");
            echo implode('<br/>', get_included_files());
            echo '<br/><br/>' . $exc->getMessage();
        }
    }

    /**
     * 从url中获取模块名称
     * 
     * @return string
     */
    private static function getClass()
    {
        $pathInfo = InputParam::server('PATH_INFO');
        //设置默认控制器和方法
        $defaultController = 'Home';
        $defaultMethod = 'index';
        if ($pathInfo) {
            $pathArr = explode('/', trim($pathInfo, '/'));
            $defaultController = isset($pathArr['0']) ? $pathArr['0'] : 'Home';
            $defaultMethod = isset($pathArr['1']) ? $pathArr['1'] : 'Index';
            //get参数
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
        }
        return [ucfirst($defaultController), $defaultMethod];
    }

}
