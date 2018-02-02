<?php

namespace baike\module;

use baike\libs\BaiException;
use baike\libs\DataModel;
use baike\tools\InputParam;
use baike\tools\UrlPath;
use baike\tools\NetTools;
use baike\tools\Func;

/**
 * Description of Qiubai
 *
 * @author Administrator
 */
class Qiubai {

    public static function main() {
        //print_r(InputParam::server());
        //echo UrlPath::siteUrl();
        self::showList();
//        $page = InputParam::get('page');
//        if ($page) {
//            //file_put_contents('./' . $page . '.txt', 'ddd');
//            self::init($page);
//        } else {
//            for ($i = 1; $i <= 1; $i++) {
//                NetTools::getBuild(UrlPath::siteUrl('qiubai?page=' . $i));
//            }
//        }
    }

    /**
     * 采集执行单元
     * @param type $i
     */
    private static function init($page) {
        $arr = self::getItemArrFromUrl($page);
        if ($arr) {
            self::addContent($arr);
            echo 'ok!<br/>';
        } else {
            echo 'Error===page ' . $page . ' no data<br/>';
        }
    }

    /**
     * 根据列表信息，保存内容
     * 
     * @name addContent
     * @param type $arr
     */
    private static function addContent($arr) {
        foreach ($arr as $value) {
            DataModel::getInstance('fun')->dbInsert(array('signId' => $value['signId'], 'age' => $value['age'], 'content' => $value['content'], 'fromUrl' => $value['fromUrl'], 'fromSite' => '糗事百科', 'addTime' => $value['addTime']));
        }
    }

    /**
     * 获取网页信息
     * 
     * @name getUrl
     * @param type $page
     * @return type
     */
    private static function getItemArrFromUrl($page) {
        $str = NetTools::getBuild('https://www.qiushibaike.com/text/page/' . $page);
        $regex4 = "/<article.*?<\/article>/ism";
        $allValues = array();
        if (preg_match_all($regex4, $str, $matches)) {
            foreach ($matches[0] as $matchesV) {
                $singleArr = array();
                //年龄
                $regename = "/<i class=\"age\">.*?<\/i>/ism";
                if (preg_match($regename, $matchesV, $matchesname)) {
                    $singleArr['age'] = Func::filterHtml($matchesname['0']);
                }
                //内容
                $regename = "/<a href=\"\/article\/.*?<\/a>/ism";
                if (preg_match($regename, $matchesV, $matchesname)) {
                    $singleArr['content'] = Func::filterHtml($matchesname['0']);
                }
                //来源地址
                $regename = "/\"\/article\/.*?class=\"text\"/ism";
                if (preg_match($regename, $matchesV, $matchesname)) {
                    if (preg_match("/\d+/", $matchesname['0'], $val)) {
                        $singleArr['fromUrl'] = 'https://www.qiushibaike.com/article/' . $val['0'];
                    }
                }
                if (!empty($singleArr)) {
                    $singleArr['signId'] = md5($singleArr['content']);
                    $singleArr['addTime'] = date('Y-m-d H:i:s', time());
                    $allValues[] = $singleArr;
                }
            }
            return $allValues;
        } else {
            throw new BaiException(__CLASS__ . ":网页抓取失败");
        }
    }

    private static function showList() {
        $conn = DataModel::getInstance('fun');
        $datas = $conn->dbSelectAllRow('*', array(), '', 'id', 'desc', 0, 60);
        if ($datas) {
            $str = '<table border="1">';
            $str .= '<tr><th>编号（' . count($datas) . '）</th><th>内容</th><th>年龄</th></tr>';
            foreach ($datas as $datasV) {
                $str .= '<tr><td>' . $datasV['id'] . '</td><td>' . $datasV['content'] . '</td><td>' . $datasV['age'] . '</td></tr>';
            }
            $str .= '</table>';
            echo $str;
        } else {
            throw new BaiException('没有查询到数据');
        }
    }

}
