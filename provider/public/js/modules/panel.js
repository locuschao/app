/**
 * 首页看板统计、公告栏(版本信息)
 * @author Frank
 * @date 2013-9-13 15:19:263
 */

var _topContainer;					//面板区域的顶级容器(包含了过来条件+面板)
var _panelContainer;				//放置所有看板的容器（DIV，自己构建的）
var _reportContainer;				//放置所有报表的容器
var _taskContainer;					//放置所有任务的容器
var _moduleCode = new Array();		//模块代码（array）
var _panelId = new Array();			//面板ID（array）
var _warehouseIdArr = new Array();	//仓库ID
var _userAccountArr = new Array();	//账户
var _warehouseId = 'all';				//传入后台仓库ID
var _userAccount = '';				//传入后台的账户

var _existWarehouseOption = false;	//是否存在仓库过滤条件
var _existUserAccountOption = false;//是否存在账户过滤条件
var _warehouseList = '';			//仓库数据
var _statisticsPanelControl;		//控制统计面板是否显示的a标签

var _statisticsPanelIsShow = false;
var _tagShowArr = new Array();		//存储上一次显示的选项卡，切换账户或者仓库时，选中上一次的选项卡

/**
 * 加载面板
 * @param container 		放置面板数据的容器（jquery对象，div标签）
 * @param moduleCode		模块代码（array）
 * @param panelId			面板ID（array）
 * @param warehouseId		仓库ID（array）
 * @param userAccount		账户（array）
 */
function loadPanel(container,moduleCode,panelId,warehouseId,userAccount){

	//指定参数
	_topContainer = container;
	_panelContainer = $("<div>").appendTo(_topContainer);
	_panelContainer.addClass("panel_container");
	_reportContainer = $("<div>").appendTo(_topContainer);
	_reportContainer.addClass("report_container");
	_taskContainer = $("<div>").appendTo(_topContainer);
	_taskContainer.addClass("task_container");
    _moduleCode = moduleCode;
    _panelId = panelId;
    _warehouseIdArr = warehouseId;
    _userAccountArr = userAccount;
    if(typeof(_warehouseIdArr) != 'undefined' && _warehouseIdArr.length > 0){
        _warehouseId = _warehouseId == '' ? _warehouseIdArr[0].warehouse_id : _warehouseId;
        _existWarehouseOption = true;
    }
    if(typeof(_userAccountArr) != 'undefined' && _userAccountArr.length > 0){
    	_userAccount = _userAccountArr[0].user_account;
    	_existUserAccountOption = true;
    }

    //开启加载等待...
    _panelContainer.myLoading();

    //构建过来条件区域
    initFilter();

    //调用查询
    getPanelData();
}

/**
 * 构建过滤条件
 */
function initFilter(){
	if(!_existUserAccountOption && !_existWarehouseOption){
		return;
	}
	//追加一个div用来放置过滤条件控件
	var divContainer = $("<div>").insertBefore(_panelContainer);
	divContainer.addClass("table-module-title");
	divContainer.css({"padding":"5px 5px","text-align":"right",'border':"1px solid #d9d9d9"});

	var tagTitle = $("<div>").appendTo(divContainer);
	tagTitle.css({"width":"100px","float":"left","text-align":"left"});
	tagTitle.html("<h3>我的面板</h3>");

	_statisticsPanelControl = $("<a>").appendTo(divContainer);
	_statisticsPanelControl.css("margin-right","15px");
	_statisticsPanelControl.html("显示统计面板");
	_statisticsPanelControl.attr("href","javascript:setStatisticsPanelControl(false);");
	_statisticsPanelControl.data("isHide",false);


	//账户
	if(_existUserAccountOption){
		divContainer.append("账户：");
		var selectTag = $("<select>").appendTo(divContainer);
		selectTag.css({"width":"120px"});
		selectTag.addClass("userAccountChange");
		for ( var i = 0; i < _userAccountArr.length; i++) {
			var val = _userAccountArr[i];
			var optionTag = $("<option>").appendTo(selectTag);
			optionTag.val(val.user_account);
			optionTag.html(val.platform_user_name);
		}

		var optionTagAll = $("<option>").appendTo(selectTag);
		optionTagAll.val('all');
		optionTagAll.html('全部');
	}

	//仓库ID
	if(_existWarehouseOption){
        divContainer.append("仓库：");
        var selectTag = $("<select>").appendTo(divContainer);
        selectTag.css({"width":"160px"});
        selectTag.addClass("warehouseChange");
        var optionTagAll = $("<option>").appendTo(selectTag);
        optionTagAll.val('all');
        optionTagAll.html('全部');
        for ( var i = 0; i < _warehouseIdArr.length; i++) {
            var val = _warehouseIdArr[i];
            var optionTag = $("<option>").appendTo(selectTag);
            optionTag.val(val.warehouse_id);
            optionTag.html(val.warehouse_code+' ['+val.warehouse_desc+']');
        }

	}

	//刷新按钮
//	var refreshTag = $("<input type='button'>").appendTo(divContainer);
//	refreshTag.val("刷新");
//	refreshTag.addClass("refreshChange baseBtn");
//	refreshTag.css("margin-left","5px");
}

/**
 * 账户切换
 */
$(".userAccountChange").live('change',function(){
	var tags = $(".chooseTag");
	var idArr = new Array();
	_tagShowArr = new Array();
	for ( var i = 0; i < tags.length; i++) {
		var element = tags[i];
		var id = $(element).attr("id");
		idArr[i] = id;
		_tagShowArr[i] = id;
	}

	_userAccount = $(this).val();
	//开启加载等待...
    _panelContainer.myLoading();
	getPanelData();

//	for ( var j = 0; j < idArr.length; j++) {
//		var tmp = idArr[j];
//		setTimeout(function(){$("#"+tmp).click();},500);
//	}
});

/**
 * 仓库切换
 */
$(".warehouseChange").live('change',function(){
	var tags = $(".chooseTag");
	var idArr = new Array();
	_tagShowArr = new Array();
	for ( var i = 0; i < tags.length; i++) {
		var element = tags[i];
		var id = $(element).attr("id");
		idArr[i] = id;
		_tagShowArr[i] = id;
	}

	_warehouseId = $(this).val();
	//开启加载等待...
    _panelContainer.myLoading();
	getPanelData();
//	for ( var j = 0; j < idArr.length; j++) {
//		var tmp = idArr[j];
//		setTimeout(function(){$("#"+tmp).click();},500);
//	}

    taskPane($("#task_pane_container"),moduleCodeArr,warehouseArr);

});

/**
 * 刷新
 */
$(".refreshChange").live('click',function(){
	var tags = $(".chooseTag");
	var idArr = new Array();
	_tagShowArr = new Array();
	for ( var i = 0; i < tags.length; i++) {
		var element = tags[i];
		var id = $(element).attr("id");
		idArr[i] = id;
		_tagShowArr[i] = id;
	}

	//开启加载等待...
    _panelContainer.myLoading();
	getPanelData();
});


/**
 * 刷新
 */
$(".task_pane_refreshChange").live('click',function(){
    taskPane($("#task_pane_container"),moduleCodeArr,warehouseArr);
});


/**
 * 设置统计面板是否显示
 * @param isInit boolean
 */
function setStatisticsPanelControl(isInit){
	/*
	 * 1. 是否有统计面板
	 */
	var statisticsPanel = $(".panel_container > .panel_div");
	if(statisticsPanel.length == 0){
		_statisticsPanelControl.hide();
		return;
	}
	/*
	 * 2.定义事件
	 */
	var aTagControl = _statisticsPanelControl.data('isHide');
	if(isInit){
		if(_statisticsPanelIsShow){
			statisticsPanel.show();
			_statisticsPanelControl.html("隐藏统计面板");
			_statisticsPanelIsShow = true;
		}else{
			statisticsPanel.hide();
		}
	}else{
		if(aTagControl){
			statisticsPanel.hide();
			_statisticsPanelControl.html("显示统计面板");
			_statisticsPanelIsShow = false;
		}else{
			statisticsPanel.show();
			_statisticsPanelControl.html("隐藏统计面板");
			_statisticsPanelIsShow = true;
		}
		_statisticsPanelControl.data('isHide',!aTagControl);
	}
}

/**
 * 获得看板数据
 */
function getPanelData(){
	//移除所有看板
	$(".panel_div").remove();

	var params = {};
	params['osm_code'] = _moduleCode;
	params['osp_id'] = _panelId;
	params['warehouse_id'] = _warehouseId;
	params['user_account'] = _userAccount;
	$.ajax({
	        type: "post",
	        dataType: "json",
	        data:params,
	        async:true,
	        url: '/default/system/get-System-Board',
	        success: function (json) {
	        	//存在数据，调用初始化方法
	        	if(json.ask == 1){
	        		initPanel(json.data);
	        	}else{
	        		notPanel();
	        	}

	        	//关闭加载图标
	        	_panelContainer.closeMyLoading();
	        }
	});
}

/**
 * 初始化面板数据
 * @param data
 */
function initPanel(jsonData){
	var bol1 = false;
	var bol2 = false;
	if(typeof(jsonData.module) != 'undefined' && jsonData.module.length > 0){
		//存在模块化面板
		$.each(jsonData.module, function (k, v) {
			addStatisticsPanel(v);
        });
		bol1 = true;
	}

	if(typeof(jsonData.unModule) != 'undefined' && jsonData.unModule.length > 0){
		//存在单独面板
		$.each(jsonData.unModule[0], function(k, v){
			//因为非模块类型，全部是单独面板，所以要拆分开,再遍历
			if(v.panel_type == '1'){
				//任务面板
				addTaskPanel(v);
			//因为非模块类型，全部是单独面板，所以要拆分开,再遍历
			}else if(v.panel_type == '2'){
				addReportPanel(v);
			}else{
				//统计面
				addStatisticsPanel(new Array(v));
			}
		});
		bol2 = true;
	}

	if(!bol1 && !bol2){
		notPanel();
	}

	//控制统计面板是否显示
	setStatisticsPanelControl(true);
}

/**
 * 向指定容器追加Panel--报表
 * @param jsonDate
 */
function addReportPanel(jsonData){
	/*
	 * 1.构建一个DIV，用来放置报表面板
	 */
	var divContainer = $("<div>").appendTo(_reportContainer);
	divContainer.addClass("panel_div admin_task_panel");
	divContainer.css({"width":"100%","margin-top":"10px",'border':"1px solid #d9d9d9"});
	/*
	 * 2.设置报表面板的名字
	 */
	var divName = $("<div>").appendTo(divContainer);
	divName.addClass("table-module-title");
    divName.css("padding","5px 5px");
	var divNameText = $("<h3>").appendTo(divName);
	divNameText.html(jsonData.name);

	/*
	 * 3.设置一个DIV来放置报表图形数据
	 */
	var reportContainer = $("<div>").appendTo(divContainer);
	reportContainer.css("background","none repeat scroll 0 0 #333333");

	var reportTarget = $("<div>").appendTo(reportContainer);
	reportTarget.css("padding","5px 5px");
	var reportTargetId = "report_"+jsonData.panelId;
	reportTarget.attr("id",reportTargetId);

	/*
	 * 4.获取报表所需的x，y轴所需数据
	 */
	var xAxis_index;
	var yAxis_index;
	for ( var int = 0; int < jsonData.title.length; int++) {
		var array_element = jsonData.title[int];
		if(array_element.type == 'date'){
			xAxis_index = int;
		}else if(array_element.type == 'int'){
			yAxis_index = int;
		}
	}

	var xLabels = new Array();
	var yData = new Array();
	var yDataTitle = new Array();
	for ( var int2 = 0; int2 < jsonData.val.length; int2++) {
		var array_element2 = jsonData.val[int2];
		xLabels.push(array_element2[xAxis_index]);
		yData.push(array_element2[yAxis_index]);
		yDataTitle.push($.formatStr(jsonData.title[yAxis_index].text ,[array_element2[yAxis_index]]));
	}

	/*
	 * 5.定义报表插件所需数据，并初始化
	 */
	options = {};
	options['id'] = reportTargetId;
	options['labels'] = xLabels;
	options['data'] = yData;
	options['dataTitle'] = yDataTitle;
	var reportTargetWidth = parseInt(reportTarget.css('width'));
	options['width'] = parseInt(reportTargetWidth * 0.99);
	options['height']= 220;
	options['leftgutter'] = parseInt(reportTargetWidth * 0.01);
	options['bottomgutter'] = 20,
	options['topgutter'] = 20;
	try{
		initReport(options);
	}catch(e){
		divContainer.hide();
	}
}
/**
 * 向指定容器追加Panel--任务用
 * @param jsonData
 */
var _loadTaskStyle = false;
function addTaskPanel(jsonData){
	if(!_loadTaskStyle){
		_loadTaskStyle = true;
		setTaskStyle();
	}
	/*
	 * 1.构建一个DIV，用来放置任务面板
	 */
	var divContainer = $("<div>").appendTo(_taskContainer);
	divContainer.addClass("panel_div admin_task_panel");

	/*
	 * 2.设置任务面板的名字
	 */
	var divName = $("<div>").appendTo(divContainer);
	divName.addClass("table-module-title");
	var divNameText = $("<h3>").appendTo(divName);
	divNameText.html(jsonData.name);

	/*
	 * 3.构建一个table，用来放任务明细
	 */
	var tableDetailContainer = $("<table>").appendTo(divContainer);
	tableDetailContainer.addClass("table-module");

	/*
	 * 4. 构建tr，td用来放详情
	 */
	//table中的title描述最多显示多少个(一个title对应一个val，所以是两个td标签)
	var maxTitleColspan = 2;
	var titleLength = jsonData.title.length;
	var titleIndex = 0;
	var trTag;
	for ( var int = 0; int < titleLength; int++) {
		if(titleIndex == 0){
			trTag = $("<tr>").appendTo(tableDetailContainer);
			trTag.addClass("manage_form_bk");
		}
		titleIndex += 1;

		if(titleIndex == maxTitleColspan){
			titleIndex = 0;
		}
		var tdTagTitle = $("<td>").appendTo(trTag);
		tdTagTitle.addClass("manage_form_bk2");
		tdTagTitle.css("text-align","center");
		tdTagTitle.html(jsonData.title[int].text);

		var tdTagVal = $("<td>").appendTo(trTag);
		var aTag = $("<a>").appendTo(tdTagVal);
		aTag.attr("href","javascript:;");
		var menuClass = "sub-menu-id-" + jsonData.ur_id[0][int];
		var menuEvent = parent.$("." + menuClass);
		aTag.attr("onclick",menuEvent.attr("onclick"));
		aTag.html(jsonData.val[0][int]);
	}

}

/**
 * 向指定容器追加Panel--统计用
 * @param jsonDataos_operating_statistics_panel
 */
function addStatisticsPanel(jsonData){
	/*
	 * 1.构建一个DIV，用来放置统计面板
	 */
	var divContainer = $("<div>").appendTo(_panelContainer);
	divContainer.addClass("panel_div");

	/*
	 * 2.1 构建选项卡div，ul
	 */
	var divTab = $("<div>").appendTo(divContainer);
	divTab.addClass("goodsTab2");
	var ulTab = $("<ul>").appendTo(divTab);
	
	//添加刷新按钮
	var fleshDiv = $("<div style='width:60px;height:auto;float:right;'><a style='color:#2FA5E8;font-size:14px;' href='javascript:void(0);' onclick='fleshSystemBoard();'>刷新</a></div>").appendTo(divTab);

	/*
	 * 2.2 循环构建选项卡li
	 */
	for ( var i = 0; i < jsonData.length; i++) {
		var panelData = jsonData[i];
		var liTab = $("<li>").appendTo(ulTab);
		liTab.attr("id","tab_"+panelData.panelId);
		var liTab_className = "panel_tab_li";
		//切换账户，选中上次的选项卡（单独选项卡，直接显示)）
		if($.inArray("tab_"+panelData.panelId , _tagShowArr) != -1 || jsonData.length == 1){
			liTab_className += ' chooseTag';
		}else if(_tagShowArr.length == 0){
			liTab_className += i==0?" chooseTag":"";
		}

		liTab.addClass(liTab_className);

		var aTab =$("<a>").appendTo(liTab);
		aTab.attr("href","javascript:;");
		aTab.html(panelData.name);
	}

	/*
	 * 2.3 为选项卡添加清除浮动的div
	 */
	var divTabClr = $("<div>").appendTo(divTab);
	divTabClr.addClass("clr");

	/*
	 * 3.1 构建面板数据
	 *    a、构建一个div用来放置table
	 *    b、循环构建table
	 */
	var divDataBox = $("<div>").appendTo(divContainer);
	for ( var j = 0; j < jsonData.length; j++) {
		var panelData = jsonData[j];
		var tableDataBox = $("<table>").appendTo(divDataBox);
		tableDataBox.attr("cellspacing","0");
		tableDataBox.attr("cellpadding","0");
		tableDataBox.attr("border","0");
		tableDataBox.css({"margin-top": "0px","width":"100%","display":"none"});

		var className = "tab_"+panelData.panelId + " manage_form5";
		tableDataBox.addClass(className);
		//切换账户，选中上次的面板(单独面板，直接显示)
		if($.inArray("tab_"+panelData.panelId , _tagShowArr) != -1 || jsonData.length == 1){
			tableDataBox.show();
		}else if(_tagShowArr.length == 0){
			if(j == 0){
				tableDataBox.show();
			}
		}
		/*
		 * 3.2 构建面板title
		 */
		var tableTitle = $("<tr>").appendTo(tableDataBox);
		for ( var tmp1 = 0; tmp1 < panelData.title.length; tmp1++) {
			var title = panelData.title[tmp1].text;
			var td = $("<td>").appendTo(tableTitle);
			td.addClass("manage_form5_bk");
			td.html(title);
		}

		/*
		 * 3.3 构建面板item
		 */
		for ( var tmp2 = panelData.val.length -1; tmp2 > -1; tmp2--) {
			var itemArray = panelData.val[tmp2];
			var tableItem = $("<tr>").appendTo(tableDataBox);

			for ( var tmp3 = 0; tmp3 < itemArray.length; tmp3++) {
				var array_element = itemArray[tmp3];
				var td = $("<td>").appendTo(tableItem);
				td.addClass("manage_form5_bk2");
				td.html(array_element);
			}
		}
	}
}

/**
 * 绑定选项卡事件
 */
$(".panel_tab_li").live("click",function(){
	//控制选项卡的选中效果
	var parentUl = $(this).parent();
	parentUl.children("li").removeClass("chooseTag");
	$(this).addClass("chooseTag");

	//面板数据的显示和隐藏
	var tableDataClass = $(this).attr("id");
	$("." + tableDataClass).parent().children("table").hide();
	$("." + tableDataClass).show();
});

/**
 * 刷新面板
 */
function fleshSystemBoard() {
	alertTip('正在努力刷新中。。。', 500);
	
	
	setTimeout(function(){
		$.ajax({
	        type: "POST",
	        async: false,
	        dataType: "json",
	        url: "/default/system/flesh-system-board",
	        data:{},
	        success: function (json){
	        	if (!isJson(json)) {
	        		alertTip('err 500');
	        	}
	            if (json.state == '1') {
	            	$("#dialog-auto-alert-tip").dialog("close");
	            	//加载数据
	            	getPanelData();
	            } else {
	            	$("#dialog-auto-alert-tip").html(json.message);
	            }
	        }
	    });
	}, 1000);
}

/**
 * 无面板数据，设置一个提示
 */
function notPanel(tip){
	tip = tip?tip:"无面板数据";

	var divContainer = $("<div>").appendTo(_panelContainer);
	divContainer.addClass("panel_div");
	divContainer.css({"text-align":"center","border":"1px solid #D9D9D9","height":"100px","line-height":"98px","clear":"both"});
	var tipTag = $("<h2>").appendTo(divContainer);
	tipTag.html(tip);

}

/**
 * 获得版本信息
 * @param container		放置公告的容器
 * @param code			系统代码
 */
function loadVersions(container,code) {

	//构建公告栏
	var taskTag = $("<div>").appendTo(container);
	taskTag.addClass("admin_task");

	var titleTag = $("<div>").appendTo(taskTag);
	titleTag.addClass("table-module-title");
	titleTag.css("text-align","center");
	var titleTextTag = $("<h2>").appendTo(titleTag);
	titleTextTag.html("公告栏");

	var ulTag = $("<ul>").appendTo(taskTag);
	ulTag.addClass("versions-list-data-li");

	//设置公告栏样式
	setAnnouncementStyle();

	//请求地址,及参数
    var url="http://www.eccang.com/default/versions/index?callback=?";
    var data={code:code,pageSize:"8"};
	//数据展示区域
    var element = ulTag;
    element.myLoading();
    var sName='loadVersion';
    var vData;
    var getLoadData = function (call) {
        $.ajax({
            type: "POST",
            async: true,
            data:data,
            dataType: "json",
            url: url,
            success: function (json) {
                if (json.state == '1' && isJson(json)) {
                    vData = json.data;
                    call('');
                    if (sessionStorage && typeof JSON !== 'undefined') {
                        sessionStorage.setItem('version', EZ.version);
                        sessionStorage.setItem(sName, JSON.stringify(vData));
                    }
                }
            }
        });
    };
    var setHtml = function (data) {
        element.closeMyLoading();
        data = data == '' ? vData : data;
        //定义最大显示条数，追加公告
        var showMaxNum = 8;
        $.each(data, function (k, v) {
            var container = $("<li>").appendTo(element);
            var liClassName = (k >= showMaxNum)?"noneLine":"showLine";
            container.addClass(liClassName);

            var titleTag = $("<div>").appendTo(container);
            titleTag.addClass("admin_task_title");
            var titleText = $("<a>").appendTo(titleTag);
            titleText.attr("href","javascript:;");
            titleText.html(v.v_title);

            var contentText = $("<p>").appendTo(titleTag);
            contentText.hide();
            contentText.html(v.v_content);

            var timeText = $("<div>").appendTo(container);
            timeText.addClass("admin_task_time");
            timeText.html(v.v_add_time);

        });
        //是否显示更多
        if(element.find(".noneLine").length > 0){
            var moreBt = $("<div>").appendTo(element);
            moreBt.addClass("admin_task_more");
            var moreBtText = $("<a>").appendTo(moreBt);
            moreBtText.attr("href","javascript:;");
            moreBtText.html("更多");
            //邦定事件
            $(".admin_task_more > a").live('click',function(){
                var aText = element.find(".admin_task_more > a");
                var hideLine = element.find(".noneLine:hidden");
                if(hideLine.length > 0){
                    hideLine.show();
                    $(this).html("隐藏");
                }else{
                    $(".versions-list-data-li").find(".noneLine:visible").hide();
                    $(this).html("更多");
                }
            });
        }
    };


        if (sessionStorage && typeof JSON !== 'undefined') {
            var sStorage = sessionStorage;
            if (sStorage.getItem(sName) && sStorage.getItem(sName) != "undefined" && sStorage.getItem(sName) != "" && sStorage.getItem('version') == EZ.version) {
                vData = JSON.parse(sStorage.getItem(sName));
                setHtml(vData);
            } else {
                getLoadData(setHtml);
            }
        } else {
            getLoadData(setHtml);
        }

}

//公告详情
$(".admin_task_title > a").live('click',function(){
	//标题
	var title = $(this).html();
	//公告内容
	var content = $(this).next().html();
	//时间
	var time = $(this).parent().next().html();

	var width = 750;
	var height = 500;
	var html = '<div title="公告" id="dialog-auto--tip">'
					+'<div style="text-align:center;">'
						+'<h2>'+title+'</h2>'
					+'</div>'
					+'<div style="border: 1px solid #D9D9D9;padding:10px 5px;">'
						+'<p>'+content+'</p>'
						+'<p style="text-align: right;height: 18px;">'+time+'</p>'
					+'</div>'
				+'</div>';

	$(html).dialog({
	        autoOpen: true,
	        width: width,
	        maxHeight: height,
	        modal: true,
	        show: "slide",
	        close: function () {
	            $(this).detach();
	        }
	});
});

/**
 * 设置公告栏样式
 */
function setAnnouncementStyle(){
	var _style = (!$("<style>"))?$("<style>").eq(0):$("<style>").insertBefore("body");
    if (typeof(_style) == 'undefined') {
        return;
    }
	_style.append(".admin_task { border:1px solid #d9d9d9; border-top:none; padding-bottom:4px; margin-left:10px;}"+
				".admin_task h2 { height:30px; line-height:30px; padding:0px 10px; background:url(../images/index/bg_index02.gif) repeat-x; border-bottom:1px solid #e3e3e3; font-size:12px; font-weight:bold; }"+
				".admin_task ul {padding-bottom:20px;max-height: 410px;overflow:auto;}"+
				".admin_task ul li { padding-left:10px; margin:5px 10px; height:38px;border-bottom:1px solid #d9d9d9;overflow:hidden;}"+
				".admin_task_text { width:80%; float:left; height:38px; line-height:38px;  overflow:hidden;}"+
				".admin_task_operate { width:60px; height:38px; line-height:38px; float:right; text-align:right; color:#999; overflow:hidden; }"+
				".admin_task_title {float: left;font-size: 12px;height: 16px;overflow: hidden;text-align: left;text-overflow: ellipsis;white-space: nowrap;width: 240px;}"+
				".admin_task_time {float: right; font-size: 10px; height: 18px;}"+
				".admin_task_more {float: right; height: 18px;padding-right: 10px;}"+
				".noneLine {display: none;}");
}

/**
 * 设置任务栏样式
 */
function setTaskStyle(){
	var _style = (!$("<style>"))?$("<style>").eq(0):$("<style>").insertBefore("body");
    if (typeof(_style) == 'undefined') {
        return;
    }
	_style.append(".admin_task_panel{-moz-border-bottom-colors: none;-moz-border-left-colors: none;-moz-border-right-colors: none;-moz-border-top-colors: none;border-color: #D9D9D9;"+
						"border-image: none;border-style: none solid solid;border-width: medium 1px 1px;margin-top: 10px;margin-right: 5px;max-height: 410px;overflow: auto;float: left;width: 49%;}"+
				  ".admin_task_panel h2 {background: url('../images/index/bg_index02.gif') repeat-x scroll 0 0 rgba(0, 0, 0, 0);border-bottom: 1px solid #E3E3E3;font-size: 12px;font-weight: bold;height: 30px;"+
				  		"line-height: 30px;padding: 0 10px;}"+
				  ".admin_task_panel table{float:left;margin-top:0px;width:100%;border:0;cellpadding:0;cellspacing:0;}");
}
/**
 * 设置任务面板样式
 */
function setPaneTaskStyle(){
	var _style = (!$("<style>"))?$("<style>").eq(0):$("<style>").insertBefore("body");
    if (typeof(_style) == 'undefined') {
        return;
    }
	_style.append(".task_pane_container{width:70%;float:left;height:auto;overflow:hidden;margin-top:10px;border:1px solid #d9d9d9;}.table-module-title-2{background-color:#f2f2f2;clear:both;height:auto;float:left;overflow:hidden;width:100%;padding:5px 0 5px 16px;}.task_pane_div{border:1px solid#f2f2f2;}.task_pane_div_data{padding-left:16px;clear:both;}.task_pane_div_data li{line-height:26px;height:26px;text-align:left;}.task_pane_div_data li span{font-weight:bold;padding:0px 5px;}");
}

/**
 * 替换字符串中的占位符
 * @param str	可能还有占位符的字符串
 * @param array	替换占位符的数组
 * @returns String
 * 调用方式：
 * var str = "表情{0}，表情{1}，表情{2}";
 * var ary = ['→ →','← ←','_(:3」∠)_'];
 * var tmp = $.formatStr(str ,ary));
 */
$.formatStr = function (){

	//传入数组为空时直接返回
	if(!arguments[1]){
		return arguments[0];
	}

	//存放替换占位符的数组
	var ary = [];
	for(i = 0 ; i < arguments[1].length ; i++){
		ary.push(arguments[1][i]);
	}

	return arguments[0].replace(/\{(\d+)\}/g,function(m ,i){
		//对于溢出的占位符，替换为空字符串
		return (ary[i])?ary[i]:"";
	});
};

//任务面板样式
$(function(){
    setPaneTaskStyle();
});

//任务面板
function getTaskPaneData(jsonData, task_pane_div) {
    $.each(jsonData, function (key, val) {
        if (val.data.length > 0) {
            var panelControl = $("<div>").appendTo(task_pane_div);
            panelControl.addClass("table-module-title-2");
            panelControl.css({"text-align":"right"});
            var ul = $("<ul>").appendTo(panelControl);
            ul.css({"width":"96%"});
            ul.append(val.date);
            var tagTitle = $("<div>").appendTo(ul);
            tagTitle.css({"width": "160px", "float": "left", "text-align": "left"});

            var panelTitle = $("<h3>").appendTo(tagTitle);

            panelTitle.html(val.app_name);
           // panelTitle.html(val.app_name+"("+val.date+")");
            var task_pane_div_data = $("<div>").appendTo(task_pane_div);
            task_pane_div_data.addClass("task_pane_div_data");
            var task_pane_div_data_ul = $("<ul>").appendTo(task_pane_div_data);
            for (var i = 0; i < val.data.length; i++) {
                var li = $("<li>").appendTo(task_pane_div_data_ul);
                li.html(val.data[i]);
            }
        }
    });
}

function taskPane(task_pane_container, moduleCode, warehouseArr) {
    var _task_pane_container = task_pane_container;

    //追加一个div用来放置过滤条件控件
    if (!$(".task_pane_refreshChange").size()) {
        var divContainer = $("<div>").appendTo(_task_pane_container);
        divContainer.addClass("table-module-title");
        divContainer.css({"padding": "5px 5px", "text-align": "right"});

        var tagTitle = $("<div>").appendTo(divContainer);
        tagTitle.css({"width": "160px", "float": "left", "text-align": "left"});
        tagTitle.html("<h3>任务面板</h3>");

        var _panelControl = $("<a>").appendTo(divContainer);
        _panelControl.css("margin-right", "15px");
        _panelControl.html("刷新");
        _panelControl.attr("href", "javascript:void(0);");
        _panelControl.addClass("task_pane_refreshChange");
    }


    //移除所有看板
    $(".task_pane_div").remove();

    var task_pane_div = $("<div>").appendTo(_task_pane_container);
    task_pane_div.addClass("task_pane_div");
    //开启加载等待...
    task_pane_div.myLoading();

    var params = {};
    params['osm_code'] = moduleCode;
    params['warehouse_id'] = _warehouseId;

    $.ajax({
        type: "post",
        dataType: "json",
        data: params,
        async: true,
        url: '/default/system/get-task-pane',
        success: function (json) {
            //存在数据，调用初始化方法
            if (json.ask == '1') {
                getTaskPaneData(json.data, task_pane_div);
                if (!$(".task_pane_div_data").size()) {
//                    _task_pane_container.html('');
                    notTaskPanel(_task_pane_container);
                }
            }else{
//                _task_pane_container.html('');
                notTaskPanel(_task_pane_container);
            }
            //关闭加载图标
            task_pane_div.closeMyLoading();
        }
    });
}

/**
 * 无任务数据，设置一个提示
 */
function notTaskPanel(_task_pane_container,tip){
    tip = tip?tip:$.getMessage('home_no_task_data');//"无任务数据"

    var divContainer = $("<div>").appendTo(_task_pane_container);
    divContainer.addClass("task_pane_div");
    divContainer.css({"text-align":"center","border":"1px solid #D9D9D9","height":"100px","line-height":"98px","clear":"both"});
    var tipTag = $("<h2>").appendTo(divContainer);
    tipTag.html(tip);

}