<link rel="stylesheet" type="text/css" href="/css/msg/user_message_guide.css">

<div id="id="module-container"">
	<div class="">
		<div class="tab-head">
			<ul class="tab-ul" id="tab-ul">
				<li class="tab choose-tab" name="firefox">Firefox</li>
				<li class="tab choose-tab" name="chrome">Chrome</li>
				<li class="tab choose-tab" name="safari">Safari</li>
			</ul>
		</div>
		<div class="tab-content">
			<div class="content" id="firefox">
				<div class="warning">
					<span class="warning-title">说明：</span>
					<span class="warning-text">浏览器拦截了桌面通知，请按指引操作。</span>
				</div>
				<div class="guide firefox">
					<img src="/images/msg/firefox_1.png">
					<img src="/images/msg/firefox_2.png">
				</div>
			</div>
			<div class="content" id="chrome">
				<div class="warning">
					<span class="warning-title">说明：</span>
					<span class="warning-text">浏览器拦截了桌面通知，请按指引操作。</span>
				</div>
				<div class="guide chrome-first">
					<h2>方法一：</h2>
					<span>1、查找左上角提示信息。</span>
					<img src="/images/msg/chrome_1.png">
					<span>2、点击【允许】。</span>
					<img src="/images/msg/chrome_2.png">
					<span>3、在右下角看到如图提示，即设置成功。</span>
				</div>
				<div class="guide chrome-second">
					<h2>方法二：</h2>
					<span>1、流量默认拦截了所有通知，请在左上角点击此“感叹号”图标。</span>
					<img src="/images/msg/chrome_3.png">
					<span>2、在【通知】栏目下，点击下拉菜单，选中【在此网站始终允许】，点击页面空白处。</span>
					<span>3、如图1，点击【重新加载】，然后重新在设置界面点击【测试浏览器支持】，看到如图2即设置成功。</span>
					<img src="/images/msg/chrome_4.png">
					<span class="picture-num">图1</span>
					<img src="/images/msg/chrome_5.png">
					<span class="picture-num">图2</span>
				</div>
			</div>
			<div class="content" id="safari">
				<div class="warning">
					<span class="warning-title">说明：</span>
					<span class="warning-text">浏览器拦截了桌面通知，请按指引操作。</span>
				</div>
				<div class="guide safari-first">
					<h2>方法一：</h2>
					<span>1、浏览器会弹出对话框，点击“允许”。</span>
					<img src="/images/msg/safari_4.png">
					<span>2、点击【允许】。</span>
					<img src="/images/msg/safari_5.png">
					<span>3、右上角即可看到桌面通知提示信息。</span>
				</div>
				<div class="guide safari-second">
					<h2>方法二：</h2>
					<span>1、默认关闭了通知功能，可见到如图提示，请在状态栏上查找“Safari”。</span>
					<img src="/images/msg/safari_1.png">
					<span>2、点击“Safari”，再点击“偏好设置”。</span>
					<img src="/images/msg/safari_2.png">
					<span>3、找到对应网址的通知设置，选为“允许”即可。</span>
					<img src="/images/msg/safari_3.png">
				</div>
			</div>
		</div>
	</div>
	<!-- <div class="btn-div">
		<input type="button" value="关闭(Close)" onclick="closeMenu(this,'guide')">
	</div> -->
</div>

<script type="text/javascript">
	(function () {
		var tabClick = function() {
			$('body').on('click', '.tab', function() {
				var self = $(this),
					tab = $('.tab'),
					content = $('.content');
				if (self.hasClass('choose-tab')) {
					tab.addClass('choose-tab');
					self.removeClass('choose-tab');
					content.hide();
					$('#' + self.attr('name')).show();
				}
				return ;
			})
		}

		var defaultClick = function() {
			var tabUl = $('#tab-ul'),
				agent = navigator.userAgent.toLowerCase();
			console.log(agent);
			//firefox
			if(agent.indexOf("firefox") > 0) {
				tabUl.find('li[name="firefox"]').trigger('click');
			}

			//Chrome
			if(agent.indexOf("chrome") > 0) {
				tabUl.find('li[name="chrome"]').trigger('click');;
			}

			//Safari
			if(agent.indexOf("safari") > 0 && agent.indexOf("chrome") < 0) {
				tabUl.find('li[name="safari"]').trigger('click');;
			} 
		}

		tabClick();
		defaultClick();
	})()
</script>