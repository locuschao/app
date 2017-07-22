<?php
class User_UserController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "user/views/";
        $this->serviceClass = new Service_User();
    }

    public function userCenterAction(){
    
        try{
            $db = Common_Common::getAdapter();
            $dbConfig = $db->getConfig();
            $sql = "select * from ".Common_Common::getWmsDb().".config where config_attribute='USER_CENTER_URL'";
            $row = $db->fetchRow($sql);

            if($row){
                //跳转
                header('Location:'.$row['config_value']."?db=".$dbConfig['dbname']);
            }else{
                throw new Exception('未设置用户中心访问链接，请联系管理员配置config[USER_CENTER_URL]');
            }
        }catch(Exception $e){
            header("Content-type: text/html; charset=utf-8");
            echo $e->getMessage();
        }
        exit;
        //----------------------------------
    }
    
    public function listAction()
    {
        $statusArray = Common_Type::status('auto');
        $departmentArray = Common_DataCache::getDepartment();
        $positionArray = Common_DataCache::getUserPosition();
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
                    'user_code',
                    'user_name',
                    'user_name_en',
                    'user_status',
                    'ud_id',
                    'up_id',
                    'user_mobile_phone',
                    'user_last_login',
                    'user_id',
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getByCondition($condition, $showFields, $pageSize, $page, array('user_id asc'));
                $language = Ec::getLang(1);
                $uwmObj = new Service_UserWarehouseMap();
                foreach ($rows as $key => $val) {
                    $rows[$key]['E7'] = isset($departmentArray[$val['E7']]['ud_name' . $language]) ? $departmentArray[$val['E7']]['ud_name' . $language] : '';
                    $rows[$key]['E8'] = isset($positionArray[$val['E8']]['up_name' . $language]) ? $positionArray[$val['E8']]['up_name' . $language] : '';
                    $rows[$key]['E5'] = $statusArray[$val['E5']];
                    $rows[$key]['warehouse'] = $uwmObj->getLeftJoinWarehouseByCondition(array('user_id' => $val['E0']), '*', 0, 0);
                }
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }
        $language = Ec::getLang();
        $this->view->status = $statusArray;
        $this->view->department = $departmentArray;
        $this->view->position = $positionArray;
        $this->view->statusArr = Common_Type::status($language);
        $this->view->userArr = Service_User::getByCondition(array(),array('user_id','user_name','user_name_en'));
        $this->view->warehouse = Common_DataCache::getWarehouseSimple();
        echo Ec::renderTpl($this->tplDirectory . "user_index.tpl", 'layout');
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
                'user_id' => '',
                'user_code' => '',
                'user_password' => '',
                'user_name' => '',
                'user_name_en' => '',
                'user_status' => '',
                'user_email' => '',
                'ud_id' => '',
                'up_id' => '',
                'user_phone' => '',
                'user_mobile_phone' => '',
                'user_note' => '',
                'user_supervisor_id' => '',
            );
            $row = $this->serviceClass->getMatchEditFields($params, $row);
            $paramId = $row['user_id'];
            if (!empty($row['user_id'])) {
                unset($row['user_id']);
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
            $row['user_update_time']=date('Y-m-d H:i:s');
            if (!empty($row['user_password'])) {
                $row['user_password'] = Ec_Password::getHash($row['user_password']);
            }else{
                unset($row['user_password']);
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
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'user_id')) {
            $rows = $this->serviceClass->getVirtualFields($rows);
            unset($rows['E2']);
            $rows['warehouse'] = Service_UserWarehouseMap::getLeftJoinWarehouseByCondition(array('user_id' => $rows['E0']), '*', 0, 0);
            $result = array('state' => 1, 'message' => '', 'data' => $rows);
        }
        die(Zend_Json::encode($result));
    }

    /**
     * 进入个人设置界面
     */
    public function userSetAction(){
        echo Ec::renderTpl($this->tplDirectory . "user_set.tpl", 'layout');
    }
    
    /**
     * 修改用户资料
     */
    public function modifyUserProfileAction(){
        $return = array(
                'state' => 0,
                'message' => '',
                'errorMessage' => array('Fail.')
        );
         
        if ($this->_request->isPost()) {
            /*
             * 1. 检查请求类型
            */
            $type = $this->_request->getParam('type','');
            if(empty($type)){
                $return['message'] = '非法的请求，请勿修改请求连接.';
                die(Zend_Json::encode($return));
            }
            $userId = Service_User::getUserId();
            $user = Service_User::getByField($userId, 'user_id', array('user_id', 'user_password'));

            /*
             * 2. 检查用户信息
            */
            if(empty($user)){
                $return['message'] = '未找到用户信息，请重新登录.';
                die(Zend_Json::encode($return));
            }
            /*
             * 3. 调用对应的修改方法
            */

            if($type == 'password'){
                $return = $this->modPassword($user);
            }
        }
        die(Zend_Json::encode($return));
    }

    private function modPassword($user){
    	$return = array(
			'state' => 0,
			'message' => '',
			'errorMessage' => array('Fail.')
    	);
    	
    	$oldPassword = $this->_request->getParam('old_password','');
    	$newPassword = $this->_request->getParam('new_password','');
    	$newPasswordAgain = $this->_request->getParam('new_password_again','');
    	 
    	$checkBol = true;
    	if(empty($oldPassword)){
    		$return['message'] = '原始密码不能为空.';
    		$checkBol = false;
    
    	}else if(!Ec_Password::comparePassword($oldPassword, $user['user_password'])){
    		$return['message'] = '原始密码输入错误，请检查.';
    		$checkBol = false;
    	}else if(empty($newPassword)){
    		$return['message'] = '新密码不能为空.';
    		$checkBol = false;
    	}else if(empty($newPasswordAgain)){
    		$return['message'] = '确认新密码不能为空.';
    		$checkBol = false;
    	}else if($newPassword != $newPasswordAgain){
    		$return['message'] = '两次密码输入不一致，请检查.';
    		$checkBol = false;
    	}
    	 
    	if(!$checkBol){
    		return $return;
    	}
    	 
    	$userId = $user['user_id'];
    	$updatePassword = Ec_Password::getHash($newPassword);
    	$date = date('Y-m-d H:i:s');
        $result = Service_User::update(array(
            'user_password' => $updatePassword,
            'user_password_update_time' => $date,
            'user_update_time' => $date
        ), array('user_id' => $userId));

		if($result){
			$return['state'] = 1;
			$return['message'] = '修改密码成功.';
            return $return;
		}
		$return['message'] = '修改密码失败，请稍后尝试.';
    	return $return;
    }
}