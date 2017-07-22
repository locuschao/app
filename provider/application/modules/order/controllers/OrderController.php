<?php
class Order_OrderController extends Ec_Controller_Action
{   
    const CONTRACT_STATUS_PRINTED = 1;      // 合同已打印状态
    const CONTRACT_STATUS_DOWNLOADED = 2;   // 合同已下载状态

    public function preDispatch()
    {   
        $this->tplDirectory = "order/views/";
        $this->serviceClass = new Service_Orders();
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
            $condition['ute_id'] = implode(',',$uteId);
            // sku条件检索
            if (!empty($condition['oi_sku'])) {
                $orderId = Table_OrderItem::getInstance()->getByCondition(array('oi_sku' => $condition['oi_sku']), 'order_id', 0, 0);
                $orderId = array_unique(Common_Common::getArrayColumn($orderId, 'order_id'));
                $condition['orders.order_id'] = implode(',', $orderId);
            }

            $count = $this->serviceClass->getByCondition($condition, 'count(*)');
            $return['total'] = $count;
            if ($count) {
                $showFields=array(
                    'order_no',
                    'order_pre_commit_time',
                    'order_price',
                    'order_price_unit',
                    'order_from',
                    'order_status',
                    'order_create_time',
                    'order_id',
                    'ute_id'
                );
                $showFields = $this->serviceClass->getFieldsAlias($showFields);
                $rows = $this->serviceClass->getOrderList($condition,$showFields, $pageSize, $page, array('orders.order_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['message'] = "";
            }
            die(Zend_Json::encode($return));
        }
        //获取所有的销售单状态
        $statusTypes = Common_Status::orderStatus();
        $this->view->statusTypes = $statusTypes;
        echo Ec::renderTpl($this->tplDirectory . "order_index.tpl", 'layout');
    }

    /**
     * @desc 获取订单详情
     * @author Zijie Yuan
     * @date 2017-03-16
     * @return string
     */
    public function orderDetailsAction() {
        $orderId = $this->_request->getParam('id', 0);
        $result = array(
            'state' => 0,
            'message' => '',
            'data' => ''
        );

        $columns=array(
            'order_no',
            'order_pre_commit_time',
            'order_price',
            'order_from',
            'order_ship_way',
            'order_pay_way',
            'order_pay_percent',
            'order_settle_way',
            'order_price',
            'order_price_unit',
            'order_amount',
            'order_amount_unit',
            'order_id',
        );
        $columns = $this->serviceClass->getFieldsAlias($columns);
        $result = $this->serviceClass->getOrderDetails($orderId, $columns);

        die(Zend_Json::encode($result));
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
                
              'order_id'=>'',
            );
            $row=$this->serviceClass->getMatchEditFields($params,$row);
            $paramId = $row['order_id'];
            if (!empty($row['order_id'])) {
                unset($row['order_id']);
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
        if (!empty($paramId) && $rows = $this->serviceClass->getByField($paramId, 'order_id')) {
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
     * @desc 打印订单合同
     * @author Zijie Yuan
     * @date 2017-04-14
     * @return string
     */
    public function printContractAction() {
        $uteId = $this->_request->getParam('uteId');
        $orderNo = $this->_request->getParam('orderNo');

        if (empty($uteId) || empty($orderNo)) {
            die('参数错误！');
        }
        $contractInfo = $this->serviceClass->printContract($uteId, $orderNo);
        if (empty($contractInfo)) {
            die('网络错误！');
        }
        if (!is_array($contractInfo)) {
            die($contractInfo);
        }
        if (!extension_loaded('gd')) {
            die('缺心眼！');
        }

        $this->view->company= $contractInfo['company'];
        $this->view->count_sum= $contractInfo['count_sum'];
        $this->view->purchaseInfo= $contractInfo['purchaseInfo'];
        $this->view->detailProduct= $contractInfo['detailProduct'];
        $this->view->is_img = 1;

        echo Ec::renderTpl($this->tplDirectory . "print_purchase_contract.tpl", 'layout');
        exit;
    }

    /**
     * @desc 打印订单合同pdf
     * @author Zijie Yuan
     * @date 2017-04-17
     * @return string
     */
    public function printContractPdfAction(){
        if (!extension_loaded('gd')) {
            die('缺心眼！');
        }
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        require_once('tcpdf/tcpdf.php');
        
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // set margins
        $pdf->SetMargins(5, 10, 5);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);
        // set auto page breaks
        $pdf->SetAutoPageBreak(FALSE);
        $pdf->SetFont('droidsansfallback', '', 12);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $uteId = $this->_request->getParam('uteId');
        $orderNo = $this->_request->getParam('orderNo');

        $contractInfo = $this->serviceClass->printContract($uteId, $orderNo);
        if (empty($contractInfo)) {
            die('网络错误！');
        }
        if (!is_array($contractInfo)) {
            die($contractInfo);
        }
        // 生成合同操作记录
        $wareshouseArray = array(
            'purchaseWarehouse' => $contractInfo['purchaseInfo']['warehouse_desc'],
            'transferWarehouse' => $contractInfo['purchaseInfo']['to_warehouse_desc']
        );
        Service_ContractLogs::logContract($orderNo, $uteId, $wareshouseArray, self::CONTRACT_STATUS_PRINTED);

        $this->view->company= $contractInfo['company'];
        $this->view->count_sum= $contractInfo['count_sum'];
        $this->view->purchaseInfo= $contractInfo['purchaseInfo'];
        $this->view->sku_species = count($contractInfo['detailProduct']);
        $this->view->host = $this->_request->getHttpHost();
        $this->view->is_img = 1;

        $htmlArr = array();
        if (count($contractInfo['detailProduct']) > 5) {
            if (count($contractInfo['detailProduct']) <= 8) {
                $this->view->detailProduct= $contractInfo['detailProduct'];
                $html = $this->view->render($this->tplDirectory . "print_purchase_contract_top.tpl");
                $html =  preg_replace('/\s+/',' ',$html);//去除换行
                $html =  preg_replace('/\'/','"',$html);//引号
                $htmlArr[] = $html;

                $html = $this->view->render($this->tplDirectory . "print_purchase_contract_bottom.tpl");
                $html =  preg_replace('/\s+/',' ',$html);//去除换行
                $html =  preg_replace('/\'/','"',$html);//引号
                $htmlArr[] = $html;
            } else {
                $first = array_splice($contractInfo['detailProduct'], 0, 8);
                $this->view->detailProduct= $first;
                $html = $this->view->render($this->tplDirectory . "print_purchase_contract_top.tpl");
                $html =  preg_replace('/\s+/',' ',$html);//去除换行
                $html =  preg_replace('/\'/','"',$html);//引号
                $htmlArr[] = $html;

                $chunk = array_chunk($contractInfo['detailProduct'], 10);
                foreach ($chunk as $k=>$v) {
                    if ($k == count($chunk)-1) {
                        if (count($v) > 6) {
                            $this->view->detailProduct= $v;
                            $html = $this->view->render($this->tplDirectory . "print_purchase_contract_middle.tpl");
                            $html =  preg_replace('/\s+/',' ',$html);//去除换行
                            $html =  preg_replace('/\'/','"',$html);//引号
                            $htmlArr[] = $html;

                            $html = $this->view->render($this->tplDirectory . "print_purchase_contract_bottom.tpl");
                            $html =  preg_replace('/\s+/',' ',$html);//去除换行
                            $html =  preg_replace('/\'/','"',$html);//引号
                            $htmlArr[] = $html;
                        } else {
                            $this->view->detailProduct= $v;
                            $html = $this->view->render($this->tplDirectory . "print_purchase_contract_part.tpl");
                            $html =  preg_replace('/\s+/',' ',$html);//去除换行
                            $html =  preg_replace('/\'/','"',$html);//引号
                            $htmlArr[] = $html;
                        }
                    } else {
                        $this->view->detailProduct= $v;
                        $html = $this->view->render($this->tplDirectory . "print_purchase_contract_middle.tpl");
                        $html =  preg_replace('/\s+/',' ',$html);//去除换行
                        $html =  preg_replace('/\'/','"',$html);//引号
                        $htmlArr[] = $html;
                    }
                }
            }
        } else {
            $this->view->detailProduct= $contractInfo['detailProduct'];
            $html = $this->view->render($this->tplDirectory . "print_purchase_contract_sku.tpl");
            $html =  preg_replace('/\s+/',' ',$html);//去除换行
            $html =  preg_replace('/\'/','"',$html);//引号

            $htmlArr[] = $html;
        }

        foreach ($htmlArr as $html) {
            $pdf->AddPage();
            $pdf->writeHTML($html, true, false, true, false, 'C');
        }

        $pdf->lastPage();
        $pdf->Output($orderCode . '.pdf', 'D');
        exit;
    }

    /**
     * @desc 下载订单合同
     * @author Zijie Yuan
     * @date 2017-04-18
     * @return string
     */
    public function downloadContractAction() {
        set_time_limit(0);
        ini_set('memory_limit', '500M');

        $uteId = $this->_request->getParam('uteId');
        $orderNo = $this->_request->getParam('orderNo');

        $userId = Service_User::getUserId();
        $dateFileName = date('ymdHis').$userId;
        $contractInfo = $this->serviceClass->printContract($uteId, $orderNo);
        if (empty($contractInfo)) {
            die('网络错误！');
        }
        if (!is_array($contractInfo)) {
            die($contractInfo);
        }
        $config = Zend_Registry::get('config');
        $contractInfo['poBarcode'] = $config->production->url . "/barcode/ec/img.php?text=" . $orderNo . "&scale=1&thickness=30";
        //$contractInfo['poBarcode'] = $this->_request->getHttpHost() . "/barcode/ec/img.php?text=" . $orderNo . "&scale=1&thickness=30";
        $contractInfo['is_img'] = 0;
        // 生成文件
        Common_CreateFileDownLoad::createContractExcelNew($contractInfo,$dateFileName);

        // 生成合同操作记录
        $wareshouseArray = array(
            'purchaseWarehouse' => $contractInfo['purchaseInfo']['warehouse_desc'],
            'transferWarehouse' => $contractInfo['purchaseInfo']['to_warehouse_desc']
        );
        Service_ContractLogs::logContract($orderNo, $uteId, $wareshouseArray, self::CONTRACT_STATUS_DOWNLOADED);

        // 打包下载zip
        $uploadDir = APPLICATION_PATH . "/../data/downLoadDir/" . $dateFileName . '/';
        $zipObj = Common_Common::zip($uploadDir."" . $dateFileName . ".zip");
        $zipObj->add_files($uploadDir . "*.xls");
        $zipObj->create_archive();
        $zipObj->download_file();
        Common_Common::clearFile($dateFileName);
    }

    /**
     * @desc 订单确认/取消
     * @author Zijie Yuan
     * @date 2017-04-18
     * @return string
     */
    public function orderOperateAction() {
        $result = array(
            "state" => 0,
            "message" => "Fail."
        );
        if ($this->_request->isPost()) {
            $type = $this->_request->getPost('type');
            $order = $this->_request->getPost('order', array());
            if (empty($order)) {
                $result['message'] = '参数错误！';
                die(Zend_Json::encode($result));
            }
            $result = $this->serviceClass->orderOperate($type, $order);
        }
        die(Zend_Json::encode($result));
    }

    /**
     * @desc 打印sku条码
     * @author Zijie Yuan
     * @date 2017-05-24
     * @return string
     */
    public function printSkuBarcodeAction() {
        if (!extension_loaded('gd')) {
            die('缺心眼！');
        }
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        $orderId = $this->_request->getParam('orderId', '');
        $orderNo = $this->_request->getParam('orderNo', '');
        if (empty($orderId) || empty($orderNo)) {
            die('参数错误！');
        }
        $condition = array(
            'order_id' => $orderId
        );
        $itemService = new Service_OrderItem;
        $skuArray = $itemService->getByCondition($condition, array('oi_sku', 'oi_en_name', 'oi_amount'));
        if (empty($skuArray)) {
            die('网络错误！');
        }

        require_once('tcpdf/tcpdf.php');
        
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // set margins
        $pdf->SetMargins(5, 10, 5);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);
        // set auto page breaks
        $pdf->SetAutoPageBreak(FALSE);
        $pdf->SetFont('droidsansfallback', '', 12);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $config = Zend_Registry::get('config');
        $host = $config->production->url;

        foreach ($skuArray as $key => $sku) {
            for ($i=0; $i < $sku['oi_amount']; $i++) { 
                $this->view->host = $host;
                $this->view->sku= $sku['oi_sku'];
                $this->view->name= $sku['oi_en_name'];
                $html = $this->view->render($this->tplDirectory . "order_item_sku.tpl");
                $pdf->AddPage();
                $pdf->writeHTML($html, true, false, true, false, 'C');
            }
        }
        
        $pdf->lastPage();
        $pdf->Output($orderNo . '_sku' . '.pdf', 'D');
        exit;
    }
}