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
        <!-- 采购合同 -->
        <tr>
            <td colspan="8">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;">
                  <tr>  
                    <td width="20%" valign="top" style="text-align:left;"><img src="/barcode/ec/img.php?text=<{$purchaseInfo.po_code}>&scale=1&thickness=30" style="margin-top:3px;margin-left:3px;" /></td>
                    <td width="40%" class="td_title" valign="middle" style="font-weight:bolder;font-size:32px;text-align:center;"><{$company.purchase_contract_name}></td>
		            <td width="40%">
		                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;">
		                    <tr><td style="text-align:left;text-indent:2px;">采购单号：<{$purchaseInfo.po_code}></td></tr>
		                    <tr><td style="text-align:left;text-indent:2px;">入库单号：<{$purchaseInfo.receiving_code}></td></tr>
		                    <tr><td style="text-align:left;text-indent:2px;">打印时间：<{$purchaseInfo.operation_user}>&nbsp;<{$purchaseInfo.operation_time}></td></tr>
		                    <tr><td style="text-align:left;text-indent:2px;">创建时间：<{$purchaseInfo.create_user}>&nbsp;<{$purchaseInfo.create_time}></td></tr>
		                    <tr><td style="text-align:left;text-indent:2px;">采购员：<{$purchaseInfo.user_name}></td></tr>
		                </table>
		            </td>
		          </tr>
                </table>
            </td>
        </tr>
        
		          
        <!-- 仓库 -->
        <tr>
             <td colspan="8" align=left>
	            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;">
	              <tr>
	                <td colspan="2" align=left style="text-indent:3px;">采购仓库：<{$purchaseInfo.warehouse_desc}></td>
	                <td colspan="2" align=left><{if $purchaseInfo.to_warehouse_desc}>中转仓：<{$purchaseInfo.to_warehouse_desc}><{/if}></td>
	              </tr>
	            </table>
             </td>
        </tr>
        
        
        <!-- 采购方、供货方 -->
        <tr>
           <td colspan="8">
               <table width="100%" border="1" cellpadding="0" cellspacing="0" style="margin:0 auto;border-collapse:collapse;">
                   <tr>
                    <td width="70">
		               <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;">
		                   <tr><td class="td_left">采购方：</td></tr>
		                   <tr><td class="td_left" valign="top" style="height:30px;">地址：</td></tr>
		                   <tr><td class="td_left">联系人：</td></tr>
		                   <tr><td class="td_left">电话：</td></tr>
		                   <tr><td class="td_left">传真：</td></tr>
		               </table> 
		            </td>
		            <td width="270">
		                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;">
		                    <tr><td class="td_left"><{if $company.company_name_cn}><{$company.company_name_cn}><{else}>&nbsp;<{/if}></td></tr>
		                    <tr><td class="td_left" valign="top" style="height:30px;"><{if $company.company_address_cn}><{$company.company_address_cn}><{else}>&nbsp;<{/if}></td></tr>
		                    <tr><td class="td_left"><{if $company.company_contact_name}><{$company.company_contact_name}><{else}>&nbsp;<{/if}></td></tr>
		                    <tr><td class="td_left"><{if $company.company_contact_tel}><{$company.company_contact_tel}><{else}>&nbsp;<{/if}></td></tr>
		                    <tr><td class="td_left"><{if $company.company_contact_fax}><{$company.company_contact_fax}><{else}>&nbsp;<{/if}></td></tr>
		                </table>
		            </td>
		            <td width="70">
		               <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;">
		                   <tr><td class="td_left">供货方：</td></tr>
		                   <tr><td class="td_left" valign="top" style="height:30px;">地址：</td></tr>
		                   <tr><td class="td_left">联系人：</td></tr>
		                   <tr><td class="td_left">电话：</td></tr>
		                   <tr><td class="td_left">传真：</td></tr>
		               </table> 
		            </td>
		            <td width="270">
		                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;">
		                    <tr><td class="td_left"><{$purchaseInfo.supplier_name}></td></tr>
		                    <tr><td class="td_left" valign="top" style="height:30px;"><{$purchaseInfo.contact_address}></td></tr>
		                    <tr><td class="td_left"><{$purchaseInfo.contact_name}></td></tr>
		                    <tr><td class="td_left"><{$purchaseInfo.contact_tel}></td></tr>
		                    <tr><td class="td_left"><{$purchaseInfo.contact_fax}></td></tr>
		                </table>
		            </td>
                   </tr>
               </table>
           </td>
        </tr>
        
        <!-- 交货日期 -->
        <tr><td colspan="8" align=right>交货日期：<{$purchaseInfo.date_eta}>&nbsp;&nbsp;</td></tr>
        <tr>
            <td width="30"><b>NO.</b></td>
            <td width="90"><b><{if $is_img=="1"}>图片<{else}>SKU<{/if}></b></td>
            <td width="100"><b>供应商品号</b></td>
            <td width="166"><b>商品中/英文详情</b></td>
            <td width="70"><b>单价(<{$purchaseInfo.currency_code}>)</b></td>
            <td width="40"><b>数量</b></td>
            <td width="60"><b>金额(<{$purchaseInfo.currency_code}>)</b></td>
            <td width="140"><b>备注</b></td>
        </tr>
        <!-- 采购单明细 -->
        <{foreach from=$detailProduct key=key item=val}>
        <tr>
            <td><{$key+1}></td>
            <td><{$val.product_barcode}><{if $is_img=="1"}><br/><img width="87" height="69" src="<{$val.product_image_url}>"><{/if}></td>
            <td><{$val.sp_supplier_sku}></td>
            <td>中文：<{$val.product_title}><br/>英文：<{$val.product_title_en}></td>
            <td><{$val.unit_price}></td>
            <td><{if $val.qty_eta}><{$val.qty_eta}><{else}><{$val.qty_expected}><{/if}></td>
            <td><{$val.payable_amount}></td>
            <td><{$val.note}></td>
        </tr>
        <{if $val.self_property}><tr><td colspan="8" align=left>产品自定义属性：<{$val.self_property}></td></tr><{/if}>
        <{/foreach}>
        <!-- SKU种类、合计金额（小写） -->
        <tr>
            <td colspan="4" class="td_left">SKU种类：<{count($detailProduct)}>  SKU总数：<{$purchaseInfo.count_sum}>  付款方式：<{$purchaseInfo.pay_type}>  结算方式：<{$purchaseInfo.account_type}></td>
            <td colspan="4" class="td_left">合计金额（小写）：<{sprintf("%0.3f", $purchaseInfo.payable_amount + $purchaseInfo.pay_ship_amount)}> <{$purchaseInfo.currency_code}></td>
        </tr>
        <!-- 运费、合计金额（大写） -->
        <tr>
            <td colspan="4" class="td_left">运费：<{$purchaseInfo.pay_ship_amount}> <{$purchaseInfo.currency_code}></td>
            <td colspan="4" class="td_left">合计金额（大写）：<{$purchaseInfo.upper_amount}></td>
        </tr>
        
        <!-- 注意事项 -->
        <tr><td colspan="8" style="font-weight:bold;text-align:left;">注意事项：</td></tr>
        <!-- 注意事项内容 -->
        <tr style="height:250px;"><td colspan="8" valign="top" style="text-align:left;"><{$purchaseInfo.supplier_treaty}></td></tr>
        <!-- 采购方代表(签字盖章)、供方代表(签字盖章) -->
        <tr>
	        <td colspan="8">
	            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;">
	                <tr style="height:135px;">
		                <td class="td_left" valign="top">采购方代表(签字盖章)：</td>
		                <td class="td_left" valign="top">供方代表(签字盖章)：</td>
	                </tr>
	            </table>
	        </td>
        </tr>
    </table>
</div>