function Orders () {
	var init = function() {
		initList();
        checkAll();
        confirmOrder();
        cancelOrder();
        operationClick();
	}

	var initList = function() {
		EZ.url = '/order/Order/';
	    EZ.getListData = function (json) {
	        var html = '';
	        var i = paginationCurrentPage <= 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
	        $.each(json.data, function (key, val) {
	            html += (i + 1) % 2 == 1 ? "<tr class='table-module-b2'>" : "<tr class='table-module-b1'>";
	            html += "<td class='ec-center'><input type='checkbox' class='checkItem' name='orderId[]' ref_id='"+val.E0+"' value='" + val.E0 + "'/></td>";
                html += "<td class='ec-center'>" + (i++) + "</td>";
	            html += "<td>" + '销售单号：' + val.E2 + "<br>";
	            html += "采购公司：" + val.E6;
                html += "</td>";
                html += "<td class='ec-center'>";
	            $.each(val.EF, function(index, item) {
	                html += item.EF1 + "<br>";
	            });
	            html += "</td>";
	            html += "<td class='ec-center'>";
	            $.each(val.EF, function(index, item) {
	                html += item.EF2 + "<br>";
	            });
	            html += "</td>";
	            html += "<td class='ec-center'>" + val.E5 + "</td>";
	            html += "<td class='ec-center'>" + ((val.E3 == '0000-00-00 00:00:00')? '' : moment(val.E3).format('YYYY-MM-DD')) + "</td>";
	            html += "<td class='ec-center'>";
	            switch(val.E10) {
	                case '1':
                        html += "待确认";
                        break;
                    case '2':
                        html += "已确认";
                        break;
                    case '3':
                        html += "已取消";
                        break;
	                default:
	                    break;
	            }
	            html += "</td>";
                html += "<td class='ec-center'>" + ((val.E11 == '0000-00-00 00:00:00')? '' : moment(val.E11).format('YYYY-MM-DD')) + "</td>";
	            html += "<td class='ec-center'>";
                html += "<select class='operation-select'>";
                html += "<option value='0'>操作</option>"
                html += "<option" + " class=\"details\" data-id=\"" + val.E0 + "\" value='1'>" + '详情' + "</option>";
                html += "<option" + " class=\"print-contract\" data-uteid=\"" + val.E17 + "\" data-orderno=\"" + val.E2 + "\" data-status=\"" + val.E10 + "\" value='2'>" + '打印合同' + "</option>";
                html += "<option" + " class=\"print-sku\" data-id=\"" + val.E0 + "\" data-orderno=\"" + val.E2 + "\" value='3'>" + '打印sku条码' + "</option>";
                html += "</select>";
                html += "</td>";
	            
                html += "</tr>";
	        });
	        return html;
	    }
	}

	// 详情点击
	var orderDetails = function(self) {
		var i = 0,
            j = 0,
            dialogHtml = '';
        dialogHtml += '<div title="查看详情" id="dialog-edit-alert-tip" class="dialog-edit-alert-tip user-group-div">';
        dialogHtml += '<form id="editDataForm" name="editDataForm" class="submitReturnFalse">';

        //订单信息
        dialogHtml += '<div class="details-div">';
        dialogHtml += '<div class="order-details">';
        dialogHtml += '<table class="order-details-table">';
        dialogHtml += '<tbody>';
        dialogHtml += '<tr>';
        dialogHtml += '<td>销售单号：<span id="order_no"></span></td>';
        dialogHtml += '<td>结算方式：<span id="settle_way"></span></td>';
        /*dialogHtml += '<td>预付比例：<span id="pre_way_percent"></span></td>';*/
        dialogHtml += '<td>支付方式：<span id="pay_way"></span></td>';
        dialogHtml += '</tr>';
        dialogHtml += '<tr>';
        dialogHtml += '<td>预计交货时间：<span id="pre_commit_time"></span></td>';
        dialogHtml += '<td>运输方式：<span id="ship_way"></span></td>';
        dialogHtml += '<td>订单总价(￥)：<span id="order_price"></span></td>';
        dialogHtml += '<td>产品总数：<span id="order_amount"></span></td>';
        dialogHtml += '</tr>';
        dialogHtml += '</tbody>';
        dialogHtml += '</table>';
        dialogHtml += '</div>';
        // 商品信息
        dialogHtml += '<div class="item-details">';
        dialogHtml += '<table width="100%" border="0" class="table_order_details">';
        dialogHtml += '<tbody>';
        dialogHtml += '<tr class="table_order_details_title">';
        dialogHtml += '<td>产品代码</td>';
        dialogHtml += '<td>产品名称</td>';
        dialogHtml += '<td>产品数量</td>';
        /*dialogHtml += '<td>产品交货期</td>';*/
        dialogHtml += '<td>产品价格（￥）</td>';
        dialogHtml += '<td>应付总价（￥）</td>';
        dialogHtml += '</tr>';
        dialogHtml += '</tbody>';
        dialogHtml += '<tbody id="item_details_list_data">';
        dialogHtml += '</tbody>';
        dialogHtml += '</table>';
        dialogHtml += '</div>';
        // 日志信息
        dialogHtml += '<div class="log-details">';
        dialogHtml += '<table width="100%" border="0" class="table_order_details">';
        dialogHtml += '<tbody>';
        dialogHtml += '<tr class="table_order_details_title">';
        dialogHtml += '<td>销售日志序号</td>';
        dialogHtml += '<td>销售单状态</td>';
        dialogHtml += '<td>时间</td>';
        dialogHtml += '</tr>';
        dialogHtml += '</tbody>';
        dialogHtml += '<tbody id="log_details_list_data">';
        dialogHtml += '</tbody>';
        dialogHtml += '</table>';
        dialogHtml += '</div>';

        dialogHtml += '</div>';
        /*dialogHtml += '<input name="paramId" type="hidden" value="'+ $(this).data('val') + '" />';*/
        dialogHtml += '</form></div>';

        var editdialog = $(dialogHtml).dialog({
            autoOpen: true,
            width: '850',
            maxHeight: 'auto',
            modal: true,
            show: "slide",
            buttons: [
                {
                    text: "取消(Cancel)",
                    click: function () {
                        $(this).dialog("close");
                    }
                }
            ], close: function () {
                $(this).detach();
            }
        });

        $.ajax({
            type: "post",
            dataType: "json",
            url: EZ.url + 'order-details',
            data: {'id': self.data('id')},
            success: function(data) {
                if (data.state) {
                	var itemTemplate = '',
                		logTemplate = '',
                		logNo = 1;
                	// 订单信息
                	$('#order_no').text(data.data.order.E2);
                	$('#settle_way').text(data.data.order.E9);
                	/*$('#pre_way_percent').text(data.data.order.E8);*/
                	$('#pay_way').text(data.data.order.E7);
                	$('#pre_commit_time').text(((data.data.order.E3 == '0000-00-00 00:00:00')? '' : moment(data.data.order.E3).format('YYYY-MM-DD')));
                	$('#ship_way').text(data.data.order.E16);
                	$('#order_price').text(data.data.order.E5);
                	$('#order_amount').text(data.data.order.E14);
                	// 商品信息
                	$.each(data.data.items, function(index, item) {
                		itemTemplate += (i + 1) % 2 == 1 ? "<tr class='table-module-b2'>" : "<tr class='table-module-b1'>";
                		itemTemplate += '<td>' + item.E2 + '</td>';
                		itemTemplate += '<td>' + item.E3 + '</td>';
                		itemTemplate += '<td>' + item.E5 + '</td>';
                		/*itemTemplate += '<td>' + ((item.E4 == '0000-00-00 00:00:00')? '' : moment(item.E4).format('YYYY-MM-DD')) + '</td>';*/
                		itemTemplate += '<td>' + item.E7 + '</td>';
                		itemTemplate += '<td>' + ' ' + item.E8 + '</td>';
                		itemTemplate += '</tr>';
                        i++;
                	})
                	$('#item_details_list_data').append(itemTemplate);
                	// 日志信息
                	$.each(data.data.logs, function(index, log) {
                		logTemplate += (j + 1) % 2 == 1 ? "<tr class='table-module-b2'>" : "<tr class='table-module-b1'>";
                		logTemplate += '<td>' + logNo + '</td>';
                		logTemplate += '<td>';
                		switch(log.E2) {
			                case '1':
			                    logTemplate += "待确认";
			                    break;
			                case '2':
			                    logTemplate += "已确认";
			                    break;
			                case '3':
			                    logTemplate += "已取消";
			                    break;
			                default:
			                    break;
			            }
			            logTemplate += '</td>';
                		logTemplate += '<td>' + moment(log.E4).format('YYYY-MM-DD') + '</td>';
                		logTemplate += '</tr>';
                		logNo ++;
                        j++;
                	})
                	$('#log_details_list_data').append(logTemplate);

                	return ;
                }
                alertErrorTip(data.msssage);
            },
            error: function() {
            	alertErrorTip('网络错误！');
            }
        });
	}

    // 全选
    var checkAll = function() {
        $(".checkAll").on('click', function() {
            $(".checkItem").attr('checked', $(this).is(':checked'));
        });
    }

    // 打印合同
    var printContract = function(self) {
        var uteId = self.data('uteid'),
            orderNo = self.data('orderno'),
            div = $('#print-edit-dialog'),
            template = '<div title="打印合同" id="print-alert-tip"' +
                ' class="dialog-edit-alert-tip" data-uteId="' + uteId + '" data-orderNo="' + orderNo + '">' +
                div.html() + '</div>';
        $(template).dialog({
            autoOpen: true,
            width: 'auto',
            maxHeight: 'auto',
            modal: true,
            show: "slide",
            buttons: [
                {
                    text: "下载",
                    click: function () {
                        downloadContract();
                    }
                },
                {
                    text: "导出（pdf）",
                    click: function () {
                        printContractPdf();
                    }
                },
                {
                    text: "预览",
                    click: function () {
                        previewContract();
                    }
                }
            ], close: function () {
                $(this).detach();
            }
        });
    }

    // 预览合同
    var previewContract = function() {
        var div = $('#print-alert-tip'),
            uteId = div.data('uteid'),
            orderNo = div.data('orderno'),
            url = EZ.url + 'print-contract?uteId=' + uteId + '&orderNo=' + orderNo;
        window.open(url);
    }

    // 打印合同pdf
    var printContractPdf = function() {
        var div = $('#print-alert-tip'),
            uteId = div.data('uteid'),
            orderNo = div.data('orderno'),
            url = EZ.url + 'print-contract-pdf?uteId=' + uteId + '&orderNo=' + orderNo;
        window.open(url);
    }

    // 下载合同
    var downloadContract = function() {
        var div = $('#print-alert-tip'),
            uteId = div.data('uteid'),
            orderNo = div.data('orderno'),
            url = EZ.url + 'download-contract?uteId=' + uteId + '&orderNo=' + orderNo;
        window.open(url);
    }

    // 确认采购单
    var confirmOrder = function() {
        $('#confirm_order').on('click', function() {
            var checkbox = $(".checkItem:checked");
            if (checkbox.length == 0) {
                alertErrorTip('请勾选销售单！');
                return ;
            }
            var orderList = checkbox.closest('tr'),
                orderInfo = [];
            $.each(orderList, function(index, item) {
                var item = $(item),
                    print = item.find('td .print-contract'),
                    check = item.find('td .checkItem');
                orderInfo.push({
                    uteId: print.data('uteid'), 
                    orderNo: print.data('orderno'), 
                    status: print.data('status'),
                    orderId: check.val()
                });
            });

            orderOperate({order: orderInfo, type: 1});
        })
    }

    // 取消采购单
    var cancelOrder = function() {
        $('#cancel_order').on('click', function() {
            var checkbox = $(".checkItem:checked");
            if (checkbox.length == 0) {
                alertErrorTip('请勾选销售单！');
                return ;
            }
            var orderList = checkbox.closest('tr'),
                orderInfo = [];
            $.each(orderList, function(index, item) {
                var item = $(item),
                    print = item.find('td .print-contract'),
                    check = item.find('td .checkItem');
                orderInfo.push({
                    uteId: print.data('uteid'), 
                    orderNo: print.data('orderno'), 
                    status: print.data('status'),
                    orderId: check.val()
                });
            });

            orderOperate({order: orderInfo, type: 0});
        })
    }

    // 订单操作 
    var orderOperate = function(postData) {
        $.ajax({
            type: "post",
            dataType: "json",
            url: EZ.url + 'order-operate',
            data: postData,
            success: function(data) {
                var template = '';
                template += data.message + '<br>';
                if (data.data.confirmSuccess != undefined && data.data.confirmSuccess.length == undefined) {
                    template += '操作成功：';
                    $.each(data.data.confirmSuccess, function(index, item) {
                        template += item;
                        template += ','
                    });
                    template = template.substr(0, template.length - 1);
                    template += '<br>';
                }else if (data.data.cancelSuccess != undefined && data.data.cancelSuccess.length == undefined) {
                    template += '操作成功：';
                    $.each(data.data.cancelSuccess, function(index, item) {
                        template += item;
                        template += ','
                    });
                    template = template.substr(0, template.length - 1);
                    template += '<br>';
                }
                if (data.data.error != undefined && data.data.error.length == undefined) {
                    template += '操作失败：';
                    $.each(data.data.error, function(index, item) {
                        template += item;
                        template += ','
                    });
                    template = template.substr(0, template.length - 1);
                }
                initData(0);
                alertTip(template);
            },
            error: function() {
                alertErrorTip('网络错误！');
            }
        });
    }

    // 打印sku条码
    var printSku = function(self) {
        var orderId = self.data('id'),
            orderNo = self.data('orderno');
        url = EZ.url + 'print-sku-barcode?orderId=' + orderId + '&orderNo=' + orderNo;
        window.open(url);
    }

    // 操作点击事件
    var operationClick = function() {
        $('body').on('change', '.operation-select', function() {
            var self = $(this),
                type = self.val();

            switch(type) {
                case '1':
                    var option = self.find('option[value="1"]');
                    orderDetails(option);
                    break;
                case '2':
                    var option = self.find('option[value="2"]');
                    printContract(option);
                    break;
                case '3':
                    var option = self.find('option[value="3"]');
                    printSku(option);
                    break;
                default:
                    break;
            }
            self.val(0);
        })
    }

	return {
		'init': init
	}
}