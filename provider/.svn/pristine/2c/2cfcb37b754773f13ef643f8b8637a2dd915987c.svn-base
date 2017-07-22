<?php
class Msg_NoticeApplicationController extends Ec_Controller_Action
{
    private $_noticeTypeService;

    public function preDispatch()
    {
        $this->tplDirectory = "msg/views/";
        $this->serviceClass = new Service_NoticeApplication();

        $this->_noticeTypeService = new Service_NoticeType();
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

            $count = $this->serviceClass->getSubqueryByCondition($condition,'count(*) as count');
            $count = !empty($count) ? $count[0]['count'] : 0;
            $return['total'] = $count;

            if ($count) {
                $showFields=array(
                    'notice_application.na_id',
                    'notice_application.na_code',
                    'notice_application.na_name',
                    'notice_application.na_status',
                    'notice_application.na_create_time',
                    'notice_application.na_modify_time',
                    'notice_application.na_is_system'
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getSubqueryByCondition($condition,$showFields, $pageSize, $page, array('notice_application.na_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }

        $noticeType = $this->_noticeTypeService->getAll();

        $this->view->noticeType = $noticeType;
        $this->view->noticeTypeJson = json_encode($noticeType);


        echo Ec::renderTpl($this->tplDirectory . "notice_application_index.tpl", 'layout');
    }

    //TODO refactor
    public function editAction()
    {
        $return = array(
            'state' => 0,
            'message' => '',
            'errorMessage'=>array('Fail.')
        );

        if ($this->_request->isPost()) {
            $params = $this->_request->getParams();

            //获取application_rule信息
            $ruleNameArr = $params['rulename'];
            $ruleIdArr = $params['nar_id'];
            $ruleData = array();

            $row = array(
                'notice_application.na_id'=>'',
                'notice_application.nt_code'=>'',
                'notice_application.na_code'=>'',
                'notice_application.na_name'=>'',
                'notice_application.na_status'=>''
            );
            $row=$this->serviceClass->getMatchEditFields($params,$row);

            $ruleArrLength = count($ruleNameArr);
            //整理rule信息
            for($ruleIndex = 0; $ruleIndex < count($ruleNameArr); $ruleIndex++){
                if ($ruleNameArr[$ruleIndex] != ''){
                    $tmpArr = array(
                        'nar_id'=>$ruleIdArr[$ruleIndex],
                        'na_code'=>$row['notice_application.na_code'],
                        'nar_name'=>$ruleNameArr[$ruleIndex],
                        'nar_level'=> $ruleArrLength--
                    );

                    $ruleData[] = $tmpArr;
                }
            }

            $paramId = $row['notice_application.na_id'];
            if (!empty($row['notice_application.na_id'])) {
                unset($row['notice_application.na_id']);
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
                if (isset($row['notice_application.na_code'])){
                    unset($row['notice_application.na_code']);
                }

                $result = $this->serviceClass->updateApplicationAndRuleTransaction($row, $paramId, $ruleData);
            } else {
                if (isset($row['notice_application.na_code'])){
                    $row['notice_application.na_code'] = strtoupper($row['notice_application.na_code']);
                }

                $result = $this->serviceClass->addApplicationAndRuleTransaction($row, $ruleData);
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
        if (!empty($paramId) && $rows = $this->serviceClass->getByFieldAndRule($paramId, 'notice_application.na_id')) {
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
                if (stripos($paramId, ',') !== false){
                    //批量删除
                    $this->serviceClass->deleteArr(explode(',', $paramId));

                    $result['state'] = 1;
                    $result['message'] = 'Success.';
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

    public function getlastcodeAction()
    {
        $result = array(
            "state" => 0,
            "message" => "Fail."
        );
        if ($this->_request->isPost()) {
            $code = $this->_request->getPost('code');
            $lastNum = 0;

            if (!empty($code)) {
                //查询出最后一条记录
                $ruleInfo = Service_NoticeApplicationRule::getByCondition(array('na_code'=>$code), 'nar_code', 1, 1, array('nar_id DESC'));


                if (!empty($ruleInfo)){
                    $lastCode = $ruleInfo[0]['nar_code'];
                    preg_match('/-([0-9]+)/', $lastCode, $matchArr);

                    if (count($matchArr) >= 2){
                        $lastNum = intval($matchArr[1]);
                    }
                }
            }

            $lastNum = sprintf("%03d", ++$lastNum);

            $result['data'] = $code.'-'.$lastNum;
            $result['state'] = 1;
            $result['message'] = "Success.";
        }
        die(Zend_Json::encode($result));
    }
}