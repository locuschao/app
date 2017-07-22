<script type="text/javascript" src="/js/jquery-ui-timepicker-addon.js" ></script>

<script type="text/javascript">
    EZ.url = '/report/Feedbackreport/';
    EZ.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1' height='60' >" : "<tr class='table-module-b2' height='60'>";
            html += "<td class='ec-center'><input type='checkbox' class='checkItem' name='orderId[]' ref_id='"+val.D0+"' value='" + val.D0 + "'/></td>";
            html += "<td class='ec-center'>" + (i++) + "</td>";
            html +="<td>"+val.D5+"</td>";
            html +="<td>"+val.D6+"</td>";
            html +="<td>"+val.D7+"</td>";
            html +="<td>"+val.D9+"</td>";
            html +="<td>" + ((val.D20 == '0000-00-00 00:00:00')? '' : moment(val.D20).format('YYYY-MM-DD')) + "</td>";
            switch(val.D21) {
                case '1':
                    html += '<td>质检异常</td>';
                    break;
                case '2':
                    html += '<td>买家退件</td>';
                    break;
                case '4':
                    html += '<td>测试</td>';
                    break;
                case '5':
                    html += '<td>测试1</td>';
                    break;
                case '6':
                    html += '<td>运输时效问题</td>';
                    break;
                case '7':
                    html += '<td>这种产品已过期，需要重新质检</td>';
                    break;
                default :
                    html += '<td></td>';
                    break;
            }
            html +="<td>"+val.D22+"</td>";

            switch(val.D24) {
                case '1':
                    html += '<td>无处理</td>';
                    break;
                case '2':
                    html += '<td>退款</td>';
                    break;
                case '3':
                    html += '<td>重发</td>';
                    break;
                case '4':
                    html += '<td>退件</td>';
                    break;
                default :
                    html += '<td></td>';
                    break;
            }
            html +="<td>"+val.D17+"</td>";
            /*html +="<td>"+val.D11+"</td>";
            html +="<td>"+val.D12+"</td>";
            html +="<td>"+val.D14+"</td>";
            html +="<td>"+val.D15+"</td>";
            html +="<td>"+val.D16+"</td>";
            html +="<td>"+val.D17+"</td>";
            html +="<td>"+val.D18+"</td>";
            html +="<td>"+val.D19+"</td>";
            html +="<td>"+val.D25+"</td>";*/
            if(val.D28 == null){
                html +="<td></td>";
            }else{
                html +='<td>';
                  html +='<div class="spec-list"><a href="javascript:;" class="arrow-prev disabled"><i class="sprite-arrow-prev" onclick="slider1(this)"></i></a><a href="javascript:;" class="arrow-next"><i class="sprite-arrow-next" onclick="slider2(this)"></i></a><div  class="spec-items" style="position: relative;width:192px;margin-left:20px;height: 60px; overflow: hidden;"><ul class="lh" style="position: absolute;height: 60px; top: 0px; left: 5px;">';
                  $.each(val.D28,function (keys, vals) {
                      html += '<li class="img-hover"><img alt="" src="'+vals+'" data-url="" onmouseover ="big_picture(this)" onmouseout="remove(this)" data-img="1" width="50" height="64"><div style="position:fixed; top:350px;right:350px;display:none;"><img src="'+vals+'" width="300"/></div></li>';
                  })
                          html+='</ul> </div> </div>';
                html +='</td>';
            }

            html += "</tr>";
        });
        return html;
    }

    //图片放大效果
    function big_picture(obj) {
        $(obj).next().css('display','');
    }
    //清除div
    function remove(obj) {
        $(obj).next().css('display','none');
    }

    //轮播图切换效果
    var index=0;//定义初始化变量
    function slider1(obj) {
        var $v_citemss = $(obj).parent().parent().find(".lh");//获取当前对象
        p_count = $(obj).parent().parent().find("li").length;//获取此处li的个数
        length=-(p_count-3)*62;
        left= parseInt($v_citemss.css('marginLeft'));
            if (left ==0) {
                index=1;
                width = index * 62;
                $v_citemss.animate({marginLeft:-width+"px"});
            } else if(left>length) {
                ++index;
                width = index * 62;
                $v_citemss.animate({marginLeft:-width+"px"});
            }else{
                return false;
            }
    }
    function slider2(obj){
        var $v_citemss = $(obj).parent().parent().find(".lh");
        p_count = $(obj).parent().parent().find("li").length;//获取此处li的个数
        length=-(p_count-3)*62;
        left= parseInt($v_citemss.css('marginLeft'));
        if ( left==0) {
           return false;
        } else if(left<=0) {
            --index;
            px=parseInt($v_citemss.css('marginLeft'))+62;//获取属性margin-left值
            $v_citemss.animate({marginLeft:px+"px"});
            return false;
        }
    }

    //日期选择
    $(function(){
        var dayNamesMin = ['日', '一', '二', '三', '四', '五', '六'];
        var monthNamesShort = ['01月', '02月', '03月', '04月', '05月', '06月', '07月', '08月', '09月', '10月', '11月', '12月'];
        $.timepicker.regional['ru'] = {
            timeText : '选择时间',
            hourText : '小时',
            minuteText : '分钟',
            secondText : '秒',
            millisecText : '毫秒',
            currentText : '当前时间',
            closeText : '确定',
            ampm : false
        };
        $.timepicker.setDefaults($.timepicker.regional['ru']);
        $('.dateFrom,.dateEnd,.date').datetimepicker({
            dayNamesMin : dayNamesMin,
            monthNamesShort : monthNamesShort,
            changeMonth : true,
            changeYear : true,
            dateFormat : 'yy-mm-dd'
        });

        $(".checkAll").live('click', function() {
            $(".checkItem").attr('checked', $(this).is(':checked'));
        });
    });

    //选择查询单号搜索类型
    $(function(){
        $("#pfr_skus").on('change',function(){
            var values = this.value;
            if(values != null){
                $("#pfr_sku").attr('name',values);
            }
        });
    });

    //导出订单
    function export_stock_report(){
        var string='';
        var data='';
        if( $(".checkItem:checked").size()>0){

            $(".checkItem:checked").each(function(){
                string+=$(this).val()+"-";
            });

            data = '<input type="hidden" name="pfr_id_arr" value="'+string+'">';
            alertConfirmTip('确定导出选定的产品?',function(){
                execute_export(data,1);
                    });
        }else{
            var no_con=true;
            data=$("#searchForm").serialize();
            $('#search-module :input').not("[type=button]").each(function(){
//                var a = $(this).html();
//                   console.log(a);return;
                if($(this).html()!=''){
                    no_con=false;
                }
            });
            if(no_con){
                alertConfirmTip('你没有选择搜索条件,将导出全部数据,这将需要更长时间等待,确认导出?',function(){
                    execute_export(data,2);
                });
            }else{
                alertConfirmTip('确定导出搜索条件对应的产品?',function(){
                    execute_export(data,2);
                });
            }
        }
    }

    //执行订单导出
    function execute_export(data,type){
        if(type==1){
            $('#exportForm').html('');
            // 添加查询条件
            $('#exportForm').append(data);
            // 提交
            setTimeout(function(){
                $('#exportForm').submit();
            },500);
        }
        if(type==2){
            var url="/report/feedbackreport/execute-export?";
            window.location = url+data;
        }
    }
</script>
<style type="text/css">
    .boundBtn {
        float: right;
        margin: 10px 5px 0 0;
        font-size: 14px;
    }
    .spec-items ul li {
        float: left;
        margin: 0 6px;
    }
    .sprite-arrow-next {
        width: 22px;
        height: 32px;
        background-image: url(/images/base/sprite.png);
        background-position: -78px 0;
        margin-left:218px;
        position: relative;
        top: 148%;
    }
    .spec-list .arrow-prev.disabled i {
        background: url(/images/base/disabled-prev.png);
        position: relative;
        top: 148%;
    }
    .sprite-arrow-prev {
        width: 22px;
        height: 32px;
        background-image: url(/images/base/sprite.png);
        background-position: 0 -54px;
        margin-left: -6px;
    }
     .spec-list .arrow-next i, .spec-list .arrow-prev i {
        display: block;
    }
    .lh {
        zoom: 1;
    }
   .spec-list .arrow-prev {
        display: block;
        width: 22px;
        height: 32px;
        float: left;
        position:relative;
        cursor: pointer;
        top: 50%;
        margin-top: -32px;
    }
    .spec-list .arrow-next{
        display: block;
        width: 22px;
        height: 32px;
        float: left;
        position: relative;
        cursor: pointer;
        top: 50%;
        margin-top: -32px;
    }
</style>
<div id="module-container">
    <form id="exportForm" action="/report/feedbackreport/execute-export" style='display: none;' method='POST'></form>
    <div id="module-table">
        <div class="module-head">
            <span class="module-title">产品反馈列表</span>
            <button id="import" class="initBtn otherBtn boundBtn" style="width: 100px;" onclick="export_stock_report()">批量导出</button>
        </div>
        <div id="search-module">
            <form id="searchForm" name="searchForm" class="submitReturnFalse">
                <div style="padding:0">
                    <div class="search-module-condition">
                        <span class="searchFilterText">单号：</span>
                        <select  class="selectCss2 " id="pfr_skus" style="width:120px;">
                            <option >请选择查询类型</option>
                            <option  value="pfr_sku">SKU号</option>
                        </select>
                        <label title="" style="cursor: pointer;">
                            <input type="text"  class="input_text keyToSearch" id="pfr_sku" placeholder="请输入单号">
                        </label>
                    </div>
                    <div class="search-module-condition">
                        <span class="searchFilterText" style="width: 100px;">采购商：</span>
                        <input type="text" name="pfr_from"  class="input_text keyToSearch" id="txt" placeholder="请输入采购商">
                    </div>
                    <!-- <div class="search-module-condition">
                        <span class="searchFilterText" style="width: 100px;">问题类型：</span>
                        <select  class="selectCss2 " name="pfr_error_type" id="pfr_error_type"  style="width: 130px;height: 24px;">
                            <option  value="">请选择类型</option>
                            <{foreach from=$getErrorData item=w key=k}>
                            <option  value='<{$k}>'><{$w}></option>
                            <{/foreach}>
                        </select>
                    
                    </div> -->
                    <!-- <div class="search-module-condition">
                        <span class="searchFilterText" style="width: 100px;">处理方式：</span>
                        <select  class="selectCss2 " id="pfr_settle_way" name="pfr_settle_way" style="width: 130px;height: 24px;">
                            <option value="">请选择类型</option>
                            <{foreach from = $getProblemHandleMethor item=v key=k }>
                            <option  value="<{$k}>"><{$v}></option>
                            <{/foreach}>
                        </select>
                    </div> -->
                    <div class="search-module-condition">
                        <span class="searchFilterText">时间：</span>
                        <input type="text" name="firstDateinfo" class="input_text datepicker dateFrom" /> 到 <input type="text" name="endDateinfo" class="input_text datepicker dateFrom" />
                    </div>
                    &nbsp;&nbsp;
                    <div class="search-module-condition">
                        <span class="searchFilterText">&nbsp;</span>
                        <input type="button" value="<{t}>搜索<{/t}>" class="initBtn otherBtn submitToSearch"/>
                    </div>
                </div>
            </form>
        </div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module">
            <tr class="table-module-title">
                <td width="2%" class="ec-center"><input type="checkbox" class="checkAll"></td>
                <td width="4%">NO.</td>
                <td>产品代码</td>
                <td>采购商</td>
                <td>国家</td>
                <td>销售平台</td>
                <td>发生时间</td>
                <td>问题类型</td>
                <td>数量</td>
                <td>处理方式</td>
                <!-- <td>RMA总数</td>
                <td>RMA比例</td> 
                <td>退款订单数</td>
                <td>币种</td>
                <td>重发订单数</td>
                <td>重发SKU树</td>
                <td>RMA原因</td>
                <td>仓库退件订单</td>
                <td>仓库退件SKU数</td>-->
                <td>问题内容</td>
                <td style="width:250px;">问题图片</td>

            </tr>
            <form id="listForm" method="POST" action=""></form>

            <tbody id="table-module-list-data"><tr class="table-module-b1"><td colspan="12">请搜索...</td></tr>

            </tbody>
        </table>
    </div>
    <div class="pagination"></div>
    <div class="to_top_div" data-show="false"><span style="float: left;cursor: pointer;padding: 0px 2px;" title="返回顶部" class="iconToTop" onclick="toTop();"></span><span style="float: left;cursor: pointer;padding: 0px 2px;" title="前往底部" class="iconToBottom" onclick="toBottom();"></span>
    </div>
</div>

<div id="ez-wms-edit-dialog" style="display:none;">
    <table class="dialog-module" border="0" cellpadding="0" cellspacing="0">
        <tbody>
        <input type="hidden" name="D0" id="D0" value=""/>

        </tbody>
    </table>
</div>

<script type="text/javascript" src="/js/moment.js"></script>


