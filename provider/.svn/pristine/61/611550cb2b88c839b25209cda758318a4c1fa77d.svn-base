<style>
#main_left p {
	padding-left: 20px;
	line-height: 15px;
	height: 16px;
}
.priority_login{
	width:13px;
	height:13px;
	line-height:13px;
	margin-right:2px; 
	vertical-align:-2px;
	*vertical-align:middle;
	_vertical-align:3px;
}
.tip-error-message{color:red;font-weight:bold;}
</style>
<div id="module-container">
	<div id="main_left" style="width: 49%; float: left;border: 1px solid #D1E7FC;height: 182px;margin-top: 2px;">
		<div style="padding-left: 5px;padding-top: 5px;">
			<h2 style="color:#E06B26;">修改密码：</h2>
			<p><strong>注意</strong></p>
			<p><span style="">&nbsp;&nbsp;1、密码不能少于6位且不能超过16位.</span></p>
			<p><span style="">&nbsp;&nbsp;2、必须存在数字和字母的组合.</span></p>
		</div>
	</div>
	<div id="main_right" style="float: right; width: 50%;" >
		<!-- 修改密码--开始 -->
		<form id="password_params">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module" style="height: 120px;margin-bottom: 5px;" id="password_table">
            <tr class="table-module-title">
            	<td width="50%" class="ec-center">修改密码</td>
            </tr>
            <tr class="table-module-b1">
            	<td>
            		<div style="margin-bottom: 5px;">
            			<span class="searchFilterText" style="width: 90px;padding-top:5px;">原始密码：</span>
            			<input type="password" class="input_text" id="old_password" name="old_password" value="" style="width: 275px; height: 30px">
            			<span class="tip-error-message" style="margin-left: 5px;display: none;" id="old_password_message"></span>
            		</div>
            		<div style="margin-bottom: 5px;">
            			<span class="searchFilterText" style="width: 90px;padding-top:5px;">新密码：</span>
            			<input type="password" class="input_text" id="new_password" name="new_password" value="" style="width: 275px; height: 30px">
            			<span class="tip-error-message" style="margin-left: 5px;display: none;" id="new_password_message"></span>
            		</div>
            		<div style="margin-bottom: 5px;">
            			<span class="searchFilterText" style="width: 90px;padding-top:5px;">确认新密码：</span>
            			<input type="password" class="input_text" id="new_password_again" name="new_password_again" value="" style="width: 275px; height: 30px">
            			<span class="tip-error-message" style="margin-left: 5px;display: none;" id="new_password_again_message"></span>
            		</div>
            		<div style="padding-left: 90px;padding-top: 5px;">
            			<input type="hidden" name='type' value='password'>
            			<input id="mod_password" type="button" class="baseBtn" value="确认"/>
            		</div>
            	</td>
            </tr>
        </table>
        </form>
        <!-- 修改密码--结束 -->
	</div>
</div>
<script type="text/javascript">
$(function(){
	/**
	 *	修改密码
	 */
	$("#mod_password").click(function(){
		var checkBol = checkPassword();
		if(checkBol){
			var params = $("#password_params").serialize(); 
			callUserSet(params);
		}
	});
});

/**
 * 发送请求
 */
function callUserSet(params){
	alertLoadTip("系统正在努力处理中...");
	$.ajax({
		type: "POST",
		data: params,
		dataType:"json",
		url: "/user/user/modify-user-profile",
		async:true,
		success:function(jsonData){
			var tips;
			if(isJson(jsonData)){
				if(jsonData['state'] == 1){
					tips = "<span class='tip-success-message'>" + jsonData.message + "</span>";
				}else if(jsonData['state'] == 0){
					tips = "<span class='tip-error-message'>" + jsonData.message + "</span>"; 
				}else{
	                if (jsonData.errorMessage == null)return;
	                $.each(jsonData.errorMessage, function (key, val) {
	                	tips += "<span class='tip-error-message'>" + val + "</span>";
	                });
				}
			}else{
				tips = "<span class='tip-error-message'>请求异常，请联系相关技术人员.</span>"; 
			}
			$("#dialog-auto-alert-tip").dialog("close");
			alertTip(tips);
		}
	});
}

/**
 * 验证密码是否符合规则
 */
function checkPassword(){
	var old_password =  $.trim($('#old_password').val());
	$('#old_password').val(old_password);
	var old_password_message =  $('#old_password_message');
	
	var new_password =  $.trim($('#new_password').val());
	$('#new_password').val(new_password);
	var new_password_message =  $('#new_password_message');
	
	var new_password_again = $.trim($('#new_password_again').val());
	$('#new_password_again').val(new_password_again);
	var new_password_again_message = $('#new_password_again_message'); 

	//var reg = new RegExp(/^(?=.*[a-z])[a-z0-9]+/ig);// 创建正则表达式对象
	var reg = /^(?=.*[a-z])[a-z0-9]+/ig;
	//re = new RegExp("ain","g"); 

	//验证原始密码
	var bol1 = true;
	old_password_message.show();
	if(old_password == ""){
		old_password_message.html("请填写原始密码.");
		bol1 = false;
	}else{
		old_password_message.hide();
		old_password_message.html("");
	}

	//验证新密码
	var bol2 = true;
	new_password_message.show();
	if(new_password == ""){
		new_password_message.html("请填写密码.");
		bol2 = false;
	}else if(new_password.length < 6){
		new_password_message.html("密码不能少于6位.");
		bol2 = false;
	}else if(new_password.length > 16){
		new_password_message.html("密码不能超过16位.");
		bol2 = false;
	}else if(!new_password.match(reg)){
		new_password_message.html("密码必须存在英文字母和数字,请检查.");
		bol2 = false;
	}else{
		new_password_message.hide();
		new_password_message.html("");
	}

	//验证确认新密码
	var bol3 = true;
	new_password_again_message.show();
	if(new_password_again == ""){
		new_password_again_message.html("请填写密码.");
		bol3 = false;
	}else if(new_password_again.length < 6){
		new_password_again_message.html("密码不能少于6位.");
		bol3 = false;
	}else if(new_password_again.length > 16){
		new_password_again_message.html("密码不能超过16位.");
		bol3 = false;
	}else if(!new_password_again.match(reg)){
		new_password_again_message.html("密码必须存在英文字母和数字,请检查.");
		bol3 = false;
	}else if(new_password_again != new_password){
		new_password_again_message.html("两次密码不一致,请检查.");
		bol3 = false;
	}else{
		new_password_again_message.hide();
		new_password_again_message.html("");
	}
	if(bol1 && bol2 && bol3){
		return true;
	}else{
		return false;
	}
}

/**
 * 弹出等等对话框
 */
function alertLoadTip(str){
	var tips = "<span class='tip-load-message'>" + str + "</span>";
	alertTip(tips);
}
</script>
