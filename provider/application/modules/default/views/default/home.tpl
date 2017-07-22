<style>
.task_pane_container {
	background-color: #F1F1F1;
}
.task_pane_container > .content-section {
  padding: 20px 20px 10px 15px;
}
.content-section > .headPanel-group > .headPanel > .headPanel-inner {
  height: 144px;
  background-color: #fff;
  text-align: center;
  padding: 15px;
  font-size: 14px;
}
.content-section > .headPanel-group > .headPanel > .headPanel-inner > p > strong {
  font: 50px bold;
}
.content-section > .headPanel-group > .headPanel > .headPanel-inner > a > .del-btn {
  border: 1px solid #DFE0E4;
  width: 95px;
  height: 30px;
  line-height: 30px;
  display: inline-block;
  border-radius: 4px;
  cursor: pointer;
  color: #666;
}
.content-section > .headPanel-group > .headPanel > .headPanel-inner > a > .del-btn:hover {
  background-color: #F5F8F9;
}
.content-section > .content-panels {
  margin-top: 40px;
}
.content-section > .content-panels > .content-left-panel {
  width: 60%;
  float: left;
  padding-right: 20px;
}
.content-section > .content-panels > .content-left-panel > .panel,
.content-section > .content-panels > .content-right-panel > .panel {
  border: none;
  box-shadow: 1px 1px 1px 1px #E8E8E8;
}
.content-section > .content-panels > .content-left-panel > .panel > .panel-heading,
.content-section > .content-panels > .content-right-panel > .panel > .panel-heading {
  background-color: #F2F3F6;
  height: 40px;
  line-height: 40px;
  border-color: transparent;
}
.content-section > .content-panels > .content-left-panel > .panel > .panel-heading > .fa,
.content-section > .content-panels > .content-right-panel > .panel > .panel-heading > .fa {
  cursor: pointer;
}
.content-section > .content-panels > .content-right-panel {
  float: left;
  width: 40%;
}
.content-section > .content-panels > .content-right-panel > .panel > .panel-body {
  padding: 0 15px;
}
.content-section > .content-panels > .content-right-panel > .panel > .panel-body > .panel-body-content {
  margin-bottom: 0;
}
.content-section > .content-panels > .content-right-panel > .panel > .panel-body > .panel-body-content > li {
  border-bottom: 1px solid #EAEAEA;
}
.content-section > .content-panels > .content-right-panel > .panel > .panel-body > .panel-body-content > li > a {
  width: 100%;
  display: inline-block;
  height: 45px;
  line-height: 45px;
  color: #000;
}
.content-section > .content-panels > .content-right-panel > .panel > .panel-body > .panel-body-content > li > a > .fa {
  margin-right: 10px;
}
.content-section > .content-panels > .content-right-panel > .panel > .panel-body > .panel-body-content > li > a > small {
  float: right;
}
.content-section > .content-panels > .content-right-panel > .panel > .panel-body > p {
  text-align: center;
}
.content-section > .content-panels > .content-right-panel > .panel > .panel-body > p > a {
  display: inline-block;
  padding: 15px;
}
#messModal .modal-dialog {
  height: 100%;
  margin-top: 0;
  margin-bottom: 0;
}
#messModal .modal-dialog > .modal-content {
  width: 720px;
  height: 80%;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translateX(-50%) translateY(-50%);
}
#messModal .modal-dialog > .modal-content > .modal-header {
  text-align: center;
}
#messModal .modal-dialog > .modal-content > .modal-header > h4 {
  font-size: 18px;
}
#messModal .modal-dialog > .modal-content > .modal-header > small {
  font-size: 12px;
  color: #C5C5C5;
}
#messModal .modal-dialog > .modal-content > .modal-body > p {
  font-size: 14px;
  text-indent: 2em;
}
</style>
<div id="task_pane_container" class="task_pane_container">
	<!--主要内容部分-->
    <div class="content-section">
        <div class="headPanel-group row">
            <div class="headPanel col-md-2">
                <div class="headPanel-inner">
                    <p>待确认订单</p>
                    <p>
                        <strong><{if isset($countInfo.order.1)}><{$countInfo.order.1.count}><{else}>0<{/if}></strong>
                        <small>份</small>
                    </p>
                    <a href="javascript:void(0);" onclick="leftMenu('1','订单中心','/order/Order/')">
                    	<span class="del-btn">立即处理</span>
                    </a>
                </div>
            </div>
            <div class="headPanel col-md-2">
                <div class="headPanel-inner">
                    <p>已确认订单</p>
                    <p>
                        <strong><{if isset($countInfo.order.2)}><{$countInfo.order.2.count}><{else}>0<{/if}></strong>
                        <small>份</small>
                    </p>
                    <a href="javascript:void(0);" onclick="leftMenu('1','订单中心','/order/Order/')">
                    	<span class="del-btn">立即处理</span>
                    </a>
                </div>
            </div>
            <div class="headPanel col-md-2">
                <div class="headPanel-inner">
                    <p>已取消订单</p>
                    <p>
                        <strong><{if isset($countInfo.order.3)}><{$countInfo.order.3.count}><{else}>0<{/if}></strong>
                        <small>份</small>
                    </p>
                    <a href="javascript:void(0);" onclick="leftMenu('1','订单中心','/order/Order/')">
                    	<span class="del-btn">立即处理</span>
                    </a>
                </div>
            </div>
            <div class="headPanel col-md-2">
                <div class="headPanel-inner">
                    <p>待处理订单</p>
                    <p>
                        <strong><{if isset($countInfo.delivery.1)}><{$countInfo.delivery.1.count}><{else}>0<{/if}></strong>
                        <small>份</small>
                    </p>
                    <a href="javascript:void(0);" onclick="leftMenu('2','发货管理','/delivery/index')">
                    	<span class="del-btn">立即处理</span>
                    </a>
                </div>
            </div>
            <div class="headPanel col-md-2">
                <div class="headPanel-inner">
                    <p>ERP已确认订单</p>
                    <p>
                        <strong><span class="number"><{if isset($countInfo.delivery.3)}><{$countInfo.delivery.3.count}><{else}>0<{/if}></strong>
                        <small>份</small>
                    </p>
                    <a href="javascript:void(0);" onclick="leftMenu('2','发货管理','/delivery/index')">
                    	<span class="del-btn">立即处理</span>
                    </a>
                </div>
            </div>
            <div class="headPanel col-md-2">
                <div class="headPanel-inner">
                    <p>审核失败订单</p>
                    <p>
                        <strong><{if isset($countInfo.delivery.5)}><{$countInfo.delivery.4.count}><{else}>0<{/if}></strong>
                        <small>份</small>
                    </p>
                    <a href="javascript:void(0);" onclick="leftMenu('2','发货管理','/delivery/index')">
                    	<span class="del-btn">立即处理</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- 图表 !-->
        <div class="content-panels clearfix">
            <div class="content-left-panel">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title pull-left">数据表单</h3>
                        <i class="fa fa-refresh pull-right"></i>
                    </div>
                    <div class="panel-body">
                        <div id="chart" class="chart"></div>
                    </div>
                </div>
            </div>
            <div class="content-right-panel">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title pull-left">公告栏</h3>
                        <i class="fa fa-refresh pull-right"></i>
                    </div>
                    <div class="panel-body">
                        <ul class="panel-body-content">
                            <li>
                                <a href="#">
                                    <small>2017-04-09</small>
                                    <i class="fa fa-envelope"></i>
                                    <span>产品标签与上门验货优化通知</span>

                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <small>2017-04-09</small>
                                    <i class="fa fa-envelope"></i>
                                    <span>产品标签与上门验货优化通知</span>

                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <small>2017-04-09</small>
                                    <i class="fa fa-envelope"></i>
                                    <span>产品标签与上门验货优化通知</span>
                                </a>
                            </li>
                        </ul>
                        <p>
                            <a href="javascript:void(0);" onclick="leftMenu('5','消息中心','/message/message/')"><span>查看全部</span></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
<script type="text/javascript">
	$(function () {
		$('#chart').highcharts({
			chart: {
				type: 'column'
			},
			title: {
				text: '订单统计'
			},
			xAxis: {
				categories: ['待确认', '已确认', '已取消', '待处理', 'ERP已确认', '审核失败']
			},
			yAxis: {
				min: 0,
				title: {
					text: '订单数（条）'
				}
			},
			legend: {
				enabled: false
			},
			credits: {
				enabled: false
			},
			plotOptions: {
				column: {
					pointPadding: 0,
				    borderWidth: 0,
					dataLabels: {
						enabled: true,
						inside: true
					}
				}
			},
			series: [{
				name: '订单数',
				data: [
					<{if isset($countInfo.order.1)}><{$countInfo.order.1.count}><{else}>0<{/if}>, 
					<{if isset($countInfo.order.2)}><{$countInfo.order.2.count}><{else}>0<{/if}>, 
					<{if isset($countInfo.order.3)}><{$countInfo.order.3.count}><{else}>0<{/if}>,
					<{if isset($countInfo.delivery.1)}><{$countInfo.delivery.1.count}><{else}>0<{/if}>,
					<{if isset($countInfo.delivery.3)}><{$countInfo.delivery.3.count}><{else}>0<{/if}>,
					<{if isset($countInfo.delivery.5)}><{$countInfo.delivery.5.count}><{else}>0<{/if}>
				]
			}]
		});
	})
</script>
</div>
