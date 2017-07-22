<?php
class Service_UserToErp extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_UserToErp|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_UserToErp();
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
    public static function update($row, $value, $field = "ute_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "ute_id")
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
    public static function getByField($value, $field = 'ute_id', $colums = "*")
    {
        $model = self::getModelInstance();
        return $model->getByField($value, $field, $colums);
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
     * @return mixed
     */
    public static function getUteIdByName($condition=array()){
        $model = self::getModelInstance();
        return $model->getUteIdByName($condition);
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
     * @param $val
     * @return array
     */
    public static function validator($val)
    {
        $validateArr = $error = array();
        
        return  Common_Validator::formValidator($validateArr);
    }


    /**
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(
        
              'E0'=>'ute_id',
              'E1'=>'user_id',
              'E2'=>'ute_erp_no',
              'E3'=>'ute_erp_name',
              'E4'=>'ute_token',
              'E5'=>'ute_status',
              'E6'=>'ute_token_expire_time',
              'E7'=>'ute_create_time',
              'E8'=>'ute_update_time',
        );
        return $row;
    }

    /**
     * @desc 获取用户与erp的关联的公司名
     * @param array $userId
     * @return array
     */

    public static function getUserAndErpRelation($userId=array()){
        //查询出当前用户与erp关联的信息
        $userToErpMessages = Service_UserToErp::getByCondition($userId);
        return $userToErpMessages;

    }

    /**
     * @desc 绑定新token
     * @param string $userCode 用户登录码
     * @param string $password 用户密码
     * @param string $token 秘钥
     * @return array
     */
    public static function boundNewToken($userCode, $password, $token) {
        $result = array(
            "state" => 0,
            "message" => '',
            "errorMessage" => array("操作失败！")
        );
        $userInfo = Service_User::getByField($userCode, 'user_code');
        if (empty($userInfo)) {
            $result['errorMessage'] = array(Ec::Lang('用户名不存在'));
            return $result;
        }
        if (!Ec_Password::comparePassword($password, $userInfo['user_password'])) {
            $result['errorMessage'] = array(Ec::Lang('用户名/密码错误'));
            return $result;
        }
        $model = self::getModelInstance();
        $userId = Service_User::getUserId();
        $uteExist = $model->getByCondition(array('user_id' => $userId, 'ute_token' => $token), array('ute_id'), 1, 1);
        // 当前用户已绑定过该token
        if ($uteExist) {
            $result['errorMessage'] = array(Ec::Lang('请勿重复绑定相同的账号！'));
            return $result;
        }
        // 复制ute信息
        $uteInfo = $model->getByCondition(
            array('user_id' => $userInfo['user_id'], 'ute_token' => $token), 
            array('ute_id', 'ute_erp_no', 'ute_erp_name', 'ute_status', 'ute_token_expire_time'), 1, 1);
        if (empty($uteInfo)) {
            $result['errorMessage'] = array(Ec::Lang('token错误！'));
            return $result;
        }
        $uteInfo = current($uteInfo);
        $date = date('Y-m-d H:i:s');
        $uteInfo['user_id'] = $userId;
        $uteInfo['ute_create_time'] = $date;
        $uteInfo['ute_update_time'] = $date;
        // 绑定新ERP
        $uteId = $model->add($uteInfo);
        if (empty($uteId)) {
            $result['errorMessage'] = array(Ec::Lang('网络错误，请重试！'));
            return $result;
        }
        $result['state'] = 1;
        $result['message'] = Ec::Lang('绑定成功！');
        $result['errorMessage'] = '';
        return $result;
    }

    /**
     * @desc 解绑token
     * @param string $provider 供应商码
     * @param string $erpCode erp码
     * @param string $token 秘钥
     * @return array
     */
    public static function unBindErp($provider, $erpCode, $token) {
         $result = array(
            "code" => 200,
            "message" => '删除成功！',
            "data" => array()
        );
        try {
            $user = Service_User::getByField($provider, 'user_unique_code', 'user_id');
            if (empty($user)) {
                throw new Exception(Ec::Lang('供应商不存在！', 'Provider'), '50009');
            }
            // 供应商与ERP对应关系
            $relation = Service_UserToErp::getByCondition(array(
                'user_id' => $user['user_id'], 'ute_erp_no' => $erpCode
                ), array('ute_id', 'ute_token'), 1, 1);

            if (empty($relation)) {
                throw new Exception(Ec::Lang('绑定关系不存在！', 'ErpCode'), '50010');
            }
            $relation = current($relation);
            if (strcmp($relation['ute_token'], $token) != 0) {
                throw new Exception(Ec::Lang('错误的token！', 'token'), '50011');
            }
            $model = self::getModelInstance();
            $affectRow = $model->update(
                array('ute_status' => 0, 'ute_update_time' => date('Y-m-d H:i:s')), 
                $relation['ute_id'], 'ute_id'
            );
            if (empty($affectRow)) {
                throw new Exception(Ec::Lang('删除失败！', ''), '600');
            }
        } catch (Exception $e) {
             $result = array(
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            );
        }
        return $result;
    }

    /**
     * @desc 获取uteId的初始erp信息
     * @param array $condition 条件数组
     * @param array $columns 需要获取的字段
     * @return array
     */
    public static function getUteInfo($condition, $columns) {
        $model = self::getModelInstance();
        return $model->getUteInfo($condition, $columns);
    }
}