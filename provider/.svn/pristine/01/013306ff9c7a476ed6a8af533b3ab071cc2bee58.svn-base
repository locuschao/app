<script type="text/javascript" src="/js/jquery-ui-timepicker-addon.js" ></script>
<script type="text/javascript">
    EZ.url = '/report/Stockreport/';
    EZ.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {

            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html += "<td class='ec-center'><input type='checkbox' class='checkItem' name='orderId[]' ref_id='"+val.E0+"' value='" + val.E0 + "'/></td>";
            html += "<td class='ec-center'>" + (i++) + "</td>";
            html +="<td>"+val.E4+"</td>";
            html +="<td>"+val.E6+"</td>";
            html +="<td>"+val.E7+"</td>";
            html +="<td>"+val.E17+val.E21+"</td>";
            html +="<td>"+val.E8+val.E21+"</td>";
            /*html +="<td>"+val.E9+val.E21+"</td>";*/
            html +="<td>"+val.E10+val.E21+"</td>";
            /*html +="<td>"+val.E11+val.E21+"</td>";
            html +="<td>"+val.E12+"</td>";
            html +="<td>"+val.E14+"</td>";*/
            html +="<td>"+val.E13+val.E22+"</td>";
            html +="<td>"+val.E18+val.E21+"</td>";
            /*html +="<td>"+val.E19+val.E21+"</td>";
            html +="<td>"+val.E20+val.E21+"</td>";*/
            html +="<td>" + ((val.E15 == '0000-00-00 00:00:00')? '' : moment(val.E15).format('YYYY-MM-DD')) + "</td>";

           /* html += "<td><a href=\"javascript:editById(" + val.E0 + ")\">" + EZ.edit + "</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"javascript:deleteById(" + val.E0 + ")\">" + EZ.del + "</a></td>";*/
            html += "</tr>";
        });
        return html;
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


    //导出订单
    function export_stock_report(){
        var string='';
        var data='';

        if($(".checkItem:checked").size()>0){

            $(".checkItem:checked").each(function(){
                string+=$(this).val()+"-";

            });

            data = '<input type="hidden" name="sr_id_arr" value="'+string+'">';
            alertConfirmTip('确定导出选定的产品?',function(){
                execute_export(data,1);
            });
        }else{
            var no_con=true;
            data=$("#searchForm").serialize();
            $('#search-module :input').not("[type=button]").each(function(){
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
            var url="/report/stockreport/execute-export?";
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
</style>

<div id="module-container">
    <form id="exportForm" action="/report/stockreport/execute-export" style='display: none;' method='POST'></form>
    <div id="module-table">
        <div class="module-head">
            <span class="module-title">商品库存列表</span>
            <button id="import" class="initBtn otherBtn boundBtn" style="width: 100px;" onclick="export_stock_report()">批量导出</button>
        </div>
        <div id="search-module">
            <form id="searchForm" name="searchForm" class="submitReturnFalse">
                <div style="padding:0">
                    <div class="search-module-condition">
                        <span class="searchFilterText" style="width: 100px;">商品SKU号：</span>
                        <input type="text" name="sr_sku" class="input_text keyToSearch" id="txt" placeholder="请输入商品SKU号">
                    </div>

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
                <td>产品代码(SKU号)</td>
                <td>品类</td>
                <td>仓库</td>
                <td>生产中库存</td>
                <td>采购在途库存</td>
                <!-- <td>头程在途库存</td> -->
                <td>可销售库存</td>
                <!-- <td>工厂待发库存</td>
                <td>库存周转率</td>
                <td>滞库天数</td> -->
                <td>库存成本（￥）</td>
                <td>不良品库存</td>
                <!-- <td>历史入库数</td>
                <td>历史出库数</td> -->
                <td>更新时间</td>

            </tr>
            <form id="listForm" method="POST" action=""></form>

            <tbody id="table-module-list-data"><tr class="table-module-b1"><td colspan="11">请搜索...</td></tr>

            </tbody>
        </table>
    </div>
    <div class="pagination"></div>
    <div class="to_top_div" data-show="false"><span style="float: left;cursor: pointer;padding: 0px 2px;" title="返回顶部" class="iconToTop" onclick="toTop();"></span><span style="float: left;cursor: pointer;padding: 0px 2px;" title="前往底部" class="iconToBottom" onclick="toBottom();"></span>
    </div>
</div>


<script type="text/javascript" src="/js/moment.js"></script>
