<script>

    //导出订单
    function export_sale_report(){
        var string='';
        var data='';
        if( $(".checkItem:checked").size()>0){

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
                if($(this).html() != ''){
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
            var url="/report/sale-report/execute-export?";
            window.location = url+data;
        }
    }

    $(".checkAll").live('click', function() {
        $(".checkItem").attr('checked', $(this).is(':checked'));
    });

</script>
<style type="text/css">
    .boundBtn {
        float: right;
        margin: 10px 5px 0 0;
        font-size: 14px;
    }
</style>
<div id="module-container">
    <form id="exportForm" action="/report/sale-report/execute-export" style="display: none;" method="POST"></form>

    <div id="module-table">
        <div class="module-head">
            <span class="module-title">销售报表列表</span>
            <button id="import" class="initBtn otherBtn boundBtn" style="width: 100px;" onclick="export_sale_report()">批量导出</button>
        </div>
        <div id="search-module" style="">
            <form id="searchForm" name="searchForm" class="submitReturnFalse">
                <div style="padding:0">
                    <div class="search-module-condition">
                        <span class="searchFilterText" style="width: 100px;">采购商：</span>
                        <!--<input type="text" name="E2" class="input_text2 keyToSearch" id="txt" placeholder="请输入采购商">-->
                        <input type="text" name="sr_from" class="input_text2 keyToSearch" id="txt" placeholder="请输入采购商">
                    </div>
                    <div class="search-module-condition">
                        <span class="searchFilterText">时间：</span>
                        <input type="text" name="startTime" class="input_text datepicker dateFrom" /> 到 <input type="text" name="endTime" class="input_text datepicker dateFrom" />
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
                <td width="4%" class="ec-center">NO.</td>
                <td class="ec-center">产品代码</td>
                <td class="ec-center">采购商</td>
                <td class="ec-center">平台</td>
                <!-- <td class="ec-center">国家</td>
                <td class="ec-center">品类</td> -->
                <td class="ec-center">成交量</td>
                <td class="ec-center">销售额（￥）</td>
                <td class="ec-center" style="width:120px;">采购成本（￥）</td>
                <td class="ec-center">成交费（￥）</td>
                <!-- <td class="ec-center">销售趋势</td>
                <td class="ec-center">销售增长率</td> -->
                <td class="ec-center" style="width:120px;">物流费用（￥）</td>
                <td class="ec-center">手续费（￥）</td>
                <td class="ec-center">更新时间</td>
                <!-- <td class="ec-center" style="width:120px;">服务商派送费用（￥）</td> -->
                <!-- <td class="ec-center">3天平均销量</td>
                <td class="ec-center">7天平均销量</td>
                <td class="ec-center">14天平均销量</td>
                <td class="ec-center">30天平均销量</td>
                <td class="ec-center">本期销量</td>
                <td class="ec-center">上期销量</td>
                <td class="ec-center">上两期销量</td>
                <td class="ec-center">上三期销量</td>
                <td class="ec-center" style="width:120px;">本期售价（￥）</td>
                <td class="ec-center" style="width:120px;">上期售价（￥）</td>
                <td class="ec-center" style="width:120px;">上两期售价（￥）</td>
                <td class="ec-center" style="width:120px;">上三期售价（￥）</td> -->
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

<script type="text/javascript" src="/js/jquery-ui-timepicker-addon.js" ></script>
<script type="text/javascript" src="/js/moment.js"></script>
<script type="text/javascript" src="/js/modules/report/salereport.js"></script>
<script type="text/javascript">
    $(function () {
        var saleReport = new SaleReport();
        saleReport.init();
    })
</script>
