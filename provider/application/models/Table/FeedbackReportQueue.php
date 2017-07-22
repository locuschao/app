<?php
class Table_FeedbackReportQueue
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_FeedbackReportQueue();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_FeedbackReportQueue();
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
    public function update($row, $value, $field = "frq_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @return mixed
     */
    public function generateTask() {
        $date = date('Y-m-d H:i:s');
        $startTime = date('Y-m-d H:i:s', strtotime($date) - 12*60*60);
        $sql = "INSERT INTO {$this->_table->info('name')} (user_id, ute_id, erp_no, erp_url, token, start_time, end_time, execute_times, frq_status, frq_create_time, frq_update_time) 
            SELECT user_id, ute_id, ute_erp_no, ute_erp_url, ute_token, '{$startTime}', '{$date}', 0, 0, '{$date}', '{$date}' 
            FROM user_to_erp WHERE ute_status = 1 AND ute_token <> '' AND ute_erp_url <> ''";
        $this->_table->getAdapter()->query($sql);
    }

    /**
     * @param string $taskId
     * @return mixed
     */
    public function lockTask($taskId) {
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE {$this->_table->info('name')} SET frq_status = 1, execute_times = execute_times + 1, 
            frq_update_time = '{$date}' WHERE frq_id IN ($taskId)";
        return $this->_table->getAdapter()->query($sql);
    }

    /**
     * @param string $taskId
     * @return mixed
     */
    public function releaseTask($taskId)
    {
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE {$this->_table->info('name')} SET frq_status = 0, 
            frq_update_time = '{$date}' WHERE frq_id IN ($taskId)";
        return $this->_table->getAdapter()->query($sql);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "frq_id")
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
    public function getByField($value, $field = 'frq_id', $colums = "*")
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
        
        if(isset($condition["erp_no"]) && $condition["erp_no"] != ""){
            $select->where("erp_no = ?",$condition["erp_no"]);
        }
        if(isset($condition["token"]) && $condition["token"] != ""){
            $select->where("token = ?",$condition["token"]);
        }
        if(isset($condition["execute_times"]) && $condition["execute_times"] != ""){
            $select->where("execute_times < ?",$condition["execute_times"]);
        }
        if(isset($condition["frq_status"])){
            $select->where("frq_status = ?",$condition["frq_status"]);
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