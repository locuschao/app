<script language="javascript" src="/lodop/LodopFuncs.js?v=20140314"></script>
<script type="text/javascript" src="/lodop/lodop_print.js?v=20140314"></script>
<script type="text/javascript" src="/lodop/print_label.js?v=20140314"></script>
<style type="text/css">
table {
	border-collapse: collapse;
	border-spacing: 0;
}
.data-table {
	width: 100%;
	font-size: 13px;
}
.data-table th {
	text-align: right;
	font-weight: bold;
	padding: 8px 5px;
	border: 1px solid #D8E0E4;
	/*background: none repeat scroll 0 0 #f4faff;*/
	background: none repeat scroll 0 0 #e1effb;
}
.data-table td {
	padding: 8px 3px;
	border: 1px solid #D8E0E4;	
}
.data-table td.left {
	width: 20%;
	font-weight: bold;
	text-align: right;
	border: 1px solid #D8E0E4;
}
.data-table td.right {
	width: 30%;
	text-align: left;
	border: 1px solid #D8E0E4;
}
#message_tip{
	color: red;
	text-align: center;
	padding:5px;
    font-weight:bold;
}
#message_tip DIV{
	line-height: 20px;
	height: 20px;
}
.form-input {
	width: 160px;
	height: 28px;
	outline: 0;
	border: 1px solid #D8E0E4;
	padding: 0 5px;
}
    #customer_currency,#customer_balance{
        font-weight:bold;
    }
    #customer_code{
        font-size:14px;
    }
.table_module TD{
	padding: 8px 3px;
	border: 1px solid #D8E0E4;		
}
.module-title {
    font-weight: bold;
    padding-right: 5px;
    text-align: right;
}
.item_pint_set{
	width: 225px;
}
.save_Btn {
    background: none repeat scroll 0 0 #0097E3;
    border: medium none;
    border-radius: 5px;
    color: #FFFFFF;
    cursor: pointer;
    font-size: 14px;
    height: 30px;
    line-height: 30px;
    padding: 0 12px;
    text-align: center;
}
</style>
<script>
$(function(){
    try {
        LODOP = getLodopTip(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
        if ((LODOP == null) || (typeof(LODOP.VERSION) == "undefined")) {
            printerSetTip(1);
            return;
        }
        printerSetTip(0);
    } catch (err) {
        printerSetTip(1);
        return;
    }
    
	/*
	 * 遍历打印机
	 */
	var print_count = LODOP.GET_PRINTER_COUNT();
	var printers = {};
	for (var i = 0; i < print_count; i++) {
	    printers[i] = LODOP.GET_PRINTER_NAME(i);
	}
	
	//设置统一打印选项中的打印机项
	var unifiedSetPrint = new Array('#unifiedPaperSetPrint','#unifiedSmSetPrint','.item_pint_set');
	for ( var i = 0; i < unifiedSetPrint.length; i++) {
		var usp = unifiedSetPrint[i];
		var html = "";
		for (var b in printers) {
            html = "<option value='" + b + "'>" + printers[b]
                 + "</option>";
	        $(html).appendTo(usp);
        }
	}

	//选择纸张打印设置
	var paperJson = <{$paperJson}>;
	for (var p1 in paperJson) {
		var p1_val = $.cookie(p1);
		if(p1_val != '' && p1_val != null){
			$("#paper_print_set_" + p1).val(p1_val);
		}
	}
	

	var shipTemplateJson = <{$shipTemplateJson}>;
	for (var s1 in shipTemplateJson) {
		var s1_val = $.cookie(s1);
		if(s1_val != '' && s1_val != null){
			$("#sm_print_set_" + s1).val(s1_val);
		}
	} 
	
	/*
	 * 统一设置纸张打印
	 */
	$("#unifiedPaperSetPrint").live('change',function(){
		var val = $(this).val();
		$(".paper_print_set",".paper_printer_list").val(val);
	});

	/*
	 * 统一设置标签打印
	 */
	$("#unifiedSmSetPrint").live('change',function(){
		var val = $(this).val();
		$(".sm_print_set",".sm_printer_list").val(val);
	});

	/* $(".sm_type").live('change',function(){
		$(".unifiedSmSetPrint_tr").hide();
		var sm_type = $(this).val();
		seachSmType(sm_type);

		var sm_code = $.trim($("#sm_code").val());
		$("#sm_code").val(sm_code);
		seachSmCode(sm_code);
		
	}); */

	/* $("#sm_code").keyup(function (e) {
		var sm_type = $("input[name='type']:checked").val();
		seachSmType(sm_type);
		
        var key = e.which;
		var val = $.trim($(this).val());
		$(this).val(val);
		seachSmCode(val);
        
    }); */
});

//设置提示
function printerSetTip(t){
    if(t=='1'){
        $("#printer_set_tip").show();
        $("#content").hide();
    }else{
        $("#printer_set_tip").hide();
        $("#content").show();
    }
}

/* function seachSmType(type_code){
	if(type_code != ''){
		$(".sm_type_" + type_code).show();
	}else{
		$(".unifiedSmSetPrint_tr").show();
	}
	
	updateSmTrColor();
} */

function seachSmCode(val){
	if(val == ''){
		return;
	}

	val = val.toUpperCase();
	if($(".unifiedSmSetPrint_tr:visible").size() > 0){
		$(".unifiedSmSetPrint_tr:visible").each(function(k){
			var key = $(this).attr('data_val');

			var reg = new RegExp(""+val+"");  
			var str = key;//要匹配的字符串
			var bol = reg.test(str);
			
			if(!bol){
				$(this).hide();
			}
		});
	}
	
	updateSmTrColor();
}

/*
 * 更新地址标签TR的底色
 */
function updateSmTrColor(){
	if($(".unifiedSmSetPrint_tr:visible").size() > 0){
		$(".unifiedSmSetPrint_tr:visible").each(function(k){
			var s = 'table-module-b2';
			if((k +1) % 2 == 1){
				s = 'table-module-b1';
			}
			$(this).removeClass('table-module-b1');
			$(this).removeClass('table-module-b2');
			$(this).addClass(s);
		});
	}
}

function savePrinterForProfessional(){
	if ($(".item_pint_set").size() > 0) {
		$(".item_pint_set").each(function () {
			var paper = $(this).attr("data_key");
			var val = $(this).val();
			$.cookie(paper, val, {expires: 365, path: '/'});
		});
	}
	$.cookie("wmsPrinterOk", "1", {expires: 365, path: '/'});// 打印机设置成功
	//alertTip("<span class='tip-success-message'>设置成功!</span>");
    $("#message_tip").show().html('<{t}>operationSuccess<{/t}>');
    $('#message_tip').hide(3000);
}
</script>
<!-- 打印机初始化 -->
<input type="hidden" id="lodop_init" value="0">
<object id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
    <embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0 pluginspage="/lodop/install_lodop32.exe"></embed>
</object>
<div id="content" class="printer_set">
	<div style="width: 100px;height: 60px;border: 1px solid #D1E7FC;position: fixed;top: 10;right: 15px;text-align: center;">
		<input type="button" class="save_Btn" style="margin-top: 10px;" onclick="savePrinterForProfessional();" value="保存设置">
        <div id="message_tip"></div>
    </div>
<div style="width: 920px;border: 2px solid #D1D8DF;height: auto; margin-top: 2px;margin-bottom:5px; margin-left: auto;margin-right: auto;">
	<div style="padding-left: 5px;padding-top: 5px;width: 360px;float: left;">
        <h2 style="color: #E06B26;">打印控件：</h2>
        <table border="0" cellspacing="0" cellpadding="0" class="table_module paper_printer_list" style="width: 100%; margin-top: 5px;">
            <tbody>
            <tr class="table-module-b2">
                <td class="module-title">
                    32位
                </td>
                <td style="text-align: center;">
                    <a href='/lodop/install_lodop32.exe' target='_self'>点击下载</a><br>
                    (兼容64位系统)
                </td>
            </tr>
            <tr class="table-module-b1" style="display:none;">
                <td class="module-title">
                    64位
                </td>
                <td style="text-align: center;">
                    <a href='/lodop/install_lodop64.exe' target='_self'>点击下载</a>
                </td>
            </tr>
            <tr class="table-module-b1">
                <td class="module-title">
                    卸载方法
                </td>
                <td style="text-align: center;">
                    在安装文件名前添加"un",如<b>un</b>install_lodop32.exe
                </td>
            </tr>
            </tbody>
        </table>
		<h2 style="color:#E06B26;">纸张：</h2>
		<table border="0" cellspacing="0" cellpadding="0" class="table_module" style="width: 100%;">
            <tbody>
            <tr style="height: 36px;">
                <td class="module-title" style="font-weight: bold;padding-right: 5px;text-align: center;" colspan="2">
                	"纸张"打印统一指定为:
                </td>
            </tr>
            <tr>
            	<td colspan="2" style="text-align: center;">
                    <select id="unifiedPaperSetPrint" class="print_set">
        			</select>
                </td>
            </tr>
        	</tbody>
        </table>
        <table border="0" cellspacing="0" cellpadding="0" class="table_module paper_printer_list" style="width: 100%;margin-top: 5px;">
            <tbody>
            <{assign var='loop1' value=0}>
            <{foreach from=$paper key=key item=item}>
	            <{$loop1=$loop1+1}>                        
	            <tr class="<{if ($loop1 +1) % 2 == 1 }>table-module-b2<{else}>table-module-b1<{/if}>">
	                <td class="module-title" id="<{$key}>">
	                		<{$item}><br/>
	                		[<span style="color:#1B9301;"><{$key}></span>]
	                </td>
	                <td colspan="2" style="text-align: center;">
	                    <select class="item_pint_set paper_print_set" id="paper_print_set_<{$key}>" data_key="<{$key}>">
	        			</select>
	                </td>
	            </tr>
            <{/foreach}>
        	</tbody>
        </table>
	</div>
	<div style="padding-left: 5px;padding-top: 5px;width: 510px;margin-right:5px; float: right;">
		<h2 style="color:#E06B26;">标签尺寸：</h2>		
		<table border="0" cellspacing="0" cellpadding="0" class="table_module" style="width: 100%;">
            <tbody>
            <!-- <tr style="height: 36px;">
                <td class="module-title" width="150px;">运输代码:</td>
                <td>
                	<input type="text" class="input_text" id="sm_code" style="text-transform: uppercase;" placeholder="支持前后模糊匹配" />
                </td>
            </tr> -->
            <!-- 不需要 -->
            <!-- <tr style="height: 36px;">
                <td class="module-title" width="150px;">运输类型:</td>
                <td>
                	<label style="cursor: pointer;"><input type="radio" name="type" class="sm_type" checked="checked" value="">全部</label>&nbsp;&nbsp;
                    <label style="cursor: pointer;"><input type="radio" name="type" class="sm_type" value="0">快递</label>&nbsp;&nbsp;
					<label style="cursor: pointer;"><input type="radio" name="type" class="sm_type" value="1">空运</label>&nbsp;&nbsp;
					<label style="cursor: pointer;"><input type="radio" name="type" class="sm_type" value="2">海运</label>
                </td>
            </tr> -->
            <tr>
                <td class="module-title">
                	"标签"打印统一指定为:
                </td>
            	<td >
                    <select id="unifiedSmSetPrint" class="print_set">
                    	
                    </select>
                </td>
            </tr>
        	</tbody>
        </table>
        
        <table border="0" cellspacing="0" cellpadding="0" class="table_module sm_printer_list" style="width: 100%;margin-top: 5px;">
            <tbody>
            <{assign var='loop2' value=0}>
			<{foreach from=$shipTemplate key=key item=item}>
			<{$loop2=$loop2+1}>
            <tr class="<{if ($loop2 +1) % 2 == 1 }>table-module-b2<{else}>table-module-b1<{/if}>  sm_type_<{$key}> unifiedSmSetPrint_tr" data_val="<{$key}>">
                <td class="module-title" id="<{$key}>" style="width: 150px;">
                    <span style="color:#1B9301;">label<{$item.st_width}>x<{$item.st_height}></span>
                </td>
                <td colspan="2" style="text-align: center;">
                    <select class="item_pint_set sm_print_set" id="sm_print_set_<{$key}>" data_key="<{$key}>">
        			</select>
                </td>
            </tr>
            <{/foreach}>
        	</tbody>
        </table>
	</div>
	<div style="clear:both;"></div>
</div>
</div>
<div id="printer_set_tip" style="display:none;">
    <{include file='default/views/default/printer_set_tip.tpl'}>
</div>
