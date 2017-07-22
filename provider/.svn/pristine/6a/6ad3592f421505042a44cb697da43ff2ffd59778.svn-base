<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<!-- 
<meta http-equiv="x-ua-compatible" content="ie=7" />
-->
<title>供应商平台</title>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/base64.js"></script>
<script type="text/javascript" src="/js/analytics.js"></script>
<link rel="stylesheet" type="text/css" href="/css/ui-lightness/jquery-ui-1.9.2.custom.min.css"/>
<link type="text/css" rel="stylesheet" href="/css/bootstrap.min.css?20170620"/>
<link type="text/css" rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css?20170619"/>
<link rel="stylesheet" type="text/css" href="/css/login/base.css" />
<link rel="stylesheet" type="text/css" href="/css/login/login.css" />

<script type="text/javascript">
	/*
	 * iframe包含
	 */
	if (top.location != location) {
		top.location.href = location.href;
	}
    $(function () {
        //配置项目--客户是否需要屏蔽Banner
    	//setBanner();
    	
		$(".login_icon").css('opacity',0.5);
        
        $("#userName").focus().addClass('loginFormIpt-focus');//css("background-color", "#FFFFCC");
        $(".login_input").click(function () {
            $(".login_input").removeClass('loginFormIpt-focus');//css("background-color", "#FFFFFF");
            $(this).addClass('loginFormIpt-focus');//css("background-color", "#FFFFCC");
        });
        
        $('#login').click(function(){
            $('#sync_wrap').html('');
          	$('#login_message').html('登录中，请稍候...');
        	$.ajax({
                type: "post",
                async: false,
                dataType: "json",
                url: '/default/index/login',
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
    
    function setBanner(){
        var _index = 1;
        var _banner_config = <{$login_banner}>;
        if(_banner_config.ask == '1'){
        	console.log((_index++) + '、客户定义Banner.');
        	$(".box").css("background-color",'#' + _banner_config.config_val);
    		$(".banner").css("background-image","url(/images/login/'"+_banner_config.config_key+"')");
        	return;
        }else{
	        console.log((_index++) + '、启用系统Banner切换.');
        }
        var data={"code":"ERP"};
        $.ajax({
            type: "POST",
            url: "http://www.eccang.com/website/get-banner",
            async: true,
            dataType: "jsonp",
            //jsonp:"switchingBanner",
            //jsonpCallback:"switchingBanner",
            data:data,
            error: function (e) {
            	console.log((_index++) + '、Error：远程请求异常');
                return;
            },
            success: function (json) {
            	if(isJson(json)){
        			console.log((_index++) + '、Banner 数据格式正常.');
        			if(json.ask == '1'){
        				console.log((_index++) + '、Banner 数据获取成功，开始替换.');
        				switchingBanner(json.data,'Y');
        			}else{
        				console.log((_index++) + '、Banner 获取数据失败=>' + json.message);
        				
        			}
        		}else{
        			console.log((_index++) + 'Error：Banner 数据异常');
        		}
            }
        });
		
    }
	
	/**
	 * 切换Banner
	 * banner Json数据 
	 * first 是否第一次 Y/N
	 */
	var _BannerIndex = 0;
	var _IsFirist = 'Y'
    function switchingBanner(json_data){
        //渠道Banner数量
        var banner_num = json_data.length;

        //设置当前banner和底色
        if(_IsFirist == 'Y'){
	        _IsFirist = 'N';
        	var color = base64_decode(json_data[0].color);
			var url = base64_decode(json_data[0].url);
        }else{
        	var color = base64_decode(json_data[_BannerIndex].color);
			var url = base64_decode(json_data[_BannerIndex].url);
        }

        //设置下次Banner坐标
        _BannerIndex++;
		if(_BannerIndex == banner_num){
			_BannerIndex = 0;
		}

		//替换
        $(".box").css("background-color",color);
		$(".banner").css("background-image","url('"+url+"')");
		//只有一个Banner时，跳出循环
		if(banner_num == 1){
			console.log('只有一张Banner,退出.');
			return;
		}

		//延时递归
		setTimeout(function(){
			console.log('切换Banner--'+color+ '--' +url);
			switchingBanner(json_data);
		}, 5000);
    }
    
    <{if isset($authCode) && $authCode=='1'}>
	    function verc() {
	        $('#verifyCode').attr('src', '/default/index/verify-code/' + Math.random());
	    }
    <{/if}>
</script>

</head>
<body>
	<!--header
	<div class="header">
		<img src="images/logo.png">
		
		<div class="nav">
			<a href="http://www.eccang.com">首页</a>&nbsp;&nbsp;|&nbsp; &nbsp;
			<a href="http://www.eccang.com/website/contact">常见问题</a>&nbsp;&nbsp;|&nbsp;&nbsp;
			<a href="http://www.eccang.com/website/contact">技术支持</a>&nbsp;&nbsp;|&nbsp;&nbsp; 
			<a href="http://www.eccang.com/website/contact">帮助</a>
		</div>
	</div>
	-->
<div class="login-wrapper">
	<div class="header">
		<div class="logo"></div>
		<p>欢迎使用深圳易仓科技供应商平台</p>
		<form method="post" id="ec_login" action="/login.html" onsubmit='return false;'>
			<h4>用户登录<small>/login</small></h4>
			<!-- <div class="loginbox"> -->
				<div class="prompt" id="login_message"><{if isset($errMsg)}><{$errMsg}><{/if}></div>
				<div class="user_name_box" id="username">
					<i class="user_icon"></i>
					<input type="text" class="user_name login_input" name="userName" id="userName" value="" placeholder="账户" autofocus required autocomplete="false">
				</div>
				<div class="password_box" id="password">
					<i class="psd_icon"></i>
					<input type="password" class="password login_input" name="userPass" id="userPass" value="" placeholder="密码"/>
					<i class="psd_key"></i>
				</div>
				<{if isset($authCode) && $authCode=='1'}>
					<div class="authcode_box">
						<input type="text" class="authCode login_input" name="authCode" id="authCode" value="" placeholder="验证码" style="width: 110px;"/>
						<label class="verifyCode">
							<img id="verifyCode" align="absmiddle" src="/default/index/verify-code" onclick="verc();" style="float: right;width: 72px;height:38px;margin: 2px 25px 0 0;"/>
							&nbsp;&nbsp; 
							<a href="javascript:;" onclick="verc();" style="float: right;margin: 43px -73px 0;color:#225592;">看不清？换一张</a> 
						</label>
					</div>
				<{else}>
					<div style="height: 10px; position: relative; top: 30px;"></div>
				<{/if}>
				<!-- 
				屏蔽DIV提交的方式，使用input。
				浏览器判断记录表单账户密码的条件：
				1、form表单中有相邻的两个输入框，其中一个是password
				2、表单中需要有submit类型的input提交按钮
				<div class="login_div" id="login">登&nbsp;&nbsp;&nbsp;&nbsp;录</div>
				 -->
				<input class="login_div" id="login" type="submit" value="登&nbsp;&nbsp;&nbsp;&nbsp;录"/>
				<div class="bott" >
					<div style="float: right; margin: 0 24px 0 0; text-align: right; width: 250px;">
						<!-- 
						<a href="javascript:;">忘记密码？</a>&nbsp;&nbsp;|&nbsp;&nbsp;
						<a href="javascript:;">注册新账户</a>&nbsp;&nbsp;|&nbsp;&nbsp;
						 -->
					</div>
				</div>
				<p><a href="javascript:void(0)" class="pull-right"><span>意见反馈</span></a></p>
			<!-- </div> -->
		</form>
	</div>
	<!--footer-->
	<div id="footer" class="footer">
		<div class="footer-inner">
			<!-- 是否屏蔽文字和显示公司名 -->
			<div class="footer-top clearfix">
				<ul class="pull-left clearfix">
					<li><a href="http://www.ez-wms.com">关于我们</a></li>
					<li><a href="http://www.ez-wms.com/service-Support.html">帮助文档</a></li>
					<li><a href="http://www.ez-wms.com/service-Support.html">常见问题</a></li>
					<li><a href="http://www.ez-wms.com/service-Support.html">技术支持</a></li>
				</ul>
				<ul class="pull-right clearfix">
					<li>
						<a href="#">
						<i class="fa fa-weixin"></i>
						<span class="erweima"></span>
						</a>
					</li>
					<li>
						<a href="#"><i class="fa fa-weibo"></i></a>
					</li>
				</ul>
			</div>
			<ul class="footer-bottom clearfix">
				<li class="pull-left"><strong>Copyright &copy; 2017 <a href="http://www.ez-wms.com">深圳易仓科技有限公司</a>. </strong>All rights reserved.</li>
				<li class="pull-right"><a href="http://www.miitbeian.gov.cn/" target="_blank">粤ICP备13020851号</a></li>
			</ul>
		</div>
	</div>
</div>
</body>
</html>