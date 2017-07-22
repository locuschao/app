<?php
class Service_DeliveryOrderItem extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_DeliveryOrderItem|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_DeliveryOrderItem();
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
    public static function update($row, $value, $field = "doi_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "doi_id")
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
    public static function getByField($value, $field = 'doi_id', $colums = "*")
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
        
              'D0'=>'doi_id',
              'D1'=>'do_id',
              'D2'=>'doi_sku',
              'D3'=>'doi_name',
              'D4'=>'doi_amount',
              'D5'=>'doi_unit',
              'D6'=>'doi_size',
              'D7'=>'doi_weight',
              'D8'=>'doi_weight_unit',
              'D9'=>'doi_box_gw',
              'D10'=>'doi_box_gw_unit',
              'D11'=>'doi_box_total_gw',
              'D12'=>'doi_box_total_gw_unit',
              'D13'=>'doi_box_nw',
              'D14'=>'doi_box_nw_unit',
              'D15'=>'doi_box_total_nw',
              'D16'=>'doi_box_total_nw_unit',
              'D17'=>'doi_total_box',
              'D18'=>'doi_total_cube',
              'D19'=>'doi_box_size',
              'D20'=>'doi_box_no',
              'D21'=>'doi_create_time',
              'D22'=>'doi_update_time',

        );
        return $row;
    }

}