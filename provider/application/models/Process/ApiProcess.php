<?php
/**
 * @desc API处理公共类
 * @author Zijie Yuan
 * @date 2017-03-29
 */
class Process_ApiProcess {

	/**
     * @desc 获取产品反馈报表
     * @author Zijie Yuan
     * @date 2017-03-31
     * @param array $params 请求参数数组
     * @param string $queueArray 任务队列数组
     * @return array
     */
	public static function getFeedbackReport($params, $queueArray) {
		try {
			$result = self::requestUrl($params);

	        if (!$result) {
	        	return false;
	        }
	        // 请求成功，没有所需要的数据
	        if (empty($result['data'])) {
	        	return true;
	        }
	        $responseArray = array(
	        	'frq_id' => $queueArray['frq_id'],
	        	'erp_no' => $queueArray['erp_no'],
	        	'user_id' => $queueArray['user_id'],
	        	'ute_id' => $queueArray['ute_id'],
	        	'frp_content' => json_encode($result['data']),
	        	'frp_create_time' => date('Y-m-d H:i:s')
	        );
	        $frpId = Service_FeedbackReportParse::add($responseArray);
	        if (empty($frpId)) {
	        	return false;
	        }
	        // 处理多页
	        while ($result['nextPage'] === 'true') {
	        	$paramsJson = json_decode($params['paramsJson'], true);
	        	// 页码加1
	        	$paramsJson['pagination']['page'] += 1;
	        	$params['paramsJson'] = json_encode($paramsJson);
	        	$result = self::requestUrl($params);
		        if (!$result) {
		        	return false;
		        }
		        // 请求成功，没有所需要的数据
		        if (empty($result['data'])) {
		        	return true;
		        }
		        $responseArray = array(
		        	'frq_id' => $queueArray['frq_id'],
		        	'erp_no' => $queueArray['erp_no'],
		        	'user_id' => $queueArray['user_id'],
		        	'ute_id' => $queueArray['ute_id'],
		        	'frp_content' => json_encode($result['data']),
		        	'frp_create_time' => date('Y-m-d H:i:s')
		        );
		        // 插入解析表
	        	$frpId = Service_FeedbackReportParse::add($responseArray);
		        if (empty($frpId)) {
		        	return false;
		        }
	        }
	        return true;
		} catch (Exception $e) {
			$error = $e->getMessage();
			self::_log($error, 'get_feedback_report');
			return false;
		}
	}

	/**
     * @desc 获取产品反馈报表的问题类型
     * @author Zijie Yuan
     * @date 2017-03-31
     * @param array $params 请求参数数组
     * @param string $queueArray 任务队列数组
     * @return array
     */
	public static function getProductTroubleType($params) {
		$config = Zend_Registry::get('config');
		$url = $params['erp_url'].$config->api->erpUrl;
		unset($params['erp_url']);

        $soap = new SoapClient($url);
        $response = $soap->callService($params);
        if (empty($response->response)) {
        	return false;
        }
        $responseJson = json_decode($response->response, true);
        // 请求错误
        if ($responseJson['code'] != 200) {
        	return false;
        }
        // json解析出错
        if (json_last_error() !== JSON_ERROR_NONE) {
        	return false;
        }
        return $responseJson['data'];
	}

		/**
     * @desc 获取产品问题处理方式
     * @author Zijie Yuan
     * @date 2017-03-31
     * @param array $params 请求参数数组
     * @return array
     */
	public static function getproductTroubleProcess($params) {
		$config = Zend_Registry::get('config');
		$url = $params['erp_url'].$config->api->erpUrl;
		unset($params['erp_url']);
        $soap = new SoapClient($url);
        $response = $soap->callService($params);
        if (empty($response->response)) {
        	return false;
        }
        $responseJson = json_decode($response->response, true);
        // 请求错误
        if ($responseJson['code'] != 200) {
        	return false;
        }
        // json解析出错
        if (json_last_error() !== JSON_ERROR_NONE) {
        	return false;
        }
        return $responseJson['data'];
	}


    /**
     * @desc 获取产品库存报表
     * @author gan sheng zhi
     * @date 2017-04-10
     * @param array $params 请求参数数组
     * @param string $queueArray 任务队列数组
     * @return array
     */
    public static function getStockReport($params,$queueArray) {

        $result = self::requestUrl($params);
        if (!$result) {
            return false;
        }
        // 请求成功，没有所需要的数据
        if (empty($result['data'])) {
            return true;
        }

        $responseArray = array(
            'srq_id' => $queueArray['srq_id'],
            'erp_no' => $queueArray['erp_no'],
            'ute_id' => $queueArray['ute_id'],
            'user_id' => $queueArray['user_id'],
            'srp_content' => json_encode($result['data']),
            'srp_create_time' => date('Y-m-d H:i:s')
        );

        $frpId = Service_StockReportParse::add($responseArray);

        if (empty($frpId)) {
            return false;
        }

        // 处理多页
        while ($result['nextPage'] === 'true') {

            $paramsJson = json_decode($params['paramsJson'], true);

            // 页码加1
            $paramsJson['pagination']['page'] += 1;
            $params['paramsJson'] = json_encode($paramsJson);
            $result = self::requestUrl($params);
            if (!$result) {
                return false;
            }
            // 请求成功，没有所需要的数据
            if (empty($result['data'])) {
                return true;
            }
            $responseArray = array(
                'srq_id' => $queueArray['srq_id'],
                'erp_no' => $queueArray['erp_no'],
                'ute_id' => $queueArray['ute_id'],
                'user_id' => $queueArray['user_id'],
                'srp_content' => json_encode($result['data']),
                'srp_create_time' => date('Y-m-d H:i:s')
            );
            // 插入解析表
            $srpId = Service_StockReportParse::add($responseArray);
            if (empty($srpId)) {
                return false;
            }
        }
        return true;
    }

	/**
     * @desc 获取销售报表
     * @author Zijie Yuan
     * @date 2017-04-10
     * @param array $params 请求参数数组
     * @param string $queueArray 任务队列数组
     * @return array
     */
	public static function getSaleReport($params, $queueArray) {
		try {
			$result = self::requestUrl($params);
	        if (!$result) {
	        	return false;
	        }
	        // 请求成功，没有所需要的数据
	        if (empty($result['data'])) {
	        	return true;
	        }
	        $responseArray = array(
	        	'srq_id' => $queueArray['srq_id'],
	        	'erp_no' => $queueArray['erp_no'],
	        	'user_id' => $queueArray['user_id'],
	        	'ute_id' => $queueArray['ute_id'],
	        	'srp_content' => json_encode($result['data']),
	        	'srp_create_time' => date('Y-m-d H:i:s')
	        );
	        // 插入解析表
	        $srpId = Service_SaleReportParse::add($responseArray);
	        if (empty($srpId)) {
	        	return false;
	        }
	        // 处理多页
	        while ($result['nextPage'] === 'true') {
	        	$paramsJson = json_decode($params['paramsJson'], true);
	        	// 页码加1
	        	$paramsJson['pagination']['page'] += 1;
	        	$params['paramsJson'] = json_encode($paramsJson);
	        	$result = self::requestUrl($params);
		        if (!$result) {
		        	return false;
		        }
		        // 请求成功，没有所需要的数据
		        if (empty($result['data'])) {
		        	return true;
		        }
		        $responseArray = array(
		        	'srq_id' => $queueArray['srq_id'],
		        	'erp_no' => $queueArray['erp_no'],
		        	'user_id' => $queueArray['user_id'],
		        	'ute_id' => $queueArray['ute_id'],
		        	'srp_content' => json_encode($result['data']),
		        	'srp_create_time' => date('Y-m-d H:i:s')
		        );
		        // 插入解析表
	        	$srpId = Service_SaleReportParse::add($responseArray);
		        if (empty($srpId)) {
		        	return false;
		        }
	        }
	        return true;
		} catch (Exception $e) {
			$error = $e->getMessage();
			self::_log($error, 'get_sale_report');
			return false;
		}
	}

	/**
     * @desc 获取合同数据
     * @author Zijie Yuan
     * @date 2017-04-14
     * @param array $params 参数数组
     * @return mix
     */
	public static function getContract($params) {
		try {
			$result = self::requestUrl($params);
	        if (!$result) {
	        	return false;
	        }
	        // 请求成功，返回错误码
	        if (empty($result['data'])) {
	        	return $result;
	        }
	        return $result['data'];
		} catch (Exception $e) {
			$error = $e->getMessage();
			self::_log($error, 'get_contract');
			return false;
		}
	}

	/**
     * @desc 确认/取消销售单
     * @author Zijie Yuan
     * @date 2017-04-20
     * @param int $type 操作类型
     * @param array $params 参数数组
     * @return mix
     */
	public static function orderOperate($type, $order) {
		$result = array(
			'confirmSuccess' => array(),
			'cancelSuccess' => array(),
			'error' => array()
		);
		try {
			foreach ($order as $key => $value) {
				$params = array(
					'erp_url' => $value['ute_erp_url'],
					'supplierToken' => $key,
	                'service' => 'checkPurchaseOrders',
	                'paramsJson'=> ''
	            );
	            unset($value['ute_erp_url']);
	            $params['paramsJson'] = json_encode(
                	array(
                		'actionType' => $type? 'verify':'cancel',
                		'poCodeArr' => $value
                	)
                );
				$response = self::requestUrl($params);
		        if (!$response) {
		        	$result['error'] = $result['error'] + $value;
		        	continue;
		        }
		        $type? $result['confirmSuccess'] = $result['confirmSuccess'] + $value : $result['cancelSuccess'] = $result['cancelSuccess'] + $value;
			}
	        return $result;
		} catch (Exception $e) {
			$error = $e->getMessage();
			self::_log($error, 'order_operate');
			return $result;
		}
	}

	/**
     * @desc 请求URL
     * @author Zijie Yuan
     * @date 2017-04-10
     * @param array $params 参数数组
     * @return mix
     */

	private static function requestUrl($params) {
		$config = Zend_Registry::get('config');
		$url = $params['erp_url'].$config->api->erpUrl;
        $soap = new SoapClient($url);
        // 记录请求信息
        self::_requestLog($params);
        $result = $soap->callService($params);

        // 记录返回信息
        self::_responseLog($params['service'], $result);

        if (empty($result->response)){
        	return false;
        }
        $response = json_decode($result->response, true);
        // 请求错误
        if ($response['code'] != 200) {
        	return $response["error"];
        }
        // json解析出错
        if (json_last_error() !== JSON_ERROR_NONE) {
        	return false;
        }

        return $response;
	}
    /**
     * 记录请求信息
     * @param $req
     * @return bool
     */
    private static function _requestLog($req)
    {
        try {
            $service = isset($req['service']) ? $req['service'] : 'null';
            $logger = new Zend_Log ();
            $date = date('Y-m-d-H');
            $uploadDir = APPLICATION_PATH . "/../data/log/".$service;
            if (!is_dir($uploadDir)) {
	            mkdir($uploadDir, 0777);
	            chmod($uploadDir, 0777);
	        }
            $writer = new Zend_Log_Writer_Stream($uploadDir.'/' . $date.'_' .'svc_request_' . $service . '_data.log');
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
     * @return bool
     */
    private static function _responseLog($service, $req)
    {
        try {
            $logger = new Zend_Log ();
            $date = date('Y-m-d-H');
            $uploadDir = APPLICATION_PATH . "/../data/log/".$service;
            if (!is_dir($uploadDir)) {
	            mkdir($uploadDir, 0777);
	            chmod($uploadDir, 0777);
	        }
            $writer = new Zend_Log_Writer_Stream ($uploadDir.'/' . $date. '_'.'svc_response_' . $service . '_data.log');
            $logger->addWriter($writer);
            $logger->info("\n" . date('Y-m-d H:i:s') . ":\n" . (print_r($req, true)));
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 错误日志
     * @param $error
     * @return bool
     */
    private static function _log($error, $fileName)
    {
        try {
            $logger = new Zend_Log ();
            $date = date('Y-m-d');
            $uploadDir = APPLICATION_PATH . "/../data/log/";
            $writer = new Zend_Log_Writer_Stream ($uploadDir . $date.'_'.$fileName.'.log');
            $logger->addWriter($writer);
            $logger->info(date('Y-m-d H:i:s') . ': ' . $error . " \n");
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     *功能：通过ute_id获取对应的erp用户$token
     * @param string $ute_id
     * @return array
     * @internal param ute_id $string $token
     * @data 2017-5-6
     * @author blank
     */
    private static function erpToUser($ute_id=''){
        //获取当前登录的用户id
        $userId = Service_User::getUserId();
        $condition['user_id'] = $userId;
        $condition['ute_status']=1;
        // 获取用户与erp的关联的公司名信息
        $userinfo = Service_UserToErp::getUserAndErpRelation($condition);
        if(!$userinfo){
            return false;
        }
        foreach ($userinfo as $key=>$value){
            if(!empty($ute_id) && $value['ute_id']==$ute_id){
                $erpinfo=$value;//对应erp信息
            }
        }
        return $erpinfo;
    }

    /**
     * 功能：获取海外服务商信息
     * @param string $ute_id 选择对应的erp供应商
     * @return array
     * @data 2017-5-6
     * @author blank
     */
    public static  function getTransfer($ute_id='')
    {
        try {
            //调用私有的方法获取对应erp用户信息
            $erpinfo=self::erpToUser($ute_id);
            if(!$erpinfo){
               return false;
            }
            $params = array(
               'erp_url' =>$erpinfo['ute_erp_url'] ,
                'supplierToken' =>$erpinfo['ute_token'],
                'service' => 'getTransferService'
            );
            //获取远程wms接口海外仓数据
            $result = self::requestUrl($params);
            if(!$result){
                return false;
            }
            //调用成功，没有数据
            if(empty($result['data'])){
                return true;
            }
            return $result['data'];

        }catch (Exception $e){
                return false;
        }
    }

    /**
     * 功能：获取服务商仓库
     * @param string $serviceCode 服务商代码
     * @param string ute_id 对应erp
     * @return array
     * @data 2017-5-6
     * @author blank
     */
    public static function  getServiceWarehouse($ute_id='',$serviceCode=''){
        try{
            //调用私有的方法获取对应erp用户信息
            $erpinfo=self::erpToUser($ute_id);
            if(!$erpinfo){
                return false;
            }
                $params = array(
                    'erp_url' => $erpinfo['ute_erp_url'],
                    'supplierToken' => $erpinfo['ute_token'],
                    'service' => "getServiceWarehouse",
                    'paramsJson' => json_encode(array('serviceCode' => $serviceCode))
                );
            $result = self::requestUrl($params);
            return $result['data'];
        }catch (Exception $e){
            return false;
        }
    }

    /**
     * 功能：获取对应系统中转仓
     * @param string $ute_id 对应erp
     * @return array
     * @author blank
     * @date 2017-5-6
     */
    public static function getTransferWarehouehouse($ute_id=''){
        try{
            $erpinfo=self::erpToUser($ute_id);
            if(!$erpinfo){
                return false;
            }
                $params = array(
                    'erp_url' => $erpinfo['ute_erp_url'],
                    'supplierToken' => $erpinfo['ute_token'],
                    'service' => "getTransferWarehoue",
                );
            $result = self::requestUrl($params);
            return $result['data'];
        }catch (Exception $e){
            return false;
        }
    }

    /**
     * 功能：获取中转仓库的运输方式
     */
    public static function getWarehoueShippingMethod($ute_id='',$warehouseId=''){
        try{
            $erpinfo=self::erpToUser($ute_id);
            if(!$erpinfo){
                return false;
            }
            $params = array(
                'erp_url' => $erpinfo['ute_erp_url'],
                'supplierToken' => $erpinfo['ute_token'],
                'service' => "getWarehoueShippingMethod",
                'paramsJson'=>json_encode(array('warehouseId'=>$warehouseId))
            );
            $result = self::requestUrl($params);
            return $result['data'];
        }catch (Exception $e){
            return false;
        }
    }

    /**
     * 功能：获取对应数据
     * @param string $serviceCode 服务商代码
     * @param string $ute_id 对应erp
     * @return array 对应的海外仓入库模板
     * @author blank
     * @date 2017-5-6
     */
    public static function getServiceBaseData($ute_id='',$serviceCode=''){
        try{
            $erpinfo=self::erpToUser($ute_id);
            if(!$erpinfo){
                return false;
            }
            //取出指定的服务商代码
                $params = array(
                    'erp_url' => $erpinfo['ute_erp_url'],
                    'supplierToken' => $erpinfo['ute_token'],
                    'service' => "getServiceBaseData",
                    'paramsJson' => json_encode(array('serviceCode' => $serviceCode))
                );
                $result = self::requestUrl($params);
                return  $result['data'];
        }catch (Exception $e){
            return false;
        }
    }

    /**
     *功能:获取装箱单winit验货仓
     * @param string $ute_id
     * @param string $winitProductCode
     * @return string 入库单号和入库清单pdf文件base64_encode编码
     * @internal param 请求参数 $param
     * @date 2017-5-12
     * @author gan
     */
    public  static function getWinitCheck($ute_id='',$winitProductCode=''){
        try{
            $erpinfo=self::erpToUser($ute_id);
            if(!$erpinfo){
                return false;
            }
            //取出指定的服务商代码
            $params = array(
                'erp_url' => $erpinfo['ute_erp_url'],
                'supplierToken' => $erpinfo['ute_token'],
                'service' => "getWinitInspectionWarehouse",
                'paramsJson' => json_encode(array('winitProductCode' => $winitProductCode))
            );
            $result = self::requestUrl($params);
            return  $result['data'];
        }catch (Exception $e){
            return false;
        }
    }


    /**
     *功能:装箱单数据接口实现入库
     * @param  string  param和ute_id 请求参数
     * @date 2017-5-11
     *
     * @return string 入库单号和入库清单pdf文件base64_encode编码
     */
    public static function packingInterface($ute_id='',$params)
    {
        try {
            $erpinfo = self::erpToUser($ute_id);
            if (!$erpinfo) {
                return false;
            }
            $paramJson=json_encode($params);
            $params = array(
                'erp_url' => $erpinfo['ute_erp_url'],
                'supplierToken' => $erpinfo['ute_token'],
                'service' => 'transferDelivery',
                'paramsJson' => $paramJson
            );
            $result = self::requestUrl($params);
            return $result;
        }catch (Exception $e){
            return $e->getMessage();
        }
  }

    /**
     * 功能：获取winit验货仓
     * @param string $ute_id
     * @param string $param
     * @return bool|string $result
     * @internal param param $string WINIT产品
     * @internal param ute_id $string 获取对应erp的url，调用接口
     * @date 2017-5-12
     */
   public static function getWinitInspectionWarehouse($ute_id='',$param=''){
       try {
           $erpinfo = self::erpToUser($ute_id);
           if (!$erpinfo) {
               return false;
           }
           $paramJson=json_encode(array('winitProductCode'=>$param));
           $params = array(
               'erp_url' => $erpinfo['ute_erp_url'],
               'supplierToken' => $erpinfo['ute_token'],
               'service' => 'getWinitInspectionWarehouse',
               'paramsJson' => $paramJson
           );
           $result = self::requestUrl($params);
           return $result['data'];
       }catch (Exception $e){
           return $e->getMessage();
       }
   }


    /**
     * @deac 产品管理数据的同步
     * @param $params 请求的参数
     * @param string $queueArray 任务队列数组
     * @return array
     * @author gan
     * @date 2017-6-12
     */
   public static  function getProduct($params,$queueArray){
       try {

           $result = self::requestUrl($params);
           if (!$result) {
               return false;
           }
           // 没有所需要的数据
           if (empty($result['data'])) {
               return true;
           }
           $responseArray = array(
               'pq_id' => $queueArray['pq_id'],
               'erp_no' => $queueArray['erp_no'],
               'ute_id' => $queueArray['ute_id'],
               'pp_content' => json_encode($result['data']),
               'pp_create_time' => date('Y-m-d H:i:s')
           );
           // 插入解析表
           $srpId = Service_ProductParse::add($responseArray);
           if (empty($srpId)) {
               return false;
           }
           // 处理多页
           while ($result['nextPage'] === 'true') {
               $paramsJson = json_decode($params['paramsJson'], true);
               // 页码加1
               $paramsJson['pagination']['page'] += 1;
               $params['paramsJson'] = json_encode($paramsJson);
               $result = self::requestUrl($params);
               if (!$result) {
                   return false;
               }
               // 请求成功，没有所需要的数据
               if (empty($result['data'])) {
                   return true;
               }
               $responseArray = array(
                   'pq_id' => $queueArray['pq_id'],
                   'erp_no' => $queueArray['erp_no'],
                   'ute_id' => $queueArray['ute_id'],
                   'pp_content' => json_encode($result['data']),
                   'pp_create_time' => date('Y-m-d H:i:s')
               );
               // 插入解析表
               $srpId = Service_ProductParse::add($responseArray);
               if (empty($srpId)) {
                   return false;
               }
           }
//           return true;
           return $srpId;
       } catch (Exception $e) {
           $error = $e->getMessage();
           self::_log($error, 'get_Product_parse');
           return false;
       }
   }
   /**
    * @desc 获取收货异常信息
    * @date 2017-6-20
    */
    public static  function getReceivingException($params,$queueArray){
        try {
            $result = self::requestUrl($params);
            if (!$result) {
                return false;
            }
            // 请求成功，没有所需要的数据
            if (empty($result['data'])) {
                return true;
            }
            $responseArray = array(
                'oreq_id' => $queueArray['oreq_id'],
                'user_id' => $queueArray['user_id'],
                'ute_id' => $queueArray['ute_id'],
                'erp_no' => $queueArray['erp_no'],
                'orep_content' => json_encode($result['data']),
                'orep_create_time' => date('Y-m-d H:i:s')
            );
            // 插入解析表
            $srpId = Service_OrderReceiveExceptionParse::add($responseArray);
            if (empty($srpId)) {
                return false;
            }
            // 处理多页
            while ($result['nextPage'] === 'true') {
                $paramsJson = json_decode($params['paramsJson'], true);
                // 页码加1
                $paramsJson['pagination']['page'] += 1;
                $params['paramsJson'] = json_encode($paramsJson);
                $result = self::requestUrl($params);
                if (!$result) {
                    return false;
                }
                // 请求成功，没有所需要的数据
                if (empty($result['data'])) {
                    return true;
                }
                $responseArray = array(
                    'oreq_id' => $queueArray['oreq_id'],
                    'user_id' => $queueArray['user_id'],
                    'ute_id' => $queueArray['ute_id'],
                    'erp_no' => $queueArray['erp_no'],
                    'orep_content' => json_encode($result['data']),
                    'orep_create_time' => date('Y-m-d H:i:s')
                );
                // 插入解析表
                $srpId = Service_OrderReceiveExceptionParse::add($responseArray);
                if (empty($srpId)) {
                    return false;
                }
            }
            return true;
        } catch (Exception $e) {
            $error = $e->getMessage();
            self::_log($error, 'getQcException');
            return false;
        }
    }
    /**
     * @desc 获取QC异常信息
     * @date 2017-6-20
     */
    public static  function getQcException($params,$queueArray){
        try {
            $result = self::requestUrl($params);
            if (!$result) {
                return false;
            }
            // 请求成功，没有所需要的数据
            if (empty($result['data'])) {
                return true;
            }
            $responseArray = array(
                'oqeq_id' => $queueArray['oqeq_id'],
                'user_id' => $queueArray['user_id'],
                'ute_id' => $queueArray['ute_id'],
                'erp_no' => $queueArray['erp_no'],
                'oqep_content' => json_encode($result['data']),
                'oqep_create_time' => date('Y-m-d H:i:s')
            );
            // 插入解析表
            $srpId = Service_OrderQcExceptionParse::add($responseArray);
            if (empty($srpId)) {
                return false;
            }
            // 处理多页
            while ($result['nextPage'] === 'true') {
                $paramsJson = json_decode($params['paramsJson'], true);
                // 页码加1
                $paramsJson['pagination']['page'] += 1;
                $params['paramsJson'] = json_encode($paramsJson);
                $result = self::requestUrl($params);
                if (!$result) {
                    return false;
                }
                // 请求成功，没有所需要的数据
                if (empty($result['data'])) {
                    return true;
                }
                $responseArray = array(
                    'oqeq_id' => $queueArray['oqeq_id'],
                    'user_id' => $queueArray['user_id'],
                    'ute_id' => $queueArray['ute_id'],
                    'erp_no' => $queueArray['erp_no'],
                    'oqep_content' => json_encode($result['data']),
                    'oqep_create_time' => date('Y-m-d H:i:s')
                );
                // 插入解析表
                $srpId = Service_OrderQcExceptionParse::add($responseArray);
                if (empty($srpId)) {
                    return false;
                }
            }
            return true;
        } catch (Exception $e) {
            $error = $e->getMessage();
            self::_log($error, 'getQcException');
            return false;
        }
    }



    /**
     * @desc 头程发货给erp提供的数据
     * @params  $params array
     * @author gan
     * @date 2017-06-20
     *
     */

    public  static  function postDeliveryOrder($params = array()){

        try{
          foreach ($params as $key => $value){
              $result = self::requestUrl($value);
              if (!$result) {
                  return false;
              }
              return true;
          }

        }catch (Exception $e){
            $error = $e->getMessage();
            self::_log($error, 'post_delivery_product');
            return false;
        }



    }



}