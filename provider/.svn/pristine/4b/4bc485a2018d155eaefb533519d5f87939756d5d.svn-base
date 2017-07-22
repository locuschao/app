<?php
class Service_OrderException extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_OrderException|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_OrderException();
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
    public static function update($row, $value, $field = "oe_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "oe_id")
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
    public static function getByField($value, $field = 'oe_id', $colums = "*")
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
        
              'E0'=>'oe_id',
              'E1'=>'order_id',
              'E2'=>'order_no',
              'E3'=>'oi_id',
              'E4'=>'oi_sku',
              'E5'=>'ute_id',
              'E6'=>'oi_name',
              'E7'=>'oi_name_en',
              'E8'=>'ute_erp_name',
              'E9'=>'oeol_id',
              'E10'=>'oe_order_amount',
              'E11'=>'oe_ship_amount',
              'E12'=>'oe_check_amount',
              'E13'=>'oe_exception_amount',
              'E14'=>'oe_supplement_amount',
              'E15'=>'oe_return_amount',
              'E16'=> 'oe_supplement_amount',
              'E17'=>'oe_amunt_unit',
              'E18'=> 'oe_type',
              'E19'=> 'oe_qc_handle_type',
              'E20'=> 'oe_receive_handle_type',
              'E21'=> 'oe_qc_status',
              'E22'=> 'oe_receive_status',
              'E23'=> 'oe_create_time',
              'E24'=> 'oe_update_time',
        );
        return $row;
    }
    
}