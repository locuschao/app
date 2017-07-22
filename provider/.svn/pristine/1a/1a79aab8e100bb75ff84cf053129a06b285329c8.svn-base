<?php
class Delivery_IndexController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "delivery/views/index/";
        $this->serviceClass = new Service_DeliveryOrder();
    }

    public function listAction()
    {
        $condition = array();
        $uteErpName = array();
        $uteId = array();
        //获取当前登录的用户id
        $userId = Service_User::getUserId();
        $condition['user_id'] = $userId;

        // 获取用户与erp的关联的公司名信息
        $userinfo = Service_UserToErp::getUserAndErpRelation($condition);
        $condition['ute_id'] = array();
        foreach ($userinfo as $k => $v) {
            if ($v['ute_status'] == 0) {
                continue;
            }
            $condition['ute_id'][] = $v['ute_id'];
        }
        //获取一个用户对应的多个erp名称
        $filed = array(
            'ute_id',
            'ute_erp_name',
        );

        foreach ($condition['ute_id'] as $key => $value) {
            $uteId['ute_id'] = $value;
            $uteErpName[] = Service_UserToErp::getByCondition($uteId, $filed, $pageSize = 0, $page = 1);

        }

        $uteErpNameData = array();
        $uteErpNameUteId = array();
        //提取数据
        foreach ($uteErpName as $key => $value) {
            $uteErpNameData[$value[0]['ute_id']] = $value[0]['ute_erp_name'];
        }

        $uteErpNameDatas = $uteErpNameData;
        $this->view->uteErpNameDatas = $uteErpNameDatas;


        if ($this->_request->isPost()) {
            $page = $this->_request->getParam('page', 1);
            $pageSize = $this->_request->getParam('pageSize', 20);
            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 20;
            $return = array(
                "state" => 0,
                "message" => "No Data"
            );

            // 获取用户与erp的关联的公司名信息
            $userinfo = Service_UserToErp::getUserAndErpRelation(array('user_id' => $userId, 'ute_status' => 1), array('ute_id'));
            $uteId = Common_Common::getArrayColumn($userinfo, 'ute_id');
            $condition['ute_id'] = implode(',', $uteId);
            $param = $this->_request->getParams();
            $condition['do_status'] = isset($param['do_status']) ? $param['do_status'] : '';
            $condition['do_no'] = trim(isset($param['do_no']) ? $param['do_no'] : '');
            $condition['do_ship_no'] = trim(isset($param['do_ship_no']) ? $param['do_ship_no'] : '');
            $condition['do_company'] = trim(isset($param['do_company']) ? $param['do_company'] : '');
            //商品sku搜索
            $condition['doi_sku'] = trim(isset($param['doi_sku']) ? $param['doi_sku'] : '');
            if (!empty($condition['doi_sku'])) {

                $doiSku['doi_sku'] = $condition['doi_sku'];
                $datas = Service_DeliveryOrderItem::getByCondition($doiSku);
                $condition['do_id'] = array();
                foreach ($datas as $k => $v) {
                    $condition['do_id'][] = $v['do_id'];
                }
            }
            $count = $this->serviceClass->getByConditions($condition, 'count(*)');
            $return['total'] = $count;
            if ($count) {
                $showFields = array(
                    'do_id',
                    'user_id',
                    'ute_id',
                    'do_no',
                    'do_ship_no',
                    'do_ship_time',
                    'do_pre_receive_time',
                    'do_company',
                    'do_ship_company',
                    'do_ship_fee',
                    'do_status',
                    'ute_id'
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);

                $deliverdatas = $this->serviceClass->getByConditions($condition, $showFields, $pageSize, $page, array('do_id desc'));


                $return['data'] = $deliverdatas;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }
        echo Ec::renderTpl($this->tplDirectory . "list_index.tpl", 'layout');
    }

    public function editAction()
    {
        $return = array(
            'state' => 0,
            'message' => '',
            'errorMessage' => array('Fail.')
        );

        if ($this->_request->isPost()) {
            $params = $this->_request->getParams();
            $row = array(
                'do_id' => '',
            );
            $row = $this->serviceClass->getMatchEditFields($params, $row);
            $paramId = $row['do_id'];
            if (!empty($row['do_id'])) {
                unset($row['do_id']);
            }
            $errorArr = $this->serviceClass->validator($row);

            if (!empty($errorArr)) {
                $return = array(
                    'state' => 0,
                    'message' => '',
                    'errorMessage' => $errorArr
                );
                die(Zend_Json::encode($return));
            }

            if (!empty($paramId)) {
                $result = $this->serviceClass->update($row, $paramId);
            } else {
                $result = $this->serviceClass->add($row);
            }
            if ($result) {
                $return['state'] = 1;
                $return['message'] = array('Success.');
            }

        }
        die(Zend_Json::encode($return));
    }

    public function getByJsonAction()
    {
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array());
        $paramId = $this->_request->getParam('paramId', '');
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'do_id')) {
            $rows = $this->serviceClass->getVirtualFields($rows);
            $result = array('state' => 1, 'message' => '', 'data' => $rows);
        }
        die(Zend_Json::encode($result));
    }

    public function deleteAction()
    {
        $result = array(
            "state" => 0,
            "message" => "Fail."
        );
        if ($this->_request->isPost()) {
            $paramId = $this->_request->getPost('paramId');
            if (!empty($paramId)) {
                if ($this->serviceClass->delete($paramId)) {
                    $result['state'] = 1;
                    $result['message'] = 'Success.';
                }
            }
        }
        die(Zend_Json::encode($result));
    }


    /**
     * @desc 头程发货
     * @author gan
     * @date 2017-06-20
     */
    public function pushDeliveryOrderAction(){
        $return = array(
            "state" => 500,
            "message" => "Fail"
        );

          $datas = array();
          $params = $this->_request->getParams();
          $condition = array();
          $condition['do_id'] = $params['doIds'];
          $deliveryOrderData = array();
          $deliveryOrder = array();
          $deliveryOrderItem = array();
          $delivery = array();
           //获取采购单号
          $ordernumber = Service_DeliveryOrder::getByCondition($condition);
          //组装发货装箱单的数据
          foreach($ordernumber as $key =>$value){
              // 获取用户与erp的关联的公司名信息
              $userinfo = Service_UserToErp::getByField($value['ute_id']);
              $erp['token'] = $userinfo['ute_token'];
              $erp['ute_erp_url'] = $userinfo['ute_erp_url'];
               $doId  =array();
               $doId['do_id'] = $value['do_id'];
               $deliveryOrder['do_no'] = $value['do_no'];
               $deliveyData = Service_DeliveryOrderItem::getByCondition($doId);
              foreach($deliveyData as $k => $v){
                      $deliveryOrderItem['doi_sku'] =$v['doi_sku'];
                      $deliveryOrderItem['doi_box_no'] =$v['doi_box_no'];
                      $deliveryOrderItem['doi_amount'] =$v['doi_amount'];
                      $deliveryOrderItem['doi_box_total_nw'] =$v['doi_box_total_nw'];
                      $deliveryOrderItem['doi_box_outside_long'] =$v['doi_box_outside_long'];
                      $deliveryOrderItem['doi_box_outside_width'] =$v['doi_box_outside_width'];
                      $deliveryOrderItem['doi_box_outside_heigh'] =$v['doi_box_outside_heigh'];
                      $deliveryOrderData[] = $deliveryOrderItem;
              }

              $delivery[] = array_merge($deliveryOrder,$deliveryOrderData);

              $param= array(
                  'token' =>  $erp['token'],
                  'erp_url' => $erp['ute_erp_url'],
                  'service' => '',
                  'data' =>$delivery,
              );

              $datas[] = $param;

          }

          //推送装箱单数据
          $delivery = Process_ApiProcess::postDeliveryOrder($datas);
          if($delivery){
              $return['state'] = '200';
              $return['message'] = 'success';
              die(Zend_Json::encode($return));
          }else{
              die(Zend_Json::encode($return));
          }



    }





    /**
     * @desc 生成批量添加发货表格
     */
    public function makeExcelAction()
    {
        Process_DeliveryIndexProcess::makeExcel();
    }

    /**
     * @desc 批量上传发货单
     */
    public function uploadAction()
    {
        $param = $this->_request->getParams();
        $uteId = $param['id'];

        if ($this->getRequest()->isPost()) {
            set_time_limit(0);
            ini_set('memory_limit', '500M');
            $return = array(
                'state' => 0,
                'message' => array('Request Method Err')
            );
            $file = $_FILES['fileToUpload'];
            $return = $this->serviceClass->uploadShelfTransaction($file, $uteId);
            die(Zend_Json::encode($return));
        }
    }


    /**
     * 获取发货单详情信息
     */
    public function getDeliveryDetailAction()
    {
        $doId = $this->_request->getParam('id', '');

        $return = array(
            'state' => 0,
            'message' => 'no Data'
        );
        $condition['do_id'] = $doId;
        if ($doId) {
            $deliveryOrderData = $this->serviceClass->getByField($doId);
            $deliveryOrderItemData = Service_DeliveryOrderItem::getByCondition($condition);

            $datas['deliveryOrderItemData'] = $deliveryOrderItemData;
            if (!empty($deliveryOrderData) && !empty($deliveryOrderItemData)) {
                $deliveryDate = array_merge($deliveryOrderData, $datas);
                $return['state'] = 1;
                $return['message'] = 'success';
                $return['data'] = $deliveryDate;
            }

        }
        die(Zend_Json::encode($return));

    }

    /**
     * 获取服务商
     * 获取海外仓服务商详情，问题待解决当选择多个商品订单时，怎么解决商品信息和token。
     *
     */
    public function getWarehouseAction(){

        $ids=$this->_request->getParam('id','');
        $condition['do_id'] = $ids;
        $data = Service_DeliveryOrder::getByCondition($condition);

        //记得处理不同的ute_id对应不同的token这一bug

        $return = array(
            'state' => 0,
            'message' => 'no Data'
        );
        $ids=$this->_request->getParam('id','');
        $condition['do_id'] = $ids;
        $data = Service_DeliveryOrder::getByCondition($condition);
        //循环比较数组中的数字
        for($i=0;$i<count($data);$i++) {
            if (isset($data[$i + 1]['ute_id']) && !empty($data[$i + 1]['ute_id'])) {
                if ($data[$i + 1]['ute_id'] == $data[$i]['ute_id']) {
                    $param[] = array();
                    foreach ($data as $key => $value) {
                        $param['ute_id'] = $value['ute_id'];
                        $param['do_id'] = $ids;
                    }
                } else {
                    $return['state'] = 2;//对应商品的token不同提示语句
                    die(Zend_Json::encode($return));
                }
            }
            $param[] = array();
            foreach ($data as $key => $value) {
                $param['ute_id'] = $value['ute_id'];
                $param['do_id'] = $ids;
            }
        }

        $param['data'] = Process_ApiProcess::getTransfer($param['ute_id']);
        if(!$param){
            die(Zend_Json::encode($return));
        }
         echo json_encode($param);


    }
    /**
     *功能:获取海外仓入库单模板基础数据
     * @param string ute_id获取对应的erp系统
     * @param string serviceCode 服务商代码
     * @return array 对应服务商模板基础数据
     * @date 2017-5-9
     * @author blank
     */
    public function getWarehouseDetailAction(){
        $params=$this->_request->getParam('service','');
        $return = array(
            'state' => 0,
            'message' => 'no Data'
        );
        $getParams=array();
        foreach ($params as $key=>$value){
           if(is_array($value)){
               $return['message'] = '参数有误';
               die(Zend_Json::encode($return));
           }
           $res=explode('=',$value);
           $getParams[]=array($res[0]=>$res[1]);
        }
        $arr=array();
        foreach ($getParams as $k=>$v){
            if(is_array($v)){
                foreach ($v as $kk=>$vv){
                    $arr[$kk]=$vv;
                }
            }
        }
        //选择的服务商
       $serviceCode=$arr['service_code'];
        if(empty($serviceCode)){
            $return['message'] = '没有选择合适服务商';
            die(Zend_Json::encode($return));
        }
        //来自哪个erp系统的商品
        $ute_id=$arr['ute_id'];
        //获取所有海外仓服务商
        $erpname = Process_ApiProcess::getTransfer($ute_id);
        foreach ($erpname as $key=>$val){
           if($val['serviceCode']==$serviceCode){
               $serviceName=$val['serviceName'];
           }
        }
        //获取对应的服务商仓库
        $ServiceWarehouse=Process_ApiProcess::getServiceWarehouse($ute_id,$serviceCode);
        //获取对应的销售单号
        $condition['do_id']=$arr['do_id'];
        $Deliveryorder=Service_DeliveryOrder::getInfoDetail($condition);
        //获取采购单中的目的仓库作为装箱单的中转仓库
        $condition['order_no']=$Deliveryorder[0]['do_no'];
        $order=Service_Orders::getOrderWarehouse($condition);
        $do_warehouse_id=$order[0]["order_warehouse_id"];
        //获取对应中转仓名称
        //$warehouse=Process_ApiProcess::getTransferWarehouehouse($arr['ute_id']);
        //运输方式
        $smCode=Process_ApiProcess::getWarehoueShippingMethod($arr['ute_id'],$do_warehouse_id);
        //获取对应模板
        $WarehouseInfo=Process_ApiProcess::getServiceBaseData($ute_id,$serviceCode);
         $data=array(
             'do_id'=>$arr['do_id'],
             'ute_id'=>$arr['ute_id'],
             'serviceCode'=>$serviceCode,
             'serviceName'=>$serviceName,//海外仓服务商
             'ServiceWarehouse'=>$ServiceWarehouse,//服务商仓库
             'toWarehouseId'=>$do_warehouse_id,//中转仓库
             'smCode'=>$smCode,//运输方式
             'WarehouseInfo'=>$WarehouseInfo//模板信息
         );
        echo  json_encode($data);
    }

    /**
     * 组装装箱单信息
     */
    public function packageDetailAction(){
        $return = array(
            'state' => 0,
            'message' => '',
            'errorMessage' => array('Fail.')
        );
        if($this->_request->isPost()){
            $params=$this->_request->getParams();
                $do_id[]=$params["do_id"];
                $pushPackData=Process_ApiProcess::pushPackData($do_id);
                foreach ($pushPackData as $key=>$v) {
                    $result['productList'][$key] = array(
                        'productSku' => $v['doi_sku'],//产品代码
                        'boxNo' => $v['doi_box_no'],//箱号
                        'quantity' =>$v['doi_amount'],//产品数量
                        'weight' => sprintf("%1\$.2f",$v['doi_weight']*$v['doi_amount'],2),//总重量
                        'length' => $v['doi_box_outside_long'],//箱长
                        'width' => $v['doi_box_outside_width'],//箱宽
                        'height' => $v['doi_box_outside_heigh'],//箱高
                        'validDate'=>date("Y-m-d",time()+3600*24*7),//有效期生成装箱单一个星期
                        'packageType'=>$params ["packageTypeArr"],
                        'goodsType'=>$params["goodsTypeArr"]
                    );

                }
            $predate=date("Y-m-d",strtotime($pushPackData[0]["do_ship_time"]));
            $dadate=date("Y-m-d",strtotime($pushPackData[0]["do_pre_receive_time"]));
            $weight=Common_Common::getArrayColumn($result['productList'], 'weight');
            $result = array(
                'poCode' => $pushPackData[0]['do_no'],
                'serviceCode' => $params['serviceCode'],
                'stpoDateEta' => isset($predate)? $predate:date("Y-m-d",time()),//预计发货时间
                'transferWarehouseId' => intval($params['toWarehouseId']),
                'toWarehouseId' => intval($params['ServiceWarehouse']),
                'stpodatearrival' => isset($dadate) ? $dadate: date("Y-m-d",time()+3600*24*7),//预计到货时间
                'productList' =>$result['productList'],
                'weight' => sprintf("%1\$.2f",array_sum($weight)),//出货总重量
                'smCode' => $params['smCode'],//ERP运输方式
                'note' => 'api'//ERP备注说明
            );
            if(strtoupper($params['serviceCode'])=="4PX"){
                $result['carrierCode']=$params["carrierCodeArr"];
                $result['customsType']=$params["customsTypeArr"];
                $result['insureType']=$params['insureType'];
                $result['dutypayType']=$params['dutypayType'];
                if(!empty($params['description'])) {
                    $result['description'] =$params['description'];
                    }
                if($params["customsTypeArr"]=='D' ||$params["customsTypeArr"]=='V'){
                    $result['vatName']=$params['vatName'];
                    $result['vatCode']=$params['vatCode'];
                    $result['eoriCode']=$params['eoriCode'];
                }
                $res=Process_ApiProcess::packingInterface($params['ute_id'],$result);
                if(isset($res[0]['errorCode'])){
                    $return['message']=$res[0]['errorMsg'];
                }
                //调用pdf接口
                $pdfbase64=$res['data']['pdfBase64'];
                $res=Process_ApiProcess:: createPdfFileAndUrl($pdfbase64,$params["do_id"]);
                if($res){
                    $return['message']='装箱成功，等待发送';
                }else{
                    $return['message']='装箱失败，重新装箱';
                }
                die($return['message']);
            }elseif (strtoupper($params['serviceCode'])=="WINIT"){
                unset($result['productList'][0]["validDate"]);
                unset($result['productList'][0]["packageType"]);
                unset($result['productList'][0]["goodsType"]);
                 $result['winitProductCode']=!empty($params['winitProductCode'])?$params['winitProductCode']:'OW01010374';//WINIT产品
                 $result['inspectionWarehouseCode']=!empty($winitProductCode['warehouseCode'])?$winitProductCode['warehouseCode']:'SZ0001';
                 $result['inspectionType']=$params['inspectionTypeArr'];
                 $result['sellerOrderNo']=!empty($params['sellerOrderNo'])?$params['sellerOrderNo']:'';
                 $result['pickupType']=$params['packageTypeArr'];//提货类型
                 if(strtoupper($params['packageTypeArr'])=="P"){
                     $result['reservePickupDate']=$params['reservePickupDate'];
                     $result['reservePickupTime']=$params["reservePickupTimeArr"];
                 }
                 if(strtoupper($params['packageTypeArr'])=="S"){
                     $result['expressVendorCode']=!empty($params['expressVendorCode'])?$params['expressVendorCode']:'LB';//待定
                     $result['expressNo']=!empty($params['expressNo'])?$params['expressNo']:'LB0001';//待定
                 }
                 $result['logisticsPlanNo']='27625';//待定 物流计划
                 $result['importerCode']=!empty($params['winitImporterVendorAr'])?$params['winitImporterVendorAr']:'IR0000000101';
                 $result['exporterCode']=!empty($params['winitExporterVendorArr'])?$params['winitExporterVendorArr']:'ER002';
                $res=Process_ApiProcess::packingInterface($params['ute_id'],$result);
                if(isset($res[0]['errorCode'])){
                    $return['message']=$res[0]['errorMsg'];
                }
                //调用pdf接口
                $pdfbase64=$res['data']['pdfBase64'];
                $res=Process_ApiProcess:: createPdfFileAndUrl($pdfbase64,$params["do_id"]);
                if($res){
                    $return['message']='装箱成功，等待发送';
                }else{
                    $return['message']='装箱失败，重新装箱';
                }
                die($return['message']);
            }elseif(strtoupper($params['serviceCode'])=="FBA"){
                unset($result['productList'][0]["validDate"]);
                unset($result['productList'][0]["packageType"]);
                unset($result['productList'][0]["goodsType"]);
                $resFBA=array(
                    'userAccount'=>!empty($params['userAccountArr'])?$params['userAccountArr']:'',
                    'countryCode'=>$params["countryArr"],
                    'labelType'=>$params["labelTypeArr"],
                    'carrierName'=>'',//承运人
                    'packageType'=>intval($params["packageTypeArr"]),
                    'addressBook'=>intval($params["addressArr"]),
                    'shipmentName'=>'',//货件名称
                    'pageType'=>$params['pageTypeArr']
                    );
                $result=array_merge($result,$resFBA);
                $res=Process_ApiProcess::packingInterface($params['ute_id'],$result);
                if(isset($res[0]['errorCode'])){
                    $return['message']=$res[0]['errorMsg'];
                }
                //调用pdf接口
                $pdfbase64=$res['data']['pdfBase64'];
                $res=Process_ApiProcess:: createPdfFileAndUrl($pdfbase64,$params["do_id"]);
                if($res){
                    $return['message']='装箱成功，等待发送';
                }else{
                    $return['message']='装箱失败，重新装箱';
                }
                die($return['message']);
            }else{
               if(strtoupper($params['serviceCode'])=="EC"){
                   unset($result['productList'][0]["validDate"]);
                   unset($result['productList'][0]["packageType"]);
                   unset($result['productList'][0]["goodsType"]);
                   $result['incomeType']=$params['incomeType'];
                   $result['referenceNo']=$params['referenceNo'];//参考单号
                   $result['transitWarehouseCode']=$params['transitWarehouseCode'];//交货仓库
                   $result['taxType']=$params['taxType'];//关税类型
                   $result['shippingMethod']=$params['shippingMethod'];//头程派送方式
                   $result['trackingNumber']=$params['trackingNumber'];//跟踪号
                   $result['etaDate']=!empty($params['etaDate'])?$params['etaDate']:date("Y-m-d",time()+3600*24*7);//预计到达时间
                   $result['receivingDesc']=$params['receivingDesc'];//备注说明
                   //如果是揽收
                   if(intval($params['incomeType'])==1){
                       $resEC=array(
                           'regionIdLevel0'=>$params['regionIdLevel0'],
                           'regionIdLevel1'=>$params['regionIdLevel1'],
                           'regionIdLevel2'=>$params['regionIdLevel2'],
                           'street'=>$params['street'],
                           'contacter'=>$params['contacter'],
                           'contactPhone'=>$params['contactPhone']
                       );
                   }
                   $result=array_merge($result,$resEC);
                   $res=Process_ApiProcess::packingInterface($params['ute_id'],$result);
                   if(isset($res[0]['errorCode'])){
                       $return['message']=$res[0]['errorMsg'];
                   }
                   //调用pdf接口
                   $pdfbase64=$res['data']['pdfBase64'];
                   $res=Process_ApiProcess:: createPdfFileAndUrl($pdfbase64,$params["do_id"]);
                   if($res){
                       $return['message']='装箱成功，等待发送';
                   }else{
                       $return['message']='装箱失败，重新装箱';
                   }
                   die($return['message']);
               }
            }
        }
        die(Zend_Json::encode($return));
    }

    /**
     *测试
     */
    public function testAction(){
       /* $request = array(
            //这些是基本数据
            "poCode"=> "PO2781705180015",
            "serviceCode"=> "WINIT",
            "stpoDateEta"=>"2036-02-05",
            "transferWarehouseId"=>278,
            "toWarehouseId"=>298 ,
            "stpodatearrival"=>"2036-02-05",
            "productList"=> array(
                array(
                    "productSku"=> "000321",
                    "boxNo"=> "111",
                    "quantity"=>  "2",
                    "weight"=> "4.00",
                    "length"=>"6.00" ,
                    "width"=>"6.00" ,
                    "height"=>"6.00"
                )
            ),
            "weight"=>"4.00" ,
            "smCode"=>"SZCLOTH-COPY3",
            "note"=>'api',
            //下面是你给我的参数
            'sellerOrderNo'=>'WL0021200001',
            'inspectionWarehouseCode'=>'SZ0001',
            'destinationWarehouseCode'=>'US0001',
            'winitProductCode'=>'OW01010374',
            'importerCode'=>'IR0000000101',
            'exporterCode'=>'ER002',
            'logisticsPlanNo'=>'27625',
            'orderType'=>'SD',
            'inspectionType'=>'WI',
            'pickupType'=>'S',
            'pickupAddressCode'=>'',
            'reservePickupDateFrom'=>'2017-05-01 00:00:00',
            'reservePickupDateTo'=>'2017-05-01 00:00:00',
            'expressVendorCode'=>'LB',
            'expressVendorName'=>'龙邦',
            'expressNo'=>'LB0001',
            'packageList'=>array(
                array(
                    'sellerCaseNo'=>'A00012341',
                    'sellerWeight'=>'2.5',
                    'sellerLength'=>'20',
                    'sellerWidth'=>'20',
                    'sellerHeight'=>'30',
                    'merchandiseList'=>array(
                        array(
                            'merchandiseCode'=>'LCD-IP4S-02',
                            'specification'=>'',
                            'quantity'=>'10'
                        )
                    )
                )
            )
      );*/
        $request = array(
            'serviceCode' => '4PX',
            'stpoDateEta' => '2017-06-21',
            'transferWarehouseId' =>278,
            'toWarehouseId' => 296,
            'carrierCode' => 'HKEMS',
            'dutypayType' => 'Y',
            'insureType' => 'LI',
            'customsType' => 'N',
            //'description' => '备注说明。。。',
//             'referenceCode' => 'referenceCode111',
            /*'vatName' => '公司名称',
            'vatCode' => 'vatCode',
            'eoriCode' => 'eoriCode',*/
            'poCode' => 'PO2781705190014',
            'productList' => array(
                array(
                    'productSku' => '000321',
                    'boxNo' => 1,
                    'quantity' => 1000,
                    'weight' => 3,
                    'length' => 4,
                    'width' => 5,
                    'height' => 6,
                    'packageType' => 'OW01',
                    'goodsType' => 'P',
                    'validDate' => '2017-05-20'
                )
            ),
            'stpoDateArrival' => '2017-05-20',
            'weight' => 30,
            'smCode' => 'TIANTIANWULIU',
            'note'=> 'api'
        );
        $res=Process_ApiProcess::packingInterface(39,$request);
        var_dump($res);
        $pdfbase64=$res['data']['pdfBase64'];
        var_dump($pdfbase64);
    }



    /**
     * desc 装箱单数据生成pdf文件
     * date 2017/05/11
     */
    public function createPdfFileAction(){
        if (!extension_loaded('gd')) {
            die('请开启GD库！');
        }
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        require_once('tcpdf/tcpdf.php');

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);
        $pdf->SetAutoPageBreak(FALSE);
        $pdf->SetFont('droidsansfallback', '', 8);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
       /* $pdf->AddPage();
        $pdf->Cell(40,10,$word,15);
        $pdf->Output();*/
/*//        $this->view->result = $result;

        $html = $this->view->render($this->tplDirectory . "create_fourpx_pdf_file.tpl");
        $html =  preg_replace('/\s+/',' ',$html);//去除换行
        $html =  preg_replace('/\'/','"',$html);//引号

        $htmlArr[] = $html;

        foreach ($htmlArr as $html) {
            $pdf->AddPage();
            $pdf->writeHTML($html, true, false, true, false, 'C');
        }

        $pdf->lastPage();
        $date = date('Y-m-d H:i:s',time());

        $Code = 'test'.$date;
        $pdf->Output($Code . '.pdf', 'D');*/

        exit;

    }

    /**
     * desc 装箱单数据入库生成入库单号和pdf文件base64_encode编码
     * author gan
     * date 2017/05/11
     */

    public function createPackInterfaceDataAction(){
        $paramsData=$this->_request->getParam('data','');
        $params = array();
        //当serviceCode =4px时参数为
        if($paramsData['serviceCode'] = '4PX'){
            $params = array(
                'poCode' => $paramsData['poCode'],
                'serviceCode' => $paramsData['serviceCode'],
                'stpoDateEta' => $paramsData['stpoDateEta'],
                'transferWarehouseId' => $paramsData['transferWarehouseId'],
                'toWarehouseId' => $paramsData['toWarehouseId'],
                'stpodatearrival' => $paramsData['stpodatearrival'],
                'weight' => $paramsData['weight'],
                'smCode' => $paramsData['smCode'],
                'note' => $paramsData['note'],
                'productList' => $paramsData['productList'],
                'carrierCode' => $paramsData['carrierCode'],
                'referenceCode' => $paramsData['referenceCode'],
                'dutypayType' => $paramsData['dutypayType'],
                'insureType' => $paramsData['insureType'],
                'customsType' => $paramsData['customsType'],
                'description' => $paramsData['description'],
                'vatName' => $paramsData['vatName'],
                'eoriCode' => $paramsData['eoriCode'],
                'service' => "transferDelivery"
            );
        }elseif ($paramsData['serviceCode'] = 'WINIT'){
            //当serviceCode =WINIT时参数为
            $params = array(
                'poCode' => $paramsData['poCode'],
                'serviceCode' => $paramsData['serviceCode'],
                'stpoDateEta' => $paramsData['stpoDateEta'],
                'transferWarehouseId' => $paramsData['transferWarehouseId'],
                'toWarehouseId' => $paramsData['toWarehouseId'],
                'stpodatearrival' => $paramsData['stpodatearrival'],
                'weight' => $paramsData['weight'],
                'smCode' => $paramsData['smCode'],
                'note' => $paramsData['note'],
                'winitProductCode' => $paramsData['winitProductCode'],
                'inspectionType' => $paramsData['inspectionType'],
                'inspectionWarehouseCode' => $paramsData['inspectionWarehouseCode'],
                'sellerOrderNo' => $paramsData['sellerOrderNo'],
                'pickupType' => $paramsData['pickupType'],
                'reservePickupDate' => $paramsData['reservePickupDate'],
                'reservePickupTime' => $paramsData['reservePickupTime'],
                'expressVendorArr' => $paramsData['expressVendorArr'],
                'expressVendorCode' => $paramsData['expressVendorCode'],
                'expressNo' => $paramsData['expressNo'],
                'logisticsPlanNo' => $paramsData['logisticsPlanNo'],
                'importerCode' => $paramsData['importerCode'],
                'exporterCode' => $paramsData['exporterCode'],
                'productList' => $paramsData['productList'],
                'service' => "transferDelivery"
            );
        }elseif ($paramsData['serviceCode'] = 'FBA'){
            //当serviceCode =FBA 时参数为
            $params =array(    'poCode' => $paramsData['poCode'],
                'serviceCode' => $paramsData['serviceCode'],
                'stpoDateEta' => $paramsData['stpoDateEta'],
                'transferWarehouseId' => $paramsData['transferWarehouseId'],
                'toWarehouseId' => $paramsData['toWarehouseId'],
                'stpodatearrival' => $paramsData['stpodatearrival'],
                'weight' => $paramsData['weight'],
                'smCode' => $paramsData['smCode'],
                'note' => $paramsData['note'],
                'productList' => $paramsData['productList'],
                'userAccount' => $paramsData['userAccount'],
                'countryCode' => $paramsData['countryCode'],
                'labelType' => $paramsData['labelType'],
                'carrierName' => $paramsData['carrierName'],
                'addressBook' => $paramsData['addressBook'],
                'packageType' => $paramsData['packageType'],
                'shipmentName' => $paramsData['shipmentName'],
                'pageType' => $paramsData['pageType'],
                'service' => "transferDelivery"
            );
        }elseif ($paramsData['serviceCode'] = 'EC'){
            //当serviceCode =EC 时参数为
            $params =array(
               'poCode' => $paramsData['poCode'],
               'serviceCode' => $paramsData['serviceCode'],
               'stpoDateEta' => $paramsData['stpoDateEta'],
               'transferWarehouseId' => $paramsData['transferWarehouseId'],
               'toWarehouseId' => $paramsData['toWarehouseId'],
               'stpodatearrival' => $paramsData['stpodatearrival'],
               'weight' => $paramsData['weight'],
               'smCode' => $paramsData['smCode'],
               'note' => $paramsData['note'],
               'productList' => $paramsData['productList'],
               'incomeType' => $paramsData['incomeType'],
               'referenceNo' => $paramsData['referenceNo'],
               'transitWarehouseCode' => $paramsData['transitWarehouseCode'],
               'taxType' => $paramsData['taxType'],
               'shippingMethod' => $paramsData['shippingMethod'],
               'trackingNumber' => $paramsData['trackingNumber'],
               'shipmentName' => $paramsData['shipmentName'],
               'etaDate' => $paramsData['etaDate'],
               'receivingDesc' => $paramsData['receivingDesc'],
               'regionIdLevel0' => $paramsData['regionIdLevel0'],
               'regionIdLevel1' => $paramsData['regionIdLevel1'],
               'regionIdLevel2' => $paramsData['regionIdLevel2'],
               'street' => $paramsData['street'],
               'contacter' => $paramsData['contacter'],
               'contactPhone' => $paramsData['contactPhone'],
               'service' => "transferDelivery"
            );
        }else{
            $params =array(
                'poCode' => $paramsData['poCode'],
                'serviceCode' => $paramsData['serviceCode'],
                'stpoDateEta' => $paramsData['stpoDateEta'],
                'transferWarehouseId' => $paramsData['transferWarehouseId'],
                'toWarehouseId' => $paramsData['toWarehouseId'],
                'stpodatearrival' => $paramsData['stpodatearrival'],
                'weight' => $paramsData['weight'],
                'smCode' => $paramsData['smCode'],
                'note' => $paramsData['note'],
                'productList' => $paramsData['productList'],
                'service' => "transferDelivery"
            );
        }

        $data = Process_ApiProcess::packingInterface($params);
        return $data;


    }



    /**
     * @desc 生成pdf文件的方法
     * @author gan
     * @date 2017/05/19
     * @return string 生成pdf文件的路径
     */
    public function getPdfUrlAction(){
        $datas = 'd3d3LmpiNTEubmV0IOiEmuacrOS5i+Wutg==';
        $do_id = 30;
//        $result = Process_ApiProcess::createPdfFileAndUrl($datas,$do_id);
////        var_dump($result);exit;

        $msg = array(
            'fail'=>'403',
            'success'=>'200'
        );

        try{
            $file = APPLICATION_PATH."/../public/pdf/";
            $pdf_path = $file."base64.txt";
            //把获取到的base64编码的数据写入文件$pdf_path中临时保存起来
            $fileContents =  file_put_contents($pdf_path,$datas);
            if($fileContents == false){
                return false;
            }
            //获取写入的base64编码的数据
            $content = file_get_contents($pdf_path);
            //解码
            $word =  base64_decode($content);
            $date = time();
            $re = $file.$date.".pdf";
            //生成pdf文件
            $result =  file_put_contents($re,$word);
            if($result){
                //生成pdf成功，删除$pdf_path中临时保存base64.txt文件
                unlink ($pdf_path);
                //把生成的pdf文件url地址写入数据库中delivery_order表中
                $url = strstr($re, '/pdf');
                $do_pack_pdf_url = array();
                $do_pack_pdf_url['do_pack_pdf_url'] = $url;
                $deliveryOrder = Service_DeliveryOrder::update($do_pack_pdf_url,$do_id);
                if(!$deliveryOrder){
                    return false;
                }
                return $msg['success'];

            }
        }catch(Exception $e){
            return $e->getMessage();
        }

    }

    public function aaAction(){
      $a =  array("ErpCode"=>"ERP",
          "AppToken"=>"6b89ee8c295aad8e6767d6b1b968a3de",
          "Timestamp"=>"2017-03-24 14:05:56",
          "Service"=>"createExceptionOrder",
          "Params"=>json_encode(array(
                  array(
                  "Token"=>"1213daff432aaa124fc09e2efa698ef4",
                  "Provider"=>"BGF0001",
                  "OrderNo"=>"PO2921704150002",
                  "Oi_sku"=>"XFF2",
                  "Oe_check_amount_all"=>50,
                  "Oe_received_amount_all"=>41,
                  "Oe_pass_amount_all"=>32,
                  "Oe_except_amount"=>9,
                  "Oe_amunt_unit"=>"件",
              ),
            array(
                "Token"=>"1213daff432aaa124fc09e2efa698ef4",
                "Provider"=>"BGF0001",
                "OrderNo"=>"PO2921704150002",
                "Oi_sku"=>"XFF2",
                "Oe_check_amount_all"=>50,
                "Oe_received_amount_all"=>41,
                "Oe_pass_amount_all"=>32,
                "Oe_except_amount"=>9,
                "Oe_amunt_unit"=>"件",
            ),
           array(
               "Token"=>"1213daff432aaa124fc09e2efa698ef4",
               "Provider"=>"BGF0001",
               "OrderNo"=>"PO2921704150002",
               "Oi_sku"=>"XFF2",
               "Oe_check_amount_all"=>50,
               "Oe_received_amount_all"=>41,
               "Oe_pass_amount_all"=>32,
               "Oe_except_amount"=>9,
               "Oe_amunt_unit"=>"件",
           ),
          ))
      );


      $b =   array("ErpCode"=>"EC",
            "AppToken"=>"6b89ee8c295aad8e6767d6b1b968a3de",
            "Timestamp"=>"2017-03-24 14:05:56",
            "Service"=>"createExceptionOrder",
            "Params"=>json_encode(array(
                "Token"=>"9e1753d1ec17e1911fc9b5d5cbdb8304",
                "Provider"=>"HFX0003",
                "OrderNo"=>"PO2781705190011",
                "Oi_sku"=>"100050",
                'oe_preorder_amount_all'=>5,
                'oe_receive_amount_all'=>3,
                'oe_ship_order_amount_all'=>3,
                'oe_ship_amount_all'=>3,
                "Oe_amunt_unit"=>"件",
            ))
        );





      $a =  json_encode($b);

      print_r($a);die;
    }

}