$(function(){
	
		//添加渠道行（<tr></tr>）
		$("#addServicChannel").live("click",function(){
			var channelRow_tr = $("#clone_data  #channelRow").clone().show();
			
			$(channelRow_tr).appendTo("#table-module-b3");
		});
		
		//添加银行行（<tr></tr>）
		$("#addBankAccount").live("click",function(){
			
			var bankAccount_tr = $("#clone_data #bankRow").clone().show();
			
			$(bankAccount_tr).appendTo("#table-module-b1");
		});
		
		//添加产品行（<tr></tr>）
		$("#addProduct").live("click",function(){
			
			var product_tr = $("#clone_data #productRow").clone().show();

			$(product_tr).appendTo("#table-module-b2");
		});
		
		$("input[name='sp_code']").live("blur",verifySpCode);
		
		
		$("#addContact").live("click",function(){
			var contact_tr = "<tr style = 'text-align: center;' class='table-module-b1'>";
			contact_tr += "contact_tr <td style = 'display:none;'><input name = 'contact_id[]' class='contact_id' value = ''/></td>";
			contact_tr += "<td class='ec-center'><input name = 'contact_name[]' class='contact_name' value =''/></td>";
			contact_tr += "<td class='ec-center'><input name = 'contact_tel[]' class='contact_tel' value =''/></td>";
			contact_tr += "<td class='ec-center'><input name = 'contact_address[]' class='contact_address' value =''/></td>";
			contact_tr += "<td class='ec-center'><input name = 'contact_note[]' class='contact_note' value =''/></td>";
			contact_tr += "<td class='ec-center'><a href = 'javascript:void(0)' onclick = 'delContact(this)'>删除</a></td>";
			contact_tr += "</tr>";

			$(contact_tr).appendTo("#table-module-contact");
		});
		
		//校验AIP服务是否有授权
		$("#as_id").live("change",function(){
			if($(this).val() == ""){
				$("#showMessage").html("");
				return;
			}
			$.ajax({
				type : "POST",
				async : false,
				dataType : "json",
				url : "/financial/service-provider/check-api-service",
				data : {as_id:$(this).val()},
				success : function(json) {
					if (!isJson(json)) {
						alertTip('Internal error.');
					}
					if (!json.state) {
						$("#showMessage").html("该API服务还未授权");
					}else{
						$("#showMessage").html("");
					}
				}
			});
		});

	});

	//删除联系人
        function delContact(obj){
            alertTip('<span class="tip-warning-message">是否删除该联系人？</span>');
            $('#dialog-auto-alert-tip').dialog('option',
                'buttons',
                {
                    "确认(Ok)": function () {
                        var sp_id = $("input[name='sp_id']").val();
                        var sp_contact_id = $(obj).parent().parent().find(".sp_contact_id").val();
                        //数据提交
                        $.ajax({
                            type : "POST",
                            async : false,
                            dataType : "json",
                            url : "/financial/service-provider/del-contact",
                            data : {'sp_contact_id':sp_contact_id,'sp_id':sp_id},
                            success : function(json) {
                                    if (!isJson(json)) {
                                            alertTip('Internal error.');
                                    }
                                    if (json.state == '1') {
                                            $('#dialog-auto-alert-tip').dialog("close");
                                            $(obj).parent().parent().remove();
                                    }
                            }
                        });
                    }, "取消(Cancel)": function () {
                    $(this).dialog("close");
                }
         });
	}

    function verifySpCode() {
    	
    	$("#serviceMsg").html("");
    	
    	var sp_code = $("input[name='sp_code']").val();
		var sp_id = $("input[name='sp_id']").val();
		
		if(sp_code == "" || sp_code.length == 0) {
			return;
		}
		
		//提交数据
		//数据提交
		$.ajax({
			type : "POST",
			async : false,
			dataType : "json",
			url : "/financial/service-provider/verify-sp-code",
			data : {'sp_code':sp_code,'serviceProviderId':sp_id},
			success : function(json) {
				if (!isJson(json)) {
					alertTip('Internal error.');
				}
				if (json.state == '0') {
					$("#serviceMsg").html("服务商代码已存在，请重新输入!");
					$("#checkMsg").html("false");
				}
			}
		});
    }

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
					window.parent.frames[ifId].initData(paginationCurrentPage);
					window.parent.$(".dialogIframe").dialog("close");
	            }
	        }
	    });
	}

	function verifyServiceProvider() {
		
		// 代码
//		verifyText($("input[name='sc_code']"));//渠道
		verifyText($("input[name='sp_code']"));//产品
		// 代码
//		testRegex($("input[name='sc_code']"));//渠道
		testRegex($("input[name='sp_code']"));//产品
		
		// 名称
		verifyText($("input[name='sp_name']"));//产品名称
//		verifyText($("input[name='sc_name']"));
//		verifyText($("input[name='sc_name_en']"));
//		verifyText($("input[name='sp_note']"));
		
		// 单号重复
		verifySpCode();
                
		//渠道代码
		 $("#table-module-b3").find(".ssc_sc_code").each(function(i){
			 if($(this).val() == "" && $(this).val().length == 0){
				 $("#channelMsg").html($("#channelMsg").html()+" 第"+(i+1)+"行服务渠道代码不能为空！");
			 }
		 });
		//中文名称
		 $("#table-module-b3").find(".ssc_sc_name").each(function(i){
			 if($(this).val() == "" && $(this).val().length == 0){
				 $("#channelMsg").html($("#channelMsg").html()+" 第"+(i+1)+"行服务渠道中文名称不能为空！");
			 }
		 });
		//英文名称
		 $("#table-module-b3").find(".ssc_sc_name_en").each(function(i){
			 if($(this).val() == "" && $(this).val().length == 0){
				 $("#channelMsg").html($("#channelMsg").html()+" 第"+(i+1)+"行服务渠道英文名称不能为空！");
			 }
		 });
		 //备注
//		 $("#table-module-b3").find(".ssc_sc_note").each(function(i){
//			 if($(this).val() == "" && $(this).val().length == 0){
//				 $("#channelMsg").html($("#channelMsg").html()+" 第"+(i+1)+"行服务渠道备注不能为空！");
//			 }
//		 });
		 
		 //服务渠道状态
		 $("#table-module-b3").find(".ssc_sc_status").each(function(i){
			 if($(this).val() == "" && $(this).val().length == 0){
				 $("#channelMsg").html($("#channelMsg").html()+" 第"+(i+1)+"行请选择服务渠道状态！");
			 }
		 });

		//服务渠道状态
//		 $("#table-module-b3").find(".template").each(function(i){
//			 if($(this).val() == "" && $(this).val().length == 0){
//				 $("#channelMsg").html($("#channelMsg").html()+" 第"+(i+1)+"行请选择标签模板！");
//			 }
//		 });
		 
		
		 //校验账号
		 $("#table-module-b1").find(".bk_code").each(function(i){
			if($(this).val() == "" && $(this).val().length == 0){
				$("#bankMsg").html($("#bankMsg").html()+" 第"+(i+1)+"行开户行不能为空！");
			}
		 }); 

		 // 网点
		 $("#table-module-b1").find(".sba_bank_branch").each(function(i){
			 if($(this).val() == "" && $(this).val().length == 0){
			 	$("#bankMsg").html($("#bankMsg").html()+" 第"+(i+1)+"行网点不能为空！");
			 }
		 });

		 //账户名
		 $("#table-module-b1").find(".sba_account_name").each(function(i){
			 if($(this).val() == "" && $(this).val().length == 0){
			 	$("#bankMsg").html($("#bankMsg").html()+" 第"+(i+1)+"行账户名不能为空！");
			 }
		 });

		 //账号
		 $("#table-module-b1").find(".sba_bank_account").each(function(i){
			 if($(this).val() == "" && $(this).val().length == 0){
			 	$("#bankMsg").html($("#bankMsg").html()+" 第"+(i+1)+"行账号不能为空！");
			 }
		 });
		 
		 // 校验产品
		 //产品代码
		 $("#table-module-b2").find(".spp_code").each(function(i){
			if($(this).val() == "" && $(this).val().length == 0){
				$("#productMsg").html($("#productMsg").html()+" 第"+(i+1)+"行产品代码不能为空！");
			}
		 }); 

		 // 产品名称
		 $("#table-module-b2").find(".spp_name").each(function(i){
			 if($(this).val() == "" && $(this).val().length == 0){
			 	$("#productMsg").html($("#productMsg").html()+" 第"+(i+1)+"行产品名称不能为空！");
			 }
		 });

		 // 同步类型
		 $("#table-module-b2").find(".sp_sync_type").each(function(i){
			 if($(this).val() == "" && $(this).val().length == 0){
			 	$("#productMsg").html($("#productMsg").html()+" 第"+(i+1)+"行同步类型不能为空！");
			 }
		 });
		 
		 //联系人
		 $("#table-module-contact").find(".contact_name").each(function(i){
			if($(this).val() == "" && $(this).val().length == 0){
				$("#contactMsg").html($("#contactMsg").html()+" 第"+(i+1)+"行联系人名称不能为空！");
			}
		 });
		 
		 
	}
	
	function testRegex(obj){
		//var regex=/^[A-Za-z0-9]+$/;
		var regex=/^[A-Za-z0-9\.-]*$/g;
		if(obj.val() == "" && obj.val().length == 0){
			return;
		}
		if(regex.test(obj.val())==false){
			obj.val("");
			obj.attr("placeholder","必须是数字或字母");
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

	// 删除行
	function delRow(obj){
		$(obj).parent().parent().remove();
	}
	
