<?php

namespace baike\libs\database;

use baike\configs\Database;
use baike\libs\DBException;

/**
 * Description of factoryclass
 *
 * url www.phpleyuan.com
 * email wangbaike168@qq.com
 * time 2018-05-05 16:08:00
 * project PMS
 * encoding UTF-8
 * @author wbk
 * */
class DBLoader
{

    public $dbIndex = 0;
    public static $dbprev = '';
    private static $dbConn = array();

    function __construct($dbIndex)
    {
        if (!isset(self::$dbConn[$dbIndex])) {
            $dbConfig = $this->getDatabaseConfig($dbIndex);
            $conn = new MysqliDB(
                $dbConfig['dbHost']
                , $dbConfig['dbPort']
                , $dbConfig['dbUser']
                , $dbConfig['dbPwd']
                , $dbConfig['dbName']
                , $dbConfig['dbCharset']
            );
            $conn->sqlLog = $dbConfig['sqlLog'];
            self::$dbprev = $dbConfig['dbPrev'];
            self::$dbConn[$this->dbIndex] = &$conn;
        }
        return isset(self::$dbConn[$this->dbIndex]) ? self::$dbConn[$this->dbIndex] : false;
    }

    /**
     * 获取要连接的数据库配置
     * @param int $dbIndex 配置文件里的数据库编号
     * @return array
     * @throws DBException
     */
    private function getDatabaseConfig($dbIndex)
    {
        $this->dbIndex = $dbIndex;
        $dbSets = Database::getDBs();
        //是否设置了数据库
        if (!isset($dbSets[$this->dbIndex])) {
            throw new DBException(__CLASS__ . ': db set exists');
        }
        return $dbSets[$this->dbIndex];
    }

}
