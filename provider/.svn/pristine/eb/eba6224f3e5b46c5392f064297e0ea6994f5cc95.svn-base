<?php

class Common_DataCache
{

    /*
     * 清除全部缓存
     */
    public static function clean($subDir = '', $directoryLevel = 0)
    {
        $cache = Ec::cache($subDir, $directoryLevel);
        return $cache->clean('all');
    }

    /*
     * 清除全部基础缓存
     */
    public static function baseClean($subDir = '', $directoryLevel = 0)
    {
        $cache = Ec::baseCache($subDir, $directoryLevel);
        return $cache->clean('all');
    }

    /*
     * 清除全部基础缓存
     */
    public static function allClean()
    {
        $dir = APPLICATION_PATH . "/../data/cache";
        $Ld = dir($dir);
        while (false !== ($entry = $Ld->read())) {
            $checkdir = $dir . "/" . $entry;
            if (is_dir($checkdir) && ! preg_match("[^\.]", $entry)) {
                self::baseClean($entry,0);
            }
        }
        $Ld->close();
    }

    /*
     * 获取产品问题类型
     */
    public static function getProductTroubleType($operation = 0, $erpCode, $token,$erpUrl) {
        $cacheName = 'FEEDBACK_ERROR_TYPE_'.$erpCode;
        $cache = Ec::cache('feedback');
        if ($operation == 1) {
            $cache->remove($cacheName);
        }
        if (!$result = $cache->load($cacheName)) {
            $params = array(
                'erp_url'=> $erpUrl,
                'supplierToken' => $token,
                'service' => 'getProductTroubleType'
            );
            $results = Process_ApiProcess::getProductTroubleType($params);
            if (empty($results)) {
                return false;
            }
            foreach ($results as $key => $value) {
                $result[$value['pteId']] = $value['pteNameCn'];
            }
            $cache->setLifetime(24 * 3600);
            $cache->save($result, $cacheName);
        }
        return $result;
    }

    /*
     * 获取产品问题处理方式
     */
    public static function getproductTroubleProcess($operation = 0, $erpCode, $token,$erpUrl) {
        $cacheName = 'FEEDBACK_TROUBLE_PROCESS_TYPE_'.$erpCode;
        $cache = Ec::cache('feedback');
        if ($operation == 1) {
            $cache->remove($cacheName);
        }
        if (!$result = $cache->load($cacheName)){
            $params = array(
                'erp_url'=> $erpUrl,
                'supplierToken' => $token,
                'service' => 'getproductTroubleProcess'
            );

            $results = Process_ApiProcess::getproductTroubleProcess($params);
            if (empty($results)) {
                return false;
            }
            foreach ($results as $key => $value) {
                $result[$value['ptpId']] = $value['ptpNameCn'];
            }
            $cache->setLifetime(24 * 3600);
            $cache->save($result, $cacheName);
        }
        return $result;
    }
}