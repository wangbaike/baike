<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace baike\framework\tools;

use baike\framework\exception\BaiException;
use baike\framework\tools\InputParam;

class NetTools
{

    /**
     * 建立http连接
     * 
     * @param string $apiUrl
     * @param array $getArr
     * @param array $postArr
     * @param array $header
     * @return string
     * @throws BaiException
     */
    public static function httpBuild($apiUrl = '', $getArr = array(), $postArr = array(), $header = array())
    {
        if ($apiUrl != '') {
            $server = InputParam::server();
            $getStr = is_array($getArr) && !empty($getArr) ? http_build_query($getArr) : '';
            //http头信息
            $headerArr = array();
            $headerArr[] = "Accept: " . (isset($server['HTTP_ACCEPT']) ? $server['HTTP_ACCEPT'] : "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8");
            $headerArr[] = "User-Agent:" . (isset($server['HTTP_USER_AGENT']) ? $server['HTTP_USER_AGENT'] : "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.75 Safari/537.36");
            $headerArr[] = "Accept-Encoding:" . (isset($server['HTTP_ACCEPT_ENCODING']) ? $server['HTTP_ACCEPT_ENCODING'] : "gzip,deflate,sdch");
            $headerArr[] = "Accept-Language:" . (isset($server['HTTP_ACCEPT_LANGUAGE']) ? $server['HTTP_ACCEPT_LANGUAGE'] : "zh-CN,zh;q=0.8");
            if (!empty($header)) {
                $headerArr = array_merge($headerArr, $header);
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl . $getStr);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            if (count($postArr)) {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postArr);
            }
            $strRes = curl_exec($ch);
            curl_close($ch);
            if ($strRes['curl_error']) {
                throw new BaiException(__CLASS__ . ":curl error code " . $strRes['curl_error']);
            }
            return $strRes;
        } else {
            throw new BaiException(__CLASS__ . ":api url is null");
        }
    }

    /**
     * 以post方式提交请求
     * 
     * @param string $url
     * @param array|string $data
     * @return bool|mixed
     */
    public static function httpPost($url, $data)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, self::_buildPost($data));
        list($content, $status) = array(curl_exec($curl), curl_getinfo($curl), curl_close($curl));
        return (intval($status["http_code"]) === 200) ? $content : false;
    }

    /**
     * POST数据过滤处理
     * 
     * @param array $data
     * @return array
     */
    static private function _buildPost(&$data)
    {
        if (is_array($data)) {
            foreach ($data as &$value) {
                if (is_string($value) && $value[0] === '@' && class_exists('CURLFile', false)) {
                    $filename = realpath(trim($value, '@'));
                    file_exists($filename) && $value = new CURLFile($filename);
                }
            }
        }
        return $data;
    }

    /**
     * 建立socket连接
     * 
     * @param string $urlStr 地址，可以带端口
     * @param boolean $isResult 是否需要接收结果，默认不接收
     * @return boolean
     * @throws BaiException
     */
    public static function socketBuild($urlStr, $isResult = false)
    {
        $url = parse_url($urlStr);
        $query = '';
        if (isset($url['query'])) {
            $query .= $url['path'] . "?" . $url['query'];
        } else {
            if (isset($url['path'])) {
                $query .= $url['path'];
            } else {
                $query .= '/';
            }
        }
        $fp = fsockopen($url['host'], isset($url['port']) ? $url['port'] : 80, $errno, $errstr, 30);
        if (!$fp) {
            throw new BaiException("socket error " . $errno . ' ' . $errstr);
        } else {
            $result = '';
            $request = "GET $query HTTP/1.1\r\n";
            $request .= "Host:" . $url['host'] . "\r\n";
            $request .= "Connection: Close\r\n";
            $request .= "\r\n";
            fwrite($fp, $request);
            if ($isResult) {
                while (!@feof($fp)) {
                    $result .= @fgets($fp, 1024);
                }
            }
            fclose($fp);
            return $result;
        }
    }

    /**
     * 建立get连接
     * 
     * @param type $urlStr
     * @return type
     */
    public static function getBuild($urlStr)
    {
        return file_get_contents($urlStr);
    }

}
