<?php
class Order_ExceptionsController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "order/views/";
        $this->serviceClass = new Service_OrderException();
    }

    public function listAction()
    {
        if ($this->_request->isPost()) {
            $page = $this->_request->getParam('page', 1);
            $pageSize = $this->_request->getParam('pageSize', 20);

            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 20;

            $return = array(
                "state" => 0,
                "message" => "No Data"
            );

            $params = $this->_request->getParams();
            $condition = $this->serviceClass->getMatchFields($params);
            $userId = Service_User::getUserId();
            $userinfo= Service_UserToErp::getUserAndErpRelation(array('user_id' => $userId, 'ute_status' => 1), array('ute_id'));
            $uteId = Common_Common::getArrayColumn($userinfo, 'ute_id');
            $condition['ute_id'] = implode(',',$uteId);
            $count = $this->serviceClass->getByCondition($condition, 'count(*)');
            $return['total'] = $count;

            if ($count) {
                $showFields=array(
                    'oe_id',
                    'order_id',
                   'order_no',
                    'oi_id',
                    'oi_sku',
                    'ute_id',
                    'ute_erp_name',
                    'oi_name',
                    'oi_name_en',
                    'oeol_id',
                    'oe_order_amount',
                    'oe_ship_amount',
                    'oe_check_amount',
                    'ooe_exception_amount',
                    'oe_supplement_amount',
                   'oe_return_amount',
                    'oe_amunt_unit',
                    'oe_type',
                    'oe_qc_handle_type',
                   'oe_receive_handle_type',
                    'oe_qc_status',
                    'oe_receive_status',
                    'oe_create_time',
                    'oe_update_time',
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass-> getByCondition($condition,$showFields, $pageSize, $page, array('oe_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }
        /*$statusTypes = Common_Status::exceptionsOrderStatus();
        $this->view->statusTypes = $statusTypes;*/
        echo Ec::renderTpl($this->tplDirectory . "exceptions_index.tpl", 'layout');
    }

    /**
     * @desc 编辑
     */
    public function editAction()
    {
        $return = array(
            'state' => 0,
            'message' => '',
            'errorMessage'=>array('Fail.')
        );

        if ($this->_request->isPost()) {
            $params = $this->_request->getParams();
            $row = array(
                
              'oe_id'=>'',
            );
            $row=$this->serviceClass->getMatchEditFields($params,$row);
            $paramId = $row['oe_id'];
            if (!empty($row['oe_id'])) {
                unset($row['oe_id']);
            }
            $errorArr = $this->serviceClass->validator($row);

            if (!empty($errorArr)) {
                $return = array(
                    'state' => 0,
                    'message'=>'',
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
    /**
     * @desc json
     */
    public function getByJsonAction()
    {
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array());
        $paramId = $this->_request->getParam('paramId', '');
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'oe_id')) {
            $rows=$this->serviceClass->getVirtualFields($rows);
            $result = array('state' => 1, 'message' => '', 'data' => $rows);
        }
        die(Zend_Json::encode($result));
    }
    /**
     * @desc 删除
     */
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
     * @desc 获取异常订单信息
     * @return max
     * @date 2017-6-19
     * @author blank
     */
    public function returnSingleAction(){
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array());
        $paramId = $this->_request->getParam('id', '');
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'oe_id')) {
            $rows=$this->serviceClass->getVirtualFields($rows);
            //生成时间退单号
            $time=date('YmdHis',time());
            //随机取出数字
            $str=rand(100000,999999);
            $returnNo=$time.$str;
            $rows=array_merge($rows,array('returnNo'=>$returnNo));
            $result = array('state' => 1, 'message' => '', 'data' => $rows);
        }
        die(Zend_Json::encode($result));
    }

    /**
     * @desc 添加退货单
     * @return max
     * @date 2017-6-19
     * @author blank
     */
    public function handleAddAction(){
        $return = array('state' => 0, 'message' => 'Fail', 'data' => array());
        $param = $this->_request->getParams();
        $companyId=$this->_request->getParam('oeol_ship_company','');
        $oe_id=$this->_request->getParam('oe_id','');
        $oeol_return_no=$this->_request->getParam('oeol_return_no','');
        $returnNo=Service_OrderExceptionOperationLogs::getByField($oeol_return_no,$field='oeol_return_no');
        if($returnNo){
            $return['message']='退货已处理';
            die(Zend_Json::encode( $return));
        }
        switch ($companyId )
        {
            case 1:
                $oeol_ship_company="顺丰快递";
                break;
            case 2:
                $oeol_ship_company="圆通快递";
                break;
        }
        if (!empty($param) ) {
            $exceptionArray=array(
                'oeol_return_no'=>$param['oeol_return_no'],
                'oeol_ship_company'=>$oeol_ship_company,
                'oeol_ship_no'=>$param['oeol_ship_no'],
                'oeol_return_amount'=>$param['totalAmount'],
                'oeol_pay_way'=>$param['oeol_pay_way'],
                'oeol_ship_fee'=>$param['oeol_ship_fee'],
                'oeol_ship_fee_unit'=>isset($param['oeol_ship_fee_unit'])?$param['oeol_ship_fee_unit']:'元',
                'oeol_weight'=>$param['totalWeight'],
                'oeol_weight_unit'=>isset($param['oeol_weight_unit'])?$param['oeol_weight_unit']:'kg',
                'oeol_create_time'=>date('YmdHis',time()),
                'oeol_update_time'=>date('YmdHis',time()),
            );
            $db = Common_Common::getAdapter();
            $db->beginTransaction();
            try {
                $id=Service_OrderExceptionOperationLogs::add($exceptionArray);
                if($id){
                    $row=array('oeol_id'=>$id);
                    $data=$this->serviceClass->update($row,$oe_id,$field = "oe_id");
                }
                $db->commit();
                $return['message'] = "条记录，操作成功";
                $return['state'] = 1;
            } catch (Exception $e) {
                $db->rollBack();
                $msg = $e->getMessage();
                $return['message'] = $e->getMessage();
            }
        }
        die(Zend_Json::encode( $return));
    }
    /**
     * 测试
     */
    public function testAction(){
        /*$param=array(
            'erp_url' => "http://ec.eccang.com",
            'supplierToken' => "b365fb21ce764e592dcb171a90d1aec0",
            'service' => 'getReceivingException'
        );
        $res=Process_ApiProcess::getReceivingException($param);
         foreach ($res as $v){
            $exceptionArray=array(
                'order_id'//订单表id
            );
         }*/
        $a=array("ErpCode"=>"EC",
            "AppToken"=>"6b89ee8c295aad8e6767d6b1b968a3de",
            "Timestamp"=>"2017-06-20 16:30:56",
            "Service"=>"createExceptionOrder",
            "Params"=>json_encode(array(
                "Token"=>"9e1753d1ec17e1911fc9b5d5cbdb8304",
                "Provider"=>"HFX0003",
                "order_id"=>"3",
                "order_no"=>"PO2781705190011",
                "oi_id"=>"2",
               "oi_sku"=>"100050",
               "oi_name"=>"易购",
               "oi_name_en"=>"yigou",
               "oe_order_amount"=>5,
               'oe_ship_amount'=>50,
               'oe_check_amount'=>37,
              'oe_exception_amount'=>3,
             "oe_supplement_amount"=>6,
             "oe_return_amount"=>3,
             "oe_status"=>1,
             "oe_amunt_unit"=>"件",
             "oe_handle_type"=>"退货",
        )));
      echo json_encode($a);
    }
}