<?php
class Validate_FactoryValidate {
    public static function factoryMethod ($orderArr) {
        $shippingMethod = $orderArr['sm_code'];
        $smCode = ucfirst(strtolower($shippingMethod));
        $class = 'Validate_' . $smCode . 'Validate';
        if (class_exists($class,false)) {
            $obj = new $class($orderArr);
        } else {
            $obj = new Validate_CommonValidate($orderArr);
        }
        return $obj->validator();
    }
}
