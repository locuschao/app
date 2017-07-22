<?php
class Order_ContractLogsController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "order/views/";
        $this->serviceClass = new Service_ContractLogs();
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
            // 获取userId
            $userId = Service_User::getUserId();
            /*
             * 功能:erp对应关系ute_id
             */
            $userinfo= Service_UserToErp::getUserAndErpRelation(array('user_id' => $userId, 'ute_status' => 1), array('ute_id'));
            $uteId = Common_Common::getArrayColumn($userinfo, 'ute_id');
            $condition['ute_id'] = implode(',', $uteId);
            // 采购商检索
            if (!empty($condition['ute_erp_name'])) {
                $uteId = Table_UserToErp::getInstance()->getByCondition(array('ute_erp_name' => $condition['ute_erp_name'], 'user_id' => $userId), 'ute_id', 0, 0);
                $uteId = array_unique(Common_Common::getArrayColumn($uteId, 'ute_id'));
                $condition['ute_id'] = implode(',', $uteId);
            }
            // 采购单检索
            if (!empty($condition['order_no'])) {
                $orderId = Table_Orders::getInstance()->getByCondition(array('order_no' => $condition['order_no'], 'ute_id' => $condition['ute_id']), 'order_id', 0, 0);
                $orderId = array_unique(Common_Common::getArrayColumn($orderId, 'order_id'));
                $condition['order_id'] = implode(',', $orderId);
            }

            $count = $this->serviceClass->getContractList($condition, 'count(*)');
            $return['total'] = $count;

            if ($count) {
                $showFields=array(
                    'ute_erp_name',
                    'contract_purchase_warehouse',
                    'contract_transfer_warehouse',
                    'contract_download_time',
                    'contract_status',
                    'contract_id',
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getContractList($condition,$showFields, $pageSize, $page, array('contract_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }
        $this->view->contractStatus = Common_Status::contractStatus();
        echo Ec::renderTpl($this->tplDirectory . "contract_logs_index.tpl", 'layout');
    }

    public function getByJsonAction()
    {
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array());
        $paramId = $this->_request->getParam('paramId', '');
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'contract_id')) {
            $rows=$this->serviceClass->getVirtualFields($rows);
            $result = array('state' => 1, 'message' => '', 'data' => $rows);
        }
        die(Zend_Json::encode($result));
    }
}