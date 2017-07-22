<?php
class Table_Samples
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_Samples();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_Samples();
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
    public function update($row, $value, $field = "sample_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "sample_id")
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
    public function getByField($value, $field = 'sample_id', $colums = "*")
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
        
        if(isset($condition["sample_no"]) && $condition["sample_no"] != ""){
            $select->where("sample_no = ?",$condition["sample_no"]);
        }
        if(isset($condition["bidding_id"]) && $condition["bidding_id"] != ""){
            $select->where("bidding_id = ?",$condition["bidding_id"]);
        }
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("user_id = ?",$condition["user_id"]);
        }
        if(isset($condition["dso_id"]) && $condition["dso_id"] != ""){
            $select->where("dso_id = ?",$condition["dso_id"]);
        }
        if(isset($condition["sample_result"]) && $condition["sample_result"] != ""){
            $select->where("sample_result = ?",$condition["sample_result"]);
        }
        if(isset($condition["sample_reason"]) && $condition["sample_reason"] != ""){
            $select->where("sample_reason = ?",$condition["sample_reason"]);
        }
        if(isset($condition["sample_price"]) && $condition["sample_price"] != ""){
            $select->where("sample_price = ?",$condition["sample_price"]);
        }
        if(isset($condition["sample_price_unit"]) && $condition["sample_price_unit"] != ""){
            $select->where("sample_price_unit = ?",$condition["sample_price_unit"]);
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