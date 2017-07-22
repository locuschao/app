<?php
class Table_Application
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_Application();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_Application();
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
    public function update($row, $value, $field = "application_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "application_id")
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
    public function getByField($value, $field = 'application_id', $colums = "*")
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
        
        if(isset($condition["application_code"]) && $condition["application_code"] != ""){
            $select->where("application_code = ?",$condition["application_code"]);
        }
        if(isset($condition["application_name"]) && $condition["application_name"] != ""){
            $select->where("application_name = ?",$condition["application_name"]);
        }
        if(isset($condition["application_note"]) && $condition["application_note"] != ""){
            $select->where("application_note = ?",$condition["application_note"]);
        }
        if(isset($condition["system_code"]) && $condition["system_code"] != ""){
            $select->where("system_code = ?",$condition["system_code"]);
        }
        if(isset($condition["current_number"]) && $condition["current_number"] != ""){
            $select->where("current_number = ?",$condition["current_number"]);
        }
        if(isset($condition["rule"]) && $condition["rule"] != ""){
            $select->where("rule = ?",$condition["rule"]);
        }
        
        //后加入
        if(isset($condition['app_add_time_start']) && $condition['app_add_time_start'] !=''){
        	$select->where ('app_add_time >= ?',$condition['app_add_time_start']);
        }
        if(isset($condition['app_add_time_end']) && $condition['app_add_time_end'] !=''){
        	$select->where ('app_add_time <= ?',$condition['app_add_time_end']);
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