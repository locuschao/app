<?php
class Service_DeliverySampleOrders extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_DeliverySampleOrders|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_DeliverySampleOrders();
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
    public static function update($row, $value, $field = "dso_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "dso_id")
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
    public static function getByField($value, $field = 'dso_id', $colums = "*")
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
    public static function getByConditionJoinSamples($condition, $type, $pageSize, $page, $order,$groupBy)
    {
        $model = self::getModelInstance();
        return $model->getByConditionJoinSamples($condition, $type, $pageSize, $page, $order,$groupBy);
    }
    public static function getByConditionJoinSB($condition, $type, $pageSize, $page, $order)
    {
        $model = self::getModelInstance();
        return $model->getByConditionJoinSB($condition, $type, $pageSize, $page, $order);
    }
    public static function getByConditionJoinSU($condition, $type, $pageSize, $page, $order,$groupBy)
    {
        $model = self::getModelInstance();
        return $model->getByConditionJoinSU($condition, $type, $pageSize, $page, $order,$groupBy);
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
        
              'E0'=>'dso_id',
              'E1'=>'dso_no',
              'E2'=>'dso_create_time',
              'E3'=>'dso_update_time',
        );
        return $row;
    }

}