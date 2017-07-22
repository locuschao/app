<?php
class Table_DeliverySampleOrders
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_DeliverySampleOrders();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_DeliverySampleOrders();
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
    public function update($row, $value, $field = "dso_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "dso_id")
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
    public function getByField($value, $field = 'dso_id', $colums = "*")
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
        
        if(isset($condition["dso_no"]) && $condition["dso_no"] != ""){
            $select->where("dso_no = ?",$condition["dso_no"]);
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

    public function getByConditionJoinSamples($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "",$groupBy = "")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        $select->joinLeft('samples', 'samples.dso_id='.$table.'.dso_id',null);
        $select->where("1 =?", 1);
        /*CONDITION_START*/

        if(isset($condition["dso_no"]) && $condition["dso_no"] != ""){
            $select->where("dso_no like ?",'%'.$condition["dso_no"].'%');
        }
        if(isset($condition["dso_create_time_start"]) && $condition["dso_create_time_start"] != ""){
            $select->where("dso_create_time >= ?",$condition["dso_create_time_start"]);
        }
        if(isset($condition["dso_create_time_end"]) && $condition["dso_create_time_end"] != ""){
            $select->where("dso_create_time <= ?",$condition["dso_create_time_end"]);
        }
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("samples.user_id = ?",$condition["user_id"]);
        }
        /*CONDITION_END*/
        if ('count(*)' == $type) {
            if(!empty($groupBy)){
                $select->group($groupBy);
            }
            return $this->_table->getAdapter()->fetchOne($select);
        } else {
            if (!empty($orderBy)) {
                $select->order($orderBy);
            }
            if(!empty($groupBy)){
                $select->group($groupBy);
            }
            if ($pageSize > 0 and $page > 0) {
                $start = ($page - 1) * $pageSize;
                $select->limit($pageSize, $start);
            }
            $sql = $select->__toString();
            return $this->_table->getAdapter()->fetchAll($sql);
        }
    }
    public function getByConditionJoinSB($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        $select->joinLeft('samples', 'samples.dso_id='.$table.'.dso_id',array('sample_price','sample_price_unit','sample_no'));
        $select->joinLeft('bidding', 'bidding.bidding_id=samples.bidding_id',array(
            'bidding_amount',
            'bidding_amount_unit',
            'bidding_name',
            'bidding_name_en',
            'bidding_long',
            'bidding_width',
            'bidding_heigh',
            'bidding_size_unit',
            'bidding_color',
            ));
        $select->where("1 =?", 1);
        /*CONDITION_START*/
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("samples.user_id = ?",$condition["user_id"]);
        }
        if(isset($condition["dso_no"]) && $condition["dso_no"] != ""){
            $select->where("dso_no = ?",$condition["dso_no"]);
        }
        /*CONDITION_END*/
        if ('count(*)' == $type) {
            if(!empty($groupBy)){
                $select->group($groupBy);
            }
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
    public function getByConditionJoinSU($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "",$groupBy = "")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        $select->joinLeft('samples', 'samples.dso_id='.$table.'.dso_id',null);
        $select->joinLeft('bidding', 'bidding.bidding_id=samples.bidding_id',array('bidding_address','bidding_phone'));
        $select->joinLeft('user_to_erp', 'user_to_erp.ute_erp_no=bidding.ute_erp_no',null);
        $select->joinLeft('user', 'user.user_id=user_to_erp.user_id',array('user_name','user_name_en'));
        $select->where("1 =?", 1);
        /*CONDITION_START*/

        if(isset($condition["dso_no"]) && $condition["dso_no"] != ""){
            $select->where("dso_no like ?",'%'.$condition["dso_no"].'%');
        }
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("samples.user_id = ?",$condition["user_id"]);
        }
        if(isset($condition["dso_create_time_start"]) && $condition["dso_create_time_start"] != ""){
            $select->where("dso_create_time >= ?",$condition["dso_create_time_start"]);
        }
        if(isset($condition["dso_create_time_end"]) && $condition["dso_create_time_end"] != ""){
            $select->where("dso_create_time <= ?",$condition["dso_create_time_end"]);
        }
        /*CONDITION_END*/
        if ('count(*)' == $type) {
            if(!empty($groupBy)){
                $select->group($groupBy);
            }
            return $this->_table->getAdapter()->fetchOne($select);
        } else {
            if (!empty($orderBy)) {
                $select->order($orderBy);
            }
            if(!empty($groupBy)){
                $select->group($groupBy);
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