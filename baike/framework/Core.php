<?php

namespace baike\framework;

use baike\framework\tools\Log;
use baike\configs\AutoLoad;

/**
 * Description of Core
 *
 * @author Administrator
 */
class Core
{

    /**
     * WEB端初始化操作，加载路由
     */
    public static function run()
    {
        //加载中间件配置
        self::loadMiddleClass();
        //执行路由
        Route::main();
    }

    /**
     * 添加中间件类库
     * @param string $classPath 类的名称，请加上完整路径，例：\baike\libs\LoginCheck
     * @param string $method 要执行的方法，支持对象的静态方法和常规方法
     * @return boolean
     */
    private static function loadMiddleClass()
    {
        if (false === self::get('middleClass')) {
            self::set('middleClass', []);
        }
        $middleClass = self::get('middleClass');
        $middleWares = AutoLoad::getInstance()->getMiddleWares();
        if (!empty($middleWares)) {
            foreach ($middleWares as $classPath => $method) {
                $sign = $classPath . '|' . $method;
                if (!in_array($sign, $middleClass)) {
                    $middleClass[] = $sign;
                }
            }
            self::set('middleClass', $middleClass);
        }
        return true;
    }

    /**
     * 执行所有中间件类库
     * @return type
     */
    public static function runMiddleClass()
    {
        if (false === self::get('middleClass')) {
            return false;
        } else {
            foreach (self::get('middleClass') as $classStr) {
                $classArr = explode('|', $classStr);
                list($classPath, $method) = $classArr;
                $obj = new \ReflectionClass($classPath);
                if ($obj->hasMethod($method)) {
                    $instance = new \ReflectionMethod($classPath, $method);
                    $instance->invoke(new $classPath());
                } else {
                    Log::add('找不到中间件的方法->' . $classStr, Log::$ERROR, Log::$FRAMEWORK_ERROR);
                }
            }
        }
    }

    /**
     * 往容器中添加东西
     * @param string|int $index 索引值
     * @param all $val 要放的数据
     * @return boolean
     */
    public static function set($index, $val = '')
    {
        self::getInstance()->container[$index] = $val;
        return true;
    }

    /**
     * 从容器中取出东西
     * @param string|int $index 索引值
     * @return boolean|all
     */
    public static function get($index)
    {
        if (isset(self::getInstance()->container[$index])) {
            return self::getInstance()->container[$index];
        }
        return false;
    }

    /**
     * 这是个大容器，能容纳一切，里面要合理分类利用
     * @var type 
     */
    private $container = array();

    /**
     * 单例对象
     * @var type 
     */
    private static $_INSTANCE = null;

    /**
     * 私有化构造方法，封装成模式
     */
    private function __construct()
    {
        
    }

    /**
     * 实例化对象
     * 
     * @return type
     */
    private static function getInstance()
    {
        if (self::$_INSTANCE == null) {
            self::$_INSTANCE = new self();
        }
        return self::$_INSTANCE;
    }

}
