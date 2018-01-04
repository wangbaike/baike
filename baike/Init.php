<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace baike;

use baike\libs\BaiException;
use baike\module;
use baike\tools\InputParam;

class Init {

    public static function main() {
        try {
            header("Content-type: text/html; charset=utf-8");
            switch (self::getPathName()) {
                //糗百视频采集模块
                case 'qiubai':
                    module\Qiubai::main();
                    break;
                //测试模块
                case 'test':
                    module\Test::main();
                    break;
                default:
                    throw new BaiException('404 Not found page');
            }
        } catch (BaiException $exc) {
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
