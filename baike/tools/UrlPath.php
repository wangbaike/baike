<?php

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           UrlPath.php
 * @package		Netbeans 8.0.2
 * @author		wbk
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-1-3 20:59:35
 */

namespace baike\tools;

use baike\tools\InputParam;
use baike\configs\Config;

/**
 * Description of UrlPath
 */
class UrlPath {

    /**
     * 访问网址
     * 
     * @param string $urlParam 网址参数
     * @return string
     */
    public static function siteUrl($urlParam = '') {
        return self::baseUrl(Config::$indexPage . ($urlParam ? '/' . $urlParam : ''));
    }

    /**
     * 系统网页目录，不带indexPage参数
     * 
     * @param string $urlParam 地址参数
     * @return string
     */
    public static function baseUrl($urlParam = '') {
        $server = InputParam::server();
        $http = $server['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        return $http . $server['HTTP_HOST'] . str_ireplace(Config::$indexPage, '', $server['SCRIPT_NAME']) . $urlParam;
    }

}
