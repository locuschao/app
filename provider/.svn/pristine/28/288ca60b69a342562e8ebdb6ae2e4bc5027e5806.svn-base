jQuery.fn.closeMyLoading = function close() {
    $(this).find(".loading").remove();
};

var _topContainer;					//面板区域的顶级容器(包含了过来条件+面板)
var _panelContainer;				//放置所有看板的容器（DIV，自己构建的）
var _reportContainer;				//放置所有报表的容器
var _taskContainer;					//放置所有任务的容器
var _moduleCode = new Array();		//模块代码（array）
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
 * 构建过滤条件
 */
function initFilter() {
    if (!_existUserAccountOption && !_existWarehouseOption) {
        return;
    }
    //追加一个div用来放置过滤条件控件
    var divContainer = $("<div>").insertBefore(_panelContainer);
    divContainer.addClass("table-module-title");
    divContainer.css({"padding": "8px 5px", "text-align": "right"});

    var tagTitle = $("<div>").appendTo(divContainer);
    tagTitle.css({"width": "100px", "float": "left", "text-align": "left"});
    tagTitle.html("<h3>我的面板</h3>");

    _statisticsPanelControl = $("<a>").appendTo(divContainer);
    _statisticsPanelControl.css("margin-right", "15px");
    _statisticsPanelControl.html("刷新");
    _statisticsPanelControl.attr("href", "javascript:void(0);");
    _statisticsPanelControl.addClass("refreshChange");

    //仓库ID
    if (_existWarehouseOption) {
        divContainer.append("仓库：");
        var selectTag = $("<select>").appendTo(divContainer);
        selectTag.css({"width": "160px"});
        selectTag.addClass("warehouseChange");
        var optionTagAll = $("<option>").appendTo(selectTag);
        optionTagAll.val('all');
        optionTagAll.html('全部');
        for (var i = 0; i < _warehouseIdArr.length; i++) {
            var val = _warehouseIdArr[i];
            var optionTag = $("<option>").appendTo(selectTag);
            optionTag.val(val.warehouse_id);
            optionTag.html(val.warehouse_code + ' [' + val.warehouse_desc + ']');
        }

    }
}

/**
 * 获得看板数据
 */
function getPanelData(appCode,date) {
    //移除所有看板
    if(appCode==undefined || appCode==''){
        $(".panel_div").remove();
    }

    var params = {};
    params['osm_code'] = _moduleCode;
    params['warehouse_id'] = _warehouseId;
    params['app_code'] = appCode;
    params['date'] = date;
    // params['user_account'] = _userAccount;
    $.ajax({
        type: "post",
        dataType: "json",
        data: params,
        async: true,
        url: '/common/panel/get-system-board',
        success: function (json) {
            //存在数据，调用初始化方法
            if (json.ask == 1) {
                initPanel(json.data);
            } else {
                notPanel();
            }
            //关闭加载图标
            _panelContainer.closeMyLoading();
        }
    });
}

/**
 * 无面板数据，设置一个提示
 */
function notPanel(tip) {
    tip = tip ? tip : "无面板数据";
    var divContainer = $("<div>").appendTo(_panelContainer);
    divContainer.addClass("panel_div");
    divContainer.css({
        "text-align": "center",
        "border": "1px solid #D9D9D9",
        "height": "100px",
        "line-height": "98px",
        "clear": "both"
    });
    var tipTag = $("<h2>").appendTo(divContainer);
    tipTag.html(tip);
}
/**
 * 初始化面板数据
 * @param data
 */
function initPanel(jsonData) {
    var bol1 = false;
    var bol2 = true;
    if (typeof(jsonData.unModule) != 'undefined' && jsonData.unModule.length > 0) {
        //存在模块化面板
        $.each(jsonData.unModule, function (k, v) {
            $.each(v, function (kk, vv) {
                addPanel(vv);
            });

        });
        bol1 = true;
    }

    if (!bol1 && !bol2) {
        notPanel();
    }

}

/**
 *@加载面板,N个
 */
function addPanel(jsonData) {
    /*
     * 1.构建一个DIV，用来放置报表面板
     */
    if($(".admin_task_panel_"+jsonData.app_code).size()){
        var divContainer = $(".admin_task_panel_"+jsonData.app_code);
        divContainer.html('');
    }else{
        var divContainer = $("<div>").appendTo(_reportContainer);
        divContainer.addClass("panel_div admin_task_panel_"+jsonData.app_code);
    }

    divContainer.css({"width": "100%", "height": "100%", "overflow": "hidden"});


    /*
     * 2.设置一个DIV来放置报表图形数据
     */
    var reportContainer = $("<div>").appendTo(divContainer);
    reportContainer.css({"min-width": "550px", "height": "280px", "max-width": "650px", "float": "left"});

    var reportTargetId = "report_" + jsonData.panelId;
    reportContainer.attr("id", reportTargetId);

    /*
     * 3.设置一个DIV来放置报表数据
     */
    var reportTableContainer = $("<div>").appendTo(divContainer);
    reportTableContainer.css({"margin-left": "30px", "float": "left", "overflow": "hidden", "width": "350px"});

    //占位
    var divClear = $("<div>").appendTo(reportTableContainer);
    divClear.css({"margin-top": "48px", "width": "100%"});


    /*
     * 3.1.设置报表过滤条件(如果有)
     */

    if(typeof(jsonData.date) != 'undefined' && jsonData.date.length>1){
        var condition = $("<div>").appendTo(reportTableContainer);
        condition.addClass("table-module-title");
        condition.css({"padding":"5px","text-align":"right"});

        var currDate='';
        var selDate = jsonData.app_code + "_selDate";
        if (typeof(_tagShowArr[selDate]) != 'undefined') {
            currDate = _tagShowArr[selDate];
        }

        var tagTitle = $("<div>").appendTo(condition);
        tagTitle.css({"width": "100px", "float": "left", "text-align": "left"});
        //今天 昨天
        tagTitle.html("<span class='select_today'><a class='select_today_click' appCode="+jsonData.app_code+" href='javascript:void(0);'>今天</a></span><span class='select_yesterday'><a class='select_yesterday_click' appCode="+jsonData.app_code+" href='javascript:void(0);'>昨天</a></span>");



        condition.append("日期：");
        var selectTag = $("<select>").appendTo(condition);
        selectTag.css({"width": "160px"});
        selectTag.attr("appCode",jsonData.app_code);
        selectTag.addClass("dateChange");
        for (var i = 0; i < jsonData.date.length; i++) {
            var val = jsonData.date[i];
            var optionTag = $("<option>").appendTo(selectTag);
            if(currDate==val){
                optionTag.attr("selected",true);
            }
            optionTag.val(val);
            optionTag.html(val);
        }

    }


    /*
     * 3.2.table栏
     */
    var tableDataBox = $("<table>").appendTo(reportTableContainer);
    tableDataBox.addClass("table-module");
    // tableDataBox.attr("cellspacing","0");
    //tableDataBox.attr("cellpadding","0");
    //tableDataBox.attr("border","0");
    tableDataBox.css({"margin-top": "0px", "width": "100%"});


    //默认参数
    var options = {
        chart: {
            plotBackgroundColor: null,
            //plotBorderWidth: 1,//null,//外框
            plotShadow: false
        },
        credits: {
            enabled: false
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: ' ', data: []
        }]
    };

    //3D饼
    var options3d = {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        credits: {
            enabled: false
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        tooltip: {
            pointFormat: '<b>{series.name}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>'
                }
            }
        },
        series: [{
            type: 'pie',
            name: ' ',
            data: []
        }]
    };

    //样式
    if (jsonData.style.toUpperCase() == '3D') {
        options = options3d;
    }

    //标题
    options.title.text = jsonData.name;
    //副标题 刷新时间
    options.subtitle.text = jsonData.date_refresh;
    var series = {
        type: 'pie',
        name: ' ',
        data: []
    };
    var length=jsonData.val.length;
    $.each(jsonData.val, function (k, v) {
        //目前仅显示一条信息
        if (k == (length-1)) {
            var value = '';
            for (var i = 0; i < v.length; i++) {
                value = parseFloat(v[i]);
                var item = {
                    name: jsonData.title[i].text + ":" + value,
                    y: value
                };
                //
                if (i == 0) {
                    item.sliced = true;
                    item.selected = true;
                }

                series.data.push(item);

                //文字 构建面板tr
                var tableTr = $("<tr>").appendTo(tableDataBox);
                tableTr.addClass("manage_form_bk");
                var td = $("<td>").appendTo(tableTr);
                td.addClass("manage_form_bk2");
                td.html(jsonData.title[i].text);
                var td = $("<td>").appendTo(tableTr);
                //td.addClass("manage_form_bk2");
                td.html(value);
            }
        }
    });
    options.series.push(series);
    //console.log(options);
    //图形
    reportContainer.highcharts(options);
}

function loadPanel(container, moduleCode, warehouseId, userAccount) {

    //指定参数
    _topContainer = container;
    _panelContainer = $("<div>").appendTo(_topContainer);
    _panelContainer.addClass("panel_container");
    _reportContainer = $("<div>").appendTo(_topContainer);
    _reportContainer.addClass("report_container");
    _taskContainer = $("<div>").appendTo(_topContainer);
    _taskContainer.addClass("task_container");
    _moduleCode = moduleCode;

    _warehouseIdArr = warehouseId;
    _userAccountArr = userAccount;
    if (typeof(_warehouseIdArr) != 'undefined' && _warehouseIdArr.length > 0) {
        _warehouseId = _warehouseId == '' ? _warehouseIdArr[0].warehouse_id : _warehouseId;
        _existWarehouseOption = true;
    }
    if (typeof(_userAccountArr) != 'undefined' && _userAccountArr.length > 0) {
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


function doHandleMonth(month){
    if(month.toString().length == 1){
        month = "0" + month;
    }
    return month;
}

function GetDateStr(AddDayCount) {
    var dd = new Date();
    dd.setDate(dd.getDate()+AddDayCount);//获取AddDayCount天后的日期
    var y = dd.getFullYear();
    var m = dd.getMonth()+1;//获取当前月份的日期
    var d = dd.getDate();
    return y+"-"+doHandleMonth(m)+"-"+doHandleMonth(d);
}

$(function () {
    setTaskTitleStyle();
    /**
     * 仓库切换
     */
    $(".warehouseChange").live('change', function () {
        //重置条件
        _tagShowArr=new Array();
        _warehouseId = $(this).val();
        //开启加载等待...
        _panelContainer.myLoading();
        getPanelData();
    });

    /**
     * 日期切换
     */
    $(".dateChange").live('change', function () {
        var appCode = $(this).attr("appCode");
        //开启加载等待...
       // _panelContainer.myLoading();
        //记录当前时间
        _tagShowArr[appCode+'_selDate']=$(this).val();
        getPanelData(appCode,$(this).val());

    });

    /**
     * 刷新
     */
    $(".refreshChange").live('click', function () {
        //重置条件
        _tagShowArr=new Array();
        //开启加载等待...
        _panelContainer.myLoading();
        getPanelData();
    });


    /**
     * 今天
     */
    $(".select_today_click").live('click', function () {
        var appCode = $(this).attr("appCode");
        //开启加载等待...
        // _panelContainer.myLoading();
        //记录当前时间
        var date=GetDateStr(0);
        _tagShowArr[appCode+'_selDate']=date;
        getPanelData(appCode,date);
    });

    /**
     * 昨天
     */
    $(".select_yesterday_click").live('click', function () {
        var appCode = $(this).attr("appCode");
        //开启加载等待...
        // _panelContainer.myLoading();
        var date=GetDateStr(-1);
        _tagShowArr[appCode+'_selDate']=date;
        getPanelData(appCode,date);
    });

});


/**
 * 设置任务栏样式
 */
function setTaskTitleStyle(){
    var _style = (!$("<style>"))?$("<style>").eq(0):$("<style>").insertBefore("body");
    _style.append(".select_today{font-weight:bold;}.select_yesterday{font-weight:bold;margin-left:10px;}");
}