$(function(){
		getUser();

		//创建公司dialog
		$("#createOrg").dialog({
	        autoOpen: false,
	        modal: true,
	        width: 450,
	        height: 350,
	        show: "slide",
	        buttons: {
	        	'确定(OK)': function () {
	        		/*var check = checkData();
	        		if(!check){
		        		return;
		        	}*/
	        		$.ajax({
	                    type: "POST",
	                    async: false,
	                    dataType: "json",
	                    url: "/organization/organization-opration/create-organization",
	                    data:$("#createOrgForm").serializeArray(),
	                    success:  function (json) {
		                    	var html = '';
		                    	if (!isJson(json)) {
		                            alertTip('Internal error.');
		                        }
								if(json.status == "1"){
									//window.location.reload();
									//清空部门、组、人员
									$("#departmentContent").find(".contentSpan").remove();
									$("#groupContent").find(".contentSpan").remove();
									$("#userContent").find("#table-module-list-data").find("tr").remove();
									
									//添加刚添加成功的组织机构span到组织机构列表
									var org_div = $("#organizationContent").find(".tabContent");
									
									var div_span = $("<span>")
										.addClass("contentSpan")
										.attr("onclick","orgEnventClick(this)")
										.attr("sel","true")
										.attr("sub",json.data)
										.text($("#o_name").val());
									
									div_span.appendTo(org_div);
									$("#createOrg").dialog('close');
									
									var org_op = $("<option>")
										.attr("value",json.data)
										.html($("#o_code").val()+" "+$("#o_name").val());
									
									org_op.clone().appendTo($("#org_id"));
									org_op.clone().appendTo($("#gorg_id"));
									
									orgEnventClick(div_span);
								}else{
									$.each(json.message,function(k,v){
										html = html+v+";";
									});
								}
								var mesDiv = $("<div>").addClass("messageDiv").css("color","red").text(html);
								$("#createOrg").append(mesDiv);
		                    },
	                    });
	            },
	            '关闭(Cancel)': function () {
	                $(this).dialog('close');
	            }
	        },
	        close: function () {
	            $(this).dialog('close');
	        }
	    });

	    //创建部门
		$("#createDep").dialog({
	        autoOpen: false,
	        modal: true,
	        width: 450,
	        height: 270,
	        show: "slide",
	        buttons: {
	        	'确定(OK)': function () {
	        		/*var check = checkData();
	        		if(!check){
		        		return;
		        	}*/
	        		$.ajax({
	                    type: "POST",
	                    async: false,
	                    dataType: "json",
	                    url: "/organization/organization-opration/create-departmention",
	                    data:$("#createDepForm").serializeArray(),
	                    success:  function (json) {
		                    	var html = '';
		                    	if (!isJson(json)) {
		                            alertTip('Internal error.');
		                        }
								if(json.status == "1"){
									//清空部门、组、人员
									$("#groupContent").find(".contentSpan").remove();
									$("#userContent").find("#table-module-list-data").find("tr").remove();
									
									//添加刚添加成功的组织机构span到组织机构列表
									var dep_div = $("#departmentContent").find(".tabContent");
									
									var div_span = $("<span>")
										.addClass("contentSpan")
										.attr("onclick","depEnventClick(this)")
										.attr("sel","true")
										.attr("sub",json.data)
										.text($("#d_name").val());
									
									div_span.appendTo(dep_div);
									
									$("#createDep").dialog('close');
									$("#depSpan").remove();
									depEnventClick(div_span);
								}else{
									$.each(json.message,function(k,v){
										html = html+v+";";
									});
								}
								var mesDiv = $("<div>").addClass("messageDiv").css("color","red").text(html);
								$("#createDep").append(mesDiv);
		                    },
	                    });
	            },
	            '关闭(Cancel)': function () {
	                $(this).dialog('close');
	            }
	        },
	        close: function () {
	            $(this).dialog('close');
	        }
	    });

	    //创建组
		$("#createGrp").dialog({
	        autoOpen: false,
	        modal: true,
	        width: 450,
	        height: 270,
	        show: "slide",
	        buttons: {
	        	'确定(OK)': function () {
	        		/*var check = checkData();
	        		if(!check){
		        		return;
		        	}*/
	        		$.ajax({
	                    type: "POST",
	                    async: false,
	                    dataType: "json",
	                    url: "/organization/organization-opration/create-group",
	                    data:$("#createGrpForm").serializeArray(),
	                    success:  function (json) {
		                    	var html = '';
		                    	if (!isJson(json)) {
		                            alertTip('Internal error.');
		                        }
								if(json.status == "1"){
									//清空部门、组、人员
									$("#userContent").find("#table-module-list-data").find("tr").remove();
									
									//添加刚添加成功的组织机构span到组织机构列表
									var grp_div = $("#groupContent").find(".tabContent");
									
									var div_span = $("<span>")
										.addClass("contentSpan")
										.attr("onclick","grpEnventClick(this)")
										.attr("sel","true")
										.attr("sub",json.data)
										.text($("#g_name").val());
									
									div_span.appendTo(grp_div);
									$("#createGrp").dialog('close');
									
									$("#grpSpan").remove();
									grpEnventClick(div_span);
								}else{
									$.each(json.message,function(k,v){
										html = html+v+";";
									});
								}
								var mesDiv = $("<div>").addClass("messageDiv").css("color","red").text(html);
								$("#createGrp").append(mesDiv);
		                    },
	                    });
	            },
	            '关闭(Cancel)': function () {
	                $(this).dialog('close');
	            }
	        },
	        close: function () {
	            $(this).dialog('close');
	        }
	    });

		
		//添加人员
		$("#createUser").dialog({
	        autoOpen: false,
	        modal: true,
	        width: 450,
	        height: 270,
	        show: "slide",
	        buttons: {
	        	'确定(OK)': function () {
	        		if($("input[name='user_name_value']").val().length == 0 || 
	        				$("input[name='user_name_value']").val() == "" ||
	        				$("input[name='user_id']").val().length == "" ||
	        				$("input[name='user_id']").val() == ""){
	        			alertTip("请选择人员！");
	        			return;
	        		}
//	        		if($("input[name='p_name_value']").val().length == 0 || 
//	        				$("input[name='p_name_value']").val() == "" ||
//	        				$("input[name='p_id']").val().length == "" ||
//	        				$("input[name='p_id']").val() == ""){
//	        			alertTip("请选择职位！");
//	        			return;
//	        		}
	        		$.ajax({
	                    type: "POST",
	                    async: false,
	                    dataType: "json",
	                    url: "/organization/organization-opration/create-user",
	                    data:$("#createUserForm").serializeArray(),
	                    success:  function (json) {
		                    	var html = '';
		                    	if (!isJson(json)) {
		                            alertTip('Internal error.');
		                        }
								if(json.status == "1"){
									$("#createUser").dialog('close');
									initData(0);
								}else{
									var mesDiv = $("<div>").addClass("messageDiv").css("color","red").html(json.message);
									mesDiv.appendTo($("#createUser"));
								}
								
		                    },
	                    });
	            },
	            '关闭(Cancel)': function () {
	                $(this).dialog('close');
	            }
	        },
	        close: function () {
	            $(this).dialog('close');
	        }
	    });

		$("#addOrg").click(function(){
	    	$("#createOrg").dialog("open");
	    	$(".messageDiv").remove();
	    	$("#createOrg").find("input").val("");
	    	$("#createOrg").find("select").val(0);
	    	
		});
		
	    $("#addDep").click(function(){
	    	$("#createDep").dialog("open");
	    	$(".messageDiv").remove();
	    	$("#createDep").find("input").val("");
	    	$("#createDep").find("select").val(0);
	    	
		});

	    $("#addGrp").click(function(){
	    	$("#createGrp").dialog("open");
	    	$(".messageDiv").remove();
	    	$("#createGrp").find("input").val("");
	    	$("#createGrp").find("select").val(0);
	    	
		});

	    $("#addUser").click(function(){
	    	$("#createUser").dialog("open");
	    	$(".messageDiv").remove();
	    	$("#createUser").find("input").val("");
	    	$("#createUser").find("select").val(0);
	    	
	    	$("#createUserBody tr").remove();
	    	if($("input[name='organizationId']").val() != null && $("input[name='organizationId']").val().length > 0){
	    		$("#ui-id-4").html("添加组织机构管理人员");
	    		addUserDom();
//	    		//职位
//	    		addUpDom();
	    		
	    		$("#createUserBody td").css("padding","5");
	    		$("#createUserBody").find("td").eq(0).append(
	    				$("<input>").attr("name","mode").attr("type","text").val(1).css("display","none")
	    		);
	    		$("#createUserBody").find("td").eq(0).append(
	    				$("<input>").attr("name","organizationId").attr("type","text").val($("input[name='organizationId']").val()).css("display","none")
	    		);
	    	}
	    	
			if($("input[name='departmentId']").val() != null && $("input[name='departmentId']").val().length > 0){
				var dep = "";
				$("#departmentContent").find(".contentSpan").each(function(){
					if($(this).attr("sel").length > 0 && $(this).attr("sel") != ""){
						dep = $(this).text();
					};
				});
				var dep_temp = "添加"+dep+"管理人员";
				$("#ui-id-4").html(dep_temp);
				
				//添加人员操作dom
	    		addUserDom();
	    		
//	    		//添加职位操作dom
//	    		addUpDom();
	    		
	    		$("#createUserBody td").css("padding","5");
	    		$("#createUserBody").find("td").eq(0).append(
	    				$("<input>").attr("name","mode").attr("type","text").val(2).css("display","none")
	    		);
	    		$("#createUserBody").find("td").eq(0).append(
	    				$("<input>").attr("name","departmentId").attr("type","text").val($("input[name='departmentId']").val()).css("display","none")
	    		);
			}
			
			if($("input[name='groupId']").val() != null && $("input[name='groupId']").val().length > 0){
				var grp = "";
				$("#groupContent").find(".contentSpan").each(function(){
					if($(this).attr("sel").length > 0 && $(this).attr("sel") != ""){
						grp = $(this).text();
					};
				});
				var grp_temp = "添加"+grp+"人员";
				$("#ui-id-4").html(grp_temp);
				//添加人员类型
				addUpType();
				//添加人员操作dom
	    		addUserDom();
//	    		//添加职位操作dom
//	    		addUpDom();
	    		
	    		$("#createUserBody td").css("padding","5");
	    		$("#createUserBody").find("td").eq(0).append(
	    				$("<input>").attr("name","mode").attr("type","text").val(3).css("display","none")
	    		);
	    		$("#createUserBody").find("td").eq(0).append(
	    				$("<input>").attr("name","groupId").attr("type","text").val($("input[name='groupId']").val()).css("display","none")
	    		);
	    		
			}
	    	
	    	
		});
	    

		$(".dialog-module td").css({
			padding:5,
		});
		
		$(".dialog-module input,select").css({
			width:240
		});
		
		

		//校验数据
		$(".dialog-module input[validator='required'],select[validator='required']").focusout(function(){
			var mes = $(this).parent().find(".messageDiv");
			if(mes.length == 0){
				var mesDiv = $("<span>")
								.addClass("messageDiv");
				$(this).parent().append(mesDiv);
			}
			if($(this).val().length == 0 && $(this).val() == ""){
				$(this).parent().find(".messageDiv").text("必填");
			}else{
				$(this).parent().find(".messageDiv").text("");
			}
		});
		
		/*
		 * 选择人员弹出框
		 */
		$("#select-user-dialog").dialog({
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
		
		/*
		 * 选择职位弹出框
		 */
		$("#select-position-dialog").dialog({
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

		//用户选择 单击事件
		$("#addUserSelect").live('click',function(){
			$("#select-user-dialog").dialog('open');
			if($("#user-list-data tr").size() == 0){
				$("#user_pagination").html("");
			}
		});
		
		//职位选择 单击事件
		$("#addUpSelect").live('click',function(){
			$("#select-position-dialog").dialog('open');
			if($("#position-list-data tr").size() == 0){
				$("#position_pagination").html("");
			}
		});
		
	});
	
	$(".contentSpan").live('mousemove',function(){
		$(this).css("backgroundColor","#D2E5F7");
	});
	$(".contentSpan").live('mouseout',function(){
		if($(this).attr("sel") != "true"){
			$(this).css("backgroundColor","white");
		}
	});

	function listUserData(pageIndex) {	

		if(pageIndex < 1) pageIndex = 0;
		var pageSize = 10, current = parseInt(pageIndex) + 1;	
		
		var i = current < 1 ? 1 : pageSize * (current - 1) + 1;
		var uri = '/organization/organization-opration/get-select-user/page/'+current+'/pageSize/' + pageSize;
		$.post(uri, $('#searchUserForm').serialize(), function(json){
			var html = '';
			if(json.state==0) html = '没有数据';
			else {
				$.each(json.data, function (key, val) {
		            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
		            html += "<td class='ec-center'>" + (i++) + "</td>";
		            html += "<td class='ec-center'>" + val.user_name + "</td>";
		            html += "<td class='ec-center'>" + val.user_name_en + "</td>";
		            html += "<td class='ec-center'>" + val.user_status + "</td>";
		            html += "<td><a id=\'"+val.user_id+"'\ href=\"javascript:addUser('" + val.user_id + "','" + val.user_name + "')\">选择</a></td>";
		            html += "</tr>";
		        });
			}
	        $('#user-list-data').html(html);
	        $("#user_pagination").pagination(json.total, {
	            callback: listUserData,
	            items_per_page: pageSize,
	            num_display_entries: 6,
	            current_page: pageIndex,
	            num_edge_entries: 2
	        });
		},'json');
	}
	
	function addUser(user_id,user_name){
		var userValue = $("input[name='user_id']").val();
		var userText = $("input[name='user_name_value']").val();
		if(userValue.indexOf(user_id) >= 0 || userText.indexOf(user_name) >= 0){
			return;
		}
		$("input[name='user_id']").val(userValue+user_id+";");
		$("input[name='user_name_value']").val(userText+user_name+";");
		$('#'+user_id).css("color","red");
	}
	
	function listPositionData(pageIndex) {	

		if(pageIndex < 1) pageIndex = 0;
		var pageSize = 10, current = parseInt(pageIndex) + 1;	
		
		var i = current < 1 ? 1 : pageSize * (current - 1) + 1;
		var uri = '/organization/organization-opration/get-select-position/page/'+current+'/pageSize/' + pageSize;
		$.post(uri, $('#searchPositionForm').serialize(), function(json){
			var html = '';
			if(json.state==0) html = '没有数据';
			else {
				$.each(json.data, function (key, val) {
		            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
		            html += "<td class='ec-center'>" + (i++) + "</td>";
		            html += "<td class='ec-center'>" + val.p_name + "</td>";
		            html += "<td class='ec-center'>" + val.pl_name + "</td>";
		            html += "<td class='ec-center'>" + val.d_name + "</td>";
		            html += "<td><a href=\"javascript:addPosition('" + val.p_id + "','" + val.p_name + "')\">选择</a></td>";
		            html += "</tr>";
		        });
			}
	        $('#position-list-data').html(html);
	        $("#position_pagination").pagination(json.total, {
	            callback: listPositionData,
	            items_per_page: pageSize,
	            num_display_entries: 6,
	            current_page: pageIndex,
	            num_edge_entries: 2
	        });
		},'json');
	}
	
	function addPosition(p_id,p_name){
		$("#select-position-dialog").dialog("close");
		$("input[name='p_id']").val(p_id);
		$("input[name='p_name_value']").val(p_name);
	}
	
	function addUpType(){
		var tr2 = $("<tr>");
		var tr2_td1 = $("<td>").addClass("dialog-module-title").text("类型：");
		var tr2_td2 = $("<td>");
		var label1 = $("<label>").appendTo(tr2_td2);
		
		label1.append(
				$("<input>")
				.attr("type","radio")
				.attr("name","up_type")
				.addClass("upType")
				.val("1")
		);
		label1.append(
				$("<span style='margin-right:10px;'>").text("添加组管理人员")
		);
		var label2 = $("<label>").appendTo(tr2_td2);
		label2.append(
				$("<input>")
				.attr("type","radio")
				.attr("name","up_type")
				.attr("checked","checked")
				.addClass("upType")
				.val("2")
		);
		label2.append(
				$("<span>").text("添加组普通人员")
		);
		tr2.append(tr2_td1);
		tr2.append(tr2_td2);
		$("#createUserBody").append(tr2);
	}

	function addUserDom(){
		var tr2 = $("<tr>");
		var tr2_td1 = $("<td>").addClass("dialog-module-title").text("人员：");
		var tr2_td2 = $("<td>");
		tr2_td2.append(
				$("<input>")
					.attr("type","text")
					.attr("name","user_name_value")
					.attr("validator","required")
					.addClass("input_text")
					.css("width","242")
					.attr("readOnly","readOnly")
		);
		tr2_td2.append(
				$("<input>")
					.attr("type","text")
					.attr("name","user_id")
					.addClass("input_text")
					.css({width:"242",display:"none"})
		);
		tr2_td2.append(
				$("<span>").addClass("msg").text("*")
		);
		tr2_td2.append(
				$("<a>")
					.attr("id","addUserSelect")
					.attr("href","javascript:void(0)")
					.text("选择")
					.css("color","blue")
		);
		tr2.append(tr2_td1);
		tr2.append(tr2_td2);
		$("#createUserBody").append(tr2);
	}
	
	function addUpDom(){
		var tr2 = $("<tr>");
		var tr2_td1 = $("<td>").addClass("dialog-module-title").text("职位：");
		var tr2_td2 = $("<td>");
		tr2_td2.append(
				$("<input>")
					.attr("type","text")
					.attr("name","p_name_value")
					.attr("validator","required")
					.addClass("input_text")
					.css("width","242")
					.attr("readOnly","readOnly")
		);
		tr2_td2.append(
				$("<input>")
				.attr("type","text")
				.attr("name","p_id")
				.addClass("input_text")
				.css({width:"242",display:"none"})
		);
		tr2_td2.append(
				$("<span>").addClass("msg").text("*")
		);
		tr2_td2.append(
				$("<a>")
					.attr("id","addUpSelect")
					.attr("href","javascript:void(0)")
					.text("选择")
					.css("color","blue")
		);
		tr2.append(tr2_td1);
		tr2.append(tr2_td2);
		$("#createUserBody").append(tr2);
	}

	function getUser(){
		setTimeout(function(){
			if($("#organizationContent").find(".contentSpan").size() > 0){
				$("#organizationContent").find(".contentSpan").each(function(){
					var check = $(this).attr("sel");
					if(check != null && check.length > 0){
						$("input[name='organizationId']").val($(this).attr("sub"));
					}
				});
				initData(0);
			}else{
				getUser();
			}
		}, 300);
	}

	function loadData(page, pageSize) {
	    EZ.listDate.myLoading();
	    $.ajax({
	        type: "POST",
	        async: false,
	        dataType: "json",
	        url: "get-load-user/page/" + page + "/pageSize/" + pageSize,
	        data:$("#orgDisFrom").serializeArray(),
	        error: function () {
	            paginationTotal = 0;
	            EZ.listDate.EzWmsSetSearchData({msg: 'The URL request error.'});
	            return;
	        },
	        success: function (json) {
	            if (!isJson(json)) {
	                paginationTotal = 0;
	                EZ.listDate.EzWmsSetSearchData({msg: 'Returns the data type error.'});
	                return;
	            }
	            paginationTotal = json.total;
	            if (json.state == '1') {
	            	var html = '';
	                var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
	                var statu = "";
	                $.each(json.data, function (key, val) {

	                	statu =json.statu[val.user_status]?json.statu[val.user_status]:'';
	                    html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
	                    html += "<td class='ec-center'>" + (i++) + "</td>";

	                    html += "<td class='ec-center'>" + val.user_name + "</td>";
	                    html += "<td class='ec-center'>" + val.up_name + "</td>";
	                    html += "<td > 手机:" + val.user_mobile_phone + "</br>固话:"+val.user_phone+"</td>";
	                    html += "<td class='ec-center'>" + statu + "</td>";
	                    html += "<td class='ec-center'>" + val.user_add_time + "</td>";
	                    //html += "<td class='ec-center'><a href=\"javascript:void(0)\">编辑</a></td>";
	                    html += "</tr>";
	                });
	                EZ.listDate.html(html);
	            } else {
	                EZ.listDate.EzWmsSetSearchData({state: 1});
	            }
	        }
	    });
	}

	//公司单击事件
	function orgEnventClick(obj){
		excuteDivCss(obj);
		$("#addUserLabel").html("添加组织机构管理人员");
		var value = $(obj).attr("sub");
		$("input").val("");
		$("input[name='organizationId']").val(value);
		//加载部门和组信息
		$.ajax({
            type: "POST",
            async: false,
            dataType: "json",
            url: "/organization/organization-opration/list",
            data:{mode:1,organizationId:value},
            success:  function (json) {
           		if (!isJson(json)) {
                    alertTip('Internal error.');
                }
                //清空部门
				var depContent = $("#departmentContent").find(".tabContent");
				depContent.html("");
				if(json.department.length > 0){
					$.each(json.department,function(k,v){
						var span = $("<span>")
									.addClass("contentSpan")
									.attr("sub",v.d_id)
									.attr("onclick","depEnventClick(this)")
									.html(v.d_name);
						$("#departmentContent").find(".tabContent").append(span);
					});
				}else{
					var span_text = $("<span id='depSpan'>").text("未分配部门");
					span_text.appendTo(depContent);
				}
				
                //清空组
				var grpContent = $("#groupContent").find(".tabContent");
				grpContent.html("");
				
				if(json.group.length > 0){
					$.each(json.group,function(k,v){
						var span = $("<span>")
									.addClass("contentSpan")
									.attr("sub",v.g_id)
									.attr("onclick","grpEnventClick(this)")
									.html(v.g_name);
						$("#groupContent").find(".tabContent").append(span);
					});
				}else{
					var span_text = $("<span id='grpSpan'>").text("未分配组");
					span_text.appendTo(grpContent);
				}
            }
        });

        //加载公司员工信息
		initData(0);
	}

	//部门单击事件
	function depEnventClick(obj){
		excuteDivCss(obj);
		$("#addUserLabel").html("添加部门管理人员");
		var value = $(obj).attr("sub");
		$("input").val("");
		$("input[name='departmentId']").val(value);
		//加载组信息
		$.ajax({
            type: "POST",
            async: false,
            dataType: "json",
            url: "/organization/organization-opration/list",
            data:{mode:2,departmentId:value},
            success:  function (json) {
           		if (!isJson(json)) {
                    alertTip('Internal error.');
                }
               	//清空组
				var grpContent = $("#groupContent").find(".tabContent").html("");
				grpContent.html("");

				if(json.group.length > 0){
					$.each(json.group,function(k,v){
						var span = $("<span>")
									.addClass("contentSpan")
									.attr("sub",v.g_id)
									.attr("onclick","grpEnventClick(this)")
									.html(v.g_name);
						$("#groupContent").find(".tabContent").append(span);
					});
				}else{
					var span_text = $("<span id='grpSpan'>").text("未分配组");
					span_text.appendTo(grpContent);
				}
            }
        });
        //加载部门员工
        initData(0);
	}

	//组单击事件
	function grpEnventClick(obj){
		excuteDivCss(obj);
		$("#addUserLabel").html("添加组人员");
		var value = $(obj).attr("sub");
		$("input").val("");
		$("input[name='groupId']").val(value);
		//加载用户信息
        initData(0);
       
	}

	function excuteDivCss(obj){
		$(obj).parent().find(".contentSpan").css("backgroundColor","white");	
		$(obj).parent().find(".contentSpan").attr("sel","");
		$(obj).css("backgroundColor","#D2E5F7");
		$(obj).attr("sel","true");
		$("input").val("");
	}

	//添加组 动态加载所属部门
	function changeOrg(){
		var oId = $("#gorg_id").val();
		$.ajax({
            type: "POST",
            async: false,
            dataType: "json",
            url: "/organization/organization-opration/get-department",
            data:{o_id:oId},
            success:  function (json) {
           		if (!isJson(json) || json.status == "0") {
                    alertTip('动态获取部门信息失败！');
                }
               	if(json.status == "1"){
                   	$("#dep_id option").remove();
                   	$.each(json.data,function(k,v){
						var option = $("<option>").val(v.d_id).text(v.d_name);
						$("#dep_id").append(option);
                    });
                }
            }
        });
	}