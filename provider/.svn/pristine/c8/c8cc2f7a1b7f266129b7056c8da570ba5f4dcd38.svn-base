<?php

class Service_User extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_User|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_User();
        }
        return self::$_modelClass;
    }

    /**
     * @param $row
     * @return mixed
     */
    public static function add($row)
    {
        $model = self::getModelInstance();
        return $model->add($row);
    }


    /**
     * @param $row
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function update($row, $value, $field = "user_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "user_id")
    {
        $model = self::getModelInstance();
        return $model->delete($value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @param string $colums
     * @return mixed
     */
    public static function getByField($value, $field = 'user_id', $colums = "*")
    {
        $model = self::getModelInstance();
        return $model->getByField($value, $field, $colums);
    }

    public static function getConditionByIn($value, $field = 'user_id', $colums = "*")
    {
        $model = self::getModelInstance();
        return $model->getConditionByIn($value, $field, $colums);
    }

    public static function getByConditionForWechat($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
    	$model = self::getModelInstance();
    	return $model->getByConditionForWechat($condition, $type, $pageSize, $page, $order);
    }

    /**
     * @return mixed
     */
    public static function getOne()
    {
        $model = self::getModelInstance();
        return $model->getOne();
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        $model = self::getModelInstance();
        return $model->getAll();
    }

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getByCondition($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $model = self::getModelInstance();
        return $model->getByCondition($condition, $type, $pageSize, $page, $order);
    }

    
    /**
     * 由账号或者姓名得到user_id
     */
    public static function getId($nameOrCode){
        $model = self::getModelInstance();
        $code = $model->getByField($nameOrCode, 'user_code', '*'); 
        $name = $model->getByField($nameOrCode, 'user_name', '*'); 
        if(!empty($code)){
            return $code;
        }else if(!empty($name)){
            return $name;
        }else{
            return;
        }
    }

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getByConditionSelect($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $model = self::getModelInstance();
        return $model->getByConditionSelect($condition, $type, $pageSize, $page, $order);
    }

    public static function getLeftJoinByCondition($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $model = self::getModelInstance();
        return $model->getLeftJoinByCondition($condition, $type, $pageSize, $page, $order);
    }

    /**
     * @param $val
     * @return array
     */
    public static function validator($val)
    {
        $validateArr = $error = array();

        $validateArr[] = array("name" => EC::Lang('userCode'), "value" => $val["user_code"], "regex" => array("require",));
        $validateArr[] = array("name" => EC::Lang('userName'), "value" => $val["user_name"], "regex" => array("require",));
        $validateArr[] = array("name" => EC::Lang('userNameEn'), "value" => $val["user_name_en"], "regex" => array("require",));
        $validateArr[] = array("name" => EC::Lang('departmentName'), "value" => $val["ud_id"], "regex" => array("require",));
        $validateArr[] = array("name" => EC::Lang('positionName'), "value" => $val["up_id"], "regex" => array("require",));
        return Common_Validator::formValidator($validateArr);
    }


    /**
     * @param array $params
     * @return array
     */
    public function getFields()
    {
        $row = array(
            'E0' => 'user_id',
            'E1' => 'user_code',
            'E2' => 'user_password',
            'E3' => 'user_name',
            'E4' => 'user_name_en',
            'E5' => 'user_status',
            'E6' => 'user_email',
            'E7' => 'ud_id',
            'E8' => 'up_id',
            'E9' => 'user_password_update_time',
            'E10' => 'user_phone',
            'E11' => 'user_mobile_phone',
            'E12' => 'user_note',
            'E13' => 'user_supervisor_id',
            'E14' => 'user_add_time',
            'E15' => 'user_last_login',
            'E16' => 'user_update_time',
            'E17' => 'user_compnay',
            'E18' => 'user_unique_code',
            'E19' => 'user_last_login_ip'
        );
        return $row;
    }

    /**
     * @登录
     * @param array $params
     * @return array
     */
    public static function login($params = array())
    {   
        $result = array('state' => 0, 'message' => '', 'priority_login' => '/');
        $userName = isset($params['userName']) ? $params['userName'] : '';
        $userPass = isset($params['userPass']) ? $params['userPass'] : '';

        if (empty($userName) || empty($userPass) || strlen($userName) > 64) {
            $result['message'] = Ec::Lang('用户名/密码错误');
            return $result;
        }
        $model = self::getModelInstance();
        $userArr = $model->getByField($userName, 'user_code');

        if (empty($userArr)) {
            $result['message'] = Ec::Lang('用户名不存在');
            return $result;
        }
        if (!Ec_Password::comparePassword($userPass, $userArr['user_password'])) {
            $result['message'] = Ec::Lang('用户名/密码错误');
            return $result;
        }

        $result['user_id'] = $userArr['user_id'];
        $session = new Zend_Session_Namespace('userAuthorization');
        $session->unsetAll();
        $date = date('Y-m-d H:i:s');

        if ($userArr['user_status'] != 1) {
            $result['message'] = Ec::Lang('用户未激活');
            Service_UserLoginLog::add(array('user_id' => $userArr['user_id'], 'ull_status' => '0', 'ull_note' => 'Account is not activated'));
            $result['state'] = 2;
            return $result;
        }

        //成功登录,记录登录数据
        $sessionId = Zend_Session::getId();
        $loginArr = array(
            'user_id' => $userArr['user_id'],
            'ull_ip' => Common_Common::getIP(),
            'ull_session' => $sessionId,
            'ull_add_time' => $date,
        );
        Service_UserLoginLog::add($loginArr);
        $session->user = $userArr;
        $session->userId = $userArr['user_id'];
        $session->userCode = $userArr['user_code'];
        $session->userName = $userArr['user_name'];
        $session->isLogin = true;
        $session->message = '';
        //更新用户中心登录时间
        Service_User::update(array('user_last_login' => date('Y-m-d H:i:s')), $userArr['user_id']);
        $model->update(array('user_last_login' => date('Y-m-d H:i:s')), $userArr['user_id']);

        $result['state'] = 1;
        $result['message'] = '登录成功..';
        return $result;
    }

    /**
     * @退出
     * @param array $params
     * @return array
     */
    public static function logout() {
        $session = new Zend_Session_Namespace('userAuthorization');
        $session->unsetAll();
        session_destroy();
        return true;
    }

    public static function getUserId()
    {
        $userAuth = new Zend_Session_Namespace('userAuthorization');
        return isset($userAuth->userId) ? $userAuth->userId : 0;
    }

    public static function getLoginUser()
    {
        $userAuth = new Zend_Session_Namespace('userAuthorization');
        return isset($userAuth->user) ? $userAuth->user : array();
    }

    /**
     * @desc 获取身份验证信息
     * @return array
     */
    public static function getValidateInfo($condition = array(), $type) {
        $join = array(array('user_to_erp', 'user_to_erp.user_id = user.user_id', array('ute_token as EF1', 'ute_token_expire_time as EF2')));
        $info = self::getModelInstance()->getByLeftJoin($condition, $type, 0, 0, '', $join);
        if (!empty($info)) {
            $info = current($info);
        }
        return $info;
    } 

    /**
     * @desc 获取当前用户全局变量
     * @return array
     */
    public static function getLoginUserGlobalVariable()
    {
        $userAuth = new Zend_Session_Namespace('userAuthorization');
        return isset($userAuth->Acl['globalVariable']) ? $userAuth->Acl['globalVariable'] : array();
    }

    /**
     * @desc 用户
     * @return array
     */
    public function getUserArr()
    {
    	$userArr = array();

    	$userRows = self::getAll();
    	if (!empty($userRows)) {
    		foreach ($userRows as $userRow) {
    			$userArr[$userRow['user_id']] = $userRow['user_name'];
    		}
    	}

    	return $userArr;
    }


    /**
     * @desc 强制下线指定SessionId
     * @param string $id
     */
    public static function unsetSessionId($id='')
    {
        $sessionFile = APPLICATION_PATH . '/../data/session/sess_'.$id;
        if(is_file($sessionFile)){
            @unlink($sessionFile);
        }
    }
}