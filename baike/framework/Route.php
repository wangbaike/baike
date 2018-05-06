<?php

namespace baike\framework;

use baike\framework\tools\InputParam; //全局输入加载
use baike\framework\exception\BaiException; //加载异常类
use baike\framework\tools\HttpPage; //http错误页面
use baike\framework\Core;
use baike\framework\tools\Log;

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

    /**
     * 路由入口
     * @throws BaiException
     */
    public static function main()
    {
        try {
            self::init();
        } catch (BaiException $exc) {
            Log::add($exc->getFile() . ' on line ' . $exc->getLine() . ' -> ' . $exc->getErrorCode() . ':' . $exc->getMessage(), Log::$NORMAL, 'route');
            header("Content-type: text/html; charset=utf-8");
            echo implode('<br/>', get_included_files());
            echo '<br/><br/>' . $exc->getMessage();
        } catch (\Exception $e) {
            Log::add($e->getFile() . ' on line ' . $e->getLine() . ' -> ' . $e->getCode() . ':' . $e->getMessage(), Log::$NORMAL, 'route');
            header("Content-type: text/html; charset=utf-8");
            echo implode('<br/>', get_included_files());
            echo '<br/><br/>' . $e->getMessage();
        } finally {
            //这里可以记录每一次日志
        }
    }

    /**
     * 执行类
     * @param string $classPath 类路径
     * @param string $method 执行的方法
     * @throws BaiException
     */
    private static function invokeClass($classPath, $method)
    {
        $obj = new \ReflectionClass($classPath);
        if ($obj->hasMethod($method)) {
            //程序执行之前加载中间件
            Core::runMiddleClass();
            //执行要执行的类库
            $instance = new \ReflectionMethod($classPath, $method);
            $instance->invoke(new $classPath());
        } else {
            HttpPage::show_404();
        }
    }

    /**
     * 从url中获取模块名称
     * 
     * @return string
     */
    private static function init()
    {
        $pathInfo = InputParam::server('PATH_INFO');
        //设置默认控制器和方法
        $basePath = "\baike\\" . self::$controllerPath;
        $defaultController = $basePath . DIRECTORY_SEPARATOR . 'Home';
        $defaultMethod = 'index';
        if ($pathInfo) {
            $isFindClass = FALSE;
            $pathArr = explode('/', trim($pathInfo, '/'));
            foreach ($pathArr as $key => $param) {
                $controller = $basePath . DIRECTORY_SEPARATOR . ucfirst($param);
                if (class_exists($controller)) {
                    $isFindClass = TRUE;
                    $defaultController = $controller;
                    //获取要执行的方法
                    $defaultMethod = isset($pathArr[$key + 1]) ? $pathArr[$key + 1] : $defaultMethod;
                    //设置GET参数
                    self::setGetParams($pathArr, $key);
                } else {
                    $basePath .= DIRECTORY_SEPARATOR . $param;
                }
            }
            //如果没有找到要执行的文件则执行404
            if (FALSE === $isFindClass) {
                HttpPage::show_404();
                return;
            }
        }
        //执行控制器
        self::invokeClass($defaultController, $defaultMethod);
    }

    /**
     * 设置路径上的其它参数为GET参数
     * @param array $pathArr
     * @param int $key
     */
    private static function setGetParams($pathArr, $key)
    {
        $beginKey = $key + 2;
        if (isset($pathArr[$beginKey])) {
            $getPathArr = array_slice($pathArr, $beginKey);
            $ignore = false;
            foreach ($getPathArr as $newKey => $val) {
                if ($ignore) {
                    $ignore = false;
                    continue;
                } else {
                    $_GET[$val] = isset($getPathArr[$newKey + 1]) ? $getPathArr[$newKey + 1] : '';
                    $ignore = true;
                }
            }
        }
    }

}
