<?php
class Service_SaleReport extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_SaleReport|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_SaleReport();
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
     * @param $val
     * @return array
     */
    public static function validator($val)
    {
        $validateArr = $error = array();
        
        return  Common_Validator::formValidator($validateArr);
    }

    public static function insertMulti($params) {
        $model = self::getModelInstance();
        return $model->insertMulti($params);
    }

    /**
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(

            /*'E0'=>'sr_id',
            'E1'=>'erp_no',
            'E2'=>'sr_sku',
            'E3'=>'sr_platform',
            'E4'=>'sr_from',
            'E5'=>'sr_sale_gross',
            'E6'=>'sr_ship_fee',
            'E7'=>'sr_cost',
            'E8'=>'sr_price',
            'E9'=>'sr_poundage',
            'E10'=>'sr_service_ship_fee',
            'E11'=>'sr_refund_fee',
            'E12'=>'sr_amount',
            'E13'=>'sr_amount_unit',
            'E14'=>'sr_increase_rate',
            'E15'=>'sr_create_time',
            'E16'=>'sr_update_time',*/
            'E0'=>'sr_id',
            'E1'=>'sr_sku',
            'E2'=>'sr_from',
            'E3'=>'sr_platform',
            'E4'=>'sr_country_name',
            'E6'=>'sr_category',
            'E7'=>'sr_amount',
            'E8'=>'sr_amount_unit',
            'E9'=>'sr_sale_gross',
            'E10'=>'sr_cost',
            'E11'=>'sr_price',
            'E12'=>'sr_update_time',
            'E13'=>'sr_trend',
            'E14'=>'sr_increase_rate',
            'E15'=>'sr_ship_fee',
            'E16'=>'sr_poundage',
            'E17'=>'sr_service_ship_fee',
            'E18'=>'sr_3d_amount',
            'E19'=>'sr_7d_amount',
            'E20'=>'sr_14d_amount',
            'E21'=>'sr_30d_amount',
            'E22'=>'sr_perior_amount',
            'E23'=>'sr_prior_perior_amount',
            'E24'=>'sr_prior_two_perior_amount',
            'E25'=>'sr_prior_three_perior_amount',
            'E26'=>'sr_perior_price',
            'E27'=>'sr_prior_perior_price',
            'E28'=>'sr_prior_two_perior_price',
            'E29'=>'sr_prior_three_perior_price',
            'E30'=>'user_id',
            'E31'=>'ute_id'
        );
        return $row;
    }

}