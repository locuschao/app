<?php
class Table_OrderExceptionOperationLogs
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_OrderExceptionOperationLogs();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_OrderExceptionOperationLogs();
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
    public function update($row, $value, $field = "oeol_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "oeol_id")
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
    public function getByField($value, $field = 'oeol_id', $colums = "*")
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
        
        if(isset($condition["oeol_return_no"]) && $condition["oeol_return_no"] != ""){
            $select->where("oeol_return_no = ?",$condition["oeol_return_no"]);
        }
        if(isset($condition["oeol_ship_company"]) && $condition["oeol_ship_company"] != ""){
            $select->where("oeol_ship_company = ?",$condition["oeol_ship_company"]);
        }
        if(isset($condition["oeol_ship_no"]) && $condition["oeol_ship_no"] != ""){
            $select->where("oeol_ship_no = ?",$condition["oeol_ship_no"]);
        }
        if(isset($condition["oeol_return_amount"]) && $condition["oeol_return_amount"] != ""){
            $select->where("oeol_return_amount = ?",$condition["oeol_return_amount"]);
        }
        if(isset($condition["oeol_pay_way"]) && $condition["oeol_pay_way"] != ""){
            $select->where("oeol_pay_way = ?",$condition["oeol_pay_way"]);
        }
        if(isset($condition["oeol_ship_fee"]) && $condition["oeol_ship_fee"] != ""){
            $select->where("oeol_ship_fee = ?",$condition["oeol_ship_fee"]);
        }
        if(isset($condition["oeol_ship_fee_unit"]) && $condition["oeol_ship_fee_unit"] != ""){
            $select->where("oeol_ship_fee_unit = ?",$condition["oeol_ship_fee_unit"]);
        }
        if(isset($condition["oeol_weight"]) && $condition["oeol_weight"] != ""){
            $select->where("oeol_weight = ?",$condition["oeol_weight"]);
        }
        if(isset($condition["oeol_weight_unit"]) && $condition["oeol_weight_unit"] != ""){
            $select->where("oeol_weight_unit = ?",$condition["oeol_weight_unit"]);
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