<?php

namespace cli\worker;

use baike\framework\tools\InputParam;

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           PHPtest.php
 * @package		Netbeans 8.0.2
 * @author		wbk
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-4-26 21:04:35
 */

/**
 * Description of CreateCircle
 */
class PHPtest
{

    /**
     * 程序执行方法
     */
    public function run()
    {
        $i = 30;
        while ($i) {
            echo $i . PHP_EOL;
            sleep(1);
            $i--;
        }
    }

}
