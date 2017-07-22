<?php
class Table_User
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_User();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_User();
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
    public function update($row, $value, $field = "user_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "user_id")
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
    public function getByField($value, $field = 'user_id', $colums = "*")
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

    public function getOne($condition = array(), $type = '*') {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("user_id = ?",$condition["user_id"]);
        }
        if(isset($condition["user_code"]) && $condition["user_code"] != ""){
            $select->where("user_code = ?",$condition["user_code"]);
        }
        if(isset($condition["user_unique_code"]) && $condition["user_unique_code"] != ""){
            $select->where("user_unique_code = ?", $condition["user_unique_code"]);
        }
        $sql = $select->__toString();
        return $this->_table->getAdapter()->fetchOne($sql);
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

        if(isset($condition["user_id_arr"]) && is_array($condition["user_id_arr"]) &&!empty($condition["user_id_arr"])){
            $select->where("user_id in(?)",$condition["user_id_arr"]);
        }
        if(isset($condition["not_user_id"]) && $condition["not_user_id"] != ""){
            $select->where("user_id != ?",$condition["not_user_id"]);
        }
        if(isset($condition["user_code"]) && $condition["user_code"] != ""){
            $select->where("user_code = ?",$condition["user_code"]);
        }
        if(isset($condition["user_password"]) && $condition["user_password"] != ""){
            $select->where("user_password = ?",$condition["user_password"]);
        }
        if(isset($condition["user_name"]) && $condition["user_name"] != ""){
            $select->where("user_name = ?",$condition["user_name"]);
        }
        if(isset($condition["user_name_en"]) && $condition["user_name_en"] != ""){
            $select->where("user_name_en = ?",$condition["user_name_en"]);
        }
        if(isset($condition["user_status"]) && $condition["user_status"] != ""){
            $select->where("user_status = ?",$condition["user_status"]);
        }
        if(isset($condition["user_email"]) && $condition["user_email"] != ""){
            $select->where("user_email = ?",$condition["user_email"]);
        }
        if(isset($condition["ud_id"]) && $condition["ud_id"] != ""){
            $select->where("ud_id = ?",$condition["ud_id"]);
        }
        if(isset($condition["up_id"]) && $condition["up_id"] != ""){
            $select->where("up_id = ?",$condition["up_id"]);
        }
        if(isset($condition["user_password_update_time"]) && $condition["user_password_update_time"] != ""){
            $select->where("user_password_update_time = ?",$condition["user_password_update_time"]);
        }
        if(isset($condition["user_phone"]) && $condition["user_phone"] != ""){
            $select->where("user_phone = ?",$condition["user_phone"]);
        }
        if(isset($condition["user_mobile_phone"]) && $condition["user_mobile_phone"] != ""){
            $select->where("user_mobile_phone = ?",$condition["user_mobile_phone"]);
        }
        if(isset($condition["user_supervisor_id"]) && $condition["user_supervisor_id"] != ""){
            $select->where("user_supervisor_id = ?",$condition["user_supervisor_id"]);
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
    public function getByConditionSelect($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "")
    {
    	$select = $this->_table->getAdapter()->select();
    	$table = $this->_table->info('name');
    	$select->from($table, $type);
    	$select->where("1 =?", 1);
    	/*CONDITION_START*/

    	if(isset($condition["user_id"]) &&!empty($condition["user_id"])){
    		$select->where("user_id = ?",$condition["user_id"]);
    	}
    	if(isset($condition["user_code"]) && $condition["user_code"] != ""){
    		$select->where("user_code = ?",$condition["user_code"]);
    	}
    	if(isset($condition["user_password"]) && $condition["user_password"] != ""){
    		$select->where("user_password = ?",$condition["user_password"]);
    	}
    	if(isset($condition["user_name"]) && $condition["user_name"] != ""){
    		$select->where("user_name like ?","%{$condition["user_name"]}%");
    	}
    	if(isset($condition["user_name_en"]) && $condition["user_name_en"] != ""){
    		$select->where("user_name_en = ?",$condition["user_name_en"]);
    	}
    	if(isset($condition["user_status"]) && $condition["user_status"] != ""){
    		$select->where("user_status = ?",$condition["user_status"]);
    	}
    	if(isset($condition["user_email"]) && $condition["user_email"] != ""){
    		$select->where("user_email = ?",$condition["user_email"]);
    	}
    	if(isset($condition["ud_id"]) && $condition["ud_id"] != ""){
    		$select->where("ud_id = ?",$condition["ud_id"]);
    	}
    	if(isset($condition["up_id"]) && $condition["up_id"] != ""){
    		$select->where("up_id = ?",$condition["up_id"]);
    	}
    	if(isset($condition["user_password_update_time"]) && $condition["user_password_update_time"] != ""){
    		$select->where("user_password_update_time = ?",$condition["user_password_update_time"]);
    	}
    	if(isset($condition["user_phone"]) && $condition["user_phone"] != ""){
    		$select->where("user_phone = ?",$condition["user_phone"]);
    	}
    	if(isset($condition["user_mobile_phone"]) && $condition["user_mobile_phone"] != ""){
    		$select->where("user_mobile_phone = ?",$condition["user_mobile_phone"]);
    	}
    	if(isset($condition["user_supervisor_id"]) && $condition["user_supervisor_id"] != ""){
    		$select->where("user_supervisor_id = ?",$condition["user_supervisor_id"]);
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

    public function getLeftJoinByCondition($condition = array(), $type = '*', $pageSize = 1, $page = 1, $orderBy = "")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        if ('count(*)' == $type) {
            //统计总数
            $select->from($table, 'count(DISTINCT(user.user_id))');
        } else {
            $select->from($table, $type);
        }
        $select->joinLeft('user_warehouse_map', 'user_warehouse_map.user_id=user.user_id',array('warehouse_id'));
        $select->where("1 =?", 1);
        /*CONDITION_START*/
        if(isset($condition["warehouse_id"]) && $condition["warehouse_id"] !== ""){
            $select->where("user_warehouse_map.warehouse_id = ?",$condition["warehouse_id"]);
        }
        if (isset($condition["warehouse_id_in"]) && is_array($condition["warehouse_id_in"])) {
            $select->where("user_warehouse_map.warehouse_id in(?)", $condition["warehouse_id_in"]);
        }
        if(isset($condition["user_code"]) && $condition["user_code"] != ""){
            $select->where("user_code = ?",$condition["user_code"]);
        }
        if(isset($condition["user_name"]) && $condition["user_name"] != ""){
            $select->where("user_name = ?",$condition["user_name"]);
        }
        if(isset($condition["user_name_en"]) && $condition["user_name_en"] != ""){
            $select->where("user_name_en = ?",$condition["user_name_en"]);
        }
        if(isset($condition["user_status"]) && $condition["user_status"] != ""){
            $select->where("user_status = ?",$condition["user_status"]);
        }
        if(isset($condition["user_email"]) && $condition["user_email"] != ""){
            $select->where("user_email = ?",$condition["user_email"]);
        }
        if(isset($condition["ud_id"]) && $condition["ud_id"] != ""){
            $select->where("ud_id = ?",$condition["ud_id"]);
        }
        if(isset($condition["up_id"]) && $condition["up_id"] != ""){
            $select->where("up_id = ?",$condition["up_id"]);
        }
        if(isset($condition["up_id_in"]) && $condition["up_id_in"] != ""){
            $select->where("up_id in (?)",$condition["up_id_in"]);
        }

        if(isset($condition["user_supervisor_id"]) && $condition["user_supervisor_id"] != ""){
            $select->where("user_supervisor_id = ?",$condition["user_supervisor_id"]);
        }
        /*CONDITION_END*/
        if ('count(*)' == $type) {
            return $this->_table->getAdapter()->fetchOne($select);
        } else {
            $select->group($table.'.user_id');
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

    //用于执行in语句
    public function getConditionByIn($value, $field = 'user_id', $colums = "*"){
    	$select = $this->_table->getAdapter()->select();
    	$table = $this->_table->info('name');
    	$select->from($table, $colums);
    	$select->where("{$field} in (?) ", $value);
    	$sql = $select->__toString();
    	return $this->_table->getAdapter()->fetchAll($sql);
    }

    public function getKV($warehouse_id=0, $department_id=0) {
        $KV = array();
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, "*");
        if(!empty($warehouse_id)) {
            $select->where("warehouse_id=?", $warehouse_id);
        }
        if(!empty($department_id)) {
            $select->where("ud_id=?", $department_id);
        }
        $list = $this->_table->getAdapter()->fetchAll($select);
        foreach($list as $row) $KV[$row['user_id']] = $row['user_name'];
        return $KV;
    }

    //去除wechat已授权用户
    public function getByConditionForWechat($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "")
    {
    	$select = $this->_table->getAdapter()->select();
    	$table = $this->_table->info('name');
        //增加新的授权应用
        $system = "";
        if(isset($condition["company_system"]) && $condition["company_system"] != ""){
            $system = " and user_system_authorization.company_system = '".$condition["company_system"]."'";
    	}
    	$select->joinLeft("user_system_authorization", "user.user_id = user_system_authorization.user_id".$system, array(''));
    	$select->from($table, $type);
    	$select->where("1 =?", 1);
    	/*CONDITION_START*/
    	//去掉已授权用户
    	$select->where("user_system_authorization.usa_id is null");
    	if(isset($condition["user_id_arr"]) && is_array($condition["user_id_arr"]) &&!empty($condition["user_id_arr"])){
    		$select->where("user_id in(?)",$condition["user_id_arr"]);
    	}
    	if(isset($condition["not_user_id"]) && $condition["not_user_id"] != ""){
    		$select->where("user_id != ?",$condition["not_user_id"]);
    	}
    	if(isset($condition["user_code"]) && $condition["user_code"] != ""){
    		$select->where("user_code = ?",$condition["user_code"]);
    	}
    	if(isset($condition["user_password"]) && $condition["user_password"] != ""){
    		$select->where("user_password = ?",$condition["user_password"]);
    	}
    	if(isset($condition["user_name"]) && $condition["user_name"] != ""){
    		$select->where("user_name = ?",$condition["user_name"]);
    	}
    	if(isset($condition["user_name_en"]) && $condition["user_name_en"] != ""){
    		$select->where("user_name_en = ?",$condition["user_name_en"]);
    	}
    	if(isset($condition["user_status"]) && $condition["user_status"] != ""){
    		$select->where("user_status = ?",$condition["user_status"]);
    	}
    	if(isset($condition["user_email"]) && $condition["user_email"] != ""){
    		$select->where("user_email = ?",$condition["user_email"]);
    	}
    	if(isset($condition["ud_id"]) && $condition["ud_id"] != ""){
    		$select->where("ud_id = ?",$condition["ud_id"]);
    	}
    	if(isset($condition["up_id"]) && $condition["up_id"] != ""){
    		$select->where("up_id = ?",$condition["up_id"]);
    	}
    	if(isset($condition["user_password_update_time"]) && $condition["user_password_update_time"] != ""){
    		$select->where("user_password_update_time = ?",$condition["user_password_update_time"]);
    	}
    	if(isset($condition["user_phone"]) && $condition["user_phone"] != ""){
    		$select->where("user_phone = ?",$condition["user_phone"]);
    	}
    	if(isset($condition["user_mobile_phone"]) && $condition["user_mobile_phone"] != ""){
    		$select->where("user_mobile_phone = ?",$condition["user_mobile_phone"]);
    	}
    	if(isset($condition["user_supervisor_id"]) && $condition["user_supervisor_id"] != ""){
    		$select->where("user_supervisor_id = ?",$condition["user_supervisor_id"]);
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
    public function getByLeftJoin($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "", $join) {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        if (!empty($join)) {
            foreach ($join as $key => $value) {
                $select->joinLeft($value[0], $value[1], $value[2]);
            }
        }
        //$select->where("1 =?", 1);
        /*CONDITION_START*/
        if(isset($condition["user_id"]) && $condition["user_id"] != ""){
            $select->where("user_id IN (?)",$condition["user_id"]);
        }
        if(isset($condition["user_code"]) && $condition["user_code"] != ""){
            $select->where("user_code = ?",$condition["user_code"]);
        }
        if(isset($condition["user_unique_code"]) && $condition["user_unique_code"] != ""){
            $select->where("user_unique_code = ?", $condition["user_unique_code"]);
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