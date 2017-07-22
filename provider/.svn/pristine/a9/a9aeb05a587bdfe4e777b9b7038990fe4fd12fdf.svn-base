<?php
class Report_StockreportController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "report/views/";
        $this->serviceClass = new Service_StockReport();
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
            $condition= array();
            //获取当前登录的用户id
            $userId = Service_User::getUserId();
            $condition['user_id'] = $userId;
            // 获取用户与erp的关联的公司名信息
            /*
             * 功能:erp对应关系ute_id
             */
            $userinfo= Service_UserToErp::getUserAndErpRelation(array('user_id' => $userId, 'ute_status' => 1), array('ute_id'));
            $uteId = Common_Common::getArrayColumn($userinfo, 'ute_id');
            $condition['ute_id'] = implode(',',$uteId);
            $condition['sr_sku']=trim(isset($params['sr_sku']) ? $params['sr_sku'] : '');
            $condition['firstDateinfo']=isset($params['firstDateinfo']) ? $params['firstDateinfo'] : '';
            $condition['endDateinfo']=isset($params['endDateinfo']) ? $params['endDateinfo'] : '';
            $count = $this->serviceClass->getByConditions($condition, 'count(*)');
            $return['total'] = $count;

            if ($count) {
                $showFields=array(
                 'sr_id',
                 'sr_sku',
                 'sr_spu',
                 'sr_category',
                 'sr_warehouse',
                 'sr_purchasing_amount',
                 'sr_shipping_amount',
                 'sr_available_amount',
                 'sr_stock_amount',
                 'sr_produce_amount',
                 'sr_rejects_amount',
                 'sr_input_amunt',
                 'sr_output_amount',
                 'sr_amount_unit',
                 'sr_cost_unit',
                 'sr_turnove_rates',
                 'sr_stock_cost',
                 'sr_save_day',
                 'sr_create_time',
                 'sr_produce_amount',
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getByConditions($condition,$showFields, $pageSize, $page, array('sr_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }





            die(Zend_Json::encode($return));
        }
        echo Ec::renderTpl($this->tplDirectory . "stock_report_index.tpl", 'layout');
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
     * @desc 导库存列表，导出库存列表信息
     * @author gan
     * @date 2017/04/17
     */
    function executeExportAction(){
        $params=$this->_request->getParams();

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
        $condition['firstDateinfo']=isset($params['firstDateinfo']) ? $params['firstDateinfo'] : '';
        $condition['endDateinfo']=isset($params['endDateinfo']) ? $params['endDateinfo'] : '';
        $condition['sr_sku']=isset($params['sr_sku']) ? $params['sr_sku'] : '';
        $rows=Service_StockReport::getByConditions($condition,'*','','','');

        if(empty($rows)){
            header("Content-type: text/html; charset=utf-8");
            echo "No Data";
            exit;
        }
        //生成Execl表格
        Process_StockProcess::createExportExcel($rows);
    }


}