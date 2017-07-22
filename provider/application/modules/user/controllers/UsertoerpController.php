<?php
class User_UserToErpController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "user/views/";
        $this->serviceClass = new Service_UserToErp();
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
            $this->boundNewErp('');
            $params = $this->_request->getParams();
            $condition = array();
            $userId = Service_User::getUserId();
            $condition['user_id'] = $userId;
            $condition['ute_status'] = isset($params['ute_status']) ? $params['ute_status'] : '';
            $condition['ute_erp_no'] = isset($params['ute_erp_no']) ? $params['ute_erp_no'] : '';
            $condition['ute_erp_name'] = isset($params['ute_erp_name']) ? $params['ute_erp_name'] : '';
            $count = $this->serviceClass->getByCondition($condition, 'count(*)');
            $return['total'] = $count;

            if ($count) {
                $showFields=array(
                'ute_id',
                'user_id',
                'ute_erp_no',
                'ute_erp_name',
                'ute_token',
                'ute_status',
                'ute_token_expire_time',
                'ute_create_time',
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getByCondition($condition,$showFields, $pageSize, $page, array('ute_id desc'));

                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }
        echo Ec::renderTpl($this->tplDirectory . "user_to_erp_index.tpl", 'layout');
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
                
              'ute_id'=>'',
            );
            $row=$this->serviceClass->getMatchEditFields($params,$row);
            $paramId = $row['ute_id'];
            if (!empty($row['ute_id'])) {
                unset($row['ute_id']);
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
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'ute_id')) {
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
     * @desc 绑定新ERP
     * @author Zijie Yuan
     * @date 2017-04-12
     * @return string
     */
    public function boundNewErpAction() {
        $result = array(
            'state' => 0,
            'message' => '',
            'errorMessage'=>array('Fail.')
        );
        if ($this->_request->isPost()) {
            $userCode = $this->_request->getPost('user_name','');
            $password = $this->_request->getPost('password','');
            $token = $this->_request->getPost('token','');

            if(empty($userCode)){
                $result['errorMessage'] = array('用户名不能为空！');
                die(Zend_Json::encode($result));
            }
            if(empty($password)){
                $result['errorMessage'] = array('密码不能为空！');
                die(Zend_Json::encode($result));
            }
            if(empty($token)){
                $result['errorMessage'] = array('token不能为空！');
                die(Zend_Json::encode($result));
            }
            $result = Service_UserToErp::boundNewToken($userCode, $password, $token);
        }
        die(Zend_Json::encode($result));
    }
}