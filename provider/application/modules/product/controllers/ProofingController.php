<?php
class Product_ProofingController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "product/views/";
        $this->serviceClass = new Service_Bidding();
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
                'sample_no'=>$params['sample_no'],
                'dso_id'=>'0',
                'ute_erp_name'=>$params['ute_erp_name'],
                'sample_result'=>$params['sample_result'],
            );
            unset($params);
            $count = $this->serviceClass->getByConditionJoinPSU($condition, 'count(*)');
            $return['total'] = $count;

            if ($count) {
                $showFields=array(
                'bidding_id',
                'bidding_name',   // 竞标产品名称
                'bidding_name_en',   // 竞标产品名称
                'bidding_long',  //  长
                'bidding_width', // 宽
                'bidding_heigh', // 高
                'bidding_size_unit', // 高
                'bidding_color', // 颜色
                'bidding_create_time',
                );
                $rows = $this->serviceClass->getByConditionJoinPSU($condition,$showFields, $pageSize, $page, array('bidding_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }
        echo Ec::renderTpl($this->tplDirectory . "proofing_list_index.tpl", 'layout');
    }

    /**
     * @desc 送样单列表
     * @author PengHe
     */
    public function detailAction()
    {
        if ($this->_request->isPost()) {
            /*$page = $this->_request->getParam('page', 1);
            $pageSize = $this->_request->getParam('pageSize', 20);

            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 20;*/

            $return = array(
                "state" => 0,
                "message" => "No Data"
            );

            $params = $this->_request->getParams();

            //$condition = $this->serviceClass->getMatchFields($params);
            if(empty($params['idString'])){
                return false;
            }
            $condition = array(
                'bidding_id_in'=>explode(',',$params['idString']),
            );
            unset($params);
            $count = $this->serviceClass->getByConditionJoinSamples($condition, 'count(*)');
            $return['total'] = $count;

            if ($count) {
                $showFields=array(
                    'bidding_id',
                    'bidding_name',   // 竞标产品名称
                    'bidding_name_en',   // 竞标产品名称
                    'bidding_long',  //  长
                    'bidding_width', // 宽
                    'bidding_heigh', // 高
                    'bidding_size_unit', // 高
                    'bidding_color', // 颜色
                    'bidding_create_time',
                );
                $rows = $this->serviceClass->getByConditionJoinSamples($condition,$showFields, 0, 1, array('bidding_id desc'));
                $return['data'] = $rows;
                $return['deliverNo'] = date('YmdHis');
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }
    }

    /**
     * @desc 生成送样单
     * @author PengHe
     */
    public function detailSaveAction()
    {
        if ($this->_request->isPost()) {
            $return = array(
                "state" => 0,
                "message" => "Operation Failure"
            );

            $params = $this->_request->getParams();
            //$condition = $this->serviceClass->getMatchFields($params);
            if(empty($params['idString'])){
                die(Zend_Json::encode($return));
            }
            $id = explode(',',$params['idString']);
            $ute = Service_Bidding::getByField($id[0],'bidding_id','ute_erp_no');
            $biddingId = Service_Bidding::getByCondition(array('ute_erp_no'=>$ute['ute_erp_no']),'bidding_id');
            foreach($biddingId as $value){
                $biddingArr[] = $value['bidding_id'];
            }
            unset($biddingId);
            foreach($id as $value){
                if(!in_array($value,$biddingArr)){
                    $return['message'] = "请选择同一采购商";
                    die(Zend_Json::encode($return));
                }
            }
            unset($biddingArr);
            $condition = array(
                'dso_no'=>$params['deliverNo'],
                'dso_create_time'=>date('Y-m-d H:i:s'),
                'dso_update_time'=>date('Y-m-d H:i:s'),
            );
            unset($params);
            $db = Common_Common::getAdapter();
            $db->beginTransaction();
            try {
                $DsId = Service_DeliverySampleOrders::add($condition);
                foreach($id as $value){
                    Service_Samples::update(array('dso_id'=>$DsId),$value,'bidding_id');
                }
                $db->commit();

                $return = array(
                    'state' => 1,
                    'message' => 'Success.'
                );
            }catch (Exception $e){
                $db->rollback();
                $return['message']=$e->getMessage();
            }
        }


            die(Zend_Json::encode($return));
        }



}