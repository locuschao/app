<?php
class Table_Orders
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_Orders();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_Orders();
    }

    /**
     * @param $row
     * @return mixed
     */
    public function add($row)
    {
        return $this->_table->insert($row);
    }


    /**
     * @param $row
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function update($row, $value, $field = "order_id")
    {   
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $row
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function updateIn($row, $value, $field = "order_id")
    {   
        $where = $this->_table->getAdapter()->quoteInto("{$field} IN (?)", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "order_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->delete($where);
    }

    /**
     * @param $value
     * @param string $field
     * @param string $colums
     * @return mixed
     */
    public function getByField($value, $field = 'order_id', $colums = "*")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $colums);
        $select->where("{$field} = ?", $value);
        return $this->_table->getAdapter()->fetchRow($select);
    }

    public function getAll()
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, "*");
        return $this->_table->getAdapter()->fetchAll($select);
    }

    /**
     * 通过order_no获取采购单目的仓库
     */
    public function byOrderNoWarehouse($condition = array())
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, "*");
        if(isset($condition["order_no"]) && $condition["order_no"] != ""){
            $select->where("order_no = ?",$condition["order_no"]);
        }
        $sql = $select->__toString();
        return $this->_table->getAdapter()->fetchAll($sql);
    }

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $orderBy
     * @return array|string
     */
    public function getByCondition($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "")
    {

        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        $select->where("1 =?", 1);
        /*CONDITION_START*/
        /*var_dump($condition);die;*/
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("user_id = ?",$condition["user_id"]);
        }
        //多字段查询or
        $ute_ids=explode(',',$condition["ute_id"]);
        $str = '';
        foreach($ute_ids as $k=>$v){
            $str .= " ute_id=$v or";
        }
        $str = trim($str,'or');

        if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("$str");
        }
        if(isset($condition["order_no"]) && $condition["order_no"] != ""){
            $select->where("order_no LIKE ?", '%'.$condition["order_no"].'%');
        }
        if(isset($condition["order_from"]) && $condition["order_from"] != ""){
            $select->where("order_from LIKE ?", '%'.$condition["order_from"].'%');
        }
        if(isset($condition["order_status"]) && $condition["order_status"] != ""){
            $select->where("order_status = ?",$condition["order_status"]);
        }
        /*CONDITION_END*/
        if ('count(*)' == $type) {
            return $this->_table->getAdapter()->fetchOne($select);
        } else {
            if (!empty($orderBy)) {
                $select->order($orderBy);
            }
            if ($pageSize > 0 and $page > 0) {
                $start = ($page - 1) * $pageSize;
                $select->limit($pageSize, $start);
            }
            $sql = $select->__toString();
            return $this->_table->getAdapter()->fetchAll($sql);
        }
    }

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $orderBy
     * @return array|string
     */
    public function getAllByCondition($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        //$select->where("1 =?", 1);
        /*CONDITION_START*/
        
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("user_id = ?",$condition["user_id"]);
        }
        if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("ute_id IN (?)",$condition["ute_id"]);
        }
        if(isset($condition["order_no"]) && $condition["order_no"] != ""){
            $select->where("order_no IN (?)", $condition["order_no"]);
        }
        if(isset($condition["order_status"]) && $condition["order_status"] != ""){
            $select->where("order_status = ?",$condition["order_status"]);
        }
        /*CONDITION_END*/
        if ('count(*)' == $type) {
            return $this->_table->getAdapter()->fetchOne($select);
        } else {
            if (!empty($orderBy)) {
                $select->order($orderBy);
            }
            if ($pageSize > 0 and $page > 0) {
                $start = ($page - 1) * $pageSize;
                $select->limit($pageSize, $start);
            }
            $sql = $select->__toString();
            return $this->_table->getAdapter()->fetchAll($sql);
        }
    }

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $orderBy
     * @param string $join
     * @return array|string
     */
    public function getByLeftJoin($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "", $join) {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        if (!empty($join)) {
            foreach ($join as $key => $value) {
                $select->joinLeft($value[0], $value[1], $value[2]);
            }
        }
        /*CONDITION_START*/
        if(isset($condition["orders.order_id"]) && $condition["orders.order_id"] != ""){
            $select->where("orders.order_id IN (?)",$condition["orders.order_id"]);
        }
        //多字段查询or
        $ute_ids=explode(',',$condition["ute_id"]);
        $str = '';
        foreach($ute_ids as $k=>$v){
            $str .= " ute_id=$v or";
        }
        $str = trim($str,'or');

        if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("$str");
        }

        if(isset($condition["order_no"]) && $condition["order_no"] != ""){
            $select->where("order_no LIKE ?", '%'.$condition["order_no"].'%');
        }
        if(isset($condition["order_from"]) && $condition["order_from"] != ""){
            $select->where("order_from LIKE ?", '%'.$condition["order_from"].'%');
        }
        if(isset($condition["order_status"]) && $condition["order_status"] != ""){
            $select->where("order_status = ?",$condition["order_status"]);
        }
        /*CONDITION_END*/
        if ('count(*)' == $type) {
            return $this->_table->getAdapter()->fetchOne($select);
        } else {
            if (!empty($orderBy)) {
                $select->order($orderBy);
            }
            if ($pageSize > 0 and $page > 0) {
                $start = ($page - 1) * $pageSize;
                $select->limit($pageSize, $start);
            }
            $sql = $select->__toString();
            return $this->_table->getAdapter()->fetchAll($sql);
        }
    }

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $orderBy
     * @param string $join
     * @return array|string
     */
    public function getByGroup($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "", $group = "") {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        /*CONDITION_START*/
        if(isset($condition["orders.order_id"]) && $condition["orders.order_id"] != ""){
            $select->where("orders.order_id IN ({$condition["orders.order_id"]})");
        }
        //多字段查询or
        $ute_ids = explode(',',$condition["ute_id"]);
        $str = '';
        foreach($ute_ids as $k=>$v){
            $str .= " ute_id=$v or";
        }
        $str = trim($str,'or');

        if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("$str");
        }

        if(isset($condition["order_no"]) && $condition["order_no"] != ""){
            $select->where("order_no LIKE ?", '%'.$condition["order_no"].'%');
        }
        if(isset($condition["order_from"]) && $condition["order_from"] != ""){
            $select->where("order_from LIKE ?", '%'.$condition["order_from"].'%');
        }
        if(isset($condition["order_status"]) && $condition["order_status"] != ""){
            $select->where("order_status = ?",$condition["order_status"]);
        }
        /*CONDITION_END*/
        if (!empty($group)) {
            $select->group($group);
        }
        if ('count(*)' == $type) {
            return $this->_table->getAdapter()->fetchOne($select);
        } else {
            if (!empty($orderBy)) {
                $select->order($orderBy);
            }
            if ($pageSize > 0 and $page > 0) {
                $start = ($page - 1) * $pageSize;
                $select->limit($pageSize, $start);
            }
            $sql = $select->__toString();
            return $this->_table->getAdapter()->fetchAll($sql);
        }
    }


    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $orderBy
     * @return array|string
     */
    public function getByConditions($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "")
    {

        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        $select->where("1 =?", 1);
        /*CONDITION_START*/

        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("user_id = ?",$condition["user_id"]);
        }
        //多字段查询or
        $ute_ids=explode(',',$condition["ute_id"]);
        $str = '';
        foreach($ute_ids as $k=>$v){
            $str .= " ute_id=$v or";
        }
        $str = trim($str,'or');

        if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("$str");
        }
        if(isset($condition["order_no"]) && $condition["order_no"] != ""){
            $select->where("order_no = ?", $condition["order_no"]);
        }
        if(isset($condition["order_from"]) && $condition["order_from"] != ""){
            $select->where("order_from LIKE ?", '%'.$condition["order_from"].'%');
        }
        if(isset($condition["order_status"]) && $condition["order_status"] != ""){
            $select->where("order_status = ?",$condition["order_status"]);
        }
        /*CONDITION_END*/
        if ('count(*)' == $type) {
            return $this->_table->getAdapter()->fetchOne($select);
        } else {
            if (!empty($orderBy)) {
                $select->order($orderBy);
            }
            if ($pageSize > 0 and $page > 0) {
                $start = ($page - 1) * $pageSize;
                $select->limit($pageSize, $start);
            }
            $sql = $select->__toString();

            return $this->_table->getAdapter()->fetchAll($sql);
        }
    }


}