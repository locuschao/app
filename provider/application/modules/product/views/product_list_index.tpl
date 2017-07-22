<script type="text/javascript">
    EZ.url = '/product/product/';
    EZ.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html +=" <td class='ec-center'><input type='checkbox' class='checkItem' name='orderId[]'  ref_id='"+val.E0+"' value='"+val.E0+"'></td>";
            html += "<td>" + (i++) + "</td>";
            if(val.E17==null){
                html += "<td></td>";
            }else{
                html +="<td><a href='"+val.E17+"'><img src='"+val.E17+"' alt='' width='50' height='50'></a></td>";
            }
            html +=" <td>"+val.E3+"</td>";
            html +=" <td>"+val.E4+"</td>";
            switch (val.E6){
                case '1' :
                    html += "<td>正常销售</td>";
                    break;
                case '2' :
                    html += "<td>缺货</td>";
                    break;
                case '3' :
                    html += "<td>停产</td>";
                    break;
                default :
                    html += "<td></td>"
            }
            html +=" <td>"+val.E7+"</td>";
            html +=" <td>"+val.E8+"</td>";
            html +=" <td>"+'长：' + val.E9 +val.E12+"<br>";
            html += "宽：" + val.E10+val.E12+"<br>";
            html += "高：" + val.E11 +val.E12;
            html += "</td>"

            html +=" <td>"+val.E13+val.E14+"</td>";
            html +=" <td>"+val.E2+"</td>";
            html +=" <td>"+val.E15+val.E16+"</td>";
            html +="<td>";
            html +="<select class='operation-select' >";
            html +="<option value='0'>操作</option>";
            html +="<option product_id='"+val.E0+"'value='1'>历史报价</option> ";
            html +="</select></td>";
            html += "</tr>";
        });
        return html;


    }

    //操作点击事件
    $('body').on('change', '.operation-select', function() {
        var self = $(this),
            type = self.val();
        switch(type) {
            case '1':
                var productId = self.find("option:selected").attr("product_id");
                showHistoryDetail(productId);
                break;
            default:
                break;
        }
        self.val(0);
    })

    //全选
    $(function(){
        $(".checkAll").live('click', function() {
            $(".checkItem").attr('checked', $(this).is(':checked'));
        });
    });

    // 查看历史报价
    $(function(){

        $("#dialogBaoguanDetail").dialog({
            autoOpen: false,
            modal: true,
            width: 1100,
            height: 250,
            show: "slide",
            title:'查看历史报价',
            buttons: {
                'Cancel(取消)': function () {
                    $(this).dialog('close');
                }
            },
            close: function () {
                $(this).dialog('close');
            }
        });
    });

    // 查看查看历史报价数据
    function showHistoryDetail(productId){
        $("#dialogBaoguanDetail").dialog('open');
        $.ajax({
            type:'POST',
            url:'/product/product/get-decale-detail',
            dataType:'json',
            data: {'product_id':productId},
            async:false,
            success:function(json){

                var html='';
                var datas ='';
                var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
                if(json.state==1) {
                    html += "<table width='100%' id='tables' border='0' cellpadding='0' cellspacing='0'>";
                    html += "<tr height='35'>";
                    html += " <td><span>供应商:&nbsp;&nbsp;&nbsp;<button  style=\"background-color: #2D8AC9; border-radius: 3px;\">全部&nbsp;&nbsp;&nbsp;</button></span> <span>"+json.data[0].ute_erp_name+"</span></td>";
                    html += "</table>";
                    $.each(json.data,function(key,val){
                        datas += (i + 1) % 2 == 1 ? "<tr class='table-module-b2'>" : "<tr class='table-module-b1'>";
                        datas += "<td>" +(i++) + "</td>";
                        datas += "<td>" +val.ute_erp_name + "</td>";
                        datas += "<td>" +val.product_sku + "</td>";
                        datas += "<td>" +val.pq_unit_price + "</td>";
                        datas += "<td>" +val.pq_latest_transaction_price + "</td>";
                        datas += "<td>" +val.pq_price_unit + "</td>";
                        datas += "<td>" +val.pq_purchase_lower_limit + "</td>";
                        datas += "<td>" +val.pq_ship_date + "</td>";
                        datas += "<td>" +val.pq_update_time + "</td>";
                        datas += "</tr>";
                        $("#deliveryData").html(datas);

                    });
                    $("#delviry").html(html);

                }
            }
        });
    }

</script>

<style type="text/css">
    .boundBtn {
        float: right;
        margin: 28px 25px 0 0;
    }
    .boundBtns {
        float: right;
        margin: 28px 55px 0 0;
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

    <form id="exportForm" action="" style="display: none;" method="POST"></form>
    <div id="module-table">
        <div class="module-head">
            <span class="module-title">产品列表</span>
        </div>
        <div id="search-module">
            <form id="searchForm" name="searchForm" class="submitReturnFalse">
                <div style="padding:0">
                    <div class="notice-type-div">
                        <div class="searchFilterText">产品状态：</div>
                        <div class="pack_manager">
                            <input id="product_status" class="input_text keyToSearch" name="product_status" value="" type="hidden">
                            <a class="nt-code current" href="javascript:void(0)" onclick="searchFilterSubmit('product_status', '', this)">全部</a>
                            <{foreach from=$biddingStatus item=val key=key}>
                            <a class="nt-code <{if $val == $biddingStatus}>current<{/if}>" href="javascript:void(0)" onclick="searchFilterSubmit('product_status', '<{$key}>', this)">
                                <{$val}>
                            </a>
                            <{/foreach}>
                        </div>
                    </div>
                    <div class="search-module-condition">
                        <span class="searchFilterText" >采购商：</span>
                        <input type="text" name="ute_erp_name" id="ute_erp_name" class="input_text keyToSearch" placeholder="请输入采购商">
                    </div>
                    <div class="search-module-condition">
                        <span class="searchFilterText" >SKU：</span>
                        <input type="text" name="product_sku" id="product_sku" class="input_text keyToSearch" placeholder="请输入SKU">
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
                <td width="5%">序号</td>
                <td width="12%">图片</td>
                <td width="10%">SKU</td>
                <td width="12%">产品名称</td>
                <td width="10%">产品状态</td>
                <td width="10%">款式</td>
                <td width="7%">颜色</td>
                <td width="12%">尺寸</td>
                <td width="10%">重量</td>
                <td width="10%">采购商</td>
                <td width="11%">价格</td>
                <td width="10%">操作</td>
            </tr>
            <form id="listForm" method="POST" action=""></form>

            <tbody id="table-module-list-data"><tr class="table-module-b1"><td colspan="13">请搜索...</td></tr>

            </tbody>
        </table>
    </div>
    <div class="pagination"></div>
    <div class="to_top_div" data-show="false"><span style="float: left;cursor: pointer;padding: 0px 2px;" title="返回顶部" class="iconToTop" onclick="toTop();"></span><span style="float: left;cursor: pointer;padding: 0px 2px;" title="前往底部" class="iconToBottom" onclick="toBottom();"></span>
    </div>

</div>

<!-- 查看历史报价  -->
<div id="dialogBaoguanDetail">
    <div id="delviry" style="margin-bottom: 15px;">
    </div>
    <table class="table_history_baoguan_details" width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module">

        <tr class="table_baoguan_details_title" style="background-color: #D4E5F6; height: 35px;">
            <td>NO</td>
            <td>供应商</td>
            <td>产品代码</td>
            <td>单价</td>
            <td>最新交易</td>
            <td>币种</td>
            <td>最低采购数量</td>
            <td>交期</td>
            <td>更新时间</td>
        </tr>
        <tbody id="deliveryData"></tbody>
    </table>
</div>
