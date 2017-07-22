<?php
class Table_OutboundBatch
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_OutboundBatch();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_OutboundBatch();
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
    public function update($row, $value, $field = "system_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "system_id")
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
    public function getByField($value, $field = 'system_id', $colums = "*")
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
        
    
        if(isset($condition["system_code"]) && $condition["system_code"] != ""){
            $select->where("system_code = ?",$condition["system_code"]);
        }
  
        if(isset($condition["system_title"]) && $condition["system_title"] != ""){
            $select->where("system_title = ?",$condition["system_title"]);
        }
        if(isset($condition["system_title_en"]) && $condition["system_title_en"] != ""){
            $select->where("system_title_en = ?",$condition["system_title_en"]);
        }
        if(isset($condition["system_url"]) && $condition["system_url"] != ""){
            $select->where("system_url = ?",$condition["system_url"]);
        }
        if(isset($condition["system_wsdl"]) && $condition["system_wsdl"] !== ""){
            $select->where("system_wsdl = ?",$condition["system_wsdl"]);
        }
        if(isset($condition["system_token"]) && $condition["system_token"] !== ""){
            $select->where("system_token != ?",$condition["system_token"]);
        }
        if(isset($condition["system_key"]) && $condition["system_key"] !== ""){
            $select->where("system_key != ?",$condition["system_key"]);
        }
        if(isset($condition["system_sort"]) && $condition["system_sort"] !== ""){
            $select->where("system_sort != ?",$condition["system_sort"]);
        }
        if(isset($condition["system_email"]) && $condition["system_email"] !== ""){
            $select->where("system_email != ?",$condition["system_email"]);
        }
        if(isset($condition["system_language"]) && $condition["system_language"] !== ""){
            $select->where("system_language != ?",$condition["system_language"]);
        }
        if(isset($condition["system_status"]) && $condition["system_status"] !== ""){
            $select->where("system_status = ?",$condition["system_status"]);
        }
        if(isset($condition["system_note"]) && $condition["system_note"] !== ""){
        	$select->where("system_note = ?",$condition["system_note"]);
        }
        /*if(isset($condition["system_status_no"]) && $condition["system_status_no"] != ""){
            $select->where("system_status != ?",$condition["system_status_no"]);
        }
        if(isset($condition["system_status_in"]) && $condition["system_status_in"] != ""){
            $select->where("system_status in (?)",$condition["system_status_in"]);
        }*/
        if(isset($condition["system_note"]) && $condition["system_note"] != ""){
            $select->where("system_note = ?",$condition["system_note"]);
        }
        /*if(isset($condition["ob_create_date"]) && $condition["ob_create_date"] != ""){
            $select->where("ob_create_date = ?",$condition["ob_create_date"]);
        }
        if(isset($condition["less_ob_error_count"]) && $condition["less_ob_error_count"] != ""){
            $select->where("ob_error_count < ?",$condition["less_ob_error_count"]);
        }
        if(isset($condition["greater_ob_error_count"]) && $condition["greater_ob_error_count"] != ""){
            $select->where("ob_error_count > ?",$condition["greater_ob_error_count"]);
        }&/
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
//             ECHO $sql;exit;
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
    public function getRowByCondition($condition = array(),$type)
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        $select->where("1 =?", 1);
        /*CONDITION_START*/
        
    
        if(isset($condition["system_code"]) && $condition["system_code"] != ""){
            $select->where("system_code = ?",$condition["system_code"]);
        }
  
        if(isset($condition["system_title"]) && $condition["system_title"] != ""){
            $select->where("system_title = ?",$condition["system_title"]);
        }
        if(isset($condition["system_title_en"]) && $condition["system_title_en"] != ""){
            $select->where("system_title_en = ?",$condition["system_title_en"]);
        }
        if(isset($condition["system_url"]) && $condition["system_url"] != ""){
            $select->where("system_url = ?",$condition["system_url"]);
        }
        if(isset($condition["system_wsdl"]) && $condition["system_wsdl"] !== ""){
            $select->where("system_wsdl = ?",$condition["system_wsdl"]);
        }
        if(isset($condition["system_token"]) && $condition["system_token"] !== ""){
            $select->where("system_token != ?",$condition["system_token"]);
        }
        if(isset($condition["system_key"]) && $condition["system_key"] !== ""){
            $select->where("system_key != ?",$condition["system_key"]);
        }
        if(isset($condition["system_sort"]) && $condition["system_sort"] !== ""){
            $select->where("system_sort != ?",$condition["system_sort"]);
        }
        if(isset($condition["system_email"]) && $condition["system_email"] !== ""){
            $select->where("system_email != ?",$condition["system_email"]);
        }
        if(isset($condition["system_language"]) && $condition["system_language"] !== ""){
            $select->where("system_language != ?",$condition["system_language"]);
        }
        if(isset($condition["system_status"]) && $condition["system_status"] !== ""){
            $select->where("system_status = ?",$condition["system_status"]);
        }
        if(isset($condition["system_note"]) && $condition["system_note"] != ""){
        	$select->where("system_note = ?",$condition["system_note"]);
        }
        /*if(isset($condition["system_status_no"]) && $condition["system_status_no"] != ""){
            $select->where("system_status != ?",$condition["system_status_no"]);
        }
        if(isset($condition["system_status_in"]) && $condition["system_status_in"] != ""){
            $select->where("system_status in (?)",$condition["system_status_in"]);
        }*/
        /*if(isset($condition["ob_create_date"]) && $condition["ob_create_date"] != ""){
            $select->where("ob_create_date = ?",$condition["ob_create_date"]);
        }
        if(isset($condition["less_ob_error_count"]) && $condition["less_ob_error_count"] != ""){
            $select->where("ob_error_count < ?",$condition["less_ob_error_count"]);
        }
        if(isset($condition["greater_ob_error_count"]) && $condition["greater_ob_error_count"] != ""){
            $select->where("ob_error_count > ?",$condition["greater_ob_error_count"]);
        }&/
        /*CONDITION_END*/
        if ('count(*)' == $type) {
            return $this->_table->getAdapter()->fetchOne($select);
        } else {
            $sql = $select->__toString();
            return $this->_table->getAdapter()->fetchRow($sql);
        }
    }
}