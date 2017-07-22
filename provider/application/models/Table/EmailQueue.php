<?php
class Table_EmailQueue
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_EmailQueue();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_EmailQueue();
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
    public function update($row, $value, $field = "eq_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "eq_id")
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
    public function getByField($value, $field = 'eq_id', $colums = "*")
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
        if (isset($condition["system_code_arr"]) && !empty($condition["system_code_arr"])) {
            $select->where("system_code in(?)", $condition["system_code_arr"]);
        }
        if (isset($condition["eq_status_arr"]) && !empty($condition["eq_status_arr"])) {
            $select->where("eq_status in(?)", $condition["eq_status_arr"]);
        }
        if (isset($condition["eq_from"]) && $condition["eq_from"] != "") {
            $select->where("eq_from = ?", $condition["eq_from"]);
        }
        if (isset($condition["system_code"]) && $condition["system_code"] != "") {
            $select->where("system_code = ?", $condition["system_code"]);
        }
        if (isset($condition["eq_to"]) && $condition["eq_to"] != "") {
            $select->where("eq_to = ?", $condition["eq_to"]);
        }
        if (isset($condition["eq_cc"]) && $condition["eq_cc"] != "") {
            $select->where("eq_cc = ?", $condition["eq_cc"]);
        }
        if (isset($condition["eq_subject"]) && $condition["eq_subject"] != "") {
            $select->where("eq_subject = ?", $condition["eq_subject"]);
        }
        if (isset($condition["eq_attachment"]) && $condition["eq_attachment"] != "") {
            $select->where("eq_attachment = ?", $condition["eq_attachment"]);
        }
        if (isset($condition["eq_body"]) && $condition["eq_body"] != "") {
            $select->where("eq_body = ?", $condition["eq_body"]);
        }
        if (isset($condition["eq_fail_number"]) && $condition["eq_fail_number"] != "") {
            $select->where("eq_fail_number = ?", $condition["eq_fail_number"]);
        }
        if (isset($condition["eq_status"]) && $condition["eq_status"] != "") {
            $select->where("eq_status = ?", $condition["eq_status"]);
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