<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: function_ftp.php 10951 2009-01-12 01:59:43Z zhengqingpeng $
*/
$_SGLOBAL = array();

function initFtp($selectFtp='us'){
	global $_SGLOBAL;
	
    $ftpConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/ftp.ini', APPLICATION_ENV);
    $ftpConfig = $ftpConfig->toArray();
    $ftpConfig = $ftpConfig['ftp'];
    
    $_SGLOBAL['setting'] = $ftpConfig[$selectFtp];
}

function getFtpHost(){
	global $_SGLOBAL;
	    
	return $_SGLOBAL['setting']['ftpurl'];
}

//保存图片
function pic_save($FILE,$param) {
        
    // 判断后缀
    $fileext = fileext($FILE['name']);
    
    // 获取目录
    $filepath = getfilepath($fileext,true);
    

    
    // 相册选择
    $serverConfig = Zend_Registry::get('server');
    // 本地上传
    $new_name =  $serverConfig['swfupload']['path']. $filepath;

    Ec::showError(print_r($new_name,true),'swf_');
//     print_r($serverConfig['swfupload']['path'].$filepath);exit;
    $tmp_name = $FILE['tmp_name'];
    if(@copy($tmp_name, $new_name)){
        @unlink($tmp_name);
    }elseif((function_exists('move_uploaded_file') && @move_uploaded_file($tmp_name, $new_name))){
        
    }elseif(@rename($tmp_name, $new_name)){
        
    }else{
        return 0;
    }
    
    // 检查是否图片
    if(function_exists('getimagesize')){
        $tmp_imagesize = @getimagesize($new_name);
        list($tmp_width,$tmp_height,$tmp_type) = (array)$tmp_imagesize;
        $tmp_size = $tmp_width * $tmp_height;
        if($tmp_size > 16777216 || $tmp_size < 4 || empty($tmp_type) || strpos($tmp_imagesize['mime'], 'flash') > 0){
            @unlink($new_name);
            return 0;
        }
    }
    
    $row = array(
        'pi_product_code' => isset($param['product_code'])?$param['product_code']:'',
        'pd_id' => isset($param['pd_id'])?$param['pd_id']:'0',
        'pi_status' => isset($param['status'])?$param['status']:'0',
        'pi_path' => $filepath,
        'pi_source' => isset($param['source'])?$param['source']:'3',
        'pi_status' => isset($param['pi_status'])?$param['pi_status']:'0',
        'date_add' => date('Y-m-d H:i:s'),
        'date_realese' => '',
    );
    if(!$pi_id = Service_ProductImages::add($row)){
        @unlink($new_name);
        return 0;
    } else {
    	if ($param['pd_id']) {
    		//记录日志
    		if ($row['pi_type']=='link') {
    			$pl_note = "修改新增图片为：" . $row['pi_path'];
    		} else {
    			$pl_note = "修改新增图片为：" . substr($row['pi_path'], (strripos($row['pi_path'], "/")+1));
    		}
    		 
    		$productRow = Service_Product::getByField($row['pd_id'], 'pd_id', array('product_id'));
    		//记录日志
    		$logRow = array(
    				'product_id' => $productRow['product_id'],
    				'pl_type' => '0',
    				'user_id' => Service_User::getUserId(),
    				'pl_statu_pre' => "0",
    				'pl_statu_now' => "0",
    				'pl_note' => $pl_note,
    				'pl_add_time' => date('Y-m-d H:i:s'),
    				'pl_ip' => Common_Common::getRealIp(),
    				'customer_id'=>""
    		);
    		 
    		Service_ProductLog::add($logRow);
    	}
    	
    }
    
    $row['pi_id'] = $pi_id;
    return $row;
}

//供应商图片上传
function supplier_pic_save($FILE,$param) {
	
    // 判断后缀
    $fileext = fileext($FILE['name']);
    
    // 获取目录
    $filepath = getfilepath($fileext,true);
    
    // 相册选择
    $serverConfig = Zend_Registry::get('server');
    // 本地上传
    $new_name =  $serverConfig['swfupload']['path']. $filepath;

    $tmp_name = $FILE['tmp_name'];
    if(@copy($tmp_name, $new_name)){
        @unlink($tmp_name);
    }elseif((function_exists('move_uploaded_file') && @move_uploaded_file($tmp_name, $new_name))){
        
    }elseif(@rename($tmp_name, $new_name)){
        
    }else{
        return 0;
    }
    
    // 检查是否图片
    if(function_exists('getimagesize')){
        $tmp_imagesize = @getimagesize($new_name);
        list($tmp_width,$tmp_height,$tmp_type) = (array)$tmp_imagesize;
        $tmp_size = $tmp_width * $tmp_height;
        if($tmp_size > 16777216 || $tmp_size < 4 || empty($tmp_type) || strpos($tmp_imagesize['mime'], 'flash') > 0){
            @unlink($new_name);
            return 0;
        }
    }
    
    $row = array(
        'supplier_id' => isset($param['supplier_id'])?$param['supplier_id']:'0',
    	'si_type' => 'img',
        'si_path' => $filepath,
        'si_add_time' => date('Y-m-d H:i:s'),
    	'si_add_user' => isset($param['pi_add_user'])?$param['pi_add_user']:'0',
    );
    
    if(!$si_id = Service_SupplierImages::add($row)){
        @unlink($new_name);
        return 0;
    }

    $row['si_id'] = $si_id;
    return $row;
}


//FTP上传
function ftpupload($source, $dest) {
	global $_SGLOBAL;

	if(empty($_SGLOBAL['ftpconnid']) && !($_SGLOBAL['ftpconnid'] = sftp_connect())) {
		return 0;
	} else {
		$ftpconnid = $_SGLOBAL['ftpconnid'];
	}
// 	print_r($_SGLOBAL);exit;
	$ftppwd = FALSE;
	$tmp = explode('/', $dest);
	$dest = array_pop($tmp);

	foreach ($tmp as $tmpdir) {
		if(!sftp_chdir($ftpconnid, $tmpdir)) {
			if(!sftp_mkdir($ftpconnid, $tmpdir)) {
				runlog('FTP', "MKDIR '$tmpdir' ERROR.", 0);
				return 0;
			}
			if(!function_exists('ftp_chmod') || !sftp_chmod($ftpconnid, 0777, $tmpdir)) {
				sftp_site($ftpconnid, "'CHMOD 0777 $tmpdir'");
			}
			if(!sftp_chdir($ftpconnid, $tmpdir)) {
				runlog('FTP', "CHDIR '$tmpdir' ERROR.", 0);
				return 0;
			}
			sftp_put($ftpconnid, 'index.htm', APPLICATION_PATH.'/../data/index.htm', FTP_BINARY);
		}
	}
//     print_r($tmp);exit;
	if(sftp_put($ftpconnid, $dest, $source, FTP_BINARY)) {
		if(file_exists($source.'.thumb.jpg')) {
			if(sftp_put($ftpconnid, $dest.'.thumb.jpg', $source.'.thumb.jpg', FTP_BINARY)) {
				@unlink($source);
				@unlink($source.'.thumb.jpg');
				sftp_close($ftpconnid);
				return 1;
			} else {
				sftp_delete($ftpconnid, $dest);
			}
		} else {
			@unlink($source);
			sftp_close($ftpconnid);
			return 1;
		}
	}
	runlog('FTP', "Upload '$source' To '$dest' error.", 0);
	return 0;
}

//FTP连接
function sftp_connect() {
	global $_SGLOBAL;

	@set_time_limit(0);

	$func = $_SGLOBAL['setting']['ftpssl'] && function_exists('ftp_ssl_connect') ? 'ftp_ssl_connect' : 'ftp_connect';
	if($func == 'ftp_connect' && !function_exists('ftp_connect')) {
		runlog('FTP', "FTP NOT SUPPORTED.", 0);
	}
	if($ftpconnid = @$func($_SGLOBAL['setting']['ftphost'], intval($_SGLOBAL['setting']['ftpport']), 20)) {
		if($_SGLOBAL['setting']['ftptimeout'] && function_exists('ftp_set_option')) {
			@ftp_set_option($ftpconnid, FTP_TIMEOUT_SEC, $_SGLOBAL['setting']['ftptimeout']);
		}
		if(sftp_login($ftpconnid, $_SGLOBAL['setting']['ftpuser'], $_SGLOBAL['setting']['ftppassword'])) {
			if($_SGLOBAL['setting']['ftppasv']) {
				sftp_pasv($ftpconnid, TRUE);
			}
			if(sftp_chdir($ftpconnid, $_SGLOBAL['setting']['ftpdir'])) {
				return $ftpconnid;
			} else {
				runlog('FTP', "CHDIR '{$_SGLOBAL[setting][ftpdir]}' ERROR.", 0);
			}
		} else {
			runlog('FTP', '530 NOT LOGGED IN.', 0);
		}
	} else {
		runlog('FTP', "COULDN'T CONNECT TO {$_SGLOBAL[setting][ftphost]}:{$_SGLOBAL[setting][ftpport]}.", 0);
	}
	sftp_close($ftpconnid);
	return -1;
}
//产生随机字符
function random($length, $numeric = 0) {
    PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
    $seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
    $hash = '';
    $max = strlen($seed) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $seed[mt_rand(0, $max)];
    }
    return $hash;
}

//获取上传路径
function getfilepath0($fileext) {
    global $_SGLOBAL;

    $filepath = time().'_'.random(5).".$fileext";
    $name1 = gmdate('Ym');
    $name2 = gmdate('d');    
    return $name1.'/'.$name2.'/'.$filepath;
}

//获取上传路径
function getfilepath($fileext, $mkdir=false) {
    global $_SGLOBAL;

    $filepath = time().'_'.random(5).".$fileext";
    $name1 = gmdate('Ym');
    $name2 = gmdate('d');

    $serverConfig = Zend_Registry::get('server'); 
    if($mkdir) {
        $newfilename = $serverConfig['swfupload']['path'].'./'.$name1;
        if(!is_dir($newfilename)) {
            if(!@mkdir($newfilename)) {
                runlog('error', "DIR: $newfilename can not make");
                return $filepath;
            }
        }
        $newfilename .= '/'.$name2;
        if(!is_dir($newfilename)) {
            if(!@mkdir($newfilename)) {
                runlog('error', "DIR: $newfilename can not make");
                return $name1.'/'.$filepath;
            }
        }
    }
    return $name1.'/'.$name2.'/'.$filepath;
}
//获取文件名后缀
function fileext($filename) {
    return strtolower(trim(substr(strrchr($filename, '.'), 1)));
}

function sftp_mkdir($ftp_stream, $directory) {
	$directory = wipespecial($directory);
	return @ftp_mkdir($ftp_stream, $directory);
}

function sftp_rmdir($ftp_stream, $directory) {
	$directory = wipespecial($directory);
	return @ftp_rmdir($ftp_stream, $directory);
}

function sftp_put($ftp_stream, $remote_file, $local_file, $mode, $startpos = 0 ) {
	$remote_file = wipespecial($remote_file);
	$local_file = wipespecial($local_file);
	$mode = intval($mode);
	$startpos = intval($startpos);
// 	var_dump($local_file);exit;
	return @ftp_put($ftp_stream, $remote_file, $local_file, $mode, $startpos);
}

function sftp_size($ftp_stream, $remote_file) {
	$remote_file = wipespecial($remote_file);
	return @ftp_size($ftp_stream, $remote_file);
}

function sftp_close($ftp_stream) {
	return @ftp_close($ftp_stream);
}

function sftp_delete($ftp_stream, $path) {
	$path = wipespecial($path);
	return @ftp_delete($ftp_stream, $path);
}

function sftp_get($ftp_stream, $local_file, $remote_file, $mode, $resumepos = 0) {
	$remote_file = wipespecial($remote_file);
	$local_file = wipespecial($local_file);
	$mode = intval($mode);
	$resumepos = intval($resumepos);
	return @ftp_get($ftp_stream, $local_file, $remote_file, $mode, $resumepos);
}

function sftp_login($ftp_stream, $username, $password) {
	$username = wipespecial($username);
	$password = str_replace(array("\n", "\r"), array('', ''), $password);
	return @ftp_login($ftp_stream, $username, $password);
}

function sftp_pasv($ftp_stream, $pasv) {
	$pasv = intval($pasv);
	return @ftp_pasv($ftp_stream, $pasv);
}

function sftp_chdir($ftp_stream, $directory) {
	$directory = wipespecial($directory);
	return @ftp_chdir($ftp_stream, $directory);
}

function sftp_site($ftp_stream, $cmd) {
	$cmd = wipespecial($cmd);
	return @ftp_site($ftp_stream, $cmd);
}

function sftp_chmod($ftp_stream, $mode, $filename) {
	$mode = intval($mode);
	$filename = wipespecial($filename);
	if(function_exists('ftp_chmod')) {
		return @ftp_chmod($ftp_stream, $mode, $filename);
	} else {
		return sftp_site($ftp_stream, 'CHMOD '.$mode.' '.$filename);
	}
}

function wipespecial($str) {
	return str_replace(array("\n", "\r"), array('', '', ''), $str);
}
function runlog($type,$log,$level=0){
    Ec::showError($log,$type.'_');
}
?>