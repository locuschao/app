<?php
class Table_StockReport
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_StockReport();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_StockReport();
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
    public function update($row, $value, $field = "sr_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "sr_id")
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
    public function getByField($value, $field = 'sr_id', $colums = "*")
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
        
       /* if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("user_id = ?",$condition["user_id"]);
        }*/
        //多字段查询or
        $ute_ids=explode(',',$condition["ute_id"]);
        $str = '';
        foreach($ute_ids as $k=>$v){
            $str .= " ute_id=$v or";
        }
        $str = trim($str,'or');


        if(isset($condition["sr_id_arr"]) && $condition["sr_id_arr"] != ""){
            $arr = '';
            foreach ($condition['sr_id_arr'] as $k =>$v){
                if(!empty($v)){
                    $arr.= " sr_id = $v or";
                }
            }
            $arr = trim($arr,'or');
            if(!empty($arr)){
                $select->where("$arr");
            }
        }
        if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("$str");
        }
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("user_id = ?",$condition["user_id"]);
        }

        if(isset($condition["erp_no"]) && $condition["erp_no"] != ""){
            $select->where("erp_no = ?",$condition["erp_no"]);
        }
        if(isset($condition["sr_sku"]) && $condition["sr_sku"] != ""){
            $select->where("sr_sku = ?",$condition["sr_sku"]);
        }
        if(isset($condition["sr_spu"]) && $condition["sr_spu"] != ""){
            $select->where("sr_spu = ?",$condition["sr_spu"]);
        }
        if(isset($condition["sr_category"]) && $condition["sr_category"] != ""){
            $select->where("sr_category = ?",$condition["sr_category"]);
        }
        if(isset($condition["sr_warehouse"])){
            $select->where("sr_warehouse = ?",$condition["sr_warehouse"]);
        }
        if(isset($condition["sr_purchasing_amount"]) && $condition["sr_purchasing_amount"] != ""){
            $select->where("sr_purchasing_amount = ?",$condition["sr_purchasing_amount"]);
        }
        if(isset($condition["sr_shipping_amount"]) && $condition["sr_shipping_amount"] != ""){
            $select->where("sr_shipping_amount = ?",$condition["sr_shipping_amount"]);
        }
        if(isset($condition["sr_available_amount"]) && $condition["sr_available_amount"] != ""){
            $select->where("sr_available_amount = ?",$condition["sr_available_amount"]);
        }
        if(isset($condition["sr_stock_amount"]) && $condition["sr_stock_amount"] != ""){
            $select->where("sr_stock_amount = ?",$condition["sr_stock_amount"]);
        }
        if(isset($condition["sr_turnove_rates"]) && $condition["sr_turnove_rates"] != ""){
            $select->where("sr_turnove_rates = ?",$condition["sr_turnove_rates"]);
        }
        if(isset($condition["sr_stock_cost"]) && $condition["sr_stock_cost"] != ""){
            $select->where("sr_stock_cost = ?",$condition["sr_stock_cost"]);
        }
        if(isset($condition["sr_save_day"]) && $condition["sr_save_day"] != ""){
            $select->where("sr_save_day = ?",$condition["sr_save_day"]);
        }
        if(isset($condition["firstDateinfo"]) && $condition["firstDateinfo"] != ""){
            $select->where("sr_create_time > ? ",$condition["firstDateinfo"]);
        }
        if(isset($condition["endDateinfo"])&& $condition["endDateinfo"] != ""){
            $select->where("sr_create_time < ? ",$condition["endDateinfo"]);
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

        /* if(isset($condition["user_id"]) && $condition["user_id"] != ""){
             $select->where("user_id = ?",$condition["user_id"]);
         }*/
        //多字段查询or
        $ute_ids=explode(',',$condition["ute_id"]);

        $str = '';
        foreach($ute_ids as $k=>$v){
            $str .= " ute_id=$v or";
        }
        $str = trim($str,'or');


        if(isset($condition["sr_id_arr"]) && $condition["sr_id_arr"] != ""){
            $arr = '';
            foreach ($condition['sr_id_arr'] as $k =>$v){
                if(!empty($v)){
                    $arr.= " sr_id = $v or";
                }
            }
            $arr = trim($arr,'or');
            if(!empty($arr)){
                $select->where("$arr");
            }
        }
        if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("$str");
        }
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("user_id = ?",$condition["user_id"]);
        }

        if(isset($condition["erp_no"]) && $condition["erp_no"] != ""){
            $select->where("erp_no = ?",$condition["erp_no"]);
        }
        if(isset($condition["sr_sku"]) && $condition["sr_sku"] != ""){
            $select->where("sr_sku like ?","%".$condition["sr_sku"]."%");
        }
        if(isset($condition["sr_spu"]) && $condition["sr_spu"] != ""){
            $select->where("sr_spu = ?",$condition["sr_spu"]);
        }
        if(isset($condition["sr_category"]) && $condition["sr_category"] != ""){
            $select->where("sr_category = ?",$condition["sr_category"]);
        }
        if(isset($condition["sr_warehouse"]) && $condition["sr_warehouse"] != ""){
            $select->where("sr_warehouse = ?",$condition["sr_warehouse"]);
        }
        if(isset($condition["sr_purchasing_amount"]) && $condition["sr_purchasing_amount"] != ""){
            $select->where("sr_purchasing_amount = ?",$condition["sr_purchasing_amount"]);
        }
        if(isset($condition["sr_shipping_amount"]) && $condition["sr_shipping_amount"] != ""){
            $select->where("sr_shipping_amount = ?",$condition["sr_shipping_amount"]);
        }
        if(isset($condition["sr_available_amount"]) && $condition["sr_available_amount"] != ""){
            $select->where("sr_available_amount = ?",$condition["sr_available_amount"]);
        }
        if(isset($condition["sr_stock_amount"]) && $condition["sr_stock_amount"] != ""){
            $select->where("sr_stock_amount = ?",$condition["sr_stock_amount"]);
        }
        if(isset($condition["sr_turnove_rates"]) && $condition["sr_turnove_rates"] != ""){
            $select->where("sr_turnove_rates = ?",$condition["sr_turnove_rates"]);
        }
        if(isset($condition["sr_stock_cost"]) && $condition["sr_stock_cost"] != ""){
            $select->where("sr_stock_cost = ?",$condition["sr_stock_cost"]);
        }
        if(isset($condition["sr_save_day"]) && $condition["sr_save_day"] != ""){
            $select->where("sr_save_day = ?",$condition["sr_save_day"]);
        }
        if(isset($condition["firstDateinfo"]) && $condition["firstDateinfo"] != ""){
            $select->where("sr_create_time > ? ",$condition["firstDateinfo"]);
        }
        if(isset($condition["endDateinfo"])&& $condition["endDateinfo"] != ""){
            $select->where("sr_create_time < ? ",$condition["endDateinfo"]);
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