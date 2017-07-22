<?php
class Product_ProductController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "product/views/";
        $this->serviceClass = new Service_Products();
    }

    public function listAction()
    {


        if ($this->_request->isPost()) {
            $uteId = array();
            //获取当前登录的用户id
            $userId = Service_User::getUserId();
            $condition['user_id'] = $userId;

            // 获取用户与erp的关联的公司名信息
            $userinfo = Service_UserToErp::getUserAndErpRelation($condition);
            $condition['ute_id'] = array();
            foreach ($userinfo as $k => $v) {
                if ($v['ute_status'] == 0) {
                    continue;
                }
                $condition['ute_id'][] = $v['ute_id'];
            }
            $page = $this->_request->getParam('page', 1);
            $pageSize = $this->_request->getParam('pageSize', 20);

            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 20;

            $return = array(
                "state" => 0,
                "message" => "No Data"
            );
            $params = $this->_request->getParams();
//            $condition = $this->serviceClass->getMatchFields($params);
            $condition['product_status'] = isset($params['product_status']) ? $params['product_status'] : "";
            $condition['ute_erp_name']   = trim(isset($params['ute_erp_name']) ? $params['ute_erp_name'] : "");
            $condition['product_sku']   = trim(isset($params['product_sku']) ? $params['product_sku'] : "");
            $count = $this->serviceClass->getByConditions($condition, 'count(*)');

            $return['total'] = $count;

            if ($count) {
                $showFields=array(
                    'product_id',
                    'ute_erp_name',
                    'product_sku',
                    'product_name',
                    'product_name_en',
                    'product_status',
                    'product_spu',
                    'product_color',
                    'product_size_unit',
                    'product_width',
                    'product_long',
                    'product_heigh',
                    'product_weight',
                    'product_weig_unit',
                    'product_price',
                    'product_price_unit',
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getByConditions($condition,$showFields, $pageSize, $page, array('product_id desc'));
                $piId= array();
                $datas = array();
                foreach($rows as $k =>$v){
                    $piId['product_id'] = $v['E0'];
                    $data = Service_ProductPictures::getByCondition($piId);
                    if(!empty($data)){
                        foreach ($data as $key =>$value){
                            $pictrue = array();
                            if($v['E0'] == $value['product_id']){
                                $pictrueDate = explode(';', $value['pi_url']);
                                $pictrue['E17'] =$pictrueDate;
                                $datas[] = array_merge($v,$pictrue);

                            }
                        }

                    }else{
                        $datas[] = $v;
                    }

                }


                $return['data'] = $datas;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }
        echo Ec::renderTpl($this->tplDirectory . "product_list_index.tpl", 'layout');
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

                'product_id'=>'',
            );
            $row=$this->serviceClass->getMatchEditFields($params,$row);
            $paramId = $row['product_id'];
            if (!empty($row['product_id'])) {
                unset($row['product_id']);
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
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'product_id')) {
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

    /**
     * @desc 获取历史报价
     * @date 2017/06/13
     * return json
     */

    public function getDecaleDetailAction(){
        $result = array(
            "state" => 0,
            "message" => "Fail."
        );
        $productId = array();
        $product_id  = $this->_request->getParam("product_id",'');

        if(empty($product_id)){
            return $result['message'] = "no data" ;
        }
        $productId['product_id']= $product_id;

        $historyBaoJiaData = Service_ProductQuoteLogs::getByCondition($productId);


        //获取产品代码
        $sku = array();
        $sku['product_id']  = $historyBaoJiaData[0]['product_id'];
        $datas = array();
        if(!empty($sku['product_id'])) {
            $productDatas = Service_Products::getByField($sku);
            $productSku['product_sku'] = $productDatas['product_sku'];
        }
        if(!empty($historyBaoJiaData) && !empty($productSku)){
            foreach($historyBaoJiaData as $key =>$value){
                $datas[] = array_merge($value,$productSku);
            }
        }

        if(!empty($datas)){
            $result['data'] =  $datas;
            $result['message'] = 'Success.';
            $result['state'] = '1';
        }

        die(Zend_Json::encode($result));

    }

//测试消息中心的demo
    public  function testAction(){
         $arr = array("ErpCode"=> "ERP",
                    "AppToken"=>"b365fb21ce764e592dcb171a90d1aec0",
                    "Timestamp"=>"2017-03-24 14:05:56",
                    "Service"=>"getMessage",
                    "Params"=>array(
                        "ErpCode"=> "ERP",
                        "Token"=>"b365fb21ce764e592dcb171a90d1aec0",
                        "Provider"=>"WZA0002",
                        "Message"=>array(
                            array(
                                "Token"=>"b365fb21ce764e592dcb171a90d1aec0",
                                "Provider"=>"WZA0002",
                                "MessageType"=>"1",
                                "MessageTitle"=>"发红包,快来抢",
                                "MessageContent"=>"志哥发红包发红包",
                                "MessageCreateTime"=> "2017-06-19 15:25:36",
                                 ),
                            array(
                                "Token"=>"b365fb21ce764e592dcb171a90d1aec0",
                                "Provider"=>"WZA0002",
                                "MessageType"=>"2",
                                "MessageTitle"=>"发工资通知！",
                                "MessageContent"=>"2017年06月10日发工资通知啦",
                                "MessageCreateTime"=> "2017-06-12 15:25:36",
                                ),

                        )

                    ),
         );

        $data = new Common_Svc();
//        var_dump($data);die;
        $a = $data->postMessages($arr['Params']);
        var_dump($a);die;


    }




}