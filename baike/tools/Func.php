<?php

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           Functions.php
 * @package		Netbeans 8.0.2
 * @author		wbk
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-1-3 21:43:39
 */

namespace baike\tools;

/**
 * Description of Functions
 */
class Func {

    /**
     * 截取字符串
     * 
     * @param $length 截取的个数
     * @return string
     */
    public static function cutStr($strings, $length, $attrstr = '...') {
        if (strlen($strings) <= $length) {
            return $strings;
        }
        $start = 0;
        $str = substr($strings, $start, $length);
        $char = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            if (ord($str[$i]) >= 128)
                $char++;
        }
        $str2 = substr($strings, $start, $length + 1);
        $str3 = substr($strings, $start, $length + 2);
        if ($char % 3 == 1) {
            return $str3 . $attrstr;
        }
        if ($char % 3 == 2) {
            return $str2 . $attrstr;
        }
        if ($char % 3 == 0) {
            return $str . $attrstr;
        }
    }

    /**
     * 过滤html标签
     * 
     * @param type $str
     * @return string
     */
    public static function filterHtml($str) {
        $str = str_ireplace("\n", '', $str);
        $str = str_ireplace("\t", '', $str);
        return preg_replace('/<[^>]+>/iU', '', $str);
    }

}
