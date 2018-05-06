<?php

namespace baike\framework\libs\database;

use baike\configs\Database;
use baike\framework\exception\DBException;

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

    /**
     * 默认连接的数据库配置项编号
     * @var int 
     */
    public $dbIndex = 0;

    /**
     * 数据表前缀，从配置文件中取出共数据模型类用
     * @var string 
     */
    protected $dbprev = '';

    /**
     * 数据库连接资源池，确保每个数据库有一个资源连接
     * @var array 
     */
    private static $dbConn = array();

    /**
     * 缓存数据库配置信息，避免重复调用
     * @var array 
     */
    private static $dbConfig = [];

    function __construct($dbIndex)
    {
        $this->dbIndex = $dbIndex;
        $dbConfig = $this->getDatabaseConfig();
        $this->dbprev = $dbConfig['dbPrev'];
        if (!isset(self::$dbConn[$this->dbIndex])) {
            $conn = new MysqliDB(
                $dbConfig['dbHost']
                , $dbConfig['dbPort']
                , $dbConfig['dbUser']
                , $dbConfig['dbPwd']
                , $dbConfig['dbCharset']
            );
            self::$dbConn[$this->dbIndex] = &$conn;
        }
        self::$dbConn[$this->dbIndex]->sqlLog = $dbConfig['sqlLog'];
        self::$dbConn[$this->dbIndex]->selectDB($dbConfig['dbName']);
        return self::$dbConn[$this->dbIndex];
    }

    /**
     * 获取要连接的数据库配置
     * @param int $dbIndex 配置文件里的数据库编号
     * @return array
     * @throws DBException
     */
    private function getDatabaseConfig()
    {
        if (empty(self::$dbConfig)) {
            self::$dbConfig = Database::getDBs();
        }
        //是否设置了数据库
        if (!isset(self::$dbConfig[$this->dbIndex])) {
            throw new DBException(__CLASS__ . ': dbIndex not exists');
        }
        return self::$dbConfig[$this->dbIndex];
    }

}
