<?php

/**
将远程图片下载到本地
 */
class Common_ImageForPrintProcess
{

    private $_savePath = '';

    private $_url_prefix = '';

    public function getSavePath($path = '')
    {
        $this->_savePath = APPLICATION_PATH . '/../public/swfupload/image_for_print/' . $path;
        $this->mkdirs($this->_savePath);
        if (!file_exists($this->_savePath)) {
            throw new Exception($this->_savePath . "\t\t\tnot exist");
        }
        /**
         *  /swfupload/image_for_print/
         */
        $this->_url_prefix = $path;
        return $this->_savePath;
    }

    /**
     * 递归创建路径
     *
     * @param
     *            $path
     */
    public function mkdirs($path)
    {
        if(! file_exists($path)){
            $this->mkdirs(dirname($path));
            mkdir($path, 0777);
        }
    }

    public function log($str)
    {
        if(PHP_SAPI == 'cli'){
			echo '[' . date ( 'Y-m-d H:i:s' ) . ']' . iconv ( 'UTF-8', 'GB2312', $str . "\n" );
        }
    }


    /**
     * 下载远程图片到本地生成缩略图
     */
    public function syncRemoteImageToLocal()
    {
        $pageSize = 200;
        $page = $loop = 1;
        $db = Common_Common::getAdapter();
        $sql = "SELECT count(DISTINCT b.pd_id) from product a INNER JOIN product_images b on a.pd_id=b.pd_id LEFT JOIN product_images_for_print c on b.pd_id=c.pd_id where b.pi_type='link' and c.pd_id is null;";

        $count = $db->fetchOne($sql);

        $pageCount = ceil($count / $pageSize);

        $this->log("总页数：" . $pageCount . " 每页：" . $pageSize);

        while ($page <= $pageCount) {
            $start = ($page - 1) * $pageSize;
            $sql = "SELECT b.pd_id,b.pi_path,b.pi_type,a.product_id,a.product_add_time from product a INNER JOIN product_images b on a.pd_id=b.pd_id LEFT JOIN product_images_for_print c on b.pd_id=c.pd_id where b.pi_type='link' and c.pd_id is null GROUP BY b.pd_id order by pi_id desc limit {$pageSize} OFFSET {$start};";
            $rows = $db->fetchAll($sql);
            $this->log("第" . $page . "页");
            $page++;
            foreach ($rows as $k => $row) {
                $path = date('Y-m-d', strtotime($row['product_add_time'])) . '/' . substr($row["product_id"], -1) . '/';
                $this->getSavePath($path);
                $this->log("下载图片：" . ($k + 1) . '/' . $count);
                try {
                    $img_file = $row['pi_path'];
                    $sql = "select * from product_images_for_print where product_id='{$row['product_id']}';";
                    $exist = $db->fetchRow($sql);
                    if ($exist) {
                        continue;
                    }
                    $url = $this->genThumb($img_file, $row['product_id'], 200, 200);
                    $arr = array(
                        'pd_id' => $row['pd_id'],
                        'product_id' => $row['product_id'],
                        'pi_path' => $url,
                        'pi_type' => 'img',
                        'date_add' => date('Y-m-d H:i:s')
                    );
                    $db->insert('product_images_for_print', $arr);
                } catch (Exception $e) {
                    Ec::showError($e->getMessage() . "\n" . print_r($row, true), 'syncRemoteImageToLocal');
                }
            }
        }
    }
    public function getResource($img_file)
    {
        if(! preg_match('/\.([a-zA-Z-9]+)$/', $img_file, $m)){
            throw new Exception('后缀不合法');
        }
        // print_r($m);
        // exit();
        $ext = strtolower($m[1]);
        switch($ext){
            case 1:
            case 'gif':
                $res = imagecreatefromgif($img_file);
                break;
            
            case 2:
            case 'pjpeg':
            case 'jpeg':
            case 'jpg':
                $res = imagecreatefromjpeg($img_file);
                break;
            
            case 3:
            case 'x-png':
            case 'png':
                $res = imagecreatefrompng($img_file);
                break;
            
            default:
                throw new Exception('后缀不合法');
        }
        // echo 'ddddddddd';
        // var_dump($res);exit;
        return $res;
    }

    /**
     * 缩略图
     *
     * @param $path 图片路径            
     * @param $name 图片名称            
     * @param $width 图片宽度            
     * @param $height 图片高度            
     * @param $bgcolor 图片背景颜色
     *            @判断长和宽的长度，计算比例
     */
    public function genThumb($path, $name, $width, $height, $bgcolor = "FFFFFF")
    {
        $ori_path = $path;
        $org_info = @getimagesize($ori_path);
        $img_org = $this->getResource($ori_path);
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
        $thumb_path = $this->_savePath . $name;
        $filename = "";
        if(function_exists('imagejpeg')){
            $filename .= '.jpg';
            imagejpeg($img_thumb, $thumb_path . $filename, 100);
        }elseif(function_exists('imagegif')){
            $filename .= '.gif';
            imagegif($img_thumb, $thumb_path . $filename);
        }elseif(function_exists('imagepng')){
            $filename .= '.png';
            imagepng($img_thumb, $thumb_path . $filename);
        }
        imagedestroy($img_thumb);
        imagedestroy($img_org);
        //图片本地url
        return $this->_url_prefix . $name . $filename;
    }
}