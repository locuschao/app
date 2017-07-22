<?php
class Service_Orders extends Common_Service
{   // 订单状态定义
    const ORDER_STATUS_WAIT_TO_CONFIRM = 1;     // 待确认
    const ORDER_STATUS_CONFIRM = 2;             // 已确认
    const ORDER_STATUS_CANCEL = 3;              // 已取消

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

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getByGroup($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "", $group = "")
    {
        $model = self::getModelInstance();
        return $model->getByGroup($condition, $type, $pageSize, $page, $order, $group);
    }

    /**
     * @desc 获取订单列表
     * @author Zijie Yuan
     * @date 2017.03.16
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getOrderList($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $result = array();
        $model = self::getModelInstance();
        // 订单列表
        $orders = $model->getByCondition($condition, $type, $pageSize, $page, $order);
        if (empty($orders)) {
            return $result;
        }
        $orderId = implode(',', Common_Common::getArrayColumn($orders, 'E0'));
        // 订单商品
        $items = Service_OrderItem::getByCondition(
            array('order_id' => $orderId), 
            array('order_id as E1', 'oi_sku as EF1', 'oi_amount as EF2', 'oi_unit as EF3'), 0, 0
        );
        $orderArray = Common_Common::arrayWithKey($orders, 'E0');
        // 订单拼接商品
        foreach ($items as $key => $item) {
            if (isset($orderArray[$item['E1']])) {
                $orderArray[$item['E1']]['EF'][] = array(
                    'EF1' => $item['EF1'], 
                    'EF2' => $item['EF2'], 
                    'EF3' => $item['EF3']
                );
            }
        }

        foreach ($orderArray as $key => $order) {
            if (isset($order['EF'])) {
                $result[$order['E17'].'_'.$order['E2']] = $order;
            }else {
                $order['EF'] = array(array(
                    'EF1' => '', 'EF2' => '', 'EF3' => ''
                ));
                $result[$order['E17'].'_'.$order['E2']] = $order;
            }
        }
        return $result;
    }

    /**
     * @desc 获取订单详情
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getOrderDetails($orderId, $columns) {
        $result = array(
            'state' => 0,
            'data' => array('order' => array(), 'items' => array(), 'logs' => array()),
            'message' => 'Fail.'
        );
        $model = self::getModelInstance();
        // 订单信息
        $order = $model->getByField($orderId, 'order_id', $columns);
        if (empty($order)) {
            return $result;
        }
        $orderId = $order['E0'];
        // 商品信息
        $itemColumns = array(
            'oi_id',
            'oi_sku',
            'oi_name',
            'oi_amount',
            'oi_unit',
            'oi_price',
            'oi_price_unit',
            'oi_commit_time',
            'oi_total_price'
        );
        $serviceOrderItem = new Service_OrderItem;
        $itemColumns = $serviceOrderItem->getFieldsAlias($itemColumns);
        $items = Table_OrderItem::getInstance()->getByCondition(
            array('order_id' => $orderId), $itemColumns, 0, 0
        );

        // 订单日志
        $logColumns = array(
            'ol_id',
            'ol_order_status',
            'ol_create_time'
        );
        $logOrderItem = new Service_OrderLog;
        $logColumns = $logOrderItem->getFieldsAlias($logColumns);
        $logs = Table_OrderLog::getInstance()->getByCondition(array('order_id' => $orderId), $logColumns, 0, 0);
        
        $result['state'] = 1;
        $result['data']['order'] = $order;
        $result['data']['items'] = $items;
        $result['data']['logs'] = $logs;
        $result['message'] = 'Success.';
        return $result;
    }

    /**
     * @desc 新建订单
     * @author Zijie Yuan
     * @param array $order
     * @param array $items
     * @return array
     */
    public static function createOrder($order, $items) {
        $result = array(
            'code' => 500,
            'message' => 'Failure!',
            'data' => array()
        );
        try {
            $db = Common_Common::getAdapter();
            $db->beginTransaction();
            // 验证供应商
            $user = Service_User::getByField($order['provider'], 'user_unique_code', 'user_id');
            if (empty($user)) {
                throw new Exception("Invalidated Provider", 500);
            }
            $uteId = Service_UserToErp::getByCondition(
                array('user_id' => $user['user_id'], 'ute_token' => $order['token']), array('ute_id'), 1, 1);
            $uteId = current($uteId);
            unset($order['provider']);
            unset($order['token']);
            $order['user_id'] = $user['user_id'];
            $order['ute_id'] = $uteId['ute_id'];
            $date = date('Y-m-d H:i:s');
            $order['order_create_time'] = $date;
            $order['order_update_time'] = $date;
            // 订单去重
            $orderExist = self::getByCondition(
                array('ute_id' => $uteId['ute_id'], 'order_no' => $order['order_no']),
                'count(*)', 0, 0
            );
            if ($orderExist > 0) {
                throw new Exception("Order is Exist", 6002);
            }
            // 新建订单
            $orderId = self::add($order);
            if (empty($orderId)) {
                throw new Exception("Operation Fail", 6001);
            }
            $itemArray = array();
            foreach ($items as $key => $item) {
                $template = array(
                    'order_id' => $orderId,
                    'oi_sku' => Common_Common::getArrayValue($item, 'ItemSKU', ''),
                    'oi_name' => Common_Common::getArrayValue($item, 'ItemName', ''),
                    'oi_en_name' => Common_Common::getArrayValue($item, 'ItemEnName', ''),
                    'oi_commit_time' => Common_Common::getArrayValue($item, 'ItemCommitTime', '0000-00-00 00:00:00'),
                    'oi_amount' => Common_Common::getArrayValue($item, 'ItemAmount', 0),
                    'oi_unit' => Common_Common::getArrayValue($item, 'ItemUnit', ''),
                    'oi_price' => Common_Common::getArrayValue($item, 'ItemPrice', 0.00),
                    'oi_total_price' => Common_Common::getArrayValue($item, 'ItemTotalPrice', 0.00),
                    'oi_price_unit' => Common_Common::getArrayValue($item, 'ItemPriceUnit', ''),
                    'oi_create_time' => $date,
                    'oi_update_time' => $date
                );
                $itemArray[] = $template;
            }
            // 新建订单商品
            $itemAffectRows = Service_OrderItem::insertMulti($itemArray);
            if (empty($itemArray)) {
                throw new Exception("Operation Fail", 6002);
            }
            // 新建订单日志
            $logArray = array(
                'order_id' => $orderId,
                'ol_order_status' => self::ORDER_STATUS_WAIT_TO_CONFIRM,
                'ol_create_time' => $date,
            );
            $logAffectRows = Service_OrderLog::add($logArray);
            if (empty($logAffectRows)) {
                throw new Exception("Operation Fail", 6002);
            }
            $db->commit();
            $result['code'] = 200;
            $result['message'] = 'Success';
        } catch (Exception $e) {
            $db->rollBack();
            $result['code'] = $e->getCode();
            $result['message'] = $e->getMessage();
        }
        return $result;
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
     * @desc 获取打印合同的数据
     * @param $uteId 供应商与erp关系Id
     * @param $orderNo 订单号
     * @return array
     */
    public static function printContract($uteId, $orderNo) {
        $uteInfo = Service_UserToErp::getUteInfo(array('ute_id' => $uteId), array('ute_token', 'ute_erp_url'));
        if (empty($uteInfo)) {
            return false;
        }
        $paramsJson = json_encode(array('poCode' => $orderNo));
        $params = array(
            'erp_url' => $uteInfo['ute_erp_url'],
            'supplierToken' => $uteInfo['ute_token'],
            'service' => 'getPurchaseContract',
            'paramsJson'=> $paramsJson
        );
        $apiResult = Process_ApiProcess::getContract($params);
        return $apiResult;
    }

    /**
     * @desc 确认/取消订单
     * @param $type 操作类型 0/1
     * @param $order 订单数组
     * @return array
     */
    public static function orderOperate($type, $order) {
        $result = array(
            'code' => 500,
            'message' => '操作失败！',
            'data' => array()
        );
        $uteIds = Common_Common::getArrayColumn($order, 'uteId');
        $status = Common_Common::getArrayColumn($order, 'status');
        // 有不是待确认状态的订单
        if (in_array(self::ORDER_STATUS_CONFIRM, $status) || in_array(self::ORDER_STATUS_CANCEL, haystack)) {
            $result['message'] = '不能操作已确认/已取消的销售单！';
            return $result;
        }
        $model = self::getModelInstance();
        // 查询对应的ERPToken
        $tokenArray = Service_UserToErp::getByCondition(array('ute_id' => $uteIds), array('ute_id', 'ute_token', 'ute_erp_url'), 0, 0);
        if (empty($tokenArray)) {
            return $result;
        }
        $tokenArray = Common_Common::arrayWithKey($tokenArray, 'ute_id', true);
        foreach ($order as $key => $value) {
            if (isset($tokenArray[$value['uteId']])) {
                $tokenArray[$value['uteId']][$value['orderId']] = $value['orderNo'];
            }
        }
        $token = array();
        foreach ($tokenArray as $key => $value) {
            $uteToken = $value['ute_token'];
            unset($value['ute_token']);
            $token[$uteToken] = $value;
        }
        // 请求API
        $apiResult = Process_ApiProcess::orderOperate($type, $token);
        // 订单更新为已确认
        if (!empty($apiResult['confirmSuccess'])) {
            $orderId = array_keys($apiResult['confirmSuccess']);
            self::getModelInstance()->updateIn(array('order_status' => self::ORDER_STATUS_CONFIRM), $orderId);
            $date = date('Y-m-d H:i:s');
            $successLog = array();
            foreach ($apiResult['confirmSuccess'] as $key => $value) {
                $successLog[] = array(
                    'order_id' => $key,
                    'ol_order_status' => self::ORDER_STATUS_CONFIRM,
                    'ol_create_time' => $date
                );
            }
            Service_OrderLog::insertMulti($successLog);
        }
        // 订单更新为已取消
        if (!empty($apiResult['cancelSuccess'])) {
            $orderId = array_keys($apiResult['cancelSuccess']);
            self::getModelInstance()->updateIn(array('order_status' => self::ORDER_STATUS_CANCEL), $orderId);
            $date = date('Y-m-d H:i:s');
            $successLog = array();
            foreach ($apiResult['cancelSuccess'] as $key => $value) {
                $successLog[] = array(
                    'order_id' => $key,
                    'ol_order_status' => self::ORDER_STATUS_CANCEL,
                    'ol_create_time' => $date
                );
            }
            Service_OrderLog::insertMulti($successLog);
        }
        $result['code'] = 200;
        $result['message'] = (empty($apiResult['confirmSuccess']) && empty($apiResult['cancelSuccess']) && empty($apiResult['error']))? $result['message'] : '';
        $result['data'] = $apiResult;
        return $result;
    }

    /**
     * @des获取采购单的目的仓库
     * @param array $condition
     * @return
     */
    public static function getOrderWarehouse($condition = array()){
        $model = self::getModelInstance();
        return $model->byOrderNoWarehouse($condition);
    }
    /**
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(
          'E0'=>'order_id',
          'E1'=>'user_id',
          'E2'=>'order_no',
          'E3'=>'order_pre_commit_time',
          'E4'=>'order_commit_time',
          'E5'=>'order_price',
          'E6'=>'order_from',
          'E7'=>'order_pay_way',
          'E8'=>'order_pay_percent',
          'E9'=>'order_settle_way',
          'E10'=>'order_status',
          'E11'=>'order_create_time',
          'E12'=>'order_update_time',
          'E13'=>'order_price_unit',
          'E14'=>'order_amount',
          'E15'=>'order_amount_unit',
          'E16'=>'order_ship_way',
          'E17'=>'ute_id',
          'EF1'=>'oi_sku'
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