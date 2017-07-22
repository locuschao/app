$(function(){
	var w = parent.windowWidth();
    var h = parent.windowHeight();
	window.parent.$(".dialogIframe").dialog( "option", 
			"buttons", { 
				"关闭(Cancel)": function() { 
					window.parent.$(".dialogIframe").dialog("close");
				}
			}).width(w-400).height(h-100);
	var checkId = $("input[name='payType']:checked").attr("id");
	excuteTag();
	//单击radio，处理对应的dom变化
	$("input[name='payType']").click(function(){
		var check_temp = $(this).attr("id");
		if(check_temp == checkId){
			return;
		}
		
		excuteTag();//disabled所有的checkbox和text
		var obj_tr = $(this).parent().parent().parent();//找到单击dom所在的对应tr
		
		obj_tr.find(":input").removeAttr("disabled");//释放该radio下对应的input的disabled
		
		$("#payMoney").html("0.000");
		$("input[name='payMoney']").val("");
		
		checkId = $(this).attr("id");
	});
	
	// 默认显示全额
	var obj_tr = $("#payAll").parent().parent().parent(); 
	obj_tr.find(":input").removeAttr("disabled");
	obj_tr.find(":input").attr("checked","checked");
	
	/*
	 * 全额--SKU金额
	 */
	$("#purchase").live("click",function(){
		var arrayObj =getAllParams($(this))
		getAmount("1",arrayObj);
	});
	
	/*
	 * 全额--运费
	 */
	$("#freight").live("click",function(){
		var arrayObj =getAllParams($(this))
		getAmount("1",arrayObj);
	});
	
	
	/*
	 * 收货情况——到货数量额
	 */
	$("#arrivalNumber").live("click",function(){
		var paramsArray = getArrivalParams($(this));
		getAmount("2",paramsArray);
	});
	
	/*
	 * 收货情况——到货数量额
	 */
	$("#notArrivalNumber").live("click",function(){
		var paramsArray = getArrivalParams($(this));
		getAmount("2",paramsArray);
	});
	
	/*
	 * QC情况——合格
	 */
	$("#qualified").live("click",function(){
		var paramsArray = getQcParams($(this));
		getAmount("3",paramsArray);
	});
	
	/*
	 * QC情况——不合格
	 */
	$("#unqualified").live("click",function(){
		var paramsArray = getQcParams($(this));
		getAmount("3",paramsArray);
	});
	
	$("#prepaidAmount").live("keyup",function(){
		var valueAmount = $(this).val();
		$("#payMoney").html(new Number(valueAmount).toFixed(3));
    	$("input[name='payMoney']").val(new Number(valueAmount).toFixed(3));
	});
	/**
	 * 提交申请费用
	 */
	$("#subAppliy").live("click",function(){
		$('<div title="申请付款" id="dialog-application-for-payment"><p align="">预计付款时间：<input id="hefocus" name="hefocus" value="" size="1" style="width:0px;border:0;" type="text"><input type="text" name="pp_pay_date_eta" id="pp_pay_date_eta" class="datepicker input_text keyToSearch" value=""/></p></div>').dialog({
	        autoOpen: true,
	        width: 300,
	        modal: true,
	        show: "slide",
	        buttons: [
	            {
	                text: '确认(Confirm)',
	                click: function () {
	                	
	                	if(!testRegex($("input[name='payMoney']").val())){
	            			alertTip("申请金额必须是数字！");
	            			return;
	            		}
	                	
	                	var pp_pay_date_eta = $("#pp_pay_date_eta").val();
	                	pattern = /^\d{4}-\d{2}-\d{2}$/;
	                	if (pp_pay_date_eta!='' && !pattern.exec(pp_pay_date_eta)) {
	                		alertTip("请填写正确的预计付款时间！");
	            			return;
	                	}
	                	
	            		var _parent=window.parent;
	            		 $.ajax({
	                         type: "POST",
	                         async: false,
	                         dataType: "json",
	                         url: "/purchase/purchase-payment/sub-purchase-amount?pp_pay_date_eta=" + pp_pay_date_eta,
	                         data:$("#subApplyForm").serializeArray(),
	                         success: function (json) {
	                        	 if (!isJson(json)) {
	            	                    alertTip('Internal error.');
	            	             }
	            	             var html = '';
	            	             
	            	             if(json.status == '1'){
	            	            	 $("#dialog-application-for-payment").dialog("close");
	            	            	 html += '<span class="tip-success-message">申请成功</span>';
	            	             }else{
	            	            	 html += '<span class="tip-error-message">申请失败</span>';
	            	            	 html += '<span class="tip-error-message">'+json.message+'</span>';
	            	             }
	            	             tipSelf(html,json.status);
	                         }
	                    });
	                }
	            },
	            {
	                text: '取消(Cancel)',
	                click: function () {
	                    $(this).dialog("close");
	                }
	            }
	        ],
	        open: function () {
	        	$(".datepicker").datepicker({ dateFormat: "yy-mm-dd", defaultDate: -1});
	        },
	        close: function () {
	            $(this).detach();
	        }
	    });
		
	  });
	function tipSelf(html,check){
		$('<div title="提示(Tip)" id="dialog-auto-alert-tip"><p align="">' + html + '</p></div>').dialog({
            autoOpen: true,
            width: 400,
            modal: true,
            show: "slide",
            buttons: [
                {
                    text: '关闭(Close)',
                    click: function () {
                        $(this).dialog("close");
                    }
                }
            ],
            close: function () {
                $(this).detach();
                if(check == "1"){
                	var ifId = window.parent.$('.iframe-container:visible').attr('id');
//    				window.parent.frames[ifId].initData(paginationCurrentPage);
    				window.parent.$(".dialogIframe").dialog("close");
                }
            }
        });
	}
});

/**
 * 校验金额是否是数字
 * @param number
 * @returns {Boolean}
 */
function testRegex(number){
	var regex=/^[0-9]+\.?[0-9]*$/;
	if(regex.test(number)==false){
		return false;
	}
	return true;
}

/**
 * QC情况 参数设置 
 * @param obj
 * @returns {Array}
 */
function getQcParams(obj){
	var arrayObj = new Array();
	arrayObj[0] = $("#po_code").val();
	arrayObj[1] = "";
	arrayObj[2] = "";
	var tempTr = $(obj).parent().parent().parent();
	
	var qualified = tempTr.find("input[name='qualified']");
	var unqualified = tempTr.find("input[name='unqualified']");
	if(qualified.is(":checked")){
		arrayObj[1] = "true";
	}
	
	if(unqualified.is(":checked")){
		arrayObj[2] = "true";
	}
	
	return arrayObj;
}

/**
 * 全部金额 参数设置 
 * @param obj
 * @returns {Array}
 */
function getAllParams(obj){
	var arrayObj = new Array();
	arrayObj[0] = $("#po_code").val();
	arrayObj[1] = "";
	arrayObj[2] = "";
	var tempTr = $(obj).parent().parent().parent();
	
	var purchase = tempTr.find("input[name='purchase']");
	var freight = tempTr.find("input[name='freight']");
	if(purchase.is(":checked")){
		arrayObj[1] = "true";
	}
	
	if(freight.is(":checked")){
		arrayObj[2] = "true";
	}
	
	return arrayObj;
}
/**
 * 收货情况 参数设置 
 * @param obj
 * @returns {Array}
 */
function getArrivalParams(obj){
	var arrayObj = new Array();
	arrayObj[0] = $("#po_code").val();
	arrayObj[1] = "";
	arrayObj[2] = "";
	var tempTr = $(obj).parent().parent().parent();
	
	var arrivalNumber = tempTr.find("input[name='arrivalNumber']");
	var notArrivalNumber = tempTr.find("input[name='notArrivalNumber']");
	if(arrivalNumber.is(":checked")){
		arrayObj[1] = "true";
	}
	
	if(notArrivalNumber.is(":checked")){
		arrayObj[2] = "true";
	}
	
	return arrayObj;
}
/**
 * 获取申请支付金额
 * @param mode
 * @param array
 */
function getAmount(mode,array){
	$.ajax({
        type: "POST",
        async: false,
        dataType: "json",
        url: "/purchase/purchase-payment/get-purchase-amount",
        data:{mode:mode,ast:array},
        success: function (json){
        	if (!isJson(json)) {
                $("#payMoney").html("Internal error.");
            }
            if (json.status == '1') {
            	var amount = 0;
            	if($("input[name='payMoneyDis']").val() < json.data){
            		amount = $("input[name='payMoneyDis']").val();
            	}else{
            		amount = json.data;
            	}
            	
            	var numberAmount = new Number(amount);
            	$("#payMoney").html(numberAmount.toFixed(3));
            	$("input[name='payMoney']").val(numberAmount.toFixed(3));
            }else{
            	$("#payMoney").html("获取采购单总额失败！");
            	$("input[name='payMoney']").val("");
            }
    	}
    });
}

function excuteTag(){
	$("input[type='checkbox'],input[name='prepaid']")
		.attr("disabled","disabled")
		.attr('checked', false);
	$("input[name='prepaid']").val("");
}