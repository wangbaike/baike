<?php

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           InputParam.php
 * @package		Netbeans 8.0.2
 * @author		Administrator
 * @link		http://www.baikeshuo.cn
 * @datetime          2017-12-22 12:47:17
 */

namespace baike\tools;

class InputParam
{

    /**
     * 单例封装
     */
    private function __construct()
    {
        
    }

    /**
     * 获取GET值
     * 
     * @param string $param 索引值，空可以返回全部GET数组
     * @return false | value | array
     */
    public static function get($param = '')
    {
        if ($param == '') {
            return !empty($_GET) ? $_GET : false;
        } else {
            return isset($_GET[$param]) ? $_GET[$param] : false;
        }
    }

    /**
     * 获取POST值
     * 
     * @param string $param 索引值，空可以返回全部POST数组
     * @return false | value | array
     */
    public static function post($param = '')
    {
        if ($param == '') {
            return !empty($_POST) ? $_POST : false;
        } else {
            return isset($_POST[$param]) ? $_POST[$param] : false;
        }
    }

    /**
     * 获取SERVER值
     * 
     * @param string $param 索引值，空可以返回全部SERVER数组
     * @return false | value | array
     */
    public static function server($param = '')
    {
        if ($param == '') {
            return !empty($_SERVER) ? $_SERVER : false;
        } else {
            return isset($_SERVER[$param]) ? $_SERVER[$param] : false;
        }
    }

    /**
     * 获取COOKIE值
     * 
     * @param string $param 索引值，空可以返回全部COOKIE数组
     * @return false | value | array
     */
    public static function cookie($param = '')
    {
        if ($param == '') {
            return !empty($_COOKIE) ? $_COOKIE : false;
        } else {
            return isset($_COOKIE[$param]) ? $_COOKIE[$param] : false;
        }
    }

    /**
     * 获取SESSION值
     * 
     * @param string $param 索引值，空可以返回全部SESSION数组
     * @return false | value | array
     */
    public static function session($param = '')
    {
        if ($param == '') {
            return !empty($_SESSION) ? $_SESSION : false;
        } else {
            return isset($_SESSION[$param]) ? $_SESSION[$param] : false;
        }
    }

    /**
     * 设置SESSION值
     * 
     * @param type $key
     * @param type $value
     * @return type
     */
    public static function set_session($key, $value = '')
    {
        if (!is_array($key)) {
            $key = array($key => $value);
        }
        foreach ($key as $keyIndex => $keyItem) {
            $_SESSION[$keyIndex] = $keyItem;
        }
        return true;
    }

    /**
     * 设置SESSION值
     * 
     * @param type $key
     * @param type $value
     * @return type
     */
    public static function set_cookie($key, $value = '')
    {
        
    }

}
