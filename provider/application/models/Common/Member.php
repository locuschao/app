<?php

class Common_Member
{

    /**
     * @desc 会员注册
     * @param array $arr
     * @return mixed
     */
    public function register($arr = array(), $erpCode = '', $erpName = '', $token = '', $erpUrl = '')
    {
        $db = Common_Common::getAdapter();
        $db->beginTransaction();
        try {
            // 用户是否存在
            $user = Service_User::getByField($arr['user_code'], 'user_code', array('user_id', 'user_code', 'user_email', 'user_unique_code'));

            if (!empty($user)) {
                throw new Exception(Ec::lang('UserCode is already in use'));
            }

            //密码加密
            $arr['user_password'] = Ec_Password::getHash($arr['user_password']);
            // 生成用户唯一码
            $arr['user_unique_code'] = Process_MemberProcess::getUserUniqueCode();

            // 新用户注册
            $date = date('Y-m-d H:i:s');
            $arr['user_add_time'] = $date;
            $arr['user_update_time'] = $date;
            $arr['user_password_update_time'] = $date;
            $arr['user_last_login'] = $date;

            $userId = Service_User::add($arr);
            // 注册失败
            if (empty($userId)) {
                throw new Exception(Ec::lang('Account registration fail'));
            }

            $uteId = Service_UserToErp::add(array(
                'ute_id' => $userId,
                'user_id' => $userId,
                'ute_erp_no' => $erpCode,
                'ute_erp_name' => $erpName,
                'ute_erp_url' => $erpUrl,
                'ute_token' => $token,
                'ute_status' => 1,
                'ute_create_time' => $date,
                'ute_update_time' => $date
            ));
            if (empty($uteId)) {
                throw new Exception(Ec::lang('Account registration fail'));
            }
            $user = Service_User::getByField($userId, 'user_id', array('user_unique_code'));

            //验证邮箱
            //$this->sendEmail($arr);
            $db->commit();
            $return['code'] = 200;
            $return['message'] = Ec::lang('Account registration success');
            $return['data'] = array('ProviderCode' => $user['user_unique_code']);

            /*else if ($codeExist && $emailExist) {
                // 已有用户
                $erpArray = Service_UserToErp::getByCondition(array('user_id' => $user['user_id']), array('ute_id', 'ute_erp_no', 'ute_status'));
                $erpArray = Common_Common::arrayWithKey($erpArray, 'ute_erp_no');

                if(!$erpArray || !array_key_exists($erpCode, $erpArray)) {
                    // 绑定新ERP
                    $date = date('Y-m-d H:i:s');
                    $uteId = Service_UserToErp::add(array(
                        'user_id' => $user['user_id'],
                        'ute_erp_no' => $erpCode,
                        'ute_status' => 1,
                        'ute_create_time' => $date,
                        'ute_update_time' => $date
                    ));
                    if (empty($uteId)) {
                        throw new Exception(Ec::lang('Account registration fail'));
                    }
                }else {
                    if ($erpArray[$erpCode]['ute_status'] == 1) {
                        throw new Exception(Ec::lang('Account has bound to you'));
                    }
                    // 已禁用的供应商，重新开启
                    Service_UserToErp::update(array('ute_status' => 1, 'ute_update_time' => date('Y-m-d H:i:s')), 
                        $erpArray[$erpCode]['ute_id'], 
                        'ute_id'
                    );
                    throw new Exception(Ec::lang('Account has been banned, please contact to admin'));
                }
                $db->commit();
                $return['code'] = 200;
                $return['message'] = Ec::lang('Account registration success');
                $return['data'] = array('ProviderCode' => $user['user_unique_code']);
            }*/

            //邮箱验证的验证码
            //$activate_code = rand(6, 89898787);
            //$arr['cu_activate_code'] = $activate_code;
        } catch (Exception $e) {
            $db->rollBack();
            $return['ask'] = 100;
            $return['message'] = $e->getMessage();
            $return['data'] = array();
        }
        return $return;
    }

    /**
     * @desc 通知验证邮箱
     * @param $row
     * @return bool
     */
    public function sendEmail($row)
    {
        /*
         * 1、发送通知邮件给维护人员
        */
        $content = Ec::lang('customer_registration').'：<br>'
            . Ec::lang('login_name').'：' . $row['cu_code'] . '<br>'
            . Ec::lang('email').'：' . $row['cu_email'] . '<br>'
            . Ec::lang('mobilePhone').'：' . $row['cu_mobile_phone'] . '<br>'
            . Ec::lang('phone').'：' . $row['cu_phone'];

        $config = Zend_Registry::get('config');
        $notice = $config->mails->config->register->notice;
        $paramsPersonnel = array(
            'bodyType' => 'html',
            'email' => array($notice),
            'subject' => 'M2C '.Ec::lang('registered_customers').': ' . $row['cu_code'] . ' [' . $row['cu_name'] . ']',
            'body' => $content
        );
        $request = new Zend_Controller_Request_Http();
        $url = $request->getHttpHost();
        //$url = $this->getRequest()->getHttpHost();
        $url = 'http://' . $url;
        $companyRow = Common_Company::getCompany();
        $companyName = isset($companyRow['name']) ? $companyRow['name'] : 'M2C';
        $content_customer = Ec::lang('dear_customer')."：" . $row['cu_name'] . " ".Ec::lang('hello')."<br>"
            . Ec::lang('congratulations_on_your_successful_registration')."" . $companyName . "，".Ec::lang('please_keep_in_mind_your_login_name')."：" . $row['cu_code'] . "<br>"
            . Ec::lang('to_verify_your_email_address')."：<br>"
            . $url . '/default/register/activate-email?user_code=' . $row['cu_code'] . '&activate=' . $row['cu_activate_code']
            . "<br><br>".Ec::lang('not_open_the_link');

        /*
         * 2、发送确认邮件给客户
        */

        $paramsCustomer = array(
            'bodyType' => 'html',
            'email' => array($row['cu_email']),
            'subject' => Ec::lang('registration_success') . date('Y-m-d H:i:s'),
            'body' => $content_customer
        );

        $bol = Common_Email::sendMail($paramsCustomer);

        /*
         * 3、发送通知邮件给客服
         */
        if (!empty($notice)) {
            Common_Email::sendMail($paramsPersonnel);
        }
        return $bol;
    }

    public static function getLoginUser()
    {
        $userAuth = new Zend_Session_Namespace('memberAuth');
        return isset($userAuth->client) ? $userAuth->client : array();
    }


    public static function getClientId()
    {
        $userAuth = new Zend_Session_Namespace('memberAuth');
        return isset($userAuth->cu_id) ? $userAuth->cu_id : '0';
    }

    public static function getClientCompanyCode($userId = 0)
    {
        $companyCode = '';
        if (!$userId) {
            $memberAuth = self::getLoginUser();
            $companyCode = isset($memberAuth['cc_code']) ? $memberAuth['cc_code'] : '';
        } else {
            $user = Service_ClientUser::getByField($userId, 'cu_id');
            if ($user && $user['cc_code']) {
                $companyCode = $user['cc_code'];
            }
        }
        return $companyCode;
    }


    //设置API的密匙
    public static function genApiToken($companyCode)
    {
        $token = md5(md5(strrev(md5($companyCode))));
        $key = md5(md5(md5(strrev(md5($companyCode . time())))));
        $company['app_token'] = $token;
        $company['app_key'] = $key;
        return $company;
    }


}