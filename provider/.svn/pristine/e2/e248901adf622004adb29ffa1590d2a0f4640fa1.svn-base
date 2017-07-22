<?php
require_once("PHPExcel.php");
require_once("PHPExcel/Reader/Excel2007.php");
require_once("PHPExcel/Reader/Excel5.php");
// require_once ('PHPExcel/IOFactory.php');
class Common_Upload
{
    /**
     * 读取CSV文件
     * @param string $filePath
     * @return array
     */
    public static function readCSV($filePath)
    {
        $content = file_get_contents($filePath);
        $arr = preg_split('/\n/', $content);
        $data = array();
        foreach ($arr as $k => $v) {
            if ($v) {
                $data[] = explode(",", trim($v));
            }
        }
        return $data;
    }

    /**
     * 读取EXCEL文件
     * @param string $filePath
     * @return array 
     */
    public static function readEXCEL($filePath,$sheet=0)
    {
        if(!file_exists($filePath)){
            return 'File Not Exists';
        }

        $PHPExcel = new PHPExcel();
        $PHPReader = new PHPExcel_Reader_Excel2007();
        if (!$PHPReader->canRead($filePath)) {
            $PHPReader = new PHPExcel_Reader_Excel5();
            if (!$PHPReader->canRead($filePath)) {
                return "File Can Not Be Readed.";
            }
        }
        $PHPExcel = $PHPReader->load($filePath);
        if(is_int($sheet)){
            $currentSheet = $PHPExcel->getSheet($sheet);
        }else{
            $currentSheet = $PHPExcel->getSheetByName($sheet);
        }  
        if(empty($currentSheet)){
            return "Sheet Not Exists.";
        }
        $keyArr="A B C D E F G H I J K L M N O P Q R S T U V W X Y Z AA AB AC AD AE AF AG AH AI AJ AK AL AM AN AO AP AQ AR AS AT AU AV AW AX AY AZ BA BB BC BD BE BF BG BH BI BJ BK BL BM BN BO BP BQ BR BS BT BU BV BW BX BY BZ CA CB CC CD CE CF CG CH CI CJ CK CL CM CN CO CP CQ CR CS CT CU CV CW CX CY CZ";
        $keyArr = explode(' ', $keyArr);
        $keyArrFlip = array_flip($keyArr);
        /**取得一共有多少列*/
        $maxColumn = $currentSheet->getHighestColumn();

        //判断是否超出列
        if(!isset($keyArrFlip[$maxColumn])){
            return "out of range";
        }
        /**取得一共有多少行*/
        $rowCount = $currentSheet->getHighestRow();
        $result = array();
        for ($row = 1; $row <= $rowCount; $row++) {
            $totalLen = 0; //记录行总长度
            for ($column = $keyArrFlip['A']; $column <= $keyArrFlip[$maxColumn]; $column++) {
                $value = $currentSheet->getCell($keyArr[$column] . $row)->getValue();
                if (is_object($value)) {
                    $value = $value->__toString();
                }
                $result[$row][] = $value;
                $totalLen += strlen(trim($value));
            }
            if ($totalLen == 0) unset($result[$row]); //去掉空行
        }
        return array_values($result);
    }

    /**
     * @desc 解析文件内容转为数组
     * @tips 将第一行转为Key
     * @param $fileName
     * @param $filePath
     * @return array
     */
    public static function readUploadFile($fileName, $filePath)
    {
        $pathinfo = pathinfo($fileName);
        $fileData = array();

        if (isset($pathinfo["extension"]) && $pathinfo["extension"] == "xls") {
            $fileData = self::readEXCEL($filePath);
        }
        $result = array();
        if (is_array($fileData) && !empty($fileData)) {
            foreach ($fileData[0] as $key => $value) {
                if (isset($columnMap[$value])) {
                    $fileData[0][$key] = $columnMap[$value];
                }
            }
            foreach ($fileData as $key => $value) {
                if ($key == 0) {
                    continue;
                }
                foreach ($value as $vKey => $vValue) {
                    if ($fileData[0][$vKey] == "") continue;
                    $result[$key][$fileData[0][$vKey]] = $vValue;
                }
            }
        }
        return $result;
    }


    /**
     * @desc 解析文件内容转为数组 指定 Sheet
     * @tips 将第一行转为Key
     * @param $fileName
     * @param $filePath
     * @return array
     */
    public static function readUploadFileBySheet($fileName, $filePath, $sheet = 0)
    {
        $pathinfo = pathinfo($fileName);
        $fileData = array();

        if (isset($pathinfo["extension"]) && $pathinfo["extension"] == "xls") {
            $fileData = self::readEXCEL($filePath,$sheet);

        }

        $result = array();
        if (is_array($fileData) && !empty($fileData)) {
            foreach ($fileData[0] as $key => $value) {
                if (isset($columnMap[$value])) {
                    $fileData[0][$key] = $columnMap[$value];
                }
            }
            foreach ($fileData as $key => $value) {
                if ($key == 0) {
                    continue;
                }
                foreach ($value as $vKey => $vValue) {
                    if ($fileData[0][$vKey] == "") continue;
                    $result[$key][$fileData[0][$vKey]] = $vValue;
                }
            }
        }

        return $result;

    }


    /**
     * @desc 解析发货单文件内容转为数组 指定 Sheet
     * @tips 将第一行转为Key
     * @param $fileName
     * @param $filePath
     * @return array
     */
    public static function readUploadFileBySheetNew($fileName, $filePath, $sheet = 0)
    {
        $pathinfo = pathinfo($fileName);
        $fileData = array();

        if (isset($pathinfo["extension"]) && $pathinfo["extension"] == "xls") {
            $fileData = self::readEXCELNew($filePath,$sheet);

        }

        $result = array();
        if (is_array($fileData) && !empty($fileData)) {
            foreach ($fileData[0] as $key => $value) {
                if (isset($columnMap[$value])) {
                    $fileData[0][$key] = $columnMap[$value];
                }
            }
            foreach($fileData[1] as $k => $v){
                if (isset($columnMap[$v])) {
                    $fileData[1][$k] = $columnMap[$v];
                }
            }
            foreach ($fileData as $key => $value) {
                if ($key == 0) {
                    continue;
                }
                foreach ($value as $vKey => $vValue) {
                    if ($fileData[0][$vKey] == "") continue;
                    $result[$key][$fileData[0][$vKey]] = $vValue;
                }
            }
        }


        return $result;

    }


    /**
     * 读取发货单EXCEL文件
     * @param string $filePath
     * @return array
     */
    public static function readEXCELNew($filePath,$sheet=0)
    {
        if(!file_exists($filePath)){
            return 'File Not Exists';
        }

        $PHPExcel = new PHPExcel();
        $PHPReader = new PHPExcel_Reader_Excel2007();
        if (!$PHPReader->canRead($filePath)) {
            $PHPReader = new PHPExcel_Reader_Excel5();
            if (!$PHPReader->canRead($filePath)) {
                return "File Can Not Be Readed.";
            }
        }
        $PHPExcel = $PHPReader->load($filePath);

        if(is_int($sheet)){
            $currentSheet = $PHPExcel->getSheet($sheet);

        }else{
            $currentSheet = $PHPExcel->getSheetByName($sheet);
        }
        if(empty($currentSheet)){
            return "Sheet Not Exists.";
        }
        $keyArr="A B C D E F G H I J K L M N O P Q R S T U V W X Y Z AA AB AC AD AE AF AG AH AI AJ AK AL AM AN AO AP AQ AR AS AT AU AV AW AX AY AZ BA BB BC BD BE BF BG BH BI BJ BK BL BM BN BO BP BQ BR BS BT BU BV BW BX BY BZ CA CB CC CD CE CF CG CH CI CJ CK CL CM CN CO CP CQ CR CS CT CU CV CW CX CY CZ";
        $keyArr = explode(' ', $keyArr);

        $keyArrFlip = array_flip($keyArr);

        /**取得一共有多少列*/
        $maxColumn = $currentSheet->getHighestColumn();


        //判断是否超出列
        if(!isset($keyArrFlip[$maxColumn])){
            return "out of range";
        }
        /**取得一共有多少行*/
        $rowCount = $currentSheet->getHighestRow();

        $result = array();
        $datas = array();
        for ($row =1; $row <= $rowCount; $row++) {
            $totalLen = 0; //记录行总长度
            for ($column = $keyArrFlip['A']; $column <= $keyArrFlip[$maxColumn]; $column++) {
                $value = $currentSheet->getCell($keyArr[$column] . $row)->getValue();
                if (is_object($value)) {
                    $value = $value->__toString();
                }
                $result[$row][] = $value;
                $totalLen += strlen(trim($value));
            }

            if ($totalLen == 0) unset($result[$row]); //去掉空行
        }
        foreach ($result[1] as $k =>$v){
            foreach ($result[2] as $key => $value){
              if($k == $key){
                   $v  = $v.$value;
                  $datas[] = $v;

              }
            }
        }

        $result[1]=$datas;
        unset($result[2]);

        return array_values($result);
    }









}