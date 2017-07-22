<?php
include_once 'function_ftp.php';

class Default_IndexController extends Ec_Controller_DefaultAction
{
    public $_loginSuccessUrl = '/default/index/index';		
    public $_authCode = 0; 				//是否用验证码

    
    public function preDispatch()
    {
        if(!isset($_COOKIE['currentPage']) || empty($_COOKIE['currentPage'])){
            setcookie('currentPage', '0{|}/system/home{|}首页',null, '/');
        }
        
        $this->view->logo_set = Common_Company::getLoginSet('LOGIN_SET_LOGO');				//LOGO配置（1#customer_logo.png）
        $this->view->login_writing = Common_Company::getLoginSet('LOGIN_SET_WRITING_NONE');	//登陆页面文字显示（1#customer_name）
        $this->view->login_banner = Zend_Json::encode(Common_Company::getLoginSet('LOGIN_SET_BANNER'));		//登陆banner配置（1#customer_banner.png#ffffff）
                
        $this->logintpl = Common_Company::getCompanylogintpl();
        $this->view->authCode = $this->_authCode;
      //  $this->view->company = Zend_Registry::get('company');
        $this->view->errMsg = '';
        $this->tplDirectory = "default/views/default/";
    }
	
    public function indexAction()
    {
        $userAuth = new Zend_Session_Namespace('userAuthorization');
        if ($userAuth->userId && $userAuth->isLogin) {
            echo Ec::renderTpl($this->tplDirectory . "index.tpl", "system-layout");
            exit();
        }
        $this->view->errMsg = '';
        echo $this->view->render($this->tplDirectory .$this->logintpl);
    }

    public function loginAction()
    {
        $errMsg = '';
        $result['priority_login'] = $this->_loginSuccessUrl;
        $result['state'] = 0;
        $result['message'] = "登录失败";
        if ($this->_request->isPost()) {
            setcookie('currentPage', '', -1, '/');
            $params = array(
                'userName' => trim($this->_request->getParam('userName', '')),
                'userPass' => trim($this->_request->getParam('userPass', ''))
            );
            $result = Service_User::login($params);
            die(Zend_Json::encode($result));
        }
        $this->view->errMsg = $errMsg;
        echo $this->view->render($this->tplDirectory .$this->logintpl);
    }

    public function logoutAction()
    {
        setcookie('currentPage', '', -1, '/');
        Service_User::logout();
        $errMsg = '';
        $this->view->errMsg = $errMsg;
        $this->view->logout = '1';
        echo $this->view->render($this->tplDirectory .$this->logintpl);
    }


    public function barcodeAction()
    {
        Common_Barcode::barcode($this->_request->code);
        exit;
    }

    public function barcode1Action()
    {
        Common_Barcode::barcode1($this->_request->code);
        exit;
    }
    

    
    public function verifyCodeAction()
    {
        $verifyCode = new Common_Verifycode();
        $verifyCode->set_sess_name('AdminVerifyCode');
        echo $verifyCode->render();
    }



}