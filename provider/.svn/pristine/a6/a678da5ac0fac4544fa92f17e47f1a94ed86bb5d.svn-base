<?php
class Service_ContractLogs extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_ContractLogs|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_ContractLogs();
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
    public static function update($row, $value, $field = "contract_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "contract_id")
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
    public static function getByField($value, $field = 'contract_id', $colums = "*")
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
     * @desc 获取合同列表
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getContractList($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "") {
        $model = self::getModelInstance();
        $join = array(array('orders', 'orders.order_id = contract_logs.order_id', array('order_no as EF1', 'order_price as EF2', 'order_price_unit as EF3', 'order_status as EF4')));
        return $model->getByLeftJoin($condition, $type, $pageSize, $page, $order, $join);
    }

    /**
     * @desc 获取合同列表
     * @param int $orderNo 订单号
     * @param int $uteId 供应商与ERP关系Id
     * @param array $contractInfo 合同信息数组
     * @return mixed
     */
    public static function logContract($orderNo, $uteId, $contractInfo, $contractStatus = 1) {
        // 获取订单id
        $orderId = Service_Orders::getByCondition(array('order_no' => $orderNo, 'ute_id' => $uteId), array('order_id'), 1, 1);
        if (empty($orderId)) {
            return false;
        }
        $orderId = current($orderId);
        // 获取erpName
        $erpName = Service_UserToErp::getByField($uteId, 'ute_id', array('ute_erp_name'));
        if (empty($erpName)) {
            return false;
        }
        $model = self::getModelInstance();
        $date = date('Y-m-d H:i:s');
        $insertArray = array(
            'ute_id' => $uteId,
            'ute_erp_name' => $erpName['ute_erp_name'],
            'order_id' => $orderId['order_id'],
            'contract_purchase_warehouse' => $contractInfo['purchaseWarehouse'],
            'contract_transfer_warehouse' => $contractInfo['transferWarehouse'],
            'contract_download_time' => $date,
            'contract_status' => $contractStatus,
            'contract_create_time' => $date,
            'contract_update_time' => $date
        );
        // 插入记录
        $model->add($insertArray);
        return true;
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
          'E0'=>'contract_id',
          'E1'=>'ute_id',
          'E2'=>'ute_erp_name',
          'E3'=>'order_id',
          'E4'=>'contract_purchase_warehouse',
          'E5'=>'contract_transfer_warehouse',
          'E6'=>'contract_download_time',
          'E7'=>'contract_status',
          'E8'=>'contract_create_time',
          'E9'=>'contract_update_time',
          'EF1'=>'order_no',
          'EF2'=>'order_price',
          'EF3'=>'order_price_unit',
          'EF4'=>'order_status',
        );
        return $row;
    }

}