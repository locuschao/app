<?php
class Report_FeedbackreportController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "report/views/";
        $this->serviceClass = new Service_ProductFeedbackReport();
    }

    public function listAction()
    {

        $cond = array();
        //获取当前登录用户的id
        $userId = Service_User::getUserId();
        $cond['user_id'] = $userId;
        //获取erp用户码和token
        $userMessages = Service_UserToErp::getUserAndErpRelation($cond);
        $erpCode = $userMessages['0']['ute_erp_no'];
        $token = $userMessages['0']['ute_token'];

        //获取uteId的初始erp信息
        //获取的字段信息
        $usernews = array(
            'ute_id',
            'user_id',
            'ute_erp_no',
            'ute_erp_name',
            'ute_erp_url',
            'ute_token',
            );
        $userinfo = Service_UserToErp::getUteInfo($cond,$usernews);



        //获取产品问题类型
        $getErrorData = Common_DataCache::getProductTroubleType($opeatption = 0,$userinfo['ute_erp_no'], $userinfo['ute_token'],$userinfo['ute_erp_url']);
        $this->view->getErrorData = $getErrorData;

        //获取产品问题处理方式
        $getProblemHandleMethor = Common_DataCache::getproductTroubleProcess($opeatption = 0,$userinfo['ute_erp_no'], $userinfo['ute_token'],$userinfo['ute_erp_url']);
        $this->view->getProblemHandleMethor = $getProblemHandleMethor;

        if ($this->_request->isPost()) {
            $page = $this->_request->getParam('page', 1);
            $pageSize = $this->_request->getParam('pageSize', 20);

            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 20;

            $return = array(
                "state" => 0,
                "message" => "No Data"
            );

            $userId = Service_User::getUserId();
            $condition = array();
            $params = $this->_request->getParams();
            $condition['user_id']=$userId;
            /*
             * 功能:erp对应关系ute_id
             */
            $userinfo= Service_UserToErp::getUserAndErpRelation($condition);
            $condition['ute_id']=array();
            foreach($userinfo as $k=>$v){
                if($v['ute_status']==0){
                    continue;
                }
                $condition['ute_id'][]=$v['ute_id'];
            }
            $condition['ute_id']=implode(',',$condition['ute_id']);
            $condition['pfr_sku']=trim(isset($params['pfr_sku']) ? $params['pfr_sku'] : '');
            $condition['pfr_from']=trim(isset($params['pfr_from']) ? $params['pfr_from'] : '');
            $condition['pfr_error_type']=trim(isset($params['pfr_error_type']) ? $params['pfr_error_type'] : '');
            $condition['pfr_settle_way']=trim(isset($params['pfr_settle_way']) ? $params['pfr_settle_way'] : '');
            $condition['firstDateinfo']=isset($params['firstDateinfo']) ? $params['firstDateinfo'] : '';
            $condition['endDateinfo']=isset($params['endDateinfo']) ? $params['endDateinfo'] : '';
            $count = $this->serviceClass->getByConditions($condition, 'count(*)');
            $return['total'] = $count;

            if ($count) {
                $showFields=array(
                    'pfr_id',
                    'pfr_sku',
                    'pfr_from',
                    'pfr_country_name',
                    'pfr_platform',
                    'pfr_rma_amount',
                    'pfr_rma_percent',
                    'pfr_refund_order',
                    'pfr_refund_cost',
                    'pfr_cost_unit',
                    'pfr_reship_order',
                    'pfr_reship_sku',
                    'pfr_rma_reason',
                    'pfr_warehouse_refund_order',
                    'pfr_warehouse_refund_sku',
                    'pfr_appear_time',
                    'pfr_error_type',
                    'pfr_quantity',
                    'pfr_settle_way',
                    'pfr_content',
                    'pfrp_thumb',
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getByConditions($condition,$showFields, $pageSize, $page, array('pfr_id desc'));

                $prf_id = array();
                $dec_pictrue = array();
                $datas = array();
                $pic = array();
                foreach($rows as $k =>$v){

                    $pfr_id['pfr_id'] = $v['D0'];
                    $content= Service_ProductFeedbackReportPicture::getByCondition($pfr_id);
                      if(!empty($content)){
                        foreach ($content as $key =>$value){

                            $pictrue = array();
                            if($v['D0'] ==$value['pfr_id']){
                                $pictrueDate = explode(';', $value['pfrp_url']);
                                $pictrue['D28'] =$pictrueDate;
                                $datas[] = array_merge($v,$pictrue);
                            }
                        }


                      }else{
                            $datas[] = $v;
                    }

                }
                $return['data'] = $datas;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }
        echo Ec::renderTpl($this->tplDirectory . "feedback_report_index.tpl", 'layout');
    }

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
                
              'pfr_id'=>'',
            );
            $row=$this->serviceClass->getMatchEditFields($params,$row);
            $paramId = $row['pfr_id'];
            if (!empty($row['pfr_id'])) {
                unset($row['pfr_id']);
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

    public function getByJsonAction()
    {
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array());
        $paramId = $this->_request->getParam('paramId', '');
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'pfr_id')) {
            $rows=$this->serviceClass->getVirtualFields($rows);
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
     * @desc 反馈列表，导出反馈列表详情
     * @author gan
     * @date 2017/04/17
     */
    function executeExportAction(){
        $params=$this->_request->getParams();

        $return=array('message'=>'');
        $condition=array();
        if(isset($params['pfr_id_arr'])){
            $sr_id_str=trim($params['pfr_id_arr'],'-');
            $srIdArr=explode('-', $sr_id_str);
            $condition['pfr_id_arr']=$srIdArr;
        }

        // 搜索条件处理
        // 获取userId
        $userId = Service_User::getUserId();
        // sku条件检索
        $condition['user_id'] = $userId;
        /*
         * 功能:erp对应关系ute_id
         */
        $userinfo= Service_UserToErp::getUserAndErpRelation(array('user_id' => $userId, 'ute_status' => 1), array('ute_id'));
        $uteId = Common_Common::getArrayColumn($userinfo, 'ute_id');
        $condition['ute_id'] = implode(',',$uteId);
        $condition['pfr_sku']=isset($params['pfr_sku']) ? $params['pfr_sku'] : '';
        $condition['pfr_from']=isset($params['pfr_from']) ? $params['pfr_from'] : '';
        $condition['firstDateinfo']=isset($params['firstDateinfo']) ? $params['firstDateinfo'] : '';
        $condition['endDateinfo']=isset($params['endDateinfo']) ? $params['endDateinfo'] : '';
        $rows=Service_ProductFeedbackReport::getByConditions($condition,'*','', '','');
        if(empty($rows)){
            header("Content-type: text/html; charset=utf-8");
            echo "No Data";
            exit;
        }
        //生成Execl表格
        Process_FeedbackProcess::createExportExcel($rows);
    }
}