<?php
class Common_SystemController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "common/views/";
        $this->serviceClass = new Service_System();
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

            $count = $this->serviceClass->getByCondition($condition, 'count(*)');
            $return['total'] = $count;

            if ($count) {
                $showFields=array(
                'system_id',
                'system_code',
                'system_title',
                'system_title_en',
                'system_url',
                'system_wsdl',
                'system_token',
                'system_key',
                'system_sort',
                'system_email',
                'system_language',
                'system_status',
                'system_note',
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                
                $rows = $this->serviceClass->getByCondition($condition,$showFields, $pageSize, $page, array('system_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }

        $outboundBatchStatusArr=Common_Status::outboundBatchStatus('auto');
        $syncStatusArr=Common_Status::syncStatus('auto');

        $this->view->outboundBatchStatusJson=json_encode($outboundBatchStatusArr);
        $this->view->syncStatusJson=json_encode($syncStatusArr);

        $this->view->outboundBatchStatusArr=$outboundBatchStatusArr;
        $this->view->syncStatusArr=$syncStatusArr;
        echo Ec::renderTpl($this->tplDirectory . "system_index.tpl", 'layout');
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
                
              'system_id'=>'',
              'system_code'=>'',
              'system_title'=>'',
              'system_title_en'=>'',
              'system_url'=>'',
              'system_wsdl'=>'',
              'system_token'=>'',
              'system_key'=>'',
              'system_sort'=>'',
              'system_email'=>'',
              'system_language'=>'',
              'system_status'=>'',
              'system_note'=>'',
            );
            $row=$this->serviceClass->getMatchEditFields($params,$row);
            $paramId = $row['system_id'];
            if (!empty($row['system_id'])) {
                unset($row['system_id']);
            }
//             throw new Exception('dfdfd');
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
                $return['message'] = array('操作成功');
            }

        }
        die(Zend_Json::encode($return));
    }

    public function getByJsonAction()
    {
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array());
        $paramId = $this->_request->getParam('paramId', '');
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'system_id')) {
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
                    $result['message'] = '操作成功';
                }
            }
        }
        die(Zend_Json::encode($result));
    }
}