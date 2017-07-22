<link href="/css/order/order_index.css?20170517" rel="stylesheet" />
<script type="text/javascript">
    EZ.url = '/product/Offer/';
    EZ.getListData = function (json) {
        console.log(json);
        var html = '';
        $('.checkAll').attr('checked',false);
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html +="<input type='hidden' class='uteId' value='"+val.E12+"'>";
            html +=" <td class='ec-center'><input type='checkbox' class='checkItem' name='orderId[]'  ref_id='"+val.E0+"' value='"+val.E0+"'></td>";
            html += "<td class='ec-center'>" + (i++) + "</td>";
            html += "<td>"+ val.E2 +"</td>";
            html += "<td>"+ val.E3 +"</td>";
            html += "<td>"+ val.E4 +"</td>";
            /*html +="<td>";
             html +="<select class='operation-select' >";
             html +="<option value='0'>操作</option>";
             html +="<option do_id='"+val.E0+"'value='1'>编辑</option> ";
             html += "<option do_url='" + val.E13 + "'value='2'>删除</option> ";
             html +="</select></td>";*/
            html += "<td><a href=\"javascript:editById(" + val.E0 + ")\">" + EZ.edit + "</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"javascript:deleteById(" + val.E0 + ")\">" + EZ.del + "</a></td>";
            html += "</tr>";
        });

        return html;
    }
</script>
<style type="text/css">
    .boundBtn {
        float: right;
        margin: 28px 25px 0 0;
    }
    .pack_manager {
        height: 30px;
        line-height: 16px;
    }
    .search-module-condition {
        padding-bottom: 10px;
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

    <div id="search-module">
        <form id="searchForm" name="searchForm" class="submitReturnFalse">
            <div style="padding:0">
                <div class="search-module-condition">
                    <span class="searchFilterText" >订单编号：</span>
                    <input type="text" name="E2" id="E2" class="input_text keyToSearch" placeholder="请输入订单编号">
                </div>
                <div class="searchFilterText">产品状态：</div>
                <div class="pack_manager">
                    <input id="E14" class="input_text keyToSearch" name="E14" value="" type="hidden">
                    <a class="nt-code current" href="javascript:void(0)" onclick="searchFilterSubmit('E14', '', this)">全部</a>
                    <{foreach from=$statusTypes item=val key=key}>
                    <a class="nt-code <{if $val == $statusTypes}>current<{/if}>" href="javascript:void(0)" onclick="searchFilterSubmit('E14', '<{$key}>', this)">
                        <{$val}>
                    </a>
                    <{/foreach}>

                </div>
                <div class="searchFilterText">参与情况：</div>
                <div class="pack_manager">
                    <input id="E14" class="input_text keyToSearch" name="E14" value="" type="hidden">
                    <a class="nt-code current" href="javascript:void(0)" onclick="searchFilterSubmit('E14', '', this)">全部</a>
                    <{foreach from=$offerStatus item=val key=key}>
                    <a class="nt-code <{if $val == $offerStatus}>current<{/if}>" href="javascript:void(0)" onclick="searchFilterSubmit('E14', '<{$key}>', this)">
                        <{$val}>
                    </a>
                    <{/foreach}>
                </div>
                <div class="search-module-condition">
                    <span class="searchFilterText">&nbsp;</span>
                    <input type="button" value="<{t}>搜索<{/t}>" class="baseBtn submitToSearch"/>
                </div>
            </div>
        </form>
    </div>
    <div id="module-table">
        <div class="module-head">
            <span class="module-title">报盘列表</span>
           <!-- <div class="order-btn-div">
                <button type="button" class="initBtn boundBtn" id="confirm_order">批量反馈</button>
            </div>-->
        </div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module" style="text-align: center;">
            <tr class="table-module-title">
                <td width="2%" class="ec-center"><input type="checkbox" class="checkAll"></td>
                <td width="3%" class="ec-center">NO.</td>
                <td class="ec-center">订单编号</td>
                <td class="ec-center">采购方</td>
                <td class="ec-center">产品名称</td>
                <td class="ec-center">规格尺寸</td>
                <td class="ec-center">颜色</td>
                <td class="ec-center">通知打样时间</td>
                <td class="ec-center">状态</td>
                <td class="ec-center">报价时间</td>
                <td class="ec-center">参考链接</td>
                <td class="ec-center">参与情况</td>
               <td class="ec-center"><{t}>操作<{/t}></td>
            </tr>
            <tbody id="table-module-list-data"></tbody>
        </table>
    </div>
    <div class="pagination"></div>
</div>
