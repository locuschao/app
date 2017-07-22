<?php

/**
 * @desc 库存操作类
 * @author gan
 * @date 2017/04/17
 * */
class Process_StockProcess
{

    public function __construct()
    {
        $this->_date = date('Y-m-d H:i:s');
    }

    /**
     * 生成订单导出表格
     * $data 数据
     */
    public static function createExportExcel($data){
    	set_time_limit(0);
    	ini_set('memory_limit', '500M');
    	 
    	$filename = date("Y-m-d") . '_InventoryReportInfo';
    	require_once("PHPExcel.php");
    	require_once("PHPExcel/Reader/Excel2007.php");
    	require_once("PHPExcel/Reader/Excel5.php");
    	require_once('PHPExcel/IOFactory.php');
    	$objExcel = new PHPExcel();
    	$objExcel->setActiveSheetIndex(0);
    	$objActSheet = $objExcel->getActiveSheet();
    	$objActSheet->setTitle('库存报表');
    	 
    	// 表头显示内容
    	$rowKey = array(
    		    'sr_sku'=>'产品sku',
    			/*'sr_spu'=>'款号',*/
    			'sr_category'=>'品类',
    			'sr_warehouse'=>'仓库',
    			'sr_produce_amount'=>'生产中库存',
                'sr_purchasing_amount'=>'采购在途数量',
                'sr_available_amount'=>'可销售数量',
    			'sr_stock_cost'=>'库存成本(￥)',
                'sr_rejects_amount'=>'不良品数量',
                /*'sr_shipping_amount'=>'头程在途数量',
                'sr_stock_amount'=>'工厂代发库存',
                'sr_input_amunt'=>'历史入库数',
                'sr_output_amount'=>'历史出库数',
                'sr_turnove_rates'=>'库存周转率(%)',
    			'sr_save_day'=>'滞库天数/库龄',*/
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