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
 * @datetime          2018-2-5 9:28:09
 */

namespace baike\controller;

use baike\libs\WeixinWebApi;
use baike\tools\View;
use baike\tools\InputParam;
use baike\tools\OutputParam;

class Weixinrobot {

    //OutputParam::jsonError('1001', '参数错误');//OutputParam::jsonRight($data)
    public static function main() {
        $action = InputParam::get('a');
        $robot = WeixinWebApi::getInstance();
        switch ($action) {
            case 'get_uuid':
                $uuid = $robot->get_uuid();
                InputParam::set_session(array('uuid' => $uuid));
                echo OutputParam::jsonRight($uuid);
                break;
//            case 'get_qrcode':
//                $imgUrl = $robot->qrcode(InputParam::session('uuid'));
//                echo OutputParam::jsonRight(array('url' => $imgUrl));
//                break;
            case 'get_login':
                $result = $robot->login(InputParam::session('uuid'));
                echo OutputParam::jsonRight($result);
                break;
            case 'get_login_done'://登陆后操作
                $callback = $robot->get_uri(InputParam::session('uuid'));
                //格式化后获取post数据
                $post = $robot->post_self($callback);
                //file_put_contents('./post.txt', json_decode($post));
                //设置登录session
                InputParam::set_session(array('post_url_header' => $callback['post_url_header'], 'https_header' => $callback['https_header'], 'post' => $post));
                echo OutputParam::jsonRight('ok');
                break;
            case 'get_login_init'://初始化操作
                $json = $robot->wxinit(InputParam::session('https_header'), InputParam::session('post'));
                InputParam::set_session(array('json' => $json));
                echo OutputParam::jsonRight('ok');
                break;
            case 'get_wxstatusnotify'://
                $json = $robot->wxstatusnotify(InputParam::session('post'), InputParam::session('json'));
                InputParam::set_session(array('json' => $json));
                echo OutputParam::jsonRight('ok');
                break;
            case 'get_synccheck'://心跳检测
                $json = InputParam::session('json');
                $jsonArr = json_decode($json, true);
                $result = $robot->synccheck(InputParam::session('post'), $jsonArr['SyncKey']);
                //InputParam::set_session(array('json' => $json));
                echo OutputParam::jsonRight($result);
                break;
            default:
                $userName = '百科';
                $json = InputParam::session('json');
                $jsonArr = json_decode($json, true);
                print_r($jsonArr['SyncKey']);
                $isLogin = 0;
                //var_dump($jsonArr['BaseResponse']['Ret']);
                if ($jsonArr['BaseResponse']['Ret'] === 0) {
                    $isLogin = 1;
                }
                View::load('wxweb', array('isLogin' => $isLogin, 'json' => $jsonArr));
                break;
        }
    }

}