<?php

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           OutputStream.php
 * @package		Netbeans 8.0.2
 * @author		Administrator
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-2-5 13:12:17
 */

namespace baike\tools;

use baike\configs\Errcode; //加载异常代码库
use baike\libs\BaiException; //加载异常类

class OutputParam {

    private static $_INSTANCE = null;

    /**
     * 实例化对象
     * 
     * @return type
     */
    private static function getInstance() {
        if (self::$_INSTANCE == null) {
            self::$_INSTANCE = new OutputParam();
        }
        return self::$_INSTANCE;
    }

    /**
     * 输出正确的数据
     * 
     * @param type $data
     * @return type
     */
    public static function jsonRight($data) {
        return self::getInstance()->outJson(array('err_code' => 0, 'data' => $data, 'msg' => ''));
    }

    /**
     * 输出错误的数据
     * 
     * @param type $errCode 错误码
     * @param type $errMsg 错误信息
     * @return type
     */
    public static function jsonError($errCode, $errMsg = '') {
        return self::getInstance()->outJson(array('err_code' => $errCode, 'data' => array(), 'msg' => $errMsg));
    }

    /**
     * 输出json字符串
     * 
     * @param array $data
     * @return type
     * @throws BaiException
     */
    private function outJson($data = array()) {
        if (!is_array($data)) {
            throw new BaiException(Errcode::$dataNotArray);
        }
        return json_encode($data);
    }

}
