<script type="text/javascript">
    EZ.url = '/order/Exceptionsoperation/';
    EZ.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html +="<input type='hidden' class='uteId' value='"+val.E12+"'>";
            html +=" <td class='ec-center'><input type='checkbox' class='checkItem' name='orderId[]'  ref_id='"+val.E0+"' value='"+val.E0+"'></td>";
            html += "<td class='ec-center'>" + (i++) + "</td>";
            html +=" <td>"+val.E1+"</td>";
            html +=" <td>"+val.E3+"</td>";
            html +=" <td>"+val.E2+"</td>";
            html +=" <td>"+val.E4+"</td>";
            switch(val.E5) {
                case '1':
                    html += '<td>现付</td>';
                    break;
                case '2':
                    html += '<td>到付</td>';
                    break;
                default :
                    html += '<td></td>';
                    break;
            }
            html +=" <td>"+val.E6+val.E7+"</td>";
            html +=" <td>"+val.E8+val.E9+"</td>";
            html +=" <td>"+val.E10+"</td>";
            html +="<td>";
            html +="<select class='operation-select' >";
            html +="<option value='0'>操作</option>";
            html +="<option doeol_id='"+val.E0+"'value='1'>查看详情</option> ";
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
                var doeol_id = self.find("option:selected").attr("doeol_id");
                showDeliveryDetail(doeol_id);
                break;
            case '2':
                var do_url = self.find("option:selected").attr("do_url");
                var curWwwPath = window.document.location.href;
                var pathName = window.document.location.pathname;
                var pos = curWwwPath.indexOf(pathName);
                var localhostPaht = curWwwPath.substring(0, pos);
                var url=localhostPaht+do_url;
                window.open(url);
                break;
            default:
                break;
        }
        self.val(0);
    })
    // 弹框查退货单详情
    $(function(){
        $("#tuihuo-dialog").dialog({
            autoOpen: false,
            modal: true,
            width: 850,
            height: 650,
            show: "slide",
            title:'查看退货单详情',
            buttons: [{
                text: "确认",
                click: function () {
                    $("#tuihuo-dialog").dialog('close');
                }
            },
                {
                    text: "取消",
                    click: function () {
                        $("#tuihuo-dialog").dialog('close');
                    }
                }
            ], close: function () {
                $(this).dialog('close');
            }
        });
    });
    function showDeliveryDetail(id){
        $.ajax({
            type:'POST',
            url:'/order/exceptionsoperation/tui-huo-detail',
            dataType:'json',
            data: {'id':id},
            async:false,
            success:function(json) {
                console.log(json);
                var html = '';
                html += "<form id='DataForm' name='DataForm' class='submitReturnFalse'>";
                html += "<input type='hidden' name='oeol_id' value='"+json.data.oeol_id+"' id='oeol_id'>";
                html += "<div class='order-details'>";
                html += "<table class='order-details-table' style='width: 750px;height: 150px;margin: 0px auto;text-align: center;'>";
                html += "<tbody><tr >";
                html += "<td>采购单号</td>";
                html += "<td>产品编码</td>";
                html += " <td>产品图片</td>";
                html += "<td>产品名称</td>";
                html += " <td>退货数量</td>";
                html += "</tr>";
                html += "<tr>";
                html += "<td>"+json.data.oeol_return_no+"</td>";
                html += "<td>"+json.data.oi_sku+"</td>";
                html += "<td></td>";
                html += "<td>"+json.data.oi_name+"</td>";
                html += "<td>"+json.data.oeol_return_amount+"</td>";
                html += "</tr>";
                html += "</tbody></table></div> <hr>";
                html += "<div class='item-details' style='text-align: center;border: 1px solid #000;width:515px;margin: 20px auto;'>";
                html += " <table width='100%' border='0' class='table_order_details' style='text-align: center;'>";
                html += " <tbody><tr >";
                html += " <td>退货单号</td>";
                html += " <td ><input type='text' id='returnNo' name='oeol_return_no' value='"+json.data.oeol_return_no+"'></td>";
                html += "  <td>创建时间</td>";
                html += " <td ><input type='text' id='oe_create_time' name='oe_create_time' value='"+json.data.oeol_create_time+" '></td>";
                html += "</tr><tr >";
                html += "  <td>退货总数量</td>";
                html += " <td ><input type='text' id='oeol_return_amount' name='oeol_return_amount' value='"+json.data.oeol_return_amount+" '></td>";
                html += "  <td>总重量</td>";
                html += " <td ><input type='text' id='oeol_weight' name='oeol_weight' value='"+json.data.oeol_weight+json.data.oeol_weight_unit+"' ></td>";
                html += " </tr><tr >";
                html += "<td>快递公司</td>";
                html += "<td> <select name='oeol_ship_company'  style='height: 29px; width: 153px;'>";
                switch (json.data.oeol_ship_company){
                    case '顺丰快递':
                        html +="<option value='1' selected='selected'>顺丰快递</option>";
                        break;
                    case '圆通快递':
                        html +="<option value='2' selected='selected'>圆通快递</option>";
                        break;
                }
                html += "<td>快递单号</td><td ><input type='text' id='oeol_ship_no' name='oeol_ship_no' value='"+json.data.oeol_ship_no+"' ></td>";
                html += "</tr><tr ><td>支付方式</td>";
                html += "<td><select name='oeol_pay_way' style='height: 29px; width: 153px;'>";
                switch(json.data.oeol_pay_way)
                {
                    case "1":
                    html+="<option value='1'>现付</option>";
                            break;
                    case "2":
                    html+="<option value='2'>到付</option>";
                        break;
                }
                 html +="</select></td>";
                html += "<td>运费</td><td><input type='text' name='oeol_ship_fee' id='oeol_ship_fee' value='"+json.data.oeol_ship_fee+json.data.oeol_ship_fee_unit+"'></td>";
                html += "</tr></tbody></table></div></form>";
                $("#tuihuo-dialog").html(html);
                $("#tuihuo-dialog").dialog('open');
            }
        });
    }
</script>
<style type="text/css">
    .boundBtn {
        float: right;
        margin: 28px 25px 0 0;
    }
    .table_order_details td{
        border: 1px solid #000;
        height: 45px;
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

    <div id="print-edit-dialog" style="display:none;">
        <span>请选择您所需的打印方式！</span>
    </div>

    <div id="module-table">
        <div class="module-head">
            <span class="module-title">异常管理操作列表</span>
        </div>
        <div id="search-module">
            <form id="searchForm" name="searchForm" class="submitReturnFalse">
                <div style="padding:0">
                    <div class="notice-type-div">
                        <div class="searchFilterText">产品状态：</div>
                        <div class="pack_manager">
                            <input id="E14" class="input_text keyToSearch" name="E14" value="" type="hidden">
                            <a class="nt-code current" href="javascript:void(0)" onclick="searchFilterSubmit('E14', '', this)">全部</a>
                            <{foreach from=$statusTypes item=val key=key}>
                            <a class="nt-code <{if $val == $statusTypes}>current<{/if}>" href="javascript:void(0)" onclick="searchFilterSubmit('E7', '<{$key}>', this)">
                                <{$val}>
                            </a>
                            <{/foreach}>
                        </div>
                    </div>

                    <div class="search-module-condition">
                        <span class="searchFilterText" >订单号：</span>
                        <input type="text" name="E1" id="E1" class="input_text keyToSearch" placeholder="请输入订单号">
                    </div>
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
                <td  class="ec-center">退货单号</td>
                <td  class="ec-center">快递单号</td>
                <td  class="ec-center">快递公司</td>
                <td class="ec-center">退货总数量</td>
                <td class="ec-center">支付方式</td>
                <td class="ec-center">运费</td>
                <td class="ec-center">重量</td>
                <td class="ec-center">创建时间</td>
                <td class="ec-center"><{t}>操作<{/t}></td>
            </tr>
            <tbody id="table-module-list-data"></tbody>
        </table>
    </div>
    <div class="pagination"></div>
</div>
<!-- 退货处理详情  -->
<div style="display:none" id="tuihuo-dialog" title="退货单" >
</div>
