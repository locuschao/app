<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>Warehouse System</title>
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.9.2.custom.min.js"></script>
<link href="/css/ui-lightness/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="/css/global.css" />
<link type="text/css" rel="stylesheet" href="/css/login/index.css" />
</head>
<body>
	<script type="text/javascript">
	//iframe包含
	if (top.location != location) {
		top.location.href = location.href;
	}
    var tm = null;
    $(function () {
        $("#userName").focus().css("background-color", "#FFFFCC");
        $(".login_input").click(function () {
            $(".login_input").css("background-color", "#FFFFFF");
            $(this).css("background-color", "#FFFFCC");
        });
        $('#login').click(function(){
            $('#sync_wrap').html('');
          	$('#login_message').html('登录中，请稍候...');
        	$.ajax({
                type: "post",
                async: false,
                dataType: "json",
                url: '/default/index/login-wms',
                data: $('#ec_login').serialize(),
                success: function (json) {
                    $('#login_message').html(json.message);
                    if (json.state) {
                        window.location.href=json.priority_login;
                    }
                }
            });
        })
    });
    <{if isset($authCode) && $authCode=='1'}>
    function verc() {
        $('#verifyCode').attr('src', '/default/index/verify-code/' + Math.random());
    }
    <{/if}>
</script>
	<div class="login_head">
		<div class="login_logo">
			<a href="http://www.ez-wms.com/index.html"></a>
		</div>
		<div class="login_head_text">
			<a href="http://www.ez-wms.com">首页</a>
			|
			<a href="http://www.ez-wms.com/service-Support.html">帮助文档</a>
			|
			<a href="http://www.ez-wms.com/service-Support.html">常见问题</a>
			|
			<a href="http://www.ez-wms.com/service-Support.html">技术支持</a>
		</div>
	</div>
	<div class="login_main">
		<div class="loginTab">
			<ul>
				<li class="chooseTag">
					<a href="#">用户登录</a>
				</li>
			</ul>
		</div>
		<div class="login_box">
			<div class="login_fill">
				<div style="padding-left: 40px; color: red; font-weight: bold;" id='login_message'><{if isset($errMsg)}><{$errMsg}><{/if}></div>
				<form method="post" id="ec_login" action="/login.html" onsubmit='return false;'>
					<table width="95%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td height="46" style="text-align: right;">
								<span style="color: red">*</span>
								账户名：
							</td>
							<td>
								<input name="userName" autocomplete="off" maxlength="50" type="text" class="login_input" id="userName" />
							</td>
							<td style="color: #969696;"></td>
						</tr>
						<tr>
							<td height="46" style="text-align: right;">
								<span style="color: red">*</span>
								密码：
							</td>
							<td>
								<input name="userPass" autocomplete="off" type="password" class="login_input" id="userPass" />
							</td>
							<td style="width: 30%; color: #969696;"></td>
						</tr>
						<{if isset($authCode) && $authCode=='1'}>
						<tr>
							<td height="46" style="text-align: right;">
								<span style="color: red">*</span>
								验证码：
							</td>
							<td>
								<input name="authCode" autocomplete="off" style="width: 80px" type="text" class="login_input" id="authCode" />
								<label class="verifyCode"> <img id="verifyCode" align="absmiddle" src="/default/index/verify-code" width=72 height=23> &nbsp; &nbsp; <a href="javascript:void(0);" onclick="verc();">看不清？换一张</a></label>
							</td>
							<td style="width: 30%; color: #969696;"></td>
						</tr>
						<{/if}>
						<tr>
							<td height="60" style="text-align: right;"></td>
							<td>
								<input type="submit" id="login" value="立刻登录" class="login_Btn" />
								<span style="padding-left: 10px; color: red; font-weight: bold;"></span>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div class="login_news">
				<dl style="padding-top: 0px;">
					<dt>
						<img src="/images/login/login_news01.gif" />
					</dt>
					<dd>
						<strong>免费的电商仓储系统</strong>
						<p>只要注册即可免费使用EZWMS系统</p>
					</dd>
					<div class="clr"></div>
				</dl>
				<dl>
					<dt>
						<img src="/images/login/login_news02.gif" />
					</dt>
					<dd>
						<strong>为B2C电商卖家量身打造</strong>
						<p>精细化的库存管理，销售平台无缝对接</p>
					</dd>
					<div class="clr"></div>
				</dl>
				<dl style="border-bottom: none;">
					<dt>
						<img src="/images/login/login_news03.gif" />
					</dt>
					<dd>
						<strong>强大的第三方仓储系统</strong>
						<p>全流程可配置，日人均最高可操作800单，错误率万分之一</p>
					</dd>
					<div class="clr"></div>
				</dl>
			</div>
		</div>
		<div id='sync_wrap' style='display: none;'></div>
		<{if isset($logout) && $logout}>
		<{foreach from=$systems name=o item=o}>
		<iframe style='display: none;' src='<{$o.logout}>'> </iframe>
		<{/foreach}>
		<{/if}>
		<div id="footer_box">
			<div class="footer">
				<p>关于易仓 | 联系易仓 | 使用条款 | 保密声明</p>
				<p>
					Copyright 2013©深圳易仓科技有限公司
					<a href="http://www.miitbeian.gov.cn/" target="_blank">粤ICP备13020851号</a>
				</p>
			</div>
		</div>
        <script type="text/javascript" src="/js/analytics.js"></script>
</body>
</html>