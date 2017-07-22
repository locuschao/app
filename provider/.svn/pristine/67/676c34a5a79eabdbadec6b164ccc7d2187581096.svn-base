<?php

function smarty_block_ec($params, $text, &$smarty)
{
    require_once "Ec/Lang.php";
    switch ($text) {
        case 'warehouse':
            // $whText = Ec_Lang::getInstance()->translate('warehouse');

            $warehouseArr = Common_DataCache::getWarehouse();
            $name = isset($params['name']) ? $params['name'] : 'warehouseId';
            $search = isset($params['search']) ? $params['search'] : 'Y';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $event = isset($params['event']) ? $params['event'] : '';

            $keyToSearch = ' keyToSearch';
            if ($search != 'Y') {
                $keyToSearch = '';
                $selectText = Ec_Lang::getInstance()->translate('pleaseSelected');
            } else {
                $selectText = Ec_Lang::getInstance()->translate('all');
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            // $text = $whText . '：';
            $text = '';
            $text .= '<select '.$event.' class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $text .= '<option value="">' . $selectText . '</option>';
            if (!empty($warehouseArr)) {
                foreach ($warehouseArr as $key => $val) {
                    $text .= '<option value=' . $val['warehouse_id'] . '>' . $val['warehouse_code'].' [' .$val['warehouse_desc']. ']</option>' . "\r";
                }
            }
            $text .= '</select>';
            break;
        case 'status':
            $statusArr = Common_Type::status('auto');
            $name = isset($params['name']) ? $params['name'] : 'status';
            $search = isset($params['search']) ? $params['search'] : 'Y';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $keyToSearch = ' keyToSearch';
            if ($search != 'Y') {
                $keyToSearch = '';
                $selectText = Ec_Lang::getInstance()->translate('pleaseSelected');
            } else {
                $selectText = Ec_Lang::getInstance()->translate('all');
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $text = '';
            $text .= '<select class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '"' . $validator . $errMsg . '>';
            $text .= '<option value="">' . $selectText . '</option>';
            if (!empty($statusArr)) {
                foreach ($statusArr as $key => $val) {
                    $text .= '<option value=' . $key . '>' . $val . '</option>' . "\r";
                }
            }
            $text .= '</select>';
            break;
        case 'foreach':
            $name = isset($params['name']) ? $params['name'] : '';
            $data = isset($params['data']) ? $params['data'] : array();
            $search = isset($params['search']) ? $params['search'] : 'Y';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $keyToSearch = ' keyToSearch';
            if ($search != 'Y') {
                $keyToSearch = '';
                $selectText = Ec_Lang::getInstance()->translate('pleaseSelected');
            } else {
                $selectText = Ec_Lang::getInstance()->translate('all');
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $text = '';
            $text .= '<select class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '"' . $validator . $errMsg . '>';
            $text .= '<option value="">' . $selectText . '</option>';
            if (!empty($data)) {
                foreach ($data as $key => $val) {
                    $text .= '<option value=' . $key . '>' . $val . '</option>' . "\r";
                }
            }
            $text .= '</select>';
            break;
        case 'currency':
            $currencyArr = Common_DataCache::getCurrency();
            $name = isset($params['name']) ? $params['name'] : 'status';
            $search = isset($params['search']) ? $params['search'] : 'Y';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $keyToSearch = ' keyToSearch';
            if ($search != 'Y') {
                $keyToSearch = '';
                $selectText = Ec_Lang::getInstance()->translate('all');
            } else {
                $selectText = Ec_Lang::getInstance()->translate('pleaseSelected');
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $text = '';
            $text .= '<select class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '"' . $validator . $errMsg . '>';
            $text .= '<option value="">' . $selectText . '</option>';
            if (!empty($currencyArr)) {
                foreach ($currencyArr as $key => $val) {
                    $text .= '<option value=' . $val['currency_code'] . '>' . $val['currency_code'] . '/' . $val['currency_name'] . '</option>' . "\r";
                }
            }
            $text .= '</select>';
            break;
        case 'userWarehouse':
            //绑定用户
            $warehouseArr = Common_DataCache::getWarehouse();
            $name = isset($params['name']) ? $params['name'] : 'warehouseId';
            $search = isset($params['search']) ? $params['search'] : 'Y';
            $field = isset($params['field']) ? $params['field'] : 'warehouse_id';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $default = isset($params['default']) ? $params['default'] : 'Y';//是否 默认 显示全部、请选择
            $event = isset($params['event']) ? $params['event'] : '';
            $keyToSearch = ' keyToSearch';
            if ($search != 'Y') {
                $keyToSearch = '';
                $selectText = Ec_Lang::getInstance()->translate('pleaseSelected');
            } else {
                $selectText = Ec_Lang::getInstance()->translate('all');
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            // $text = $whText . '：';
            $text = '';
            $text .= '<select '.$event.' class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $uw=Service_User::getUserWarehouseIds();
            $text .= $default == 'Y' && count($uw)>1 ? '<option value="">' . $selectText . '</option>' : '';
            if (!empty($warehouseArr)) {
                foreach ($warehouseArr as $key => $val) {
                    if(isset($uw[$val['warehouse_id']])){
                        $text .= '<option value=' . $val[$field] . '>' .  $val['warehouse_code'].' [' .$val['warehouse_desc'] . ']</option>' . "\r";
                    }
                }
            }
            $text .= '</select>';
            break;
        case 'userStandardWarehouse':
            //绑定用户
            $warehouseArr = Common_DataCache::getWarehouse();
            $name = isset($params['name']) ? $params['name'] : 'warehouseId';
            $search = isset($params['search']) ? $params['search'] : 'Y';
            $field = isset($params['field']) ? $params['field'] : 'warehouse_id';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $default = isset($params['default']) ? $params['default'] : 'Y';//是否 默认 显示全部、请选择
            $event = isset($params['event']) ? $params['event'] : '';
            $keyToSearch = ' keyToSearch';
            if ($search != 'Y') {
                $keyToSearch = '';
                $selectText = Ec_Lang::getInstance()->translate('pleaseSelected');
            } else {
                $selectText = Ec_Lang::getInstance()->translate('all');
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            // $text = $whText . '：';
            $text = '';
            $text .= '<select '.$event.' class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $uw=Service_User::getUserWarehouseIds();
            $text .= $default == 'Y' && count($uw)>1 ? '<option value="">' . $selectText . '</option>' : '';
            if (!empty($warehouseArr)) {
                foreach ($warehouseArr as $key => $val) {
                    if (isset($uw[$val['warehouse_id']]) && $val['warehouse_virtual'] == '0' && $val['warehouse_type'] == '0') {
                        $text .= '<option value=' . $val[$field] . '>' . $val['warehouse_code'] . ' [' . $val['warehouse_desc'] . ']</option>' . "\r";
                    }
                }
            }
            $text .= '</select>';
            break;
        default;
            break;
    }
    return $text;
}