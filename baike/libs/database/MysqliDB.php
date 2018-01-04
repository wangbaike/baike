<?php

namespace baike\libs\database;

use baike\libs\BaiException;

/**
 * Description of mysqldbclass
 *
 * url www.phpleyuan.com
 * email wangbaike168@qq.com
 * time 2013-3-17 16:16:03
 * project PMS
 * encoding UTF-8
 * @author wbk
 * */
class MysqliDB {

    public $host = 'localhost';
    public $port = 3306;
    public $user = 'root';
    public $pwd = '';
    public $dbName;
    public $charset = 'utf8';
    private $dbConn = null;

    function __construct($host, $port, $user, $pwd, $dbName, $charset) {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->pwd = $pwd;
        $this->dbName = $dbName;
        $this->charset = $charset;
        return $this->connect();
    }

    /**
     * 连接数据库
     *
     * @return resource
     */
    function connect() {
        $this->dbConn = mysqli_connect($this->host, $this->user, $this->pwd, $this->dbName, $this->port);
        if (!$this->dbConn) {
            throw new BaiException(__CLASS__ . ':error to connect mysql server' . mysqli_error($this->dbConn));
        }
        $this->dbConn->query("SET NAMES " . $this->charset);
        return $this->dbConn;
    }

    /**
     * 执行sql语句
     *
     * @name query
     * @param string $sql SQL语句
     * @return bool
     */
    function query($sql) {
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
    function selectCell($filed, $where, $table) {
        $resoult = $this->query("select " . $filed . " from " . $table . $this->getWhereStr($where) . " limit 1");
        $info = mysql_fetch_assoc($resoult);
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
    function selectRow($filed = '*', $where = array(), $group = '', $order = '', $asc = 'asc', $table = '') {
        $sql = "select " . $filed . " from " . $table . $this->getWhereStr($where);
        if ($group != '') {
            $sql .= ' group by ' . $group;
        }
        if ($order != '') {
            $sql .= ' order by ' . $order . ' ' . $asc;
        }
        $sql .= ' limit 1';
        $resoult = $this->query($sql);
        return mysql_fetch_assoc($resoult);
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
    function selectAllRow($filed = '*', $where = array(), $group = '', $order = '', $asc = 'asc', $start = '0', $offset = '15', $table = '') {
        $sql = "select " . $filed . " from " . $table . $this->getWhereStr($where);
        if ($group != '') {
            $sql .= ' group by ' . $group;
        }
        if ($order != '') {
            $sql .= ' order by ' . $order . ' ' . $asc;
        }
        if ($start != '0' || $offset != '0') {
            $sql .= ' limit ' . $start . ',' . $offset;
        }
        $resoult = $this->query($sql);
        $arr = array();
        while ($info = mysql_fetch_assoc($resoult)) {
            $arr[] = $info;
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
    function delete($where, $table, $all = false) {
        return $this->query("delete from " . $table . $this->getWhereStr($where) . ($all ? '' : " limit 1"));
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
    function update($item, $table, $where) {
        $data = array();
        foreach ($item as $key1 => $val1) {
            $data[] = $key1 . "=" . $val1;
        }
        return $this->query("update " . $table . " set " . implode(",", $data) . $this->getWhereStr($where));
    }

    /**
     * 插入数据
     *
     * @name insert
     * @param array $item 值的格式 格式为array("index"=>'value')
     * @param string $table 表名称
     * @return bool
     */
    function insert($item, $table) {
        $field_arr = array();
        $value_arr = array();
        foreach ($item as $key => $val) {
            $field_arr[] = "`" . $key . "`";
            $value_arr[] = $this->escape($val);
        }
        $result = $this->query("INSERT INTO `" . $table . "`(" . implode(' ,', $field_arr) . ") VALUES(" . implode(' ,', $value_arr) . ")");
        if ($result) {
            return mysql_insert_id();
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
    private function getWhereStr($where) {
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
            $whereString = " where " . implode(" and ", $data_arr);
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
    private function escape($str) {
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
    function close($conn = '') {
        if ($conn != '') {
            mysql_close($conn);
        } else {
            mysql_close($this->dbConn);
        }
    }

}
