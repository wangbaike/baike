<?php

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           View.php
 * @package		Netbeans 8.0.2
 * @author		Administrator
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-2-2 11:16:37
 */

namespace baike\tools;

use baike\configs\Config; //加载配置文件
use baike\configs\Errcode; //加载异常代码库
use baike\libs\BaiException; //加载异常类
use baike\tools\UrlPath; //加载路径

class View
{

    private static $_INSTANCE = null;

    /**
     * 实例化对象
     * 
     * @return type
     */
    private static function getInstance()
    {
        if (self::$_INSTANCE == null) {
            self::$_INSTANCE = new View();
        }
        return self::$_INSTANCE;
    }

    /**
     * 加载模板文件
     * 
     * @param type $tplName 模板名称，不带文件后缀
     * @param type $param 要传入的参数数组
     * @param type $ext 文件后缀名，不带“.”
     * @throws BaiException
     */
    public static function load($tplName, $param = array(), $ext = 'php')
    {
        if (!is_array($param)) {
            throw new BaiException(Errcode::$paramViewTypeError);
        }
        $file_path = APP_PATH . Config::getInstance()->getViewDir() . DIRECTORY_SEPARATOR . $tplName . '.' . $ext;
        if (file_exists($file_path)) {
            extract($param);
            include $file_path;
        } else {
            throw new BaiException(Errcode::$fileNotFindView);
        }
    }

    /**
     * 加载css目录中css文件
     * 
     * @param type $fileName css文件名
     * echo string
     */
    public static function loadCss($fileName)
    {
        echo self::getInstance()->loadAssetsFile($fileName, 'css');
    }

    /**
     * 加载js目录中js文件
     * 
     * @param type $fileName js文件名
     * echo string
     */
    public static function loadJs($fileName)
    {
        echo self::getInstance()->loadAssetsFile($fileName, 'js');
    }

    /**
     * 加载assets目录中的自定义文件
     * 
     * @param type $fileName 文件名带后缀
     * echo string
     */
    public static function loadAssets($fileName)
    {
        echo self::getInstance()->loadAssetsFile($fileName);
    }

    /**
     * 加载附件文件夹的内容
     * 
     * @param type $fileName 文件名可以带目录
     * @param type $ext 文件后缀
     * @return string
     * @throws BaiException
     */
    private function loadAssetsFile($fileName, $ext = '')
    {
        is_array($fileName) or $fileName = array($fileName);
        $html = '';
        foreach ($fileName as $fileNameVal) {
            if (preg_match("/^(http|https){1}(:\/\/){1}.*$/i", $fileNameVal)) {
                $html .= $this->loadUrl($fileNameVal);
            } else {
                if ($ext) {
                    $fileNameVal = $ext . '/' . $fileNameVal;
                }
                $file_path = Config::getInstance()->getAssetsDir() . '/' . $fileNameVal . ($ext ? '.' . $ext : '');
                $local_path = WEB_PATH . $file_path;
                if (file_exists($local_path)) {
                    switch ($ext) {
                        case 'css':
                        case 'CSS':
                            $html .= '<link href="' . UrlPath::baseUrl($file_path) . '" rel="stylesheet" type="text/css" />';
                            break;
                        case 'js':
                        case 'JS':
                            $html .= '<script type="text/javascript" src="' . UrlPath::baseUrl($file_path) . '"></script>';
                            break;
                        default:
                            $html .= UrlPath::baseUrl($file_path);
                            break;
                    }
                } else {
                    throw new BaiException(Errcode::$fileNotFindAssets);
                }
            }
        }
        return $html ? $html : false;
    }

    /**
     * 加载http链接
     * 
     * @param type $url
     * @return type
     */
    private function loadUrl($url)
    {
        $last_str = substr($url, -3);
        $html = '';
        switch ($last_str) {
            case 'css':
            case 'CSS':
                $html .= '<link href="' . $url . '" rel="stylesheet" type="text/css" />';
                break;
            case '.js':
            case '.JS':
                $html .= '<script type="text/javascript" src="' . $url . '"></script>';
                break;
            default:
                $html .= $url;
                break;
        }
        return $html ? $html : false;
    }

}
