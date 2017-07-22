<?php
class Common_OrdersController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "common/views/";
        $this->serviceClass = new Service_Orders();
    }

    public function listAction()
    {
//     	echo "dsdsadsd";
//     	exit();
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
                    
                'system_code',
                'order_code',
                'tracking_number',
                'order_status',
                'create_type',
                'sm_code',
                'sync_wms_time',
                'sync_express_status',
				'order_id',
                );
				
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getByCondition($condition,$showFields, $pageSize, $page, array('order_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }

        $outboundBatchStatusArr=Common_Status::outboundBatchStatus('auto');


        $this->view->outboundBatchStatusJson=json_encode($outboundBatchStatusArr);


        $this->view->outboundBatchStatusArr=$outboundBatchStatusArr;

        echo Ec::renderTpl($this->tplDirectory . "orders_index.tpl", 'layout');
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
                
              'ob_id'=>'',
              'ob_no'=>'',
              'service_code'=>'',
              'ob_path'=>'',
              'ob_error_count'=>'',
              'ob_status'=>'',
              'ob_sync_status'=>'',
              'ob_note'=>'',
              'ob_sync_time'=>'',
              'ob_succeed_time'=>'',
              'ob_create_date'=>'',
              'ob_update_time'=>'',
            );
            $row=$this->serviceClass->getMatchEditFields($params,$row);
            $paramId = $row['ob_id'];
            if (!empty($row['ob_id'])) {
                unset($row['ob_id']);
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
                $return['message'] = array('操作成功');
            }

        }
        die(Zend_Json::encode($return));
    }

    public function getByJsonAction()
    {
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array());
        $paramId = $this->_request->getParam('paramId', '');
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'ob_id')) {
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
                    $result['message'] = '操作成功';
                }
            }
        }
        die(Zend_Json::encode($result));
    }
}