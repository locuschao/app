<?php
require_once("PHPExcel.php");
require_once("PHPExcel/Writer/Excel5.php");
require_once ('PHPExcel/IOFactory.php');
class Common_CreateFileDownLoad{
	/**
	 * 创建采购订单
	 * @param unknown_type $date_array
	 */
	public static function createContractExcelNew($contractData = array(),$dateFileName){
		
		//控制全局内容字体大小除了标题
		$font_size = 12;
	
		//设置生成的文档名称和path
		$fileName = $contractData['purchaseInfo']["po_code"].".xls";
		$fileDre = APPLICATION_PATH . "/../data/downLoadDir/" . $dateFileName . '/';
		/*
		 * 1、创建phpExcel对象
		* 获取文档预先需获取的信息，如company信息等·····
		*/
		$objPHPExcel = new PHPExcel();
	
		/*
		 * 2、设置文档属性
		*/
		$objPHPExcel->getProperties()->setTitle($contractData['company']["company_name_cn"].$contractData['company']["purchase_contract_name"]);//标题
		$objPHPExcel->getProperties()->setSubject($contractData['company']["company_name_cn"].$contractData['company']["purchase_contract_name"]); //主题
	
		/*
		 * 3、创建工作表
		*/
		$objPHPExcel->createSheet(1);
	
		//获取工作表
	
		//激活工作表
		$objPHPExcel->setActiveSheetIndex(0);
	
		//获取当前激活的工作表
		$sheet = $objPHPExcel->getActiveSheet();
	
		//设置当前工作表title
		$sheet->setTitle("采购格式横项");
		
		/*
		 * 4、向工作表写入数据
		*/
		//采购合同
		$index = 1;
		$sheet->mergeCells("A" . $index . ":B" . $index);
		$sheet->getStyle("A" . $index)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP ); // 垂直方向居中
		//保存条码到本地，并返回路径
		$real_image_path = self::saveImg2Local($contractData['poBarcode'], $contractData['purchaseInfo']['po_code']);
		if ($real_image_path) {
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath($real_image_path);
			//$objDrawing->setHeight(100);
			//$objDrawing->setWidth(100);
			$objDrawing->setCoordinates( "A" . $index);
			$objDrawing->setOffsetY(30);
			$objDrawing->setOffsetX(5);
			$objDrawing->setWorksheet($sheet);
			$sheet->getRowDimension ( $index )->setRowHeight (120); // 设置高度
		}
		
		$sheet->setCellValue("C" . $index, $contractData['company']["purchase_contract_name"]);
		$sheet->mergeCells("C" . $index . ":G" . $index);
		$sheet->getRowDimension("1")->setRowHeight(90);
		$styleA1 = $sheet->getStyle("C" . $index);	
		$styleA1->getFont()->setBold(true);														//粗体
		$styleA1->getFont()->setSize(20);														//字体大小													//获取单元格的样式对象
		$styleA1->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 	//水平方向
		$styleA1->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);       //垂直方向
		self::excuteBorder ( $sheet->getStyle("A" . $index) );
		$sheet->getStyle("B".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("C".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("D".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("E".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("F".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("G".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//采购单号、入库单号、制单员、采购员
		$sheet->setCellValue("H" . $index, "采购单号：" . $contractData['purchaseInfo']['po_code'] . "\r\n" . "入库单号：" . $contractData['purchaseInfo']['po_code'] . "\r\n" . "打印时间：" . $contractData['purchaseInfo']['operation_user'] . '  ' . $contractData['purchaseInfo']['operation_time'] . "\r\n" . "创建时间：" . $contractData['purchaseInfo']['create_user'] . '  ' . $contractData['purchaseInfo']['create_time'] . "\r\n" . "采购员：" . $contractData['purchaseInfo']['user_name']);
		$sheet->getStyle("H" . $index)->getFont()->setSize($font_size);
		$sheet->getStyle("H" . $index)->getAlignment()->setWrapText(true);
		$sheet->getStyle("H".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//self::excuteBorder ($sheet->getStyle("H" . $index));
		
		//仓库
		$index++;
		
		if (empty($contractData['purchaseInfo']['to_warehouse_desc'])) {
			$sheet->mergeCells("A" . $index . ":H" . $index);
		} else {
			$sheet->mergeCells("A" . $index . ":D" . $index);
			$sheet->mergeCells("E" . $index . ":H" . $index);
			
			$sheet->setCellValue("E" . $index, "中转仓：" . $contractData['purchaseInfo']['to_warehouse_desc']);
			$sheet->getStyle("D".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}
		
		$sheet->setCellValue("A" . $index, "采购仓库：" . $contractData['purchaseInfo']['warehouse_desc']);
		$sheet->getStyle("A".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("B".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("C".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("D".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("E".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("F".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("G".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		
		
		//采购方、地址、联系人、电话、传真
		$index++;
		$sheet->getRowDimension($index)->setRowHeight(80);
		$sheet->setCellValue("A" . $index, "采购方：" . "\r\n". "地址：" . "\r\n" . "联系人：" . "\r\n" . "电话：" . "\r\n" . "传真：");
		$sheet->getStyle("A" . $index)->getFont()->setSize($font_size);
		$sheet->getStyle("A" . $index)->getAlignment()->setWrapText(true);
		$sheet->getStyle("A".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("A".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$sheet->mergeCells("B" . $index . ":D" . $index);
		$sheet->setCellValue("B" . $index, $contractData['company']['company_name_cn'] . "\r\n". $contractData['company']['company_address_cn'] . "\r\n" . $contractData['company']['company_contact_name'] . "\r\n" . $contractData['company']['company_contact_tel'] . "\r\n" . $contractData['company']['company_contact_fax']);
		$sheet->getStyle("B" . $index)->getFont()->setSize($font_size);
		$sheet->getStyle("B" . $index)->getAlignment()->setWrapText(true);
		$sheet->getStyle("B".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("C".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("D".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("D".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$sheet->setCellValue("E" . $index, "供货方：" . "\r\n". "地址：" . "\r\n" . "联系人：" . "\r\n" . "电话：" . "\r\n" . "传真：");
		$sheet->getStyle("E" . $index)->getFont()->setSize($font_size);
		$sheet->getStyle("E" . $index)->getAlignment()->setWrapText(true);
		$sheet->getStyle("E".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("E".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$sheet->mergeCells("F" . $index . ":H" . $index);
		$sheet->setCellValue("F" . $index, $contractData['purchaseInfo']["supplier_name"] . "\r\n". $contractData['purchaseInfo']["contact_address"] . "\r\n" . $contractData['purchaseInfo']["contact_name"] . "\r\n" . $contractData['purchaseInfo']["contact_tel"] . "\r\n" . $contractData['purchaseInfo']["contact_Fax"]);
		$sheet->getStyle("F" . $index)->getFont()->setSize($font_size);
		$sheet->getStyle("F" . $index)->getAlignment()->setWrapText(true);
		$sheet->getStyle("F".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("G".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		
		//交货日期
		$index++;
		$sheet->mergeCells("A" . $index . ":H" . $index);
		$sheet->setCellValue("A" . $index, "交货日期：" . $contractData['purchaseInfo']["date_eta"]);
		$sheet->getStyle("A" . $index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 	//水平方向
		$sheet->getStyle("A".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("B".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("C".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("D".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("E".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("F".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("G".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	
		//采购商品明细
		$index++;
		$sheet->setCellValue("A".$index, "NO.");
		$sheet->getStyle("A9".$index)->getFont()->setSize($font_size);
		$sheet->setCellValue("B".$index, ($contractData['is_img']=="1" ? "图片" : "SKU"));
		$sheet->getStyle("B".$index)->getFont()->setSize($font_size);
		$sheet->setCellValue("C".$index, "供应商品号");
		$sheet->getStyle("C".$index)->getFont()->setSize($font_size);
		$sheet->setCellValue("D".$index, "商品中/英文详情");
		$sheet->getStyle("D".$index)->getFont()->setSize($font_size);
		$sheet->setCellValue("E".$index, "单价(" . $contractData['purchaseInfo']['currency_code'] . ")");
		$sheet->getStyle("E".$index)->getFont()->setSize($font_size);
		$sheet->setCellValue("F".$index, "数量");
		$sheet->getStyle("F".$index)->getFont()->setSize($font_size);
		$sheet->setCellValue("G".$index, "金额(" . $contractData['purchaseInfo']['currency_code'] . ")");
		$sheet->getStyle("G".$index)->getFont()->setSize($font_size);
		$sheet->setCellValue("H".$index, "备注");
		$sheet->getStyle("H".$index)->getFont()->setSize($font_size);
		//循环设置表头公共样式
		for($currentColumn= 'A';$currentColumn<= "H"; $currentColumn++){
			$style_temp = $sheet->getStyle($currentColumn.$index);
			$style_temp->getFont()->setBold(true);
			$style_temp->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 	// 水平方向
			$style_temp->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);       //垂直方向
			self::excuteBorder ( $style_temp );
		}
		
		$detail = $contractData["detailProduct"];
		$count_sum = 0;
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		//$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
		
		foreach($detail as $key=>$val){
			if(empty($val["qty_eta"]) || $val["qty_eta"] == 0){
				$val["qty_eta"] = $val["qty_expected"];
			}
			$count_sum += $val["qty_eta"];
				
			$index += 1;
			//产品信息
			$styleA1 = $sheet->getStyle ( $index );
			$styleA1->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER ); // 水平方向居中
			$styleA1->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER ); // 垂直方向居中
			//列A
			$sheet->setCellValue("A".$index, $key+1);
			$sheet->getStyle("A".$index)->getFont()->setSize($font_size);
			self::excuteBorder ( $sheet->getStyle("A".$index) );
				
			//列 B ----------
			//图片路径
			if (is_numeric($val["product_sku"])) {
				$sheet->setCellValueExplicit("B".$index, $val["product_sku"]);
			} else {
				$sheet->setCellValue("B".$index, $val["product_sku"]);
			}
			$sheet->getStyle("B" . $index)->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_TOP ); // 垂直方向居中
			
			
			$real_image_path = '';
			//是否显示图片
			if ($contractData['is_img'] == '1') {
				$real_image_path=Common_CreateFileDownLoad::getProductPic($val["product_image_url"]);
				/* 实例化插入图片类 */
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setPath($real_image_path);
				/* 设置图片高度 */
				$objDrawing->setHeight(100);
				$objDrawing->setWidth(100);
				$objDrawing->setCoordinates( "B" . $index);
				/* 设置图片所在单元格的格式 */
				$objDrawing->setOffsetY(30);
				$objDrawing->setOffsetX(5);
				$objDrawing->setWorksheet($sheet);
				$sheet->getRowDimension ( $index )->setRowHeight (120); // 设置高度
			}
			
			self::excuteBorder ( $sheet->getStyle("B".$index) );
				
			$sheet->setCellValue("C".$index, $val["sp_supplier_sku"]);
			$sheet->getStyle("C".$index)->getFont()->setSize($font_size);
			self::excuteBorder ( $sheet->getStyle("C".$index) );
				
			//中英文
			$sheet->setCellValue("D".$index, "中文：" . $val["product_title"] . "\r\n" . "英文：" . $val["product_title_en"]);
			$sheet->getStyle("D".$index)->getFont()->setSize($font_size);
			$sheet->getStyle("D" . $index)->getAlignment()->setWrapText(true);
			self::excuteBorder ( $sheet->getStyle("D".$index) );
		
			//单价
			$sheet->setCellValue("E".$index, $val["unit_price"]);
			$sheet->getStyle("E".$index)->getFont()->setSize($font_size);
			self::excuteBorder ( $sheet->getStyle("E".$index) );
				
			//数量
			$num = $val["qty_eta"];
			if(empty($num) || $num == 0){
				$num = $val["qty_expected"];
			}
			$sheet->setCellValue("F".$index, $num);//$val["number"]
			$sheet->getStyle("F".$index)->getFont()->setSize($font_size);
			self::excuteBorder ( $sheet->getStyle("F".$index) );
		
		    //金额
			$sheet->setCellValue("G".$index, $val["payable_amount"]);
			$sheet->getStyle("G".$index)->getFont()->setSize($font_size);
			self::excuteBorder ( $sheet->getStyle("G".$index) );
		
			$sheet->setCellValue("H".$index, $val['note']);
			$sheet->getStyle("H".$index)->getFont()->setSize($font_size);
			self::excuteBorder ( $sheet->getStyle("H".$index) );
			
			//产品自定义属性
			if ($val['self_property']) {
				$index += 1;
				$sheet->mergeCells("A" . $index . ":H" . $index);
				$sheet->setCellValue("A" . $index, "产品自定义属性：" . $val['self_property']);
				$sheet->getStyle("A" . $index)->getFont()->setBold(true);
				$sheet->getStyle("A".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$sheet->getStyle("B".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$sheet->getStyle("C".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$sheet->getStyle("D".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$sheet->getStyle("E".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$sheet->getStyle("F".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$sheet->getStyle("G".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$sheet->getStyle("H".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$sheet->getStyle("H".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				
			}
		}
		
		//SKU种类、SKU总数、付款方式、结算方式
		$index++;
		$sheet->mergeCells("A" . $index . ":D" . $index);
		$sheet->setCellValue("A" . $index, "SKU种类：" . count($detail) . "  SKU总数：" . $count_sum . "  付款方式：" . $contractData['purchaseInfo']['pay_type'] . "  结算方式：" . $contractData['purchaseInfo']["account_type"]);
		$sheet->getStyle("A".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("B".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("C".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("D".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("D".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$sheet->mergeCells("E" . $index . ":H" . $index);
		$sheet->setCellValue("E" . $index, "合计金额（小写）：" . (sprintf("%0.3f", $contractData["payable_amount"] + $contractData['purchaseInfo']['pay_ship_amount'])) . " ".$contractData['purchaseInfo']['currency_code']);
		$sheet->getStyle("E".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("F".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("G".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		//运费、合计金额（大写）
		$index++;
		$sheet->mergeCells("A" . $index . ":D" . $index);
		$sheet->setCellValue("A" . $index, "运费：" . $contractData['purchaseInfo']['pay_ship_amount']." ".$contractData['purchaseInfo']['currency_code']);
		$sheet->getStyle("A".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("B".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("C".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("D".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("D".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$sheet->mergeCells("E" . $index . ":H" . $index);
		$amount = Common_AmountTool::get_amount(sprintf("%0.3f", $contractData['purchaseInfo']["payable_amount"] + $contractData['purchaseInfo']['pay_ship_amount']));
		$sheet->setCellValue("E" . $index, "合计金额（大写）：" . $amount);
		$sheet->getStyle("E".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("F".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("G".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		//“主要事项”标题
		$index++;
		$sheet->mergeCells("A" . $index . ":H" . $index);
		$sheet->setCellValue("A" . $index, "注意事项：");
		$sheet->getStyle("A" . $index)->getFont()->setBold(true);
		$sheet->getStyle("A".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("B".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("C".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("D".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("E".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("F".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("G".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		//主要事项
		$index++;
		$sheet->mergeCells("A" . $index . ":H" . $index);
		$sheet->getRowDimension($index)->setRowHeight(200);
		$sheet->setCellValue("A" . $index, $contractData['purchaseInfo']["supplier_treaty"]);
		$sheet->getStyle("A" . $index)->getAlignment()->setWrapText(true);
		$sheet->getStyle("A" . $index)->getFont()->setBold(true);
		$sheet->getStyle("A" . $index)->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_TOP ); // 垂直方向居中
		$sheet->getStyle("A".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("B".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("C".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("D".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("E".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("F".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("G".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		//采购方代表(签字盖章)：                   
		$index++;
		$sheet->getRowDimension($index)->setRowHeight(100);
		$sheet->mergeCells("A" . $index . ":D" . $index);
		$sheet->setCellValue("A" . $index, "采购方代表(签字盖章)：");
		$sheet->mergeCells("E" . $index . ":H" . $index);
		$sheet->setCellValue("E" . $index, "供方代表(签字盖章)：");
		$sheet->getStyle("A" . $index)->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_TOP ); // 垂直方向居中
		$sheet->getStyle("E" . $index)->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_TOP ); // 垂直方向居中
		$sheet->getStyle("A".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("B".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("C".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("D".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$sheet->getStyle("E".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("F".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("G".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle("H".$index)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		/*
		 * 5、数据保存到本地文件夹
		*/
		if(!file_exists($fileDre)){
			mkdir($fileDre);
		}
		//将生成的excel文档保存到本地
		PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5')->save($fileDre.$fileName);
	}

	public static function saveImg2Local($url, $poCode){
		$path = '';
		
		//面单存放目录
		if(!is_dir(APPLICATION_PATH . '/../data/barcode/')){
			mkdir(APPLICATION_PATH . '/../data/barcode/', 0777);
			chmod(APPLICATION_PATH . '/../data/barcode/', 0777);
		}
		try {
			//print_r(file_get_contents($url, true));die;
			if ($fileContents = file_get_contents($url)) {
				
				$file = APPLICATION_PATH . '/../data/barcode/' . $poCode . ".png";;
				
				file_put_contents($file, $fileContents);
				
				if(!file_exists($file)){
					return $path;
				}
				
				chmod($file,0777);
				
				return realpath($file);
			}
		} catch (Exception $e) {
			print_r($e);
		}
		
		return $path;
	}

	/**
	 * @param style_temp
	 */
	 private static function excuteBorder($style_temp) {
			 $style_temp->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   //设置边框
			 $style_temp->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   //设置边框
			 $style_temp->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   //设置边框
			 $style_temp->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   //设置边框
	}

	/**
     * 产品图片可能是存在本地的资源，也可能是远程资源，如果是远程图片资源则下载下来
     * @param String $product_url  产品图片地址
     * @return String 本地图片路径
     */
   static function getProductPic($product_url){
        //创建缓存图片的文件夹
        if (! is_dir ( APPLICATION_PATH . '/../data/images' )) {
            mkdir(APPLICATION_PATH . '/../data/images', 0777);
            chmod(APPLICATION_PATH . '/../data/images', 0777);
        }
        if (! is_dir ( APPLICATION_PATH . '/../data/images/product' )) {
            mkdir(APPLICATION_PATH . '/../data/images/product', 0777);
            chmod(APPLICATION_PATH . '/../data/images/product', 0777);
        }
        $local_path_temp= realpath(APPLICATION_PATH.'/../data/images').'/product';
        //无图片时候显示
        $not_image=realpath(APPLICATION_PATH.'/../public')."/images/base/noimg.jpg";
        //设置单元格用的图片路径，应该是本地路径
        $real_image_path=$not_image;
        
		//远程图片应该被临时下载下来
		$real_image_path=$product_url;
		if(preg_match('/^(http|ftp)/', $real_image_path)){//网络图片
			$real_image_path = str_replace(' ', '%20', $real_image_path);
		}
		$fileName = Common_Common::uuid(time());
		//如果本地无图片,远程下载图片到本地
		$local_file_path_temp= $local_path_temp."/".$fileName.".jpg";
		//小于1024字节，判断为图片异常
		if(!file_exists($local_file_path_temp) || filesize($local_file_path_temp)<1024){
			set_time_limit(120);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch,CURLOPT_URL,$real_image_path);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$content = curl_exec($ch);
			curl_close($ch);
			//                             $content = file_get_contents($real_image_path);
			if(empty($content) || strlen($content)<1024){
				$local_file_path_temp=$not_image;
			}else{
				file_put_contents($local_file_path_temp, $content);
			}
			$org_info = @getimagesize($local_file_path_temp);
			if($org_info===false){//非图片
				//删除保存的文件
				@unlink($local_file_path_temp);
				$local_file_path_temp=$not_image;
			}
		}
		$real_image_path=$local_file_path_temp;
		self::genThumbNew($real_image_path, 150, 150);
        
        if(!file_exists($real_image_path)){$real_image_path=$not_image;}
        return $real_image_path;
    }

    //缩略图
    public static function genThumbNew($path, $width, $height, $bgcolor = "FFFFFF")
    {
    	$ori_path = $path;
    	try {
    		if(!file_exists($path)){
    			throw new Exception('获取图片失败');
    		}
    		$org_info = @getimagesize($ori_path);
    		
    		if($org_info===false){
    			throw new Exception('获取图片失败');
    		}
    		$obj = new Common_ImageForPrintProcess();
    		$img_org = $obj->getResource($ori_path,$org_info);
    		
    		if(!$img_org){
    			throw new Exception('获取图片失败');
    		}
    		if($org_info[0]<$width&&$org_info[1]<$height){
    			return;
    		}
    		/*
    		 * 原始图片以及缩略图的尺寸比例
    		*/
    		$scale_org = $org_info[0] / $org_info[1];
    		$img_thumb = imagecreatetruecolor($width, $height);
    		$red = $green = $blue = "";
    		sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue);
    		$clr = imagecolorallocate($img_thumb, $red, $green, $blue);
    		imagefilledrectangle($img_thumb, 0, 0, $width, $height, $clr);
    		if($org_info[0] / $width > $org_info[1] / $height){
    			$lessen_width = $width;
    			$lessen_height = $width / $scale_org;
    		}else{
    			/*
    			 * 原始图片比较高，则以高度为准
    			*/
    			$lessen_width = $height * $scale_org;
    			$lessen_height = $height;
    		}
    		$dst_x = ($width - $lessen_width) / 2;
    		$dst_y = ($height - $lessen_height) / 2;
    		@imagecopyresampled($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height, $org_info[0], $org_info[1]);
    		$thumb_path = $path;
    		if(function_exists('imagejpeg')){
    			imagejpeg($img_thumb, $path, 100);
    		}elseif(function_exists('imagegif')){
    			imagegif($img_thumb, $path);
    		}elseif(function_exists('imagepng')){
    			imagepng($img_thumb, $path);
    		}
    		imagedestroy($img_thumb);
    		imagedestroy($img_org);
    	} catch (Exception $e) {
    		//失败
    		$path = realpath(APPLICATION_PATH.'/../public')."/images/base/noimg.jpg";
    	}    	
    	//图片本地url
    	return $path;
    }
}