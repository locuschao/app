<?php
class GetNumber
{
    private $applicationCode, $customerCode, $time, $prefix, $rule;

    public function __construct($applicationCode = '', $customerCode = '', $prefix = 'E', $rule)
    {
        $this->prefix = $prefix;
        $this->time = $this->timeSlice();
        $this->customerCode = $customerCode;
        $this->applicationCode = $applicationCode;
        $this->rule = $rule;
    }

    public function getCode()
    {
        $string = $this->rule ? $this->customerCode : str_pad(rand(10, 99), 2, '0', STR_PAD_LEFT);
        return strtoupper($this->prefix . $string . $this->time . $this->getSequence());
    }

    private function getOrderCnt()
    {
        $condition = array(
            'application_code' => $this->applicationCode,
        );
        if ($this->customerCode != '' && $this->rule) {
            $condition['customer_code'] = $this->customerCode;
        }
        $application = Service_Application::getByCondition($condition, '*');
        $date = date('Ymd');
        $time = date('Y-m-d H:i:s');
        if (empty($application)) {
            $row = array(
                'application_code' => $this->applicationCode,
                'current_number' => $date . '-1',
                'app_add_time' => $time,
                'customer_code' => $this->customerCode,
            );
            Service_Application::add($row);
            return '1';
        } else {
            if (!empty($application[0]['current_number']) && isset($application[0]['current_number'])) {
                $arr = explode('-', $application[0]['current_number']);
                if ($date == $arr[0]) {
                    $count = $arr[1] + 1;
                } else {
                    $count = 1;
                }
            } else {
                $count = 1;
            }
            $update = array('current_number' => $date . '-' . $count, 'app_update_time' => $time);
            Service_Application::update($update, $application[0]['application_id']);
        }
        return $count;
    }

    private function getSequence()
    {   
        return sprintf('%04s', $this->getOrderCnt());
    }

    public function timeSlice()
    {
        return date('ymd');
    }
    

    /**
     * @desc 生成随机数未6位（DGM包袋号生成，用到）
     * @return string
     */
    public function getCode2()
    {
    	$string = $this->rule ? $this->customerCode : str_pad(rand(10, 99), 2, '0', STR_PAD_LEFT);
    	return strtoupper($this->prefix . $string . $this->time . $this->getSequence2());
    }

    private function getSequence2()
    {
    	return sprintf('%06s', $this->getOrderCnt());
    }

    /**
     * @desc 生成用户唯一码
     * @return string
     */
    public function getUniqueCode($length) {
        return $this->createUniqueCode($length);

    }

    /**
     * @desc 创建随机码
     * @author Zijie Yuan
     * @date 2016-12-05
     * @param $length 随机码长度
     * @return string
     */
    private function createUniqueCode($length) {
        $code = '';
        for ($i=0; $i < 3; $i++) {
            // 大写字母 
            $code .= chr(mt_rand(65, 90));
        }
        $code .= $this->getSequence();
        return $code;
    }
}

class Common_GetNumbers
{
    /**
     * @param string $applicationCode
     * @param string $customerCode/跟客户无关就传$warehouseId
     * @param string $prefix
     * @param string $rule 1:单号带客户代码 0:四位随机
     * @return string
     */
    public static function getCode($applicationCode = '', $customerCode = '', $prefix = 'DO', $rule = 1)
    {
        $obj = new GetNumber($applicationCode, $customerCode, $prefix, $rule);
        return $obj->getCode();
    }
    
    /**
     * @param string $applicationCode
     * @param string $customerCode/跟客户无关就传$warehouseId
     * @param string $prefix
     * @param string $rule 1:单号带客户代码 0:六位随机
     * @return string
     */
    public static function getCode2($applicationCode = '', $customerCode = '', $prefix = 'DO', $rule = 1)
    {
    	$obj = new GetNumber($applicationCode, $customerCode, $prefix, $rule);
    	return $obj->getCode2();
    }

    /**
     * @desc 生成用户唯一码
     * @return string
     */
    public static function getUserUniqueCode($length = 4) {
        $obj = new GetNumber('', '', '', 0);
        return $obj->getUniqueCode($length);
    }
}