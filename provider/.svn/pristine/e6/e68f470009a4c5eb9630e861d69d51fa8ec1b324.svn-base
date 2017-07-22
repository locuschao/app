<?php
class Table_UserToErp
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_UserToErp();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_UserToErp();
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
    public function update($row, $value, $field = "ute_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "ute_id")
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
    public function getByField($value, $field = 'ute_id', $colums = "*")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $colums);
        $select->where("{$field} = ?", $value);
        var_dump($select->__toString());die;
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
     * @des 通过ute_id获取erpname
     * @param array $condition
     * @return mixed
     */
    public function getUteIdByName($condition = array())
    {

        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table);
        $select->where("1 =?", 1);
        /*CONDITION_START*/
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("user_id = ?",$condition["user_id"]);
        }
        if(isset($condition["ute_erp_no"]) && $condition["ute_erp_no"] != ""){
            $select->where("ute_erp_no =?",$condition["ute_erp_no"]);
        }
        if(isset($condition["ute_token"]) && $condition["ute_token"] != ""){
            $select->where("ute_token = ?",$condition["ute_token"]);
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
        if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("ute_id IN (?)",$condition["ute_id"]);
        }
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("user_id = ?",$condition["user_id"]);
        }
        if(isset($condition["ute_erp_no"]) && $condition["ute_erp_no"] != ""){
            $select->where("ute_erp_no =?",$condition["ute_erp_no"]);
        }
        if(isset($condition["ute_erp_name"]) && $condition["ute_erp_name"] != ""){
            $select->where("ute_erp_name like ?","%".$condition["ute_erp_name"]."%");
        }
        if(isset($condition["ute_token"]) && $condition["ute_token"] != ""){
            $select->where("ute_token = ?",$condition["ute_token"]);
        }
        if(isset($condition["ute_status"]) && $condition["ute_status"] != ""){
            $select->where("ute_status = ?",$condition["ute_status"]);
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
     * @return array|string
     */
    public function getUteInfo($condition = array(), $type = '*') {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("ute_id = ?",$condition["ute_id"]);
        }
        $select->where('ute_token <> ?', '');
        $sql = $select->__toString();
        return $this->_table->getAdapter()->fetchRow($sql);
    }
}