<?php
/**
 * Created by JetBrains PhpStorm.
 * User: cl
 * Date: 13-6-19
 * Time: 下午8:38
 * To change this template use File | Settings | File Templates.
 */

class Common_Company {

    public static function getCompanylogintpl()
    {
        return 'login_new.tpl';
    }
    /**
     * 获取登陆页面配置项目
     */
    public static function getLoginSet($longin_config_attribute){
    	
    	$return = array(
    				'ask'=>0,
    				'message'=>'Fail.',
    				'config_key'=>'',
    				'config_val'=>'',
    			);
    	
    	$config = Common_Common::getConfig($longin_config_attribute);
    	if(!$config){
    		$return['message'] = '未配置登陆项目.';
    		return $return;
    	} 
    	$arr = explode("#",$config);
    	foreach ($arr as $key => $value) {
    		switch ($key){
    			case '0':
    				$return['ask'] = $value;
    				break;
    			case '1':
    				$return['config_key'] = $value;
    				break;
    			case '2':
    				$return['config_val'] = $value;
    				break;
    			default:
    				//失败
    				$return['ask'] = 0;
    				return $return;
    				break;
    		}
    	}
    	
    	return $return;
    }
    
    public static function getCompanyCode()
    {
        $config = Zend_Registry::get('company');
        return isset($config['companycode']) ? $config['companycode'] : '';
    }

    public static function getEbayDevid(){
        $config = Zend_Registry::get('company');
        return $config['ebay']['devid'];
    }

    public static function getEbayAppid(){
        $config = Zend_Registry::get('company');
        return $config['ebay']['appid'];
    }

    public static function getEbayCertid(){
        $config = Zend_Registry::get('company');
        return $config['ebay']['certid'];
    }

    public static function getEbayServerurl(){
        $config = Zend_Registry::get('company');
        return $config['ebay']['serverurl'];
    }


    public static function getEbayVersion(){
        $config = Zend_Registry::get('company');
        return $config['ebay']['version'];
    }

    public static function getEbayRuname(){
        $config = Zend_Registry::get('company');
        return $config['ebay']['runame'];
    }

    public static function getEbayLoginUrl(){
        $config = Zend_Registry::get('company');
        return $config['ebay']['loginUrl'];
    }

    public static function getPaypalEndpoint(){
    	$config = Zend_Registry::get('company');
    	return $config['paypal']['endpoint'];
    }
    
    /**
     * 获取重量单位
     */
    public static function getUnitOfWeight()
    {
    	$config = Zend_Registry::get('company');
    	return isset($config['config']['unit_of_weight']) ? $config['config']['unit_of_weight'] : 'KG';
    }
}