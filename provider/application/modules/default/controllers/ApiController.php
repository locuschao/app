<?php

class Default_ApiController extends Zend_Controller_Action
{
    public function init()
    {
        error_reporting(0);
    }

    public function indexAction()
    {
        $this->_forward('svc');
    }

    public function svcAction()
    {

        $return = array(
            'code' => '500',
            'message' => '数据格式不正确'
        );
        try {
            $json = file_get_contents('php://input');
            if (empty ($json)) {
                throw new Exception ('无请求数据');
            }
            // 请求格式为json
            $req = json_decode($json, true);
            if (!$req) {
                throw new Exception ('数据格式需为json格式');
            }
            $svc = new Common_Svc();
            $return = $svc->callService($req);
        } catch (Exception $e) {
            $return['message'] = $e->getMessage();
        }
        echo json_encode($return);
    }
}