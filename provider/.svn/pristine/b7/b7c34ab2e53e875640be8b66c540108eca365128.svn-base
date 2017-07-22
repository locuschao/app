<?php
class Service_OrderItem extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_OrderItem|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_OrderItem();
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
    public static function update($row, $value, $field = "oi_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }
    /**
     * @desc 通过order_id 查询oi_sku
     * @date 2017-6-12
     * @author blank
     */
    public static function getSkubyOrderId($value,$field='order_id',$colums = "*"){
        $model = self::getModelInstance();
        return $model->getSkubyOrderId($value,$field,$colums);
    }
    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "oi_id")
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
    public static function getByField($value, $field = 'oi_id', $colums = "*")
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
        
              'E0'=>'oi_id',
              'E1'=>'order_id',
              'E2'=>'oi_sku',
              'E3'=>'oi_name',
              'E4'=>'oi_commit_time',
              'E5'=>'oi_amount',
              'E6'=>'oi_unit',
              'E7'=>'oi_price',
              'E8'=>'oi_total_price',
              'E9'=>'oi_create_time',
              'E10'=>'oi_update_time',
              'E11'=>'oi_price_unit'
        );
        return $row;
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



}