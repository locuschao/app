<?php

class Default_SystemController extends Ec_Controller_DefaultAction
{
    public function preDispatch()
    {
        $this->tplDirectory = "default/views/default/";
        $this->_userAuth = new Zend_Session_Namespace('userAuthorization');

        if (!$this->_userAuth->isLogin) {
            $this->_redirect('/default/index/login');
            exit();
        }
    }

    /*
     * 布局头部
     */
    public function headerAction()
    {
        $this->view->menu = Common_Config::menuData();
        $this->view->userCode = $this->_userAuth->userCode;
        $this->view->userId = $this->_userAuth->userId;
        $this->view->userName = $this->_userAuth->userName;
        echo $this->view->render($this->tplDirectory . 'header.tpl');
    }

    /*
     * 后台左导航
     */
    public function leftMenuAction()
    {
        $result = array('state' => 0, 'data' => array());
        $userMenu = isset($this->_userAuth->Acl['menuArr']) ? $this->_userAuth->Acl['menuArr'] : array();
        if ($this->_request->isPost()) {
            if (count($userMenu)) {
                $result = array('state' => 1, 'data' => $userMenu);
            }
            die(Zend_Json::encode($result));
        }
        $this->view->menu = $userMenu;
        echo $this->view->render($this->tplDirectory . 'left_menu.tpl');
    }

    public function homeAction()
    {   
        $condition = array();
        // 获取userId
        $userId = Service_User::getUserId();
        // 获取uteId
        $userinfo= Service_UserToErp::getUserAndErpRelation(array('user_id' => $userId, 'ute_status' => 1), array('ute_id'));
        $uteId = Common_Common::getArrayColumn($userinfo, 'ute_id');
        $condition['ute_id'] = implode(',',$uteId);
        $orderCount = Service_Orders::getByGroup($condition, array('COUNT(order_id) as count', 'order_status as status'), 0, 0, '', 'order_status');
        $orderCount = Common_Common::arrayWithKey($orderCount, 'status', true);
        $deliveryCount = Service_DeliveryOrder::getByGroup($condition, array('COUNT(do_id) as count', 'do_status as status'), 0, 0, '', 'do_status');
        $deliveryCount = Common_Common::arrayWithKey($deliveryCount, 'status', true);
        $countInfo = array('order' => $orderCount, 'delivery' => $deliveryCount);
        $this->view->countInfo = $countInfo;
        echo Ec::renderTpl($this->tplDirectory . "home.tpl", 'layout');
    }

    public function rightGuildAction()
    {
        echo $this->view->render($this->tplDirectory . "right_guild.tpl");
    }

    /**
     * @查看产品图片
     * @desc WMS 全站使用
     */
    public function viewProductImgAction()
    {
        $productId = $this->_request->getParam('id', "");
        try {
            if (!$productId) {
                throw new Exception('参数错误');
            }

            $productRow = Service_Product::getByField($productId, 'product_id');
            if (!$productRow) {
                throw new Exception('产品不存在或已删除');
            }
            /**
             * 判断本地图片是否存在
             */
            /**
             * 先查询上传的图片，再去找同步的图片  ------------------------------------------- by tom 2016-7-5
             * 按客户配置产品图片显示，0：显示最后上传的一张图片 1：显示第一张上传的图片      ------------ by tom 2016-8-5
             */
            $pdId = $productRow['pd_id'];
            if (!$pdId) {
            	throw new Exception('不存在产品开发数据');
            }
            
            $configRow = Service_Config::getByField('PRODUCT_IMAGES_SHOW_RULE', 'config_attribute', array('config_value'));
            $PRODUCT_IMAGES_SHOW_RULE = isset($configRow['config_value']) ? $configRow['config_value'] : '0';
            
            if ($PRODUCT_IMAGES_SHOW_RULE == '1') {
            	$orderBy = array("is_main desc","pi_id asc");
            } else {
            	$orderBy = array("is_main desc","pi_id desc");
            }
            
            $productImage = Service_ProductImages::getByCondition(array("pd_id" => $pdId, "pi_status" => "1"), "*", 1, 1, $orderBy);
            
            if (!$productImage) {
            	$db = Common_Common::getAdapter();
                $sql = "SELECT * FROM `product_images_for_print` WHERE product_id={$productId};";
                $image = $db->fetchRow($sql);
                if (!empty($image)) {
                	if ($image['pi_type'] == 'link') {
                		header("Location: " . $image['pi_path']);
                	} elseif ($image['pi_type'] == 'img') {
                		header("Location: http://" . $this->getRequest()->getHttpHost() . '/swfupload/image_for_print/' . $image['pi_path']);
                	} else {
                		throw new Exception('图片类型不正确');
                	}
                } else {
                	throw new Exception('产品开发不存在图片');
                }
            } else {
            	$image = $productImage[0];
            	if (!$image) {
            		throw new Exception('产品开发不存在图片');
            	}
            	if ($image['pi_type'] == 'link') {
            		header("Location: " . $image['pi_path']);
            	} elseif ($image['pi_type'] == 'img') {
            		$config = Zend_Registry::get('server');
            		header("Location: http://" . $this->getRequest()->getHttpHost() . $config['swfupload']['url_prefix'] . $image['pi_path']);
            	} else {
            		throw new Exception('图片类型不正确');
            	}
            }
        } catch (Exception $e) {
            header("Location: /images/base/noimg.jpg");
        }
        exit();
    }

    public function getSearchFilterAction()
    {
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array());
        $actionId = $this->_request->getParam('quick', '-1');

        $actionId = empty($actionId) ? '-1' : $actionId;
        if (!empty($actionId)) {
            $condition = array(
                "filter_action_id" => $actionId
            );
            $rows = Service_SearchFilter::getByCondition($condition, '*', 50, 1, array('parent_id asc', 'search_sort asc'));
            if (!empty($rows)) {
                $sType = $sFilter = array();
                foreach ($rows as $key => $value) {
                    if ($value['parent_id'] == '0') {
                        $sType[$value['search_sort'] . '_' . $value['sf_id']] = $value;
                        $sFilter[$value['sf_id']] = $value;
                    } elseif (isset($sFilter[$value['parent_id']])) {
                        $sType[$sFilter[$value['parent_id']]['search_sort'] . '_' . $value['parent_id']]['item'][] = $value;
                    }
                }
                ksort($sType);
                $result = array('state' => 1, 'message' => '', 'data' => $sType);
            }
        }
        die(Zend_Json::encode($result));
    }

    /**
     * @desc 获取自定义导航
     */
    public function getSkyeQuiKeyAction()
    {
        $result = array('state' => 0, 'message' => 'Fail', 'data' => array(), 'userId' => 0);
        $data = Service_UserRightHeaderMap::getSkyeQuiKey();
        if (!empty($data)) {
            $userId = isset($this->_userAuth->userId) ? $this->_userAuth->userId : '0';
            $result = array('state' => 1, 'userId' => $userId, 'data' => $data);
        }
        die(Zend_Json::encode($result));
    }

    /**
     * 用于登录,请勿删除或修改此方法
     */
    public function apiLoginAction()
    {
        $result['ask'] = 1;
        $result['message'] = 'Success';
        Zend_Json::encode($result);
    }
}