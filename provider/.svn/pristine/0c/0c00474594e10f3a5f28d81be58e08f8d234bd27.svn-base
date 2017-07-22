<?php

function smarty_block_ez($params, $text, &$smarty)
{
    require_once "Ec/Lang.php";
    switch ($text) {
        case 'transitWarehouse':
            $warehouseArr = Common_DataCache::getWarehouse();
            $name = isset($params['name']) ? $params['name'] : 'warehouseId';
            $type = isset($params['type']) ? $params['type'] : '0';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $event = isset($params['event']) ? $params['event'] : '';
            $selectText = '';
            if ($type == '1') {
                $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $text = '';
            $text .= '<select '.$event.' class="input_text2 ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $text .= $selectText;
            if (!empty($warehouseArr)) {
                foreach ($warehouseArr as $key => $val) {
                    if ($val['warehouse_type'] == '1') {
                        $text .= '<option value=' . $val['warehouse_id'] . '>' . $val['warehouse_code'].'[' .$val['warehouse_desc'] . ']</option>' . "\r";
                    }
                }
            }
            $text .= '</select>';
            break;
        case 'standardWarehouse':
            //绑定用户
            $warehouseArr = Common_DataCache::getWarehouse();
            $name = isset($params['name']) ? $params['name'] : 'warehouseId';
            $type = isset($params['type']) ? $params['type'] : '0';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $event = isset($params['event']) ? $params['event'] : '';
            $selectText = '';
            $keyToSearch = ' keyToSearch';
            if ($type == '1') {
                $keyToSearch = '';
                $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
            } elseif ($type == '2') {
                $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $text = '';
            $text .= '<select '.$event.' class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $whArr = array();
            if (!empty($warehouseArr)) {
                foreach ($warehouseArr as $key => $val) {
                    if ($val['warehouse_type'] == '0') {
                        $whArr[] = $val['warehouse_id'];
                        $option .= '<option value=' . $val['warehouse_id'] . '>' . $val['warehouse_code'].'[' .$val['warehouse_desc']. ']</option>' . "\r";
                    }
                }
            }
            if (count($whArr) > 1) {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;
        case 'warehouse':
            $warehouseArr = Common_DataCache::getWarehouse();
            $name = isset($params['name']) ? $params['name'] : 'warehouseId';
            $type = isset($params['type']) ? $params['type'] : '0';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $event = isset($params['event']) ? $params['event'] : '';
            $defaultValue = isset($params['defaultValue']) ? $params['defaultValue'] : '';
            $selectText = '';
            $keyToSearch = ' keyToSearch';
            if ($type == '1') {
                $keyToSearch = '';
                $selectText = '<option value="'.$defaultValue.'">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
            } elseif ($type == '2') {
                $selectText = '<option value="'.$defaultValue.'">' . Ec_Lang::getInstance()->translate('all') . '</option>';
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $text = '';
            $text .= '<select '.$event.' class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $whArr = array();
            if (!empty($warehouseArr)) {
                foreach ($warehouseArr as $key => $val) {
                    $whArr[] = $val['warehouse_id'];
                    $option .= '<option value=' . $val['warehouse_id'] . '>' . $val['warehouse_code'] . '[' . $val['warehouse_desc'] . ']</option>' . "\r";
                }
            }
            if (count($whArr) > 1) {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;
        case 'shippingMethod':
            $shippingMethodSimpleArr = Common_DataCache::getShippingMethodSimple();
            $name = isset($params['name']) ? $params['name'] : 'smId';
            $type = isset($params['type']) ? $params['type'] : '0';
            $field = isset($params['field']) ? $params['field'] : 'sm_id';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $selectText = '';
            $keyToSearch = ' keyToSearch';
            if ($type == '1') {
                $keyToSearch = '';
                $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
            } elseif ($type == '2') {
                $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $text = '';
            $text .= '<select class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $smArr = array();
            if (!empty($shippingMethodSimpleArr)) {
                foreach ($shippingMethodSimpleArr as $key => $val) {
                    $smArr[] = $val['sm_id'];
                    $option .= '<option value=' . $val[$field] . '>' . $val['sm_code'] . '  [' . $val['sm_name_cn'] . ']</option>' . "\r";
                }
            }
            if (count($smArr) > 1) {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;
        case 'countrySort':
            $getCountrySort = Common_DataCache::getCountrySort();
            $name = isset($params['name']) ? $params['name'] : 'countryId';
            $field = isset($params['field']) ? $params['field'] : 'country_id';
            $type = isset($params['type']) ? $params['type'] : '0';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $selectText = '';
            $keyToSearch = ' keyToSearch';
            if ($type == '1') {
                $keyToSearch = '';
                $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
            } elseif ($type == '2') {
                $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $text = '';
            $text .= '<select class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            if (!empty($getCountrySort)) {
                foreach ($getCountrySort as $key => $val) {
                    $cyArr[] = $val['country_id'];
                    $option .= '<option value=' . $val[$field] . '>' . $val['country_code'] . ' [' . $val['country_name'] . ']</option>' . "\r";
                }
            }
            if (count($cyArr) > 1) {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;
        case 'currency':
            $currencyArr = Common_DataCache::getCurrency();
            $name = isset($params['name']) ? $params['name'] : 'countryId';
            $field = isset($params['field']) ? $params['field'] : 'currency_code';
            $type = isset($params['type']) ? $params['type'] : '0';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $selectText = '';
            $keyToSearch = ' keyToSearch';
            if ($type == '1') {
                $keyToSearch = '';
                $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
            } elseif ($type == '2') {
                $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $text = '';
            $text .= '<select class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            if (!empty($currencyArr)) {
                foreach ($currencyArr as $key => $val) {
                    $cyArr[] = $val['currency_code'];
                    $option .= '<option value=' . $val[$field] . '>' . $val['currency_code'] . ' [' . $val['currency_name'] . '] '.$val['currency_rate'].'</option>' . "\r";
                }
            }
            if (count($cyArr) > 1) {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;
        case 'productCategory':
            $currencyArr = Common_DataCache::getProductCategory();
            $name = isset($params['name']) ? $params['name'] : 'pcId';
            $field = isset($params['field']) ? $params['field'] : 'pc_id';
            $type = isset($params['type']) ? $params['type'] : '0';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $selectText = '';
            $keyToSearch = ' keyToSearch';
            if ($type == '1') {
                $keyToSearch = '';
                $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
            } elseif ($type == '2') {
                $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $text = '';
            $text .= '<select class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            if (!empty($currencyArr)) {
                foreach ($currencyArr as $key => $val) {
                    $cyArr[] = $val['pc_id'];
                    $option .= '<option value=' . $val[$field] . '>' . $val['pc_shortname'] . ' [' . $val['pc_name'] . ']</option>' . "\r";
                }
            }
            if (count($cyArr) > 1) {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;
        default;
            break;
    }
    return $text;
}