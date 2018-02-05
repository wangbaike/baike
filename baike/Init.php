<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace baike;

use baike\controller; //加载控制器内类
use baike\tools\InputParam; //全局输入加载
use baike\configs\Errcode; //加载异常代码库
use baike\libs\BaiException; //加载异常类

session_start();

class Init {

    public static function main() {
        try {
            //header("Content-type: text/html; charset=utf-8");
            switch (self::getPathName()) {
                //糗百视频采集模块
                case 'qiubai':
                    controller\Qiubai::main();
                    break;
                //测试模块
                case 'test':
                    controller\Test::main();
                    break;
                //微信模块
                case 'wx':
                    controller\Weixinrobot::main();
                    break;
                default:
                    throw new BaiException(Errcode::$pageNotFind);
            }
        } catch (BaiException $exc) {
            header("Content-type: text/html; charset=utf-8");
            echo implode('<br/>', get_included_files());
            echo '<br/><br/>' . $exc->getMessage();
        }
    }

    /**
     * 从url中获取模块名称
     * 
     * @return string
     */
    private static function getPathName() {
        $pathInfo = InputParam::server('PATH_INFO');
        $pathArr = explode('/', trim($pathInfo, '/'));
        return $pathArr['0'];
    }

}
