<?php
class Process_DeliveryIndexProcess {

    /**
     * 生成发货单表格
     * $data 数据
     */

    public static function makeExcel(){
        set_time_limit(0);
        ini_set('memory_limit', '500M');

        $filename = date("Y-m-d") . '_DeliveryOrder';
        require_once("PHPExcel.php");
        require_once("PHPExcel/Reader/Excel2007.php");
        require_once("PHPExcel/Reader/Excel5.php");
        require_once('PHPExcel/IOFactory.php');
        $objExcel = new PHPExcel();
        $objExcel->setActiveSheetIndex(0);
        $objActSheet = $objExcel->getActiveSheet();
        $objActSheet->setTitle('发货单');

        //设置单元格宽度
        $objActSheet->getColumnDimension('A')->setWidth(10);
        $objActSheet->getColumnDimension('B')->setWidth(30);
        $objActSheet->getColumnDimension('C')->setWidth(30);
        $objActSheet->getColumnDimension('D')->setWidth(30);
        $objActSheet->getColumnDimension('E')->setWidth(30);
        $objActSheet->getColumnDimension('F')->setWidth(30);
        $objActSheet->getColumnDimension('G')->setWidth(30);
        $objActSheet->getColumnDimension('H')->setWidth(30);
        $objActSheet->getColumnDimension('I')->setWidth(30);
        $objActSheet->getColumnDimension('J')->setWidth(30);
        $objActSheet->getColumnDimension('K')->setWidth(30);
        $objActSheet->getColumnDimension('L')->setWidth(30);
        $objActSheet->getColumnDimension('M')->setWidth(30);
        $objActSheet->getColumnDimension('N')->setWidth(30);
        $objActSheet->getColumnDimension('O')->setWidth(30);
        $objActSheet->getColumnDimension('P')->setWidth(30);
        $objActSheet->getColumnDimension('Q')->setWidth(30);
        $objActSheet->getColumnDimension('R')->setWidth(30);
        $objActSheet->getColumnDimension('S')->setWidth(30);
        $objActSheet->getColumnDimension('T')->setWidth(30);
        $objActSheet->getColumnDimension('U')->setWidth(30);
        $objActSheet->getColumnDimension('V')->setWidth(50);
        $objActSheet->getColumnDimension('W')->setWidth(50);
        $objActSheet->getColumnDimension('X')->setWidth(30);
        $objActSheet->getColumnDimension('Y')->setWidth(30);
        $objActSheet->getColumnDimension('Z')->setWidth(30);
        $objActSheet->getColumnDimension('AA')->setWidth(70);
        $objActSheet->getColumnDimension('AB')->setWidth(70);
        $objActSheet->getColumnDimension('AC')->setWidth(70);
        $objActSheet->getColumnDimension('AD')->setWidth(70);
        $objActSheet->getColumnDimension('AE')->setWidth(70);


        //表头
        $Letter=array(
            'A','B','C','D','E','F','G','J','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE'
        );

        //定义一个规格尺寸的表头
        $Letterbox1 = array(
            'G','H','I','J','K','L'
        );

      //合并单元格
        $objActSheet->mergeCells('A1:A2');
        $objActSheet->mergeCells('B1:B2');
        $objActSheet->mergeCells('C1:C2');
        $objActSheet->mergeCells('D1:D2');
        $objActSheet->mergeCells('E1:E2');
        $objActSheet->mergeCells('F1:F2');
        $objActSheet->mergeCells('G1:I1');
        $objActSheet->mergeCells('J1:L1');
        $objActSheet->mergeCells('M1:M2');
        $objActSheet->mergeCells('N1:N2');
        $objActSheet->mergeCells('O1:O2');
        $objActSheet->mergeCells('P1:P2');
        $objActSheet->mergeCells('Q1:Q2');
        $objActSheet->mergeCells('R1:R2');
        $objActSheet->mergeCells('S1:S2');
        $objActSheet->mergeCells('T1:T2');
        $objActSheet->mergeCells('U1:U2');
        $objActSheet->mergeCells('V1:V2');
        $objActSheet->mergeCells('W1:W2');
        $objActSheet->mergeCells('X1:X2');
        $objActSheet->mergeCells('Y1:Y2');
        $objActSheet->mergeCells('Z1:Z2');
        $objActSheet->mergeCells('AA1:AA2');
        $objActSheet->mergeCells('AB1:AB2');
        $objActSheet->mergeCells('AC1:AC2');


        $ExcelKeybox = array(
            'doi_box_size_long'=>'内盒长(cm)',
            'doi_box_size_width'=>'内盒宽(cm)',
            'doi_box_size_heigh'=>'内盒高(cm)',
            'doi_box_outside_long'=>'外箱长(cm)',
            'doi_box_outside_width'=>'外箱宽(cm)',
            'doi_box_outside_heigh'=>'外箱高(cm)',
        );

        $ExcelKey = array(
            'do_id'=>'序号',
            'do_no'=>'销售单号',
            'do_ship_no'=>'物流单号',
            'doi_sku'=>'商品sku',
            'doi_name'=>'商品名',
            'doi_amount'=>'商品数量(个)',
            'doi_box_size'=>'内盒规格尺寸(cm)',
            'doi_box_outside_size'=>'外箱规格尺寸(cm)',
            'doi_size'=>'商品尺寸',
            'doi_weight'=>'商品重量(kg)',
            'doi_box_gw'=>'单箱净重(kg)',
            'doi_box_total_gw'=>'总净重(kg)',
            'doi_box_nw'=>'单箱毛重(kg)',
            'doi_box_total_nw'=>'总毛重(kg)',
            'doi_total_box'=>'总箱数',
            'doi_total_cube'=>'总立方(m³)',
            'doi_box_no'=>'箱号',
            'do_ship_time'=>'发货日期(格式：yyyy/mm/dd)',
            'do_pre_receive_time'=>'预计到货时间(格式：yyyy/mm/dd)',
            'do_ship_company'=>'承运方公司',
            'do_company'=>'采购方公司',
            'do_ship_fee'=>'物流费(￥)',
            'do_status'=>'状态(1为：待处理；2为：未发货；3为：已发货；4为：已签收)',
            'doi_remark'=>'备注',
        );
        //需要换行的
        $newLine=array(
            'do_id',
            'do_no',
            'do_ship_no',
            'doi_sku',
            'doi_name',
            'doi_amount',
            'doi_unit',
            'doi_weight',
            'doi_weight_unit',
            'doi_box_gw',
            'doi_box_gw_unit',
            'doi_box_total_gw',
            'doi_box_total_gw_unit',
            'doi_box_nw',
            'doi_box_nw_unit',
            'doi_box_total_nw',
            'doi_box_total_nw_unit',
            'doi_total_box',
            'doi_total_cube',
            'doi_box_size',
            'doi_box_no',
            'do_ship_time',
            'do_pre_receive_time',
            'do_ship_company',
            'do_company',
            'do_ship_fee',
            'do_status',
        );
        $wArr=array();

        //表头
        $i1=0;
        foreach ($ExcelKey as $k => $val) {
            $objActSheet->getStyle($Letter[$i1] . '1')->applyFromArray(
                array(
                    'font' => array (
                        'bold' => true
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                    )
                )

            );
            $objActSheet->setCellValue($Letter[$i1] . '1', $val);
            $i1++;
        }

        $i2 = 0;
        foreach($ExcelKeybox as $key => $value){
            $objActSheet->setCellValue($Letterbox1[$i2] . '2', $value);
            $i2++;
        }

        //填充数据
        $i3=0;
        foreach ($ExcelKey as $k1=>$v1){
            if(in_array($k1, $wArr)){
                $objActSheet->getColumnDimension($Letter[$i3])->setWidth(30);
            }
            $i3++;
        }

        //填充数据
        $i4=0;
        foreach ($ExcelKeybox as $k1=>$v1){
            if(in_array($k1, $wArr)){
                $objActSheet->getColumnDimension($Letterbox1[$i4])->setWidth(30);
            }
            $i4++;
        }
        header('Pragma:public');
        header('Content-Type:application/x-msexecl;name="' . $filename . '.xls');
        header("Content-Disposition:inline;filename=" . $filename . '.xls');
        $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
        $objWriter->save('php://output');

    }


    /**
     * 生成产品导出表格
     * $data 数据
     */
    public static function createExportExcel($data){
    	set_time_limit(0);
    	ini_set('memory_limit', '500M');
    	
    	$filename = date("Y-m-d") . '_ShareProductInfo';
    	require_once("PHPExcel.php");
    	require_once("PHPExcel/Reader/Excel2007.php");
    	require_once("PHPExcel/Reader/Excel5.php");
    	require_once('PHPExcel/IOFactory.php');
        $objExcel = new PHPExcel();
    	$objExcel->setActiveSheetIndex(0);
    	$objActSheet = $objExcel->getActiveSheet();
    	$objActSheet->setTitle('产品资料');
    	
    	//设置单元格宽度
    	$objActSheet->getColumnDimension('A')->setWidth(20);
    	$objActSheet->getColumnDimension('B')->setWidth(45);
    	$objActSheet->getColumnDimension('C')->setWidth(15);
    	$objActSheet->getColumnDimension('D')->setWidth(35);
    	$objActSheet->getColumnDimension('E')->setWidth(20);
    	$objActSheet->getColumnDimension('F')->setWidth(29);
    	$objActSheet->getColumnDimension('G')->setWidth(35);
    	$objActSheet->getColumnDimension('H')->setWidth(90);
    	
    	//表头
    	$Letter=array(
    			'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
    			'AA','AB','AC','AD','AE',
    	);
    	$ExcelKey = array(
    			'product_sku'=>'SKU',
    			'product_info'=>'产品基本信息',
    			'weight_info'=>'重量(kg)',
    			'size_info'=>'尺寸(长x宽x高 CM)',
    		    'status'=>'状态',
    			'create_info'=>'创建信息',
    			'supplier_info'=>'供应商信息',
    			'spd_and_img'=>'附件和图片',
    	);
    	//需要换行的
    	$newLine=array(
    			'product_info',
    			'weight_info',
    			'size_info',
    			'status',
    			'create_info',
    			'supplier_info',
    			'spd_and_img',
    	);
    	$wArr=array();
    	//仓库
    	$warehouseArr = Common_DataCache::getWarehouse();
    	if(!empty($warehouseArr)){
    		foreach ($warehouseArr as $wid=>$w){
    			$ExcelKey[$w['warehouse_code']]=$w['warehouse_code'].'['.$w['warehouse_desc'].']';
    			$newLine[]=$w['warehouse_code'];
    			$wArr[]=$w['warehouse_code'];
    		}
    	}
    	//表头
    	     $i1=0;
    	foreach ($ExcelKey as $k => $val) {
    		$objActSheet->setCellValue($Letter[$i1] . '1', $val);
    		$i1++;
    	} 
    	//填充数据
    	 $i2=0;
    	foreach ($ExcelKey as $k1=>$v1){
    		foreach ($data as $k2=>$v2){
    			$objActSheet->setCellValue($Letter[$i2] .($k2+2), $v2[$k1]);
    			$objAlignment=$objActSheet->getStyle($Letter[$i2] .($k2+2))->getAlignment();
    			$objAlignment->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);  //上对齐
    			if(in_array($k1, $newLine)){
    				$objAlignment->setWrapText(true);
    			}
    		}
    		if(in_array($k1, $wArr)){
    			$objActSheet->getColumnDimension($Letter[$i2])->setWidth(30);
    		}
    		$i2++;
    	} 
    	header('Pragma:public');
    	header('Content-Type:application/x-msexecl;name="' . $filename . '.xls');
    	header("Content-Disposition:inline;filename=" . $filename . '.xls');
    	$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
    	$objWriter->save('php://output');
    }


}