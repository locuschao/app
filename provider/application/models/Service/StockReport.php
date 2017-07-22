<?php
class Service_StockReport extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_StockReport|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_StockReport();
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
    public static function update($row, $value, $field = "sr_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "sr_id")
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
    public static function getByField($value, $field = 'sr_id', $colums = "*")
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
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getByConditions($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {

        $model = self::getModelInstance();
        return $model->getByConditions($condition, $type, $pageSize, $page, $order);
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
        
              'E0'=>'sr_id',
              'E1'=>'user_id',
              'E2'=>'ute_id',
              'E3'=>'erp_no',
              'E4'=>'sr_sku',
              'E5'=>'sr_spu',
              'E6'=>'sr_category',
              'E7'=>'sr_warehouse',
              'E8'=>'sr_purchasing_amount',
              'E9'=>'sr_shipping_amount',
              'E10'=>'sr_available_amount',
              'E11'=>'sr_stock_amount',
              'E12'=>'sr_turnove_rates',
              'E13'=>'sr_stock_cost',
              'E14'=>'sr_save_day',
              'E15'=>'sr_create_time',
              'E16'=>'sr_update_time',
              'E17'=>'sr_produce_amount',
              'E18'=>'sr_rejects_amount',
              'E19'=>'sr_input_amunt',
              'E20'=>'sr_output_amount',
              'E21'=>'sr_amount_unit',
              'E22'=>'sr_cost_unit',
        );
        return $row;
    }





}