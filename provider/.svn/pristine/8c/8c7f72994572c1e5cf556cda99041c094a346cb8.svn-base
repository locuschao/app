<?php
class Table_DeliveryOrderItem
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_DeliveryOrderItem();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_DeliveryOrderItem();
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
    public function update($row, $value, $field = "doi_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "doi_id")
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
    public function getByField($value, $field = 'doi_id', $colums = "*")
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
        
        if(isset($condition["do_id"]) && $condition["do_id"] != ""){
            $select->where("do_id = ?",$condition["do_id"]);
        }

        if(isset($condition["doi_sku"]) && $condition["doi_sku"] != ""){
            $select->where("doi_sku like ?","%".$condition["doi_sku"]."%");
        }
        if(isset($condition["doi_name"]) && $condition["doi_name"] != ""){
            $select->where("doi_name = ?",$condition["doi_name"]);
        }
        if(isset($condition["doi_amount"]) && $condition["doi_amount"] != ""){
            $select->where("doi_amount = ?",$condition["doi_amount"]);
        }
        if(isset($condition["doi_unit"]) && $condition["doi_unit"] != ""){
            $select->where("doi_unit = ?",$condition["doi_unit"]);
        }
        if(isset($condition["doi_size"]) && $condition["doi_size"] != ""){
            $select->where("doi_size = ?",$condition["doi_size"]);
        }
        if(isset($condition["doi_weight"]) && $condition["doi_weight"] != ""){
            $select->where("doi_weight = ?",$condition["doi_weight"]);
        }
        if(isset($condition["doi_weight_unit"]) && $condition["doi_weight_unit"] != ""){
            $select->where("doi_weight_unit = ?",$condition["doi_weight_unit"]);
        }
        if(isset($condition["doi_box_gw"]) && $condition["doi_box_gw"] != ""){
            $select->where("doi_box_gw = ?",$condition["doi_box_gw"]);
        }
        if(isset($condition["doi_box_gw_unit"]) && $condition["doi_box_gw_unit"] != ""){
            $select->where("doi_box_gw_unit = ?",$condition["doi_box_gw_unit"]);
        }
        if(isset($condition["doi_box_total_gw"]) && $condition["doi_box_total_gw"] != ""){
            $select->where("doi_box_total_gw = ?",$condition["doi_box_total_gw"]);
        }
        if(isset($condition["doi_box_total_gw_unit"]) && $condition["doi_box_total_gw_unit"] != ""){
            $select->where("doi_box_total_gw_unit = ?",$condition["doi_box_total_gw_unit"]);
        }
        if(isset($condition["doi_box_nw"]) && $condition["doi_box_nw"] != ""){
            $select->where("doi_box_nw = ?",$condition["doi_box_nw"]);
        }
        if(isset($condition["doi_box_nw_unit"]) && $condition["doi_box_nw_unit"] != ""){
            $select->where("doi_box_nw_unit = ?",$condition["doi_box_nw_unit"]);
        }
        if(isset($condition["doi_box_total_nw"]) && $condition["doi_box_total_nw"] != ""){
            $select->where("doi_box_total_nw = ?",$condition["doi_box_total_nw"]);
        }
        if(isset($condition["doi_box_total_nw_unit"]) && $condition["doi_box_total_nw_unit"] != ""){
            $select->where("doi_box_total_nw_unit = ?",$condition["doi_box_total_nw_unit"]);
        }
        if(isset($condition["doi_total_box"]) && $condition["doi_total_box"] != ""){
            $select->where("doi_total_box = ?",$condition["doi_total_box"]);
        }
        if(isset($condition["doi_total_cube"]) && $condition["doi_total_cube"] != ""){
            $select->where("doi_total_cube = ?",$condition["doi_total_cube"]);
        }
        if(isset($condition["doi_box_size"]) && $condition["doi_box_size"] != ""){
            $select->where("doi_box_size = ?",$condition["doi_box_size"]);
        }
        if(isset($condition["doi_box_no"]) && $condition["doi_box_no"] != ""){
            $select->where("doi_box_no = ?",$condition["doi_box_no"]);
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
    } /**
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


        $doId=$condition["do_id"];
        //多字段查询or
        $do_ids=explode(',',$doId);
        $str = '';
        foreach($do_ids as $k=>$v){
            $str .= " do_id=$v or";
        }
        $strs = trim($str,'or');
        if(isset($condition["do_id"]) && $condition["do_id"] != ""){
            $select->where("$strs");
        }

        if(isset($condition["doi_sku"]) && $condition["doi_sku"] != ""){
            $select->where("doi_sku like ?","%".$condition["doi_sku"]."%");
        }
        if(isset($condition["doi_name"]) && $condition["doi_name"] != ""){
            $select->where("doi_name = ?",$condition["doi_name"]);
        }
        if(isset($condition["doi_amount"]) && $condition["doi_amount"] != ""){
            $select->where("doi_amount = ?",$condition["doi_amount"]);
        }
        if(isset($condition["doi_unit"]) && $condition["doi_unit"] != ""){
            $select->where("doi_unit = ?",$condition["doi_unit"]);
        }
        if(isset($condition["doi_size"]) && $condition["doi_size"] != ""){
            $select->where("doi_size = ?",$condition["doi_size"]);
        }
        if(isset($condition["doi_weight"]) && $condition["doi_weight"] != ""){
            $select->where("doi_weight = ?",$condition["doi_weight"]);
        }
        if(isset($condition["doi_weight_unit"]) && $condition["doi_weight_unit"] != ""){
            $select->where("doi_weight_unit = ?",$condition["doi_weight_unit"]);
        }
        if(isset($condition["doi_box_gw"]) && $condition["doi_box_gw"] != ""){
            $select->where("doi_box_gw = ?",$condition["doi_box_gw"]);
        }
        if(isset($condition["doi_box_gw_unit"]) && $condition["doi_box_gw_unit"] != ""){
            $select->where("doi_box_gw_unit = ?",$condition["doi_box_gw_unit"]);
        }
        if(isset($condition["doi_box_total_gw"]) && $condition["doi_box_total_gw"] != ""){
            $select->where("doi_box_total_gw = ?",$condition["doi_box_total_gw"]);
        }
        if(isset($condition["doi_box_total_gw_unit"]) && $condition["doi_box_total_gw_unit"] != ""){
            $select->where("doi_box_total_gw_unit = ?",$condition["doi_box_total_gw_unit"]);
        }
        if(isset($condition["doi_box_nw"]) && $condition["doi_box_nw"] != ""){
            $select->where("doi_box_nw = ?",$condition["doi_box_nw"]);
        }
        if(isset($condition["doi_box_nw_unit"]) && $condition["doi_box_nw_unit"] != ""){
            $select->where("doi_box_nw_unit = ?",$condition["doi_box_nw_unit"]);
        }
        if(isset($condition["doi_box_total_nw"]) && $condition["doi_box_total_nw"] != ""){
            $select->where("doi_box_total_nw = ?",$condition["doi_box_total_nw"]);
        }
        if(isset($condition["doi_box_total_nw_unit"]) && $condition["doi_box_total_nw_unit"] != ""){
            $select->where("doi_box_total_nw_unit = ?",$condition["doi_box_total_nw_unit"]);
        }
        if(isset($condition["doi_total_box"]) && $condition["doi_total_box"] != ""){
            $select->where("doi_total_box = ?",$condition["doi_total_box"]);
        }
        if(isset($condition["doi_total_cube"]) && $condition["doi_total_cube"] != ""){
            $select->where("doi_total_cube = ?",$condition["doi_total_cube"]);
        }
        if(isset($condition["doi_box_size"]) && $condition["doi_box_size"] != ""){
            $select->where("doi_box_size = ?",$condition["doi_box_size"]);
        }
        if(isset($condition["doi_box_no"]) && $condition["doi_box_no"] != ""){
            $select->where("doi_box_no = ?",$condition["doi_box_no"]);
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