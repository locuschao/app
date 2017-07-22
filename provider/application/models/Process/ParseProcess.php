<?php
/**
 * @desc 数据解析公共类
 * @author Zijie Yuan
 * @date 2017-03-31
 */
class Process_ParseProcess {

	/**
     * @desc 获取产品反馈报表
     * @author Zijie Yuan
     * @date 2017-03-31
     * @param array $params 请求参数数组
     * @param string $queueArray 任务队列数组
     * @return array
     */
	public static function getSaleReport($params, $queueArray) {
		$config = Zend_Registry::get('config');
		$url = $config->api->erpUrl;
        $soap = new SoapClient($url);
        $response = $soap->callService($params);
        if (empty($response->response)) {
        	return false;
        }
        $responseJson = json_decode($response->response, true);
        // 请求错误
        if ($responseJson['code'] != 200) {
        	return false;
        }
        // json解析出错
        if (json_last_error() !== JSON_ERROR_NONE) {
        	return false;
        }
        $responseArray = array(
        	'frq_id' => $queueArray['frq_id'],
        	'erp_no' => $queueArray['erp_no'],
        	'frp_content' => json_encode($responseJson['data']),
        	'frp_create_time' => date('Y-m-d H:i:s')
        );
        $frpId = Service_FeedbackReportParse::add($responseArray);
        if (empty($frpId)) {
        	return false;
        }
        // 处理多页
        return true;
	}
}