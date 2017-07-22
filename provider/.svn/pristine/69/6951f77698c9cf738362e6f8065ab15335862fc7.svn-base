<?php

class Common_Config
{

    /**
     * @desc 获取订单已发货状态
     * @return array
     */
    public static function shippedStatusArr()
    {
        return array(8, 9, 10, 11, 12, 13);
    }

    /**
     * @desc 采购金额是否需要采购员审核
     * @return int 0：不需要审核 1：需要审核
     */
    public static function purchaseIsCheck()
    {
        return 0;
    }

    /**
     * @desc 创建补货采购单是否需要审核
     * @return int 0：不需要审核 1：需要审核
     */
    public static function createPurchaseOrdersIsCheck()
    {
        return 0;
    }

    /**
     * @desc 财务流水单是否需要审核
     * @return int 0：不需要审核 1：需要审核
     */
    public static function financialManagementIsCheck()
    {
        return 0;
    }

    /**
     * @desc 全站采购成本币种
     * @return string
     */
    public static function purchaseCostCurrency()
    {
        return 'RMB';
    }

    /**
     * @desc 收货时是否需要根据收货数据自动创建付款申请
     * @return int 0：不需要 1：需要
     */
    public static function autoCreatePaymentRequest()
    {
        return 0;
    }

    /**
     * @desc 中转仓理货模式下是否提供强转自动化模式
     * @return int
     */
    public static function appSelectIsCheck()
    {
        return 1;
    }

    /**
     * @desc 如果系统为第一方系统，需要配置客户代码
     * @return int
     */
    public static function getCurrentCustomerCode()
    {
        return 'EC001';
    }

    /**
     * @desc 如果系统为第一方系统，需要配置客户代码
     * @return int
     */
    public static function getCurrentCustomer()
    {
        return array(
            'customer_id' => 1,
            'customer_code' => 'EC001',
        );
    }

    /**
     * @desc 是否为第一方系统
     * @return int 0：否(第三方) 1：是(第一方)
     */
    public static function firstPartySystem()
    {
        return 1;
    }

    /**
     * @kim
     * @desc 货架是否允许放多个SKU
     * @param int $wid
     * @return int
     */
    public static function warehouseStorageType($wid = 0)
    {
        $waRow = Service_WarehouseAdditional::getByField($wid, 'warehouse_id');
        return isset($waRow['storage_type']) ? $waRow['storage_type'] : 1;
    }

    /**
     * @desc 获取客户自定义产品条码打印尺寸
     * @param int $wid
     * @return array|mixed
     */
    public static function getCustomProductLabel($wid = 0)
    {
    	//按客户配置产品名称是否显示2行
    	$configRow = Service_Config::getByField('SHOW_MORE_PRODUCT_TITLE', 'config_attribute', array('config_value'));
    	$SHOW_MORE_PRODUCT_TITLE = isset($configRow['config_value']) ? $configRow['config_value'] : 0;
    	
    	//打印SKU条码，按客户配置，1,：打印仓库条码 0：打印系统SKU条码
    	$configRow = Service_Config::getByField('CUSTOM_PRINT_PRODUCT_BARCODE', 'config_attribute', array('config_value'));
    	$CUSTOM_PRINT_PRODUCT_BARCODE = isset($configRow['config_value']) ? $configRow['config_value'] : 0;
    	
    	//按照仓库配置，打印SKU条码时，是否显示产品中文名称
    	$print_barcode_show_title = 1;
    	if (!empty($wid)) {
    		$warehouseAdditionalRow = Service_WarehouseAdditional::getByField($wid, 'warehouse_id', array('print_barcode_show_title'));
    		$print_barcode_show_title = $warehouseAdditionalRow['print_barcode_show_title'];
    	}
    	
        $sizeArr = array(
            'width' => 70,
            'height' => 30,
            'type' => 0,
            'show_title' => $print_barcode_show_title,
            'show_location' => 0,
            'show_po_code' => 1,   
            'title_lang' => 'cn',
            'print_qc' => '1',
        	'show_ref_no' => 0,  //可配置打印参考在SKU条码下方，默认不打印
        	'show_size' => 0,  //是否显示尺寸
        	'show_color' => 0,  //是否显示颜色
        	'show_material' => 0,  //是否显示材质
        	'show_more_product_title' => $SHOW_MORE_PRODUCT_TITLE, //若配置了显示产品名称，是否显示2行产品名称
        	'custom_print_product_barcode' => $CUSTOM_PRINT_PRODUCT_BARCODE, //打印SKU条码，按客户配置，1,：打印仓库条码 0：打印系统SKU条码
        	'barcode_type' => '1',  //配置打印的条码类型，1：旧条码形式 2：新条码
            'show_supplier' => 0,  //显示供应商名称，默认不显示
            'print_style' => '1',  //打印样式，1：普通，2：卡佩希(定制)，默认普通
        );
        
        $wid = empty($wid) ? '-1' : $wid;
        $db = Common_Common::getAdapter();
        $sql = "SELECT config_value FROM `config` WHERE warehouse_id in(0,$wid) AND config_attribute='CUSTOM_PRODUCT_LABEL' ORDER BY warehouse_id desc;";
        $row = $db->fetchRow($sql);
        if (!empty($row)) {
            $object = json_decode($row['config_value']);
            if (isset($object->width) && isset($object->height)) {
                $sizeArr = array(
                    'width' => $object->width,
                    'height' => $object->height,
                    'type' => isset($object->type) ? $object->type : 0,
                    'show_title' => $print_barcode_show_title ? (isset($object->show_title) ? $object->show_title : 1) : 0,
                    'show_location' => isset($object->show_location) ? $object->show_location : 0,
                    'show_po_code' => isset($object->show_po_code) ? $object->show_po_code : 1,
                	'show_ref_no' => isset($object->show_ref_no) ? $object->show_ref_no : 0,
                    'print_qc' => isset($object->print_qc) ? $object->print_qc : 1,
                    'title_lang' => isset($object->title_lang) ? strtolower($object->title_lang) : 'cn',
                	'show_size' => isset($object->show_size) ? $object->show_size : 0,
                	'show_color' => isset($object->show_color) ? $object->show_color : 0,
                	'show_material' => isset($object->show_material) ? $object->show_material : 0,
                	'show_more_product_title' => $SHOW_MORE_PRODUCT_TITLE,
                	'custom_print_product_barcode' => $CUSTOM_PRINT_PRODUCT_BARCODE,
                	'barcode_type' => isset($object->barcode_type) ? $object->barcode_type : 1,
                	'show_supplier' => isset($object->show_supplier) ? $object->show_supplier : 0,
                	'print_style' => isset($object->print_style) ? $object->print_style : 1,
                );
            }
        }
        
        
        return $sizeArr;
    }
    
    /**
     * 采购单外销合同配置
     */
    public static function getCustomExportedPurchaseOrders()
    {
        $configArr = array(
            'show_contract' => 0,
            'base' => 1,
            'company' => '',
            'address' => '',
        );
        
        $configRow = Service_Config::getByField('EXPORTED_PURCHASE_ORDERS_CONFIG', 'config_attribute', array('config_value'));
        if (!empty($configRow)) {
            $object = json_decode($configRow['config_value']);
            
            $configArr['show_contract'] = isset($object->show_contract) ? $object->show_contract : 0;
            $configArr['base'] = isset($object->base) ? $object->base : 1;
            $configArr['company'] = isset($object->company) ? $object->company : '';
            $configArr['address'] = isset($object->address) ? $object->address : '';
        }
        
        return $configArr;
    }
    
    /**
     * 按客户配置，质检时，可默认长、宽、高、产品包材
     * {"is_size":"0","is_package":"0","length":"28","width":"17","height":"5","pp_barcode":""}
     */
    public static function getCustomQcCconfig()
    {
        $configArr = array(
            'is_size' => 0,
            'is_package' => 1,
            'length' => 0,
            'width' => 0,
        	'height' => 0,
        	'pp_barcode' => '',
        );
        
        $configRow = Service_Config::getByField('CUSTOM_QC_CONFIG', 'config_attribute', array('config_value'));
        if (!empty($configRow)) {
            $object = json_decode($configRow['config_value']);
            
            $configArr['is_size'] = isset($object->is_size) ? $object->is_size : 0;
            $configArr['is_package'] = isset($object->is_package) ? $object->is_package : 0;
            $configArr['length'] = isset($object->length) ? $object->length : 0;
            $configArr['width'] = isset($object->width) ? $object->width : 0;
            $configArr['height'] = isset($object->height) ? $object->height : 0;
            $configArr['pp_barcode'] = isset($object->pp_barcode) ? $object->pp_barcode : '';
        }
        
        return $configArr;
    }
    


    /**
     * @desc 设置打印项
     * @return array()
     */
    public static function setupPrinter()
    {
        return array(
            'A4-297x210' => 'A4纸打印机',
            'A6-105x148' => 'A6纸打印机',
            'customProductLabel' => '产品条码',
            '70x30' => '条码(70x30)',
            '100x30' => '条码(100x30)',
            '80x90' => '标签(80x90)',
            '100x100' => '标签(100x100)',
            '100x150' => '标签(100x150)',
            //统一使用A4-297x210
            //'receiving' => '入库单',
            //'print_qc' => '质检单',
            'print_tpp' => '装箱单',
            //'abnormal' => '异常处理单据',
            //'delivery' => '头程出库单',
            'picking' => '拣货单',
            //'picking2' => '配货单(多件)',
            'invoice' => '形式发票',
            'bag' => '包袋标签',
            'stylus_printer' => '针式打印机(面单)',
        	'single_shelves' => '上架单',
        	'invoiceLabel' => '配货单标签',
        );
    }

    /**
     * 设置是否用自定义条码还是用产品默认条码
     * 0 产品默认条码 1 自定义维护条码
     */
    public static function setUseProductBarcode()
    {
        $state = 0;
        $objConfig = Service_Config::getByField("PRODUCTBARCODE_USER", "config_attribute", "config_value");
        if (!empty($objConfig)) {
            $state = $objConfig["config_value"];
        }

        return $state;
    }

    /**
     * 供应商信息是否只有默认采购员才可以查看 0：否 1：是
     * @return Ambigous <number, mixed>
     */
    public static function getSupplierUser()
    {
        $permissionsArr = self::getSystemPermissions();
        return $permissionsArr['SUPPLIER_USER'];
    }

    /**
     * 采购员是否只能看到自己的采购单 0：否 1：是
     * @return Ambigous <number, mixed>
     */
    public static function getPurchaseOrderUser()
    {
        $permissionsArr = self::getSystemPermissions();
        return $permissionsArr['PURCHASE_USER'];
    }


    /**
     * @desc 获取系统数据权限
     * PURCHASE_USER 采购员是否只能看到自己的采购单 0：否 1：是
     * SUPPLIER_USER 是否需要限制人员访问 0：否 1：是
     * @return array
     */
    public static function getSystemPermissions()
    {
        $permissionsArr = array(
            'PURCHASE_USER' => 0,
            'SUPPLIER_USER' => 0,
        );
        //获取当前登录用户,如果是超级管理员则不限制
        $userId = Service_User::getUserId();
        if ($userId == '1') {
            return $permissionsArr;
        }

        /**
         * @全局权限说明,当角色绑定了全局权限,也不限制
         */
        //ALL_PURCHASE_UNIT_PRICE  采购单价(全局权限)
        //ALL_SUPPLIER 供应商信息(全局权限)

        $globalVariableArr = Service_User::getLoginUserGlobalVariable();

        //采购员是否只能看到自己的采购单
        if (!isset($globalVariableArr['ALL_PURCHASE_UNIT_PRICE'])) {
            $objConfig = Service_Config::getByField("PURCHASE_USER", "config_attribute", "*");
            if (!empty($objConfig)) {
                $permissionsArr['PURCHASE_USER'] = $objConfig["config_value"];
            }
        }


        //是否需要限制人员访问
        if (!isset($globalVariableArr['ALL_SUPPLIER'])) {
            $objConfig = Service_Config::getByField("SUPPLIER_USER", "config_attribute", "*");
            if (!empty($objConfig)) {
                $permissionsArr['SUPPLIER_USER'] = $objConfig["config_value"];
            }
        }

        return $permissionsArr;
    }


    /**
     * @desc 获取供应商信息（全局权限）
     * ALL_SUPPLIER 是否可以看到供应商信息（如供应商地址信息） 0：否 1：是
     * supplierNoRightString 不可以看到的信息以“***”显示
     * @return array
     */
    public static function getSupplierInfoPermissions()
    {
        $permissionsArr = array(
            'ALL_SUPPLIER' => 0,
            'supplierNoRightString' => '',
        );
        
        //角色权限
        $userBusinessData = Service_User::getLoginUserGlobalVariable();
        $userBusinessData = array_keys($userBusinessData);
        if (in_array('ALL_SUPPLIER', $userBusinessData)) {
        	$permissionsArr['ALL_SUPPLIER'] = 1;
        } else {
        	$permissionsArr['supplierNoRightString'] = self::supplierNoRightString();
        }
        
        return $permissionsArr;
    }
    
    

    /**
     * @desc 平台需要进行PDF打印标签的渠道
     * @return array
     */
    public static function getPdfShippingMethod()
    {
        return array(
            'EPACKET' => '线上EUB',
            'EUB' => '线下EUB',
            'CHINA-POST' => '',
            'EMS' => '',
            'YANWEN-EUR' => '',
            'YANWEN-US' => '',
        );
    }


    /**
     * @desc 获取物流产品组代码
     * @return string
     */
    public static function getProductGroupCode()
    {
        return 'EC';
    }

    /**
     * @desc 采购费用合并标志
     * @return int 0：不合并 1：合并
     */
    public static function purchaseMergeFlag()
    {
        $mergeFlag = 0;
        $objConfig = Service_Config::getByField("PAYMENT_MERGE_FLAG", "config_attribute", "*");
        if (!empty($objConfig)) {
            $mergeFlag = $objConfig["config_value"];
        }

        return $mergeFlag;
    }

    /**
     * @desc 采购可合并状态，结合合并标志使用
     * 当可合并时，根据状态合并费用
     * @return int 0: 只合并草稿状态费用，1：可合并草稿、审核未通过、审核状态费用， 2：可合并草稿、审核未通过、审核、审批状态费用
     */
    public static function purchaseAllowMergerState()
    {
        $allowMergerState = 0;
        $allowMergerState = Service_Config::getByField("ALLOW_MERGER_STATE", "config_attribute", "*");
        if (!empty($objConfig)) {
            $allowMergerState = $objConfig["config_value"];
        }

        return $allowMergerState;
    }

    /**
     * @desc 支持补货高级模式
     * @return int 0: 不支持，1： 支持
     */
    public static function supportAdvancedReplenishMode()
    {
        $mode = 0;
        $objConfig = Service_Config::getByField("REPLENISH_MODE", "config_attribute", "*");
        if (!empty($objConfig)) {
            $mode = $objConfig["config_value"];
        }

        return $mode;
    }


    /**
     * @desc 获取是否启用OWMS对接
     * @param int $default
     * @return int
     */
    public static function getOwmsActive($default = 0)
    {
        $active = $default;
        if (Zend_Registry::isRegistered('api')) {
            $api = Zend_Registry::get('api');
            if (isset($api->owms->active)) {
                $active = $api->owms->active;
            } elseif (isset($api['owms']['active'])) {
                $active = $api['owms']['active'];
            }
        }
        return $active;
    }


    /**
     * @desc 下载装箱明细时,当批次中没有成本时是否支持使用默认供应商报价
     * @param int $default
     * @return int
     */
    public static function defaultSupplierProductCost($default = 0)
    {
        $value = $default;
        $objConfig = Service_Config::getByField("default_supplier_product_cost", "config_attribute", array('config_value'));
        if (!empty($objConfig)) {
            $value = $objConfig["config_value"];
        }
        return $value;
    }

    /**
     * @desc 获取平台帐号
     */
    public static function getPlatformUser()
    {
        //卖家帐号
        $db = Common_Common::getAdapter();
        $platformUserArr = array();
        $usRow = Service_UserSystem::getByField('EB', 'us_code');
        if (!empty($usRow)) {
            $sql = "SELECT user_account,platform_user_name FROM {$usRow['us_db']}.`platform_user`;";
            $uaRows = $db->fetchAll($sql);
            if (!empty($uaRows)) {
                foreach ($uaRows as $row) {
                    $platformUserArr[$row['user_account']] = $row['platform_user_name'];
                }
            }
        }
        return $platformUserArr;
    }


    /**
     * @desc 是否支持运输方式维护打包后自动签出功能
     * @param int $value
     * @return int
     */
    public static function setAutoDelivery($value = 0)
    {
        $objConfig = Service_Config::getByField("auto_delivery", "config_attribute", array('config_value'));
        if (!empty($objConfig)) {
            $value = $objConfig["config_value"];
        }
        return $value;
    }

    /**
     * 出纳批量付款是否支持不同供应商一起操作  0：否 1：是
     * @return Ambigous <number, mixed>
     */
    public static function getSupportMerge()
    {
    	$state = 0;
    	$objConfig = Service_Config::getByField("SUPPORT_MERGE", "config_attribute", "*");
    	if (!empty($objConfig)) {
    		$state = $objConfig["config_value"];
    	}
    
    	return $state;
    }


    /**
     * @desc 设置是否开启全局变量控制报表及相关数据
     * @return int 1:开启 0:关闭
     */
    public static function getGlobalVariable()
    {
        $state = 0;
        $objConfig = Service_Config::getByField("BUSINESS_DATA_ACCESS", "config_attribute", "config_value");
        if (!empty($objConfig)) {
            $state = $objConfig["config_value"];
        }
        return $state;
    }
    
    /**
     * @desc 角色管理的业务数据权限中的采购单价控制应用,无权限,默认字符
     * @return string
     */
    public static function purchaseUnitPriceNoRightString()
    {
    	return '***';
    }
    
    /**
     * @desc 角色管理的业务数据权限中的“供应商名称”价控制应用,无权限,默认字符
     * @return string
     */
    public static function supplierNameNoRightString()
    {
    	return '***';
    }

    /**
     * @desc 角色管理的业务数据权限中的供应商控制应用,无权限,默认字符
     * @return string
     */
    public static function supplierNoRightString()
    {
        return '***';
    }
    
    /**
     * @desc 欧盟国家
     */
    public static function getEuStates() {
    	$euStates = array(
    		'AT',
    		'LV',
    		'BE',
    		'LT',
    		'BG',
    		'LU',
    		'CY',
    		'MT',
    		'CZ',
    		'NL',
    		'DK',
    		'PL',
    		'EE',
    		'PT',
    		'FI',
    		'RO',
    		'FR',
    		'SK',
    		'DE',
    		'SI',
    		'GR',
    		'ES',
    		'HU',
    		'SE',
    		'IE',
    		'GB',
    		'IT',
    		'HR',
    	);
    	
    	return $euStates;
    }
    
    /**
     * @desc 走出库流程的类型
     * 1,标准自营仓调拨
     * 3,标准-中转仓
     * 5,“中转外调调拨”，走“出库流程”
     */
    public static function getTransferOrdersOutWarehouseType() {
    	return array(1,3,5);
    }


    /**
     * @desc 是否显示快捷下架
     * @return int 0: 不支持，1： 支持
     */
    public static function getQuickOffShelf()
    {
        $mode = 0;
        $objConfig = Service_Config::getByField("quick_off_shelf", "config_attribute", "*");
        if (!empty($objConfig)) {
            $mode = $objConfig["config_value"];
        }
        return $mode;
    }

    /**
     * @desc 系统统一打印某仓库库位,如果配置指定则整个系统都是使用该仓库库位
     * @param int $warehouseId
     * @return int
     */
    public static function getProductLocationByWarehouse($warehouseId = 0)
    {
        $objConfig = Service_Config::getByField("PRODUCT_LOCATION_BY_WAREHOUSE", "config_attribute", "config_value");
        if (!empty($objConfig)) {
            $warehouseId = $objConfig["config_value"];
        }
        return $warehouseId;
    }
    
    /**
     * @desc 特殊处理
     * @desc质检项目：采购备注
     * @desc创建采购单时：采购备注，读取“产品资料管理”的质检项目“采购备注”
     * @param int $pdId
     * @return string 
     */
    public static function getPurchaseNote($pdId) {
    	$note = '';
    	
    	$productQcOptionsRow = Service_ProductQcOptions::getByField('采购备注', 'pqo_name');
    	if (!empty($productQcOptionsRow)) {
    		$productQcMapRow = Service_ProductQcMap::getByCondition(array("pd_id"=>$pdId, "pqo_id"=>$productQcOptionsRow['pqo_id']), array('pq_detail'));
    		$note = $productQcMapRow[0]['pq_detail'] ? $productQcMapRow[0]['pq_detail'] : '';
    	}
    	
    	return $note;
    }
    
    /**
     * @desc 配置FBA试算链接的页面
     */
    public static function listFba(){
    	$return = array(
    		"北美" => array(
    			"CA" => array("name"=>"加拿大", "link"=>"https://sellercentral.amazon.ca/hz/fba/profitabilitycalculator/index?lang=en_CA"),
    			"US" => array("name"=>"美国", "link"=>"https://sellercentral.amazon.com/hz/fba/profitabilitycalculator/index?lang=en_US"),
    			"MX" => array("name"=>"墨西哥", "link"=>"https://sellercentral.amazon.com.mx/hz/fba/profitabilitycalculator/index?lang=es_MX"),
    		),
    		"欧洲" => array(
    			"DE" => array("name"=>"德国", "link"=>"https://sellercentral.amazon.de/hz/fba/profitabilitycalculator/index?lang=fr_DE"),
    			"ES" => array("name"=>"西班牙", "link"=>"https://sellercentral.amazon.es/hz/fba/profitabilitycalculator/index?lang=es_ES"),
    			"FR" => array("name"=>"法国", "link"=>"https://sellercentral.amazon.fr/hz/fba/profitabilitycalculator/index?lang=fr_FR"),
    			"IN" => array("name"=>"印度", "link"=>"https://sellercentral.amazon.in/hz/fba/profitabilitycalculator/index?lang=fr_IN"),
    			"IT" => array("name"=>"意大利", "link"=>"https://sellercentral.amazon.it/hz/fba/profitabilitycalculator/index?lang=it_IT"),
    			"UK" => array("name"=>"英国", "link"=>"https://sellercentral.amazon.co.uk/hz/fba/profitabilitycalculator/index?lang=en_GB"),
    		),
    		"远东" => array(
    			"JP" => array("name"=>"日本", "link"=>"https://sellercentral.amazon.co.jp/hz/fba/profitabilitycalculator/index?lang=en_JP"),
    		),
    		/* "中国" => array(
    			"CN" => "https://sellercentral.amazon.cn/hz/fba/profitabilitycalculator/index?lang=en_CN",
    		), */
    	);
    	
    	return $return;
    }


    /**
     * @desc 是否支持API试算配置
     * @return int
     */
    public static function getApiTrial()
    {
        $db = Common_Common::getAdapter();
        $value = $db->fetchOne('SELECT COUNT(1) FROM `api_service` where as_trial=1 and as_status=0 and as_is_authorize=1;');
        return $value > 0 ? 1 : 0;
    }


    /**
     * @desc 拣货单附件配置
     * @return int
     */
    public static function getTpAttachment()
    {
        return array(
    		"AttachmentSku" => "SKU条码",
    		"AttachmentPackingList" => "装箱清单",
    		"AttachmentPackingBarcode" => "装箱条码",
    		"AttachmentOther" => "其他附件",
    	);
    }


    /**
     * @desc 调拨单附件配置
     * @return int
     */
    public static function getToAttachment()
    {
        return array(
    		"AttachmentSku" => "SKU条码",
    		"AttachmentPackingList" => "装箱清单",
    		"AttachmentPackingBarcode" => "装箱条码",
    		"AttachmentOther" => "其他附件",
    	);
    }
    
    /**
     * PDA权限配置
     */
    public static function getPdaRightConfig()
    {
        return array(
    		"received" => "收货",
    		"putaway" => "上架",
    		"picking" => "下架",
    		"delivery" => "签出",
        	"package_scan" => "包装扫件",
        	"get_inventory" => "查库存",
        	"update_inventory" => "改库存",
        	"update_location" => "移货架",
    	);
    }
    
    /**
     * 编辑SKU权限
     */
    public static function getEditSkuRight($product_sku)
    {
    	$_edit_sku = 1;
    	
    	$productRow = Service_Product::getByField($product_sku, 'product_sku', array('product_id', 'pd_id'));
    		
    	//查看有无库存数据
    	if (!empty($productRow)) {
    		$productInventoryRow = Service_ProductInventory::getByField($productRow['product_id'], 'product_id');
    		//有库存，不能修改
    		if (!empty($productInventoryRow)) {
    			$_edit_sku = 0;
    		}
    			 
    		//查看有无采购数据
    		$popRow = Service_PurchaseOrderProduct::getByField($productRow['product_id'], 'product_id');
    		//有采购数据，不能修改
    		if (!empty($popRow)) {
    			$_edit_sku = 0;
    		}
    			 
    		//查看有无入库数据
    		$receivingDetailRow = Service_ReceivingDetail::getByField($productRow['product_id'], 'product_id');
    		//有入库数据，不能修改
    		if (!empty($receivingDetailRow)) {
    			$_edit_sku = 0;
    		}
    			
    		//查看有无订单
    		$orderProductRow = Service_OrderProduct::getByField($productRow['product_id'], 'product_id');
    		//有订单数据，不能修改
    		if (!empty($orderProductRow)) {
    			$_edit_sku = 0;
    		}
    	}
    	
    	return $_edit_sku;
    }
    
    /**
     * 供应商单价权限
     */
    public static function getSupplierPriceRight($product_sku){
    	$data = array('purchase_unit_price'=>0, 'purchaseUnitPriceNoRightString'=>'');
    	
    	$userBusinessData = Service_User::getLoginUserGlobalVariable();
    	$userBusinessData = array_keys($userBusinessData);

    	if (in_array('PURCHASE_UNIT_PRICE', $userBusinessData)) {
    		$data['purchase_unit_price'] = 1;
    	} else {
    		$data['purchaseUnitPriceNoRightString'] = self::purchaseUnitPriceNoRightString();
    	}
    	
    	return $data;
    }
    
    /**
     * @desc KPI考核月份
     */
    public static function getKpiMonth(){
    	$data = array();
    	
    	for ($i=date("Y") - 1;$i<=date("Y")+1;$i++) {
    		for ($j=1;$j<=12;$j++) {
    			$data[$i . '-' . sprintf("%02d", $j)] = $i . '年' .  sprintf("%02d", $j) . '月';
    		}
    	}
    	
    	return $data;
    }
    
    /**
     * @desc KPI考核月份
     * @param string $month
     */
    public static function getCurrentDate($month = ''){
    	if (empty($month)) {
    		$month = date("Y-m");
    	}
    	
    	$data = array();
    	$BeginDate=date('Y-m-01', strtotime($month));
    	$day = date('d', strtotime("$BeginDate +1 month -1 day"));
    	for ($i=1;$i<=$day;$i++) {
    		$data[$i] = $i;
    	}
    	return $data;
    }
    
    /**
     * @desc KPI考核部门表格内容配置
     */
    public static function listKpiConfig(){
    	$return = array(
	    		"tHead" => array(
			    		"1" => array('NO.', '员工', '总收货数', '总工时', '均产能/时'),
			    		"2" => array('NO.', '员工', '总合格品数', '总不合格品数', '总工时', '均产能/时'),
			    		"3" => array('NO.', '员工', '总上架数', '总工时', '均产能/时'),
			    		"4" => array('NO.', '员工', '总订单数', '总工时', '均产能/时'),
			    		"5" => array('NO.', '员工', '总订单数', '总工时', '均产能/时'),
			    		"6" => array('NO.', '员工', '总订单数', '总工时', '均产能/时'),
			    		"7" => array('NO.', '员工', '总订单数', '总工时', '均产能/时'),
    	           ),
    			"subtHead" => array(
			    		"1" => array('日', '收货数', '总工时', '均产能/时'),
			    		"2" => array('日', '总合格品数', '总不合格品数', '总工时', '均产能/时'),
			    		"3" => array('日', '上架数', '总工时', '均产能/时'),
			    		"4" => array('日', '订单数', '总工时', '均产能/时'),
			    		"5" => array('日', '订单数', '总工时', '均产能/时'),
			    		"6" => array('日', '订单数', '总工时', '均产能/时'),
			    		"7" => array('日', '订单数', '总工时', '均产能/时'),
    			),
    			"field" => array(
    					"1" => array('total_receiving_qty', 'total_hours', 'total_average_capacity'),
    					"2" => array('total_qc_sellable', 'total_qc_unsellable', 'total_hours', 'total_average_capacity'),
    					"3" => array('total_putaway_qty', 'total_hours', 'total_average_capacity'),
    					"4" => array('total_picking_qty', 'total_hours', 'total_average_capacity'),
    					"5" => array('total_scan_qty', 'total_hours', 'total_average_capacity'),
    					"6" => array('total_pack_qty', 'total_hours', 'total_average_capacity'),
    					"7" => array('total_ship_qty', 'total_hours', 'total_average_capacity'),
    			),
    			"subFiled" => array(
			    		"1" => array('kuh_day', 'kuh_receiving_qty', 'kuh_hours', 'average_capacity'),
			    		"2" => array('kuh_day', 'kuh_qc_sellable', 'kuh_qc_unsellable', 'kuh_hours', 'average_capacity'),
			    		"3" => array('kuh_day', 'kuh_putaway_qty', 'kuh_hours', 'average_capacity'),
			    		"4" => array('kuh_day', 'kuh_picking_qty', 'kuh_hours', 'average_capacity'),
			    		"5" => array('kuh_day', 'kuh_scan_qty', 'kuh_hours', 'average_capacity'),
			    		"6" => array('kuh_day', 'kuh_pack_qty', 'kuh_hours', 'average_capacity'),
			    		"7" => array('kuh_day', 'kuh_ship_qty', 'kuh_hours', 'average_capacity'),
    			),
    			
    	);
    	
    	return $return;
    }



    /**
     * @desc 菜单
     * @return array
     */
    public static function menuData()
    {
        $menuArr[] = array(
            'parent' => '系统列表',
            'item' => array(
                array(
                    'title' => '首页',
                    'url' => '/system/home',
                    'src' => 'home',
                ),
                array(
                    'title' => '产品中心',
                    'url' => '',
                    'src' => 'columns',
                    'item' => array(
                        array(
                            'title' => '产品管理',
                            'url' => '/product/product/',
                        ),
                        array(
                            'title' => '竞标管理',
                            'url' => '/product/bidding/',
                        ),
                        array(
                            'title' => '打样管理',
                            'url' => '/product/proofing/',
                        ),
                        array(
                            'title' => '送样管理',
                            'url' => '/product/deliver/',
                        ),
                    )
                ),
                array(
                    'title' => '订单管理',
                    'url' => '',
                    'src' => 'desktop',
                    'item' => array(
                        array(
                            'title' => '订单中心',
                            'url' => '/order/Order/',
                        ),
                        array(
                            'title' => '异常管理（NEW）',
                            'url' => '/order/Exceptions/',
                        ),
                        array(
                            'title' => '异常管理操作',
                            'url' => '/order/Exceptionsoperation/',
                        ),
                        array(
                            'title' => '合同管理',
                            'url' => '/order/contract-logs'
                        )
                    )
                ),
                array(
                    'title' => '发货管理',
                    'url' => '/delivery/index',
                    'src' => 'truck',
                ),
                //author by blank
                //date 2017-6-10
                array(
                    'title' => '报表中心',
                    'url' => '',
                    'src' => 'table',
                    'item' => array(
                        array(
                            'title' => '销售报表',
                            'url' => '/report/sale-report',
                        ),
                        array(
                            'title' => '产品反馈报表',
                            'url' => '/report/feedbackreport',
                        ),
                        array(
                            'title' => '库存报表',
                            'url' => '/report/stockreport',
                        ),
                    )
                ),
                array(
                    'title' => '消息中心',
                    'url' => '/message/message',
                    'src' => 'volume-up',
                ),
                array(
                    'title' => '用户中心',
                    'url' => '',
                    'src' => 'user',
                    'item' => array(
                        array(
                            'title' => '基础信息',
                            'url' => '/user/info',
                        ),
                        array(
                            'title' => 'ERP列表',
                            'url' => '/user/usertoerp',
                        )
                    )
                ),
                /*array(
                    'title' => '代码生成工具',
                    'url' => '/admin/tool',
                    'src' => '20120127231732261.png',
                ),*/
            ),
        );
        return $menuArr;
    }

}