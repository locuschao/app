<?php
class Service_ProductFeedbackReport extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_ProductFeedbackReport|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_ProductFeedbackReport();
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
    public static function update($row, $value, $field = "pfr_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "pfr_id")
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
    public static function getByField($value, $field = 'pfr_id', $colums = "*")
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
        
              'D0'=>'pfr_id',
              'D1'=>'user_id',
              'D2'=>'ute_id',
              'D3'=>'pfr_uuid',
              'D4'=>'erp_no',
              'D5'=>'pfr_sku',
              'D6'=>'pfr_from',
              'D7'=>'pfr_country_name',
              'D8'=>'pfr_country_code',
              'D9'=>'pfr_platform',
              'D10'=>'pfr_rma_amount',
              'D11'=>'pfr_rma_percent',
              'D12'=>'pfr_refund_order',
              'D13'=>'pfr_refund_cost',
              'D14'=>'pfr_cost_unit',
              'D15'=>'pfr_reship_order',
              'D16'=>'pfr_reship_sku',
              'D17'=>'pfr_rma_reason',
              'D18'=>'pfr_warehouse_refund_order',
              'D19'=>'pfr_warehouse_refund_sku',
              'D20'=>'pfr_appear_time',
              'D21'=>'pfr_error_type',
              'D22'=>'pfr_quantity',
              'D23'=>'pfr_quantity_unit',
              'D24'=>'pfr_settle_way',
              'D25'=>'pfr_content',
              'D26'=>'pfr_create_time',
              'D27'=>'pfr_update_time',
        );
        return $row;
    }

}