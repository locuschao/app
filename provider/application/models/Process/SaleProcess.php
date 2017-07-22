<?php

/**
 * @desc 销售报表操作类
 * @author gan
 * @date 2017/04/18
 * */
class Process_SaleProcess
{

    public function __construct()
    {
        $this->_date = date('Y-m-d H:i:s');
    }

    /**
     * @desc 生成订单导出表格
     * @param $data 数据
     */
    public static function createExportExcel($data){
    	set_time_limit(0);
    	ini_set('memory_limit', '500M');
    	 
    	$filename = date("Y-m-d") . '_SaleReportInfo';
    	require_once("PHPExcel.php");
    	require_once("PHPExcel/Reader/Excel2007.php");
    	require_once("PHPExcel/Reader/Excel5.php");
    	require_once('PHPExcel/IOFactory.php');
    	$objExcel = new PHPExcel();
    	$objExcel->setActiveSheetIndex(0);
    	$objActSheet = $objExcel->getActiveSheet();
    	$objActSheet->setTitle('销售报表信息');
    	 
    	// 表头显示内容
    	$rowKey = array(
    		    'sr_sku'=>'产品sku',
    			'sr_from'=>'采购商',
    			/*'sr_country_name'=>'国家名',
    			'sr_category'=>'类别',*/
    			'sr_platform'=>'销售平台',
    			'sr_amount'=>'成交量',
                'sr_sale_gross'=>'销售额',
                'sr_cost'=>'采购成本',
                'sr_price'=>'成交费',
                'sr_ship_fee'=>'物流费用',
                'sr_poundage'=>'手续费',
                /*'sr_service_ship_fee'=>'服务商派送费',
                'sr_refund_fee'=>'退款费',
                'sr_cost_unit'=>'金额单位',
    			'sr_amount_unit'=>'成交量单位',
    			'sr_trend'=>'销售趋势',
    			'sr_increase_rate'=>'增长率',
    			'sr_3d_amount'=>'3天平均销量',
    			'sr_7d_amount'=>'7天平均销量',
    			'sr_14d_amount'=>'14天平均销量',
    			'sr_30d_amount'=>'30天平均销量',
    			'sr_perior_amount'=>'本期销量',
    			'sr_prior_perior_amount'=>'上期销量',
    			'sr_prior_two_perior_amount'=>'上两期销量',
    			'sr_prior_three_perior_amount'=>'上三期销量',
    			'sr_perior_price'=>'本期售价',
    			'sr_prior_perior_price'=>'上期售价',
    			'sr_prior_two_perior_price'=>'上两期售价',
    			'sr_prior_three_perior_price'=>'上三期售价',*/
    			'sr_update_time'=>'更新时间',
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
    			$objActSheet->setCellValue($k4 .($k3+2), $v3[$v4]);
    			$objExcel->getActiveSheet()->getColumnDimension($k4)->setWidth(20);
    		}
    	}

    	header('Pragma:public');
    	header('Content-Type:application/x-msexecl;name="' . $filename . '.xls');
    	header("Content-Disposition:inline;filename=" . $filename . '.xls');
    	$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
    	$objWriter->save('php://output');
    }
    
    

}