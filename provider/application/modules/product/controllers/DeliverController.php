<?php
class Product_DeliverController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "product/views/";
        $this->serviceClass = new Service_DeliverySampleOrders();
    }

    /**
     * @desc 打样列表
     * @author PengHe
     */
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

            //$condition = $this->serviceClass->getMatchFields($params);
            $condition = array(
                'user_id'=>Service_User::getUserId(),
                'dso_no'=>$params['dso_no'],
                'dso_create_time_start'=>$params['dateFor'],
                'dso_create_time_end'=>$params['dateTo'],
            );
            unset($params);
            $count = $this->serviceClass->getByConditionJoinSamples($condition,'*', '', 1, array('dso_create_time desc'),'dso_no');
            $return['total'] = count($count);

            if ($count) {
                $rows = $this->serviceClass->getByConditionJoinSamples($condition,array('COUNT(dso_no) AS count_dso_no' ,'*'), $pageSize, $page, array('dso_create_time desc'),'dso_no');
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }
        echo Ec::renderTpl($this->tplDirectory . "deliver_list_index.tpl", 'layout');
    }

    /**
     * @desc 获取送样单详情
     */
    public function detailAction()
    {
        if ($this->_request->isPost()) {
            $return = array(
                "state" => 0,
                "message" => "No Data"
            );

            $params = $this->_request->getParams();
            $condition = array(
                'dso_id'=>$params['dsoId'],
                //'user_id'=>Service_User::getUserId(),
            );
            $dosInfo = $this->serviceClass->getByConditionJoinSU($condition,array('COUNT(dso_no) AS count_dso_no' ,'*'),0,1,array('dso_create_time desc'),'dso_no');
            $spamleInfo = $this->serviceClass->getByConditionJoinSB($condition);
            if(!empty($dosInfo) && !empty($spamleInfo)){
                $return['data'] = array(
                    'dsoInfo'=>$dosInfo[0],
                    'spamleInfo'=>$spamleInfo,
                );
                $return['state'] = 1;
                $return['message'] = "";
            }

            die(Zend_Json::encode($return));
        }
    }
}