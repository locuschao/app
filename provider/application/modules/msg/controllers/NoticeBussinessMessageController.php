<?php
class Msg_NoticeBussinessMessageController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "msg/views/";
        $this->serviceClass = new Service_NoticeBussinessMessage();
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
                    'nt_code',
                    'na_code',
                    'nbm_status',
                    'nbm_code',
                    'nbm_curr_user_id',
                    'nbm_curr_user_group_id',
                    'nbm_bus_no',
                    'nbm_ref_no',
                    'nbm_create_time',
                    'nbm_modify_time',
                    'nbm_id',
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getByCondition($condition,$showFields, $pageSize, $page, array('nbm_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }
        echo Ec::renderTpl($this->tplDirectory . "notice_bussiness_message_index.tpl", 'layout');
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
                
              'nbm_id'=>'',
              'nt_code'=>'',
              'na_code'=>'',
              'nbm_status'=>'',
              'nbm_code'=>'',
              'nbm_curr_user_id'=>'',
              'nbm_curr_user_group_id'=>'',
              'nbm_bus_no'=>'',
              'nbm_ref_no'=>'',
              'nbm_create_time'=>'',
              'nbm_modify_time'=>'',
            );
            $row=$this->serviceClass->getMatchEditFields($params,$row);
            $paramId = $row['nbm_id'];
            if (!empty($row['nbm_id'])) {
                unset($row['nbm_id']);
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
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'nbm_id')) {
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
     * @desc 获取通知事务消息流程
     * @auth Zijie Yuan
     * @return json
     */
     public function getBusinessMessageAction() {
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array());
        $param = $this->_request->getParam('E0', 0);
        $showFields = array(
            'nbm_curr_nar_code',
            'nbm_curr_user_id',
            'nbm_curr_user_group_id',
            'nbm_id'
        );
        $showFields = $this->serviceClass->getFieldsAlias($showFields);
        $result = $this->serviceClass->getBusinessMessage($param, 'nbm_id', $showFields);
        die(Zend_Json::encode($result));
    }

    /**
     * @desc 添加流程通知
     * @auth Zijie Yuan
     * @return json
     */
    public function addFlowMessageAction() {
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array());
        $param = $this->_request->getPost();
        if (empty($param)) {
            die(Zend_Json::encode($result));
        }

        $result = $this->serviceClass->addFlowMessage($param);
        die(Zend_Json::encode($result));
    }

    /**
     * @desc 确认/通过流程通知
     * @auth Zijie Yuan
     * @return json
     */
    public function passFlowMessageAction() {
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array());
        $param = $this->_request->getParam('umid', 0);
        if (empty($param)) {
            die(Zend_Json::encode($result));
        }
        $result = $this->serviceClass->passFlowMessage($param);
        die(Zend_Json::encode($result));
    }
}