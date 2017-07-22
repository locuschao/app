<?php
class Service_Deliverys extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_Orders|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_Orders();
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
    public static function update($row, $value, $field = "order_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "order_id")
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
    public static function getByField($value, $field = 'order_id', $colums = "*")
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
    //getByConditionJoinPro
    public static function getByConditionJoinPro($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $model = self::getModelInstance();
        return $model->getByConditionJoinPro($condition, $type, $pageSize, $page, $order);
    }
    /**
     * 连接订单产品表
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getByConditionJoinOP($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "",$group='')
    {
        $model = self::getModelInstance();
        return $model->getByConditionJoinOP($condition, $type, $pageSize, $page, $order,$group);
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
     * 退件审核，同步到订单
     * @param unknown_type $productId
     */
    public static function ordersUpdateByTransaction($orderRow, $order_no,$order_type){

        $re=Service_Orders::update($orderRow, $order_no,"refrence_no_platform");
        if(!$re){
            throw new Exception("同步订单失败");
        }
        // 写入日志

        $rowLog=array(
            'ref_id'=>$order_no,
            'create_time'=>date("Y-m-d H:i:s",time()),
            'system'=>'master',
            'op_user_id'=>Service_User::getUserId(),
            'op_id'=>Common_Common::getIP(),
        );
        switch ($order_type) {
            case 1: //通过退货申请
                $rowLog['log_content']='退件审核成功,备注:'.$orderRow['operator_note'];
                break;
            case 2: //订单转重发
                $rowLog['log_content']='订单转为重发';
                break;
        }
        $logRre=Service_OrderLog::add($rowLog);
        if(!$logRre){
            throw new Exception("添加日志失败");
        }
    }




    /**
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(

            'E0'=>'order_id',
            'E1'=>'platform',
            'E2'=>'customer_id',
            'E3'=>'company_code',
            'E4'=>'order_type',
            'E5'=>'create_type',
            'E6'=>'order_status',
            'E7'=>'sub_status',
            'E8'=>'cancel_status',
            'E9'=>'create_method',
            'E10'=>'shipping_method',
            'E11'=>'shipping_method_platform',
            'E12'=>'warehouse_id',
            'E13'=>'warehouse_code',
            'E14'=>'shipping_method_no',
            'E15'=>'is_oda',
            'E16'=>'is_signature',
            'E17'=>'is_insurance',
            'E18'=>'insurance_value',
            'E19'=>'order_weight',
            'E20'=>'order_desc',
            'E21'=>'date_create',
            'E22'=>'date_release',
            'E23'=>'date_pickup',
            'E24'=>'date_warehouse_shipping',
            'E25'=>'date_last_modify',
            'E26'=>'refrence_no',
            'E27'=>'refrence_no_platform',
            'E28'=>'refrence_no_sys',
            'E29'=>'refrence_no_warehouse',
            'E30'=>'shipping_address_id',
            'E31'=>'operator_id',
            'E32'=>'operator_note',
            'E33'=>'sync_status',
            'E34'=>'sync_time',
            'E35'=>'date_create_platform',
            'E36'=>'date_paid_platform',
            'E37'=>'date_paid_int',
            'E38'=>'amountpaid',
            'E39'=>'subtotal',
            'E40'=>'ship_fee',
            'E41'=>'platform_fee',
            'E42'=>'finalvaluefee',
            'E43'=>'currency',
            'E44'=>'user_account',
            'E45'=>'buyer_id',
            'E46'=>'third_part_ship',
            'E47'=>'is_merge',
            'E48'=>'site',
            'E49'=>'abnormal_type',
            'E50'=>'abnormal_reason',
            'E51'=>'is_one_piece',
            'E52'=>'product_count',
            'E53'=>'consignee_country',
            'E54'=>'buyer_name',
            'E55'=>'buyer_mail',
            'E56'=>'has_buyer_note',
            'E57'=>'fulfillment_channel',
            'E58'=>'ship_service_level',
            'E59'=>'shipment_service_level_category',
            'E60'=>'leave_comment',
            'E61'=>'ebay_case_type',
            'E62'=>'order_refund',
            'E63'=>'process_again',
            'E64'=>'has_export',
            'E65'=>'has_pickup',
            'E66'=>'has_print_pickup_label',
            'E67'=>'service_status',
            'E68'=>'service_provider',
            'E69'=>'ot_id',
            'E70'=>'sys_tips',
            'E71'=>'consignee_name',
            'E72'=>'consignee_company',
            'E73'=>'consignee_street1',
            'E74'=>'consignee_street2',
            'E75'=>'consignee_street3',
            'E76'=>'consignee_district',
            'E77'=>'consignee_county',
            'E78'=>'consignee_city',
            'E79'=>'consignee_state',
            'E80'=>'consignee_country_code',
            'E81'=>'consignee_country_name',
            'E82'=>'consignee_phone',
            'E83'=>'consignee_email',
            'E84'=>'consignee_postal_code',
            'E85'=>'consignee_doorplate',
            'E86'=>'shared_sign',
            'E87'=>'is_returns',
            'E88'=>'lm_code',
            'E91'=>'other_fee',
            'E92'=>'shipping_shipping_method',
            'E93'=>'shipping_warehouse_id',
        );
        return $row;
    }

}