<?php

class Common_Parse
{
	private $taskNumber = 10;

	/**
	 * @desc 解析产品反馈报表
	 * @author Zijie Yuan
	 * @date 2017-04-12
	 * @return string
	 */
	public function parseFeedbackReport()
	{
		try {
			while (true) {
				$fields = array('frp_id', 'frq_id', 'user_id', 'ute_id', 'erp_no', 'frp_content');
				$parseArray = Service_FeedbackReportParse::getByCondition(array(), $fields, $this->taskNumber, 1);
				if (empty($parseArray)) {
					break;
				}
				$frqIdArray = array();
				// 遍历parse数组
				foreach ($parseArray as $key => $parse) {
					$userId = $parse['user_id'];
					$uteId = $parse['ute_id'];
					$erpCode = $parse['erp_no'];
					$companyName = Service_UserToErp::getByCondition(array(
						'user_id' => $userId,
						'ute_erp_no' => $erpCode
					), array('ute_erp_name'), 1, 1);
					$companyName = empty($companyName) ? array() : current($companyName);
					$frqIdArray[] = $parse['frq_id'];
					$reportContent = $parse['frp_content'];
					if (empty($reportContent)) {
						continue;
					}
					$reportList = json_decode($reportContent, true);
					if (!is_array($reportList)) {
						continue;
					}
					// 遍历json里的订单
					foreach ($reportList as $key => $report) {
						$date = date('Y-m-d H:i:s');
						$reportInfo = array();  // 报表信息
						$reportPictureInfo = array();   // 报表图片信息

						$reportArray['user_id'] = $userId;
						$reportArray['ute_id'] = $uteId;
						$reportArray['erp_no'] = $erpCode;
						$reportArray['pfr_uuid'] = Common_Common::getArrayValue($report, 'pttId', '');
						$reportArray['pfr_sku'] = Common_Common::getArrayValue($report, 'productSku', '');
						$reportArray['pfr_from'] = Common_Common::getArrayValue($companyName, 'ute_erp_name');
						$reportArray['pfr_country_name'] = Common_Common::getArrayValue($report, 'country', '');
						$reportArray['pfr_platform'] = Common_Common::getArrayValue($report, 'platform', '');
						$reportArray['pfr_appear_time'] = Common_Common::getArrayValue($report, 'time', '');
						$reportArray['pfr_error_type'] = Common_Common::getArrayValue($report, 'pteId', 0);
						$reportArray['pfr_quantity'] = Common_Common::getArrayValue($report, 'quantity', 0);
						$reportArray['pfr_settle_way'] = Common_Common::getArrayValue($report, 'ptpId', 0);
						$reportArray['pfr_content'] = Common_Common::getArrayValue($report, 'content', '');
						$reportArray['pfr_last_update_time'] = Common_Common::getArrayValue($report, 'updateTime', '0000-00-00');
						$reportArray['pfr_create_time'] = $date;
						$reportArray['pfr_update_time'] = $date;
						// 重复处理
						$reportExist = Service_ProductFeedbackReport::getByCondition(
							array('ute_id' => $uteId, 'pfr_uuid' => $reportArray['pfr_uuid'], 'pfr_platform' => $reportArray['pfr_platform']),
							array('pfr_id', 'pfr_last_update_time'), 1, 1);
						// 已存在的sku，更新反馈报表
						if ($reportExist && strtotime($reportArray['pfr_last_update_time']) > strtotime($reportExist['pfr_last_update_time'])) {
							$reportExist = current($reportExist);
							unset($reportArray['pfr_create_time']);
							Service_ProductFeedbackReport::update($reportArray, array('pfr_id' => $reportExist['pfr_id']));
							if (!empty($report['troubleImg'])) {
								// 删除图片，重新添加
								Service_ProductFeedbackReport::delete($reportExist['pfr_id'], 'pfr_id');
								foreach ($report['troubleImg'] as $key => $picture) {
									$reportPictureInfo[] = array(
										'pfr_id' => $reportExist['pfr_id'],
										'pfrp_thumb' => $picture,
										'pfrp_url' => $picture,
										'pfrp_create_time' => $date,
										'pfrp_update_time' => $date
									);
								}
								$affectRows = Service_ProductFeedbackReport::insertMulti($reportPictureInfo);
								continue;
							}
						}
						// 新增记录
						$db = Common_Common::getAdapter();
						$db->beginTransaction();
						$pfrId = Service_ProductFeedbackReport::add($reportArray);
						if (empty($pfrId)) {
							$db->rollBack();
							continue;
						}
						// 报表图片
						if (!empty($report['troubleImg'])) {
							foreach ($report['troubleImg'] as $key => $picture) {
								$reportPictureInfo[] = array(
									'pfr_id' => $pfrId,
									'pfrp_thumb' => $picture,
									'pfrp_url' => $picture,
									'pfrp_create_time' => $date,
									'pfrp_update_time' => $date
								);
							}
							$affectRows = Service_ProductFeedbackReport::insertMulti($reportPictureInfo);
							if (empty($affectRows)) {
								$db->rollBack();
								continue;
							}
						}
						$db->commit();
					}
				}
				Service_FeedbackReportParse::deleteIn($frqIdArray, 'frq_id');
				unset($parseArray);
			}
		} catch (Exception $e) {
			$error = $e->getMessage();
			self::_log($error, 'parse_sale_report');
			return false;
		}
	}

	/**
	 * @desc 解析销售报表
	 * @author Zijie Yuan
	 * @date 2017-04-12
	 * @return string
	 */
	public function parseSaleReport()
	{
		try {
			while (true) {
				$fields = array('srp_id', 'srq_id', 'user_id', 'ute_id', 'erp_no', 'srp_content');
				$parseArray = Service_SaleReportParse::getByCondition(array(), $fields, $this->taskNumber, 1);
				if (empty($parseArray)) {
					break;
				}
				$srqIdArray = array();
				// 遍历parse数组
				foreach ($parseArray as $key => $parse) {
					$userId = $parse['user_id'];
					$uteId = $parse['ute_id'];
					$erpCode = $parse['erp_no'];
					$companyName = Service_UserToErp::getByCondition(array(
						'user_id' => $userId,
						'ute_erp_no' => $erpCode
					), array('ute_erp_name'), 1, 1);
					$companyName = empty($companyName) ? array() : current($companyName);
					$srqIdArray[] = $parse['srq_id'];
					$reportContent = $parse['srp_content'];
					if (empty($reportContent)) {
						continue;
					}
					$reportList = json_decode($reportContent, true);
					if (!is_array($reportList)) {
						continue;
					}
					$date = date('Y-m-d H:i:s');
					$reportInfo = array();  // 报表信息
					// 遍历json里的订单
					foreach ($reportList as $key => $report) {
						$reportArray = array();
						$reportArray['user_id'] = $userId;
						$reportArray['ute_id'] = $uteId;
						$reportArray['erp_no'] = $erpCode;
						$reportArray['sr_sku'] = Common_Common::getArrayValue($report, 'productSku', '');
						$reportArray['sr_platform'] = Common_Common::getArrayValue($report, 'platform');
						$reportArray['sr_from'] = Common_Common::getArrayValue($companyName, 'ute_erp_name', '');
						$reportArray['sr_sale_gross'] = Common_Common::getArrayValue($report, 'salesAmountCount', 0.00);
						$reportArray['sr_ship_fee'] = Common_Common::getArrayValue($report, 'shippingFeeCount', 0.00);
						$reportArray['sr_cost'] = Common_Common::getArrayValue($report, 'purchaseCostCount', 0.00);
						$reportArray['sr_cost_unit'] = '￥';
						$reportArray['sr_price'] = 0.00;
						$reportArray['sr_poundage'] = Common_Common::getArrayValue($report, 'platformCostCount', 0.00) + Common_Common::getArrayValue($report, 'paymentPlatformFeeCount', 0.00) + Common_Common::getArrayValue($report, 'fbaFeeCount', 0.00);
						$reportArray['sr_service_ship_fee'] = 0.00;
						$reportArray['sr_refund_fee'] = 0.00;
						$reportArray['sr_amount'] = Common_Common::getArrayValue($report, 'quantity', 0);
						$reportArray['sr_amount_unit'] = Common_Common::getArrayValue($report, 'quantityUnit', '个');
						$reportArray['sr_increase_rate'] = 0.00;
						$reportArray['sr_create_time'] = $date;
						$reportArray['sr_update_time'] = $date;
						// 重复处理
						$reportExist = Service_SaleReport::getByCondition(
							array('ute_id' => $uteId, 'sr_sku' => $reportArray['sr_sku'], 'sr_platform' => $reportArray['sr_platform']),
							array('sr_id'), 1, 1);
						// 已存在的sku，更新销售报表
						if ($reportExist) {
							$reportExist = current($reportExist);
							unset($reportArray['sr_create_time']);
							Service_SaleReport::update($reportArray, array('sr_id' => $reportExist['sr_id']));
							continue;
						}
						$reportInfo[] = $reportArray;
					}
					Service_SaleReport::insertMulti($reportInfo);
				}
				Service_SaleReportParse::deleteIn($srqIdArray, 'srq_id');
				unset($parseArray);
			}
		} catch (Exception $e) {
			$error = $e->getMessage();
			self::_log($error, 'parse_sale_report');
			return false;
		}
	}


	/**
	 * @desc 解析产品管理数据
	 * @author gan
	 * @date 2017-06-12
	 * @return string
	 */
	public function parseProduct()
	{
		try {
			while (true) {
				$fields = array('pp_id', 'pq_id', 'ute_id', 'erp_no', 'pp_content');
				$parseArray = Service_ProductParse::getByCondition(array(), $fields, $this->taskNumber, 1);
				if (empty($parseArray)) {
					break;
				}
				$frqIdArray = array();
				// 遍历parse数组
				foreach ($parseArray as $key => $parse) {
					// $userId = $parse['user_id'];
					$uteId = $parse['ute_id'];
					$erpCode = $parse['erp_no'];
					$companyName = Service_UserToErp::getByCondition(array(
//                            'user_id' => $userId,
						'ute_erp_no' => $erpCode
					), array('ute_erp_name'), 1, 1);
					$companyName = empty($companyName) ? array() : current($companyName);
					$frqIdArray[] = $parse['pq_id'];
					$reportContent = $parse['pp_content'];
					if (empty($reportContent)) {
						continue;
					}
					$reportList = json_decode($reportContent, true);
					if (!is_array($reportList)) {
						continue;
					}
					// 遍历json里的产品
					foreach ($reportList as $key => $report) {
						$date = date('Y-m-d H:i:s');
						$reportArray = array();
						$productLogs = array();
						$reportPictureInfo = array();
						$reportArray['ute_id'] = $uteId;
						$reportArray['ute_erp_name'] = Common_Common::getArrayValue($report, 'purchaseCompany', '');
						$reportArray['product_sku'] = Common_Common::getArrayValue($report, 'productSku', '');
						$reportArray['product_name'] = Common_Common::getArrayValue($report, 'productTitle', '');
						$reportArray['product_status'] = Common_Common::getArrayValue($report, 'saleStatus', '');
						$reportArray['product_spu'] = Common_Common::getArrayValue($report, 'productSpu', '');
						$reportArray['product_color'] = Common_Common::getArrayValue($report, 'productColor', '');
						$reportArray['product_long'] = Common_Common::getArrayValue($report, 'productLength', '');
						$reportArray['product_width'] = Common_Common::getArrayValue($report, 'productWidth', '');
						$reportArray['product_heigh'] = Common_Common::getArrayValue($report, 'productHeight', '');
						$reportArray['product_size_unit'] = 'CM';
						$reportArray['product_weight'] = Common_Common::getArrayValue($report, 'productWeight', '');
						$reportArray['product_weig_unit'] = 'kg';
						$reportArray['product_price'] = Common_Common::getArrayValue($report, 'spUnitPrice', '');
						$reportArray['product_price_unit'] = "RMB";
						$reportArray['product_create_time'] = Common_Common::getArrayValue($report, 'productAddTime', '');

						$reportArray['product_update_time'] = $date;

						$db = Common_Common::getAdapter();

						$db->beginTransaction();

						$productId = Service_Products::add($reportArray);
						$productLogs['product_id'] = $productId;
						if (!empty($productId)) {
							if (!empty($report['historyPrice'])) {
								foreach ($report['historyPrice'] as $key => $val) {
									$productLogs['ute_erp_name'] = Common_Common::getArrayValue($report, 'purchaseCompany', '');
									$productLogs['pq_unit_price'] = Common_Common::getArrayValue($val, 'pqUnitPrice', 0.00);
									$productLogs['pq_latest_transaction_price'] = Common_Common::getArrayValue($val, 'pqLatestTransactionPrice', 0.00);
									$productLogs['pq_price_unit'] = Common_Common::getArrayValue($val, 'pqPpriceUnit', 0.00);
									$productLogs['pq_purchase_lower_limit'] = Common_Common::getArrayValue($val, 'pqPurchaseLowerLimit', 0.00);
									$productLogs['pq_ship_date'] = Common_Common::getArrayValue($val, 'pqShiDate', 0.00);
									$productLogs['pq_quote_time'] = Common_Common::getArrayValue($val, 'pqQuoteTime', 0.00);
									$productLogs['pq_ship_date'] = Common_Common::getArrayValue($val, 'pqShipDate', 0.00);
									$productLogs['pq_create_time'] = Common_Common::getArrayValue($val, 'pqCreateTime', 0.00);
									$productLogs['pq_update_time'] = $date;

									$pfrId = Service_ProductQuoteLogs::add($productLogs);
								}
							}
						}
						// 报表图片
						if (!empty($report['images'])) {
							foreach ($report['images'] as $key => $picture) {
								$reportPictureInfo[] = array(
									'product_id' => $productId,
									'pi_url' => $picture['url'],
									'pi_create_time' => $date,
									'pi_update_time' => $date
								);

								$affectRows = Service_ProductPictures::add($reportPictureInfo);

							}
//                                $affectRows = Service_ProductPictures::insertMulti($reportPictureInfo);

							if (empty($productId) && empty($pfrId) && empty($affectRows)) {
								$db->rollBack();
								continue;
							}

						}
						$db->commit();
					}
				}
				Service_ProductParse::deleteIn($frqIdArray, 'pq_id');
				unset($parseArray);
			}
		} catch (Exception $e) {
			$error = $e->getMessage();
			self::_log($error, 'parse_product');
			return false;
		}


	}


	/**
	 * 错误日志
	 * @param $error
	 */
	private function _log($error, $fileName)
	{
		try {
			$logger = new Zend_Log ();
			$date = date('Y-m-d');
			$uploadDir = APPLICATION_PATH . "/../data/log/";
			$writer = new Zend_Log_Writer_Stream ($uploadDir . $date . '_' . $fileName . '.log');
			$logger->addWriter($writer);
			$logger->info(date('Y-m-d H:i:s') . ': ' . $error . " \n");
		} catch (Exception $e) {
			return false;
		}
	}

	/**
	 * @desc 解析QC异常管理数据
	 * @date 2017-06-20
	 * @return string
	 */
	public function parseQcException()
	{
		try {
			while (true) {
				$fields = array('oqep_id', 'oqeq_id', 'user_id', 'ute_id', 'erp_no', 'oqep_content');
				$parseArray = Service_OrderQcExceptionParse::getByCondition(array(), $fields, $this->taskNumber, 1);
				if (empty($parseArray)) {
					break;
				}
				$frqIdArray = array();
				// 遍历parse数组
				foreach ($parseArray as $key => $parse) {
					$uteId = $parse['ute_id'];
					$userId = $parse['user_id'];
					$erpCode = $parse['erp_no'];
					$companyName = Service_UserToErp::getByCondition(array(
						'user_id' => $userId,
						'ute_erp_no' => $erpCode
					), array('ute_erp_name'), 1, 1);
					$companyName = empty($companyName) ? array() : current($companyName);
					$frqIdArray[] = $parse['oqeq_id'];
					$reportContent = $parse['oqep_content'];
					if (empty($reportContent)) {
						continue;
					}
					$reportList = json_decode($reportContent, true);
					if (!is_array($reportList)) {
						continue;
					}
					// 遍历json里的产品
					foreach ($reportList as $key => $v) {
						$date = date('Y-m-d H:i:s');
						$reportArray = array();
						foreach ($v['exceptionDetail'] as $report) {
							//查询订单表order_id
							$order_id = Service_Orders::getByField($v['poCode'], $field = 'order_no', $colums = "order_id");
							if (empty($order_id)) {
								continue;
							}
							$oi_id = Service_OrderItem::getByField($report['productSku'], $field = 'oi_sku', $colums = "oi_id");
							if (empty($oi_id)) {
								continue;
							}
							$reportArray['order_id'] = $order_id['order_id'];//订单表id
							$reportArray['order_no'] = Common_Common::getArrayValue($v, 'poCode', '');//订单号
							$reportArray['oi_id'] = $oi_id["oi_id"];//订单商品id
							$reportArray['oi_sku'] = Common_Common::getArrayValue($report, 'productSku', '');//异常订单sku
							$reportArray['oi_name'] = Common_Common::getArrayValue($report, 'productTitle', '');//产品名称
							$reportArray['oi_name_en'] = '';//产品英文名
							$reportArray['ute_id'] = $uteId;//供应商与erp对应关系表id
							$reportArray['ute_erp_name'] = $companyName['ute_erp_name'];//采购商
							$reportArray['oeol_id'] = 0;//异常操作记录表id
							$reportArray['oe_order_amount'] = Common_Common::getArrayValue($report, 'qcReceivedQty', '');//订单数量
							$reportArray['oe_ship_amount'] = Common_Common::getArrayValue($report, 'qcReceivedQty', '');//送货数量
							$reportArray['oe_check_amount'] = Common_Common::getArrayValue($report, 'qcQty', '');//质检数量
							$reportArray['oe_exception_amount'] = Common_Common::getArrayValue($report, 'qcQtyUnsellable', '');//问题件数量
							$reportArray['oe_supplement_amount'] = Common_Common::getArrayValue($report, 'qcQtyUnsellable', '');//需补件数
							$reportArray['oe_return_amount'] = Common_Common::getArrayValue($report, 'qcQtyUnsellable', '');//需退数量
							$reportArray['oe_amunt_unit'] = "件";//数量单位
							$reportArray['oe_type'] = 1;//异常类型，1：QC异常；2：收货异常；
							$reportArray['oe_qc_handle_type'] = Common_Common::getArrayValue($report, 'qeProcessType', '');//QC异常处理类型,处理类型：0:待确认,1:销毁，采购方承担,2:销毁，供应商承担,3:退回，供应商退回款项,6:换货，供应商重新发货,4:不良品上架
							$reportArray['oe_receive_handle_type'] = "";//收货异常处理类型， 0 比预期数量多 1 比预期数量少
							$reportArray['oe_qc_status'] = Common_Common::getArrayValue($report, 'qeStatus', '');//qc异常状态，0:已作废 1:未处理 2:已确认 3:已审核 4:已完成
							$reportArray['oe_receive_status'] = "";//收货处理状态：0:已作废 1:未处理 2:已确认 3:已审核 4:已完成
							$reportArray['oe_create_time'] = $date;//创建时间
							$reportArray['oe_update_time'] = $date;//更新时间
							$id = Service_OrderException::add($reportArray);
						}
						$productLogs['Exception_Qc_id'] = $id;
					}
				}
				Service_OrderQcExceptionParse::deleteIn($frqIdArray, 'oqeq_id');
				unset($parseArray);
			}
		} catch (Exception $e) {
			$error = $e->getMessage();
			self::_log($error, 'QcException');
			return false;
		}


	}

	/**
	 * @desc 解析收货异常管理数据
	 * @date 2017-06-20
	 * @return string
	 */
	public function parseException()
	{
		try {
			while (true) {
				$fields = array('orep_id', 'oreq_id', 'user_id', 'ute_id', 'erp_no', 'orep_content');
				$parseArray = Service_OrderReceiveExceptionParse::getByCondition(array(), $fields, $this->taskNumber, 1);
				if (empty($parseArray)) {
					break;
				}
				$frqIdArray = array();
				// 遍历parse数组
				foreach ($parseArray as $key => $parse) {
					$uteId = $parse['ute_id'];
					$userId = $parse['user_id'];
					$erpCode = $parse['erp_no'];
					$companyName = Service_UserToErp::getByCondition(array(
						'user_id' => $userId,
						'ute_erp_no' => $erpCode
					), array('ute_erp_name'), 1, 1);
					if (empty($companyName)) {
						continue;
					}
					$companyName = empty($companyName) ? array() : current($companyName);
					$frqIdArray[] = $parse['oreq_id'];
					$reportContent = $parse['orep_content'];
					if (empty($reportContent)) {
						continue;
					}
					$reportList = json_decode($reportContent, true);
					if (!is_array($reportList)) {
						continue;
					}
					// 遍历json里的产品
					foreach ($reportList as $key => $v) {
						$date = date('Y-m-d H:i:s');
						$reportArray = array();
						foreach ($v['exceptionDetail'] as $report) {
							//查询订单表order_id
							$order_id = Service_Orders::getByField($v['poCode'], $field = 'order_no', $colums = "order_id");
							if (empty($order_id)) {
								continue;
							}
							$oi_id = Service_OrderItem::getByField($report['productSku'], $field = 'oi_sku', $colums = "oi_id");
							if (empty($oi_id)) {
								continue;
							}
							$reportArray['order_id'] = $order_id['order_id'];//订单表id
							$reportArray['order_no'] = Common_Common::getArrayValue($v, 'poCode', '');//订单号
							$reportArray['oi_id'] = $oi_id["oi_id"];//订单商品id
							$reportArray['oi_sku'] = Common_Common::getArrayValue($report, 'productSku', '');//异常订单sku
							$reportArray['oi_name'] = Common_Common::getArrayValue($report, 'productTitle', '');//产品名称
							$reportArray['oi_name_en'] = '';//产品英文名
							$reportArray['ute_id'] = $uteId;//供应商与erp对应关系表id
							$reportArray['ute_erp_name'] = $companyName['ute_erp_name'];//采购商
							$reportArray['oeol_id'] = 0;//异常操作记录表id
							$reportArray['oe_order_amount'] = Common_Common::getArrayValue($report, 'receivingQty', '');//订单数量
							$reportArray['oe_ship_amount'] = Common_Common::getArrayValue($report, 'deliveryQty', '');//送货数量
							$reportArray['oe_check_amount'] = Common_Common::getArrayValue($report, 'deliveryQty', '');//质检数量
							$reportArray['oe_exception_amount'] = '';//问题件数量
							$reportArray['oe_supplement_amount'] = $report['receivingQty']-$report['receivedQty'];//需补件数
							$reportArray['oe_return_amount'] = 0;//需退数量
							$reportArray['oe_amunt_unit'] = "件";//数量单位
							$reportArray['oe_type'] = 2;//异常类型，1：QC异常；2：收货异常；
							$reportArray['oe_qc_handle_type'] = '';//QC异常处理类型,处理类型：0:待确认,1:销毁，采购方承担,2:销毁，供应商承担,3:退回，供应商退回款项,6:换货，供应商重新发货,4:不良品上架
							$reportArray['oe_receive_handle_type'] =  Common_Common::getArrayValue($report, 'reProcessType', '');//收货异常处理类型， 0 比预期数量多 1 比预期数量少
							$reportArray['oe_qc_status'] = "";//qc异常状态，0:已作废 1:未处理 2:已确认 3:已审核 4:已完成
							$reportArray['oe_receive_status'] =  Common_Common::getArrayValue($report, 'reStatus', '');//收货处理状态：0:已作废 1:未处理 2:已确认 3:已审核 4:已完成
							$reportArray['oe_create_time'] = $date;//创建时间
							$reportArray['oe_update_time'] = $date;//更新时间
							$id = Service_OrderException::add($reportArray);
						}
						$productLogs['Receive_Exception_id'] = $id;
					}
				}
				Service_OrderReceiveExceptionParse::deleteIn($frqIdArray, 'oreq_id');
				unset($parseArray);
			}
		} catch (Exception $e) {
			$error = $e->getMessage();
			self::_log($error, 'Receive_Exception');
			return false;
		}
	}
}