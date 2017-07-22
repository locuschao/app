<?php
$langFiles = array();

// $langFiles[] = include_once 'zh/common.php';
// $langFiles[] = include_once 'zh/product.php';
// $langFiles[] = include_once 'zh/order.php';
// $langFiles[] = include_once 'zh/receiving.php';

/*
 * 扫描文件夹，读取多语言文件，开发时使用，开发后，需合并为一个文件
 */
$dir = dirname(__FILE__) . '/zh/';
$Ld = dir($dir);
while(false !== ($entry = $Ld->read())){
    $checkdir = $dir . "/" . $entry;
    if(preg_match('/\.php$/', $entry)){
        $langFiles[] = include_once $dir.$entry;
    }
}
$Ld->close();

$merge = array();
foreach($langFiles as $lang){
    $merge = array_merge($merge, $lang);
}
return $merge;