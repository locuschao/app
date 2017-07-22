<?php

class Msg_NoticeUserGroupController extends Ec_Controller_Action
{
    private $_noticeUserService;

    public function preDispatch()
    {
        $this->tplDirectory = "msg/views/";
        $this->serviceClass = new Service_NoticeUserGroup();

        $this->_noticeUserService = new Service_NoticeUser();
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

            $count = $this->serviceClass->getByConditionX($condition, 'count(*)');
            $return['total'] = $count;

            if ($count) {
                $showFields = array(
                    'nug_status',
                    'nug_name',
                    'nug_user_num',
                    'nug_create_id',
                    'nug_modify_id',
                    'nug_create_time',
                    'nug_modify_time',
                    'nug_id'
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getGroupList($condition, $showFields, $pageSize, $page, array('notice_user_group.nug_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }

        $noticeUserGroupStatusArr = Common_Status::noticeUserGroupStatus();
        $noticeUserGroupDistributeStatusArr = Common_Status::noticeUserGroupDistributeStatus();
        $this->view->noticeUserGroupStatusArr = $noticeUserGroupStatusArr;
        $this->view->noticeUserGroupDistributeStatusArr = $noticeUserGroupDistributeStatusArr;

        echo Ec::renderTpl($this->tplDirectory . "notice_user_group_index.tpl", 'layout');
    }

    public function editAction()
    {
        $return = array(
            'state' => 0,
            'message' => '',
            'errorMessage' => array('Fail.')
        );

        if ($this->_request->isPost()) {
            $userId = Process_DataProcess::getLoginedUser();
            $userId = $userId['user_id'];
            $params = $this->_request->getParams();
            $row = array(
                'nug_id' => '',
                'nug_status' => '',
                'nug_name' => '',
            );
            $row = $this->serviceClass->getMatchEditFields($params, $row);
            $row['nug_modify_time'] = date('Y-m-d H:i:s');
            $row['nug_modify_id'] = $userId;
            $paramId = $row['nug_id'];
            if (!empty($row['nug_id'])) {
                unset($row['nug_id']);
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
                $row['nug_create_id'] = $userId;
                $row['nug_create_time'] = date('Y-m-d H:i:s');
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
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'nug_id')) {
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

    /**
     * @desc 获取所有的用户分组
     * @author zhengyu
     * @Date 2016-11-07 15:16:48
     */
    public function getUserGroupAction()
    {
        $result = array(
            "state" => 0,
            "message" => "Fail."
        );
        if ($this->_request->isPost()) {

            $groupData = array();

            $showUserFields = array(
                'user_id'
            );
            //获取全部的用户信息
            $userInfos = $this->_noticeUserService->getSubqueryByCondition(array(), $showUserFields, 0, 1, array('nu_id asc'), 'user_id');

            if (!empty($userInfos)) {
                $child = array();

                foreach ($userInfos as $u) {
                    $child[] = array(
                        'id' => $u['user_id'],
                        'name' => $u['EF1'],
                        'type' => 'user',
                        'search-key' => 'g_0_u_' . $u['user_id']
                    );
                }

                $groupData[] = array(
                    'id' => '0',
                    'name' => '全部',
                    'type' => 'group',
                    'search-key' => 'g_0_u_0',
                    'children' => $child
                );
            }

            //获取全部的分组
            $showGroupFields = array(
                'nug_status',
                'nug_name',
                'nug_use',
                'nug_user_num',
                'nug_create_id',
                'nug_modify_id',
                'nug_create_time',
                'nug_modify_time',
                'nug_id'
            );
            $showFields = $this->serviceClass->getFieldsAlias($showGroupFields);
            $groupInfos = $this->serviceClass->getGroupList(array(), $showFields, 0, 1, array('notice_user_group.nug_id desc'));

            if (!empty($groupInfos)) {
                foreach ($groupInfos as $group) {
                    if (!empty($group['F1'])) {
                        $children = array();

                        foreach ($group['F1'] as $uId => $uName) {
                            $children[] = array(
                                'id' => $uId,
                                'name' => $uName,
                                'type' => 'user',
                                'search-key' => 'g_' . $group['E0'] . '_u_' . $uId
                            );
                        }

                        $groupData[] = array(
                            'id' => $group['E0'],
                            'name' => $group['E2'],
                            'type' => 'group',
                            'search-key' => 'g_' . $group['E0'] . '_u_0',
                            'children' => $children
                        );
                    }
                }
            }

            $result['data'] = $groupData;
            $result['state'] = 1;
            $result['message'] = 'Success.';

        }
        die(Zend_Json::encode($result));
    }

    public function getSystemUserAction()
    {
        $result = array(
            "state" => 0,
            "message" => "Fail."
        );

        $userInfo = array();
        $users = Process_DataProcess::getUsersByStatus();

        if (!empty($users)){
            $userService = new Service_User();
            foreach ($users as $user){
                $userInfo[] = $userService->getVirtualFields($user);
            }

            $result['data'] = $userInfo;
            $result['state'] = 1;
            $result['message'] = 'Success.';
        }

        die(Zend_Json::encode($result));
    }

    /**
     * @desc 通过分组id获取用户信息
     * @author zhengyu
     * @Date 2016-11-10 16:53:21
     */
    public function getGroupUserAction()
    {
        $result = array(
            "state" => 0,
            "message" => "Fail."
        );
        if ($this->_request->isPost()) {
            $params = $this->_request->getParams();

            $gId = $params['paramId'];

            $showFields = array(
                'nu_id',
                'nug_id',
                'user_id',
                'nu_create_time',
                'nu_modify_time'
            );
            $showFields = $this->_noticeUserService->getFieldsAlias($showFields);

            $gUserInfo = $this->_noticeUserService->getSubqueryByCondition(array('nug_id' => $gId), $showFields);

            if (!empty($gUserInfo)) {
                $result['data']['gu'] = $gUserInfo;
                $result['state'] = 1;
                $result['message'] = 'Success.';
            }

            //获取系统数据
            $userInfo = array();
            $users = Process_DataProcess::getUsersByStatus();

            if (!empty($users)){
                $userService = new Service_User();
                foreach ($users as $user){
                    $userInfo[] = $userService->getVirtualFields($user);
                }

                $result['data']['su'] = $userInfo;
            }
        }

        die(Zend_Json::encode($result));
    }

    public function editGroupUserAction()
    {
        $result = array(
            "state" => 0,
            "message" => "Fail."
        );

        if ($this->_request->isPost()) {
            $params = $this->_request->getParams();

            $gId = $params['paramId'];

            $userIds = $params['userIds'];

            if ($this->serviceClass->updateGroupUser($gId, $userIds)){
                $result['state'] = 1;
                $result['message'] = 'Success.';
            }
        }

        die(Zend_Json::encode($result));
    }
}