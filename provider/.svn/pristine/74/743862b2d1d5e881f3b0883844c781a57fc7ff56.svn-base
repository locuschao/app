<?php
/**
 * @desc 数据处理公共类
 * @author Zijie Yuan
 * @date 2016-11-01
 */
class Process_DataProcess {
	const USER_STATUS_POSITIVE = 1;		// 用户已激活

	/**
     * @desc 获取某种状态的用户信息
     * @author Zijie Yuan
     * @date 2016-11-01
     * @param int $status 用户状态(默认为已激活状态)
     * @return array
     */
	public static function getUsersByStatus($status = self::USER_STATUS_POSITIVE) {
		$condition = array('user_status' => $status);
		$columns = array('user_id', 'user_code', 'user_name', 'user_name_en', 'user_status');
		$users = Service_User::getByCondition($condition, $columns, 0, 0);
		return $users;
	}

	/**
     * @desc 根据用户ID获取用户信息
     * @author Zijie Yuan
     * @date 2016-11-01
     * @param int $userId 用户ID
     * @return array
     */
	public static function getUserById($userId){
		$userInfo = array();
		if (empty($userId)) {
			return $userInfo;
		}
		$filedName = 'user_id';
		$columns = array('user_id', 'user_code', 'user_name', 'user_name_en', 'user_status');
		$userInfo = Service_User::getByField($userId, $filedName, $columns);
		return $userInfo;
	}

    /**
     * @desc 生成pdf文件的方法
     * @author gan
     * @date 2017/05/19
     * @return string 生成pdf文件的路径
     */
    public static function createPdfFileAndUrl($base64_datas,$do_id){
        if(empty($base64_datas)){
            return false;
        }
        try{
            $file = APPLICATION_PATH."/../public/pdf/";
            $pdf_path = $file."base64.txt";
            //把获取到的base64编码的数据写入文件$pdf_path中临时保存起来
            $fileContents =  file_put_contents($pdf_path,$base64_datas);
            if($fileContents == false){
                return false;
            }
            //获取写入的base64编码的数据
            $content = file_get_contents($pdf_path);
            //解码
            $word =  base64_decode($content);
            $date =date('Y-m-d',time());
            $dir=$file.$date;
            Common_Common::mkdirs($dir);
            $time=date('YmdHis',time());
            $re = $dir.'/'.$time.".pdf";
            //生成pdf文件
            $result =  file_put_contents($re,$word);
            if($result){
                //生成pdf成功，删除$pdf_path中临时保存base64.txt文件
                unlink ($pdf_path);
                //把生成的pdf文件url地址写入数据库中delivery_order表中
                $url = strstr($re, '/pdf');
                $do_pack_pdf_url = array();
                $do_pack_pdf_url['do_pack_pdf_url'] = $url;
                $deliveryOrder = Service_DeliveryOrder::update($do_pack_pdf_url,$do_id);
                if(!$deliveryOrder){
                    return false;
                }
                return false;
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }


    /**
     *功能:装箱单生成的pdf文件base64_encode编码数据，进行解码
     * @param  param 请求参数
     * @date 2017-5-11
     * @author gan
     * @return string base64_encode解码后的数据
     */
    public static function parseBase64_encode($datas){
        $data  =  base64_decode($datas);
        return $data;
    }


}