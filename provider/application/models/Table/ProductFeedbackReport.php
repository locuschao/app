<?php
class Table_ProductFeedbackReport
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_ProductFeedbackReport();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_ProductFeedbackReport();
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
    public function update($row, $value, $field = "pfr_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "pfr_id")
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
    public function getByField($value, $field = 'pfr_id', $colums = "*")
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
        if(isset($condition["pfr_sku"]) && $condition["pfr_sku"] != ""){
            $select->where("pfr_sku = ?",$condition["pfr_sku"]);
        }
        if(isset($condition["pfr_from"]) && $condition["pfr_from"] != ""){
            $select->where("pfr_from = ?",$condition["pfr_from"]);
        }
        if(isset($condition["pfr_country_name"]) && $condition["pfr_country_name"] != ""){
            $select->where("pfr_country_name = ?",$condition["pfr_country_name"]);
        }
        if(isset($condition["pfr_country_code"]) && $condition["pfr_country_code"] != ""){
            $select->where("pfr_country_code = ?",$condition["pfr_country_code"]);
        }
        if(isset($condition["pfr_platform"]) && $condition["pfr_platform"] != ""){
            $select->where("pfr_platform = ?",$condition["pfr_platform"]);
        }
        if(isset($condition["pfr_error_type"]) && $condition["pfr_error_type"] != ""){
            $select->where("pfr_error_type = ?",$condition["pfr_error_type"]);
        }
        if(isset($condition["pfr_quantity"]) && $condition["pfr_quantity"] != ""){
            $select->where("pfr_quantity = ?",$condition["pfr_quantity"]);
        }
        if(isset($condition["pfr_settle_way"]) && $condition["pfr_settle_way"] != ""){
            $select->where("pfr_settle_way = ?",$condition["pfr_settle_way"]);
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
     * @param int $pageSize
     * @param int $page
     * @param string $orderBy
     * @return array|string
     */
    public function getByConditions($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "")
    {

        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        $select->where("1 =?", 1);
        /*CONDITION_START*/

        //多字段查询or
        $ute_ids=explode(',',$condition["ute_id"]);
        $str = '';
        foreach($ute_ids as $k=>$v){
            $str .= " ute_id=$v or";
        }
        $str = trim($str,'or');

        if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("$str");
        }

        if(isset($condition["pfr_id_arr"]) && $condition["pfr_id_arr"] != ""){
            $arr = '';
            foreach ($condition['pfr_id_arr'] as $k =>$v){
                if(!empty($v)){
                    $arr.= " pfr_id = $v or";
                }
            }
            $arr = trim($arr,'or');
            if(!empty($arr)){
                $select->where("$arr");
            }
        }


       /* if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("ute_id IN (?)",$condition["ute_id"]);
        }*/
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("user_id = ?",$condition["user_id"]);
        }
        if(isset($condition["pfr_uuid"]) && $condition["pfr_uuid"] != ""){
            $select->where("pfr_uuid = ?",$condition["pfr_uuid"]);
        }
        if(isset($condition["erp_no"]) && $condition["erp_no"] != ""){
            $select->where("erp_no = ?",$condition["erp_no"]);
        }
        if(isset($condition["pfr_sku"]) && $condition["pfr_sku"] != ""){
            $select->where("pfr_sku like ?","%".$condition["pfr_sku"]."%");
        }
        if(isset($condition["pfr_from"]) && $condition["pfr_from"] != ""){
            $select->where("pfr_from like ?","%".$condition["pfr_from"]."%");
        }
        if(isset($condition["pfr_country_name"]) && $condition["pfr_country_name"] != ""){
            $select->where("pfr_country_name = ?",$condition["pfr_country_name"]);
        }
        if(isset($condition["pfr_country_code"]) && $condition["pfr_country_code"] != ""){
            $select->where("pfr_country_code = ?",$condition["pfr_country_code"]);
        }
        if(isset($condition["pfr_platform"]) && $condition["pfr_platform"] != ""){
            $select->where("pfr_platform = ?",$condition["pfr_platform"]);
        }
        if(isset($condition["pfr_rma_amount"]) && $condition["pfr_rma_amount"] != ""){
            $select->where("pfr_rma_amount = ?",$condition["pfr_rma_amount"]);
        }
        if(isset($condition["pfr_rma_percent"]) && $condition["pfr_rma_percent"] != ""){
            $select->where("pfr_rma_percent = ?",$condition["pfr_rma_percent"]);
        }
        if(isset($condition["pfr_refund_order"]) && $condition["pfr_refund_order"] != ""){
            $select->where("pfr_refund_order = ?",$condition["pfr_refund_order"]);
        }
        if(isset($condition["pfr_refund_cost"]) && $condition["pfr_refund_cost"] != ""){
            $select->where("pfr_refund_cost = ?",$condition["pfr_refund_cost"]);
        }
        if(isset($condition["pfr_cost_unit"]) && $condition["pfr_cost_unit"] != ""){
            $select->where("pfr_cost_unit = ?",$condition["pfr_cost_unit"]);
        }
        if(isset($condition["pfr_reship_order"]) && $condition["pfr_reship_order"] != ""){
            $select->where("pfr_reship_order = ?",$condition["pfr_reship_order"]);
        }
        if(isset($condition["pfr_reship_sku"]) && $condition["pfr_reship_sku"] != ""){
            $select->where("pfr_reship_sku = ?",$condition["pfr_reship_sku"]);
        }
        if(isset($condition["pfr_rma_reason"]) && $condition["pfr_rma_reason"] != ""){
            $select->where("pfr_rma_reason = ?",$condition["pfr_rma_reason"]);
        }
        if(isset($condition["pfr_warehouse_refund_order"]) && $condition["pfr_warehouse_refund_order"] != ""){
            $select->where("pfr_warehouse_refund_order = ?",$condition["pfr_warehouse_refund_order"]);
        }
        if(isset($condition["pfr_warehouse_refund_sku"]) && $condition["pfr_warehouse_refund_sku"] != ""){
            $select->where("pfr_warehouse_refund_sku = ?",$condition["pfr_warehouse_refund_sku"]);
        }
        if(isset($condition["pfr_error_type"]) && $condition["pfr_error_type"] != ""){
            $select->where("pfr_error_type = ?",$condition["pfr_error_type"]);
        }
        if(isset($condition["pfr_quantity"]) && $condition["pfr_quantity"] != ""){
            $select->where("pfr_quantity = ?",$condition["pfr_quantity"]);
        }
        if(isset($condition["pfr_quantity_unit"]) && $condition["pfr_quantity_unit"] != ""){
            $select->where("pfr_quantity_unit = ?",$condition["pfr_quantity_unit"]);
        }
        if(isset($condition["pfr_settle_way"]) && $condition["pfr_settle_way"] != ""){
            $select->where("pfr_settle_way = ?",$condition["pfr_settle_way"]);
        }
        if(isset($condition["firstDateinfo"]) && $condition["firstDateinfo"] != ""){
            $select->where("pfr_appear_time > ? ",$condition["firstDateinfo"]);
        }
        if(isset($condition["endDateinfo"])&& $condition["endDateinfo"] != ""){
            $select->where("pfr_appear_time < ? ",$condition["endDateinfo"]);
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