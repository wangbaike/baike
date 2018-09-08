<?php

namespace baike\framework\libs\database;

use baike\framework\tools\Log;

/**
 * Description of mysqldbclass
 *
 * url www.phpleyuan.com
 * email wangbaike168@qq.com
 * time 2018-05-05 08:20:03
 * project PMS
 * encoding UTF-8
 * @author wbk
 * */
class MysqliDB
{

    public $host = 'localhost';
    public $port = 3306;
    public $user = 'root';
    public $pwd = '';
    public $dbName;
    public $charset = 'utf8';
    public $sqlLog = 0; //是否开启sql日志， 0-不开启，1-开启
    private $dbConn = null;

    function __construct($host, $port, $user, $pwd, $charset)
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->pwd = $pwd;
        $this->charset = $charset;
        return $this->connect();
    }

    /**
     * 连接数据库
     *
     * @return resource
     */
    private function connect()
    {
        if (null === $this->dbConn) {
            $this->dbConn = new \mysqli($this->host, $this->user, $this->pwd, '', $this->port);
            if ($this->dbConn->connect_errno) {
                throw new DBException(__CLASS__ . ':error to connect mysql server' . $this->dbConn->connect_errno);
            }
            $this->setCharset();
        }
        return $this->dbConn;
    }

    /**
     * 选择数据库
     * @throws DBException
     */
    public function selectDB($dbName)
    {
        $this->dbName = $dbName;
        if (!$this->dbConn->select_db($this->dbName)) {
            throw new DBException(__CLASS__ . ':error to connect database:' . $this->dbName . $this->dbConn->error);
        }
    }

    /**
     * 设置数据库编编码
     * @throws DBException
     */
    public function setCharset()
    {
        if (!$this->dbConn->set_charset($this->charset)) {
            throw new DBException(__CLASS__ . ':error to set charset on database:' . $this->dbName . $this->dbConn->error);
        }
    }

    /**
     * 执行sql语句
     *
     * @name query
     * @param string $sql SQL语句
     * @return bool
     */
    public function query($sql)
    {
        if ($this->sqlLog) {
            Log::add($sql, Log::$NORMAL, 'dbSQL');
        }
        return $this->dbConn->query($sql);
    }

    /**
     * 查询表中的单个字段
     *
     * @name selectCell
     * @param string $filed 要查询的字段，
     * @param array $where 查询条件 格式为array("index"=>'value')
     * @param string $table 表名称
     * @return array | false
     */
    public function selectCell($filed, $where, $table)
    {
        $resoult = $this->query("SELECT " . $filed . " FROM " . $table . $this->getWhereStr($where) . " LIMIT 1");
        $info = $resoult->fetch_assoc();
        return isset($info[$filed]) ? $info[$filed] : false;
    }

    /**
     * 查询表中的单条信息
     *
     * @name selectRow
     * @param string $filed 要查询的字段，用“,”号隔开
     * @param array $where 查询条件 格式为array("index"=>'value')
     * @param string $group 分组字段
     * @param string $order 排序字段 可以为空
     * @param string $asc 排序条件 默认为正序排列asc
     * @param string $table 表名称
     * @return array | false
     */
    public function selectRow($filed = '*', $where = array(), $group = '', $order = '', $asc = 'ASC', $table = '')
    {
        $sql = "SELECT " . $filed . " FROM " . $table . $this->getWhereStr($where);
        if ($group != '') {
            $sql .= ' GROUP BY ' . $group;
        }
        if ($order != '') {
            $sql .= ' ORDER BY ' . $order . ' ' . $asc;
        }
        $sql .= ' LIMIT 1';
        $resoult = $this->query($sql);
        return $resoult->fetch_assoc();
    }

    /**
     * 查询表中的所有的信息
     *
     * @name selectAllRow
     * @param string $filed 要查询的字段，用“,”号隔开
     * @param array $where 查询条件 格式为array("index"=>'value')
     * @param string $group 分组字段
     * @param string $order 排序字段 可以为空
     * @param string $asc 排序条件 默认为正序排列asc
     * @param int $start 起始字段
     * @param int $offset 每次查询的个数
     * @param string $table 表名称
     * @return array | false
     */
    public function selectAllRow($filed = '*', $where = array(), $group = '', $order = '', $asc = 'ASC', $start = '0', $offset = '15', $table = '')
    {
        $sql = "SELECT " . $filed . " FROM " . $table . $this->getWhereStr($where);
        if ($group != '') {
            $sql .= ' GROUP BY ' . $group;
        }
        if ($order != '') {
            $sql .= ' ORDER BY ' . $order . ' ' . $asc;
        }
        if ($start != '0' || $offset != '0') {
            $sql .= ' LIMIT ' . $start . ',' . $offset;
        }
        $resoult = $this->query($sql);
        $arr = array();
        if ($resoult) {
            while ($info = $resoult->fetch_assoc()) {
                $arr[] = $info;
            }
        }
        return $arr;
    }

    /**
     * 删除表中的信息
     *
     * @name delete
     *
     * @param array $where 查询条件 格式为array("index"=>'value')
     * @param string $table 表名称
     * @param string $all 为真测删除全部符合条件的，为假则删除一条
     * @return bool
     */
    public function delete($where, $table, $all = false)
    {
        return $this->query("DELETE FROM " . $table . $this->getWhereStr($where) . ($all ? '' : " LIMIT 1"));
    }

    /**
     * 更新表中的信息
     *
     * @name update
     *
     * @param array $item 值的格式 格式为array("index"=>'value')
     * @param string $table 表名称
     * @param array $where 查询条件 格式为array("index"=>'value')
     * @return bool
     */
    public function update($item, $table, $where)
    {
        $data = array();
        foreach ($item as $key1 => $val1) {
            $data[] = $key1 . "=" . $val1;
        }
        return $this->query("UPDATE " . $table . " SET " . implode(",", $data) . $this->getWhereStr($where));
    }

    /**
     * 插入数据
     *
     * @name insert
     * @param array $item 值的格式 格式为array("index"=>'value')
     * @param string $table 表名称
     * @return bool
     */
    public function insert($item, $table)
    {
        $field_arr = array();
        $value_arr = array();
        foreach ($item as $key => $val) {
            $field_arr[] = "`" . $key . "`";
            $value_arr[] = $this->escape($val);
        }
        $result = $this->query("INSERT INTO `" . $table . "`(" . implode(' ,', $field_arr) . ") VALUES(" . implode(' ,', $value_arr) . ")");
        if ($result) {
            return $this->dbConn->insert_id;
        } else {
            return false;
        }
    }

    /**
     * 生成查询条件字符串
     *
     * @name getWhereStr
     * @param array $where 查询条件 格式为array("index"=>'value')
     * @return string 查询条件字符串
     */
    private function getWhereStr($where)
    {
        $data_arr = array();
        $whereString = '';
        if (count($where)) {
            foreach ($where as $key => $val) {
                if (preg_match("/[<|>|<=|>=|!=]/", $key)) {
                    $data_arr[] = $key . $this->escape($val);
                } else {
                    if (is_array($val)) {
                        $data_arr[] = $key . " in (" . implode(',', $val) . ")";
                    } else {
                        $data_arr[] = $key . "=" . $this->escape($val);
                    }
                }
            }
            $whereString = " WHERE " . implode(" AND ", $data_arr);
        }
        return $whereString;
    }

    /**
     * 查询条件的值，根据类型，自动区别字符类型
     *
     * @name escape
     * @access	public
     * @param	string
     * @return	mixed
     */
    private function escape($str)
    {
        if (is_string($str)) {
            $str = "'" . $str . "'";
        } elseif (is_bool($str)) {
            $str = ($str === FALSE) ? 0 : 1;
        } elseif (is_null($str)) {
            $str = 'NULL';
        }
        return $str;
    }

    /**
     * 关闭数据库连接
     */
    public function close($conn = '')
    {
//        if ($conn != '') {
//            $this->dbConn->;
//        } else {
//            mysql_close();
//        }
    }

}
