<?php
class Message_MessageController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "message/views/";
        $this->serviceClass = new Service_Message();
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
            $condition['message_status'] = isset($params['message_status']) ? $params['message_status'] : '';

            $count = $this->serviceClass->getByCondition($condition, 'count(*)');
            $return['total'] = $count;

            if ($count) {
                $showFields=array(
                'message_id',
                'ute_id',
                'message_type',
                'message_title',
                'message_status',
                'message_create_time',
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getByCondition($condition,$showFields, $pageSize, $page, array('message_id desc'));
               $datas = array();
                foreach($rows as $key => $val){
                    $message_id['message_id'] = $val['E0'];
                    $messageContent = Service_MessageContent::getByCondition($message_id);
                    $content['mc_content'] =  $messageContent[0]['mc_content'];
                    $datas[] = array_merge($val,$content);

                }
                $return['data'] = $datas;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }
        echo Ec::renderTpl($this->tplDirectory . "message_list_index.tpl", 'layout');
    }

    public function editAction()
    {
        $return = array(
            'state' => 0,
            'message' => '',
            'errorMessage'=>array('Fail.')
        );

        if ($this->_request->isPost()) {
            $params = $this->_request->getParams();
            $row = array(
                
              'message_id'=>'',
            );
            $row=$this->serviceClass->getMatchEditFields($params,$row);
            $paramId = $row['message_id'];
            if (!empty($row['message_id'])) {
                unset($row['message_id']);
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
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'message_id')) {
            $rows=$this->serviceClass->getVirtualFields($rows);
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
                if ($this->serviceClass->delete($paramId)) {
                    $result['state'] = 1;
                    $result['message'] = 'Success.';
                }
            }
        }
        die(Zend_Json::encode($result));
    }


    public function getMessageDetailAction(){
        $result = array(
            "state" => 0,
            "message" => "Fail."
        );
        $messageId = array();
        $message_id  = $this->_request->getParam("messageId",'');

        if(empty($message_id)){
            return $result['message'] = "no data" ;
        }
        $messageId['message_id']= $message_id;
        $messgae = Service_MessageContent::getByField($messageId);
        //获取消息内容
        $content  = $messgae['mc_content'];
        if(!empty($content)){
            $result['data'] =  $content;
            $result['message'] = 'Success.';
            $result['state'] = '1';
        }

        die(Zend_Json::encode($result));
    }



    public function  testAction(){
        $datas = array(
            array(
                'erp_no' => '123123',
                'data' =>'2017/1/06',
                'use_id'=>'12'

            ),
            array(
                'erp_no' => '123123',
                'data' =>'2017/1/06',
                'use_id'=>'12'
            ),
        );

        $data = new Common_Svc();

        $a = $data ->getMessages($datas);

    }
}