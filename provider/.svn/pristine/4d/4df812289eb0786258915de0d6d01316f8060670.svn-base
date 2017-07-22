<?php
class Table_Message
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_Message();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_Message();
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
    public function update($row, $value, $field = "message_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "message_id")
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
    public function getByField($value, $field = 'message_id', $colums = "*")
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
        if(isset($condition["message_type"]) && $condition["message_type"] != ""){
            $select->where("message_type = ?",$condition["message_type"]);
        }
        if(isset($condition["message_title"]) && $condition["message_title"] != ""){
            $select->where("message_title = ?",$condition["message_title"]);
        }
        if(isset($condition["message_status"]) && $condition["message_status"] != ""){
            $select->where("message_status = ?",$condition["message_status"]);
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
     * @desc 插入多条记录(注意：某条记录待插入字段如果没有值，将默认为String '')
     * @param array $paramsArray 包含多个字段数组的数组，字段数组键名为字段名，值为字段值
     * @return integer number of rows affected by the execution OR false
     * @date 2017-06-19
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