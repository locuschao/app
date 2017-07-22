<?php
class Table_Products
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_Products();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_Products();
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

        if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where("ute_id = ?",$condition["ute_id"]);
        }
        if(isset($condition["product_id"]) && $condition["product_id"] != ""){
            $select->where("product_id = ?",$condition["product_id"]);
        }
        if(isset($condition["ute_erp_name"]) && $condition["ute_erp_name"] != ""){
            $select->where("ute_erp_name like ?","%".$condition["ute_erp_name"]."%");
        }
        if(isset($condition["product_sku"]) && $condition["product_sku"] != ""){
            $select->where("product_sku like ?","%".$condition["product_sku"]."%");
        }
        if(isset($condition["product_name"]) && $condition["product_name"] != ""){
            $select->where("product_name = ?",$condition["product_name"]);
        }
        if(isset($condition["product_name_en"]) && $condition["product_name_en"] != ""){
            $select->where("product_name_en = ?",$condition["product_name_en"]);
        }
        if(isset($condition["product_status"]) && $condition["product_status"] != ""){
            $select->where("product_status = ?",$condition["product_status"]);
        }
        if(isset($condition["product_spu"]) && $condition["product_spu"] != ""){
            $select->where("product_spu = ?",$condition["product_spu"]);
        }
        if(isset($condition["product_color"]) && $condition["product_color"] != ""){
            $select->where("product_color = ?",$condition["product_color"]);
        }
        if(isset($condition["product_long"]) && $condition["product_long"] != ""){
            $select->where("product_long = ?",$condition["product_long"]);
        }
        if(isset($condition["product_width"]) && $condition["product_width"] != ""){
            $select->where("product_width = ?",$condition["product_width"]);
        }
        if(isset($condition["product_heigh"]) && $condition["product_heigh"] != ""){
            $select->where("product_heigh = ?",$condition["product_heigh"]);
        }
        if(isset($condition["product_size_unit"]) && $condition["product_size_unit"] != ""){
            $select->where("product_size_unit = ?",$condition["product_size_unit"]);
        }
        if(isset($condition["product_weight"]) && $condition["product_weight"] != ""){
            $select->where("product_weight = ?",$condition["product_weight"]);
        }
        if(isset($condition["product_weig_unit"]) && $condition["product_weig_unit"] != ""){
            $select->where("product_weig_unit = ?",$condition["product_weig_unit"]);
        }
        if(isset($condition["product_price"]) && $condition["product_price"] != ""){
            $select->where("product_price = ?",$condition["product_price"]);
        }
        if(isset($condition["product_price_unit"]) && $condition["product_price_unit"] != ""){
            $select->where("product_price_unit = ?",$condition["product_price_unit"]);
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
    }  /**
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

        $uteId=$condition["ute_id"];

        //多字段查询or
        $str = '';
        foreach($uteId as $k=>$v){
            $str .= " ute_id=$v or";
        }
        $strs = trim($str,'or');
        if(isset($condition["ute_id"]) && $condition["ute_id"] != ""){
            $select->where($strs);
        }
        if(isset($condition["product_id"]) && $condition["product_id"] != ""){
            $select->where("product_id = ?",$condition["product_id"]);
        }
        if(isset($condition["ute_erp_name"]) && $condition["ute_erp_name"] != ""){
            $select->where("ute_erp_name like ?","%".$condition["ute_erp_name"]."%");
        }
        if(isset($condition["product_sku"]) && $condition["product_sku"] != ""){
            $select->where("product_sku like ?","%".$condition["product_sku"]."%");
        }
        if(isset($condition["product_name"]) && $condition["product_name"] != ""){
            $select->where("product_name = ?",$condition["product_name"]);
        }
        if(isset($condition["product_name_en"]) && $condition["product_name_en"] != ""){
            $select->where("product_name_en = ?",$condition["product_name_en"]);
        }
        if(isset($condition["product_status"]) && $condition["product_status"] != ""){
            $select->where("product_status = ?",$condition["product_status"]);
        }
        if(isset($condition["product_spu"]) && $condition["product_spu"] != ""){
            $select->where("product_spu = ?",$condition["product_spu"]);
        }
        if(isset($condition["product_color"]) && $condition["product_color"] != ""){
            $select->where("product_color = ?",$condition["product_color"]);
        }
        if(isset($condition["product_long"]) && $condition["product_long"] != ""){
            $select->where("product_long = ?",$condition["product_long"]);
        }
        if(isset($condition["product_width"]) && $condition["product_width"] != ""){
            $select->where("product_width = ?",$condition["product_width"]);
        }
        if(isset($condition["product_heigh"]) && $condition["product_heigh"] != ""){
            $select->where("product_heigh = ?",$condition["product_heigh"]);
        }
        if(isset($condition["product_size_unit"]) && $condition["product_size_unit"] != ""){
            $select->where("product_size_unit = ?",$condition["product_size_unit"]);
        }
        if(isset($condition["product_weight"]) && $condition["product_weight"] != ""){
            $select->where("product_weight = ?",$condition["product_weight"]);
        }
        if(isset($condition["product_weig_unit"]) && $condition["product_weig_unit"] != ""){
            $select->where("product_weig_unit = ?",$condition["product_weig_unit"]);
        }
        if(isset($condition["product_price"]) && $condition["product_price"] != ""){
            $select->where("product_price = ?",$condition["product_price"]);
        }
        if(isset($condition["product_price_unit"]) && $condition["product_price_unit"] != ""){
            $select->where("product_price_unit = ?",$condition["product_price_unit"]);
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