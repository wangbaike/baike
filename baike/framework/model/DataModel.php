<?php

namespace baike\framework\model;

use baike\framework\libs\database\DBLoader;

/**
 * Description of modelclass
 *
 * url www.phpleyuan.com
 * email wangbaike168@qq.com
 * time 2013-3-17 16:07:05
 * project PMS
 * encoding UTF-8
 * @author wbk
 * */
class DataModel extends DBLoader
{

    /**
     * 查询表中的单个字段
     *
     * @name dbSelectCell
     * @param string $filed 要查询的字段，
     * @param array $where 查询条件 格式为array("index"=>'value')
     * @return array | false
     */
    function dbSelectCell($filed, $where = array())
    {
        return $this->conn->selectCell($filed, $where, $this->table);
    }

    /**
     * 查询表中的单条信息
     *
     * @name dbSelectRow
     * @param string $filed 要查询的字段，用“,”号隔开
     * @param array $where 查询条件 格式为array("index"=>'value')
     *  @param string $group 分组字段
     * @param string $order 排序字段 可以为空
     * @param string $asc 排序条件 默认为正序排列asc
     * @return array | false
     */
    function dbSelectRow($filed = '*', $where = array(), $group = '', $order = '', $asc = 'asc')
    {
        return $this->conn->selectRow($filed, $where, $group, $order, $asc, $this->table);
    }

    /**
     * 查询表中的所有的信息
     *
     * @name dbSelectAllRow
     * @param string $filed 要查询的字段，用“,”号隔开
     * @param array $where 查询条件 格式为array("index"=>'value')
     * @param string $group 分组字段
     * @param string $order 排序字段 可以为空
     * @param string $asc 排序条件 默认为正序排列asc
     * @param int $start 起始字段
     * @param int $offset 每次查询的个数
     * @return array | false
     */
    function dbSelectAllRow($filed = '*', $where = array(), $group = '', $order = '', $asc = 'asc', $start = '0', $offset = '0')
    {
        return $this->conn->selectAllRow($filed, $where, $group, $order, $asc, $start, $offset, $this->table);
    }

    /**
     * 删除表中的信息
     *
     * @name dbDelete
     *
     * @param array $where 查询条件 格式为array("index"=>'value')
     * @param string $all 为真测删除全部符合条件的，为假则删除一条
     * @return bool
     */
    function dbDelete($where, $all = false)
    {
        return $this->conn->delete($where, $this->table, $all);
    }

    /**
     * 更新表中的信息
     *
     * @name dbUpdate
     *
     * @param array $item 值的格式 格式为array("index"=>'value')
     * @param array $where 查询条件 格式为array("index"=>'value')
     * @return bool
     */
    function dbUpdate($item, $where)
    {
        return $this->conn->update($item, $this->table, $where);
    }

    /**
     * 插入数据
     *
     * @name dbInsert
     * @param array $item 值的格式 格式为array("index"=>'value')
     * @return bool
     */
    function dbInsert($item)
    {
        return $this->conn->insert($item, $this->table);
    }

    /**
     * 执行sql语句
     *
     * @name dbQuery
     * @param string $sql SQL语句
     * @return bool
     */
    function dbQuery($sql)
    {
        return $this->conn->query($sql);
    }

    /**
     * 关闭数据库连接
     */
    function dbClose()
    {
        return $this->conn->close($this->conn);
    }

    //构造函数
    function __construct($dbIndex = 0)
    {
        if (null === $this->conn) {
            $this->conn = parent::__construct($dbIndex);
        }
    }

    /**
     * 设置要操作的表
     * @param string $tableName
     */
    public function setTable($tableName)
    {
        $this->table = $this->dbprev . $tableName; //加上数据表前缀
    }

    /**
     * 实例化工厂
     * @param string $tableName 表名称
     * @param int $dbIndex 数据库的编号，在数据库配置文件中可以查看索引编号
     * @return type
     */
    public static function getInstance($tableName, $dbIndex = 0)
    {
        if (null === self::$instance) {
            self::$instance = new self($dbIndex);
        }
        self::$instance->setTable($tableName);
        return self::$instance;
    }

    private $conn = null;
    private $table;
    private static $instance = null;

}
