<?php

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           Config.php
 * @package		Netbeans 8.0.2
 * @author		wbk
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-1-3 21:13:38
 */

namespace baike\configs;

/**
 * Description of Config
 */
class Config {

    /**
     * 网站入口文件，可以为空
     * 默认为 index.php
     * @var type 
     */
    private $indexPage = 'index.php';
    private $viewDir = 'view';
    private static $_INSTANCE = null; //实例化

    /**
     * 实例化本类
     * 
     * @return type
     */

    public static function getInstance() {
        if (self::$_INSTANCE === null) {
            self::$_INSTANCE = new Config();
        }
        return self::$_INSTANCE;
    }

    /**
     * 返回入口文件
     * 
     * @return type
     */
    public function getIndexPage() {
        return $this->indexPage;
    }

    /**
     * 获取模板文件夹名称
     * @return type
     */
    public function getViewDir() {
        return $this->viewDir;
    }

}
