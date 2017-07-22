<?php
class Common_Common
{

    /**
     * @return mixed
     */
    public static function getIP()
    {
        if (@$_SERVER['HTTP_CLIENT_IP'] && @$_SERVER['HTTP_CLIENT_IP'] != 'unknown') {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (@$_SERVER['HTTP_X_FORWARDED_FOR'] && @$_SERVER['HTTP_X_FORWARDED_FOR'] != 'unknown') {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip ? $ip : '127.0.0.1';
    }

    /**
     * 产生随机字符
     * @param $length
     * @param int $numeric
     * @return string
     */
    public static function random($length, $numeric = 0)
    {
        PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
        $seed = base_convert(md5(print_r($_SERVER, 1) . microtime()), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
        $hash = '';
        $max = strlen($seed) - 1;
        for ($i = 0; $i < $length; $i++) {
            $hash .= $seed[mt_rand(0, $max)];
        }
        return $hash;
    }

    public static function getfname($url)
    {
        // 返回$url最后出现"/"的位置
        $pos = strrpos($url, "/");
        $pos = $pos ? $pos : strrpos($url, "\\");
        $pos = $pos ? $pos : 0;
        if($pos == false){
            $pos = - 1;
        }
        // 取得$url长度
        $len = strlen($url);
        if($len < $pos){
            return false;
        }else{
            // substr截取指定位置指定长度的子字符串
            $filename = substr($url, $pos + 1, $len - $pos - 1);
            return $filename;
        }
    }
    /**
     * 文件下载
     * @param string $realName
     */
    public static function downloadFile($file, $realName = '')
    {
        // if (!is_file($file)) { die("<b>404 File not found!</b>"); }
        // Gather relevent info about file
        $len = filesize($file);
        $filename = self::getfname($file);
        $file_extension = strtolower(substr(strrchr($filename, "."), 1));
        // This will set the Content-Type to the appropriate setting for the file
        switch ($file_extension) {
            case "pdf":
                $ctype = "application/pdf";
                break;
            case "exe":
                $ctype = "application/octet-stream";
                break;
            case "zip":
                $ctype = "application/zip";
                break;
            case "doc":
                $ctype = "application/msword";
                break;
            case "xls":
                $ctype = "application/vnd.ms-excel";
                break;
            case "ppt":
                $ctype = "application/vnd.ms-powerpoint";
                break;
            case "gif":
                $ctype = "image/gif";
                break;
            case "png":
                $ctype = "image/png";
                break;
            case "jpeg":
            case "jpg":
                $ctype = "image/jpg";
                break;
            case "mp3":
                $ctype = "audio/mpeg";
                break;
            case "wav":
                $ctype = "audio/x-wav";
                break;
            case "mpeg":
            case "mpg":
            case "mpe":
                $ctype = "video/mpeg";
                break;
            case "mov":
                $ctype = "video/quicktime";
                break;
            case "avi":
                $ctype = "video/x-msvideo";
                break;
            // The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
            case "php":
            case "htm":
            case "html":
            case "txt":
                die("<b>Cannot be used for " . $file_extension . " files!</b>");
                break;
            default:
                $ctype = "application/force-download";
        }
        ob_end_clean();
        // Begin writing headers
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        // Use the switch-generated Content-Type
        header("Content-Type: $ctype");
        // Force the download
        
        /**
         * Tom 2016-3-23
         * 下载文件时，可能显示的不是文件自身的名称，而是其他名称
         */
        if (!empty($realName)) {
        	$filename = $realName;
        }
        
        $header = "Content-Disposition: attachment; filename=" . $filename . ";";
        header($header);
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $len);
        @readfile($file);
        exit();
    }

    /**
     * 获取服务器IP
     * @return string
     */
    public static function getRealIp()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR')) {
            $ip = getenv('REMOTE_ADDR');
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip?$ip:'127.0.0.1';
    }

    /**
     * 对象转数组
     * @param $obj
     * @return mixed
     */
    public static function objectToArray($obj)
    {
        $arr='';
        $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
        if (is_array($_arr)) {
            foreach ($_arr as $key => $val) {
                $val = (is_array($val) || is_object($val)) ? self::objectToArray($val) : $val;
                $arr[$key] = $val;
            }
        }
        return $arr;
    }

    /*
     * 页面延迟跳转，并提示
     */
    public static function redirect($url, $msg)
    {
        $second = 3;
        $millisecond = $second * 1000;
        // 用html方法实现页面延迟跳转
        echo "<html>\n";
        echo "<head>\n";
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        echo "<meta http-equiv='refresh' content='{$second};url=" . $url . "'>\n";
        echo "</head>\n";
        echo "<body style='text-align:center;padding-top:100px;line-height:25px;'>\n";
        echo $msg . "</br>\n";
        echo "页面将在{$second}秒后自动跳转...</br>\n";
        echo "<a href='" . $url . "'>如果没有跳转，请点这里跳转</a>\n";
        echo "</body>\n";
        echo "</html>\n";
        exit();

        // 用js方法实现页面延迟跳转
        echo $msg . "</br>";
        echo "页面将在3秒后自动跳转...</br>";
        echo "<a href='" . $url . "'>如果没有跳转，请点这里跳转</a>";
        echo "<script language='javascript'>setTimeout(\"window.location.href='" . $url . "'\",{$millisecond})</script>";
        exit();
    }

    /**
     * 字符串截取
     * @param $str
     * @param $len
     * @return string
     */
    public static function utf_substr($str, $len)
    {
        for ($i = 0; $i < $len; $i++) {
            $temp_str = substr($str, 0, 1);
            if (ord($temp_str) > 127) {
                $i++;
                if ($i < $len) {
                    $new_str[] = substr($str, 0, 3);
                    $str = substr($str, 3);
                }
            } else {
                $new_str[] = substr($str, 0, 1);
                $str = substr($str, 1);
            }
        }
        return join('', $new_str);
    }

    //清除wsdl缓存文件
    public static function clearWsdlTmp()
    {
        $dir = ini_get('soap.wsdl_cache_dir'); // 查找跟目录下file文件夹中的文件
        if (is_dir($dir)) {
            if ($dir_handle = opendir($dir)) {
                while (false !== ($file_name = readdir($dir_handle))) {
                    if ($file_name == '.' or $file_name == '..') {
                        continue;
                    } else {
                        //     					echo $file_name."\n";
                        if (preg_match('/^(wsdl).*/', $file_name)) {

                            @unlink($dir . "/" . $file_name);

                        }

                    }
                }
            }
            return true;
        }
        return false;
    }

    //清除wsdl缓存文件
    public static function clearWsdlCacheFile()
    {
        $dir = APPLICATION_PATH . '/../data/cache';
        if (is_dir($dir)) {
            if ($dir_handle = opendir($dir)) {
                while (false !== ($file_name = readdir($dir_handle))) {
                    if ($file_name == '.' or $file_name == '..') {
                        continue;
                    } else {
                        //     					echo $file_name."\n";
                        if (preg_match('/.*(wsdl)$/', $file_name)) {

                            @unlink($dir . "/" . $file_name);

                        }

                    }
                }
            }
            return true;
        }
        return false;
    }

    //清除超时图片缓存文件
    public static function clearImageTempFile()
    {
        $dir = APPLICATION_PATH . '/../data/images/temp';
        if (is_dir($dir)) {
            if ($dir_handle = opendir($dir)) {
                while (false !== ($file_name = readdir($dir_handle))) {
                    if ($file_name == '.' or $file_name == '..') {
                        continue;
                    } else {
                        // echo $file_name."\n";
                        $a = fileatime($dir . "/" . $file_name);
                        if (time() - $a > 3600) {
                            @unlink($dir . "/" . $file_name);
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * 判断是不是soap数组
     * @param array $input
     * @return boolean
     */
    public static function isSoapArray($input)
    {
        if (!is_array($input)) {
            return false;
        }
        $keys = array_keys($input);
        $isInt = true;
        foreach ($keys as $k) {
            if (!is_int($k)) {
                $isInt = false;
            }
        }
        return $isInt;
    }


    /**
     * 判断如果为一维数据转为多维
     * @param $arr
     * @return array
     */
    public static function multiArr($arr)
    {
        $return = array();
        $isMulti = false;
        foreach ($arr as $k => $v) {
            if (is_int($k)) {
                $isMulti = true;
            }
        }
        if (!$isMulti) {
            $return[] = $arr;
        } else {
            $return = $arr;
        }
        return $return;
    }

    /**
     * @param $url
     * @param int $timeout
     * @param array $header
     * @return mixed
     * @throws Exception
     */
    public static function http_request($url, $timeout = 300, $header = array())
    {
        if (!function_exists('curl_init')) {
            throw new Exception('server not install curl');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        $data = curl_exec($ch);
        list ($header, $data) = explode("\r\n\r\n", $data);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code == 301 || $http_code == 302) {
            $matches = array();
            preg_match('/Location:(.*?)\n/', $header, $matches);
            $url = trim(array_pop($matches));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $data = curl_exec($ch);
        }

        if ($data == false) {
            curl_close($ch);
        }
        @curl_close($ch);
        return $data;
    }
    
    /**
     * 获得数据库DB
     * $db->beginTransaction();
     * $db->commit();
     * $db->rollback()
     */
    public static function getAdapter(){
        $table = new DbTable_UserSystem();
        return $table->getAdapter();
//     	return Zend_Registry::get('db');
    }

    //字符串解密加密
    public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
    {
        $ckey_length = 6; // 随机密钥长度 取值 0-32;
        // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
        // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
        // 当此值为 0 时，则不产生随机密钥

        $key = md5($key ? $key : 'EC');
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }


    /**
     * @desc 返回对应Excel的Key
     * @param $rows
     * @return array
     */
    public static function getExcelKey($rows)
    {
        $newRow = array();
        $prefix = $stat = '';
        $num = $ord = 0;
        $limit = 26;
        $stat = 96;
        foreach ($rows as $k => $val) {
            $num++;
            $ord++;
            if ($ord > $limit) {
                $ord = 1;
            }
            $mod = ceil(($num) / $limit);
            if ($mod - 1) {
                $prefix = chr(ord('a') + $mod - 2);
            }
            $newRow[strtoupper($prefix . chr($stat + $ord))] = $k;

            if (strtoupper(chr($stat + $ord)) == 'Z') {
                $stat = 96;
            }
        }
        return $newRow;
    }
    
    //清除文件
    public static function clearFile($uploadDir = '')
    {
    	$dir = APPLICATION_PATH . '/../data/downLoadDir/' . $uploadDir;
    	if (is_dir($dir)) {
    		if ($dir_handle = opendir($dir)) {
    			while (false !== ($file_name = readdir($dir_handle))) {
    				@unlink($dir . "/" . $file_name);
    			}
    		}
    		@rmdir($dir);
    		return true;
    	}
    	return false;
    }
    
    /**
     * 打包zip
     * @param unknown_type $fileName
     * @return zip_file
     */
    public static function zip($fileName = '')
    {
    	require_once 'archive.php';
    	$zip = new zip_file($fileName);
    	$zip->set_options(array('inmemory' => 1, 'recurse' => 0, 'storepaths' => 0));
    	return $zip;
    }

    /**
     * @desc 同步实时汇率
     * @return array/String
     */
    public  static function GetCurrency()
    {
        if (!function_exists('curl_init')) {
            return 'server not install curl';
        }
        $url = "http://download.finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s=USDCNY=x+EURCNY=x+AUDCNY=x+GBPCNY=x+HKDCNY=x+CADCNY=x";
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($handle, CURLOPT_CONNECTTIMEOUT, 300);
        $result = curl_exec($handle);
        @curl_close($handle);
        $rows = explode("\n", $result);
        $curr=array();
        if(is_array($rows)){
            foreach($rows as $row){
                $rArr=explode(',',$row);
                if(isset($rArr[1])){
                    $curr[str_replace('"',"",str_ireplace('CNY=X','',$rArr[0]))]=$rArr[1];
                }
            }
        }
        return $curr;
    }
    
    /**
     * 获取配置
     * @param unknown $attr
     * @return mixed|boolean
     */
    public static function getConfig($attr){
    	$config = Service_Config::getByField($attr,'config_attribute',array('config_value'));
    	if($config){
    		return $config['config_value'];
    	}
    	return false;
    }

    /**
     * @desc 获取销售系统数据库名称
     * @return string
     */
    public static function GetEbDbName()
    {
        $system = Service_UserSystem::getByField('EB','us_code');
        if(!$system){
            throw new Exception('销售系统未配置user_system');
        }
        return $system['us_db'];
//         $logSync = Zend_Registry::get('log-sync');
//         return (isset($logSync->eb->dbname) ? $logSync->eb->dbname : (isset($logSync['eb']['dbname']) ? $logSync['eb']['dbname'] : ''));
    }

    /**
     * 导入EXCEL 日期字段处理
     * @param unknown_type $date
     * @param unknown_type $time
     * @return string|multitype:
     */
    public static function excelTime($date, $time = false)
    {
    	if (is_numeric($date)) {
    		$jd = GregorianToJD(1, 1, 1970);
    		$gregorian = JDToGregorian($jd + intval($date) - 25569);
    		$date = explode('/', $gregorian);
    		$date_str = str_pad($date[2], 4, '0', STR_PAD_LEFT)
    		. "-" . str_pad($date[0], 2, '0', STR_PAD_LEFT)
    		. "-" . str_pad($date[1], 2, '0', STR_PAD_LEFT)
    		. ($time ? " 00:00:00" : '');
    		return $date_str;
    	}
    	return $date;
    }


    /**
     * 检测列是否存在
     */
    public static function checkTableColumnExist($table,$column)
    {
        try{
            $db = Common_Common::getAdapter();
            $sql = "desc {$table}";
           
            $rows = $db->fetchAll($sql);
            $columns = array();
            foreach($rows as $v){
                $columns[] = $v['Field'];
            }
            if(! in_array($column, $columns)){
                $sql = "ALTER TABLE `{$table}` ADD COLUMN $column varchar(200) NULL DEFAULT '' COMMENT ''";
                $db->query($sql);
            }
        }catch(Exception $e){
            
        }
    }



    /**
     * 递归创建路径
     */
    public static function mkdirs($path) {
        if (! file_exists ( $path )) {
            self::mkdirs ( dirname ( $path ) );
            mkdir($path,0777);
            chmod($path,0777);
        }
    }


    /**
     * g
     * @param unknown_type $url
     * @param unknown_type $base64_content
     * @throws Exception
     * @return mixed
     */
    public static function curlRequest($url, $base64_content,$paramArr=array()) {
        // initialise a CURL session
        $connection = curl_init ();
        // set method as POST
        curl_setopt ( $connection, CURLOPT_POST, 1 );
        // curl_setopt ( $connection, CURLOPT_HTTPHEADER, array (
        // 'Content-type: application/x-www-form-urlencoded'
        // ) );
        curl_setopt($connection, CURLOPT_CUSTOMREQUEST, "POST");
        $signature = Common_Company::getCompanyCode();
        $paramArr['order_code'] = $paramArr['order_code']?$paramArr['order_code']:'';
        $params = array(
            'base64_content' => $base64_content,
            'density' => isset($paramArr['density']) ? $paramArr['density'] : 500,
            'signature' => $signature.preg_replace('/[^a-zA-Z0-9]/', 'x', $paramArr['order_code']) . time(),
        );
        // echo $params;exit;
        curl_setopt ( $connection, CURLOPT_POSTFIELDS, $params );
		Common_Common::myEcho($url);
        curl_setopt ( $connection, CURLOPT_URL, $url );

        // stop CURL from verifying the peer's certificate
        curl_setopt ( $connection, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt ( $connection, CURLOPT_SSL_VERIFYHOST, 0 );

        // set it to return the transfer as a string from curl_exec
        curl_setopt ( $connection, CURLOPT_RETURNTRANSFER, 1 );

        // Send the Request
        $response = curl_exec ( $connection );

        // close the connection
        curl_close ( $connection );

        // return the response
        // echo $response;exit;
        $response = json_decode ( $response, true );
        if (empty ( $response )) {
            throw new Exception ( '返回结果错误,请检查请求的URL是否有空格' );
        }
        return $response;
    }

    /**
     * Test if a timestamp matches a cron format or not
     * //$cron = '5 0 * * *';
     */
    public static function is_time_cron($time, $cron)
    {
        $cron_parts = explode(' ', $cron);
        if (count($cron_parts) != 5) {
            return false;
        }

        list($min, $hour, $day, $mon, $week) = explode(' ', $cron);

        $to_check = array('min' => 'i', 'hour' => 'G', 'day' => 'j', 'mon' => 'n', 'week' => 'w');

        $ranges = array(
            'min' => '0-59',
            'hour' => '0-23',
            'day' => '1-31',
            'mon' => '1-12',
            'week' => '0-6',
        );

        foreach ($to_check as $part => $c) {
            $val = $$part;
            $values = array();

            /*
                For patters like 0-23/2
            */
            if (strpos($val, '/') !== false) {
                //Get the range and step
                list($range, $steps) = explode('/', $val);

                //Now get the start and stop
                if ($range == '*') {
                    $range = $ranges[$part];
                }
                list($start, $stop) = explode('-', $range);

                for ($i = $start; $i <= $stop; $i = $i + $steps) {
                    $values[] = $i;
                }
            }
            /*
            For patters like :
            2
            2,5,8
            2-23
            */
            else {
                $k = explode(',', $val);

                foreach ($k as $v) {
                    if (strpos($v, '-') !== false) {
                        list($start, $stop) = explode('-', $v);

                        for ($i = $start; $i <= $stop; $i++) {
                            $values[] = $i;
                        }
                    } else {
                        $values[] = $v;
                    }
                }
            }

            if (!in_array(date($c, $time), $values) and (strval($val) != '*')) {
                return false;
            }
        }

        return true;
    }
    
    /**
     * @desc 删除文件夹内的文件
     * @param $dir
     * @return bool
     */
    public static function delDirFile($dir)
    {
    	if (!file_exists($dir)) {
    		return true;
    	}
    	if (is_dir($dir)) {
    		$dh = opendir($dir);
    		while ($file = readdir($dh)) {
    			if ($file != "." && $file != "..") {
    				$fullpath = $dir . "/" . $file;
    				if (!is_dir($fullpath)) {
    					unlink($fullpath);
    				}
    			}
    		}
    		closedir($dh);
    	}
    }


    /*
     * @desc 命令模式下才输出
     */
    public static function myEcho($str)
    {
        if (PHP_SAPI == 'cli') {
            echo '[' . date('Y-m-d H:i:s') . ']' . iconv('UTF-8', 'GB2312', $str . "\n");
        }
    }

    /**
     * 获取图片绝对路径
     */
    public static function listDir($dir = null)
    {
        $pngList = array();
        if (!file_exists($dir)) {
            return array();
        }
        if (is_dir($dir)) {
            $dir_handle = opendir($dir);
            if ($dir_handle) {
                while (false !== ($file_name = readdir($dir_handle))) {
                    $key = basename($file_name);
                    $keyArr = explode(".", $key);
                    if (isset($keyArr[1]) && $keyArr[0] !== '') {
                        $pngList [$key] = $dir . "/" . $file_name;
                    }
                }
            }
        } else {
            return array();
        }
        ksort($pngList);
        return $pngList;
    }
    
	/**
	 * Reduce a string by the middle, keeps whole words together
	 *
	 * @param string $string
	 * @param int $max (default 50)
	 * @param string $replacement (default [...])
	 * @return string
	 * @author david at ethinkn dot com
	 * @author loic at xhtml dot ne
	 * @author arne dot hartherz at gmx dot net
	 */
	function strMiddleReduceWordSensitive($string, $max = 50, $rep = '...') {
	   $strlen = strlen($string);
	
	   if ($strlen <= $max)
	       return $string;
	
	   $lengthtokeep = $max - strlen($rep);
	   $start = 0;
	   $end = 0;
	
	   if (($lengthtokeep % 2) == 0) {
	       $start = $lengthtokeep / 2;
	       $end = $start;
	   } else {
	       $start = intval($lengthtokeep / 2);
	       $end = $start + 1;
	   }
	
	   $i = $start;
	   $tmp_string = $string;
	   while ($i < $strlen) {
	       if (isset($tmp_string[$i]) and $tmp_string[$i] == ' ') {
	           $tmp_string = substr($tmp_string, 0, $i) . $rep;
	           $return = $tmp_string;
	       }
	       $i++;
	   }
	
	   $i = $end;
	   $tmp_string = strrev ($string);
	   while ($i < $strlen) {
	       if (isset($tmp_string[$i]) and $tmp_string[$i] == ' ') {
	           $tmp_string = substr($tmp_string, 0, $i);
	           $return .= strrev ($tmp_string);
	       }
	       $i++;
	   }
// 	   print_r($string);
// 	   echo ">"
// 	   print_r($start);
// 	   echo ">"
// 	   print_r($end);
// 	   echo ">"
	   
	   return substr($string, 0, $start) . $rep . substr($string, - $end);
	}


	/**
	 * 数组转html,用于打印调试
	 * @param unknown $data
	 * @return mixed
	 */
	public static function arr2html($data){
		$data = print_r($data, true);
		$data = preg_replace('/ /', '&nbsp;', $data);
		$data = preg_replace("/\n/", '<br/>', $data);
		return $data;
	}
	/**
	 * 二维数组取唯一列组成一维数组
	 * @param unknown $arr
	 * @param unknown $column
	 * @return multitype:unknown
	 */
	public static  function array2one($arr,$column){
		$return = array();
		foreach($arr as $v){
			$return[] = $v[$column];
		}
		return $return;
	}
	
	/**
	 * 更换数组的键名
	 * @param unknown $arr
	 * @param unknown $key
	 * @return multitype:unknown
	 */
	public static  function arrayKeyChange($arr,$key){
		$return = array();
		foreach($arr as $v){
			$return[$v[$key]] = $v;
		}
		return $return;
	}



    /**
     * @desc 获取图片文件类型
     * @param string $file
     * @return string
     */
    public static function getFileMimeType($file = '')
    {
        $type = '';
        if (!file_exists($file)) {
            return $type;
        }
        $pathinfo = pathinfo($file);
        $type = isset($pathinfo['extension']) ? $pathinfo['extension'] : $type;
        if (in_array($type, array('jpg', 'jpeg', 'gif', 'png', 'swf', 'bmp')) && function_exists('getimagesize')) {
            $pathinfo = getimagesize($file);
            $mimeArr = explode("/", $pathinfo['mime']);
            $type = isset($mimeArr[1]) ? $mimeArr[1] : $type;
        }
        return $type;
    }

    /**
     * form数组转换
     * 如$product_analysis_wh_extra = array('wh_id'=>array(0=>12,1=>13),'percent'=>array(0=>'10RMB',1=>'50RMB'));
     * 转换为
     * $product_analysis_wh_extra = array(0=>array('wh_id'=>12,'percent'=>'10RMB'),1=>array('wh_id'=>13,'percent'=>'50RMB'));
     * @param unknown $arr
     * @return Ambigous <multitype:, unknown>
     */
    public static function formArrChange($arr){
    	$rs = array();
    	foreach($arr as $k=>$v){
    		foreach($v as $kk=>$vv){
    			$rs[$kk][$k] = $vv;
    		}
    	}
    	return  $rs;
    }
    /**
     * 汇率转换
     * @param unknown $code_start
     * @param unknown $code_end
     * @param unknown $value
     * @return Ambigous <number, string, unknown>
     */
    public static function converByCode($code_start, $code_end, $value){
    	return Service_Currency::converByCode($code_start, $code_end, $value);
    }

    /**
     * @desc 获取本地数据库
     * @return Zend_Db_Adapter_Abstract
     */
    public static function getLdb()
    {
        $server = new Zend_Config_Ini(APPLICATION_PATH . '/../application/configs/db.ini', 'production');
        $params = $server->get('resources')->get('multidb')->get('ldb')->toArray();
        $db = Zend_Db::factory('PDO_MYSQL', $params);
        $db->query('set names utf8');
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        return Zend_Db_Table::getDefaultAdapter();
    }

    
    public static function getCommonDb()
    {
    	$server = new Zend_Config_Ini(APPLICATION_PATH . '/../application/configs/db.ini', 'production');
    	$params = $server->get('resources')->get('multidb')->get('common')->toArray();
    	$db = Zend_Db::factory('PDO_MYSQL', $params);
    	$db->query('set names utf8');
    	Zend_Db_Table_Abstract::setDefaultAdapter($db);
    	return Zend_Db_Table::getDefaultAdapter();
    }
    


    public static function query($sql)
    {
    	$db = Common_Common::getAdapter();
    	$db->query($sql);
    }
    
    public static function fetchRow($sql)
    {
    	$db = Common_Common::getAdapter();
    	$data = $db->fetchRow($sql);
    	return $data;
    }
    
    public static function fetchAll($sql)
    {
    	$db = Common_Common::getAdapter();
    	$data = $db->fetchAll($sql);
    	return $data;
    }
    
    public static function fetchOne($sql)
    {
    	$db = Common_Common::getAdapter();
    	$data = $db->fetchOne($sql);
    	return $data;
    }
    
    /**
     * 获取网络文件类型
     * @param string $url
     * @return string|NULL
     */
   public static function getNetworkFileType($url) {
    	if (function_exists('curl_init'))
    	{
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_URL, $url);
    		curl_setopt($ch, CURLOPT_HEADER, 1);
    		curl_setopt($ch, CURLOPT_NOBODY, 1);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    		$results = explode("\n", trim(curl_exec($ch)));
    		foreach($results as $line) {
    			if (strtok($line, ':') == 'Content-Type') {
    				$parts = explode(":", $line);
    				return trim($parts[1]);
    			}
    		}
    	}else{
    		$url = parse_url($url);
    		if ($fp = @fsockopen($url['host'], empty($url['port']) ? 80 : $url['port'], $error)) {
    			fputs($fp, "GET " . (empty($url['path']) ? '/' : $url['path']) . " HTTP/1.1\r\n");
    			fputs($fp, "Host: {$url['host']}\r\n\r\n");
    			while (!feof($fp)) {
    				$tmp = fgets($fp);
    				if (trim($tmp) == '') {
    					break;
    				} else if (preg_match('/Content-Type:(.*)/si', $tmp, $arr)) {
    					return trim((string)$arr[1]);
    				}
    			}
    			return null;
    		} else {
    			return null;
    		}
    	}
    	return null;
    }
    
    /**
     * @desc UNICODE编码
     * @param string $name
     */
    public static function ecUnicodeEncode($name) {
    	if (empty($name)) {
    		return $name;
    	}
    	
    	$name = iconv('UTF-8', 'UCS-2', $name);
    	$len = strlen($name);
    	$str = '';
    	for ($i = 0; $i < $len - 1; $i = $i + 2)
    	{
    		$c = $name[$i];
    		$c2 = $name[$i + 1];
    		if (ord($c) > 0)
    		{   //两个字节的文字
    			$str .= '\u'.base_convert(ord($c), 10, 16).str_pad(base_convert(ord($c2), 10, 16), 2, 0, STR_PAD_LEFT);
    		}
    		else
    		{
    			$str .= $c2;
    		}
    	}
    	return $str;
    }
    
    /**
     * @desc UNICODE编码解码
     * @param string $name
     */
    public static function ecUnicodeDecode($name) {
    	if (empty($name)) {
    		return $name;
    	}
    	
    	//转换编码，将Unicode编码转换成可以浏览的utf-8编码
    	$pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
    	preg_match_all($pattern, $name, $matches);
    	if (!empty($matches))
    	{
    		$name = '';
    		for ($j = 0; $j < count($matches[0]); $j++)
    		{
    		    $str = $matches[0][$j];
    		    if (strpos($str, '\\u') === 0)
    		    {
    		        $code = base_convert(substr($str, 2, 2), 16, 10);
    			    $code2 = base_convert(substr($str, 4), 16, 10);
    			    $c = chr($code).chr($code2);
    			    $c = iconv('UCS-2', 'UTF-8', $c);
    			    $name .= $c;
    		    }
    		    else
    		    {
    		        $name .= $str;
    		    }
    		}
    	}
    	return $name;
    }
    

    public static function curlRequestForDataMatrix($url, $postData = '', $proxy = "")
    {
    	$proxy = trim($proxy);
    	$user_agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)";
    	$ch = curl_init(); // 初始化CURL 句柄
    	if(! empty($proxy)){
    		curl_setopt($ch, CURLOPT_PROXY, $proxy); // 设置代理服务器
    	}
    	//         echo $url;exit;
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
    	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    
    	curl_setopt($ch, CURLOPT_VERBOSE, true);
    
    	curl_setopt($ch, CURLOPT_HEADER, true); // 请求头是否包含在响应中
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch, CURLOPT_URL, $url); // 设置请求的URL
    	// curl_setopt($ch,
    	// CURLOPT_FAILONERROR, 1); //
    	// 启用时显示HTTP 状态码，默认行为是忽略编号小于等于400
    	// 的HTTP 信息
    	// curl_setopt($ch,
    	// CURLOPT_FOLLOWLOCATION,
    	// 1);//启用时会将服务器服务器返回的“Location:”放在header
    	// 中递归的返回给服务器
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 设为TRUE
    	// 把curl_exec()结果转化为字串，而不是直接输出
    	curl_setopt($ch, CURLOPT_POST, 1); // 启用POST 提交
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); // 设置POST 提交的字符串
    	// curl_setopt($ch,
    	// CURLOPT_PORT, 80);
    	// //设置端口
    	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 60); // 超时时间
    	curl_setopt($ch, CURLOPT_USERAGENT, $user_agent); // HTTP 请求User-Agent:头
    	curl_setopt($ch, CURLOPT_HEADER, false); // 设为TRUE
    	// 在输出中包含头信息
    	// $fp =
    	// fopen("example_homepage.txt",
    	// "w");//输出文件
    	// curl_setopt($ch,
    	// CURLOPT_FILE,
    	// $fp);//设置输出文件的位置，值是一个资源类型，默认为STDOUT
    	// (浏览器)。
    	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    	'Accept-Language: zh-cn',
    	'Connection: Keep-Alive',
    	'Cache-Control: no-cache'
    			)); // 设置HTTP 头信息
    
    	$response = curl_exec($ch); // 执行预定义的CURL
    	if(empty($response)){
    		throw new Exception('service no data response');
    	}
    	$info = curl_getinfo($ch); // 得到返回信息的特性
    	$errno = curl_errno($ch);
    	$error = curl_error($ch);
    	if($errno){
    		throw new Exception($error, $errno);
    	}
    	curl_close($ch);
    	if($info['http_code'] == "405"){
    		throw new Exception("bad proxy {$proxy}", 500);
    	}
    
    	return $response;
    }
    
    /**
     * @desc根据产品、运输方式，获取绑定的箱规
     * @param string $productSku
     * @param string $smCode
     */
    public static function getProductBoxInfo($productSku='', $smCode='0') {
    	$productBox = array();
    	
    	if (!empty($productSku)) {
    		//取配置的箱柜信息
    		$pbpRows = Service_ProductBoxProperty::getByConditionJoinBoxes(array("product_sku"=>$productSku, "sm_code"=>$smCode), array('quantity'));
    		if (!empty($pbpRows)) {
    			if (count($pbpRows)>1) {
    				foreach ($pbpRows as $pbpK=>$pbpV) {
    					if (!empty($pbpV['sm_code'])) $productBox = $pbpV;
    				}
    			} else {
    				$productBox = $pbpRows[0];
    			}
    		}
    	}
    	
    	return $productBox;
    }
    
    /**
     * @desc 获取产品图片实际路径
     * @param int $productId
     */
    public static function getProductImagePath($productId) {
    	$path = '/images/base/noimg.jpg';
    	
    	try {
    		if (!$productId) {
    			throw new Exception('数据异常');
    		}
    		
    		$productRow = Service_Product::getByField($productId, 'product_id');
    		if (!$productRow) {
    			throw new Exception('数据异常');
    		}
    		 
    		/**
    		 * 判断本地图片是否存在
    		 */
    		$db = Common_Common::getAdapter();
    		$sql = "SELECT * FROM `product_images_for_print` WHERE product_id={$productId};";
    		$image = $db->fetchRow($sql);
    		if (!empty($image)) {
    			if ($image['pi_type'] == 'link') {
    				$path = $image['pi_path'];
    			} elseif ($image['pi_type'] == 'img') {
    				$path = '/swfupload/image_for_print/' . $image['pi_path'];
    			} else {
    				throw new Exception('图片类型不正确');
    			}
    		} else {
    			$pdId = $productRow['pd_id'];
    			if (!$pdId) {
    				throw new Exception('不存在产品开发数据');
    			}
    			
    			/**
    			 * 按客户配置产品图片显示，0：显示最后上传的一张图片 1：显示第一张上传的图片      ------------ by tom 2016-8-5
    			 */
    			$configRow = Service_Config::getByField('PRODUCT_IMAGES_SHOW_RULE', 'config_attribute', array('config_value'));
    			$PRODUCT_IMAGES_SHOW_RULE = isset($configRow['config_value']) ? $configRow['config_value'] : '0';
    			if ($PRODUCT_IMAGES_SHOW_RULE == '1') {
    				$orderBy = array("is_main desc","pi_id asc");
    			} else {
    				$orderBy = array("is_main desc","pi_id desc");
    			}
    			
    			$productImage = Service_ProductImages::getByCondition(array("pd_id" => $pdId, "pi_status" => "1"), "*", 1, 1, $orderBy);
    			if (!$productImage) {
    				throw new Exception('产品开发不存在图片');
    			}
    			$image = $productImage[0];
    			if (!$image) {
    				throw new Exception('产品开发不存在图片');
    			}
    			if ($image['pi_type'] == 'link') {
    				$path = $image['pi_path'];
    			} elseif ($image['pi_type'] == 'img') {
    				$config = Zend_Registry::get('server');
    				$path = $config['swfupload']['url_prefix'] . $image['pi_path'];
    			} else {
    				throw new Exception('图片类型不正确');
    			}
    		}
    	} catch(Exception $e) {
    		return $path;
    	}
    	
    	return $path;
    }
    
    /**
     * @desc 获取产品问题图片的真实路径
     * @param int $ptt_id
     */
    public function getProductTroubleImagePath($ptt_id) {
    	$path = realpath(APPLICATION_PATH.'/../public')."/images/base/noimg.jpg";
    	
    	if (empty($ptt_id)) {
    		return $path;
    	}
    	
        $productTroubleImage = Service_ProductTroubleImages::getByCondition(array("ptt_id"=>$ptt_id,"pti_status"=>"1"),"*",0,1,array("pti_id desc"));
        
        if (!empty($productTroubleImage)) {
        	$image = $productTroubleImage[0];
        	if ($image['pti_type'] == 'link') {
        		$path = $image['pti_path'];
        	} elseif ($image['pti_type'] == 'img' && file_exists(APPLICATION_PATH.'/../public/swfupload/upload/product_trouble_images/'.$image['pti_path'])) {
        		$path = realpath(APPLICATION_PATH.'/../public/swfupload/upload/product_trouble_images/'.$image['pti_path']);
        	} else {
        		return $path;
        	}
    	}
    	
    	return $path;
    }
    
    /**
     * Generates an UUID
     * 生成UUID，一个唯一标示符
     * @author     Anis uddin Ahmad
     * @param      string  an optional prefix	前缀
     * @return     string  the formatted uuid
     */
    public static function uuid($prefix = ''){
    	$chars = md5(uniqid(mt_rand(), true));
    	$uuid  = substr($chars,0,8) . '-';
    	$uuid .= substr($chars,8,4) . '-';
    	$uuid .= substr($chars,12,4) . '-';
    	$uuid .= substr($chars,16,4) . '-';
    	$uuid .= substr($chars,20,12);
    	return $prefix . $uuid;
    }
    

    /**
     * 将一维数组条件整理成SQL中 in 需要的格式
     * @param array $arr
     */
    public static function makeConForIn($arr){
    	$sql="('";
    	if(!empty($arr) && is_array($arr)){
    		foreach ($arr as $v){
    			$sql .= $v."','";
    		}
    	}else{
    		return "(' null ')";
    	}
    	$sql=trim($sql,",'")."'";
    	$sql .= ')';
    	return $sql;
    }

    /**
     * @desc 获取二维数组某个key的集合(php版本>=5.5.0可以用array_column函数)
     * @param array $source 源数据（一个二维数组）
     * @param string $key 需要匹配的key
     * @return array key对应的数据集合
     * @date 2016-11-03
     */
    public static function getArrayColumn($source, $key){
        if(version_compare(PHP_VERSION, '5.5.0') >= 0){
            return array_column($source, $key);
        }
        $sets = array();
        if(!empty($source) && is_array($source)){
            $sets = array_reduce($source, function($result, $item) use ($key){
                if(array_key_exists($key, $item)){
                    $result[] = $item[$key];
                }
                return $result;
            });
        }
        return $sets;
    }

    /**
     * @desc 将查询结果数组变成以某个值为键的带键数组
     * @param array $queryArray 查询结果数组
     * @param mixed $keyColumn 其值要作为键的列名string或下标int
     * @param bool $isUnset 是否删除作为键的值
     * @param bool $isMerge 是否合并成键值对（数组只有两个值时）
     * @return array $resultArray 转换后的键值对数组
     * @date 2016-11-02
     */
    public static function arrayWithKey($queryArray, $keyColumn, $isUnset = false, $isMerge = false){
        if(empty($queryArray) || !is_array($queryArray) || empty($keyColumn)){
            return false;
        }
        $resultArray = array();
        foreach ($queryArray as $row) {
            $resultKey = $row[$keyColumn];
            if($isUnset){
                unset($row[$keyColumn]);
            }
            if($isMerge && count($row) === 1){
                $row = array_pop($row);
            }
            $resultArray[$resultKey] = $row;
        }
        return $resultArray;
    }

    /**
     * @desc 判断数组里是否存在该键值对应的元素
     * @param array $searchArray 要查找的数组
     * @param string $key 要查找的键值
     * @param $default 不存在时候的默认值
     * @return mixed，有值则返回，其余返回默认值
     * @date 2017-03-24
     */
    public static function getArrayValue($searchArray, $key, $default = ''){
        if(!is_array($searchArray) || empty($searchArray) || !isset($key)){
            return $default;
        }
        $returnValue = $default;
        if(array_key_exists($key, $searchArray)){
            $returnValue = $searchArray[$key];
            if($searchArray[$key] === '' || $searchArray[$key] === NULL){
                // 空字符窜返回默认值
                $returnValue = $default;
            }
            if(is_array($searchArray[$key]) && empty($searchArray[$key])){
                // 空数组返回默认值
                $returnValue = $default;
            }
        }
        return $returnValue;
    }

    /**
     * @des数组转化为对象
     * @param $array array
     * @return  object
     * @date 2017-5-12
     */
    public static function arrayToObject($array) {
        if (is_array($array)) {
            $obj = new StdClass();
            foreach ($array as $key => $val){
                $obj->$key = $val;
            }
        }
        else { $obj = $array; }
        return $obj;
    }
}