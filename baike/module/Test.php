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
        exit;
        $url = 'https://weixin.huitour.cn/hcfangche/index.php/wxapp/admin/?';
        $result = NetTools::httpBuild($url, array('method' => 'price_type.add_price'), array(
                    'price_type_id' => 7,
                    'name' => '预付定金可享5000优惠',
                    'remark' => '1. 支付成功，可享受福建全景八日游5000元现金优惠。<br/>2.以5人/车18800为例，立减5000，优惠价13800，余款需支付11800元',
                    'price' => 2000,
                    'start_time' => '2018-01-20',
                    'end_time' => '2018-01-27',
                    'total_num' => 10));
        var_dump($result);
        print_r(json_decode($result, true));
    }

}
