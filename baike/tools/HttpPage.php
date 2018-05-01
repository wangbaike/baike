<?php

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           HttpPage.php
 * @package		Netbeans 8.0.2
 * @author		wbk
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-5-1 16:40:02
 */

namespace baike\tools;

use baike\tools\View;

/**
 * Description of HttpPage
 */
class HttpPage
{

    /**
     * 404页面
     */
    public static function show_404()
    {
        View::load('common/404');
    }

}
