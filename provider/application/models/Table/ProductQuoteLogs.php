<?php
class Table_ProductQuoteLogs
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_ProductQuoteLogs();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_ProductQuoteLogs();
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
    public function update($row, $value, $field = "product_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "product_id")
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
    public function getByField($value, $field = 'product_id', $colums = "*")
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
        if(isset($condition["product_id"]) && $condition["product_id"] != ""){
            $select->where("product_id = ?",$condition["product_id"]);
        }
        
        if(isset($condition["ute_erp_name"]) && $condition["ute_erp_name"] != ""){
            $select->where("ute_erp_name = ?",$condition["ute_erp_name"]);
        }
        if(isset($condition["pq_unit_price"]) && $condition["pq_unit_price"] != ""){
            $select->where("pq_unit_price = ?",$condition["pq_unit_price"]);
        }
        if(isset($condition["pq_latest_transaction_price"]) && $condition["pq_latest_transaction_price"] != ""){
            $select->where("pq_latest_transaction_price = ?",$condition["pq_latest_transaction_price"]);
        }
        if(isset($condition["pq_price_unit"]) && $condition["pq_price_unit"] != ""){
            $select->where("pq_price_unit = ?",$condition["pq_price_unit"]);
        }
        if(isset($condition["pq_purchase_lower_limit"]) && $condition["pq_purchase_lower_limit"] != ""){
            $select->where("pq_purchase_lower_limit = ?",$condition["pq_purchase_lower_limit"]);
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