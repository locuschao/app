<?php

class Msg_NoticeBussinessController extends Ec_Controller_Action
{
    private $_noticeTypeService;
    private $_noticeApplicationService;
    private $_noticeApplicationRuleService;
    private $_noticeBussinessListService;
    private $_noticeBussinessListUserService;
    private $_noticeUserService;
    private $_noticeUserGroup;

    public function preDispatch()
    {
        $this->tplDirectory = "msg/views/";
        $this->serviceClass = new Service_NoticeBussiness();

        $this->_noticeTypeService = new Service_NoticeType();
        $this->_noticeApplicationService = new Service_NoticeApplication();
        $this->_noticeApplicationRuleService = new Service_NoticeApplicationRule();
        $this->_noticeBussinessListService = new Service_NoticeBussinessList();
        $this->_noticeBussinessListUserService = new Service_NoticeBussinessListUser();
        $this->_noticeUserService = new Service_NoticeUser();
        $this->_noticeUserGroup = new Service_NoticeUserGroup();
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

            if (isset($params['E1'])){
                $tmpE1Str = '';
                foreach ($params['E1'] as $e1Key=>$e1){
                    $params['E1'][$e1Key] = '\'' . $e1 . '\'';
                }
                $params['E1'] = implode(',', $params['E1']);
            }

            $condition = $this->serviceClass->getMatchFields($params);

            $count = $this->serviceClass->getSubqueryByCondition($condition, 'count(*) as count');
            $count = !empty($count) ? $count[0]['count'] : 0;

            $return['total'] = $count;

            if ($count) {
                $showFields = array(

                    'nb_id',
                    'na_code',
                    'nb_status',
                    'nb_is_system',
                    'nb_name',
                    'nb_code_prefix',
                    'nb_create_time',
                    'nb_modify_time',

                    //外键
                    'na_name',
                    'nb_create_username',
                    'nb_modify_username'

                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getSubqueryByCondition($condition, $showFields, $pageSize, $page, array('nb_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }

        $noticeType = $this->_noticeTypeService->getAll();
        $this->view->noticeType = $noticeType;
        $noticeApplication = $this->_noticeApplicationService->getAll();
        $this->view->noticeApplication = $noticeApplication;

        //以noticeType分类
        $noticeApplicationJson = array();
        if (!empty($noticeApplication) && !empty($noticeType)){
            $noticeTypeArr = array();
            foreach ($noticeType as $ntInfo){
                $noticeTypeArr[$ntInfo['nt_code']] = $ntInfo['nt_name'];
            }

            $noticeApplicationArr = array();
            foreach ($noticeApplication as $naInfo){
                $naInfo['nt_name'] = isset($noticeTypeArr[$naInfo['nt_code']]) ? $noticeTypeArr[$naInfo['nt_code']] : '';
                $noticeApplicationArr[$naInfo['nt_code']][] = $naInfo;
            }

            if (!empty($noticeApplicationArr)){
                foreach ($noticeApplicationArr as $naa){
                    $noticeApplicationJson = array_merge($noticeApplicationJson, $naa);
                }
            }
        }
        $this->view->noticeApplicationJson = json_encode($noticeApplicationJson);

        echo Ec::renderTpl($this->tplDirectory . "notice_bussiness_index.tpl", 'layout');
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

            //获取相关的用户对应信息
            $selectRuleUsers = $params['selectRuleUser'];
            unset($params['selectRuleUser']);

            $selectRuleCcUsers = $params['selectRuleCcUser'];
            unset($params['selectRuleCcUser']);

            $row = array(
                'nb_id' => '',
                'na_code' => '',
                'nb_status' => '',
                'nb_code_prefix' => '',
                'nb_name' => '',
                'nb_content' => ''
            );
            $row = $this->serviceClass->getMatchEditFields($params, $row);
            $paramId = $row['nb_id'];
            if (!empty($row['nb_id'])) {
                unset($row['nb_id']);
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
                $result = $this->serviceClass->updateBussinessTransaction($paramId, $row, $selectRuleUsers, $selectRuleCcUsers);
            } else {
                unset($row['nb_id']);
                $result = $this->serviceClass->addBussinessTransaction($row, $selectRuleUsers, $selectRuleCcUsers);
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
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'nb_id')) {

            $rows['bussiness_rule'] = Process_NoticeBussinessProcess::processBussinessRule($rows);

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
                if (is_array($paramId)){
                    //批量删除
                    if ($this->serviceClass->deleteArr($paramId)) {
                        $result['state'] = 1;
                        $result['message'] = 'Success.';
                    }
                }else{
                    if ($this->serviceClass->delete($paramId)) {
                        $result['state'] = 1;
                        $result['message'] = 'Success.';
                    }
                }
            }
        }
        die(Zend_Json::encode($result));
    }

    public function getrulesAction()
    {
        $result = array(
            "state" => 0,
            "message" => "Fail."
        );
        if ($this->_request->isPost()) {
            $paramId = $this->_request->getPost('paramId');
            if (!empty($paramId)) {
                $showFields = $this->_noticeApplicationRuleService->getFieldsAlias(array(
                    'nar_id',
                    'nar_code',
                    'nar_name',
                    'nar_level'
                ));

                $ruleInfo = Service_NoticeApplicationRule::getByCondition(array('na_code' => $paramId), $showFields, 0, 1, array('nar_level DESC'));

                if (!empty($ruleInfo)) {
                    $result['state'] = 1;
                    $result['message'] = 'Success.';
                    $result['data'] = $ruleInfo;
                }
            }
        }
        die(Zend_Json::encode($result));
    }

    /**
     * @desc 获取用户自定义的通知业务
     * @auth Zijie Yuan
     * @date 2016-11-10 13:56
     * @return mixed
     */
    public function getUserBusinessAction() {
        $result = array(
            "state" => 0,
            "message" => "Fail."
        );

        if ($this->_request->isPost()) {
            $searchKey = $this->_request->getPost('searchKey', '');
            $userId = Process_DataProcess::getLoginedUser();
            // 查询条件
            $condition = array(
                'nb_create_id' => $userId['user_id'],
                'nb_name' => $searchKey,
                'nb_is_system' => 0,
                'nb_status' => 1
            );

            $showFields = $this->serviceClass->getFieldsAlias(array(
                'nb_id',
                'nb_name',
                'nb_content'
            ));

            $result = $this->serviceClass->getUserBusiness($condition, $showFields, 0, 0, array('notice_application_rule.nar_level DESC'));
        }
        die(Zend_Json::encode($result));
    }
}