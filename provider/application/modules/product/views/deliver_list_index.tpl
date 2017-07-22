<script src="/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
<script type="text/javascript">
    EZ.url = '/product/deliver/';
    EZ.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html +=" <td class='ec-center'><input type='checkbox' class='checkItem' name='dsoId[]'  ref_id='"+val.dso_id+"' value='"+val.dso_id+"'></td>";
            html += "<td>" + (i++) + "</td>";
            html +=" <td>"+val.dso_no+"</td>";
            html +=" <td>"+val.count_dso_no+"</td>";
            html +=" <td>"+val.dso_create_time+"</td>";
            html +=" <td>";
            html +="<a href='javascript:void(0);' onclick='viewDetail(this);' class='single-operation' data-dsoid = '"+val.dso_id+"'>" + EZ.view + "</a>";
            html +="</td>";
            html += "</tr>";
        });
        return html;
    }
    //全选
    $(function(){
        $(".checkAll").live('click', function() {
            $(".checkItem").attr('checked', $(this).is(':checked'));
        });
    });
    $(function(){
        //初始化时间 start
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

        $(".datepicker").datepicker({
            dayNamesMin : dayNamesMin,
            monthNamesShort : monthNamesShort,
            changeMonth : true,
            changeYear : true,
            dateFormat : 'yy-mm-dd',
            defaultDate: -1
        });

        $(".datepickerTo").datepicker({
            dayNamesMin : dayNamesMin,
            monthNamesShort : monthNamesShort,
            changeMonth : true,
            changeYear : true,
            dateFormat : 'yy-mm-dd',
            defaultDate: +1
        });
        //初始化时间 end
    });
    $(function(){
        //送样单列表
        $("#deliver_list").dialog({
            autoOpen: false,
            width: 900,
            height: 600,
            modal: true,
            show: "slide",
            buttons: [
                {
                    text: "关闭(Cancel)",
                    click: function () {
                        $(this).dialog("close");
                    }
                }
            ]
        });
    });
    function viewDetail(object){
        $.ajax({
            async:true,
            type:'Post',
            url:'/product/deliver/detail',
            data:{
                dosId:$(object).data('dsoid'),
            },
            dataType:'json',
            success:function(json){
                if(json.state == 0){
                    var tabHtml = '';
                    tabHtml += "<tr class='table-module-b1'>";
                    tabHtml +=" <td colspan='13'>"+json.message+"</td>";
                    tabHtml += "</tr>";
                    $('#detail_data_sapmles').append(tabHtml);
                    $("#deliver_list").dialog('open');
                    return;
                }
                var html = '';
                var i = 1;
                $.each(json.data.spamleInfo, function (key, val) {
                    html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
                    html += "<td>" + (i++) + "</td>";
                    html +=" <td>"+val.sample_no+"</td>";
                    html +=" <td>"+val.bidding_name+ (val.bidding_name_en ? "["+val.bidding_name_en+"]" : '')+"</td>";
                    html +=" <td>长：" + val.bidding_long +val.bidding_size_unit+"<br>";
                    html += "宽：" + val.bidding_width+val.bidding_size_unit+"<br>";
                    html += "高：" + val.bidding_heigh +val.bidding_size_unit;
                    html += "</td>";
                    html +=" <td>"+val.bidding_color+"</td>";
                    html +=" <td>"+val.sample_price+val.sample_price_unit+"</td>";
                    html +=" <td>"+val.bidding_amount+val.bidding_amount_unit+"</td>";
                    html += "</tr>";
                });
                var tabHtml = '';
                tabHtml += "<tr class='table-module-b1'>";
                tabHtml +=" <td class='ec-center'>送样单号:"+json.data.dsoInfo.dso_no+"</td>";
                tabHtml +=" <td class='ec-center'>采购商名称:"+json.data.dsoInfo.user_name+(json.data.dsoInfo.user_name_en ? "["+json.data.dsoInfo.user_name_en+"]" : '')+"</td>";
                tabHtml +=" <td class='ec-center'>采购商收货地址:"+json.data.dsoInfo.bidding_address+"</td>";
                tabHtml += "</tr>";
                tabHtml += "<tr class='table-module-b2'>";
                tabHtml +=" <td class='ec-center'>联系人电话:"+json.data.dsoInfo.bidding_phone+"</td>";
                tabHtml +=" <td class='ec-center'>样品数:"+json.data.dsoInfo.count_dso_no+"</td>";
                tabHtml +=" <td class='ec-center'></td>";
                tabHtml += "</tr>";
                $('#detail_data_dos').html('');
                $('#detail_data_dos').append(tabHtml);
                $('#detail_data_sapmles').html('');
                $('#detail_data_sapmles').append(html);
            }
        });
        /* 清空客户代码 end*/
        $("#deliver_list").dialog('open');
    }
</script>
<style>
    .condition_manager{
        height:auto;
        display:inline;
        /* float:left; */
    }
</style>
<div id="module-container">
    <div id="ez-wms-edit-dialog" style="display:none;">
        <table class="dialog-module" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <input type="hidden" name="E0" id="E0" value=""/>

            </tbody>
        </table>
    </div>

    <div id="module-table">
        <div class="module-head">
            <span class="module-title">送样列表</span>
        </div>
        <div id="search-module">
            <form id="searchForm" name="searchForm" class="submitReturnFalse">
                <input type="hidden" value="120" id="filterActionId">
                <div class="search-module-condition" style="margin-bottom: 10px;">
                    <span class="searchFilterText" style="width: 120px;">送样单号：</span>
                    <input type="text" name="dso_no" class="input_text keyToSearch" id="txt" placeholder="请输入送样单号">
                </div>
                 <div class="search-module-condition">
                    <span class="searchFilterText">出货时间：</span>
                    <input type="text" name="dateFor" class="input_text datepicker dateFrom" /> 到 <input type="text" name="dateTo" class="input_text datepicker dateFrom" />
                </div>
                <!-- <div class="condition_manager" style="width:320px;">
                    <span class="searchFilterText">出货时间：</span>
                    <input type="text" name="dateFor" id="dateFor" class="datepicker input_text keyToSearch" value="<{$dateBefore}>">
                    <span style="margin-left:5px;margin-right:5px;">到</span>
                    <input type="text" name="dateTo" id="dateTo" class="datepickerTo input_text keyToSearch" value="<{$dateNow}>">
                </div> -->
                &nbsp;&nbsp;
                <div class="search-module-condition">
                    <span class="searchFilterText" style="width: 120px;"></span>
                    <input type="button" value="搜索" class="initBtn otherBtn submitToSearch">
                </div>
            </form>
        </div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module">
            <tr class="table-module-title">
                <td width="2%" class="ec-center"><input type="checkbox" class="checkAll"></td>
                <td width="4%">序号</td>
                <td>送样单</td>
                <td>样品数</td>
                <td>送样时间</td>
                <td>操作</td>
            </tr>
            <tbody id="table-module-list-data"><tr class="table-module-b1"><td colspan="6">请搜索...</td></tr>

            </tbody>
        </table>
    </div>
    <div class="pagination"></div>
    <div class="to_top_div" data-show="false"><span style="float: left;cursor: pointer;padding: 0px 2px;" title="返回顶部" class="iconToTop" onclick="toTop();"></span><span style="float: left;cursor: pointer;padding: 0px 2px;" title="前往底部" class="iconToBottom" onclick="toBottom();"></span>
    </div>
    <!-- 送样单列表 -->
    <div id="deliver_list" title="送样单列表" style="display: none; clear: both">
        <div>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module">
                <tbody id="detail_data_dos"><tr class="table-module-b1"></tr>

                </tbody>
            </table>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module">
                <tr class="table-module-title">
                    <td width="4%">序号</td>
                    <td>样品编号</td>
                    <td>产品名称</td>
                    <td>规格尺寸</td>
                    <td>颜色</td>
                    <td>价格</td>
                    <td>数量</td>
                </tr>
                <tbody id="detail_data_sapmles"><tr class="table-module-b1"></tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
