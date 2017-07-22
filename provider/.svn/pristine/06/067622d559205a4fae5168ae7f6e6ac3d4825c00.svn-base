<?php
class Table_DeliveryOrder
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_DeliveryOrder();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_DeliveryOrder();
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
    public function update($row, $value, $field = "do_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "do_id")
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
    public function getByField($value, $field = 'do_id', $colums = "*")
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
     * @des 功能获取指定装箱的货物的信息
     * @param array $condition
     * @return mixed
     * @date 2017-5-9
     * @author blank
     */
    public function getInfoDetail($condition=array())
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table.' as o', '*');
        $select->joinLeft('delivery_order_item as op',"op.do_id=o.do_id");
        $select->where("1 =?", 1);
        $strs = '';
        if(is_array($condition["do_id"])){
            $doId=$condition["do_id"];
        }else{
            $doId[]=$condition["do_id"];
        }
            foreach($doId as $k=>$v){
                $strs .= " op.do_id=$v or";
            }
            $do_id = trim($strs,'or');

        if(isset($condition["do_id"]) && $condition["do_id"] != ""){
            $select->where("$do_id");
        }
        if(isset($condition["do_status"]) && $condition["do_status"] != ""){
            $select->where("o.do_status = ?",$condition["do_status"]);
        }
            $sql = $select->__toString();
            return $this->_table->getAdapter()->fetchAll($sql);
    }

    /**
     * @des 通过do_no获取指定的发货单信息
     * @param array $condition
     * @return mixed
     * @date 2017-5-25
     * @author blank
     */
    public function getByDoNO($condition=array())
    {

        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table);
        $select->where("1 =?", 1);
        if(isset($condition) && $condition != ""){
            $select->where("do_no = ?",$condition);
        }
        $sql = $select->__toString();
        return $this->_table->getAdapter()->fetchAll($sql);
    }

    /**
     * @desc 通过状态获取所有的订单号
     * @param array
     * @date 2017-6-5
     * @author blank
     * @return mixed
     */
    public function getOrderBystatu($condition=array()){
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table.' as o', '*');
        $select->joinLeft('user_to_erp as erp',"erp.ute_id=o.ute_id");
        $select->where("1 =?", 1);
        if(isset($condition) && $condition != ""){
            $select->where("do_status = ?",$condition);
        }
        $sql = $select->__toString();
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
        $doId=$condition["do_id"];
        $strs = '';
        foreach(explode(",",$doId) as $k=>$v){
            $strs .= " do_id=$v or";
        }
        $do_id = trim($strs,'or');
        if(isset($condition["do_id"]) && $condition["do_id"] != ""){
            $select->where("$do_id");
        }
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("user_id = ?",$condition["user_id"]);
        }
       if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("ute_id = ?",$condition["ute_id"]);
        }
        if(isset($condition["do_no"]) && $condition["do_no"] != ""){
            $select->where("do_no = ?",$condition["do_no"]);
        }
        if(isset($condition["do_ship_no"]) && $condition["do_ship_no"] != ""){
            $select->where("do_ship_no = ?",$condition["do_ship_no"]);
        }
        if(isset($condition["do_company"]) && $condition["do_company"] != ""){
            $select->where("do_company = ?",$condition["do_company"]);
        }
        if(isset($condition["do_ship_company"]) && $condition["do_ship_company"] != ""){
            $select->where("do_ship_company = ?",$condition["do_ship_company"]);
        }
        if(isset($condition["do_ship_fee"]) && $condition["do_ship_fee"] != ""){
            $select->where("do_ship_fee = ?",$condition["do_ship_fee"]);
        }
        if(isset($condition["do_status"]) && $condition["do_status"] != ""){
            $select->where("do_status = ?",$condition["do_status"]);
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
     * @des 通过do_id 获取发送单对应的erp
     * @param array $condition
     * @return mixed
     */
    public function getErpByDoid($condition = array())
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table);
        $select->where("1 =?", 1);
        /*CONDITION_START*/
        if(isset($condition['do_id']) && $condition['do_id'] != ""){
            $select->where("do_id IN (?)",$condition["do_id"]);
        }
            $sql = $select->__toString();
            return $this->_table->getAdapter()->fetchAll($sql);

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
        if($condition["ute_id"] == ""){
            return  false;
        }
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        $select->where("1 =?", 1);
        /*CONDITION_START*/

        $doId=$condition["do_id"];

        $strs = '';
        foreach($doId as $k=>$v){
            $strs .= " do_id=$v or";
        }
        $do_id = trim($strs,'or');

        if(isset($condition["do_id"]) && $condition["do_id"] != ""){
            $select->where("$do_id");
        }
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
        if(isset($condition["do_no"]) && $condition["do_no"] != ""){
            $select->where("do_no like ?","%".$condition["do_no"]."%");
        }
        if(isset($condition["do_ship_no"]) && $condition["do_ship_no"] != ""){
            $select->where("do_ship_no like ?","%".$condition["do_ship_no"]."%");
        }
        if(isset($condition["do_company"]) && $condition["do_company"] != ""){
            $select->where("do_company like ?","%".$condition["do_company"]."%");
        }
        if(isset($condition["do_ship_company"]) && $condition["do_ship_company"] != ""){
            $select->where("do_ship_company = ?",$condition["do_ship_company"]);
        }
        if(isset($condition["do_ship_fee"]) && $condition["do_ship_fee"] != ""){
            $select->where("do_ship_fee = ?",$condition["do_ship_fee"]);
        }
        if(isset($condition["do_status"]) && $condition["do_status"] != ""){
            $select->where("do_status = ?",$condition["do_status"]);
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
     * @param string $join
     * @return array|string
     */
    public function getByGroup($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "", $group = "") {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        $select->where("1 =?", 1);
        /*CONDITION_START*/

        $doId=$condition["do_id"];

        $strs = '';
        foreach($doId as $k=>$v){
            $strs .= " do_id=$v or";
        }
        $do_id = trim($strs,'or');

        if(isset($condition["do_id"]) && $condition["do_id"] != ""){
            $select->where("$do_id");
        }
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
        if(isset($condition["do_no"]) && $condition["do_no"] != ""){
            $select->where("do_no like ?","%".$condition["do_no"]."%");
        }
        if(isset($condition["do_ship_no"]) && $condition["do_ship_no"] != ""){
            $select->where("do_ship_no like ?","%".$condition["do_ship_no"]."%");
        }
        if(isset($condition["do_company"]) && $condition["do_company"] != ""){
            $select->where("do_company like ?","%".$condition["do_company"]."%");
        }
        if(isset($condition["do_ship_company"]) && $condition["do_ship_company"] != ""){
            $select->where("do_ship_company = ?",$condition["do_ship_company"]);
        }
        if(isset($condition["do_ship_fee"]) && $condition["do_ship_fee"] != ""){
            $select->where("do_ship_fee = ?",$condition["do_ship_fee"]);
        }
        if(isset($condition["do_status"]) && $condition["do_status"] != ""){
            $select->where("do_status = ?",$condition["do_status"]);
        }

        /*CONDITION_END*/
        if (!empty($group)) {
            $select->group($group);
        }
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