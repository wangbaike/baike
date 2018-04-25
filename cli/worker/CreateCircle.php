<?php

namespace cli\worker;

use baike\tools\InputParam;

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           CreateCircle.php
 * @package		Netbeans 8.0.2
 * @author		wbk
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-4-25 21:34:35
 */

/**
 * Description of CreateCircle
 */
class CreateCircle
{

    public function run()
    {
        $i = 20;
        while ($i) {
            echo $i . PHP_EOL;
            print_r(InputParam::get());
            sleep(1);
            $i--;
        }
    }

}
