<?php

/**
 * Class Common_OrderQueueController
 * 同步跟踪号到wms队列
 */
class Common_OrderQueueController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "common/views/";
        $this->serviceClass = new Service_OrderQueue();
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
                $showFields = array(
                    'oq_id',
                    'system_code',
                    'order_code',
                    'oq_status',
                    'oq_sync_count',

                    'ask',
                    'message',
                    'error_code',
                    'error',
                    'oq_note',

                    'oq_add_time',
                    'oq_send_time'
                );

                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getByCondition($condition, $showFields, $pageSize, $page, array('oq_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }

        $outboundBatchStatusArr = Common_Status::outboundBatchStatus('auto');

        $orderQueueSendStatusArr = Common_Status::orderQueueSendStatus('auto');
        $orderQueueLogisticsStatusArr = Common_Status::orderQueueLogisticsStatus('auto');

        $this->view->outboundBatchStatusJson = json_encode($outboundBatchStatusArr);
        $this->view->outboundBatchStatusArr = $outboundBatchStatusArr;

        $this->view->orderQueueSendStatusJson = Zend_Json::encode($orderQueueSendStatusArr);
        $this->view->orderQueueSendStatusArr = $orderQueueSendStatusArr;

        $this->view->orderQueueLogisticsStatusJson = Zend_Json::encode($orderQueueLogisticsStatusArr);
        $this->view->orderQueueLogisticsStatusArr = $orderQueueLogisticsStatusArr;


        echo Ec::renderTpl($this->tplDirectory . "order_queue_index.tpl", 'layout');
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
                'oq_id' => '',
                'oq_status' => '',

                'oqm_id' => '0',
                'oq_sync_count' => '0',
            );
            $row = $this->serviceClass->getMatchEditFields($params, $row);
            $paramId = $row['oq_id'];
            if (!empty($row['oq_id'])) {
                unset($row['oq_id']);
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
                $return['message'] = array('操作成功');
            }

        }
        die(Zend_Json::encode($return));
    }

    public function getByJsonAction()
    {
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array());
        $paramId = $this->_request->getParam('paramId', '');
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'oq_id')) {
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
                    $result['message'] = '操作成功';
                }
            }
        }
        die(Zend_Json::encode($result));
    }
}