<?php

/**
 * @desc 反馈报表操作类
 * @author gan
 * @date 2017/04/17
 * */
class Process_FeedbackProcess
{

    public function __construct()
    {
        $this->_date = date('Y-m-d H:i:s');
    }

    /**
     * 生成反馈报表导出表格
     * $data 数据
     */
    public static function createExportExcel($data){
    	set_time_limit(0);
    	ini_set('memory_limit', '500M');
    	 
    	$filename = date("Y-m-d") . '_FeedbackReportInfo';
    	require_once("PHPExcel.php");
    	require_once("PHPExcel/Reader/Excel2007.php");
    	require_once("PHPExcel/Reader/Excel5.php");
    	require_once('PHPExcel/IOFactory.php');
    	$objExcel = new PHPExcel();
    	$objExcel->setActiveSheetIndex(0);
    	$objActSheet = $objExcel->getActiveSheet();
    	$objActSheet->setTitle('反馈报表信息');
    	 
    	// 表头显示内容
    	$rowKey = array(
    		    'pfr_sku'=>'产品sku',
    			'pfr_from'=>'采购商',
    			'pfr_country_name'=>'国家名',
    			'pfr_platform'=>'销售平台',
    			'pfr_rma_amount'=>'RMA总数',
    			/*'pfr_rma_percent'=>'RMA比例，RMA/订单总数',
    			'pfr_refund_order'=>'退款订单数(件)',
    			'pfr_refund_cost'=>'退款金额(￥)',
    			'pfr_reship_order'=>'重复订单数(件)',
    			'pfr_reship_sku'=>'重发sku数(件)',
    			'pfr_rma_reason'=>'RMA原因',
    			'pfr_warehouse_refund_order'=>'仓库退件订单数(件)',
    			'pfr_warehouse_refund_sku'=>'仓库退件sku数(件)',*/
    			'pfr_appear_time'=>'问题出现时间',
    			'pfr_error_type'=>'问题类型(1:质检异常,2:买家退件,6:运输时效问题,7:产品已过期，需重新质检,(注：其它数字待定))',
    			'pfr_quantity'=>'数量(件)',
    			'pfr_settle_way'=>'处理方式(1:无处理,2:退款,3:重发,4:退件)',
    			'pfr_content'=>'问题内容',
    			'pfr_update_time'=>'更新时间',

    	);

    	 
    	$ExcelKey = Common_Common::getExcelKey($rowKey);

    	//设置表头
    	foreach($rowKey as $k1=>$v1){
    		foreach($ExcelKey as $k2=>$v2){
    			$val = isset($rowKey[$v2]) ? $rowKey[$v2] : '';
    			$objActSheet->setCellValue($k2 . '1', $val);
    			$objExcel->getActiveSheet()->getStyle('A1:'.$k2.'1')->getFont()->setBold(true);
    		}
    	}

    	//填充数据
    	$i2=0;
    	foreach($data as $k3=>$v3){
    		foreach($ExcelKey as $k4=>$v4){
    		   if($v4 =='pfr_sku'){//设置产品代码单元格数据格式为字符类型
                   $objActSheet->setCellValueExplicit($k4 .($k3+2), $v3[$v4], PHPExcel_Cell_DataType::TYPE_STRING);
               }else{
                   $objActSheet->setCellValue($k4 .($k3+2), $v3[$v4]);
               }

    			$objExcel->getActiveSheet()->getColumnDimension($k4)->setWidth(30);
    		}
    	}

    	header('Pragma:public');
    	header('Content-Type:application/x-msexecl;name="' . $filename . '.xls');
    	header("Content-Disposition:inline;filename=" . $filename . '.xls');
    	$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
    	$objWriter->save('php://output');
    }
    
    

}