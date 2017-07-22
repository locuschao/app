<?php
class Service_Application extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_Application|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_Application();
        }
        return self::$_modelClass;
    }

    /**
     * @param $row
     * @return mixed
     */
    public static function add($row)
    {
        $model = self::getModelInstance();
        return $model->add($row);
    }


    /**
     * @param $row
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function update($row, $value, $field = "application_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "application_id")
    {
        $model = self::getModelInstance();
        return $model->delete($value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @param string $colums
     * @return mixed
     */
    public static function getByField($value, $field = 'application_id', $colums = "*")
    {
        $model = self::getModelInstance();
        return $model->getByField($value, $field, $colums);
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        $model = self::getModelInstance();
        return $model->getAll();
    }

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getByCondition($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $model = self::getModelInstance();
        return $model->getByCondition($condition, $type, $pageSize, $page, $order);
    }

    /**
     * @param $val
     * @return array
     */
    public static function validator($val)
    {
        $validateArr = $error = array();
        
        return  Common_Validator::formValidator($validateArr);
    }


    /**
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(
        
              'E0'=>'application_id',
              'E1'=>'application_code',
              'E2'=>'application_name',
              'E3'=>'application_note',
              'E4'=>'warehouse_id',
              'E5'=>'customer_id',
              'E6'=>'customer_code',
              'E7'=>'current_number',
              'E8'=>'rule',
              'E9'=>'app_add_time',
              'E10'=>'app_update_time',
        		//后加入
        	  'E11'=>'system_code',
        	  'E12'=>'prefix',
        	  'E13'=>'app_add_time_start',
        	  'E14'=>'app_add_time_end',
        	  /*新增*/
        	  'E15'=>'oqm_status',
              'E16'=>'order_count',
        	  'E17'=>'oqm_note',
        	  'E18'=>'oqm_add_time',
        	  'E19'=>'oqm_process_time',
        	  'E20'=>'oqm_end_time', 
        	  'E21'=>'oqm_id',
        );
        return $row;
    }

}