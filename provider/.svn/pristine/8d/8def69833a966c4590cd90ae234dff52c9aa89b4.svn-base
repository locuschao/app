<?php
function smarty_block_e($params, $text, &$smarty)
{
    require_once "Ec/Lang.php";
    $short = Ec::getLang(1);
    switch ($text) {
        case 'product_group':
            $rows = Service_SpProductGroup::getByCondition(array(), array('pg_code', 'pg_name', 'pg_name_en'), 0, 0, array('pg_code'));
            $name = isset($params['name']) ? $params['name'] : 'pg_code';
            $search = isset($params['search']) ? $params['search'] : 'P';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $event = isset($params['event']) ? $params['event'] : '';
            $field = isset($params['field']) ? $params['field'] : 'pg_code';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';
            $search = strtolower($search);
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }

            $text = '<select ' . $event . ' class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            if (!empty($rows)) {
                $setValue = 'pg_name' . $short;
                foreach ($rows as $key => $val) {
                    $cyArr[] = $val['pg_code'];
                    if ($val[$field] == $value) {
                        $option .= '<option selected value=' . $val[$field] . '>' . '' .$val[$field]. ' ['. $val[$setValue] . ']</option>' . "\r";
                    } else {
                        $option .= '<option value=' . $val[$field] . '>' . '' .$val[$field]. ' ['. $val[$setValue] . ']</option>' . "\r";
                    }
                }
            }
            if (count($cyArr) > 1 || $search != '') {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;

        case 'service_channel':
            $status = isset($params['status']) ? $params['status'] : '';
            $rows = Service_SpServiceChannel::getByCondition(array('sc_status' => $status), array('sc_code', 'sc_name', 'sc_name_en', 'sc_id'), 0, 0, array('sc_code'));
            $name = isset($params['name']) ? $params['name'] : 'sc_id';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $event = isset($params['event']) ? $params['event'] : '';
            $field = isset($params['field']) ? $params['field'] : 'sc_id';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';
            $search = strtolower($search);
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }

            $text = '<select ' . $event . ' class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            if (!empty($rows)) {
                $setValue = 'sc_name' . $short;
                foreach ($rows as $key => $val) {
                    $cyArr[] = $val['sc_code'];
                    if ($val[$field] == $value) {
                        $option .= '<option selected value=' . $val[$field] . '>' . $val['sc_code'] . ' [' . $val[$setValue] . ']</option>' . "\r";
                    } else {
                        $option .= '<option value=' . $val[$field] . '>' . $val['sc_code'] . ' [' . $val[$setValue] . ']</option>' . "\r";
                    }
                }
            }
            if (count($cyArr) > 1 || $search != '') {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;

        case 'shipping_method':
            $shippingMethodSimpleArr = Service_ShippingMethod::getByCondition(array(), array('sm_code', 'sm_id', 'sm_name_cn', 'sm_name'), 0, 0, array('sm_code'));
            $name = isset($params['name']) ? $params['name'] : 'sm_id';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $field = isset($params['field']) ? $params['field'] : 'sm_id';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';
            $search = strtolower($search);
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            $text = '';
            $text .= '<select class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            if (!empty($shippingMethodSimpleArr)) {
                $setValue = strtolower($short) == 'en_us' ? 'sm_name' : 'sm_name_cn';
                foreach ($shippingMethodSimpleArr as $key => $val) {
                    $cyArr[] = $val['sm_id'];
                    if ($val[$field] == $value) {
                        $option .= '<option selected value=' . $val[$field] . '>' . $val['sm_code'] . ' [' . $val[$setValue] . ']</option>' . "\r";
                    } else {
                        $option .= '<option value=' . $val[$field] . '>' . $val['sm_code'] . ' [' . $val[$setValue] . ']</option>' . "\r";
                    }
                }
            }
            if (count($cyArr) > 1 || $search != '') {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;
        case 'ynSign':
            $Arr = Process_SpConfig::ynSign('auto');
            $name = isset($params['name']) ? $params['name'] : 'ynSign';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $text = '<select class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '"' . $validator . $errMsg . '>';
            $text .= $selectText;
            if (!empty($Arr)) {
                foreach ($Arr as $key => $val) {
                    if ($key == $value) {
                        $text .= '<option selected value=' . $key . '>' . $val . '</option>' . "\r";
                    } else {
                        $text .= '<option value=' . $key . '>' . $val . '</option>' . "\r";
                    }
                }
            }
            $text .= '</select>';
            break;

        case 'productGradeType':
            $Arr = Process_SpConfig::productGradeType('auto');
            $name = isset($params['name']) ? $params['name'] : 'productGradeType';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $text = '<select class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '"' . $validator . $errMsg . '>';
            $text .= $selectText;
            if (!empty($Arr)) {
                foreach ($Arr as $key => $val) {
                    if ($key == $value) {
                        $text .= '<option selected value=' . $key . '>' . $val . '</option>' . "\r";
                    } else {
                        $text .= '<option value=' . $key . '>' . $val . '</option>' . "\r";
                    }
                }
            }
            $text .= '</select>';
            break;

        case 'product_grade':
            $name = isset($params['name']) ? $params['name'] : 'pge_grade';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $field = isset($params['field']) ? $params['field'] : 'pge_grade';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $type = isset($params['ft_code']) ? $params['ft_code'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';

            $rowsArr = Service_SpProductGrade::getByCondition(array('ft_code' => $type), '*', 0, 0, array('pge_grade'));
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $search = strtolower($search);
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            $text = '';
            $text .= '<select class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            if (!empty($rowsArr)) {
                $setValue = strtolower($short) == 'en_us' ? 'pge_name_en' : 'pge_name';
                foreach ($rowsArr as $key => $val) {
                    $cyArr[] = $val['pge_grade'];
                    if ($val[$field] == $value) {
                        $option .= '<option selected value=' . $val[$field] . '>' . $val[$setValue] . '</option>' . "\r";
                    } else {
                        $option .= '<option value=' . $val[$field] . '>' . $val[$setValue] . '</option>' . "\r";
                    }
                }
            }
            if (count($cyArr) > 1 || $search != '') {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;

        case 'ctCode':
            $Arr = Process_SpConfig::ctCode('auto');
            $name = isset($params['name']) ? $params['name'] : 'productGradeType';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $text = '<select class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '"' . $validator . $errMsg . '>';
            $text .= $selectText;
            if (!empty($Arr)) {
                foreach ($Arr as $key => $val) {
                    if ($key == $value) {
                        $text .= '<option selected value=' . $key . '>' . $val . '</option>' . "\r";
                    } else {
                        $text .= '<option value=' . $key . '>' . $val . '</option>' . "\r";
                    }
                }
            }
            $text .= '</select>';
            break;
        case 'pmType':
            $Arr = Process_SpConfig::pmType('auto');
            $name = isset($params['name']) ? $params['name'] : 'productGradeType';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $text = '<select class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '"' . $validator . $errMsg . '>';
            $text .= $selectText;
            if (!empty($Arr)) {
                foreach ($Arr as $key => $val) {
                    if ($key == $value) {
                        $text .= '<option selected value=' . $key . '>' . $val . '</option>' . "\r";
                    } else {
                        $text .= '<option value=' . $key . '>' . $val . '</option>' . "\r";
                    }
                }
            }
            $text .= '</select>';
            break;

        case 'warehouse':
            $name = isset($params['name']) ? $params['name'] : 'warehouse_id';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $field = isset($params['field']) ? $params['field'] : 'warehouse_id';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';

            $rowsArr = Service_Warehouse::getByCondition(array(), array('warehouse_id', 'warehouse_code', 'warehouse_desc'), 0, 0, array('warehouse_code'));
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }
            $search = strtolower($search);
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            $text = '';
            $text .= '<select class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            if (!empty($rowsArr)) {
                $setValue = strtolower($short) == 'en_us' ? 'warehouse_desc' : 'warehouse_desc';
                foreach ($rowsArr as $key => $val) {
                    $cyArr[] = $val['warehouse_id'];
                    if ($val[$field] == $value) {
                        $option .= '<option selected value=' . $val[$field] . '>' . $val['warehouse_code'] . ' [' . $val[$setValue] . ']</option>' . "\r";
                    } else {
                        $option .= '<option value=' . $val[$field] . '>' . $val['warehouse_code'] . ' [' . $val[$setValue] . ']</option>' . "\r";
                    }
                }
            }
            if (count($cyArr) > 1 || $search != '') {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;
        case 'zone_scheme':
            $status = isset($params['status']) ? $params['status'] : '';
            $rows = Service_SpZoneScheme::getByCondition(array('zs_status' => $status), array('zs_name', 'zs_name_en', 'zs_id'), 0, 0, array('zs_name'));
            $name = isset($params['name']) ? $params['name'] : 'zs_id';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $event = isset($params['event']) ? $params['event'] : '';
            $field = isset($params['field']) ? $params['field'] : 'zs_id';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';
            $search = strtolower($search);
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }

            $text = '<select ' . $event . ' class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            if (!empty($rows)) {
                $setValue = 'zs_name' . $short;
                foreach ($rows as $key => $val) {
                    $cyArr[] = $val['zs_id'];
                    if ($val[$field] == $value) {
                        $option .= '<option selected value=' . $val[$field] . '>' . $val[$setValue] . '</option>' . "\r";
                    } else {
                        $option .= '<option value=' . $val[$field] . '>' . $val[$setValue] . '</option>' . "\r";
                    }
                }
            }
            if (count($cyArr) > 1 || $search != '') {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;

        case 'weight_template':
            $status = isset($params['status']) ? $params['status'] : '';
            $wt_con = array();
            if($status != ''){
            	$wt_con['wt_status'] = $status;
            }
            $rows = Service_SpWeightTemplate::getByCondition($wt_con, array('wt_name', 'wt_name_en', 'wt_id'), 0, 0, array('wt_name'));
            $name = isset($params['name']) ? $params['name'] : 'wt_id';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $event = isset($params['event']) ? $params['event'] : '';
            $field = isset($params['field']) ? $params['field'] : 'wt_id';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';
            $search = strtolower($search);
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }

            $text = '<select ' . $event . ' class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            if (!empty($rows)) {
                $setValue = 'wt_name' . $short;
                foreach ($rows as $key => $val) {
                    $cyArr[] = $val['wt_id'];
                    if ($val[$field] == $value) {
                        $option .= '<option selected value=' . $val[$field] . '>' . $val[$setValue] . '</option>' . "\r";
                    } else {
                        $option .= '<option value=' . $val[$field] . '>' . $val[$setValue] . '</option>' . "\r";
                    }
                }
            }
            if (count($cyArr) > 1 || $search != '') {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;

        case 'currency':
            //$status = isset($params['status']) ? $params['status'] : '';
            $rows = Service_Currency::getByCondition(array(), array('currency_code', 'currency_name', 'currency_name_en'), 0, 0, array('currency_code'));
            $name = isset($params['name']) ? $params['name'] : 'currency_code';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $event = isset($params['event']) ? $params['event'] : '';
            $field = isset($params['field']) ? $params['field'] : 'currency_code';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';
            $search = strtolower($search);
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }

            $text = '<select ' . $event . ' class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            if (!empty($rows)) {
                $setValue = 'currency_name' . $short;
                foreach ($rows as $key => $val) {
                    $cyArr[] = $val['currency_code'];
                    if ($val[$field] == $value) {
                        $option .= '<option selected value=' . $val[$field] . '>' . $val['currency_code'] . ' ' . $val[$setValue] . '</option>' . "\r";
                    } else {
                        $option .= '<option value=' . $val[$field] . '>' . $val['currency_code'] . ' ' . $val[$setValue] . '</option>' . "\r";
                    }
                }
            }
            if (count($cyArr) > 1 || $search != '') {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;

        case 'transitWarehouse':
            //$status = isset($params['status']) ? $params['status'] : '';
            $rows = Service_Warehouse::getByCondition(array('warehouse_type'=>1), array('warehouse_id', 'warehouse_code', 'warehouse_desc'), 0, 0, array('warehouse_code'));
            $name = isset($params['name']) ? $params['name'] : 'warehouse_id';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $event = isset($params['event']) ? $params['event'] : '';
            $field = isset($params['field']) ? $params['field'] : 'warehouse_id';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';
            $search = strtolower($search);
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }

            $text = '<select ' . $event . ' class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            $short='';
            if (!empty($rows)) {
                $setValue = 'warehouse_desc' . $short;
                foreach ($rows as $key => $val) {
                    $cyArr[] = $val['warehouse_code'];
                    if ($val[$field] == $value) {
                        $option .= '<option selected value=' . $val[$field] . '>' . $val['warehouse_code'] . ' ' . $val[$setValue] . '</option>' . "\r";
                    } else {
                        $option .= '<option value=' . $val[$field] . '>' . $val['warehouse_code'] . ' ' . $val[$setValue] . '</option>' . "\r";
                    }
                }
            }
            if (count($cyArr) > 1 || $search != '') {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;

        case 'standardWarehouse':
            //$status = isset($params['status']) ? $params['status'] : '';
            $rows = Service_Warehouse::getByCondition(array('warehouse_type'=>'0'), array('warehouse_id', 'warehouse_code', 'warehouse_desc'), 0, 0, array('warehouse_code'));
            $name = isset($params['name']) ? $params['name'] : 'warehouse_id';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $event = isset($params['event']) ? $params['event'] : '';
            $field = isset($params['field']) ? $params['field'] : 'warehouse_id';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';
            $search = strtolower($search);
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }

            $text = '<select ' . $event . ' class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            $short='';
            if (!empty($rows)) {
                $setValue = 'warehouse_desc' . $short;
                foreach ($rows as $key => $val) {
                    $cyArr[] = $val['warehouse_code'];
                    if ($val[$field] == $value) {
                        $option .= '<option selected value=' . $val[$field] . '>' . $val['warehouse_code'] . ' ' . $val[$setValue] . '</option>' . "\r";
                    } else {
                        $option .= '<option value=' . $val[$field] . '>' . $val['warehouse_code'] . ' ' . $val[$setValue] . '</option>' . "\r";
                    }
                }
            }
            if (count($cyArr) > 1 || $search != '') {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;

        case 'country':
            //$status = isset($params['status']) ? $params['status'] : '';
            //$rows = Common_DataCache::getCountrySortCode();
            $rows = Service_Country::getByCondition(array(), array('country_code', 'country_name', 'country_name_en'), 0, 0, array('country_sort desc','country_code'));
            $name = isset($params['name']) ? $params['name'] : 'country_code';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $event = isset($params['event']) ? $params['event'] : '';
            $field = isset($params['field']) ? $params['field'] : 'country_code';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';
            $search = strtolower($search);
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }

            $text = '<select ' . $event . ' class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            if (!empty($rows)) {
                $setValue = 'country_name' . $short;
                foreach ($rows as $key => $val) {
                    $cyArr[] = $val['country_name'];
                    if ($val[$field] == $value) {
                        $option .= '<option selected value=' . $val[$field] . '>' . $val['country_code'] . ' ' . $val[$setValue] . '</option>' . "\r";
                    } else {
                        $option .= '<option value=' . $val[$field] . '>' . $val['country_code'] . ' ' . $val[$setValue] . '</option>' . "\r";
                    }
                }
            }
            if (count($cyArr) > 1 || $search != '') {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;

        case 'feeType':
            //$status = isset($params['status']) ? $params['status'] : '';
            $rows = Service_FeeType::getByCondition(array());
            $name = isset($params['name']) ? $params['name'] : 'ft_code';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $event = isset($params['event']) ? $params['event'] : '';
            $field = isset($params['field']) ? $params['field'] : 'ft_code';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';
            $search = strtolower($search);
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }

            $text = '<select ' . $event . ' class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            if (!empty($rows)) {
                $setValue = $short == '' ? 'ft_name_cn' : 'ft_name_en';
                foreach ($rows as $key => $val) {
                    $cyArr[] = $val['ft_code'];
                    if ($val[$field] == $value) {
                        $option .= '<option selected value=' . $val[$field] . '>' . $val[$setValue] . '</option>' . "\r";
                    } else {
                        $option .= '<option value=' . $val[$field] . '>' . $val[$setValue] . '</option>' . "\r";
                    }
                }
            }
            if (count($cyArr) > 1 || $search != '') {
                $text .= $selectText;
            }
            $text .= $option;
            $text .= '</select>';
            break;
        case 'reportSystem':
            $db=Common_Common::getAdapter();
            $name = isset($params['name']) ? $params['name'] : 'rd_code';
            $search = isset($params['search']) ? $params['search'] : 'p';
            $validator = isset($params['validator']) ? $params['validator'] : '';
            $errMsg = isset($params['err-msg']) ? $params['err-msg'] : '';
            $class = isset($params['class']) ? $params['class'] : '';
            $event = isset($params['event']) ? $params['event'] : '';
            $field = isset($params['field']) ? $params['field'] : 'rd_code';
            $value = isset($params['value']) && !empty($params['value']) ? $params['value'] : '';
            $parent_code = isset($params['parent_code']) && !empty($params['parent_code']) ? $params['parent_code'] : '';
            $sql="SELECT rs.* FROM `report_system` as rs LEFT JOIN report_system as rs2 on rs.parent_id=rs2.rs_id WHERE rs.rs_status=1 and rs2.rd_code='{$parent_code}';";
            $rows=$db->fetchAll($sql);
            $search = strtolower($search);
            $keyToSearch = ' keyToSearch';
            $selectText = '';
            switch (strtolower($search)) {
                case  'p':
                    $keyToSearch = '';
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('pleaseSelected') . '</option>';
                    break;
                case  'a':
                    $selectText = '<option value="">' . Ec_Lang::getInstance()->translate('all') . '</option>';
                    break;
                case  'n':
                    $validator = '';
                    $selectText = '<option value=""></option>';
                    break;
            }
            if (!empty($validator)) {
                $validator = ' validator="' . $validator . '" ';
            }
            if (!empty($errMsg)) {
                $errMsg = ' err-msg="' . $errMsg . '" ';
            }

            $text = '<select ' . $event . ' class="input_text2' . $keyToSearch . ' ' . $class . '" id="' . $name . '" name="' . $name . '" ' . $validator . $errMsg . '>';
            $option = '';
            $cyArr = array();
            if (!empty($rows)) {
                $setValue = $short == '' ? 'rs_title' : 'rs_title_en';
                foreach ($rows as $key => $val) {
                    $cyArr[] = $val['rd_code'];
                    if ($val[$field] == $value) {
                        $option .= '<option selected value=' . $val[$field] . ' url='.$val['rs_url'].'>' . $val[$setValue] . '</option>' . "\r";
                    } else {
                        $option .= '<option value=' . $val[$field] . ' url='.$val['rs_url'].'>' . $val[$setValue] . '</option>' . "\r";
                    }
                }
            }
            if (count($cyArr) > 1 || $search != '') {
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