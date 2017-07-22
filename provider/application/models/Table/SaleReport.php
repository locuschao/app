<?php
class Table_SaleReport
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_SaleReport();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_SaleReport();
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

        if(isset($condition["erp_no"]) && $condition["erp_no"] != ""){
            $select->where("erp_no = ?",$condition["erp_no"]);
        }
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("user_id = ?",$condition["user_id"]);
        }
        if(isset($condition["sr_sku"]) && $condition["sr_sku"] != ""){
            $select->where("sr_sku = ?",$condition["sr_sku"]);
        }
        if(isset($condition["sr_platform"]) && $condition["sr_platform"] != ""){
            $select->where("sr_platform = ?",$condition["sr_platform"]);
        }
        if(isset($condition["sr_from"]) && $condition["sr_from"] != ""){
            $select->where("sr_from LIKE ?",'%'.$condition["sr_from"].'%');
        }
        if(isset($condition["sr_sale_gross"]) && $condition["sr_sale_gross"] != ""){
            $select->where("sr_sale_gross = ?",$condition["sr_sale_gross"]);
        }
        if(isset($condition["sr_ship_fee"]) && $condition["sr_ship_fee"] != ""){
            $select->where("sr_ship_fee = ?",$condition["sr_ship_fee"]);
        }
        if(isset($condition["sr_cost"]) && $condition["sr_cost"] != ""){
            $select->where("sr_cost = ?",$condition["sr_cost"]);
        }
        if(isset($condition["sr_price"]) && $condition["sr_price"] != ""){
            $select->where("sr_price = ?",$condition["sr_price"]);
        }
        if(isset($condition["sr_poundage"]) && $condition["sr_poundage"] != ""){
            $select->where("sr_poundage = ?",$condition["sr_poundage"]);
        }
        if(isset($condition["sr_service_ship_fee"]) && $condition["sr_service_ship_fee"] != ""){
            $select->where("sr_service_ship_fee = ?",$condition["sr_service_ship_fee"]);
        }
        if(isset($condition["sr_refund_fee"]) && $condition["sr_refund_fee"] != ""){
            $select->where("sr_refund_fee = ?",$condition["sr_refund_fee"]);
        }
        if(isset($condition["sr_amount"]) && $condition["sr_amount"] != ""){
            $select->where("sr_amount = ?",$condition["sr_amount"]);
        }
        if(isset($condition["sr_increase_rate"]) && $condition["sr_increase_rate"] != ""){
            $select->where("sr_increase_rate = ?",$condition["sr_increase_rate"]);
        }
        if(isset($condition["startTime"]) && $condition["startTime"] != ""){
            $select->where("sr_update_time >= ?",$condition["startTime"]);
        }
        if(isset($condition["endTime"]) && $condition["endTime"] != ""){
            $select->where("sr_update_time <= ?",$condition["endTime"]);
        }
        /*CONDITION_END*/
        if ('count(*)' == $type) {

            return $this->_table->getAdapter()->fetchOne($select);
        } else {
            if (!empty($orderBy)){
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
     * @desc 插入多条记录(注意：某条记录待插入字段如果没有值，将默认为String '')
     * @param array $paramsArray 包含多个字段数组的数组，字段数组键名为字段名，值为字段值
     * @return integer number of rows affected by the execution OR false
     * @date 2017-03-24
     */
    public function insertMulti($paramsArray){
        if(empty($paramsArray)){
            return false;
        }

        // Get all columns that need to insert
        $columns = array();
        foreach($paramsArray as $rowData){
            foreach($rowData as $columnName => $columnValue){
                if(!in_array($columnName, $columns, true)) {
                    if($columnName !== null){
                        $columns[]=$columnName;
                    }
                }
            }
        }

        $paramCount = 0;
        $paramValues = array();
        $rowInsertValuesArray = array();
        // 遍历待插入数据数组，构建插入数据sql
        foreach($paramsArray as $rowData){
            $rowValues = array();
            foreach ($columns as $columnName) {
                if(isset($rowData[$columnName])){
                    $rowValues[$columnName] = "'".$rowData[$columnName]."'";
                } else {
                    $rowValues[$columnName] = '\'\'';
                }
                $paramCount++;
            }
            $rowInsertValuesArray[] = '('.implode(',', $rowValues).')';
        }

        $columnInsertNames = '('.implode(',', $columns).')';
        $rowInsertValues = implode(',', $rowInsertValuesArray);
        $sql = "INSERT INTO `{$this->_table->info('name')}` {$columnInsertNames} VALUES {$rowInsertValues};";
        try{
            $affectRows = $this->_table->getAdapter()->exec($sql);
            return $affectRows;
        } catch (Exception $ex){
            return false;
        }
    }
}