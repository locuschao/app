<?php

class Msg_UserMessageController extends Ec_Controller_Action
{
    private $_messageUnReadTotal = 0;
    private $serviceClass;
    private $_noticeType;

    public function preDispatch()
    {
        $this->tplDirectory = "msg/views/";
        $this->serviceClass = new Service_UserMessage();
        $this->_noticeType = new Service_NoticeType();

        $userInfo = Process_DataProcess::getLoginedUser();
        $this->_messageUnReadTotal = $this->serviceClass->getByCondition(array('um_is_read' => '0', 'um_receive_user_id'=>$userInfo['user_id']), 'count(*)');
    }

    public function listAction()
    {   
        $selectedTypeCode = '';

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

            //自定义模糊筛选条件
            $searchName = $params['search_name'];
            $searchKey = $params['search_key'];

            if ($searchKey && in_array($searchName, array('E5', 'EF5', 'EF2', 'EF8'))){
                $params[$searchName] = $searchKey;
            }

            //通知类型筛选
            $userInfo = Process_DataProcess::getLoginedUser();

            if ($userInfo['user_id']){
                $params['E7'] = $userInfo['user_id'];
                $condition = $this->serviceClass->getMatchFields($params);

                $count = $this->serviceClass->getSubqueryByCondition($condition, 'count(*)');
                $return['total'] = $count;

                if ($count) {
                    $showFields = array(
                        'um_subject',
                        'um_type',
                        'um_send_user_id',
                        'um_receive_user_id',
                        'um_is_read',
                        'um_folder_starred',
                        'um_create_time',
                        'um_modify_time',
                        'um_id',
                    );
                    $showFields = $this->serviceClass->getFieldsAlias($showFields);
                    $rows = $this->serviceClass->getSubqueryByCondition($condition, $showFields, $pageSize, $page, array('um_id desc'));
                    // 是否推送
                    $pushConfig = Process_NoticeMessagePushProcess::getPushStatus($userInfo['user_id'], 
                        array('msg' => 'msg_status', 'warn' => 'warn_status', 'process' => 'process_status'));
                    $return['data'] = $rows;
                    $return['config'] = $pushConfig;
                    $return['state'] = 1;
                    $return['message'] = "";
                }
            }

            die(Zend_Json::encode($return));
        }else{
            $idArr = $this->_request->getParam('ids', 0);
            if ($idArr){
                $this->view->idArr = $idArr;
            }
        }

        // 消息总数
        $userId = Process_DataProcess::getLoginedUser();
        $userId = $userId['user_id'];
        $count = $this->serviceClass->getByCondition(array('um_receive_user_id' => $userId), 'count(*)');

        $noticeTypes = $this->_noticeType->getAll();
        if (!empty($noticeTypes)){
            array_unshift($noticeTypes, array(
                'nt_id'=>0,
                'nt_code'=>'',
                'nt_name'=>'全部'
            ));
        }else{
            $noticeTypes = array(array(
                'nt_id'=>0,
                'nt_code'=>'',
                'nt_name'=>'全部'
            ));
        }

        //获取所有的通知类型
        $this->view->noticeTypes = $noticeTypes;
        //获取消息读取状态
        $this->view->messageReadStatus = Common_Status::messageReadStatus();
        // 消息搜索条件
        $this->view->messageSearch = Common_Status::messageSearch();
        //获取所有的操作类型
        $this->view->selectedTypeCode = $selectedTypeCode;
        //未读信息数
        $this->view->messageUnReadTotal = $this->_messageUnReadTotal;
        //信息总数
        $this->view->messageTotal = $count;

        echo Ec::renderTpl($this->tplDirectory . "user_message_index.tpl", 'message-layout');
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

                'um_id' => '',
                'um_type' => '',
                'um_send_user_id' => '',
                'um__receive_user_id' => '',
                'um_is_read' => '',
                'um_create_time' => '',
                'um_modify_time' => '',
            );
            $row = $this->serviceClass->getMatchEditFields($params, $row);
            $paramId = $row['um_id'];
            if (!empty($row['um_id'])) {
                unset($row['um_id']);
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
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'um_id')) {
            $rows = $this->serviceClass->getVirtualFields($rows);
            $result = array('state' => 1, 'message' => '', 'data' => $rows);
        }
        die(Zend_Json::encode($result));
    }

    /**
     * @desc 通过ajax获取消息
     * @author zhengyu
     * @date 2016-12-16 14:08:53
     */
    public function getPushMessageAction()
    {
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array());

        $userInfo = Process_DataProcess::getLoginedUser();

        if (isset($userInfo['user_id']) && !empty($userInfo['user_id'])){
            $userId = $userInfo['user_id'];

            $pushConfig = Process_NoticeMessagePushProcess::getPushStatus($userId);

            $noticeTypeName = array();
            if (!empty($pushConfig)){
                if (isset($pushConfig['msg_status']) && !empty($pushConfig['msg_status'])){
                    $noticeTypeName[] = 'MSG';
                }

                if (isset($pushConfig['warn_status']) && !empty($pushConfig['warn_status'])){
                    $noticeTypeName[] = 'WARN';
                }

                if (isset($pushConfig['process_status']) && !empty($pushConfig['process_status'])){
                    $noticeTypeName[] = 'PROCESS';
                }
            }

            if (!empty($noticeTypeName)){
                $messageInfo = Process_NoticeMessagePushProcess::getPushMessage($userId, $noticeTypeName);

                $result = array('state' => 1, 'message' => '', 'data' => $messageInfo);
            }
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
     * @desc 写信
     * @auth Zijie Yuan
     * @date 2016-11-07 17:56
     * @return mixed
     * @modify zhengyu 2016-11-16 16:28:50 添加转发功能
     */
    public function writeLetterAction()
    {
        $rewardId = $this->_request->getParam('reward', 0);
        if ($rewardId){
            //循环获取信息，栈顶为当前转发的信息
            $msgInfos = Process_UserMessageProcess::getRecurParentMsgInfo($rewardId);

            $msg = $msgInfos[count($msgInfos) - 1];

            $this->view->rewardId = $rewardId;
            $this->view->msg = $msg;
            $this->view->msgInfos = $msgInfos;
        }

        $this->view->messageTypeArr = Common_status::messageTypeStatus();
        //未读信息数
        $this->view->messageUnReadTotal = $this->_messageUnReadTotal;
        $this->view->reward = $rewardId;
        echo Ec::renderTpl($this->tplDirectory . "user_message_write.tpl", 'message-layout');
    }

    /**
     * @desc 发送消息
     * @auth Zijie Yuan
     * @date 2016-11-08 17:56
     * @return mixed
     * @modify zhengyu 2016-11-17 10:31:54 添加转发功能
     */
    public function sendMessageAction()
    {
        $result = array(
            "state" => 0,
            "message" => "Error"
        );

        $params = $this->_request->getParams();
        $fields = $this->serviceClass->getMatchFields($params);
        $content = isset($params['F1']) ? $params['F1'] : '';
        $sendTo = isset($params['F2']) ? $params['F2'] : array();
        $cc = isset($params['F3']) ? $params['F3'] : array();
        $parentId = isset($params['E1']) ? $params['E1'] : 0;

        if ($parentId){
            //转发
            $result = $this->serviceClass->rewardMessage($fields, $content, $sendTo, $cc, $parentId);
        }else{
            //发送消息
            $result = $this->serviceClass->sendMessage($fields, $content, $sendTo, $cc);
        }

        echo Zend_Json::encode($result);
        return;
    }

    /**
     * @desc 设置信息星标
     * @author zhengyu
     * @date 2016-11-15 11:05:19
     */
    public function setStartAction(){
        $result = array(
            "state" => 0,
            "message" => "Error"
        );

        if ($this->_request->isPost()) {
            $paramId = $this->_request->getPost('paramId');
            $isStart = $this->_request->getPost('start');

            if (!empty($paramId)) {
                if (is_array($paramId)){
                    $ret = $this->serviceClass->updates(array('um_folder_starred'=>$isStart), $paramId, 'um_id');
                }else{
                    $ret = $this->serviceClass->update(array('um_folder_starred'=>$isStart), $paramId, 'um_id');
                }

                if ($ret) {
                    $result['state'] = 1;
                    $result['message'] = 'Success.';
                }
            }
        }

        echo Zend_Json::encode($result);
        return;
    }

    /**
     * @desc 查看消息详情
     * @auth Zijie Yuan
     * @date 2016-11-15 16:09
     * @return mixed
     */
    public function messageDetailsAction() {
        $param = $this->_request->getParam('umid', 0);
        $fields = $this->serviceClass->getFieldsAlias(array('um_id', 'nbm_id', 'um_type', 'um_subject', 'um_folder_starred', 'um_create_time'));
        $this->serviceClass->updates(array('um_is_read' => 1), $param, 'um_id');
        $messages = $this->serviceClass->getMessageDetails($param, $fields);

        if (!empty($messages)) {
            $userId = Process_DataProcess::getLoginedUser();
            $field = $this->serviceClass->getFieldsAlias(array('um_id'));
            $messages['G1'] = $this->serviceClass->getPreMessageDetails(array('um_id <' => $messages['E0'], 'um_receive_user_id' => $userId['user_id']), $field, 1, array('um_id DESC'));
            $messages['G2'] = $this->serviceClass->getPreMessageDetails(array('um_id >' => $messages['E0'], 'um_receive_user_id' => $userId['user_id']), $field, 1, array('um_id DESC'));
        }

        $this->view->messages = $messages;
        //获取所有的通知类型
        $this->view->noticeTypes = Common_status::emailStatus();
        //未读信息数
        $this->view->messageUnReadTotal = $this->_messageUnReadTotal;
        echo Ec::renderTpl($this->tplDirectory . "user_message_detail.tpl", 'message-layout');
        return;
    }

    /**
     * @desc 标记信息已读
     * @author zhengyu
     * @date 2016-11-15 11:10:06
     */
    public function setReadAction(){
        $result = array(
            "state" => 0,
            "message" => "Error"
        );
        $ret = false;

        if ($this->_request->isPost()) {
            $paramId = $this->_request->getPost('paramId');
            $isRead = $this->_request->getPost('read');

            if (!empty($paramId)) {
                if (is_array($paramId)){
                    $ret = $this->serviceClass->updates(array('um_is_read'=>$isRead), $paramId, 'um_id');

                    if (!$ret){
                        $result['message'] = '该信息状态不用更改';
                    }
                }else{
                    if ($paramId == 'all'){
                        //全部已读
                        $userInfo = Process_DataProcess::getLoginedUser();

                        if ($userInfo['user_id']){
                            $ret = $this->serviceClass->update(array('um_is_read'=>$isRead), $userInfo['user_id'], 'um_receive_user_id');

                            if (!$ret){
                                $result['message'] = '该信息状态不用更改';
                            }
                        }
                    }else{
                        $ret = $this->serviceClass->update(array('um_is_read'=>$isRead), $paramId, 'um_id');
                    }
                }

                if ($ret) {
                    $result['state'] = 1;
                    $result['message'] = 'Success.';
                }
            }
        }

        echo Zend_Json::encode($result);
        return;
    }

    /**
     * @desc 获取未读信息数
     * @author zhengyu
     * @date 2016-11-15 14:17:10
     */
    public function getMsgUnreadAction()
    {
        $result = array(
            "state" => 0,
            "message" => "Error",
            "data" => 0
        );

        $userInfo = Process_DataProcess::getLoginedUser();
        if (isset($userInfo['user_id'])){
            $result['state'] = 1;
            $result['data'] = $this->serviceClass->getByCondition(array('um_is_read' => '0', 'um_receive_user_id'=>$userInfo['user_id']), 'count(*)');
        }

        echo Zend_Json::encode($result);
        return;

    }

    /**
     * @desc 星标件
     * @author zhengyu
     * @date 2016-11-15 16:26:17
     */
    public function startListAction()
    {
        $selectedTypeCode = '';

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

            //自定义模糊筛选条件
            $searchName = $params['search_name'];
            $searchKey = $params['search_key'];

            if ($searchKey && in_array($searchName, array('E5', 'EF5', 'EF6'))){
                $params[$searchName] = $searchKey;
            }

            //通知类型筛选
            $userInfo = Process_DataProcess::getLoginedUser();

            if ($userInfo['user_id']){
                //表示星标件
                $params['E9'] = '1';
                $params['E7'] = $userInfo['user_id'];
                $condition = $this->serviceClass->getMatchFields($params);

                $count = $this->serviceClass->getSubqueryByCondition($condition, 'count(*)');
                $return['total'] = $count;

                if ($count) {
                    $showFields = array(
                        'um_subject',
                        'um_type',
                        'um_send_user_id',
                        'um__receive_user_id',
                        'um_is_read',
                        'um_folder_starred',
                        'um_create_time',
                        'um_modify_time',
                        'um_id',
                    );
                    $showFields = $this->serviceClass->getFieldsAlias($showFields);
                    $rows = $this->serviceClass->getSubqueryByCondition($condition, $showFields, $pageSize, $page, array('um_id desc'));
                    $return['data'] = $rows;
                    $return['state'] = 1;
                    $return['message'] = "";
                }
            }

            die(Zend_Json::encode($return));
        }

        //未读信息数
        $this->view->messageUnReadTotal = $this->_messageUnReadTotal;

        $noticeTypes = $this->_noticeType->getAll();
        if (!empty($noticeTypes)){
            array_unshift($noticeTypes, array(
                'nt_id'=>0,
                'nt_code'=>'',
                'nt_name'=>'全部'
            ));
        }else{
            $noticeTypes = array(array(
                'nt_id'=>0,
                'nt_code'=>'',
                'nt_name'=>'全部'
            ));
        }

        //获取所有的通知类型
        $this->view->noticeTypes = $noticeTypes;
        $this->view->selectedTypeCode = $selectedTypeCode;

        echo Ec::renderTpl($this->tplDirectory . "user_message_start_list.tpl", 'message-layout');
    }

    /**
     * @desc 已发送
     * @author zhengyu
     * @date 2016-11-15 16:26:37
     */
    public function sendListAction()
    {
        $selectedTypeCode = '';

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

            //自定义模糊筛选条件
            $searchName = $params['search_name'];
            $searchKey = $params['search_key'];

            if ($searchKey && in_array($searchName, array('E5', 'EF5', 'EF6'))){
                $params[$searchName] = $searchKey;
            }

            //通知类型筛选
            $userInfo = Process_DataProcess::getLoginedUser();

            if ($userInfo['user_id']){
                $params['E6'] = $userInfo['user_id'];
                $condition = $this->serviceClass->getMatchFields($params);

                $count = $this->serviceClass->getSubqueryByCondition($condition, 'count(*)');
                $return['total'] = $count;

                if ($count) {
                    $showFields = array(
                        'um_subject',
                        'um_type',
                        'um_send_user_id',
                        'um__receive_user_id',
                        'um_is_read',
                        'um_folder_starred',
                        'um_create_time',
                        'um_modify_time',
                        'um_id',
                    );
                    $showFields = $this->serviceClass->getFieldsAlias($showFields);
                    $rows = $this->serviceClass->getSubqueryByCondition($condition, $showFields, $pageSize, $page, array('um_id desc'));
                    $return['data'] = $rows;
                    $return['state'] = 1;
                    $return['message'] = "";
                }
            }

            die(Zend_Json::encode($return));
        }

        //未读信息数
        $this->view->messageUnReadTotal = $this->_messageUnReadTotal;

        $noticeTypes = $this->_noticeType->getAll();
        if (!empty($noticeTypes)){
            array_unshift($noticeTypes, array(
                'nt_id'=>0,
                'nt_code'=>'',
                'nt_name'=>'全部'
            ));
        }else{
            $noticeTypes = array(array(
                'nt_id'=>0,
                'nt_code'=>'',
                'nt_name'=>'全部'
            ));
        }

        //获取所有的通知类型
        $this->view->noticeTypes = $noticeTypes;
        $this->view->selectedTypeCode = $selectedTypeCode;

        echo Ec::renderTpl($this->tplDirectory . "user_message_send_list.tpl", 'message-layout');
    }

    /**
     * @desc 消息设置指南
     * @author Zijie Yuan
     * @date 2016-12-15 16:26:37
     */
    public function guideAction() {
        echo Ec::renderTpl($this->tplDirectory . "user_message_guide.tpl", 'layout');
    }

    /**
     * @desc 消息设置
     * @author Zijie Yuan
     * @date 2016-12-16 16:26:37
     */
    public function setMessageAction() {
        $result = array('state' => 0, 'errorMessage' => array('保存失败，请重试！'));
        if ($this->_request->isPost()) {
            $params = $this->_request->getPost();
            if (!empty($params['inform-type']) && empty($params['msg']) 
                && empty($params['warn']) && empty($params['process'])) {
                $result['errorMessage'] = array('请至少选择一种通知类型！');
                echo Zend_Json::encode($result);
                return ;
            }
            $result = Process_NoticeMessagePushProcess::setMessage($params);
        }
        echo Zend_Json::encode($result);
        return ;
    }

    /**
     * @desc 更新推送消息状态
     * @author zhengyu
     * @date 2016-12-16 16:41:19
     */
    public function finshPushMessageAction()
    {
        $result = array(
            "state" => 0,
            "message" => "Error",
            "data" => 0
        );

        $userInfo = Process_DataProcess::getLoginedUser();

        if (isset($userInfo['user_id'])){
            $umId = $this->_request->getParam('umId');

           $ret = Process_NoticeMessagePushProcess::updatePush($umId, Process_NoticeMessagePushProcess::$PUSH_STATUS_ALREADY_PUSH);

           if ($ret){
               $result['state'] = 1;
               $result['message'] = 'Sucess';
           }
        }

        echo Zend_Json::encode($result);
        return;
    }
}