<?php
class Report_SaleReportController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "report/views/";
        $this->serviceClass = new Service_SaleReport();
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
            $condition['sr_from'] =trim(isset($params['sr_from']) ? $params['sr_from'] : '');
            $condition['startTime']=isset($params['startTime']) ? $params['startTime'] : '';
            $condition['endTime']=isset($params['endTime']) ? $params['endTime'] : '';

            $count = $this->serviceClass->getByCondition($condition, 'count(*)');
//            var_dump($count);exit;

            $return['total'] = $count;

            if ($count) {
                $showFields=array(
                    'sr_id',
                    'sr_sku',
                    'sr_from',
                    'sr_platform',
                    'sr_country_name',
                    'sr_category',
                    'sr_amount',
                    'sr_amount_unit',
                    'sr_sale_gross',
                    'sr_cost',
                    'sr_price',
                    'sr_update_time',
                    'sr_trend',
                    'sr_increase_rate',
                    'sr_ship_fee',
                    'sr_poundage',
                    'sr_service_ship_fee',
                    'sr_3d_amount',
                    'sr_7d_amount',
                    'sr_14d_amount',
                    'sr_30d_amount',
                    'sr_perior_amount',
                    'sr_prior_perior_amount',
                    'sr_prior_two_perior_amount',
                    'sr_prior_three_perior_amount',
                    'sr_perior_price',
                    'sr_prior_perior_price',
                    'sr_prior_two_perior_price',
                    'sr_prior_three_perior_price',
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getByCondition($condition,$showFields, $pageSize, $page, array('sr_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }
        echo Ec::renderTpl($this->tplDirectory . "sale_report_index.tpl", 'layout');
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
                
              'sr_id'=>'',
            );
            $row=$this->serviceClass->getMatchEditFields($params,$row);
            $paramId = $row['sr_id'];
            if (!empty($row['sr_id'])) {
                unset($row['sr_id']);
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
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'sr_id')) {
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
     * @desc 销售报表，导出销售报表详情
     * @author gan
     * @date 2017/04/18
     */
    function executeExportAction(){
        $params=$this->_request->getParams();

        $return=array('message'=>'');
        $condition=array();
        if(isset($params['sr_id_arr'])){
            $sr_id_str=trim($params['sr_id_arr'],'-');
            $srIdArr=explode('-', $sr_id_str);
            $condition['sr_id_arr']=$srIdArr;
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
        $condition['startTime']=isset($params['startTime']) ? $params['startTime'] : '';
        $condition['endTime']=isset($params['endTime']) ? $params['endTime'] : '';
        $condition['sr_from']=isset($params['sr_from']) ? $params['sr_from'] : '';

        $rows=Service_SaleReport::getByCondition($condition,'*','', '','');

        if(empty($rows)){
            header("Content-type: text/html; charset=utf-8");
            echo "No Data";
            exit;
        }
        //生成Execl表格
        Process_SaleProcess::createExportExcel($rows);
    }



}