<?php

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           WeixinRobot.php
 * @package		Netbeans 8.0.2
 * @author		Administrator
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-2-25 20:20:09
 */

namespace baike\controller;

//use baike\libs\WeixinWebApi;
use baike\tools\View;
use baike\tools\InputParam;
use baike\tools\OutputParam;
use baike\model\DataModel;

class Tongji {

    //OutputParam::jsonError('1001', '参数错误');//OutputParam::jsonRight($data)
    public static function main() {
        $action = InputParam::get('a');
//        $robot = WeixinWebApi::getInstance();
        switch ($action) {
            case 'get_uuid':
                $uuid = $robot->get_uuid();
                InputParam::set_session(array('uuid' => $uuid));
                echo OutputParam::jsonRight($uuid);
                break;
            default:
//                $datas = DataModel::getInstance('hxl_people')->dbSelectAllRow('*', array());
//                //print_r($datas);
//                $result = array('dateCount' => array());
//
//                foreach ($datas as $datasV) {
//                    $ymd = date('Ymd', $datasV['add_time']);
//                    if (!isset($result['dateCount'][$ymd])) {
//                        $result['dateCount'][$ymd] = 1;
//                    } else {
//                        $result['dateCount'][$ymd] ++;
//                    }
//                }
//                $str = '';
//                foreach ($result['dateCount'] as $key => $value) {
//                    $str .= $key . ',' . $value . "\n";
//                }
//                print_r($result['dateCount']);
//                echo $str;
                $arr = file("./hxl_people.csv");
                $str = '';
                foreach ($arr as $arrV) {
                    if ($arrV) {
                        $arrV = str_ireplace('"', '', $arrV);
                        $s = explode(",", $arrV);
                        $str .= $s['0'] . ',' . $s['1'] . ',\'' . $s['2'] . ',\'' . $s['3'] . ',' . $s['4'] . ','
                                . $s['5'] . ',' . $s['6'] . ',\'' . $s['7'] . ',' . $s['8'] . ',' . $s['9'] . ','
                                . $s['10'] . ',' . $s['11'] . ',' . $s['12'] . ',' . $s['13'] . ',' . $s['14'] . ',' . $s['15'];
                    }
                }
                file_put_contents('2.csv', $str);
                break;
        }
    }

}
