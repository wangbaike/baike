<?php

namespace baike\libs\database;

use baike\configs\Database;
use baike\libs\BaiException;

/**
 * Description of factoryclass
 *
 * url www.phpleyuan.com
 * email wangbaike168@qq.com
 * time 2013-3-17 16:08:00
 * project PMS
 * encoding UTF-8
 * @author wbk
 * */
class DBLoader {

    public $database = '0';
    public static $dbprev = '';
    private static $dbConn = array();

    function __construct($dbIndex) {
        if ($dbIndex) {
            $this->database = $dbIndex;
        }
        $dbSets = Database::getDBs();
        if (!isset(self::$dbConn[$this->database])) {
            //是否设置了数据库
            if (!isset($dbSets[$this->database])) {
                throw new BaiException(__CLASS__ . ': db set exists');
            }
            $dbConfig = $dbSets[$this->database];
            if ($conn = new mysqldb($dbConfig['dbHost'], $dbConfig['dbPort'], $dbConfig['dbUser'], $dbConfig['dbPwd'], $dbConfig['dbName'], $dbConfig['dbCharset'])) {
                self::$dbConn[$this->database] = &$conn;
            } else {
                throw new BaiException(__CLASS__ . ': mysqldb can not connected');
            }
        }
        return isset(self::$dbConn[$this->database]) ? self::$dbConn[$this->database] : false;
    }

}
