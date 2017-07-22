<?php
class GetNumbers
{
    private $applicationCode, $customerCode, $time, $prefix, $ruleStr;

    public function __construct($applicationCode = '', $customerCode = '', $prefix = '')
    {
        $this->time = $this->timeSlice();
        $this->customerCode = $customerCode;
        $this->applicationCode = $applicationCode;
        $this->prefix = $prefix;
    }

    public function getCode()
    {
        $sequence = $this->getSequence();
        return strtoupper($this->prefix . $this->ruleStr . $this->time . $sequence);
    }

    private function getCnt()
    {
        $condition = array(
            'application_code' => $this->applicationCode,
        );
        if ($this->customerCode != '') {
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
            $this->ruleStr = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            return '1';
        } else {
            $this->prefix = isset($application[0]['prefix']) && !empty($application[0]['prefix']) ? $application[0]['prefix'] : $this->prefix;
            $rule = isset($application[0]['rule']) ? $application[0]['rule'] : 1;
            switch ((int)$rule) {
                case 1: //随机四位
                    $this->ruleStr = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                    break;
                case 2: //使用客户代码
                    $this->ruleStr = $this->customerCode;
                    break;
                default: //空
                    $this->ruleStr = '';
                    break;
            }
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
        return sprintf('%04s', $this->getCnt());
    }

    public function timeSlice()
    {
        return date('ymd');
    }


}

class Common_GetNumber
{
    /**
     * @param string $applicationCode 应用代码
     * @param string $customerCode /跟客户无关就传$warehouseId
     * @param string $prefix 前缀(当表字段不为空是，使用表中的值)
     * @return string
     */
    public static function getCode($applicationCode = '', $customerCode = '', $prefix = '')
    {
        $obj = new GetNumbers($applicationCode, $customerCode, $prefix);
        return $obj->getCode();
    }
}