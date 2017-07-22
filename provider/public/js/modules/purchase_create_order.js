$(function(){
	// autocomplete 自动提示
	$(".select_supplier").live('focus', function() {
		$(this).autocomplete({
			source : "/purchase/purchase-others/get-by-keyword/limit/50",
			minLength : 2,
			delay : 100,
			select : function(event, ui) {
				$(this).siblings('.supplier_code').val(ui.item.supplier_code);
				$(this).siblings('.supplier_id').val(ui.item.supplier_id);

	            var accountType = (ui.item.account_types[ui.item.account_type] ? ui.item.account_types[ui.item.account_type] : '')
	            $("#account_type").val(ui.item.account_type);

	            if(ui.item.account_type == 1) {
	            	$("#account_type_txt").html(accountType);
	            } else {
	            	$("#account_type_txt").html(accountType + "<span style='color:red;'>[预付比例：" + ui.item.account_proportion+"%]</span>");
	            }
			}
		});
	}).live('blur', function() {

	});

	$("#supplier_id").live("change",function(){
		$supplierId = $(this).val();
		$.ajax({
            type: "POST",
            async: false,
            dataType: "json",
            url: "/purchase/purchase-opration/get-supplier-account",
            data:{supplier_id:$supplierId},
            success: function (json) {
            	if (!isJson(json)) {
                    alertTip('Internal error.');
                }
                var html = '';
                if (json.state == '1') {
    	            $("#account_type").val(json.data.account_type);
    	            $("#pay_type").val(json.data.pay_type);
                    $("#shipping_method_id_head").val(json.data.shipping_method_id_head);
                    if(json.data.shipping_method_id_head != '1'){
                        $("#ps_id").show();
                        $("#open_add_shiper").show();
                        $("#ps_id").val(json.data.ps_id);
                    }else{
                        $("#ps_id").hide();
                        $("#open_add_shiper").hide();
                        $("#ps_id").val("");
                    }
                    if(PURCHASE_TRACK_PEOPLE == '1'){
                        $("#pts_oprater").val(json.data.track_id);
                        //$("#operator_purchase").val(json.data.buyer_id);
                        //$('#operator_purchase').trigger('chosen:updated');
                        $('#pts_oprater').trigger('chosen:updated');
                    }
    	            if(json.data.account_type != 2) {
    	            	$("#account_proportion").val("");
    	            	$("#account_proportion_span").hide();
    	            } else {
    	            	$("#account_proportion").val(json.data.account_proportion);
    	            	$("#account_proportion_span").show();
    	            }
    	            
    	            if (json.data.pay_type == '2') {
    	        		$("#show_alipay_account").show();
    	        	} else {
    	        		$("#alipay_account").val('');
    	        		$("#show_alipay_account").hide();
    	        	}
                }
            }
        });
	});


	$("#ch_no_stok").live("click",function(){
		listCategoryData(0);
	});

	$(".shipping_method_id_head_code_name").live('focus', function() {
		var warehouseId = $("#warehouse_id").val();
		$(this).autocomplete({
			source : "/purchase/purchase-others/get-by-method/limit/50/wearhouse/"+warehouseId,
			minLength : 2,
			delay : 100,
			select : function(event, ui) {
				$(this).siblings('.shipping_method_id_head').val(ui.item.sm_code);
				$(this).siblings('.shipping_method_id_head_code').val(ui.item.sm_name_cn);
			}
		});
	}).live('blur', function() {

	});

	$(".headNameShow").live('focus', function() {
		$(this).autocomplete({
			source : "/purchase/purchase-others/get-by-method/limit/50",
			minLength : 2,
			delay : 100,
			select : function(event, ui) {
				$(this).siblings('.headCode').val(ui.item.sm_code);
				$(this).siblings('.headName').val(ui.item.sm_name_cn);
			}
		});
	}).live('blur', function() {

	});

	//选择采购商弹出框
	$("#select-supplier-dialog").dialog({
        autoOpen: false,
        modal: true,
        width: 760,
        height: 500,
        show: "slide",
        buttons: {
            '关闭(Cancel)': function () {
                $(this).dialog('close');
            }
        },
        close: function () {
            $(this).dialog('close');
        }
    });

	//选择运输方式弹出框
	$("#select-method-dialog").dialog({
        autoOpen: false,
        modal: true,
        width: 760,
        height: 500,
        show: "slide",
        buttons: {
            '关闭(Cancel)': function () {
                $(this).dialog('close');
            }
        },
        close: function () {
            $(this).dialog('close');
        }
    });

	//批量设置头程运输方式
//	$("#selectHeadMethod").dialog({
//        autoOpen: false,
//        modal: true,
//        width: 400,
//        height: 150,
//        show: "slide",
//        buttons: {
//        	'确定(OK)': function () {
//                $(".productCheck:checked").each(function(){
//            		if($("#headCode").val() == "" || $("#headCode").val().length == 0){
//                		alertTip("非法运输方式！");
//                		return;
//                	}
//                	$(this).parent().parent().find(".method_dis").val(
//                			$("#headCode").val()
//                	);
//                });
//                $(this).dialog('close');
//            },
//            '关闭(Cancel)': function () {
//                $(this).dialog('close');
//            }
//        },
//        close: function () {
//            $(this).dialog('close');
//        }
//    });

	$("#selectSupplier").click(function(){
		$("#supplier-list-data tr").remove();
		$("#supplier").val("");
		listSupplierData(0);
		$("#select-supplier-dialog").dialog("open");
	});

	$("#selectMethod").click(function(){
		$("#method-list-data tr").remove();
		$("#method").val("");
		$("#shipping_warehouse_id").val($("#warehouse_id").val());
		$("#method_pagination").html("");
		$("#select-method-dialog").dialog("open");

	});

    /**
     * 设置头程运输方式
     */
    $("#method_dis").live("change",function(){
    	if($(this).val() == ""){
    		return;
    	}
    	if($("#table-product-list-data").find("tr").size() == 0){
    		$("#messageMe").html("请先添加采购产品信息！").css("color","red");
    		return;
    	}
    	if($(".productCheck:checked").size() == 0){
    		$("#messageMe").html("请勾选要设置的采购产品行！").css("color","red");
    		return;
    	}
    	$("#messageMe").html("");
    	$(".productCheck:checked").each(function(){
        	$(this).parent().parent().find(".method_dis").val(
        			$("#method_dis").val()
        	);
        });
    });
    $("#cretae_purchase_list").find(":checkbox").live("click",function(){
    	if($(this).attr("class") == "checkAll"){
    		if ($(this).is(':checked')) {
                $(".productCheck").attr('checked', true);
            } else {
                $(".productCheck").attr('checked', false);
            }
    	}
    	$("#messageMe").html("");
    	$(".productCheck:checked").each(function(){
        	$(this).parent().parent().find(".method_dis").val(
        			$("#method_dis").val()
        	);
        });


    });

    $("#account_type").change(function() {
    	if($(this).val() != 2) {
        	$("#account_proportion").val("");
        	$("#account_proportion_span").hide();
        } else {
        	$("#account_proportion").val();
        	$("#account_proportion_span").show();
        }
    });

});
//function setUpMethod(){
//	if($("#table-product-list-data").find("tr").size() == 0){
//		alertTip("请先添加产品信息！");
//		return;
//	}
//	if($(".productCheck:checked").size() == 0){
//		alertTip("请选择要设置的产品列！");
//		return;
//	}
//	$(".headNameShow,.headCode,.headName").val("");
////	$("#selectHeadMethod").dialog("open");
//}

function listSupplierData(pageIndex) {

	if(pageIndex < 1) pageIndex = 0;
	var pageSize = 10, current = parseInt(pageIndex) + 1;

	var i = current < 1 ? 1 : pageSize * (current - 1) + 1;
	var uri = '/purchase/Purchase-others/get-supplier/page/'+current+'/pageSize/' + pageSize;
	$.post(uri, $('#searchSupplierForm').serialize(), function(json){
		var html = '';
		if(json.state==0) html = '没有数据';
		else {
			$.each(json.data, function (key, val) {
	            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
	            html += "<td class='ec-center'>" + (i++) + "</td>";
	            html += "<td class='ec-center'>" + val.supplier_code + "</td>";
	            html += "<td class='ec-center'>" + val.supplier_name + "</td>";

	            var accountType = (json.accountType[val.account_type] ? json.accountType[val.account_type] : '')
	            html += "<td><a name='"+val.supplier_id+"' href=\"javascript:addSupplier('" + val.supplier_id + "','" + val.supplier_code + "','" + val.supplier_name + "','" + val.account_type + "','" + accountType + "','" + val.account_proportion + "')\">选择</a></td>";
	            html += "</tr>";
	        });
		}
        $('#supplier-list-data').html(html);
        $("#supplier_pagination").pagination(json.total, {
            callback: listSupplierData,
            items_per_page: pageSize,
            num_display_entries: 6,
            current_page: pageIndex,
            num_edge_entries: 2
        });
	},'json');
}

function listMethodData(pageIndex) {

	if(pageIndex < 1) pageIndex = 0;
	var pageSize = 10, current = parseInt(pageIndex) + 1;

	 	var i = current < 1 ? 1 : pageSize * (current - 1) + 1;
	var uri = '/purchase/Purchase-others/get-method/page/'+current+'/pageSize/' + pageSize;
	$.post(uri, $('#searchMethodForm').serialize(), function(json){
		var html = '';
		if(json.state==0) html = '没有数据';
		else {
			$.each(json.data, function (key, val) {
	            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
	            html += "<td class='ec-center'>" + (i++) + "</td>";
	            html += "<td class='ec-center'>" + val.sm_code + "</td>";
	            html += "<td class='ec-center'>" + val.sm_name_cn + "</td>";
	            html += "<td><a name='"+val.product_id+"' href=\"javascript:addMethod('" + val.sm_code + "','" + val.sm_name_cn + "')\">选择</a></td>";
	            html += "</tr>";
	        });
		}
        $('#method-list-data').html(html);
        $("#method_pagination").pagination(json.total, {
            callback: listMethodData,
            items_per_page: pageSize,
            num_display_entries: 6,
            current_page: pageIndex,
            num_edge_entries: 2
        });
	},'json');
}

/**
 * 添加备注
 */
function addText(obj){
	$("#addText").remove();
	var domLeft = $(obj).offset().left;
	var domTop = $(obj).offset().top;
	var selfHeight = $(obj).height();
	domTop = domTop - selfHeight-142;
	domLeft = domLeft-159-72;
	var sub = $(obj).attr("sub");
	var textArea = $("<textarea name='addText' id='addText' rows='8' placeholder='在此处放大框填写备注内容' onKeyUp = 'upToText("+sub+",this)' onblur = 'removeText()' cols='35'>")//onblur = 'removeText()'
					.css({
						position:'absolute',
						left: domLeft,
					  	top: domTop,
					  	fontSize:'12px'
//					  	backgroundColor:'#E8E8E8'
					});
	textArea.appendTo("body");
	textArea.val($(obj).val());
}

function upToText(sub,obj){
	$("input[sub='"+sub+"']").val($(obj).val());
}

/**
 * 删除备注框
 */
function removeText(){
	$("#addText").remove();
}

$(document).bind("click",function(e){
	var target = $(e.target);
	var inMailMenuDiv = target.closest("#addText").length > 0;
	var inText = target.closest("input[name='product_note[]']").length > 0;

	if(!inMailMenuDiv && !inText){
		$("#addText").animate({right:'-220px'},'slow');
		$("#addText").hide();
	}

});

/**
 * 添加供应商
 */
function addSupplier(supplier_id,supplier_code,supplier_name,account_type,accountType,account_proportion){
	$("input[name='suppiler_id']").val(supplier_id);
	$("input[name='supplier_code']").val(supplier_code);
	$("input[name='account_type']").val(account_type);

	if(account_type == 2) {
    	$("#account_type_txt").html(accountType);
    } else {
    	$("#account_type_txt").html(accountType + "<span style='color:red;'>[预付比例：" + account_proportion+"%]</span>");
    }
	$(".select_supplier").val(supplier_name);
	$("#select-supplier-dialog").dialog("close");
}

/**
 * 添加运输方式
 */
function addMethod(sm_code,sm_name_cn){
	$("input[name='shipping_method_id_head']").val(sm_code);
	$("input[name='shipping_method_id_head_code']").val(sm_name_cn);
	$(".shipping_method_id_head_code_name").val(sm_name_cn);
	$("#select-method-dialog").dialog("close");
}

//设置头程运输方式
function setupHeadMethod(isShow){
	var reOption = excuteHeadMethod();
	if(isShow == 'Y'){
		$("#method_dis").show();
	}

	$(reOption).appendTo("#method_dis");
}

function excuteHeadMethod(){
	//判断是否需要中转，中转采购单则需要根据中转仓库设置头程。如果不需要中转，则根据采购仓库设置即可
	var isTransit = $("input[name='rad']:checked").val();//0：需要中转。1：不需要中转
	var warehouse = "";
	if(isTransit == "0"){
		if($("#to_warehouse_id").val() == ""){
			$("#messageMe").html("请选择中转仓库！").css("color","red");
    		return;
		}else{
			warehouse = $("#to_warehouse_id").val();
		}
	}
	if(isTransit == "1"){
		if($("#warehouse_id").val() == ""){
			$("#messageMe").html("请选择采购仓库！").css("color","red");
    		return;
		}else{
			warehouse = $("#warehouse_id").val();
		}
	}

	var option = "";
	//根据仓库获取头程运输方式
	$.ajax({
        type: "POST",
        async: false,
        dataType: "json",
        url: "/purchase/purchase-opration/get-head-method",
        data:{warehouse:warehouse},
        success: function (json) {
            if (isJson(json)) {
            	if(json.status == '1'){
            		$("#method_dis").find("option").each(function(i){
            			if(i > 0){
            				$(this).remove();
            			}
            		});

            		$.each(json.data, function (k, v) {
            			option += "<option value = '"+v.sm_code+"'>"+v.sm_code+" "+v.sm_name_cn+"</option>";
                    });
            	}
            }

        }
    });

	return option;
}



