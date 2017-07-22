<style>
    body {
        font: 12px/150% Arial, Helvetica, sans-serif, '宋体';
    	color:black;
    }
    #print_content {
        background: none repeat scroll 0 0 white;
        margin-left: auto;
        margin-right: auto;
        position: relative;
        text-align: center;
        width: 19cm;
        padding: 0px;
        font-size: 13px;
    }
    #print_content table {
        border-collapse: collapse;
        border: none;
        width: 100%;
    }
    td{
	    font-size:12px;
    }
    .td_title{
    	text-align:center;
	    font-weight:bolder;
        font-size:32px;
    }
    .td_left{
	    text-align:left;
        text-indent:2px;
    }
</style>

<div id="print_content">
    <table width="100%" border="1" cellpadding="0" cellspacing="0" style="margin:0 auto;border-collapse:collapse;">
        <!-- SKU种类、合计金额（小写） -->
        <tr>
            <td width="55%" colspan="4" style="text-align:left;text-indent:2px;">SKU种类：<{count($detailProduct)}>  SKU总数：<{$count_sum}>  付款方式：<{$purchaseInfo.pay_type}>  结算方式：<{$purchaseInfo.account_type}></td>
            <td width="45%" colspan="4" style="text-align:left;text-indent:2px;">合计金额（小写）：<{sprintf("%0.3f", $purchaseInfo.payable_amount + $purchaseInfo.pay_ship_amount)}> <{$purchaseInfo.currency_code}></td>
        </tr>
        <!-- 运费、合计金额（大写） -->
        <tr>
            <td colspan="4" style="text-align:left;text-indent:2px;">运费：<{$purchaseInfo.pay_ship_amount}> <{$purchaseInfo.currency_code}></td>
            <td colspan="4" style="text-align:left;text-indent:2px;">合计金额（大写）：<{$purchaseInfo.upper_amount}></td>
        </tr>
        
        <!-- 注意事项 -->
        <tr><td colspan="8" style="font-weight:bold;text-align:left;">注意事项：</td></tr>
        <!-- 注意事项内容 -->
        <tr style="height:250px;"><td colspan="8" valign="top" style="text-align:left;"><{$purchaseInfo.supplier_treaty}></td></tr>
        <!-- 采购方代表(签字盖章)、供方代表(签字盖章) -->
        <tr>
	        <td colspan="8">
	            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;">
	                <tr>
		                <td style="height:100px;text-align:left;text-indent:2px;" valign="top">采购方代表(签字盖章)：</td>
		                <td style="text-align:left;text-indent:2px;" valign="top">供方代表(签字盖章)：</td>
	                </tr>
	            </table>
	        </td>
        </tr>
    </table>
</div>