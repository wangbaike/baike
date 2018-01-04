<?php

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           Test.php
 * @package		Netbeans 8.0.2
 * @author		Administrator
 * @link		http://www.baikeshuo.cn
 * @datetime          2017-12-22 16:28:54
 */

namespace baike\module;

use baike\tools\NetTools;

class Test {

    public static function main() {
        self::fcTest();
    }

    private static function fcTest() {
        $url = 'https://weixin.huitour.cn/hcfangche/index.php/wxapp/lines/?';
        $result = NetTools::httpBuild($url, array('method' => 'lines.date'), array('price_type_id' => 7, 'login_key' => '944a2914b092ce2e34764313b555d9ce'));
        var_dump($result);
        print_r(json_decode($result, true));
    }

}
