<?php

class Common_Factory {
    public static function factoryMethod ($customClass,$construct,$model='Service') {
        if (class_exists($customClass,false)) {
            $obj = new $customClass($construct);
        } else {
            $config = Zend_Registry::get('config');
            $customModule=$config->customModule;
            $customClass=$model.preg_replace("/Custom_".$customModule."/","",$customClass);
            $obj = new $customClass($construct);
        }
        return $obj;
    }
}