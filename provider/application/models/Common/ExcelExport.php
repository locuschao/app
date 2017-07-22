<?php
//测试excel最多多少列
require_once("PHPExcel.php");
require_once ("PHPExcel/Reader/Excel5.php");
require_once ("PHPExcel/Reader/Excel2007.php");
require_once ("PHPExcel/Writer/Excel5.php"); 
require_once ("PHPExcel/Writer/Excel2007.php"); 
class Common_ExcelExport {

    private static $objExcel = '';

    public static $excel2003Col = array(
            0 => 'A',
            1 => 'B',
            2 => 'C',
            3 => 'D',
            4 => 'E',
            5 => 'F',
            6 => 'G',
            7 => 'H',
            8 => 'I',
            9 => 'J',
            10 => 'K',
            11 => 'L',
            12 => 'M',
            13 => 'N',
            14 => 'O',
            15 => 'P',
            16 => 'Q',
            17 => 'R',
            18 => 'S',
            19 => 'T',
            20 => 'U',
            21 => 'V',
            22 => 'W',
            23 => 'X',
            24 => 'Y',
            25 => 'Z',
            26 => 'AA',
            27 => 'AB',
            28 => 'AC',
            29 => 'AD',
            30 => 'AE',
            31 => 'AF',
            32 => 'AG',
            33 => 'AH',
            34 => 'AI',
            35 => 'AJ',
            36 => 'AK',
            37 => 'AL',
            38 => 'AM',
            39 => 'AN',
            40 => 'AO',
            41 => 'AP',
            42 => 'AQ',
            43 => 'AR',
            44 => 'AS',
            45 => 'AT',
            46 => 'AU',
            47 => 'AV',
            48 => 'AW',
            49 => 'AX',
            50 => 'AY',
            51 => 'AZ',
            52 => 'BA',
            53 => 'BB',
            54 => 'BC',
            55 => 'BD',
            56 => 'BE',
            57 => 'BF',
            58 => 'BG',
            59 => 'BH',
            60 => 'BI',
            61 => 'BJ',
            62 => 'BK',
            63 => 'BL',
            64 => 'BM',
            65 => 'BN',
            66 => 'BO',
            67 => 'BP',
            68 => 'BQ',
            69 => 'BR',
            70 => 'BS',
            71 => 'BT',
            72 => 'BU',
            73 => 'BV',
            74 => 'BW',
            75 => 'BX',
            76 => 'BY',
            77 => 'BZ',
            78 => 'CA',
            79 => 'CB',
            80 => 'CC',
            81 => 'CD',
            82 => 'CE',
            83 => 'CF',
            84 => 'CG',
            85 => 'CH',
            86 => 'CI',
            87 => 'CJ',
            88 => 'CK',
            89 => 'CL',
            90 => 'CM',
            91 => 'CN',
            92 => 'CO',
            93 => 'CP',
            94 => 'CQ',
            95 => 'CR',
            96 => 'CS',
            97 => 'CT',
            98 => 'CU',
            99 => 'CV',
            100 => 'CW',
            101 => 'CX',
            102 => 'CY',
            103 => 'CZ',
            104 => 'DA',
            105 => 'DB',
            106 => 'DC',
            107 => 'DD',
            108 => 'DE',
            109 => 'DF',
            110 => 'DG',
            111 => 'DH',
            112 => 'DI',
            113 => 'DJ',
            114 => 'DK',
            115 => 'DL',
            116 => 'DM',
            117 => 'DN',
            118 => 'DO',
            119 => 'DP',
            120 => 'DQ',
            121 => 'DR',
            122 => 'DS',
            123 => 'DT',
            124 => 'DU',
            125 => 'DV',
            126 => 'DW',
            127 => 'DX',
            128 => 'DY',
            129 => 'DZ',
            130 => 'EA',
            131 => 'EB',
            132 => 'EC',
            133 => 'ED',
            134 => 'EE',
            135 => 'EF',
            136 => 'EG',
            137 => 'EH',
            138 => 'EI',
            139 => 'EJ',
            140 => 'EK',
            141 => 'EL',
            142 => 'EM',
            143 => 'EN',
            144 => 'EO',
            145 => 'EP',
            146 => 'EQ',
            147 => 'ER',
            148 => 'ES',
            149 => 'ET',
            150 => 'EU',
            151 => 'EV',
            152 => 'EW',
            153 => 'EX',
            154 => 'EY',
            155 => 'EZ',
            156 => 'FA',
            157 => 'FB',
            158 => 'FC',
            159 => 'FD',
            160 => 'FE',
            161 => 'FF',
            162 => 'FG',
            163 => 'FH',
            164 => 'FI',
            165 => 'FJ',
            166 => 'FK',
            167 => 'FL',
            168 => 'FM',
            169 => 'FN',
            170 => 'FO',
            171 => 'FP',
            172 => 'FQ',
            173 => 'FR',
            174 => 'FS',
            175 => 'FT',
            176 => 'FU',
            177 => 'FV',
            178 => 'FW',
            179 => 'FX',
            180 => 'FY',
            181 => 'FZ',
            182 => 'GA',
            183 => 'GB',
            184 => 'GC',
            185 => 'GD',
            186 => 'GE',
            187 => 'GF',
            188 => 'GG',
            189 => 'GH',
            190 => 'GI',
            191 => 'GJ',
            192 => 'GK',
            193 => 'GL',
            194 => 'GM',
            195 => 'GN',
            196 => 'GO',
            197 => 'GP',
            198 => 'GQ',
            199 => 'GR',
            200 => 'GS',
            201 => 'GT',
            202 => 'GU',
            203 => 'GV',
            204 => 'GW',
            205 => 'GX',
            206 => 'GY',
            207 => 'GZ',
            208 => 'HA',
            209 => 'HB',
            210 => 'HC',
            211 => 'HD',
            212 => 'HE',
            213 => 'HF',
            214 => 'HG',
            215 => 'HH',
            216 => 'HI',
            217 => 'HJ',
            218 => 'HK',
            219 => 'HL',
            220 => 'HM',
            221 => 'HN',
            222 => 'HO',
            223 => 'HP',
            224 => 'HQ',
            225 => 'HR',
            226 => 'HS',
            227 => 'HT',
            228 => 'HU',
            229 => 'HV',
            230 => 'HW',
            231 => 'HX',
            232 => 'HY',
            233 => 'HZ',
            234 => 'IA',
            235 => 'IB',
            236 => 'IC',
            237 => 'ID',
            238 => 'IE',
            239 => 'IF',
            240 => 'IG',
            241 => 'IH',
            242 => 'II',
            243 => 'IJ',
            244 => 'IK',
            245 => 'IL',
            246 => 'IM',
            247 => 'IN',
            248 => 'IO',
            249 => 'IP',
            250 => 'IQ',
            251 => 'IR',
            252 => 'IS',
            253 => 'IT',
            254 => 'IU',
            255 => 'IV',
    );
    
    private static function __init(){
        
        // 创建一个处理对象实例
        self::$objExcel = new PHPExcel();
        
        // 创建文件格式写入对象实例
        self::$objExcel->getProperties()
            ->setCreator("ecargo")
            ->setLastModifiedBy("MaxOu")
            ->setTitle("OfficeXLSTestDocument")
            ->setSubject("OfficeXLSTestDocument,Demo")
            ->setDescription("Testdocument,generatedbyPHPExcel.")
            ->setKeywords("officeexcelPHPExcel")
            ->setCategory("Test");
    }
    

    //数据填充
    private static function __fillData($dataList,$title){
    	$objActSheet = self::$objExcel->getActiveSheet();
    	// 设置当前活动sheet的名称
    	$objActSheet->setTitle($title);
    
    	$columns = current($dataList);
    	$startNum = 0;
    	foreach ($columns as $v => $v0) {
    		$start = self::$excel2003Col[$startNum];
    		$objActSheet->getStyle($start)
    		->getAlignment()
    		->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    		$objActSheet->getStyle($start)
    		->getAlignment()
    		->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    
    		$objActSheet->getColumnDimension($start)->setAutoSize(true); // 内容自适应
    		
    		$objActSheet->getColumnDimension($start)->setWidth(100); // 30宽
    		 
    		// 设置单元格内容由PHPExcel根据传入内容自动判断单元格内容类型
    		$objActSheet->setCellValueExplicit($start . '1', $v); // 字符串内容
    		$startNum ++;
    	}
        $newKey=2;
    	foreach ($dataList as $kk => $column) {
    		$startNum = 0;
    		foreach ($column as $k => $v) {
    			$start = self::$excel2003Col[$startNum];
                //判断是否需要转为数字类型
                if (is_numeric($v) && strlen($v) < 11) {
                    $objActSheet->setCellValue($start . ($newKey), $v); // 数字类型内容
                }else{
                    $objActSheet->setCellValueExplicit($start . ($newKey), $v); // 字符串内容
                }
    			$startNum ++;
    		}
            $newKey++;
    	}
    }
    

    //数据填充，鸟系统导出
    private static function __fillDataNiao($dataList,$title){
        $objActSheet = self::$objExcel->getActiveSheet();
        // 设置当前活动sheet的名称
        $objActSheet->setTitle($title);
    
        $columns = $dataList[0];
        $startNum = 0;
        foreach ($columns as $v => $v0) {
            $start = self::$excel2003Col[$startNum];
            $objActSheet->getStyle($start)
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle($start)
            ->getAlignment()
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    
            $objActSheet->getColumnDimension($start)->setAutoSize(true); // 内容自适应
    
            $objActSheet->getColumnDimension($start)->setWidth(100); // 30宽
             
            // 设置单元格内容由PHPExcel根据传入内容自动判断单元格内容类型
            $objActSheet->setCellValueExplicit($start . '2', $v); // 字符串内容
            $startNum ++;
        }
    
        foreach ($dataList as $kk => $column) {
            $startNum = 0;
            foreach ($column as $k => $v) {
                $start = self::$excel2003Col[$startNum];
                $objActSheet->setCellValueExplicit($start . ($kk + 4), $v); // 字符串内容
                $startNum ++;
            }
        }
    }
    //数据填充
    private static function __fillDataT($dataList,$title='Data'){
        $objActSheet = self::$objExcel->getActiveSheet();
        // 设置当前活动sheet的名称
        $objActSheet->setTitle($title);

        $columns = $dataList;
        $start = 'A';
        $startNum = ord($start);
        $prefix = '';
        $colArr = array();
        foreach ($columns as $v => $v0) {
            $col = $start;
            
            $col = $prefix . $start;
            if ($v > 26) {
                // echo $col;exit;
            }
            //
            $objActSheet->getStyle($col)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objActSheet->getStyle($col)
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            
//             $objActSheet->getColumnDimension($col)->setAutoSize(true); // 内容自适应
            $objActSheet->getColumnDimension($start)->setWidth(30); // 30宽
                                                         
            // 设置单元格内容由PHPExcel根据传入内容自动判断单元格内容类型
            $objActSheet->setCellValueExplicit($col . '1', $v0); // 字符串内容
            //$colArr[] = $v.'=>\''.$col.'\',';
            if ($startNum % 90 == 0) {
                $start = 'A';
                $startNum = ord($start);
               
                $prefix = ! empty($prefix) ? chr(ord($prefix) + 1) : 'A';
//                 echo $prefix;
            }else{
                $startNum ++;
                $start = chr($startNum);
            }          
            
        }
        echo implode(' ', $colArr); exit;
    }

    public static function exportToFile($dataList, $sheetName, $fileName = '', $suffix = 'xls')
    {
        if(empty($fileName)){ // 默认为excel2003
            $fileName = time() . ".xls";
            $localFile = APPLICATION_PATH . '/../data/tpl_c/' . $fileName;
            // 初始化
            self::__init();
            
            self::$objExcel->setActiveSheetIndex(0);
            
            self::__fillData($dataList, $sheetName);
            // 保存
            $objWriter = new PHPExcel_Writer_Excel5(self::$objExcel); // 用于其他版本格式
            $objWriter->save($localFile);
            
            return $localFile;
        }else{
            
            $fileName = $fileName . "." . $suffix;
            $localFile = APPLICATION_PATH . '/../data/tpl_c/' . $fileName;
            
            // 初始化
            self::__init();
            
            self::$objExcel->setActiveSheetIndex(0);
            
            self::__fillData($dataList, $sheetName);
            if($suffix == 'xlsx'){
                // 保存
                $objWriter = new PHPExcel_Writer_Excel2007(self::$objExcel); // 用于其他版本格式
                $objWriter->save($localFile);
            }else{
                // 保存
                $objWriter = new PHPExcel_Writer_Excel5(self::$objExcel); // 用于其他版本格式
                $objWriter->save($localFile);
            }
            return $localFile;
        }
    }

	public static function exportToFileNiao($dataList,$title){
	    $fileName = time () . ".xls";
	    $localFile = APPLICATION_PATH . '/../data/tpl_c/' . $fileName;
	
	    // 初始化
	    self::__init ();
	
	    self::$objExcel->setActiveSheetIndex ( 0 );
	
	    self::__fillDataNiao ( $dataList, $title );
	    // 保存
	    $objWriter = new PHPExcel_Writer_Excel5 ( self::$objExcel ); // 用于其他版本格式
	    $objWriter->save ( $localFile );
	
	    return $localFile;
	}

	//数据填充，鸟系统导出
	private static function __fillDataXlsChange($dataList,$title){
	    $objActSheet = self::$objExcel->getActiveSheet();
	    // 设置当前活动sheet的名称
	    $objActSheet->setTitle($title);
	
	    $columns = $dataList[0];
	    $startNum = 0;
	   
	    foreach ($dataList as $kk => $column) {
	        $startNum = 0;
	        foreach ($column as $k => $v) {
	            $start = self::$excel2003Col[$startNum];
	            $objActSheet->setCellValueExplicit($start . ($kk + 4), $v); // 字符串内容
	            $startNum ++;
	        }
	    }
	}
	public static function xlsChange($fileName,$dataList,$title){
	    $fileName = preg_replace('/\.xls/i', '', $fileName);
	    $fileName = $fileName . ".xls";
	    $localFile = APPLICATION_PATH . '/../data/tpl_c/' . $fileName;
	
	    // 初始化
	    self::__init ();
	
	    self::$objExcel->setActiveSheetIndex ( 0 );
	
	    self::__fillDataXlsChange ( $dataList, $title );
	    // 保存
	    $objWriter = new PHPExcel_Writer_Excel5 ( self::$objExcel ); // 用于其他版本格式
	    $objWriter->save ( $localFile );
	
	    return $localFile;
	}
}