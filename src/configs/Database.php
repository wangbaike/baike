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
class Database
{

    public static function getDBs()
    {
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
        $database[$dbIndex]['sqlLog'] = 1; //记录sql日志 0-不记录，1-记录
        //return $database;

        $dbIndex ++;
        $database[$dbIndex]['dbHost'] = 'localhost';
        $database[$dbIndex]['dbPort'] = 3306;
        $database[$dbIndex]['dbName'] = 'baikedoc';
        $database[$dbIndex]['dbUser'] = 'root';
        $database[$dbIndex]['dbPwd'] = 'root';
        $database[$dbIndex]['dbCharset'] = 'utf8';
        $database[$dbIndex]['dbPrev'] = '';
        $database[$dbIndex]['sqlLog'] = 1; //记录sql日志 0-不记录，1-记录
        
         $dbIndex ++;
        $database[$dbIndex]['dbHost'] = 'localhost';
        $database[$dbIndex]['dbPort'] = 3306;
        $database[$dbIndex]['dbName'] = 'hc_sharetravel';
        $database[$dbIndex]['dbUser'] = 'root';
        $database[$dbIndex]['dbPwd'] = 'root';
        $database[$dbIndex]['dbCharset'] = 'utf8';
        $database[$dbIndex]['dbPrev'] = 'ta_';
        $database[$dbIndex]['sqlLog'] = 1; //记录sql日志 0-不记录，1-记录
        return $database;
    }

}
