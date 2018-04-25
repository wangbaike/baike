<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace baike\configs;

/**
 * Description of Database
 *
 * @author wbk
 */
class Database {

    public static function getDBs() {
        //本地测试数据库
        $dbIndex = 0;
        $database = array();
        $database[$dbIndex]['dbHost'] = 'localhost';
        $database[$dbIndex]['dbPort'] = 3306;
        $database[$dbIndex]['dbName'] = 'baike';
        $database[$dbIndex]['dbUser'] = 'root';
        $database[$dbIndex]['dbPwd'] = 'root';
        $database[$dbIndex]['dbCharset'] = 'utf8';
        $database[$dbIndex]['dbPrev'] = 'bk_';

        //百度云数据库
        $dbIndex++;
        $database[$dbIndex]['dbHost'] = 'sqld.duapp.com';
        $database[$dbIndex]['dbPort'] = 4050;
        $database[$dbIndex]['dbName'] = 'XJVfFeCawfOCxGqXJYUs';
        $database[$dbIndex]['dbUser'] = '8204d3c2ad144bf89c1ad2326271b31f';
        $database[$dbIndex]['dbPwd'] = '91f642a0cff440b3b947c3373dff5f69';
        $database[$dbIndex]['dbCharset'] = 'utf8';
        $database[$dbIndex]['dbPrev'] = 'bk_';

        //本地数据库
        $dbIndex ++;
        $database[$dbIndex]['dbHost'] = 'localhost';
        $database[$dbIndex]['dbPort'] = 3306;
        $database[$dbIndex]['dbName'] = 'tongji';
        $database[$dbIndex]['dbUser'] = 'root';
        $database[$dbIndex]['dbPwd'] = 'root';
        $database[$dbIndex]['dbCharset'] = 'utf8';
        $database[$dbIndex]['dbPrev'] = '';
        return $database;
    }

}
