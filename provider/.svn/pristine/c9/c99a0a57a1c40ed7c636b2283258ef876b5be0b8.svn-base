<?php
class Common_Validator
{
    public static function formValidator($validateArray)
    {
        $error = array();
        foreach ($validateArray as $validate) {
            $name = $validate['name'];
            $value = $validate['value'];
            if (trim($value) === '' && in_array('require', $validate['regex'])) {
                $error[] = $name . ' ' . Ec::Lang('validateRequire');
                continue;
            } elseif (trim($value) === '') {
                continue;
            }
            foreach ($validate['regex'] as $regex) {
                switch (true) {
                    case (substr($regex, 0, 6) == 'length'):
                        $length = str_replace('length[', '', $regex);
                        $length = str_replace(']', '', $length);
                        $lengthArray = explode(",", $length);
                        $valueLength = strlen($value);

                        if ($valueLength < $lengthArray[0] || $valueLength > $lengthArray[1]) {
                            $error[] =$name. Ec::Lang('validateLengthLeft') . ' ' . $lengthArray[0] . ' - ' . $lengthArray[1] . ' ' . Ec::Lang('validateLengthRight');
                            break 2;
                        }
                        continue 2;
                    case (substr($regex, 0, 7) == 'number['): //范围两边值可取
                        $length = str_replace('number[', '', $regex);
                        $length = str_replace(']', '', $length);
                        $lengthArray = explode(",", $length);
                        if ($value < $lengthArray[0] || $value > $lengthArray[1]) {
                            $error[] =$name .' '. Ec::Lang('validateNumber') . ' ' . $lengthArray[0] . ' ' . $lengthArray[1];
                            break 2;
                        }
                        continue 2;
                    case (substr($regex, 0, 7) == 'number('): //范围两边值不可取
                        $length = str_replace('number(', '', $regex);
                        $length = str_replace(')', '', $length);
                        $lengthArray = explode(",", $length);
                        if ($value <= $lengthArray[0] || $value >= $lengthArray[1]) {
                            $error[] = Ec::Lang('validateUnNumber') . ' ' . $lengthArray[0] . ' ' . $lengthArray[1];
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'email'): //email验证
                        if (!eregi("^[a-zA-Z0-9_\.-]+\@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$", $value)) {
                            $error[] = $name . ' ' . Ec::Lang('validateEmail');
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'integer'): //正整数（可为0）
                        if (!preg_match("/^\d+$/", $value)) {
                            $error[] = $name . ' ' . Ec::Lang('validateInteger');
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'positive1'): //正数（不可为0）
                        if (!preg_match("/^[1-9]\d*(.\d+)*$|^0.\d*[1-9]+\d*$/", $value)) {
                            $error[] = $name . ' ' . Ec::Lang('validatePositive1');
                            break 2;
                        }
                        continue 2;

                    case ($regex == 'positive'): //正数（可为0）
                        if (!preg_match("/^\d*(.\d*)$/", $value)) {
                            $error[] = $name . ' ' . Ec::Lang('validatePositive');
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'telephone'): //电话号码

                        continue 2;
                    case ($regex == 'noCharacter'): //不能是汉字
                        if (preg_match("/[\x{4e00}-\x{9fa5}]+/u", $value)) {
                            $error[] = $name . ' ' . Ec::Lang('validateNoCharacter');
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'english');
                        if (!preg_match('/^[A-Za-z]+$/', $value)) {
                            $error[] = $name . ' ' . Ec::Lang('validateEnglish');
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'chinese'): //含有中文
                        $low = chr(0xa1);
                        $high = chr(0xff);
                        if (!preg_match("/[$low-$high]/", $value)) {
                            $error[] = $name . ' ' . Ec::Lang('validateChinese');
                            break 2;
                        }
                        continue 2;
                    case (substr($regex, 0, 5) == 'equal'): //两值相比较
                        $compareValue = str_replace('equal[', '', $regex);
                        $compareValue = str_replace(']', '', $compareValue);
                        $compareArray = explode(",", $compareValue);
                        if ($compareArray[0] != $compareArray[1]) {
                            $error[] = $name . ' ' . Ec::Lang('validateEqual');
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'specialCharDesc'):
                        $specialChar = array("tools", "sample", "Electronics", "Gift", " Personal gift", "Personal sample");
                        if (in_array(trim($value), $specialChar)) {
                            $error[] = $name . ' ' . Ec::Lang('validateSpecialCharDesc');
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'onlyNumber'):
                        if (preg_match("/^\d+$/", $value)) {
                            $error[] = $name . ' ' . Ec::Lang('validateOnlyNumber');
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'charNumber'):
                        if (!preg_match("/^[\s\n0-9a-zA-Z]+$/", $value)) {
                            $error[] = $name . ' ' . Ec::Lang('validateCharNumber');
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'charOnly'):
                        if (!preg_match("/^[\s\na-zA-Z]+$/", $value)) {
                            $error[] = $name . ' ' . Ec::Lang('validateCharOnly');
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'msn_qq'):
                        if (!preg_match("/^[0-9]{5,15}$|^[a-zA-Z0-9_\.]+@[a-zA-Z0-9-]+\.[a-zA-Z]+$/", $value)) {
                            $error[] = $name . ' ' . Ec::Lang('validateMsnQq');
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'us_zip'):
                        //美国邮编
                        if (!preg_match("/^[0-9]{5}(\-[0-9]{4}){0,1}+$/", $value)) {
                            $error[] = $name . ' ' . Ec::Lang('validateUSZip');
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'euexp_char'):
                        if (!self::eu_encode($value)) {
                            $error[] = $name . ' ' . Ec::Lang('validateEuexpChar');
                            break 2;
                        }
                        continue 2;
                    case (substr($regex, 0, 4) == 'max['):
                        $compareValue = str_replace('max[', '', $regex);
                        $compareValue = str_replace(']', '', $compareValue);
                        $compareArray = explode(",", $compareValue);
                        if ($compareArray[0] < $value) {
                            $error[] = $name . ' ' . Ec::Lang('validateMax') . ' ' . $compareArray[0] . $compareArray[1];
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'en_char'): //必须包括英文
                        if (self::selectEnchar($value)) {
                            $error[] = $name . ' ' . Ec::Lang('validateEnChar');
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'englishAndNumber');
                        if (!preg_match('/^[A-Za-z0-9]+$/', $value)) {
                        	$error[] = $name . ' ' . Ec::Lang('validateEnglish');
                        	break 2;
                        }
                        continue 2;
                }
            }
        }
        return $error;
    }

    public static function selectEnchar($str)
    {
        $length = strlen($str);
        $i = 0;
        while ($i < $length) {
            $ascii = ord($str[$i]);
            if ($ascii <= 122 && $ascii >= 65) {
                return false;
            }
            $i++;
        }
        return true;
    }

    public static function Validator($validate)
    {
        $name = $validate['name'];
        $error = '';
        $value = $validate['value'];
        if (trim($value) === '' && in_array('require', $validate['regex'])) {
            $error = $name . ' ' . Ec::Lang('validateRequire');
            return $error;
        } elseif (trim($value) === '') {
            return;
        }
        foreach ($validate['regex'] as $regex) {
            switch (true) {
                case (substr($regex, 0, 6) == 'length'):
                    $length = str_replace('length[', '', $regex);
                    $length = str_replace(']', '', $length);
                    $lengthArray = explode(",", $length);
                    $valueLength = strlen($value);
                    if ($valueLength < $lengthArray[0] || $valueLength > $lengthArray[1]) {
                        $error = Ec::Lang('validateLengthLeft') . ' ' . $lengthArray[0] . ' - ' . $lengthArray[1] . ' ' . Ec::Lang('validateLengthRight');
                        break 2;
                    }
                    continue 1;
                case (substr($regex, 0, 7) == 'number['): //范围两边值可取
                    $length = str_replace('number[', '', $regex);
                    $length = str_replace(']', '', $length);
                    $lengthArray = explode(",", $length);
                    if ($value < $lengthArray[0] || $value > $lengthArray[1]) {
                        $error = Ec::Lang('validateNumber') . ' ' . $lengthArray[0] . ' ' . $lengthArray[1];
                        break 2;
                    }
                    continue 1;
                case (substr($regex, 0, 7) == 'number('): //范围两边值不可取
                    $length = str_replace('number(', '', $regex);
                    $length = str_replace(')', '', $length);
                    $lengthArray = explode(",", $length);
                    if ($value <= $lengthArray[0] || $value >= $lengthArray[1]) {
                        $error = Ec::Lang('validateUnNumber') . ' ' . $lengthArray[0] . ' ' . $lengthArray[1];
                        break 2;
                    }
                    continue 1;
                case ($regex == 'email'): //email验证
                    if (!eregi("^[a-zA-Z0-9_\.-]+@[a-zA-Z0-9-]+[\.a-zA-Z]+$", $value)) {
                        $error = $name . ' ' . Ec::Lang('validateEmail');
                        break 2;
                    }
                    continue 1;
                case ($regex == 'integer'): //正整数（可为0）
                    if (!preg_match("/^\d+$/", $value)) {
                        $error = $name . ' ' . Ec::Lang('validateInteger');
                        break 2;
                    }
                    continue 1;
                case ($regex == 'positive'): //正数（可为0）
                    if (!preg_match("/^\d*(.\d*)$/", $value)) {
                        $error = $name . ' ' . Ec::Lang('validatePositive');
                        break 2;
                    }
                    continue 1;

                case ($regex == 'positive1'): //正数（不可为0）
                    if (!preg_match("/^[1-9]\d*(.\d+)*$|^0.\d*[1-9]+\d*$/", $value)) {
                        $error = $name . ' ' . Ec::Lang('validatePositive1');
                        break 2;
                    }
                    continue 1;

                case ($regex == 'telephone'): //电话号码

                    continue 1;
                case ($regex == 'cn_char'): //中文字符
                    $low = chr(0xa1);
                    $high = chr(0xff);
                    if (preg_match("/[$low-$high]/", $value)) {
                        $error = $name . ' ' . Ec::Lang('validateChinese');
                        break 2;
                    }
                    continue 1;
                case ($regex == 'charNumber'):
                    if (!preg_match("/^[\s\n0-9a-zA-Z]+$/", $value)) {
                        $error = $name . ' ' . Ec::Lang('validateCharNumber');
                        break 2;
                    }
                    continue 1;
                case ($regex == 'charOnly'):
                    if (!preg_match("/^[\s\na-zA-Z]+$/", $value)) {
                        $error = $name . ' ' . Ec::Lang('validateCharOnly');
                        break 2;
                    }
                    continue 1;
                case (substr($regex, 0, 5) == 'equal'): //两值相比较
                    $compareValue = str_replace('equal[', '', $regex);
                    $compareValue = str_replace(']', '', $compareValue);
                    $compareArray = explode(",", $compareValue);
                    if ($compareArray[0] != $compareArray[1]) {
                        $error = $name . ' ' . Ec::Lang('validateEqual');
                        break 2;
                    }
                    continue 1;
                case ($regex == 'specialCharDesc'):
                    $specialChar = array("tools", "sample", "Electronics", "Gift", " Personal gift", "Personal sample");
                    if (in_array(trim($value), $specialChar)) {
                        $error = $name . ' ' . Ec::Lang('validateSpecialCharDesc');
                        break 2;
                    }
                    continue 1;
                case ($regex == 'onlyNumber'):

                    if (preg_match("/^\d+$/", $value)) {
                        $error = $name . ' ' . Ec::Lang('validateOnlyNumber');
                        break 2;
                    }
                    continue 1;
                case ($regex == 'msn_qq'):
                    if (!preg_match("/^[0-9]{5,15}$|^[a-zA-Z0-9_\.]+@[a-zA-Z0-9-]+\.[a-zA-Z]+$/", $value)) {
                        $error = $name . ' ' . Ec::Lang('validateMsnQq');
                        break 2;
                    }
                    continue 1;
                case ($regex == 'us_zip'):
                    if (!preg_match("/^[0-9]{5}(\-[0-9]{4}){0,1}+$/", $value)) {
                        $error = $name . ' ' . Ec::Lang('validateUSZip');
                        break 2;
                    }
//                        continue 1;
                    if (!self::eu_encode($value)) {
                        $error = $name . ' ' . Ec::Lang('validateEncode');
                        break 2;
                    }
                    continue 1;
                case (substr($regex, 0, 4) == 'max['):
                    $compareValue = str_replace('max[', '', $regex);
                    $compareValue = str_replace(']', '', $compareValue);
                    $compareArray = explode(",", $compareValue);
                    if ($compareArray[0] < $value) {
                        $error = $name . ' ' . Ec::Lang('validateMax') . ' ' . $compareArray[0] . $compareArray[1];
                        break 2;
                    }
                    continue 1;
                case ($regex == 'numeric'):
                    if (!is_numeric($value)) {
                        $error = $name . ' ' . Ec::Lang('validateNumeric');
                        break 2;
                    }
                    continue 1;
                case ($regex == 'en_char'):
                    if (self::selectEnchar($value)) {
                        $error = $name . ' ' . Ec::Lang('validateEnChar');
                        break 2;
                    }
                    continue 1;
            }
        }
        return $error;
    }


    public static function eu_encode($str)
    {
        $length = strlen($str);
        $i = 0;
        $nStr = '';
        while ($i < $length) {
            $ascii = ord($str[$i]);
            if ($ascii > 126) {
                return false;
            }
            $i++;
        }
        return true;
    }
}