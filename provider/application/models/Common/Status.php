<?php
class Common_Status
{
    /**
     * @desc 同步状态
     * @param string $lang
     * @return array
     */
    public static function syncStatus($lang = 'auto')
    {
        $tmp = array(
            'zh_CN' => array(
                '0' => '未同步',
                '1' => '已同步',
                '2' => '同步异常',
            ),
            'en_US' => array(
                '0' => 'Not synchronized',
                '1' => 'synchronized',
                '2' => 'Synchronization exception',
            ),
        );
        if ($lang == 'auto') {
            $lang = Ec::getLang();
        }
        return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
    }

    /**
     * @总单状态
     * @param string $lang
     * @return array
     */
    public static function outboundBatchStatus($lang = 'zh_CN')
    {
        $tmp = array(
            'zh_CN' => array(
                '0' => '未处理',
                '1' => '处理中',
                '2' => '已完成',
                '3' => '失败',
            ),
            'en_US' => array(
                '0' => '未处理',
                '1' => '处理中',
                '2' => '已完成',
                '3' => '失败',
            )
        );
        if ($lang == 'auto') {
            $lang = Ec::getLang();
        }
        return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
    }


	/**
	 * @汇率状态
	 * @param string $lang
	 * @return array
	 */
	public static function currencyStatus($lang = 'zh_CN')
	{
		$tmp = array(
				'zh_CN' => array(
						'0' => '草稿',
						'1' => '正式',
						'2' => '作废',
						
				),
				'en_US' => array(
						'0' => 'draft',
						'1' => 'formal',
						'2' => 'invalid',
						
				)
		);
		if ($lang == 'auto') {
			$lang = Ec::getLang();
		}
		return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
	}


    /**
     * 发送状态
     * @param string $lang
     * @return array
     */
    public static function orderQueueSendStatus($lang = 'zh_CN'){
        $tmp = array(
            'zh_CN' => array(
                '0' => '未发送',
                '1' => '发送成功',
                '2' => '发送失败',
            ),
            'en_US' => array(
                '0' => 'Not sent',
                '1' => 'Send success',
                '2' => 'Send failed',
            )
        );
        if ($lang == 'auto') {
            $lang = Ec::getLang();
        }
        return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
    }

    /**
     * 物流状态
     * @param string $lang
     * @return array
     */
    public static function orderQueueLogisticsStatus($lang = 'zh_CN'){
        $tmp = array(
            'zh_CN' => array(
                '0' => '失败',
                '1' => '成功',
            ),
            'en_US' => array(
                '0' => 'fail',
                '1' => 'success',
            )
        );
        if ($lang == 'auto') {
            $lang = Ec::getLang();
        }
        return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
    }

    /**
     * 用户分组状态
     * @param string $lang
     * @return array
     */
    public static function noticeUserGroupStatus($lang = 'zh_CN'){
        $tmp = array(
            'zh_CN' => array(
                '0' => '未启用',
                '1' => '启用',
            ),
        );
        return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
    }

    /**
     * 用户分组应用状态
     * @param string $lang
     * @return array
     */
    public static function noticeUserGroupDistributeStatus($lang = 'zh_CN'){
        $tmp = array(
            'zh_CN' => array(
                '0' => '未应用',
                '1' => '应用',
            ),
        );
        return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
    }

    public static function orderStatus($lang = 'zh_CN') {
        $tmp = array(
            'zh_CN' => array(
                '1' => '待确认',
                '2' => '已确认',
                '3' => '已取消',
            ),
        );
        return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
    }

    public static function deliveryOrderStatus($lang = 'zh_CN') {
        $tmp = array(
            'zh_CN' => array(
                '1' => '待处理',
                '2' => '待审核',
                '3' => '已确认',
                '4' => '已发货',
                '5' => '审核失败'
            ),
        );
        return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
    }

    public static function exceptionsOrderStatus($lang = 'zh_CN') {
        $tmp = array(
            'zh_CN' => array(
                '1' => '正常销售',
                '2' => '缺货',
                '3' => '停产',
            ),
        );
        return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
    }

    /**
     * 合同状态
     * @param string $lang
     * @return array
     */
    public static function contractStatus($lang = 'zh_CN') {
        $tmp = array(
            'zh_CN' => array(
                '1' => '已打印',
                '2' => '已下载',
            ),
        );
        return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
    }

    /**
     * 竞标状态
     * @param string $lang
     * @return array
     */
    public static function biddingStatus($lang = 'zh_CN') {
        $tmp = array(
            'zh_CN' => array(
                '1' => '竞标进行中',
                '2' => '等待竞标结果',
                '3' => '竞标已结束'
            ),
        );
        return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
    }

    /**
     * 竞标参与状态
     * @param string $lang
     * @return array
     */
    public static function biddingParticipantStatus($lang = 'zh_CN') {
        $tmp = array(
            'zh_CN' => array(
                '1' => '未参与',
                '2' => '已参与',
            ),
        );
        return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
    }

    /**
     * @desc 报盘反馈产品状态
     * @param string $lang
     * @return array|mixed
     * @date 2017-6-15
     */
    public static function offerOrderStatus($lang = 'zh_CN') {
        $tmp = array(
            'zh_CN' => array(
                '1' => '未开始',
                '2' => '打样中',
                '3' => '已打烊',
            ),
        );
        return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
    }
    /**
     * @desc 报盘反馈参与请况
     * @param string $lang
     * @return array|mixed
     * @date 2017-6-15
     */
    public static function offerStatus($lang = 'zh_CN') {
        $tmp = array(
            'zh_CN' => array(
                '1' => '已参与',
                '2' => '未参与',
            ),
        );
        return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
    }
}