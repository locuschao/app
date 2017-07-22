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
        <tr>
            <td width="30"><b>NO.</b></td>
            <td width="90"><b><{if $is_img=="1"}>图片<{else}>SKU<{/if}></b></td>
            <td width="100"><b>供应商品号</b></td>
            <td width="166"><b>商品中/英文详情</b></td>
            <td width="70"><b>单价(<{$purchaseInfo.currency_code}>)</b></td>
            <td width="40"><b>数量</b></td>
            <td width="60"><b>金额(<{$purchaseInfo.currency_code}>)</b></td>
            <td width="143"><b>备注</b></td>
        </tr>
        <!-- 采购单明细 -->
        <{foreach from=$detailProduct key=key item=val}>
        <tr>
            <td><{$val.sorting}></td>
            <td><{$val.product_barcode}><{if $is_img=="1"}><br/><img width="87" height="69" src="<{$val.product_image_url}>"><{/if}></td>
            <td><{$val.sp_supplier_sku}></td>
            <td>中文：<{$val.product_title}><br/>英文：<{$val.product_title_en}></td>
            <td><{$val.unit_price}></td>
            <td><{if $val.qty_eta}><{$val.qty_eta}><{else}><{$val.qty_expected}><{/if}></td>
            <td><{$val.payable_amount}></td>
            <td><{$val.note}></td>
        </tr>
        <{if $val.self_property}><tr><td colspan="8" style="text-align:left;text-indent:3px;">产品自定义属性：<{$val.self_property}></td></tr><{/if}>
        <{/foreach}>
    </table>
</div>