<?php
require_once ("PHPExcel.php" );
require_once ("PHPExcel/Writer/Excel5.php" );
require_once ('PHPExcel/IOFactory.php' );
class Service_Warehouse extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_Warehouse|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_Warehouse();
        }
        return self::$_modelClass;
    }

    /**
     * @param $row
     * @return mixed
     */
    public static function add($row)
    {
        $model = self::getModelInstance();
        return $model->add($row);
    }


    /**
     * @param $row
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function update($row, $value, $field = "warehouse_id")
    {
        $row['warehouse_update_time'] = date('Y-m-d H:i:s');
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "warehouse_id")
    {
        $model = self::getModelInstance();
        return $model->delete($value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @param string $colums
     * @return mixed
     */
    public static function getByField($value, $field = 'warehouse_id', $colums = "*")
    {
        $model = self::getModelInstance();
        return $model->getByField($value, $field, $colums);
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        $model = self::getModelInstance();
        return $model->getAll();
    }

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getByCondition($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $model = self::getModelInstance();
        return $model->getByCondition($condition, $type, $pageSize, $page, $order);
    }

    public static function getJoinLeftByCondition($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $model = self::getModelInstance();
        return $model->getJoinLeftByCondition($condition, $type, $pageSize, $page, $order);
    }

    public static function getGroupCountryByCondition($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $model = self::getModelInstance();
        return $model->getGroupCountryByCondition($condition, $type, $pageSize, $page, $order);
    }

    /**
     * 获取非中转仓信息
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getStandardWarehouse($type = array("warehouse_id","warehouse_code","warehouse_desc"))
    {
    	$model = self::getModelInstance();
    	return $model->getStandardWarehouse($type = array("warehouse_id","warehouse_code","warehouse_desc"));
    }

    /**
     * @desc获取海外仓库
     * @param array $order
     * @return mixed
     */
    public static function getOtherWarehouse($order = array("country_id", "warehouse_code"))
    {
        $configRow = Service_Config::getByField('LOCALCOUNTRYID', 'config_attribute');
        $localCountryId = isset($configRow['config_value']) ? $configRow['config_value'] : '';
        return self::getByCondition(array('country_id_neq' => $localCountryId), '*', 0, 0, $order);
    }

    /**
     * @param $val
     * @return array
     */
    public static function validator($val)
    {
        $validateArr = $error = array();
        $validateArr[] = array("name" => EC::Lang('warehouseCode'), "value" => $val["warehouse_code"], "regex" => array("require", "englishAndNumber",));
        $validateArr[] = array("name" => EC::Lang('country'), "value" => $val["country_id"], "regex" => array("require", "integer",));
        $validateArr[] = array("name" => EC::Lang('status'), "value" => $val["warehouse_status"], "regex" => array("positive"));
        $error = Common_Validator::formValidator($validateArr);
        if (!empty($val["warehouse_code"])) {
            $condition = array(
                'warehouse_id_neq' => (isset($val['warehouse_id']) ? $val['warehouse_id'] : ''),
                'warehouse_code' => $val["warehouse_code"],
            );
            if (self::getByCondition($condition, 'count(*)')) {
                $error[] = '仓库代码已存在';
            }
        }

        if($val["warehouse_virtual"] == '1'){
        	if(empty($val["warehouse_proxy_code"])){
        		$error[] = '请填写“第三方仓库代码”';
        	}
        }
        return $error;
    }


    /**
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(

              'E0'=>'warehouse_id',
              'E1'=>'warehouse_code',
              'E2'=>'warehouse_status',
              'E3'=>'country_id',
              'E4'=>'state',
              'E5'=>'city',
              'E6'=>'contacter',
              'E7'=>'phone_no',
              'E8'=>'street_address1',
              'E9'=>'street_address2',
              'E10'=>'warehouse_desc',
              'E11'=>'warehouse_add_time',
              'E12'=>'warehouse_update_time',
              'E13'=>'warehouse_virtual',
              'E14'=>'warehouse_type',
              'E15'=>'postcode',
              'E16'=>'company',
              'E17'=>'warehouse_proxy_code',
              'E18'=>'warehouse_service',
        	  'E19'=>'street_number',
        	  'E20'=>'is_transfer',
        	  'E21'=>'cell_phone',
        	  'E22'=>'fax',
        	  'E23'=>'email',
        	  'E24'=>'warehouse_sort',
        );
        return $row;
    }

    /**
     * @desc 字段中文对照
     */
    public function filedEn2Zh(){
    	$row = array(
              'warehouse_code'=>'仓库代码',
    		  'warehouse_desc'=>'仓库名称',
              'warehouse_status'=>'仓库状态',
    		  'warehouse_type'=>'仓库类型',
    		  'warehouse_virtual'=>'运营方式',
    		  'is_transfer'=>'是否需要头程',
    		  'country_id'=>'国家',
              'state'=>'省份',
              'city'=>'城市',
    		  'postcode'=>'邮编',
    		  'company'=>'公司名称',
              'contacter'=>'联系人',
              'phone_no'=>'电话',
              'street_address1'=>'地址1',
              'street_address2'=>'地址2',
    		  'street_number'=>'门牌号',
              'warehouse_proxy_code'=>'第三方仓库代码',
              'warehouse_service'=>'第三方仓储服务(FBA)',
    		  'warehouse_sort'=>'排序',
    	);
    	return $row;
    }

    /**
     * @desc 仓库
     * @return array
     */
    public function getWarehouseArr(){
    	$warehouseArr = array();

    	$warehouseRows = self::getAll();
    	if (!empty($warehouseRows)) {
    		foreach ($warehouseRows as $warehouseRow) {
    			$warehouseArr[$warehouseRow['warehouse_id']] = $warehouseRow['warehouse_code'] . '[' .$warehouseRow['warehouse_desc']. ']';
    		}
    	}

    	return $warehouseArr;
    }


    /**
     * @desc 快捷初始化仓库、分区、库位,FBA仓库、服务商、渠道、运输方式
     * @param array $paramArr warehouse_code、country_code、warehouse_desc、currency_code、sm_code
     * @return mixed
     */
    public static function createFbaWarehouseDataForEbTransaction($paramArr = array())
    {
        $db = Common_Common::getAdapter();
        $db->beginTransaction();
        try {

            if (empty($paramArr['warehouse_code'])) {
                throw new Exception("仓库代码不能为空");
            }

            //转大写
            $paramArr['sm_code'] = strtoupper($paramArr['sm_code']);
            $paramArr['warehouse_code'] = strtoupper($paramArr['warehouse_code']);
            $paramArr['currency_code'] = strtoupper($paramArr['currency_code']);

            $wRow = Service_Warehouse::getByField($paramArr['warehouse_code'], 'warehouse_code');
            if (!empty($wRow)) {
                throw new Exception("仓库代码[{$paramArr['warehouse_code']}]已存在");
            }

            if (empty($paramArr['country_code'])) {
                throw new Exception("国家代码不能为空");
            }

            //仓库名称
            $warehouseDesc = !empty($paramArr['warehouse_desc']) ? $paramArr['warehouse_desc'] : $paramArr['warehouse_code'];

            /**
             * 1、建立仓库
             */
            $countryRow = Service_Country::getByField($paramArr['country_code'], 'country_code');
            $row = array(
                'warehouse_code' => $paramArr['warehouse_code'],
                'warehouse_desc' => $warehouseDesc,
                'warehouse_type' => 0,
                'warehouse_status' => 1,
                'warehouse_virtual' => 1,
                'sp_code' => $paramArr['warehouse_code'],
                'country_code' => $paramArr['country_code'],
                'country_id' => $countryRow['country_id'],
                'warehouse_service' => 'FBA',
                'warehouse_add_time' => date('Y-m-d H:i:s'),
            );

            if (!$wid = Service_Warehouse::add($row)) {
                throw new Exception("初始化仓库数据异常");
            }
            $wwmRow = Service_WarehouseOperationMode::getByField('1', 'wom_default');
            $mapRow = array(
                'warehouse_id' => $wid,
                'wom_id' => (isset($wwmRow['wom_id']) ? $wwmRow['wom_id'] : 5),
                'wwm_add_time' => date('Y-m-d H:i:s'),
            );
            //第三方仓库使用自动化
            if ($row['warehouse_virtual'] == '1') {
                $mapRow['wom_id'] = 3;
            }
            Service_WarehouseWomMap::add($mapRow);
            //出库模式
            $addRow = array(
                'warehouse_id' => $wid,
                'outbound_mode' => 3,//默认为 1
                'wa_update_time' => date('Y-m-d H:i:s'),
                'barcode_type' => 1,//支持仓库条码
            );
            Service_WarehouseAdditional::add($addRow);

            //日志
            $comments = '快捷初始化仓库、分区、库位数据';
            unset($row['warehouse_id']);
            foreach ($row as $key => $val) {
                $comments .= $key . ' [' . $val . '] ';
            }
            $logArr = array(
                'warehouse_id' => $wid,
                'user_id' => Service_User::getUserId(),
                'wl_ip' => Common_Common::getIP(),
                'wl_comments' => $comments,
            );
            if ($wid) {
                Table_WarehouseLog::getInstance()->add($logArr);
            }


            /**
             * 2、建立分区
             */
            $waRow = Service_WarehouseArea::getByField($paramArr['warehouse_code'], 'wa_code');
            if (!empty($waRow)) {
                throw new Exception("初始化分区数据异常,分区代码[" . $paramArr['warehouse_code'] . "]已存在,请更换仓库代码");
            }
            $areaArr = array(
                'wa_code' => $paramArr['warehouse_code'],
                'wa_name' => $paramArr['warehouse_code'] . '分区',
                'wa_name_en' => $paramArr['warehouse_code'],
                'wa_type' => '1',
                // 'pc_id' => '',
                'warehouse_id' => $wid,
                'wa_status' => '1',
                'wa_add_time' => date('Y-m-d H:i:s'),
            );
            if (!Service_WarehouseArea::add($areaArr)) {
                throw new Exception("初始化分区数据异常,无法建立分区数据");
            }

            /**
             * 3、建立库位
             */
            $lRow = Service_Location::getByField($paramArr['warehouse_code'], 'lc_code');
            if (!empty($lRow)) {
                throw new Exception("初始化库位数据异常,库位号[" . $paramArr['warehouse_code'] . "]已存在,请更换仓库代码");
            }

            //获取库位类型
            $ltRows = Service_LocationType::getByCondition(array(), '*', 1, 1);
            $lArr = array(
                'lc_code' => $paramArr['warehouse_code'],
                'lc_note' => '',
                'lc_status' => '1',
                'warehouse_id' => $wid,
                'lt_code' => isset($ltRows[0]['lt_code']) ? $ltRows[0]['lt_code'] : '',
                'wa_code' => $areaArr['wa_code'],
                'lc_sort' => '1',
                'picking_sort' => '1',
            );
            if (!Service_Location::add($lArr)) {
                throw new Exception("初始化库位数据异常,无法建立库位数据");
            }


            /**
             * 二、服务商、渠道、运输方式
             */
            if (!empty($paramArr['sm_code'])) {
                $sml_content = '';
                $smId = '';
                $smRow = Service_ShippingMethod::getByField($paramArr['sm_code'], 'sm_code');
                if (!empty($smRow)) {
                    $smId = $smRow['sm_id'];
                }

                //判断是否存在
                if ($smId == '') {
                    /**
                     * 1、建立服务商、渠道、运输方式
                     */
                    $validateArr[] = array("name" => EC::Lang('smCode'), "value" => $paramArr['sm_code'], "regex" => array("require", "length[1,20]", "noCharacter", "alphanumeric"));
                    $errorArr = Common_Validator::formValidator($validateArr);
                    if (!empty($errorArr)) {
                        throw new Exception(join(" ", $errorArr));
                    }

                    //服务商数据
                    $spId = '';
                    $spRow = Service_ServiceProvider::getByField('FBA', 'sp_code');
                    if (!empty($spRow)) {
                        $spId = $spRow['sp_id'];
                    } else {
                        //为空使用本位币
                        if (!empty($paramArr['currency_code'])) {
                            $currencyCode = $paramArr['currency_code'];
                        } else {
                            $cRow = Service_Currency::getByField('1', 'currency_local');
                            $currencyCode = $cRow['currency_code'];
                        }
                        $spArr = array(
                            'sp_code' => 'FBA',
                            'sp_name' => 'FBA',
                            'sp_contact_name' => '',
                            'sp_contact_phone' => '',
                            'sp_address' => '',
                            'sp_settlement_type' => '0',
                            'currency_code' => $currencyCode,
                            'sp_update_date' => date('Y-m-d H:i:s'),
                            'sp_status' => '0',
                        );
                        $spId = Service_ServiceProvider::add($spArr);
                    }

                    //渠道
                    $scId = '';
                    $scRow = Service_SpServiceChannel::getByField('FBA', 'sc_code');
                    if (!empty($scRow)) {
                        $scId = $scRow['sc_id'];
                    } else {
                        $channel = array(
                            "sp_id" => $spId,
                            "sc_code" => 'FBA',
                            "sc_short_name" => 'FBA',
                            "sc_name" => 'FBA',
                            "sc_name_en" => 'FBA',
                            "sc_status" => 1,
                        );
                        $scId = Service_SpServiceChannel::add($channel);
                    }

                    //运输方式
                    $row = array(
                        'sm_code' => $paramArr['sm_code'],
                        'sm_name_cn' => $paramArr['sm_code'],
                        'sm_name' => $paramArr['sm_code'],
                        'sm_delivery_time_min' => '1',
                        'sm_delivery_time_max' => '4',
                        'sm_delivery_time_avg' => '2',
                        'sm_status' => '1',
                        'sm_class_code' => 'CRE',
                        'sm_is_tracking' => '1',
                        'sm_fee_type' => '',
                        'sm_calc_type' => '',
                        //  'sm_baf'=>'',
                        'sm_return_recipient' => '',
                        'sm_short_name' => '',
                        'st_id' => '',
                        'sc_id' => $scId,
                        'sm_carrier_number' => 'FBA',
                    );
                    $row['pg_code'] = Common_Config::getProductGroupCode();

                    //建立运输方式
                    $smId = Service_ShippingMethod::add($row);
                    $sml_content .= "快捷建立运输方式,并绑定仓库[" . $warehouseDesc . "];";
                } else {
                    $sml_content .= " 绑定仓库[" . $warehouseDesc . "];";
                }


                /**
                 * 2、绑定运输方式
                 */
                $smsRow['warehouse_id'] = $wid;
                $smsRow['sm_id'] = $smId;
                Service_ShippingMethodSettings::add($smsRow);

                //记录日志
                if (!empty($sml_content)) {
                    $log = array(
                        'sm_id' => $smId,
                        'user_id' => Service_User::getUserId(),
                        'sml_ip' => Common_Common::getIP(),
                        'sml_content' => $sml_content,
                        'sml_add_time' => date("Y-m-d H:i:s"),
                    );
                    Service_ShippingMethodLog::add($log);
                }
            }

            //清理缓存
            Common_DataCache::allCleanByDir('ship', 0);
            Common_DataCache::allCleanByDir('warehouse',0);

            $db->commit();
            $return['ask'] = 1;
            $return['message'] = 'success';
            $return['data'] = array();
            $return['data']['warehouse_id'] = $wid;
            $return['data']['sm_code'] = $paramArr['sm_code'];
            $return['data']['warehouse_code'] = $paramArr['warehouse_code'];
            $return['data']['warehouse_desc'] = $paramArr['warehouse_desc'];
        } catch (Exception $e) {
            $return['ask'] = 0;
            $return['message'] = $e->getMessage();
            $db->rollBack();
        }
        return $return;
    }
    
    
     /**
     * 下载模板
     */
    public function downLoadTemplate(){
    	//控制全局内容字体大小除了标题
    	$font_size = 12;

    	//设置生成的文档名称和path
    	$dateFileName = date('ymdHis');
    	$fileName = "uploadWarehouse.xls";

    	/*
    	 * 1、创建phpExcel对象
    	* 获取文档预先需获取的信息，如company信息等·····
    	*/
    	$objPHPExcel = new PHPExcel();

    	/*
    	 * 2、创建工作表
    	*/
    	$objPHPExcel->createSheet(0);
    	$objPHPExcel->createSheet(1);

    	//获取工作表
    	$sheet = $objPHPExcel->getSheet(0);
    	$sheet1 = $objPHPExcel->getSheet(1);
        $sheet2 = $objPHPExcel->getSheet(2);
    	$sheet->setTitle("批量导入仓库");
    	$sheet1->setTitle("基础数据");
        $sheet2->setTitle("基础数据(国家简码)");

    	//激活工作表
    	$objPHPExcel->setActiveSheetIndex(0);
    	$objPHPExcel->setActiveSheetIndex(1);

    	//写入sheet
    	$sheet->setCellValue("A1", "仓库代码");
    	$sheet->setCellValue("B1", "仓库名称");
    	$sheet->setCellValue("C1", "排序");
    	$sheet->setCellValue("D1", "状态");
    	$sheet->setCellValue("E1", "类型");
    	$sheet->setCellValue("F1", "运营方式");
    	$sheet->setCellValue("G1", "运营方式(第三方)");
    	$sheet->setCellValue("H1", "是否验证库存上架时间");
        $sheet->setCellValue("I1", "是否需要头程");
    	$sheet->setCellValue("J1", "国家简码");
    	$sheet->setCellValue("K1", "省份");
    	$sheet->setCellValue("L1", "城市");
    	$sheet->setCellValue("M1", "邮编");
    	$sheet->setCellValue("N1", "第三方仓库代码");
    	$sheet->setCellValue("O1", "公司名称");
    	$sheet->setCellValue("P1", "联系人");
        $sheet->setCellValue("Q1", "电话");
        $sheet->setCellValue("R1", "手机");
    	$sheet->setCellValue("S1", "FAX");
    	$sheet->setCellValue("T1", "Email");
    	$sheet->setCellValue("U1", "地址1");
    	$sheet->setCellValue("V1", "地址2");
    	$sheet->setCellValue("W1", "门牌号");

    	$sheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    	$sheet->getStyle('A1')->getFill()->getStartColor()->setARGB("#FFFF00");
    	$sheet->getStyle('D1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    	$sheet->getStyle('D1:F1')->getFill()->getStartColor()->setARGB("#FFFF00");
        $sheet->getStyle('I1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    	$sheet->getStyle('I1:J1')->getFill()->getStartColor()->setARGB("#FFFF00");

    	//写入sheet1-基础数据
    	$sheet1->setCellValue("A1", "状态");
        $sheet1->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    	$sheet1->getStyle('A1')->getFill()->getStartColor()->setARGB("#FFFF00");
        $status=Common_Type::status('auto');
        $index1 = 3;
        foreach($status as $s){
    		$sheet1->setCellValue("A".$index1, $s);
    		$index1 ++;
    	}
        
        $sheet1->setCellValue("C1", "类型");
        $sheet1->getStyle('C1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    	$sheet1->getStyle('C1')->getFill()->getStartColor()->setARGB("#FFFF00");
        $typeArray = Common_Type::warehouseType('auto');
        $index2 = 3;
        foreach($typeArray as $t){
    		$sheet1->setCellValue("C".$index2, $t);
    		$index2 ++;
    	}
        
        $sheet1->setCellValue("E1", "运营方式");
        $sheet1->setCellValue("F1", "运营方式(第三方)");
        $sheet1->getStyle('E1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    	$sheet1->getStyle('E1:F1')->getFill()->getStartColor()->setARGB("#FFFF00");
        $virtualArray = Common_Type::warehouseVirtual('auto');
        $index3 = 3;
        foreach($virtualArray as $v){
    		$sheet1->setCellValue("E".$index3, $v);
    		$index3 ++;
    	}
        $warehouseServiceArr = Common_Type::warehouseService('auto');
        $index4 = 3;
        foreach ($warehouseServiceArr as $key => $value) {
            $sheet1->setCellValue("F".$index4, $key);
            $index4 ++;
        }
        
        $sheet1->setCellValue("H1", "是否验证库存上架时间");
        $sheet1->setCellValue("H3", "是");
        $sheet1->setCellValue("H4", "否");
        $sheet1->setCellValue("I1", "是否需要头程");
        $sheet1->setCellValue("I3", "是");
        $sheet1->setCellValue("I4", "否");
        $sheet1->getStyle('H1:I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    	$sheet1->getStyle('H1:I1')->getFill()->getStartColor()->setARGB("#FFFF00");
        
        //写入sheet2--国家基础数据
        $sheet2->setCellValue("A1", "国家简码");
        $sheet2->setCellValue("B1", "英文");
        $sheet2->setCellValue("C1", "中文");
        $sheet2->getStyle('A1:C1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    	$sheet2->getStyle('A1:C1')->getFill()->getStartColor()->setARGB("#FFFF00");
        $country = Service_Country::getByCondition(array(),array('country_name','country_name_en','country_code'),0,1,'country_sort desc');
        $index5 = 2;
        foreach ($country as $v) {
            $sheet2->setCellValue("A".$index5, $v['country_code']);
            $sheet2->setCellValue("B".$index5, $v['country_name_en']);
            $sheet2->setCellValue("C".$index5, $v['country_name']);
            $index5 ++;
        }
        
    	/*
    	 * 4、用浏览器输出
    	*/
    	header('Pragma:public');
    	header('Content-Type:application/x-msexecl;name="' . $fileName );
    	header("Content-Disposition:inline;filename=" . $fileName);
    	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    	$objWriter->save('php://output');
    }


    /**
     * 批量导入
     * @param unknown $file
     * @throws Exception
     * @return multitype:number multitype: multitype:string  |multitype:string |multitype:number multitype: multitype:string  multitype:NULL
     */
    public function uploadWarehouseTransaction($file){
    	$return = array('state' => 0,'message' => array());

    	if ($file['error']) {
    		$return['message'] = array('请选择xls文件');
    		return $return;
    	}
    	$fileName = $file['name'];
    	$filePath = $file['tmp_name'];
    	$pathinfo = pathinfo($fileName);
    	if (isset($pathinfo["extension"]) && $pathinfo["extension"] != "xls") {
    		$return['message'] = array('请选择xls文件');
    		return $return;
    	}
    	$fileData = Common_Upload::readUploadFile($fileName, $filePath);
    	if (!isset($fileData[1]) || !is_array($fileData[1])) {
    		$result['message'] = array('上传失败，无法解析文件内容;');
    		return $result;
    	}
    	/**
    	 * 格式化数据
    	 */
    	$keys = array(
            '仓库代码' => 'warehouse_code',
            '仓库名称' => 'warehouse_desc',
            '排序' => 'warehouse_sort',
            '状态' => 'warehouse_status',
            '类型' => 'warehouse_type',
            '运营方式' => 'warehouse_virtual',
            '运营方式(第三方)' => 'warehouse_service',
            '是否验证库存上架时间'    => 'verify_validity_stock',
            '是否需要头程' => 'is_transfer',
            '国家简码' => 'country_code',
            '省份' => 'state',
            '城市' => 'city',
            '邮编' => 'postcode',
            '第三方仓库代码' => 'warehouse_proxy_code',
            '公司名称' => 'company',
            '联系人'    => 'contacter',
            '电话' => 'phone_no',
            '手机' => 'cell_phone',
            'FAX' => 'fax',
            'Email' => 'email',
            '地址1' => 'street_address1',
            '地址2' => 'street_address2',
            '门牌号' => 'street_number',
    	);

    	$data = $error = array();
        $onlyCode = array();//检查excel中是否有重复仓库代码
    	foreach ($fileData as $key => $val) {
    		$newVal = array();
    		foreach ($keys as $k => $v) {
    			$newVal[$v] = isset($val[$k]) ? $val[$k] : '';
    		}

        	//分区代码
        	if (empty($newVal['warehouse_code'])) {
        		$error[] = '第 ' . $key . ' 行,仓库代码不能为空';
        		continue;
        	}else{
                    if(in_array($newVal['warehouse_code'], $onlyCode)){
                        $error[] = '第 ' . $key . ' 行,仓库代码[' . $newVal['warehouse_code'] . ']在表格中重复，请更改.';
        		continue;
                    }
                    $onlyCode[] = $newVal['warehouse_code'];//检查excel中是否有重复仓库代码
                    $warehouse = Service_Warehouse::getByField($newVal['warehouse_code'], 'warehouse_code');
                    if ($warehouse){
                            $error[] = '第 ' . $key . ' 行,仓库代码[' . $newVal['warehouse_code'] . ']已存在，请更改.';
                            continue;
                    }
                }
                
                //排序
                if($newVal['warehouse_sort'] != ""){
                    if (!preg_match ( "/^\d+$/", $newVal['warehouse_sort'])) {
                        $error[] = '第 ' . $key . ' 行,排序只能为正整数' ;
                        continue ;
                    }
                }
                
                //状态
        	if ($newVal['warehouse_status'] == "") {
        		$error[] = '第 ' . $key . ' 行,状态不能为空.';
        		continue;
        	}else{
                     switch ($newVal['warehouse_status']) {
                        case '可用':
                            $warehouse_status = '1';
                            break;
                        case '不可用':
                            $warehouse_status = '0';
                            break;
                        case '已废弃':
                            $warehouse_status = '-1';
                            break;
                        default:
                            $error[] = '第 ' . $key . ' 行,状态不存在或无法识别.';
                            continue;
                    }
                }
                
                //类型
        	if ($newVal['warehouse_type'] == "") {
        		$error[] = '第 ' . $key . ' 行,类型不能为空.';
        		continue;
        	}else{
                    switch ($newVal['warehouse_type']) {
                        case '标准':
                            $warehouse_type = '0';
                            break;
                        case '中转':
                            $warehouse_type = '1';
                            break;
                        default:
                            $error[] = '第 ' . $key . ' 行,类型不存在或无法识别.';
                            continue;
                    }
                }
        	
                //运营方式
                if ($newVal['warehouse_virtual'] == "") {
        		$error[] = '第 ' . $key . ' 行,运营方式不能为空.';
        		continue;
        	}else{
                    switch ($newVal['warehouse_virtual']) {
                        case '自营':
                            $warehouse_virtual = '0';
                            break;
                        case '第三方':
                            $warehouse_virtual = '1';
                            break;
                        default:
                            $error[] = '第 ' . $key . ' 行,运营方式不存在或无法识别.';
                            continue;
                    }
                }
                //运营方式（第三方）
                if($newVal['warehouse_service'] != ""){
                    if($warehouse_virtual != '1'){
                        $error[] = '第 ' . $key . ' 行,运营方式为非第三方，请勿填写.';
                        continue;
                    }
                    if($newVal['warehouse_service'] != "FBA"){
                        $error[] = '第 ' . $key . ' 行,运营方式(第三方)不存在或无法识别.';
                        continue;
                    }
                }
                
                //是否验证库存上架时间
                if($newVal['verify_validity_stock'] != ""){
                    if($newVal['warehouse_service'] != "FBA"){
                        $error[] = '第 ' . $key . ' 行,非FBA请勿填写验证库存上架时间.';
                        continue;
                    }
                    switch ($newVal['verify_validity_stock']) {
                        case '是':
                            $verify_validity_stock = 1;
                            break;
                        case '否':
                            $verify_validity_stock = 0;
                            break;
                        default:
                            $error[] = '第 ' . $key . ' 行,是否验证库存上架时间请填写是或否.';
                            break;
                    }
                }
                
                //是否需要头程
                if($newVal['is_transfer'] == ""){
                    $error[] = '第 ' . $key . ' 行,是否需要头程不能为空.';
                    continue;
                }else{
                    switch ($newVal['is_transfer']) {
                        case '是':
                            $is_transfer = 1;
                            break;
                        case '否':
                            $is_transfer = 0;
                            break;
                        default:
                            $error[] = '第 ' . $key . ' 行,是否需要头程请填写是或否.';
                            break;
                    }
                }
                
                //国家简码
                if ($newVal['country_code'] == "") {
        		$error[] = '第 ' . $key . ' 行,国家简码不能为空.';
        		continue;
        	}else{
                    $issetC = Service_Country::getByField($newVal['country_code'], 'country_code');
                    if(empty($issetC)){
                        $error[] = '第 ' . $key . ' 行,国家简码不存在或无法识别.';
                        continue;
                    }
                }
                
                //第三方仓库代码
                if ($newVal['warehouse_proxy_code'] != "") {
                    if($warehouse_virtual != '1'){
                        $error[] = '第 ' . $key . ' 行,运营方式为非第三方，请勿填写第三方仓库代码.';
                        continue;
                    }
        	}

    		$data[$key] = array(
    				'warehouse_code' => $newVal['warehouse_code'],
    				'warehouse_type' => $warehouse_type,
    				'warehouse_status' => $warehouse_status,
    				'warehouse_virtual' => $warehouse_virtual,
    				'is_transfer' => $is_transfer,//批量导入，状态设置为1-可用
    				'country_code' => $newVal['country_code'],
    				'country_id' => $issetC['country_id'],
    				'state' => $newVal['state'],
                                'city' => $newVal['city'],
                                'contacter' => $newVal['contacter'],
                                'company' => $newVal['company'],
                                'phone_no' => $newVal['phone_no'],
                                'cell_phone' => $newVal['cell_phone'],
                                'fax' => $newVal['fax'],
                                'email' => $newVal['email'],
                                'street_address1' => $newVal['street_address1'],
                                'street_address2' => $newVal['street_address2'],
                                'postcode' => $newVal['postcode'],
                                'warehouse_desc' => $newVal['warehouse_desc'],
                                'warehouse_add_time' => date("Y-m-d H:i:s"),
                                'warehouse_proxy_code' => $newVal['warehouse_proxy_code'],
    				'warehouse_service' => $newVal['warehouse_service'],
                                'street_number' => $newVal['street_number'],
                                'warehouse_sort' => $newVal['warehouse_sort'],
                                'verify_validity_stock' => $verify_validity_stock,
    		);
    	}
    	unset($fileData, $newVal);

    	if (!empty($error) || empty($data)) {
    		$return['state'] = 0;
    		$return['message'] = $error;
    		return $return;
    	}

    	$db = Common_Common::getAdapter();
    	$db->beginTransaction();
    	try {
    		foreach ($data as $key => $row) {
                    $verify_validity_stock = $row['verify_validity_stock'];
                    unset($row['verify_validity_stock']);
                    
                    $result = self::add($row);
                    $wwmRow = Service_WarehouseOperationMode::getByField('1', 'wom_default');
                    $mapRow = array(
                        'warehouse_id' => $result,
                        'wom_id' => (isset($wwmRow['wom_id']) ? $wwmRow['wom_id'] : 5),
                        'wwm_add_time' => date('Y-m-d H:i:s'),
                    );
                    //第三方仓库使用自动化
                    if ($row['warehouse_virtual'] == '1') {
                        $mapRow['wom_id'] = 3;
                    }
                    Service_WarehouseWomMap::add($mapRow);
                    //出库模式
                    $addRow = array(
                        'warehouse_id' => $result,
                        'outbound_mode' => 3,//默认为 1
                        'wa_update_time' => date('Y-m-d H:i:s'),
                    );
                    if ($verify_validity_stock=='1' || $verify_validity_stock=='0') {
                            $addRow['verify_validity_stock'] = $verify_validity_stock;

                            if ($verify_validity_stock=='1') {
                                    $vvsLog = ",开启验证库存批次上架时间";
                            } else {
                                    $vvsLog = ",关闭验证库存批次上架时间";
                            }
                    }
                    Service_WarehouseAdditional::add($addRow);

                    //日志
                    $comments = '';
//                    unset($row['warehouse_id']);
                    foreach ($row as $key => $val) {
                            $comments .= $key . ' [' . $val . '] ';
                    }
                    $logArr = array(
                        'warehouse_id' => $result,
                        'user_id' => Service_User::getUserId(),
                        'wl_ip' => Common_Common::getIP(),
                        'wl_comments' => $comments.$vvsLog,
                    );
                    if ($result) {
                        Table_WarehouseLog::getInstance()->add($logArr);
                    }
    		}
    		$db->commit();
    		$return['state'] = 1;
    		$return['message'] = array('操作成功');
    	} catch (Exception $e) {
    		$db->rollBack();
    		$return['message'] = array($e->getMessage());
    	}
    	return $return;
    }
    
}