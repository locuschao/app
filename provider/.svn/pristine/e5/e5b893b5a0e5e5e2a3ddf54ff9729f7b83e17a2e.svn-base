<?php
class Table_SaleReportQueue
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_SaleReportQueue();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_SaleReportQueue();
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
    public function update($row, $value, $field = "srq_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "srq_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->delete($where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function deleteIn($value, $field = "frq_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field} IN (?)", $value);
        return $this->_table->delete($where);
    }

    /**
     * @param $value
     * @param string $field
     * @param string $colums
     * @return mixed
     */
    public function getByField($value, $field = 'srq_id', $colums = "*")
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
        
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("user_id = ?",$condition["user_id"]);
        }
        if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("ute_id = ?",$condition["ute_id"]);
        }
        if(isset($condition["erp_no"]) && $condition["erp_no"] != ""){
            $select->where("erp_no = ?",$condition["erp_no"]);
        }
        if(isset($condition["token"]) && $condition["token"] != ""){
            $select->where("token = ?",$condition["token"]);
        }
        if(isset($condition["execute_times"]) && $condition["execute_times"] != ""){
            $select->where("execute_times < ?",$condition["execute_times"]);
        }
        if(isset($condition["srq_status"])){
            $select->where("srq_status = ?",$condition["srq_status"]);
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
     * @return mixed
     */
    public function generateTask() {
        $date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO {$this->_table->info('name')} (user_id, ute_id, erp_no, erp_url, token, execute_times, srq_status, srq_create_time, srq_update_time) 
            SELECT user_id, ute_id, ute_erp_no, ute_erp_url, ute_token, 0, 0, '{$date}', '{$date}' 
            FROM user_to_erp WHERE ute_status = 1 AND ute_token <> '' AND ute_erp_url <> ''";
        $this->_table->getAdapter()->query($sql);
    }

    /**
     * @param string $taskId
     * @return mixed
     */
    public function lockTask($taskId) {
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE {$this->_table->info('name')} SET srq_status = 1, execute_times = execute_times + 1, 
            srq_update_time = '{$date}' WHERE srq_id IN ($taskId)";
        return $this->_table->getAdapter()->query($sql);
    }

    /**
     * @param string $taskId
     * @return mixed
     */
    public function releaseTask($taskId)
    {
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE {$this->_table->info('name')} SET srq_status = 0, 
            srq_update_time = '{$date}' WHERE srq_id IN ($taskId)";
        return $this->_table->getAdapter()->query($sql);
    }
}