<?php
class Table_Bidding
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_Bidding();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_Bidding();
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
    public function update($row, $value, $field = "bidding_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "bidding_id")
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
    public function getByField($value, $field = 'bidding_id', $colums = "*")
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
        
        if(isset($condition["ute_erp_no"]) && $condition["ute_erp_no"] != ""){
            $select->where("ute_erp_no = ?",$condition["ute_erp_no"]);
        }
        if(isset($condition["bidding_no"]) && $condition["bidding_no"] != ""){
            $select->where("bidding_no = ?",$condition["bidding_no"]);
        }
        if(isset($condition["bidding_name"]) && $condition["bidding_name"] != ""){
            $select->where("bidding_name = ?",$condition["bidding_name"]);
        }
        if(isset($condition["bidding_name_en"]) && $condition["bidding_name_en"] != ""){
            $select->where("bidding_name_en = ?",$condition["bidding_name_en"]);
        }
        if(isset($condition["bidding_long"]) && $condition["bidding_long"] != ""){
            $select->where("bidding_long = ?",$condition["bidding_long"]);
        }
        if(isset($condition["bidding_width"]) && $condition["bidding_width"] != ""){
            $select->where("bidding_width = ?",$condition["bidding_width"]);
        }
        if(isset($condition["bidding_heigh"]) && $condition["bidding_heigh"] != ""){
            $select->where("bidding_heigh = ?",$condition["bidding_heigh"]);
        }
        if(isset($condition["bidding_size_unit"]) && $condition["bidding_size_unit"] != ""){
            $select->where("bidding_size_unit = ?",$condition["bidding_size_unit"]);
        }
        if(isset($condition["bidding_color"]) && $condition["bidding_color"] != ""){
            $select->where("bidding_color = ?",$condition["bidding_color"]);
        }
        if(isset($condition["bidding_amount"]) && $condition["bidding_amount"] != ""){
            $select->where("bidding_amount = ?",$condition["bidding_amount"]);
        }
        if(isset($condition["bidding_amount_unit"]) && $condition["bidding_amount_unit"] != ""){
            $select->where("bidding_amount_unit = ?",$condition["bidding_amount_unit"]);
        }
        if(isset($condition["bidding_status"]) && $condition["bidding_status"] != ""){
            $select->where("bidding_status = ?",$condition["bidding_status"]);
        }
        if(isset($condition["bidding_product_url"]) && $condition["bidding_product_url"] != ""){
            $select->where("bidding_product_url = ?",$condition["bidding_product_url"]);
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
     * @return mixed
     */
    public function getByConditionJoinPSU($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        $select->joinLeft('bidding_pictures', 'bidding_pictures.bidding_id='.$table.'.bidding_id',array('bp_url'));
        $select->joinLeft('samples', 'samples.bidding_id='.$table.'.bidding_id',array(
            'sample_no',
            'sample_result',
            'sample_reason',
            'sample_price',
            'sample_price_unit',
        ));
        $select->joinLeft('user_to_erp', 'user_to_erp.ute_erp_no='.$table.'.ute_erp_no',null);
        $select->joinLeft('user', 'user.user_id=user_to_erp.user_id',array('user_name','user_name_en'));
        $select->where("1 =?", 1);
        /*CONDITION_START*/
        if(isset($condition["ute_erp_no"]) && $condition["ute_erp_no"] != ""){
            $select->where("ute_erp_no = ?",$condition["ute_erp_no"]);
        }
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("samples.user_id = ?",$condition["user_id"]);
        }
        if(isset($condition["bidding_no"]) && $condition["bidding_no"] != ""){
            $select->where("bidding_no = ?",$condition["bidding_no"]);
        }
        if(isset($condition["bidding_name"]) && $condition["bidding_name"] != ""){
            $select->where("bidding_name = ?",$condition["bidding_name"]);
        }
        if(isset($condition["bidding_name_en"]) && $condition["bidding_name_en"] != ""){
            $select->where("bidding_name_en = ?",$condition["bidding_name_en"]);
        }
        if(isset($condition["bidding_long"]) && $condition["bidding_long"] != ""){
            $select->where("bidding_long = ?",$condition["bidding_long"]);
        }
        if(isset($condition["dso_id"]) && $condition["dso_id"] != ""){
            $select->where("dso_id = ?",$condition["dso_id"]);
        }
        if(isset($condition["bidding_width"]) && $condition["bidding_width"] != ""){
            $select->where("bidding_width = ?",$condition["bidding_width"]);
        }
        if(isset($condition["bidding_heigh"]) && $condition["bidding_heigh"] != ""){
            $select->where("bidding_heigh = ?",$condition["bidding_heigh"]);
        }
        if(isset($condition["bidding_size_unit"]) && $condition["bidding_size_unit"] != ""){
            $select->where("bidding_size_unit = ?",$condition["bidding_size_unit"]);
        }
        if(isset($condition["bidding_color"]) && $condition["bidding_color"] != ""){
            $select->where("bidding_color = ?",$condition["bidding_color"]);
        }
        if(isset($condition["bidding_amount"]) && $condition["bidding_amount"] != ""){
            $select->where("bidding_amount = ?",$condition["bidding_amount"]);
        }
        if(isset($condition["bidding_amount_unit"]) && $condition["bidding_amount_unit"] != ""){
            $select->where("bidding_amount_unit = ?",$condition["bidding_amount_unit"]);
        }
        if(isset($condition["bidding_status"]) && $condition["bidding_status"] != ""){
            $select->where("bidding_status = ?",$condition["bidding_status"]);
        }
        if(isset($condition["bidding_product_url"]) && $condition["bidding_product_url"] != ""){
            $select->where("bidding_product_url = ?",$condition["bidding_product_url"]);
        }
        if(isset($condition["sample_no"]) && $condition["sample_no"] != ""){
            $select->where("samples.sample_no like ?",'%'.$condition["sample_no"].'%');
        }
        if(isset($condition["ute_erp_name"]) && $condition["ute_erp_name"] != ""){
            $select->where("user_to_erp.ute_erp_name like ?",'%'.$condition["ute_erp_name"].'%');
        }
        if(isset($condition["sample_result"]) && $condition["sample_result"] != ""){
            $select->where("samples.sample_result = ?",$condition["sample_result"]);
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
    public function getByConditionJoinSamples($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        $select->joinLeft('samples', 'samples.bidding_id='.$table.'.bidding_id',array(
            'sample_no',
        ));
        $select->where("1 =?", 1);
        /*CONDITION_START*/
        if(isset($condition["bidding_id_in"]) && $condition["bidding_id_in"] != "" && is_array($condition["bidding_id_in"])){
            $select->where($table.".bidding_id in (?)",$condition["bidding_id_in"]);
        }
        if(isset($condition["ute_erp_no"]) && $condition["ute_erp_no"] != ""){
            $select->where("ute_erp_no = ?",$condition["ute_erp_no"]);
        }
        if(isset($condition["bidding_no"]) && $condition["bidding_no"] != ""){
            $select->where("bidding_no = ?",$condition["bidding_no"]);
        }
        if(isset($condition["dso_id"]) && $condition["dso_id"] != ""){
            $select->where("dso_id = ?",$condition["dso_id"]);
        }
        if(isset($condition["bidding_name"]) && $condition["bidding_name"] != ""){
            $select->where("bidding_name = ?",$condition["bidding_name"]);
        }
        if(isset($condition["bidding_name_en"]) && $condition["bidding_name_en"] != ""){
            $select->where("bidding_name_en = ?",$condition["bidding_name_en"]);
        }
        if(isset($condition["bidding_long"]) && $condition["bidding_long"] != ""){
            $select->where("bidding_long = ?",$condition["bidding_long"]);
        }
        if(isset($condition["bidding_width"]) && $condition["bidding_width"] != ""){
            $select->where("bidding_width = ?",$condition["bidding_width"]);
        }
        if(isset($condition["bidding_heigh"]) && $condition["bidding_heigh"] != ""){
            $select->where("bidding_heigh = ?",$condition["bidding_heigh"]);
        }
        if(isset($condition["bidding_size_unit"]) && $condition["bidding_size_unit"] != ""){
            $select->where("bidding_size_unit = ?",$condition["bidding_size_unit"]);
        }
        if(isset($condition["bidding_color"]) && $condition["bidding_color"] != ""){
            $select->where("bidding_color = ?",$condition["bidding_color"]);
        }
        if(isset($condition["bidding_amount"]) && $condition["bidding_amount"] != ""){
            $select->where("bidding_amount = ?",$condition["bidding_amount"]);
        }
        if(isset($condition["bidding_amount_unit"]) && $condition["bidding_amount_unit"] != ""){
            $select->where("bidding_amount_unit = ?",$condition["bidding_amount_unit"]);
        }
        if(isset($condition["bidding_status"]) && $condition["bidding_status"] != ""){
            $select->where("bidding_status = ?",$condition["bidding_status"]);
        }
        if(isset($condition["bidding_product_url"]) && $condition["bidding_product_url"] != ""){
            $select->where("bidding_product_url = ?",$condition["bidding_product_url"]);
        }
        if(isset($condition["sample_no"]) && $condition["sample_no"] != ""){
            $select->where("samples.sample_no = ?",$condition["sample_no"]);
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
    public function getByLeftJoin($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "", $join = "")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        if (!empty($join)) {
            foreach ($join as $key => $value) {
                $select->joinLeft($value[0], $value[1], $value[2]);
            }
        }
        /*CONDITION_START*/
        if(isset($condition["bidding_no"]) && $condition["bidding_no"] != ""){
            $select->where("bidding_no = ?",$condition["bidding_no"]);
        }
        if(isset($condition["bidding_status"]) && $condition["bidding_status"] != ""){
            $select->where("bidding_status = ?",$condition["bidding_status"]);
        }
        if(isset($condition["bidding_participant"]) && $condition["bidding_participant"] != ""){
            $select->where("bidding_participant = ?",$condition["bidding_participant"]);
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