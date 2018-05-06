<?php

namespace baike\model;

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           Demos.php
 * @package		Netbeans 8.0.2
 * @author		wbk
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-5-5 21:27:17
 */
use baike\framework\model\DataModel;

/**
 * 测试数据模型
 */
class Fun extends DataModel
{

    function __construct()
    {
        parent::__construct(0);
        $this->setTable('fun');
    }

    /**
     * 实例化对象存储
     * @var type 
     */
    private static $instance = null;

    /**
     * 快速调用模型，省略实例化过程
     * @return object
     */
    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}
