$(function(){
    
		//控制结算方式输入框
//		excuteAccountPro();
//		$("#E5").live("change",function(){
//			excuteAccountPro();
//		});

		//控制运输承担方
		excuteShip();
		$("#E17").live("change",function(){
			excuteShip();
		});
                
                //控制默认运输方式
		excuteShipMethod();
		$("#E26").live("change",function(){
			excuteShipMethod();
		});
		
		//控制结算方式
		excuteAccountPro();
		$("#E5").live("change",function(){
			excuteAccountPro();
		});
//		
//		// 支付方式
//		excuteAccountPro();
//		$("#E5").live("change",function(){
//			excuteAccountPro();
//		});
		
		// 支付方式
		excutePaymentMethod();
		$(".pm_id").live("change",function(){
			if($(this).val() == "2"){
				$(".bank", $(this).parents('tr')).hide();
				$(".online_pay", $(this).parents('tr')).show();
			} else {
				$(".bank", $(this).parents('tr')).show();
				$(".online_pay", $(this).parents('tr')).hide();
			}
		});

		$("#addContact").live("click",function(){
			var contact_tr = "<tr style = 'text-align: center;' class='table-module-b1'>";
			contact_tr += "<td style = 'display:none;'><input name = 'contact_id[]' class='contact_id' value = ''/></td>";
			contact_tr += "<td class='ec-center'><span class='msg'>*</span>&nbsp;<input name = 'contact_name[]' class='contact_name contact_input' value =''/></td>";
			contact_tr += "<td class='ec-center'><span class='msg'>*</span>&nbsp;<input name = 'contact_tel[]' class='contact_tel contact_input' value =''/></td>";
			contact_tr += "<td class='ec-center'><span class='msg'></span>&nbsp;<input name = 'contact_fax[]' class='contact_fax contact_input' value =''/></td>";
			contact_tr += "<td class='ec-center'><span class='msg'></span>&nbsp;<input name = 'contact_address[]' class='contact_address contact_input' value =''/></td>";
			contact_tr += "<td class='ec-center'><span class='msg'></span>&nbsp;<input name = 'contact_address_en[]' class='contact_address_en contact_input' value =''/></td>";
			contact_tr += "<td class='ec-center'><input name = 'contact_post[]' class='contact_post contact_input' value =''/></td>";
			contact_tr += "<td class='ec-center'><input name = 'contact_qq[]' class='contact_qq contact_input' value =''/></td>";
			contact_tr += "<td class='ec-center'><input name = 'contact_wechat[]' class='contact_wechat contact_input' value =''/></td>";
			contact_tr += "<td class='ec-center'><input name = 'contact_wangwang[]' class='contact_wangwang contact_input' value =''/></td>";
			contact_tr += "<td class='ec-center'><input name = 'contact_skype[]' class='contact_skype contact_input' value =''/></td>";
			contact_tr += "<td class='ec-center'><a href = 'javascript:void(0)' onclick = 'delContact(this)'>删除</a></td>";
			contact_tr += "</tr>";

			$(contact_tr).appendTo("#table-module-b1");
		});
		
		$("#addPaymentMethod").click(function() {
			var pm_id_clone = $("#pm_id_tpl").clone();
			var bank_tpl_clone = $("#bank_tpl").clone();
			var platform_type_tpl_clone = $("#platform_type_tpl").clone();
			var pm_status_tpl_clone = $("#pm_status_tpl").clone();
			
			var payment_method_tr = "<tr class='table-module-b1'>";
			payment_method_tr += "<td style = 'display:none;'><input name = 'spm_id[]' class='spm_id' value = ''/></td>";
			payment_method_tr += "<td><span class='msg'>*</span>"+ pm_id_clone.html() + "</td>";
			payment_method_tr += "<td>"
				+ "<div class='bank' style='display:none;'><span class='msg'>*</span>"
			    + bank_tpl_clone.html()
			    + "<input name = 'pm_bankname[]' class='pm_bankname' class='input_text' placeholder='请录入支行名称' style='width:150px;' value =''/>"
			    + "</div>"
			    + "<div class='online_pay'><span class='msg'>*</span>"
			    + platform_type_tpl_clone.html()
			    + "</div>"
			    + "</td>";
			
			payment_method_tr += "<td>"
				+ "<span class='msg'>*</span>&nbsp;"
				+ "<input name = 'pm_account[]' class='pm_account' value ='' style='width:250px;'/>"
				+ "</td>";
			
			payment_method_tr += "<td>"
				+ "<span class='msg'>*</span>&nbsp;"
				+ "<input name = 'pm_name[]' class='pm_name' value ='' style='width:80px;'/>"
				+ "</td>";
			
			payment_method_tr += "<td>"
				+ pm_status_tpl_clone.html()
				+ "</td>";
			
			payment_method_tr += "<td class='ec-center'><a href = 'javascript:void(0)' onclick = 'delContact(this)'>删除</a></td>";
			payment_method_tr += "</tr>";

			$(payment_method_tr).appendTo("#payment_method_table-module-b1");
		});

		//单击下拉框的时候清空下拉框内提示内容
		//$("select").live("click",function(){
		//	$(this).find(".tip_msg").remove();
		//});

		$(".tab").click(function(){
            $(".tabContent").hide();
            $(this).parent().removeClass("chooseTag");
            $(this).parent().siblings().addClass("chooseTag");
            $("#"+$(this).attr("id").replace("tab_","")).show();
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
    				window.parent.frames[ifId].initData(paginationCurrentPage-1);
    				window.parent.$(".dialogIframe").dialog("close");
                }
            }
        });
	}

	function verifySupplier(){
		//校验供应商代码
		if($("input[name='E1']").attr("disabled") == undefined){
			verifyText($("input[name='E1']"));
		}
		
		/*
		*名称不能为空
		*/
		checkResult = verifyText($("input[name='E2']"));

		/*
		*采购员
		*/
		verifySelect($("#E13"));

		/*
		*结算方式
		*/
		verifySelect($("#E5"));

		//周期结算和非周期结算校验不一样的内容
		if($("#E5").val() == "1"){
			//校验支付周期
			verifySelect($("#E20"));
//			testRegex($("input[name='E14']"));

			//如果选的是周期结算类型，则清空支付比例
//			$("input[name='E15']").val("");
		} 
		
		if($("#E5").val() == "2"){
			//校验支付比例
			verifyText($("input[name='E15']"));
			testRegex($("input[name='E15']"));

			if($("#E15").val() > 100) {
				$("#E15").val("");
				$("#E15").attr("placeholder","不能大于100");
				$("#E15").css("background","#FF85FF");
				$("#checkMsg").html("比例值不能大于100");
			}
			//如果选的是非周期结算类型，则清空支付周期
//			$("#E20").val("");
		}

		/*
		*支付方式
		*/
		verifySelect($("#E6"));

		/*
		 *运输信息校验
		 */
		verifySelect($("#E17"));

		 if($("#E17").val() == "2"){
			 verifySelect($("#E18"));
		 }else{
			 //如果选择的是供应商承担运费，则清空运输支付方式。
			 $("#E18").val("");
		 }

		/*
		 *QC不良品处理
		 */	
		 if($("input[name='E16']:checked").val() == undefined || $("input[name='E16']:checked").val() == null){
			 $(".qcMSG").html("(请选择,不良品处理方式！)");
			 $("#checkMsg").html("false");
		 }else{
			 $(".qcMSG").html("");
		 }
			
		 /*
		 *校验联系方式内容
		 */
		 //if($("#table-module-b1").find("tr").size() == 0){
		//	 $("#contactMsg").html("供应商至少存在一个联系人");
		// }
		 //校验联系人
		 $("#table-module-b1").find(".contact_name").each(function(i){
			if($(this).val() == "" && $(this).val().length == 0){
				$("#contactMsg").html($("#contactMsg").html()+" 第"+(i+1)+"行联系人名称不能为空！");
			}
		 }); 

		 //联系电话
		 $("#table-module-b1").find(".contact_tel").each(function(i){
			 if($(this).val() == "" && $(this).val().length == 0){
			 	$("#contactMsg").html($("#contactMsg").html()+" 第"+(i+1)+"行联系电话不能为空！");
			 }
		 });

		 // 账户
		 $("#payment_method_table-module-b1").find(".pm_account").each(function(i){
			 if($(this).val() == "" && $(this).val().length == 0){
			 	$("#payMsg").html($("#payMsg").html()+" 第"+(i+1)+"行账户不能为空！");
			 }
		 });
		 
		 // 账户名
		 $("#payment_method_table-module-b1").find(".pm_name").each(function(i){
			 if($(this).val() == "" && $(this).val().length == 0){
				 $("#payMsg").html($("#payMsg").html()+" 第"+(i+1)+"行账户名不能为空！");
			 }
		 });
		 
		 // 验证支付方式
		 excutePayType();
	}

	function testRegex(obj){
		var regex=/^[0-9]+\.?[0-9]*$/;
		if(obj.val() == "" && obj.val().length == 0){
			return;
		}
		if(regex.test(obj.val())==false){
			obj.val("");
			obj.attr("placeholder","必须是数字");
			obj.css("background","#FF85FF");
			$("#checkMsg").html("false");
		}
	}

	//校验必填文本框
	function verifyText(obj){
		var verifyResult = true;
		if(obj.val() == "" || obj.val().length == 0){
			obj.attr("placeholder","不能为空");
			obj.css("background","#FF85FF");

			verifyResult = false;

			$("#checkMsg").html("false");
		}else{
			obj.removeAttr("placeholder");
			obj.css("background","");
		}

		return verifyResult;
	}

	//校验必填下拉框
	function verifySelect(obj){
		var verifyResult = true;
		var pay_type = obj.val();
		if(pay_type == "" || pay_type.length == 0){
			//var option = $("<option class='tip_msg' selected = 'selected' value=''>").text("不能为空");
			//option.appendTo(obj);
			obj.css("background","#FF85FF");
			verifyResult = false;
			$("#checkMsg").html("false");
		}else{
			obj.css("background","");
		}

		return verifyResult;
	}


	function excuteShip(){
		if($("#E17").val() == "2"){
			$(".account_ship").show();
		}else{
			$(".account_ship").hide();
		}
	}
        
        function excuteShipMethod(){
		if($("#E26").val() != "1"){
			$(".ship_method").show();
		}else{
			$(".ship_method").hide();
		}
	}
	
	function excuteAccountPro(pm_id){
		if($("#E5").val() == "2"){
			$(".account_pro").show();
		}else{
			$(".account_pro").hide();
		}
	}
	
	function excutePaymentMethod(){
		$.each($(".pm_id"), function() {
			if($(this).val() == "2"){
				$(".bank", $(this).parents('tr')).hide();
				$(".online_pay", $(this).parents('tr')).show();
			} else {
				$(".bank", $(this).parents('tr')).show();
				$(".online_pay", $(this).parents('tr')).hide();
			}
		});
	}

	function excutePayType(){
		if($("#E6").val() == "1"){
			return true;
		}
		
		if($("#E6").val() == "2"){
			 var flag = true;
			 $("#payment_method_table-module-b1").find(".pm_id").each(function(i) {
				 if($(this).val() == "2" && $(".pm_status", $(this).parents('tr')).val() == 1){
					 flag = false;
					 return false;
				 }
			 });
			 if(flag) {
				 $("#payMsg").html("请至少维护一个【默认支付方式】【在线】对应的【可用】支付账号");
				 return false;
			 }
		} else if($("#E6").val() == "3") {
			var flag = true;
			 $("#payment_method_table-module-b1").find(".pm_id").each(function(i){
				 if($(this).val() == "3" && $(".pm_status", $(this).parents('tr')).val() == 1){
					 flag = false;
					 return false;
				 }
			 });
			 if(flag) {
				 $("#payMsg").html("请至少维护一个【默认支付方式】【银行卡】对应的【可用】支付账号");
				 return false;
			 }
		}
		
		return true;
	}

	//删除联系人
	function delContact(obj){
		$(obj).parent().parent().remove();
	}
	
	//点击图片，显示原图
	function viewImageDialog(si_id, src, width, height) {
		width = parseFloat(width);
		height = parseFloat(height);
		var wWidth = 1000;
		if (width > wWidth) {
			height = height*wWidth/width;
			width = wWidth;
		}
		var thtml = '<div id="view_image_dialog" title="查看图片">';
		thtml += '<img src="'+ src +'" width="'+width+'">';
		thtml += '</div>';
		$(thtml).dialog({
	        autoOpen: true,
	        width: (width + 27),
	        maxHeight: (height + 200),
	        modal: true,
	        show: "slide",
	        close: function () {
	            $(this).detach();
	        }
	    });
	}
