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
                echo OutputParam::jsonRight(array('ok'));
                break;
            case 'get_qrcode':
                $imgUrl = $robot->qrcode(InputParam::session('uuid'));
                echo OutputParam::jsonRight(array('url' => $imgUrl));
                break;
            case 'get_login':
                $result = $robot->login(InputParam::session('uuid'));
                echo OutputParam::jsonRight(array('ok'));
                break;
            /**
             * 登录确认后操作
             * 
             * "data":{
             * "post_url_header":"https:\/\/wx.qq.com\/cgi-bin\/mmwebwx-bin",
             * "post":{
             *      "BaseRequest":{
             *          "Uin":"276036175",
             *          "Sid":"49CdJjISVmJNVxdx",
             *          "Skey":"@crypt_76d3bfc0_9dd019e237818756f1aea47cacf678f2",
             *          "DeviceID":"e962976072911621"
             *         },
             * "skey":"@crypt_76d3bfc0_9dd019e237818756f1aea47cacf678f2",
             * "pass_ticket":"SkUWlxjGB%2FBGJcdm24GEmHs1LJnPUj7C28W3S9EF%2B2A15ts6DnFsnvFUayyeLlTb",
             * "sid":"49CdJjISVmJNVxdx",
             * "uin":"276036175"
             * }}
             */
            case 'get_login_done':
                $callback = $robot->get_uri(InputParam::session('uuid'));
                //格式化后获取post数据
                $post = $robot->post_self($callback);
                //设置登录session
                InputParam::set_session(array('post_url_header' => $callback['post_url_header'], 'https_header' => $callback['https_header'], 'post' => $post));
                echo OutputParam::jsonRight(array('ok'));
                break;
            case 'get_login_init':
                $json = $robot->wxinit(InputParam::session('https_header'), InputParam::session('post'));
                InputParam::set_session(array('json' => $json));
                echo OutputParam::jsonRight(array('ok'));
                break;
            case 'get_wxstatusnotify'://
                $json = $robot->wxstatusnotify(InputParam::session('post'), InputParam::session('json'));
                InputParam::set_session(array('json' => $json));
                echo OutputParam::jsonRight(array('ok'));
                break;
            default:
                $userName = '百科';
                //var_dump(InputParam::session('uuid'));
                View::load('wxweb', array('isLogin' => $userName));
                break;
        }
    }

}
