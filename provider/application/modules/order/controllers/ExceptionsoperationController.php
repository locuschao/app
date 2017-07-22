<?php
class Order_ExceptionsoperationController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "order/views/";
        $this->serviceClass = new Service_OrderExceptionOperationLogs();
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

            $count = $this->serviceClass->getByCondition($condition, 'count(*)');
            $return['total'] = $count;

            if ($count) {
                $showFields=array(
                    'oeol_id',
                    'oeol_return_no',
                    'oeol_ship_company',
                   'oeol_ship_no',
                   'oeol_return_amount',
                   'oeol_pay_way',
                   'oeol_ship_fee',
                   'oeol_ship_fee_unit',
                   'oeol_weight',
                  'oeol_weight_unit',
                    'oeol_create_time',
                   'oeol_update_time',
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getByCondition($condition,$showFields, $pageSize, $page, array('oeol_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }
        /*$statusTypes = Common_Status::exceptionsOrderStatus();
        $this->view->statusTypes = $statusTypes;*/
        echo Ec::renderTpl($this->tplDirectory . "exceptionsoperation_index.tpl", 'layout');
    }

    /**
     * 编辑
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
                
              'oeol_id'=>'',
            );
            $row=$this->serviceClass->getMatchEditFields($params,$row);
            $paramId = $row['oeol_id'];
            if (!empty($row['oeol_id'])) {
                unset($row['oeol_id']);
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
     * 转接json
     */
    public function getByJsonAction()
    {
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array());
        $paramId = $this->_request->getParam('paramId', '');
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'oeol_id')) {
            $rows=$this->serviceClass->getVirtualFields($rows);
            $result = array('state' => 1, 'message' => '', 'data' => $rows);
        }
        die(Zend_Json::encode($result));
    }

    /**
     * 删除
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
     * @desc 获取退货单详情
     * @date 2017-6-20
     */
    public function tuiHuoDetailAction(){
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array());
        $paramId = $this->_request->getParam('id', '');
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'oeol_id')) {
            $exceptionDetail=Service_OrderException::getByField($rows['oeol_id'],$field = 'oeol_id');
            $data=array_merge($rows,$exceptionDetail);
            $result = array('state' => 1, 'message' => '', 'data' => $data);
        }
        die(Zend_Json::encode($result));
    }
    

}