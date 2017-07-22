<?php
class Table_OrderException
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_OrderException();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_OrderException();
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
    public function update($row, $value, $field = "oe_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "oe_id")
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
    public function getByField($value, $field = 'oe_id', $colums = "*")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $colums);
        $select->where("{$field} = ?", $value);
        return $this->_table->getAdapter()->fetchRow($select);
    }

    /**
     * @desc 连表查询
     * @return mixed
     * @date 2017-6-19
     * @author blank
     */
    public function  getByLeftCondition($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        $select->where("1 =?", 1);
        /*CONDITION_START*/

        if(isset($condition["order_id"]) && $condition["order_id"] != ""){
            $select->where("order_id = ?",$condition["order_id"]);
        }
        if(isset($condition["order_no"]) && $condition["order_no"] != ""){
            $select->where("order_no = ?",$condition["order_no"]);
        }
        if(isset($condition["oi_id"]) && $condition["oi_id"] != ""){
            $select->where("oi_id = ?",$condition["oi_id"]);
        }
        if(isset($condition["oi_sku"]) && $condition["oi_sku"] != ""){
            $select->where("oi_sku = ?",$condition["oi_sku"]);
        }
        if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("ute_id = ?",$condition["ute_id"]);
        }
        if(isset($condition["ute_erp_name"]) && $condition["ute_erp_name"] != ""){
            $select->where("ute_erp_name = ?",$condition["ute_erp_name"]);
        }
        if(isset($condition["oeol_id"]) && $condition["oeol_id"] != ""){
            $select->where("oeol_id = ?",$condition["oeol_id"]);
        }
        if(isset($condition["oe_preorder_amount_all"]) && $condition["oe_preorder_amount_all"] != ""){
            $select->where("oe_preorder_amount_all = ?",$condition["oe_preorder_amount_all"]);
        }
        if(isset($condition["oe_receive_amount_all"]) && $condition["oe_receive_amount_all"] != ""){
            $select->where("oe_receive_amount_all = ?",$condition["oe_receive_amount_all"]);
        }
        if(isset($condition["oe_ship_order_amount_all"]) && $condition["oe_ship_order_amount_all"] != ""){
            $select->where("oe_ship_order_amount_all = ?",$condition["oe_ship_order_amount_all"]);
        }
        if(isset($condition["oe_ship_amount_all"]) && $condition["oe_ship_amount_all"] != ""){
            $select->where("oe_ship_amount_all = ?",$condition["oe_ship_amount_all"]);
        }
        if(isset($condition["oe_check_amount_all"]) && $condition["oe_check_amount_all"] != ""){
            $select->where("oe_check_amount_all = ?",$condition["oe_check_amount_all"]);
        }
        if(isset($condition["oe_received_amount_all"]) && $condition["oe_received_amount_all"] != ""){
            $select->where("oe_received_amount_all = ?",$condition["oe_received_amount_all"]);
        }
        if(isset($condition["oe_pass_amount_all"]) && $condition["oe_pass_amount_all"] != ""){
            $select->where("oe_pass_amount_all = ?",$condition["oe_pass_amount_all"]);
        }
        if(isset($condition["oe_except_amount"]) && $condition["oe_except_amount"] != ""){
            $select->where("oe_except_amount = ?",$condition["oe_except_amount"]);
        }
        if(isset($condition["oe_amunt_unit"]) && $condition["oe_amunt_unit"] != ""){
            $select->where("oe_amunt_unit = ?",$condition["oe_amunt_unit"]);
        }
        if(isset($condition["oe_status"]) && $condition["oe_status"] != ""){
            $select->where("oe_status = ?",$condition["oe_status"]);
        }
        if(isset($condition["oe_handle_status"]) && $condition["oe_handle_status"] != ""){
            $select->where("oe_handle_status = ?",$condition["oe_handle_status"]);
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
        if(isset($condition["order_id"]) && $condition["order_id"] != ""){
            $select->where("order_id = ?",$condition["order_id"]);
        }
        if(isset($condition["order_no"]) && $condition["order_no"] != ""){
            $select->where("order_no = ?",$condition["order_no"]);
        }
        if(isset($condition["oi_id"]) && $condition["oi_id"] != ""){
            $select->where("oi_id = ?",$condition["oi_id"]);
        }
        if(isset($condition["oi_sku"]) && $condition["oi_sku"] != ""){
            $select->where("oi_sku = ?",$condition["oi_sku"]);
        }
        //---改进foreach拼接,多字段查询or date 2017-6-10---//
        $ute_ids=explode(',',$condition["ute_id"]);
        $str = '';
        $str=array_reduce($ute_ids ,function($str,$v){
            $str .= " ute_id=$v or";
            return $str;
        });
        $str = rtrim($str,'or');
        if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("$str");
        }
        if(isset($condition["ute_erp_name"]) && $condition["ute_erp_name"] != ""){
            $select->where("ute_erp_name = ?",$condition["ute_erp_name"]);
        }
        if(isset($condition["oeol_id"]) && $condition["oeol_id"] != ""){
            $select->where("oeol_id = ?",$condition["oeol_id"]);
        }
        if(isset($condition["oe_preorder_amount_all"]) && $condition["oe_preorder_amount_all"] != ""){
            $select->where("oe_preorder_amount_all = ?",$condition["oe_preorder_amount_all"]);
        }
        if(isset($condition["oe_receive_amount_all"]) && $condition["oe_receive_amount_all"] != ""){
            $select->where("oe_receive_amount_all = ?",$condition["oe_receive_amount_all"]);
        }
        if(isset($condition["oe_ship_order_amount_all"]) && $condition["oe_ship_order_amount_all"] != ""){
            $select->where("oe_ship_order_amount_all = ?",$condition["oe_ship_order_amount_all"]);
        }
        if(isset($condition["oe_ship_amount_all"]) && $condition["oe_ship_amount_all"] != ""){
            $select->where("oe_ship_amount_all = ?",$condition["oe_ship_amount_all"]);
        }
        if(isset($condition["oe_check_amount_all"]) && $condition["oe_check_amount_all"] != ""){
            $select->where("oe_check_amount_all = ?",$condition["oe_check_amount_all"]);
        }
        if(isset($condition["oe_received_amount_all"]) && $condition["oe_received_amount_all"] != ""){
            $select->where("oe_received_amount_all = ?",$condition["oe_received_amount_all"]);
        }
        if(isset($condition["oe_pass_amount_all"]) && $condition["oe_pass_amount_all"] != ""){
            $select->where("oe_pass_amount_all = ?",$condition["oe_pass_amount_all"]);
        }
        if(isset($condition["oe_except_amount"]) && $condition["oe_except_amount"] != ""){
            $select->where("oe_except_amount = ?",$condition["oe_except_amount"]);
        }
        if(isset($condition["oe_amunt_unit"]) && $condition["oe_amunt_unit"] != ""){
            $select->where("oe_amunt_unit = ?",$condition["oe_amunt_unit"]);
        }
        if(isset($condition["oe_status"]) && $condition["oe_status"] != ""){
            $select->where("oe_status = ?",$condition["oe_status"]);
        }
        if(isset($condition["oe_handle_status"]) && $condition["oe_handle_status"] != ""){
            $select->where("oe_handle_status = ?",$condition["oe_handle_status"]);
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