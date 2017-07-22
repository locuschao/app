var pre_remeber_sn="";
$(function(){
	$(":input[name='supplier_name']").live('focus', function() {
		//记录文本 supplier_name 值
		pre_remeber_sn=$(this).parent().find('#supplier_name').val();
		$(this).autocomplete({
			source : "/purchase/purchase-others/get-by-keyword/limit/50",
			minLength : 2,
			delay : 100,
			select : function(event, ui) {
				$(this).siblings('#E2').val(ui.item.supplier_id);
				$(this).siblings('#supplier_name').val(ui.item.supplier_name);
				var buyer_id = ui.item.buyer_id;
				var def_buyer_id = '无默认采购员';
				$('#supplier_dialog_form .buyer_id option').each(function(){
					var text = $(this).attr('user_name');
					if(buyer_id&&buyer_id==$(this).attr('value')){
						def_buyer_id= "当前默认采购员:"+text;
						text+=" [供应商默认采购员]";
					}
					$(this).text(text);
					
				});
				$('#supplier_dialog_form .buyer_id').trigger('chosen:updated');
				$('#supplier_dialog_form .def_buyer_id').text(def_buyer_id); 
				
//				$(this).siblings('#supplier_code').val(ui.item.supplier_code);
			}
		});
	}).live('blur', function() {
//		$(this).parent().find('.msg_sup').html(pre_remeber_sn);
		var curr_sn=$(this).parent().find('#supplier_name').val();
		//文本框值改变
		if(curr_sn != pre_remeber_sn){
			$(this).siblings('#E2').val('');
		}
		$(this).unbind('blur');
		var param={};
		param['supplier_id']=$(this).parent().find('#E2').val();
		param['supplier_name']=$(this).parent().find('#supplier_name').val();
		var error_element=$(this).parent().find('.msg_sup');
		if(!param['supplier_name']){
			error_element.html("必填");
			return;
		}
		//文本框值没改变就不验证
		if(curr_sn == pre_remeber_sn){return false;}
		var temp_this=this;
		$.ajax({
	        type: "POST",
	        async: false,
	        dataType: "json",
	        url: "/supplier/product/is-set-supplier",
	        data: param,
	        success: function (json) {
	        	var html = json.message;
	            if (!json.state) { 
	            	error_element.html("<font color='red'>"+json.message+"</font>");
	            }else{
	            	$(temp_this).siblings('#E2').val(json.data['supplier_id']);	
	            	error_element.html("");
	            }
	        }
	    });
//		alert($("#E2","#editDataForm").val());
	});
	
	$('.def_supplier_id').live('change',function(){
		var supplier_id = $(this).val();
		if(supplier_id==''){
			return;
		}
		var buyer_id = $('option:selected',this).attr('buyer_id');
		var def_buyer_id = '无默认采购员';
		$('#supplier_dialog_form .buyer_id option').each(function(){
			var text = $(this).attr('user_name');
			if(buyer_id&&buyer_id==$(this).attr('value')){
				def_buyer_id= "当前默认采购员:"+text;
				text+=" [供应商默认采购员]";
			}
			$(this).text(text);
			
		});
		$('#supplier_dialog_form .mycustom_chosen').trigger('chosen:updated');
		$('#supplier_dialog_form .def_buyer_id').text(def_buyer_id); 
	});
	//产品弹出框
	$("#product-category-dialog").dialog({
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
	
	
});

function selectProduct() {
	$("#suppiler_span").html($("#supplier_code","#dialog-edit-alert-tip").val()+$("#supplier_name","#dialog-edit-alert-tip").val());
	$("#suppiler_id_re").val($("#E2","#dialog-edit-alert-tip").val());
	$("#category-list-data").find("tr").remove();
    $("#page_pagination").html('');
    $("#product-category-dialog").dialog("open");
}
function listCategoryData(pageIndex) {	

	if(pageIndex < 1) pageIndex = 0;
	var pageSize = 10, current = parseInt(pageIndex) + 1;	
	
	var i = current < 1 ? 1 : pageSize * (current - 1) + 1;
	var uri = '/supplier/product/get-product/page/'+current+'/pageSize/' + pageSize;
	$.post(uri, $('#searchForm_product').serialize(), function(json){
		var html = '';
		if(json.state==0) html = '没有数据';
		else {
			$.each(json.data, function (key, val) {
	            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1' id='"+val.product_barcode+"'>" : "<tr class='table-module-b2'>";
	            html += "<td class='ec-center'>" + (i++) + "</td>";
	            html += "<td class='ec-center'>" + val.product_barcode + "</td>";
	            html += "<td class='ec-center'>" + val.product_title + "</td>";
	            html += "<td><a name='"+val.product_id+"' href=\"javascript:addProduct('" + val.product_barcode + "')\">选择</a></td>";
	            html += "</tr>";
	        });
		}
        $('#product-list-data').html(html);
        $("#page_pagination").pagination(json.total, {
            callback: listCategoryData,
            items_per_page: pageSize,
            num_display_entries: 6,
            current_page: pageIndex,
            num_edge_entries: 2
        });
	},'json');
}

function addProduct(product_code){
	$("#E3","#dialog-edit-alert-tip").val(product_code);
	$("#product-category-dialog").dialog("close");
}