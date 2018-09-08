<?php

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           AutoLoad.php
 * @package		Netbeans
 * @author		Administrator
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-8-5 10:35:39
 */

namespace baike\configs;

/**
 * 自动加载配置文件，支持中间件加载
 */
class AutoLoad
{

    /**
     * 加载中间件
     * 数据类型为 类库名称 => 执行方法（支持静态和非静态）
     * 例："\baike\middleware\RequestLog" => "record"
     * @var type 
     */
    private $middleWares = [
        "\baike\middleware\RequestLog" => "record"
    ];

    /**
     * 返回中间件配置
     * 
     * @return array
     */
    public function getMiddleWares()
    {
        return $this->middleWares;
    }

    private static $_INSTANCE = null; //实例化

    /**
     * 实例化本类
     * 
     * @return type
     */

    public static function getInstance()
    {
        if (self::$_INSTANCE === null) {
            self::$_INSTANCE = new self();
        }
        return self::$_INSTANCE;
    }

}
