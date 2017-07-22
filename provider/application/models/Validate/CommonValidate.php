<?php
class Validate_CommonValidate
{
    public $_orderArr = array(); //调用前必需初始化订单数据
    public $_error = array();

    public function __construct($array)
    {
        if ($array != null) {
            $this->_orderArr = $array;
        }
        $this->_error = array();
    }

    public function set($array)
    {
        $this->_orderArr = $array;
    }


    public function referenceNo()
    {
        if (trim($this->_orderArr['reference_no']) != '') {
            $orderModel = new Table_Orders();
            $order = $orderModel->getByCondition(
                array(
                    "customer_id" => $this->_orderArr['customer_id'],
                    "reference_no" => $this->_orderArr['reference_no'],
                    "order_code_neq" => $this->_orderArr['order_code'],
                    "order_status_neq" => '0'
                ));
            if (count($order) > 0) {
                $this->_error[] = "ReferenceNo Exists";
            }
        }
    }

    public function shippingMethod()
    {
        if (empty($this->_orderArr['sm_code'])) {
            $this->_error[] = 'Shipping Method can not be empty';
        }
    }

    public function consigneeCountryId()
    {
        if (empty($this->_orderArr['order_address_book']['oab_country_id'])) {
            $this->_error[] = 'Consignee Country can not be empty';
        }
    }

    public function consigneeName()
    {
        $regex[] = array('name' => 'Consignee Name', 'value' => $this->_orderArr['order_address_book']['oab_firstname'] . $this->_orderArr['order_address_book']['oab_lastname'], 'regex' => array('require', 'length[1,70]'));
        $error = Common_Validator::formValidator($regex);
        if (!empty($error)) {
            foreach ($error as $err) {
                $this->_error[] = $err;
            }
        }
    }

    public function address()
    {

        $regex[] = array('name' => 'Consignee Address', 'value' => $this->_orderArr['order_address_book']['oab_street_address1'] . $this->_orderArr['order_address_book']['oab_street_address2'], 'regex' => array('require', 'length[1,125]',));

        $error = Common_Validator::formValidator($regex);
        if (!empty($error)) {
            foreach ($error as $err) {
                $this->_error[] = $err;
            }
        }
    }


    //公司名称
    public function consigneeCompany()
    {

    }


    //收件人城市
    public function consigneeCity()
    {
        if (empty($this->_orderArr['order_address_book']['oab_city'])) {
            $this->_error[] = 'Consignee City Require';
        }
    }

    //收件人州
    public function consigneeRegion()
    {
        $regex = array('name' => 'Consignee State/Provice', 'value' => $this->_orderArr['order_address_book']['oab_state'], 'regex' => array('length[1,128]', ));
        $error = Common_Validator::Validator($regex);
        if (!empty($error)) {
            $this->_error[] = $error;
        }
    }

    //物品申报价值
    public function parcelDeclaredValue()
    {

    }

    //邮编
    public function consigneeZip()
    {
        $regex = array('name' => 'Consignee Postalcode', 'value' => $this->_orderArr['order_address_book']['oab_postcode'], 'regex' => array('length[1,255]', 'noCharacter', 'require'));
        $error = Common_Validator::Validator($regex);
        if (!empty($error)) {
            $this->_error[] = $error;
        }
    }

    //发往美国邮编5位
    public function usZip()
    {
        $regex = array('name' => 'Consignee Postalcode', 'value' => $this->_orderArr['order_address_book']['oab_postcode'], 'regex' => array('length[1,255]', 'noCharacter', 'require'));
        if ($this->_orderArr['order_address_book']['oab_country_id'] == 243) {
            $regex['regex'][] = 'us_zip';
            $error = Common_Validator::Validator($regex);
            if (!empty($error)) {
                $this->_error[] = $error;
            }
        }
    }

    //电话
    public function consigneePhone()
    {
        $regex = array('name' => 'Consignee Phone No', 'value' => $this->_orderArr['order_address_book']['oab_phone'], 'regex' => array('length[1,30]', 'noCharacter', 'require'));
        $error = Common_Validator::Validator($regex);
        if (!empty($error)) {
            $this->_error[] = $error;
        }
    }

    //Email
    public function consigneeEmail()
    {
        $regex = array('name' => 'Email', 'value' => $this->_orderArr['order_address_book']['oab_email'], 'regex' => array('require', 'email'));
        $error = Common_Validator::Validator($regex);
        if (!empty($error)) {
            $this->_error[] = $error;
        }
    }

    public function orderProduct()
    {
        $totalQuantity = 0;
        if (is_array($this->_orderArr['order_product'])) {
            foreach ($this->_orderArr['order_product'] as $key => $value) {
                $totalQuantity += isset($value['op_quantity']) ? $value['op_quantity'] : 0;
            }
        }
        if ($totalQuantity == 0) {
            $this->_error[] = "Order Product Empty";
        }
    }

    public function validator()
    {
        $this->shippingMethod();
        $this->consigneeName();
        $this->consigneeCountryId();
        $this->address();
        $this->orderProduct();
        $this->referenceNo();
        $this->usZip();
        return $this->_error;
    }

}
