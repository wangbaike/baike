<?php

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           Errcode.php
 * @package		Netbeans 8.0.2
 * @author		Administrator
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-2-5 10:06:37
 */

namespace baike\configs;

class Errcode
{

    /**
     * 加载|模板文件找不到
     * @var array 
     */
    public static $fileNotFindView = array('code' => 1101, 'message' => '找不到模板文件');

    /**
     * 加载|页面找不到
     * @var array 
     */
    public static $pageNotFind = array('code' => 1201, 'message' => '找不到页面');

    /**
     * 加载|模板传入参数错误
     * @var array 
     */
    public static $paramViewTypeError = array('code' => 1301, 'message' => '模板传入参数错误');

    /**
     * 加载|附件文件找不到
     * @var array 
     */
    public static $fileNotFindAssets = array('code' => 1401, 'message' => '找不到附件文件');

    /**
     * 参数类型|参数类型应是数组
     * @var array 
     */
    public static $dataNotArray = array('code' => 1501, 'message' => '参数类型应是数组');

    /**
     * 加载文件|找不到对应的控制器
     * @var array 
     */
    public static $classNotFind = array('code' => 1601, 'message' => '找不到对应的控制器');

    /**
     * 加载文件|找不到控制器对应的执行方法
     * @var array 
     */
    public static $methodNotFind = array('code' => 1602, 'message' => '找不到控制器对应的执行方法');

}
