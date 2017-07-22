<?php

class Default_ParseController extends Zend_Controller_Action
{
    public function init()
    {   
        error_reporting(0);
    }

    /**
     * @desc 解析产品反馈报表
     * @author Zijie Yuan
     * @date 2017-03-31
     * @return string
     */
    public function parseFeedbackReportAction() {
        Common_Parse::parseFeedbackReport();
        exit;
    }

    /**
     * @desc 解析库存报表
     * @author gan
     * @date 2017-04-10
     * @return string
     */
    public function parseStockReportAction() {
        while (true) {
            $fields = array('srp_id', 'srq_id', 'user_id', 'ute_id', 'erp_no', 'srp_content', 'srp_create_time');
            $numbers = 10;
            $parseArray = Service_StockReportParse::getByCondition(array(), $fields,$numbers, 1);


            if (empty($parseArray)) {
                break;
            }
            $frqIdArray = array();
            // 遍历parse数组
            foreach ($parseArray as $key => $parse) {

                $userId = $parse['user_id'];
                $erpCode = $parse['erp_no'];
                $uteId = $parse['ute_id'];
                $frqIdArray[] = $parse['srp_id'];

                $reportContent = $parse['srp_content'];
                if (empty($reportContent)) {
                    continue;
                }

                $reportList = json_decode($reportContent, true);

                if(!is_array($reportList)){
                    continue;
                }
                // 遍历json里的订单
                foreach ($reportList as $key => $report) {
                    $date = date('Y-m-d H:i:s');
                    $reportInfo = array();  // 报表信息

                    $reportArray['user_id'] = $userId;//用户id
                    $reportArray['ute_id'] = $uteId;//用户与erp对应关系id
                    $reportArray['erp_no'] = $erpCode;//erp用户码
                    $reportArray['sr_sku'] = Common_Common::getArrayValue($report, 'productSku', '');//产品sku
                    $reportArray['sr_spu'] = Common_Common::getArrayValue($report, 'productParent', '');//款号
                    $reportArray['sr_category'] = Common_Common::getArrayValue($report, 'categoryName', '');//品类
                    $reportArray['sr_warehouse'] = Common_Common::getArrayValue($report, 'warehouseDesc', '');//库仓
                    $reportArray['sr_purchasing_amount'] = Common_Common::getArrayValue($report, 'planned', 0);//采购在途数量
                    $reportArray['sr_shipping_amount'] = Common_Common::getArrayValue($report, 'onway', 0);//头程在途数量
                    $reportArray['sr_available_amount'] = Common_Common::getArrayValue($report, 'sellable', 0);//可销售数量
                    $reportArray['sr_produce_amount'] = 0;//生产中库存
                    $reportArray['sr_stock_amount'] = 0;//工厂代发库存
                    $reportArray['sr_turnove_rates'] = 0;//库存周转率
                    $reportArray['sr_stock_cost'] = 0.00;//库存成本
                    $reportArray['sr_save_day'] = 0;//滞库天数/库龄
                    $reportArray['sr_rejects_amount'] = 0;//不良品数量
                    $reportArray['sr_input_amunt'] = 0;//历史入库数
                    $reportArray['sr_output_amount'] = 0;//历史出库数
                    $reportArray['sr_create_time'] = $date;//创建时间
                    $reportArray['sr_update_time'] = $date;//更新时间


                    // 检测数据是否重复
                    $reportExist = Service_StockReport::getByCondition(
                        array('ute_id'=>$reportArray['ute_id'],'sr_sku'=>$reportArray['sr_sku'],'sr_warehouse'=>$reportArray['sr_warehouse'],'sr_spu'=>$reportArray['sr_spu'],'sr_category'=>$reportArray['sr_category']),
                        array('sr_id','sr_sku','sr_warehouse','sr_category'), 1,1
                    );

                    //数据重复则更新数据
                    if(($reportExist[0]['sr_id'] !='') && ($reportExist[0]['sr_sku']=$reportArray['sr_sku']) && ($reportExist[0]['sr_warehouse']=$reportArray['sr_warehouse'])&& ($reportExist[0]['sr_category']=$reportArray['sr_category'])){
                        unset($reportArray['sr_create_time']);
                        Service_StockReport::update($reportArray,array('sr_id'=>$reportExist[0]['sr_id']));
                    }else{
                        $data = Service_StockReport::add($reportArray);
                    }


                    if (empty($data)) {
                        continue;
                    }
                }
            }
            Service_StockReportParse::deleteIn($frqIdArray, 'srp_id');
            unset($parseArray);
        }
        exit;
    }

    /**
     * @desc 解析销售报表
     * @author Zijie Yuan
     * @date 2017-03-31
     * @return string
     */
    public function parseSaleReportAction() {
        Common_Parse::parseSaleReport();
        exit;
    }

    /**
     * @desc 解析产品管理列表数据
     * @author gan
     * @date 2017-06-13
     * @return string
     */
    public function parseProductAction(){
        Common_Parse::parseProduct();
        exit;
    }

    /**
     * @desc 解析QC异常列表数据
     * @date 2017-06-20
     * @return string
     */
    public function parseQcExceptionAction(){
        Common_Parse::parseQcException();
        exit;
    }

    /**
     * @desc 解析收货异常列表数据
     * @date 2017-06-20
     * @return string
     */
    public function parseExceptionAction(){
        Common_Parse::parseException();
        exit;
    }

}

