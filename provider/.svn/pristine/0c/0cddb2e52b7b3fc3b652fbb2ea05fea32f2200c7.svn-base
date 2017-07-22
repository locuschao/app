<?php

class Common_ImageExcuteService
{

    /**
     * 修改一个图片 让其翻转指定度数
     *
     * @param string $filename 文件名（包括文件路径）
     * @param  float $degrees 旋转度数
     * @return boolean
     */
    public static function flip($filename, $src, $degrees = 90)
    {
        // 读取图片
        $data = @getimagesize($filename);
        if ($data == false)
            return false;
        // 读取旧图片
        switch ($data[2]) {
            case 1:
                $src_f = imagecreatefromgif($filename);
                break;
            case 2:
                $src_f = imagecreatefromjpeg($filename);
                break;
            case 3:
                $src_f = imagecreatefrompng($filename);
                break;
        }
        if ($src_f == "")
            return false;
        $rotate = @imagerotate($src_f, $degrees, 0);
        if (!imagegif($rotate, $src)) {
            return false;
        }
        @imagedestroy($rotate);
        return true;
    }


    /*

    * 功能：PHP图片水印 (水印支持图片或文字)

    * 参数：

    *$groundImage 背景图片，即需要加水印的图片，暂只支持GIF,JPG,PNG格式；

    *$waterPos水印位置，有10种状态，0为随机位置；

    *1为顶端居左，2为顶端居中，3为顶端居右；

    *4为中部居左，5为中部居中，6为中部居右；

    *7为底端居左，8为底端居中，9为底端居右；

    *$waterImage图片水印，即作为水印的图片，暂只支持GIF,JPG,PNG格式；

    *$waterText文字水印，即把文字作为为水印，支持ASCII码，不支持中文；

    *$textFont文字大小，值为1、2、3、4或5，默认为5；

    *$textColor文字颜色，值为十六进制颜色值，默认为#FF0000(红色)；

    *

    * 注意：Support GD 2.0，Support FreeType、GIF Read、GIF Create、JPG 、PNG

    *$waterImage 和 $waterText 最好不要同时使用，选其中之一即可，优先使用 $waterImage。

    *当$waterImage有效时，参数$waterString、$stringFont、$stringColor均不生效。

    *加水印后的图片的文件名和 $groundImage 一样。

    * 作者：longware @ 2004-11-3 14:15:13

    */

    public static function imageWaterMark($groundImage, $waterPos = 0, $waterImage = "", $waterText = "", $textFont = 20, $textColor = "#000000", $customX = 0, $customY = 0)
    {

        $isWaterImage = false;

        $formatMsg = "暂不支持该文件格式，请用图片处理软件将图片转换为GIF、JPG、PNG格式。";

        //读取水印文件

        if (!empty($waterImage) && file_exists($waterImage)) {

            $isWaterImage = TRUE;

            $water_info = getimagesize($waterImage);

            $water_w = $water_info[0]; //取得水印图片的宽

            $water_h = $water_info[1]; //取得水印图片的高

            switch ($water_info[2]) //取得水印图片的格式

            {

                case 1:
                    $water_im = imagecreatefromgif($waterImage);
                    break;

                case 2:
                    $water_im = imagecreatefromjpeg($waterImage);
                    break;

                case 3:
                    $water_im = imagecreatefrompng($waterImage);
                    break;

                default:
                    die($formatMsg);

            }

        }

        //读取背景图片

        if (!empty($groundImage) && file_exists($groundImage)) {

            $ground_info = getimagesize($groundImage);

            $ground_w = $ground_info[0]; //取得背景图片的宽

            $ground_h = $ground_info[1]; //取得背景图片的高

            switch ($ground_info[2]) //取得背景图片的格式

            {

                case 1:
                    $ground_im = imagecreatefromgif($groundImage);
                    break;

                case 2:
                    $ground_im = imagecreatefromjpeg($groundImage);
                    break;

                case 3:
                    $ground_im = imagecreatefrompng($groundImage);
                    break;

                default:
                    die($formatMsg);

            }

        } else {

            die("需要加水印的图片不存在！");

        }

        //水印位置

        if ($isWaterImage) //图片水印

        {

            $w = $water_w;

            $h = $water_h;

            $label = "图片的";

        } else //文字水印

        {
            $temp = imagettfbbox(ceil($textFont),0,APPLICATION_PATH . "/../data/STSONG.TTF",$waterText); // 取得使用 TrueType 字体的文本的范围

            $w = $temp[2] - $temp[6];

            $h = $temp[3] - $temp[7];

            unset($temp);

            $label = "文字区域";

        }

        if (($ground_w < $w) || ($ground_h < $h)) {

            echo "需要加水印的图片的长度或宽度比水印" . $label . "还小，无法生成水印！";

            return;

        }

        switch ($waterPos) {

            case 0: //随机

                $posX = rand(0, ($ground_w - $w));

                $posY = rand(0, ($ground_h - $h));

                break;

            case 1: //1为顶端居左

                $posX = 2;

                $posY = 5;

                break;

            case 2: //2为顶端居中

                $posX = ($ground_w - $w) / 2;

                $posY = 0;

                break;

            case 3: //3为顶端居右

                $posX = $ground_w - $w;

                $posY = 0;

                break;

            case 4: //4为中部居左

                $posX = 0;

                $posY = ($ground_h - $h) / 2;

                break;

            case 5: //5为中部居中

                $posX = ($ground_w - $w) / 2;

                $posY = ($ground_h - $h) / 2;

                break;

            case 6: //6为中部居右

                $posX = $ground_w - $w - 70 - $customX;

                $posY = (($ground_h - $h) / 2) - $customY;
                break;

            case 7: //7为底端居左

                $posX = 20;

                $posY = $ground_h - $h - 15;

                break;

            case 8: //8为底端居中

                $posX = ($ground_w - $w) / 2;

                $posY = $ground_h - $h;

                break;

            case 9: //9为底端居右

                $posX = $ground_w - $w - 70-$customX; // -10 是距离右侧10px 可以自己调节

                $posY = $ground_h - $h - 15 - $customY; // -10 是距离底部10px 可以自己调节

                break;

            //自定义
            case 10: //6为中部居右

                $posX = $ground_w - $customX;

                $posY = $ground_h - $customY;

                break;

            default: //随机

                $posX = rand(0, ($ground_w - $w));

                $posY = rand(0, ($ground_h - $h));

                break;

        }

        //设定图像的混色模式

        imagealphablending($ground_im, true);

        if ($isWaterImage) //图片水印

        {

            imagecopy($ground_im, $water_im, $posX, $posY, 0, 0, $water_w, $water_h); //拷贝水印到目标文件

        } else //文字水印

        {

            if (!empty($textColor) && (strlen($textColor) == 7)) {

                $R = hexdec(substr($textColor, 1, 2));

                $G = hexdec(substr($textColor, 3, 2));

                $B = hexdec(substr($textColor, 5));

            } else {

                die("水印文字颜色格式不正确！");

            }

           //imagestring($ground_im, $textFont, $posX, $posY, $waterText, imagecolorallocate($ground_im, $R, $G, $B));
           imagettftext($ground_im, $textFont, 0, $posX, $posY, imagecolorallocate($ground_im, $R, $G, $B), APPLICATION_PATH . "/../data/STSONG.TTF", $waterText);
        }

        //生成水印后的图片

        @unlink($groundImage);

        switch ($ground_info[2]) //取得背景图片的格式

        {

            case 1:
                imagegif($ground_im, $groundImage);
                break;

            case 2:
                imagejpeg($ground_im, $groundImage);
                break;

            case 3:
                imagepng($ground_im, $groundImage);
                break;

            default:
                die("背景图片格式异常");

        }

        //释放内存

        if (isset($water_info)) unset($water_info);

        if (isset($water_im)) imagedestroy($water_im);

        unset($ground_info);

        imagedestroy($ground_im);

    }

    public static function resizeImage($imgname, $minwidth, $minheight)
    {
        $im = imagecreatefromgif($imgname);
        $pic_width = imagesx($im);
        $pic_height = imagesy($im);

        if (($minwidth && $pic_width < $minwidth) || ($minheight && $pic_height < $minheight)) {
            if ($minwidth && $pic_width < $minwidth) {
                $widthratio = $minwidth / $pic_width;
                $resizewidth_tag = true;
            }
            if ($minheight && $pic_height < $minheight) {
                $heightratio = $minheight / $pic_height;
                $resizeheight_tag = true;
            }
            if ($resizewidth_tag && $resizeheight_tag) {
                if ($widthratio > $heightratio)
                    $ratio = $widthratio;
                else
                    $ratio = $heightratio;
            }
            if ($resizewidth_tag && !$resizeheight_tag)
                $ratio = $widthratio;
            if ($resizeheight_tag && !$resizewidth_tag)
                $ratio = $heightratio;
            $newwidth = $pic_width * $ratio;
            $newheight = $pic_height * $ratio;
            if (function_exists("imagecopyresampled")) {
                $newim = imagecreatetruecolor($newwidth, $newheight);
                imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
            } else {
                $newim = imagecreate($newwidth, $newheight);
                imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
            }
            imagegif($newim, $imgname);
            imagedestroy($newim);
        }
    }


}