$(function () {
    $(".text-center,.textareaCss").click(function () {
        $(".text-center,.textareaCss").css('background-color', '#FFFFFF');
        $(this).css('background-color', '#FFFFCC');
    });

    $("#receivedQty").live('keydown',function(){
    	var objReceivedQty = $(this);
    	setTimeout(function(){
    		$("#errorMessage").html("实收数量与预期数量不匹配");
    		var receivedCount = objReceivedQty.parent().parent().find('td').eq(1).text();
    		if(receivedCount != objReceivedQty.val()){
    			$("#errorMessage").html("实收数量与预期数量不匹配");
    		}else{
    			$("#errorMessage").html("");
    		}
		}, 100);
    });
});
function valid() {
    var state = 1;
    var tip = '';
    $(".text-center").each(function (k, v) {
        if ($(this).val() == '') {
            if ($(this).attr("id") == 'product[category]') {
                $(this).parent().css('background-color', '#FFFFCC');
                tip += '请选择产品分类。<br>';
            }
            if ($(this).attr("id") == 'product[package]') {
                $(this).css('background-color', '#FFFFCC');
                tip += '请选择包材。<br>';
            }
            $(this).focus();
            $(this).css('background-color', '#FFFFCC');
            state = 0;
            return false;
        } else {
            var isNum = 0;
            if ($(this).attr('valid')) {
                isNum = $(this).attr('valid');
            }
            if (isNum == '1' && /[^\d]/.test($(this).val())) {
                state = 0;
                tip += $(this).attr('alt') + ' 必须填写数字。<br>';
                return false;
            } else if (isNum == '2' && !/^([1-9][0-9]*|0)(\.[0-9]+)?$/.test($(this).val())) {
                state = 0;
                tip += $(this).attr('alt') + ' 必须填写数字。<br>';
                return false;
            }
        }
    });
    var problemQty = 0;
    var isQcQty = $(".qcQty").size();
    $(".qcQty").each(function (k, v) {
        if ($(this).val() != '' && parseInt($(this).val()) != '0') {
            problemQty += parseInt($(this).val());
            var ref = $(this).attr('ref');
            var obj = $("[name='qcNote[" + ref + "]']");
            if (obj.val() == '') {
                obj.focus();
                obj.css('background-color', '#FFFFCC');
                state = 0;
                return false;
            }
        }
    });
    var selQty = parseInt($("#problemSellableQty").val());
    var problemQtyObj=$("#problemQty");
    var receivedQty = parseInt($("#receivedQty").val());
    var problemTotalQty = parseInt(problemQtyObj.val());
    var noLabelQty=0;
    if($("#noLabelQty").size()){
        var noLabelQty =parseInt($("#noLabelQty").val());
    }
    
    if (receivedQty < problemTotalQty && isQcQty > 0) {
        tip += '不合格总数量不能大于实收总数量。<br>';
        $(".text-center,.textareaCss").css('background-color', '#FFFFFF');
        problemQtyObj.css('background-color', '#FFFFCC');
    }
    if (problemTotalQty > parseInt(problemQty) && isQcQty > 0) {
        tip += '不合格总数量不能大于问题数量的总和。<br>';
        $(".text-center,.textareaCss").css('background-color', '#FFFFFF');
        problemQtyObj.css('background-color', '#FFFFCC');
    }
    if (receivedQty < noLabelQty) {
        tip += '未贴标数量不能大于实收总数量。<br>';
        $(".text-center,.textareaCss").css('background-color', '#FFFFFF');
        $("#noLabelQty").css('background-color', '#FFFFCC');
    }
    if (problemTotalQty > 0 && $("#shelf").val() == '') {
        tip += '当存在不合格数量时，必须填写临时货架。<br>';
        $("#shelf").css('background-color', '#FFFFCC');
    }
    if (selQty + problemTotalQty != receivedQty) {
        tip += '实收数量=不合格总数+合格总数。请检查确认填写的数量！<br>';
        $("#receivedQty").css('background-color', '#FFFFCC');
        $("#problemSellableQty").css('background-color', '#FFFFCC');
        $("#problemQty").css('background-color', '#FFFFCC');
    }

    /*    if (parseInt($("#problemQty").val()) < 1 && $("#shelf").val() != '') {
     tip += '当存在不合格数量为空时，不需要填写临时货架。<br>';
     $("#shelf").css('background-color', '#FFFFCC');
     }*/

    if ($("#shelves").size() > 0 && (receivedQty - problemTotalQty) > 0 && $.trim($("#shelves").val()) == '') {
        tip += '请填写良品货架号。<br>';
        $("#shelves").css('background-color', '#FFFFCC');
    }

    if (tip != '') {
        alertTip(tip);
        state = 0;
    }
    return state;
}

function submitQc() {
    if (!valid()) {
        return false;
    }
    
    var check = '';

    //var selQty = parseInt($("#problemSellableQty").val());
    //var problemQty = parseInt($("#problemQty").val());
    var receivedQty = parseInt($("#receivedQty").val());
    var qc_quantity = parseInt($("#qc_quantity").val());
    if(qc_quantity!=receivedQty){
        check += '<span class="tip-warning-message" style = "color:red;">实收数量与预期数量不匹配</span>';
    }
    /*
    if((selQty+problemQty) != receivedQty){
    	check += '<span class="tip-warning-message" style = "color:red;">实收数量=不合格总数+合格总数。请检查确认填写的数量！</span>';
    }
    */
    if(check.length > 0 || check != ""){
    	check += '<span class="tip-warning-message" style = "color:red;">是否继续？</span>';
    	
    	alertTip(check);
    	$('#dialog-auto-alert-tip').dialog('option',
                'buttons',
                {
                    "否(Cancel)": function () {
                        $(this).dialog("close");
                        return;
                    }, "是(OK)": function () {
                    $(this).dialog("close");
                    excuteSub();
                }
         });
    }else{
    	excuteSub();
    }
    
    
}

function excuteSub(){
	submitArea(0);
    $.ajax({
        type: "post",
        async: false,
        dataType: "json",
        url: '/receiving/quality-control/submit',
        data: $("#QcForm").serialize(),
        success: function (json) {
            if (isJson(json)) {
                if (json.state == '1') {
                    alertTip(json.message);
                    location.reload();
                    return;
                }
                submitArea(1);
                var html = '';
                $.each(json.error, function (k, v) {
                    html += '<span class="tip-error-message">' + v.errorMsg + '</span>'
                });
                alertTip(html);
            } else {
                submitArea(1);
                alertTip('5000 Internal error');
            }
        }
    });
}

$(function () {
    $("#product-category-dialog").dialog({
        autoOpen: false,
        modal: true,
        width: 760,
        height: 500,
        show: "slide",
        buttons: {
            '取消(Cancel)': function () {
                $(this).dialog('close');
            }
        },
        close: function () {
            $(this).dialog('close');
        }
    });
});

function listCategory(t, v) {
    $.ajax({
        type: "post",
        async: false,
        dataType: "json",
        url: '/receiving/quality-control/get-category-list/search/1',
        data: {
            pce_parent_id: v,
            pce_level: t * 1 + 1
        },
        success: function (json) {

            var optionStr = '<option value="">ALL</option>';
            var controller = '';
            if (json.state == 1) {
                $.each(json.data, function (k, v) {
                    optionStr += '<option value="' + v.pce_ebay_cid + '">' + v.pce_title + '</option>';
                });
            }
            if (t == '1') {
                $("#pce_level_c").html('<option value="">ALL</option>');
                $("#pce_level_b").html(optionStr);
                submitSearch();
            } else if (t == '2') {
                $("#pce_level_c").html(optionStr);
                submitSearch();
            }

        }});
}

EZ.url = '/receiving/quality-control/get-category-';
EZ.getListData = function (json) {
    var html = '';
    var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
    $.each(json.data, function (key, val) {
        html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
        html += "<td class='ec-center'>" + (i++) + "</td>";
        html += "<td >" + val.pce_title + "</td>";
        html += "<td >" + val.pce_level + "</td>";
        html += "<td >" + val.pce_hs_code + "</td>";
        html += "<td><a href=\"javascript:addCategory(" + val.pce_id + ",'" + val.pce_title + "')\">选择</a></td>";
        html += "</tr>";
    });
    return html;
}

function addCategory(id, title) {
    $("[name='product[category]']").val(id);
    $("#productCategoryTitle").html(title);
}

function selectCategory() {
    $("#product-category-dialog").dialog("open");
}

function stopQc() {
    var html = '';
    html += '备注：<textarea class="textareaCss" name="description" id="description" cols="56"></textarea>';
    html += '<div id="dialog-message" style="padding:8px 0 0 40px;color:red;font-weight:bold;"></div>';
    $('<div title="产品未到货" id="dialog-receiving-alert-tip">' + html + '</div>').dialog({
        autoOpen: true,
        width: 460,
        modal: true,
        show: "slide",
        buttons: [
            {
                text: '确定(Ok)',
                click: function () {
                    if ($("#description").val() == '') {
                        $("#dialog-message").html('请填写备注.');
                        return false;
                    }
                    submitArea(0);
                    $.ajax({
                        type: "post",
                        async: false,
                        dataType: "json",
                        url: '/receiving/quality-control/stop',
                        data: {
                            qcId: $("#qcId").val(),
                            remark: $("#description").val()
                        },
                        success: function (json) {
                            if (isJson(json)) {
                                if (json.state == '1') {
                                    $("#dialog-receiving-alert-tip").dialog("close");
                                    alertTip(json.message);
                                    location.reload();
                                    return;
                                }
                                submitArea(1);
                                var html = '';
                                $.each(json.error, function (k, v) {
                                    html += '<span style="width:100%;clear:both;">' + v.errorMsg + '</span>'
                                });
                                $("#dialog-message").html(html);
                            } else {
                                submitArea(1);
                                $("#dialog-message").html('5000 Internal error');
                            }
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
        close: function () {
            $(this).detach();
        }
    });
}

function submitArea(t) {
    if (t) {
        $("#submitArea").show();
    } else {
        $("#submitArea").hide();
    }
}

function printLabel() {
    var product_barcode = $("#productBarcode", "#QcForm").val();
    var barcode =""
    var print_sku = "";//用于判断：打印产品条码时，是否需要在条码下方加上：（XXXXXX）——系统产品sku代码
    var printData={};
    //获取条码内容
    $.ajax({
        type: "post",
        async: false,
        dataType: "json",
        url: "/receiving/quality-control/get-barcode?receivingCode="+$("#quality_reciving_code").html()+"&productBarcode="+product_barcode+"&qcCode="+$("#printQcCode").val(),
        success: function (json) {
            var html = '';
            if (isJson(json)) {
                if(json.state){
                	barcode = json.data;
                	print_sku = json.product_sku;
                    printData=json.printData;
                }
            }
        }
    });

    if(barcode == "" || barcode.length == 0){
    	alertTip("<span class = 'tip-error-message'>未找到产品条码内容，请确认产品条码是否有配置</span>");
    	return;
    }
    var noLabelQty = 0;
    if($("#noLabelQty", "#QcForm").size()){
        noLabelQty = $("#noLabelQty", "#QcForm").val();
    }
    var productCategoryId = $("#productCategoryId", "#QcForm").val();
    var customerCode = $("#customerCode", "#QcForm").val();
    var firstReceived = $("#firstReceived", "#QcForm").val();
    var productCategory = $("#productCategory", "#QcForm").val();
    var isBattery = $("#isBattery", "#QcForm").val();
    var firstPartySystem = $("#firstPartySystem", "#QcForm").val();
    var labelWidth = $("#labelWidth", "#QcForm").val();
    var labelHeight = $("#labelHeight", "#QcForm").val();
    var printType = "1";
    var productTitle = $("#product_title", "#QcForm").html();
    var po_code = $("#po_code", "#QcForm").html();
    /*    if(firstReceived=='0'){
     productCategoryId=$("#product[category]","#QcForm").val();
     }*/
    var html = '';
    html += '<input type="hidden" value="' + barcode + '" name="productBarcode" />';
    html += '<input type="hidden" value="5x2" name="printType">';
    html += '<input type="hidden" value="' + productCategoryId + '" name="productCategoryId">';
    html += '<input type="hidden" value="' + customerCode + '" name="customerCode">';
    html += '<table class="table-module" border="0" cellpadding="0" cellspacing="0" style="width:100%">';
    html += "<tbody><tr class='table-module-title'><td>产品条码</td><td>条码数量</td></tr><tbody>";
    html += "<tbody><tr class='table-module-b1'>";
    html += "<td>" + barcode + "</td>";
    html += '<td><input name="printQty" id="printQty" size="9" value="' + noLabelQty + '"  class="text-center"></td>';
    html += "</tr><tbody>";
    html += '</table>';
    html += '<div id="dialog-print-message" style="padding:8px 0 0 8px;color:red;font-weight:bold;"></div>';
    $('<div title="产品标签" id="dialog-auto-alert-tip"><form id="printLabelForm" name="printLabelForm" action="/receiving/quality-control/print-label" method="post" target="_blank">' + html + '</form></div>').dialog({
        autoOpen: true,
        width: 650,
        modal: true,
        show: "slide",
        buttons: [
            {
                text: '打印机设置(printerSetup)',
                click: function () {
                    printerSetup();
                }
            },
            /*
            {
                text: '打印(Print)',
                click: function () {
                    var Qty = $("#printQty", "#printLabelForm").val();
                    if (Qty == '' || parseInt(Qty) < 1) {
                        $("#dialog-print-message").html('请填写条码数量.');
                        return false;
                    }
                    $("#printLabelForm").submit();
                    $(this).dialog('close');
                }
            },
            */
            {
                text: '控件打印(Print)',
                click: function () {
                    var Qty = $("#printQty", "#printLabelForm").val();
                    if (Qty == '' || parseInt(Qty) < 1) {
                        $("#dialog-print-message").html('请填写条码数量.');
                        return false;
                    }
                    //customerCode = firstPartySystem == '1' ? '' : customerCode;
                    //printLabelHtml(barcode, Qty, customerCode, productCategory, isBattery, 1);
                    var param = {};
                    param.code = barcode;
                    param.intCopies = Qty;
                    param.categoryName = productCategory;
                    param.isBattery = isBattery;
                    param.isQc = 1;
                    //param.printerNo = 'customProductLabel';
                    param.width = printData.width;//单位mm
                    param.height = printData.height;
                    param.printType = printType;
                    param.product_title = printData.product_title;
                    param.po_code = printData.po_code;
                    param.product_sku = printData.product_sku;
                    param.printType = "1";//不需要打印质检条码
                    param.productReceiveStatus = printData.productReceiveStatus;//首次收货
                    param.productLocation = printData.productLocation;//货位
                    param.show_title = printData.show_title;
                    param.show_location = printData.show_location;
                    param.show_po_code = printData.show_po_code;
                    param.printQc = printData.print_qc;
                    printCustomLabelHtml(param);
                    $(this).dialog('close');
                }
            },
            {
                text: '取消(Cancel)',
                click: function () {
                    $(this).dialog("close");
                }
            }
        ],
        close: function () {
            $(this).detach();
        }
    });
    $("#printQty", "#printLabelForm").select().focus();
}