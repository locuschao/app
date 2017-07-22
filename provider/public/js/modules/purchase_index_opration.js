$(function(){
	$("#showMoreDoButton").click(function(){
		$("#printPurchase").show();
		$("#downLoadPurchase").show();
		$("#printContract").show();

		$(this).hide();
		$("#hideMoreDoButton").show();
		$("#doButton").show();
	});

	$("#hideMoreDoButton").click(function(){
		$(this).hide();
		$("#showMoreDoButton").show();
		$("#doButton").hide();
	});

	$("#printContract").click(function(){
		downLoadContract();
	});

	addUserStatus();

});

/**
 * 打印采购合同
 */
function printContract(orderId,orderNo){
    window.open("/purchase/purchase-others/print-contract?orderId="+orderId+"&orderCode="+orderNo);
}

/**
 * 下载采购合同
 */
function downLoadContract(orderId,orderNo){
	window.open("/purchase/purchase-orders/download-contract?orderId="+orderId+"&orderCode="+orderNo);
}

/**
 * 导出pdf采购合同
 */
function downLoadContractPdf(orderId,orderNo){
	window.open("/purchase/purchase-others/print-contract-pdf?orderId="+orderId+"&orderCode="+orderNo);
}

/**
 * 下载预估采购合同
 */
function downLoadTransferPurchaseContract(orderId,orderNo){
	window.open("/purchase/purchase-orders/download-transfer-purchase-contract?orderId="+orderId+"&orderCode="+orderNo);
}

/**
 * 下载外销采购合同
 */
function downLoadExportedTransferPurchaseContract(orderId,orderNo){
	window.open("/purchase/purchase-orders/download-exported-transfer-purchase-contract?orderId="+orderId+"&orderCode="+orderNo);
}


/**
 * 处理收货异常
 * @param orderId
 * @param orderNo
 */
function doReceiveException(orderNo){
	var w = parent.windowWidth();
    var h = parent.windowHeight();
	parent.openIframeDialog('/purchase/purchase-menu/process-received-exception?poCode='+orderNo,w-400,h-100,$.getMessage('purchase_js_oprationexception'));
}

/**
 * 页面加载添加采购负责任筛选项
 */
function addUserStatus(){
	setTimeout(function(){
		if($(".pack_manager").size() >= 1){
			var tbody_ = $("#searchfilterArea").find("tbody tr").eq(0);

			var responsible = $.getMessage('purchase_is_responsible');
			var statu_tr = $("<tr>");
			var statu_td = $("<td>");
			statu_td.appendTo(statu_tr);

			var statu_div_title = $("<div>");
			statu_div_title
				.addClass("searchFilterText")
				.css("width","90px")
				.text(responsible+"：");
			statu_div_title.appendTo(statu_td);


			var statu_div_item = $("<div>");
			statu_div_item.addClass("pack_manager");
			statu_div_item.appendTo(statu_td);
			var statu_div_input = $("<input>");
			statu_div_input
				.attr("id","userMark")
				.addClass("input_text keyToSearch")
				.attr("name","userMark")
				.attr("value","1")  //默认“与我相关”
				.css("display","none");  
			statu_div_input.appendTo(statu_div_item);

			var statu_div_a = $("<a>");
			var all = $.getMessage('js_all');
			statu_div_a
				.attr("onclick","selectByUser('userMark','',this)")
				.attr("href","javascript:void(0)")
				.addClass("selectUser")
				.text(all);
			statu_div_a.appendTo(statu_div_item);

			var statu_div_a = $("<a>");
			var andrelated = $.getMessage('purchase_js_andrelated');
			statu_div_a
				.attr("onclick","selectByUser('userMark','1',this)")
				.attr("href","javascript:void(0)")
				.addClass("selectUser myPermissions current")  //默认“与我相关”
				.text(andrelated);
			statu_div_a.appendTo(statu_div_item);

			var statu_div_a2 = $("<a>");
			var messageOther = $.getMessage('purchase_js_other');
			statu_div_a2
				.attr("onclick","selectByUser('userMark','2',this)")
				.attr("href","javascript:void(0)")
				.addClass("selectUser")
				.text(messageOther);
			statu_div_a2.appendTo(statu_div_item);

			tbody_.before(statu_tr);

			var tbody_track = $("#searchfilterArea").find("tbody tr").eq(2);
			var tbody_track2 = $("#searchfilterArea").find("tbody tr").eq(2);
			var track_tr = '<tr><td>';
			track_tr += '<div class="searchFilterText" style="width: 90px;">'+$.getMessage('purchase_js_purchasetrackstatus_new')+'：</div>';
			track_tr += '<div class="pack_manager">';
			track_tr += '<input type="hidden" class="input_text keyToSearch" id="E28" name="E28">';
			track_tr += '<a onclick="searchFilterSubmit(\'E28\',\'\',this)" href="javascript:void(0)">'+$.getMessage('js_all')+'</a>';
			$.ajax({
	            type: "POST",
	            async: false,
	            dataType: "json",
	            url: "/purchase/purchase-track-status/list",
	            data:{},
	            success:  function (json) {
	           		if (!isJson(json)) {
	                    alertTip('Internal error.');
	                }
	                if (json.state) {
	                	var locale = isEnLocale();
	                	$.each(json.data, function (k, v) {
	                		var pts_name = "";
	                		if(locale){
	                			pts_name = v.pts_name_en;
		                	}else{
		                		pts_name = v.pts_name;
		                	}
	                		track_tr += '<a onclick="searchFilterSubmit(\'E28\',\''+v.pts_status_sort+'\',this)" href="javascript:void(0)">'+pts_name+'</a>';
	                	});

	                }
	            }
	        });
			track_tr += '</div></td></tr>';

			var track_tr2 = '<tr><td>';
			track_tr2 += '<div class="searchFilterText" style="width: 90px;">'+$.getMessage('purchase_js_financetrackstatus')+'：</div>';
			track_tr2 += '<div class="pack_manager">';
			track_tr2 += '<input type="hidden" class="input_text keyToSearch" id="E40" name="E40">';
			track_tr2 += '<a onclick="searchFilterSubmit(\'E40\',\'\',this)" href="javascript:void(0)">'+$.getMessage('js_all')+'</a>';
			$.ajax({
	            type: "POST",
	            async: false,
	            dataType: "json",
	            url: "/purchase/purchase-track-status/finance-list",
	            data:{},
	            success:  function (json) {
	           		if (!isJson(json)) {
	                    alertTip('Internal error.');
	                }
	                if (json.state) {
	                	var locale = isEnLocale();
	                	$.each(json.data, function (k, v) {
	                		var fts_name = "";
	                		if(locale){
	                			fts_name = v.fts_name_en;
		                	}else{
		                		fts_name = v.fts_name;
		                	}
	                		track_tr2 += '<a onclick="searchFilterSubmit(\'E40\',\''+v.fts_status_sort+'\',this)" href="javascript:void(0)">'+fts_name+'</a>';
	                	});

	                }
	            }
	        });
			track_tr2 += '</div></td></tr>';


			var aa = $(track_tr);
			var bb = $(track_tr2);
			tbody_track.before(aa);
			tbody_track2.before(bb);
		}else{
			addUserStatus();
		}
		//仅显示与我相关
		if(PURCHASE_USER=='1') {
			selectByPermissions('userMark', '1', $(".myPermissions"));
		}
	}, 100);
}


//与我相关
function selectByPermissions(name, userMark, obj) {
	if (userMark == "1") {
		$("#purchaseUser").hide();
	} else {
		$("#purchaseUser").show();
	}
	loadState(userMark, "2");
	if(name!=null){
		$('input[name=' + name + ']', "#searchForm").attr('value', userMark);
		$(obj).parent().children("a").removeClass('current').hide();
		$(obj).addClass('current').show();
	}
}

/**
 * 采购责任人单击触发事件
 * @param name 表单名
 * @param userMark 表单值
 * @param obj 标签对象
 * @returns
 */
function selectByUser(name,userMark,obj){
	if(userMark == "1"){
		$("#purchaseUser").hide();
	}else{
		$("#purchaseUser").show();
	}
	loadState(userMark,"2");
	searchFilterSubmit(name,userMark,obj);

	setTimeout(function(){
		$(".custom_chosen").css("width","257");
	},100);
}

//采购单申请付款
function doApplyForPayment(poCode){
	var w = parent.windowWidth();
    var h = parent.windowHeight();
	parent.openIframeDialog('/purchase/purchase-payment/do-applay-payment?poCode='+poCode,w-400,h-100,$.getMessage('purchase_js_paymentrequest'));
}





