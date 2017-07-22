<?php

class Common_Svc
{

    protected $_secret = '';
    protected $_expireTime = 900;
    protected $_language = 'zh_CN';
    protected $_active = 1; // 是否开启对接
    protected $_requestLog = 1; // 是否开启记录请求信息
    protected $_responseLog = 1; // 是否开启记录响应信息


    /*
     * @数据初始化验证
     */
    private function authentication($req)
    {   
        $config = Zend_Registry::get('config');
        $this->_secret = $config->api->secret;
        if (empty($req['ErpCode'])) {
            throw new Exception(Ec::Lang('param_can_not_empty', 'ErpCode'), '50002');
        }
        if (empty($req['AppToken'])) {
            throw new Exception(Ec::Lang('param_can_not_empty', 'AppToken'), '50003');
        }
        if (empty($req['Timestamp'])) {
             throw new Exception(Ec::Lang('param_can_not_empty', 'Timestamp'), '50004');
        }
        //var_dump(md5($req['ErpCode'].$this->_secret.$req['Timestamp']));die;
        if (strcmp($req['AppToken'], md5($req['ErpCode'].$this->_secret.$req['Timestamp'])) != 0) {
            throw new Exception(Ec::Lang('AppToken does not match with our computation', 'AppToken'), '50007');
        }

        if ((time() - strtotime($req['Timestamp'])) > $this->_expireTime) {
            throw new Exception(Ec::Lang('Timestamp is expired', 'Timestamp'), '50008');
        }
        /*if (isset($req['language']) && !empty($req['language']) && in_array(strtoupper($req['language']), array('ZH_CN', 'EN_US'))) {
            $this->_language = strtoupper($req['language']) == 'EN_US' ? 'en_US' : 'zh_CN';
        }*/
        if (empty($req['Service'])) {
            throw new Exception(Ec::Lang('param_can_not_empty', 'Service'), '50005');
        }

        //是否记录请求&响应数据
        $logAsk = isset($config->api->log) ? $config->api->log : 0;
        $this->_responseLog = $logAsk;
        $this->_requestLog = $logAsk;
    }

    /*
     * @用户身份验证
     */
    private function authIdentity($req) {
        $condition = array(
            'user_unique_code' => $req['Provider'],
            'ute_erp_no' => $req['ErpCode']
        );
        $serviceUser = new Service_User;
        $type = $serviceUser->getFieldsAlias(array('user_id'));
        $userInfo = $serviceUser->getValidateInfo($condition, $type);
        if (empty($userInfo)) {
            throw new Exception("Invalidated identity", 5009);
        }
        if (empty($userInfo['EF1'])) {
            throw new Exception("Invalidated Token", 5010);
        }
        if (strcmp($req['Token'], $userInfo['EF1']) != 0) {
            throw new Exception("error Token", 5011);
        }
        // token暂不做过期处理
        /*if (strtotime($userInfo['EF2']) - time() < 0) {
            throw new Exception("Token is overdue", 5012);
        }*/
    }

    /**
     * 接口入口
     * @param $req
     * @return array
     */
    public function callService($req)
    {   
        $service = '';
        try {
            // 对象转数组
            $req = Common_Common::objectToArray($req);
            // 数据验证
            $this->authentication($req);
            // 记录请求数据
            $this->_requestLog($req);
            $service = $req['Service'];
            $params = Zend_Json::decode(Common_Common::getArrayValue($req, 'Params', ''));
            //$params['ErpCode'] = Common_Common::getArrayValue($req, 'ErpCode', '');
            //2017-6-14 author blank
           foreach($params as $k=> $v){
               if(!is_array($v)){
                   $params['ErpCode'] = Common_Common::getArrayValue($req, 'ErpCode', '');
               }else{
               $ErpCode= Common_Common::getArrayValue($req, 'ErpCode', '');
               $params[$k]= array_merge($v,array('ErpCode'=>$ErpCode));
               }
           };
            $return = $this->$service($params);
        } catch (Exception $e) {
            $return = array(
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            );
        }
        // 记录响应数据
        $this->_responseLog($service, $return);
        return $return;
    }

    /**
     * @desc 用户注册接口
     * @author Zijie Yuan
     * @date 2017-03-20
     * @return string 
     */
    private function register($params = array()) {
        $result = array(
            'code' => 500,
            'message' => 'Failure!',
            'data' => array()
        );

        try {
            if (empty($params['ErpName'])) {
                throw new Exception(Ec::Lang('ErpName can not be empty'));
            }
            if (strlen($params['ErpName']) == 0 || strlen($params['ErpName']) > 12) {
                throw new Exception(Ec::Lang('ErpName length must be longer than 0 and shorter than 12'));
            }
            if (empty($params['ErpUrl'])) {
                throw new Exception(Ec::Lang('ErpUrl can not be empty'));
            }
            if (!preg_match('/^([a-zA-Z0-9_\-]+)$/', $params['UserCode'])) {
                throw new Exception(Ec::Lang('UserCode can only be composed of letters,numbers,underscores and lines'));
            } 
            if (empty($params['UserPassword']) || strlen($params['UserPassword']) < 6 || strlen($params['UserPassword']) > 16) {
                throw new Exception(Ec::Lang('Password cannot be empty and the length must be longer than 6 and shorter than 16'));
            }

            if (empty($params['UserPasswordConfirm'])) {
                throw new Exception(Ec::Lang('Confirm password can not be empty'));
            }

            if ($params['UserPassword'] != $params['UserPasswordConfirm']) {
                throw new Exception(Ec::Lang('Two passwords are not consistent'));
            }
            if (empty($params['UserName'])) {
                throw new Exception(Ec::Lang('UserName can not be empty'));
            }
            if (!empty($params['UserEmail']) && !eregi("^[a-zA-Z0-9_\.-]+\@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$", $params['UserEmail'])) {
                throw new Exception(Ec::Lang('Invalidate Email'));
            }

            /*if (empty($params['UserMobilePhone'])) {
                throw new Exception(Ec::Lang('Phone number can not be empty'));
            }*/
            if (!empty($params['UserMobilePhone']) && !preg_match('/^[1][34578][0-9]{9}$/',$params['UserMobilePhone'])){
                throw new Exception(Ec::Lang('Wrong format of phone number'));
            }
            if (empty($params['UserCompany'])) {
                throw new Exception(Ec::Lang('UserCompany can not be empty'));
            }
            if (empty($params['UserToken'])) {
                throw new Exception(Ec::Lang('UserToken can not be empty'));
            }

            $userArray = array(
                'user_code' => $params['UserCode'],
                'user_name' => $params['UserName'],
                'user_password' => $params['UserPassword'],
                'user_status' => 1,
                'user_email' => Common_Common::getArrayValue($params, 'UserEmail', ''),
                'user_mobile_phone' => Common_Common::getArrayValue($params, 'UserMobilePhone', ''),
                'user_company' => $params['UserCompany']
            );

            $erpCode = trim($params['ErpCode']);
            $erpName = trim($params['ErpName']);
            $token = trim($params['UserToken']);
            $erpUrl = trim($params['ErpUrl']);

            $member = new Common_Member;
            $result = $member->register($userArray, $erpCode, $erpName, $token, $erpUrl);
            die(Zend_Json::encode($result));
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
            die(Zend_Json::encode($result));
        }
    }

    /**
     * @desc 删除供应商
     * @author Zijie Yuan
     * @date 2017-04-21
     * @return string 
     */
    public function deleteProvider($params = array()) {
        $result = array(
            'code' => 500,
            'message' => 'Failure!',
            'data' => array()
        );

        try {
            if (empty($params['Provider'])) {
                throw new Exception(Ec::lang('Provider can not be null'));
            }
            if (empty($params['Token'])) {
                throw new Exception(Ec::lang('Token can not be null'));
            }
            if (empty($params['ErpCode'])) {
                throw new Exception(Ec::lang('ErpCode can not be null'));
            }

            $provider = trim($params['Provider']);
            $erpCode = trim($params['ErpCode']);
            $token = trim($params['Token']);

            $result = Service_UserToErp::unBindErp($provider, $erpCode, $token);
            die(Zend_Json::encode($result));
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
            die(Zend_Json::encode($result));
        }
    }

    /**
     * @desc 新建订单
     * @author Zijie Yuan
     * @date 2017-03-23
     * @return string 
     */
    private function createOrder($params = array()) {
        $result = array(
            'code' => 500,
            'message' => 'Failure!',
            'data' => array()
        );

        try {
            if (empty($params['Provider'])) {
                throw new Exception(Ec::lang('Provider can not be null'));
            }
            if (empty($params['Token'])) {
                throw new Exception(Ec::lang('Token can not be null'));
            }
            // 验证用户身份
            $this->authIdentity($params);
            if (empty($params['OrderNo'])) {
                throw new Exception(Ec::lang('OrderNo can not be null'));
            }
            if (empty($params['Price'])) {
                throw new Exception(Ec::lang('Price can not be null'));
            }
            if (!preg_match('/^[0-9]+(.[0-9]+)?$/', $params['Price'])) {
                throw new Exception(Ec::lang('Price is invalidated'));
            }
            if (empty($params['PriceUnit'])) {
                throw new Exception(Ec::lang('PriceUnit can not be null'));
            }
            if (empty($params['Amount'])) {
                throw new Exception(Ec::lang('Amount can not be null'));
            }
            $params['Amount'] = (int)$params['Amount'];
            if (empty($params['Amount'])) {
                throw new Exception(Ec::lang('Amount must be integer'));
            }
            /*if (empty($params['AmountUnit'])) {
                throw new Exception(Ec::lang('AmountUnit can not be null'));
            }*/
            if (empty($params['From'])) {
                throw new Exception(Ec::lang('From can not be null'));
            }
            if (empty($params['PayWay'])) {
                throw new Exception(Ec::lang('PayWay can not be null'));
            }
            if (empty($params['ShipWay'])) {
                throw new Exception(Ec::lang('ShipWay can not be null'));
            }
            /*if (empty($params['PayPercent'])) {
                throw new Exception(Ec::lang('PayPercent can not be null'));
            }*/
            if (empty($params['SettleWay'])) {
                throw new Exception(Ec::lang('SettleWay can not be null'));
            }
            if (empty($params['WarehouseId'])) {
                throw new Exception(Ec::lang('Warehouse can not be null'));
            }
            if (empty($params['Items'])) {
                throw new Exception(Ec::lang('Items can not be null'));
            }
            if (!is_array($params['Items'])) {
                throw new Exception(Ec::lang('Items must be a array'));
            }
            // 验证销售单商品
            foreach ($params['Items'] as $key => $value) {
                if (empty($value['ItemSKU'])) {
                    throw new Exception(Ec::lang('SKU can not be null'));
                }
                if (empty($value['ItemName'])) {
                    throw new Exception(Ec::lang('ItemName can not be null'));
                }
                if (empty($value['ItemAmount'])) {
                    throw new Exception(Ec::lang('ItemAmount can not be null'));
                }
                $value['ItemAmount'] = (int)$value['ItemAmount'];
                if (empty($value['ItemAmount'])) {
                    throw new Exception(Ec::lang('ItemAmount must be integer'));
                }
                if (empty($value['ItemPrice'])) {
                    throw new Exception(Ec::lang('ItemPrice can not be null'));
                }
                if (!preg_match('/^[0-9]+(.[0-9]+)?$/', $value['ItemPrice'])) {
                    throw new Exception(Ec::lang('ItemPrice is invalidated'));
                }
                if (empty($value['ItemTotalPrice'])) {
                    throw new Exception(Ec::lang('ItemTotalPrice can not be null'));
                }
                if (!preg_match('/^[0-9]+(.[0-9]+)?$/', $value['ItemTotalPrice'])) {
                    throw new Exception(Ec::lang('ItemTotalPrice is invalidated'));
                }
            }

            $orderArray = array(
                'token' => Common_Common::getArrayValue($params, 'Token', ''),
                'provider' => Common_Common::getArrayValue($params, 'Provider', ''),
                'order_no' => Common_Common::getArrayValue($params, 'OrderNo', ''),
                'order_pre_commit_time' => Common_Common::getArrayValue($params, 'CommitTime', '0000-00-00 00:00:00'),
                'order_commit_time' => Common_Common::getArrayValue($params, 'CommitTime', '0000-00-00 00:00:00'),
                'order_price' => Common_Common::getArrayValue($params, 'Price', 0.00),
                'order_price_unit' => Common_Common::getArrayValue($params, 'PriceUnit', ''),
                'order_amount' => Common_Common::getArrayValue($params, 'Amount', 0),
                'order_amount_unit' => Common_Common::getArrayValue($params, 'AmountUnit', ''),
                'order_from' => Common_Common::getArrayValue($params, 'From', ''),
                'order_ship_way' => Common_Common::getArrayValue($params, 'ShipWay', ''),
                'order_pay_way' => Common_Common::getArrayValue($params, 'PayWay', ''),
                'order_pay_percent' => Common_Common::getArrayValue($params, 'PayPercent', ''),
                'order_settle_way' => Common_Common::getArrayValue($params, 'SettleWay', ''),
                'order_warehouse_id' => Common_Common::getArrayValue($params, 'WarehouseId', 0)
            );

            $itemArray = $params['Items'];
            $orderService = new Service_Orders;
            $result = $orderService->createOrder($orderArray, $itemArray);
            die(Zend_Json::encode($result));
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
            die(Zend_Json::encode($result));
        }
    }

    /**
     * 测试
     *
     * @param $params
     * @return array
     */
    private function demo($params)
    {
        $return = array(
            'ask' => 'Failure',
            'message' => '',
            'data' => ''
        );
        try {
            $return ['ask'] = 'Success';
            $return ['data'] = $params;
        } catch (Exception $e) {
            $return ['message'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 记录请求信息
     * @param $req
     */
    private function _requestLog($req)
    {
        if (!$this->_requestLog) {
            return;
        }
        try {
            $service = isset($req['Service']) ? $req['Service'] : 'null';
            $logger = new Zend_Log ();
            $date = date('Y-m-d-H');
            $uploadDir = APPLICATION_PATH . "/../data/log/".$service;
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777);
                chmod($uploadDir, 0777);
            }
            $writer = new Zend_Log_Writer_Stream($uploadDir . '/' . $date . '_' .'svc_request_' . $service . '_data.log');
            $logger->addWriter($writer);
            $logger->info("\n" . date('Y-m-d H:i:s') . ":\n" . (print_r($req, true)));
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 记录请求信息
     *
     * @param $service
     * @param $req
     */
    private function _responseLog($service, $req)
    {
        if (!$this->_responseLog) {
            return;
        }
        try {
            $logger = new Zend_Log ();
            $date = date('Y-m-d-H');
            $uploadDir = APPLICATION_PATH . "/../data/log/". $service;
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777);
                chmod($uploadDir, 0777);
            }
            $writer = new Zend_Log_Writer_Stream ($uploadDir . '/' . $date . '_' . 'svc_response_' . $service . '_data.log');
            $logger->addWriter($writer);
            $logger->info("\n" . date('Y-m-d H:i:s') . ":\n" . (print_r($req, true)));
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 错误日志
     *
     * @param $error
     */
    private function _log($error)
    {
        try {
            $logger = new Zend_Log ();
            $uploadDir = APPLICATION_PATH . "/../data/log/";
            $writer = new Zend_Log_Writer_Stream ($uploadDir . 'svc.log');
            $logger->addWriter($writer);
            $logger->info(date('Y-m-d H:i:s') . ': ' . $error . " \n");
        } catch (Exception $e) {
            //
        }
    }

    /**
     * @desc  更新用户信息接口
     * @param array
     * @return array
     * @author blank
     * @date 2017-4-24
     */
    public function updateProvider($params=array()){
        $result=array(
            'code' => "500",
            'message' => 'failure',
            'data' => array('无效的请求')
        );
        if(empty($params['ProviderCode'])){
            $result['data'] = array(Ec::Lang('标识不存在'));
            die(Zend_Json::encode($result));
        }

        $user = Service_User::getByField($params['ProviderCode'], 'user_unique_code');
        if(empty($user)){
            $result['data'] = array(Ec::Lang('用户不存在'));
            die(Zend_Json::encode($result));
        }
        $userInfo['user_id']= $user['user_id'];
        if(!empty($params['UserName'])){
            if(strlen($params['UserName'])>36){
                $result['data'] = array(Ec::Lang('供应商名超过字数限制了'));
                die(Zend_Json::encode($result));
            }
            $userInfo['user_name']=$params['UserName'];
        }
        if(!empty( $params['UserCompany'])){
            if(strlen($params['UserCompany'])>50){
                $result['data'] = array(Ec::Lang('公司名称不规范'));
                die(Zend_Json::encode($result));
            }
             $userInfo['user_company']=  $params['UserCompany'];
        }
        if(!empty($params['NewPassword'])) {
            if (strlen($params['NewPassword']) > 16 || strlen($params['NewPassword']) < 6) {
                $result['data'] = array(Ec::Lang('密码不安全'));
                die(Zend_Json::encode($result));
            }
            $userInfo['user_password']=  $params['NewPassword'];
        }
        if(!empty($params['UserEmail'])) {
            if (!eregi("^[a-zA-Z0-9_\.-]+\@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$", $params['UserEmail'])) {
                $result['data'] = array(Ec::Lang('邮箱不正确'));
                die(Zend_Json::encode($result));
            }
            $userInfo['user_email'] = $params['UserEmail'];
        }

        if(!empty($params['UserMobilePhone'])){
            if(!preg_match('/^[1][34578][0-9]{9}$/',$params['UserMobilePhone'])){
                $result['data'] = array(Ec::Lang('电话号码不正确'));
                die(Zend_Json::encode($result));
           }
            $userInfo['user_mobile_phone']=$params['UserMobilePhone'];
        }
        $userInfo['user_update_time']= date('Y-m-d H:i:s',time());
        if(Service_User::update($userInfo, $userInfo['user_id'])){
            $result['code']=200;
            $result['message']='success';
            $result['data']='更新成功';
        }else{
            $result['code']=500;
            $result['data']='更新失败';
        }
        die(Zend_Json::encode($result));
    }

    /**
     * 功能：推送装箱单的数据
     * @param  array $do_id 选取对应的装箱物品
     * @return array
     * @date 2017-5-24
     * @author blank
     */
   public function pushPackData($do_id=array()){
        $condition=array();
        $condition['do_id']=$do_id;
        $condition['do_status']=1;
        if(empty($condition['do_id'])){
            return false;
        }
        $data=Service_DeliveryOrder::getInfoDetail($condition);
        foreach ($data as $key=>$value){
            $arr[$value['do_no']][$key]=$value;
        }
        if(empty($data)){
            return false;
        }
        return $arr;
    }

    /**
     * @desc  推送入库清单
     * @param array
     * @return array
     * @author blank
     * @date 2017-5-24
     */
   public function pushStoreDetail($params=array())
    {
        $return = array(
            'state' => 0,
            'message' => '非法操作',
            'data'=>'miss'
        );
        if(empty($params)){
            die(Zend_Json::encode($return));
        }
        if(self::authIdentity($params)){
            $return['message']='身份不正确';
            die(Zend_Json::encode($return));
        };
        if(empty($params['do_no'])){
            $return['message']='请选择要入库的订单号';
            die(Zend_Json::encode($return));
        }
        $deliveryOrder=Service_DeliveryOrder::getByDoNO($params['do_no']);
        if(empty($deliveryOrder)){
            $return['message']='该订单号还没准备发货';
            die(Zend_Json::encode($return));
        }
        $do_id= $deliveryOrder[0]['do_id'];
        $pushPackData=$this->pushPackData($do_id);
        if(false===$pushPackData){
            $return['message']='请选择待处理的入库的商品';
            die(Zend_Json::encode($return));
        }
        foreach ($pushPackData as $k=>$v) {
            foreach ($v as $kk => $vv) {
                $product[$kk] = array(
                    'productSku' => $vv['doi_sku'],//产品代码
                    'boxNo' => $vv['doi_box_no'],//箱号
                    'quantity' => $vv['doi_amount'],//产品数量
                    'weight' => sprintf("%1\$.2f", $vv['doi_weight'] * $vv['doi_amount'], 2),//总重量
                    'length' => $vv['doi_box_outside_long'],//箱长
                    'width' => $vv['doi_box_outside_width'],//箱宽
                    'height' => $vv['doi_box_outside_heigh'],//箱高
                );
                $condition['do_id'] = $vv['do_id'];
                $deliveryOrder = Service_DeliveryOrder::getErpByDoid($condition);
                if (empty($deliveryOrder)) {
                    $return['message'] = '没有对应供应商信息';
                    die(Zend_Json::encode($return));
                }
                $condition['ute_id'] = $deliveryOrder[0]['ute_id'];
                $uteErp = Service_UserToErp::getUteIdByName($condition);
                if (empty($uteErp)) {
                    $return['message'] = '没有对应供应商信息';
                    die(Zend_Json::encode($return));
                }
                if (empty($product)) {
                    $return['message'] = '发货单下没有对应的商品';
                    die(Zend_Json::encode($return));
                }
                $data = array(
                    'ute_erp_name' => $uteErp[0]['ute_erp_name'],//供应商对应的erp名
                    'ute_erp_no' => $uteErp[0]['ute_erp_no'],//erp用户码
                    'do_no' => $vv['do_no'],//销售单号
                    'product' => $product
                );
            }
            $result[$k]=$data;
        }
          $return['state']=200;
          $return['message']='success';
          $return['data']=$result;
        die(Zend_Json::encode($return));

    }
    
    /**
     * @desc 新建异常订单,多插入
     * @author blank
     * @date 2017-06-12
     * @return string
     */
    public  function createExceptionOrder($params = array())
    {
        $result = array(
            'code' => 500,
            'message' => 'Failure!',
            'data' => array()
        );
        foreach ($params as $k => $v) {
            if(!is_array($v)){
                if (empty($params['Provider'])) {
                    $log["order_id=".$params['order_id']] = array('不存在供应商');
                    $result['data']=$log;
                    continue;
                }
                if (empty($params['Token'])) {
                    $log["order_id=".$params['order_id']] = array('不存在token');
                    $result['data']=$log;
                    continue;
                }
                $user = Service_User::getByField($params['Provider'], 'user_unique_code', 'user_id');
                $condition=array(
                    'user_id'=>$user['user_id'],
                    'ute_erp_no'=>$params['ErpCode'],
                    'ute_token'=>$params['Token'],
                );

                $erpInfo = Service_UserToErp::getUteIdByName($condition);
                if (empty($erpInfo)) {
                    $log["order_id=".$params['order_id']] = array('供应商关系没有对应');
                    $result['data']=$log;
                    continue;
                }
                $exceptions=Service_OrderException::getByField($params['order_id'],$field = 'order_id');
                if(!empty($exceptions)){
                    $log["order_id=".$params['order_id']] = array('该订单号已存在');
                    $result['data']=$log;
                    continue;
                }
                $res = array(
                    'order_id' => $params['order_id'],
                    'order_no' => $params['order_no'],
                    'oi_id' => $params['oi_id'],
                    'oi_sku' => $params['oi_sku'],
                    'oi_name' => $params['oi_name'],//产品名称
                    'oi_name_en' =>isset($params['oi_name_en'])?$params['oi_name_en']:'',//产品英文名称
                    'ute_id' => $erpInfo[0]['ute_id'],
                    'ute_erp_name' =>$erpInfo[0]['ute_erp_name'],//供应商名称
                    'oeol_id' => 0,//异常操作记录id
                    'oe_order_amount' => $params['oe_order_amount'],//订单数
                    'oe_ship_amount' => $params['oe_ship_amount'],//送货数
                    'oe_check_amount' => $params['oe_check_amount'],//检查数量
                    'oe_exception_amount' => $params['oe_exception_amount'],//问题件数量
                    'oe_supplement_amount' =>$params['oe_supplement_amount'],//需要补数量
                    'oe_return_amount' =>$params['oe_return_amount'],//需要退货数量
                    'oe_amunt_unit' => $params['oe_amunt_unit'],//数量单位
                    'oe_status' =>$params['oe_status'],//异常类型
                    'oe_handle_type' => $params['oe_handle_type'],//处理类型
                    'oe_create_time' => date("Y-m-d His",time()),//创建时间
                    'oe_update_time' => date("Y-m-d His",time()),//更新时间
                    'oe_handle_status' => 0//状态
                );
                $orderId = Service_OrderException::add($res);
                $result=array(
                    'code' => 200,
                    'message' => 'success',
                    'data' =>$log
                );
                die(Zend_Json::encode( $result));
            }
            if (empty($v['Provider'])) {
                $log["order_id=".$v['order_id']] = array('不存在供应商');
                $result['data']=$log;
                continue;
            }
            if (empty($v['Token'])) {
                $log["order_id=".$v['order_id']] = array('不存在token');
                $result['data']=$log;
                continue;
            }
            $user = Service_User::getByField($v['Provider'], 'user_unique_code', 'user_id');
            $condition[] = array();
            $condition['user_id'] = $user['user_id'];
            $condition['ute_erp_no'] = $v['ErpCode'];
            $condition['ute_token'] = $v['Token'];
            $erpInfo = Service_UserToErp::getUteIdByName($condition);
            if (empty($erpInfo)) {
                $log["order_id=".$v['order_id']] = array('供应商关系没有对应');
                $result['data']=$log;
                continue;
            }
            $exceptions=Service_OrderException::getByField($v['order_id'],$field = 'order_id');
            if(!empty($exceptions)){
                $log["order_id=".$v['order_id']] = array('该订单号已存在');
                $result['data']=$log;
                continue;
            }
                $res = array(
                    'order_id' => $v['order_id'],
                    'order_no' => $v['order_no'],
                    'oi_id' => $v['oi_id'],
                    'oi_sku' => $v['oi_sku'],
                    'oi_name' => $v['oi_name'],//产品名称
                    'oi_name_en' =>isset($v['oi_name_en'])?$v['oi_name_en']:'',//产品英文名称
                    'ute_id' => $erpInfo[0]['ute_id'],
                    'ute_erp_name' =>$erpInfo[0]['ute_erp_name'],//供应商名称
                    'oeol_id' => 0,//异常操作记录id
                    'oe_order_amount' => $v['oe_order_amount'],//订单数
                    'oe_ship_amount' => $v['oe_ship_amount'],//送货数
                    'oe_check_amount' => $v['oe_check_amount'],//检查数量
                    'oe_exception_amount' => $v['oe_exception_amount'],//问题件数量
                    'oe_supplement_amount' =>$v['oe_supplement_amount'],//需要补数量
                    'oe_return_amount' => $v['oe_return_amount'],//需要退货数量
                    'oe_amunt_unit' => $v['oe_amunt_unit'],//数量单位
                    'oe_status' =>$v['oe_status'],//异常类型
                    'oe_handle_type' => $v['oe_handle_type'],//处理类型
                    'oe_create_time' => date("Y-m-d His",time()),//创建时间
                    'oe_update_time' => date("Y-m-d His",time()),//更新时间
                    'oe_handle_status' => 0//状态
                );
                $orderId = Service_OrderException::add($res);
        }
        if($orderId){
            $result=array(
                'code' => 200,
                'message' => 'success',
                'data' =>$log
            );
            die(Zend_Json::encode( $result));
        }
        die(Zend_Json::encode( $result));
    }

    /**
     * @desc 发起竞标
     * @author Zijie Yuan
     * @date 2017-06-15
     * @return string 
     */
    private function createBidding($params) {
        $result = array(
            'code' => 500,
            'message' => 'Failure!',
            'data' => array()
        );

        try {
            if (empty($params['BiddingNo'])) {
                throw new Exception(Ec::lang('BiddingNo can not be null'));
            }
            if (empty($params['BiddingName'])) {
                throw new Exception(Ec::lang('BiddingName can not be null'));
            }
            if (empty($params['BiddingLong'])) {
                throw new Exception(Ec::lang('BiddingLong can not be null'));
            }
            if (empty($params['BiddingWidth'])) {
                throw new Exception(Ec::lang('BiddingWidth can not be null'));
            }
            if (empty($params['BiddingHeigh'])) {
                throw new Exception(Ec::lang('BiddingHeigh can not be null'));
            }
            if (empty($params['BiddingColor'])) {
                throw new Exception(Ec::lang('BiddingColor can not be null'));
            }
            if (empty($params['BiddingAmount'])) {
                throw new Exception(Ec::lang('BiddingAmount must be integer'));
            }
            if (empty($params['BiddingTimeStart'])) {
                throw new Exception(Ec::lang('BiddingTimeStart can not be null'));
            }
            if (empty($params['BiddingTimeEnd'])) {
                throw new Exception(Ec::lang('BiddingTimeEnd can not be null'));
            }
        }
    }

    /**
     * 消息中心-接收erp推送过来的消息
     * @param $datas array
     * @author gan
     * @date 2017/06/19
     */

    public function postMessages($params = array()){
        $return = array(
            'state' => '500',
            'message' => 'Fail',
            'data' => array()
        );
        if(empty($params)){
            die(Zend_Json::encode($return));
        }

        try{
            if(!empty($params)){
                //验证字段是可为空
               if(empty($params['Provider'])){
                   throw new Exception(Ec::lang('Provider can not be null'));
               }
                if (empty($params['Token'])) {
                    throw new Exception(Ec::lang('Token can not be null'));
                }
                //验证用户身份
                $this ->authIdentity($params);

               //判断消息内容是否空
               foreach ($params['Message'] as $key =>$value){

                   if(empty($value['MessageType'])){
                       throw  new Exception(Ec::lang('MessageType can not null'));
                   }
                   if(empty($value['MessageTitle'])){
                       throw  new Exception(Ec::lang('MessageTitle can not null'));
                   }
                   if(empty($value['MessageContent'])){
                       throw  new Exception(Ec::lang('MessageContent can not null'));
                   }
                   if(empty($value['MessageCreateTime'])){
                       throw  new Exception(Ec::lang('MessageCreateTime can not null'));
                   }

               }
                $paramsArray = array(
                    'token' => Common_Common::getArrayValue($params, 'Token', ''),
                    'provider' => Common_Common::getArrayValue($params, 'Provider', ''),
                );

                //判断供应商是否存在
                $user = Service_User::getByField($paramsArray['provider'], 'user_unique_code', 'user_id');
                if (empty($user)) {
                    throw new Exception("Invalidated Provider", 500);
                }
                $uteId = Service_UserToErp::getByCondition(
                    array('user_id' => $user['user_id'], 'ute_token' => $paramsArray['token']), array('ute_id'), 1, 1);
                $uteId = current($uteId);
                $datetime = date("Y-m-d H:i:s",time());
                foreach($params['Message'] as  $K =>$v){
                    $messageArray = array(
                        'message_type' => Common_Common::getArrayValue($v, 'MessageType', ''),
                        'message_title' => Common_Common::getArrayValue($v, 'MessageTitle', ''),
                        'message_status' =>0,
                        'message_create_time' => Common_Common::getArrayValue($v, 'MessageCreateTime', '0000-00-00 00:00:00'),
                        'message_update_time' => $datetime,
                    );
                    $contentArray = array(
                        'mc_Content' => Common_Common::getArrayValue($v, 'MessageContent', '')
                    );
                    $messageArray['ute_id'] =  $uteId['ute_id'];
                    $db = Common_Common::getAdapter();
                    //开启事务
                    $db->beginTransaction();
                    //写入消息表
                      $message = Service_Message::add($messageArray);
                    if(empty($message)){
                         throw new Exception("Operation Fail", 6002);
                    }

                    $contentArray['message_id'] = $message;
                    //写入消息内容表
                    $msgContent = Service_MessageContent::add($contentArray);
                    if(empty($msgContent)){
                        $db->rollBack();
                        continue;
                    }
                    $db->commit();

                }
                $return['state'] ='200';
                $return['message'] = 'success';

            }

        }catch (Exception $e){
            $return['code'] = $e->getCode();

            $return['message'] = $e->getMessage();
        }

        return $return;

    }

}