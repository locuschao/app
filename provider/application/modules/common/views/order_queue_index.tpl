<script type="text/javascript">
    var orderQueueSendStatusJson = <{$orderQueueSendStatusJson}>;
    var orderQueueLogisticsStatusJson = <{$orderQueueLogisticsStatusJson}>;

    EZ.url = '/common/order-queue/';
    EZ.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html += "<td class='ec-center'>" + (i++) + "</td>";
            html += "<td>" + val.E2 + "</td>";
            html += "<td>" + (orderQueueSendStatusJson[val.E3]?orderQueueSendStatusJson[val.E3]:'') + "</td>";
            html += "<td>" + val.E4 + "</td>";

            html += "<td>" + (orderQueueLogisticsStatusJson[val.E5]?orderQueueLogisticsStatusJson[val.E5]:'') + "</td>";
            html += "<td>" + val.E6 + "</td>";
            html += "<td>" + val.E7 + "</td>";
            html += "<td>" + val.E8 + "</td>";
            html += "<td>" + val.E9 + "</td>";

            html += "<td>" + val.E10 + "</td>";
            html += "<td>" + val.E11 + "</td>";
            html += "<td><a href=\"javascript:editById(" + val.E0 + ")\">" + EZ.edit + "</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"javascript:deleteById(" + val.E0 + ")\">" + EZ.del + "</a></td>";
            html += "</tr>";
        });
        return html;
    }
</script>
<style>
    .searchFilterText{
        width:100px;
    }
    .table-module td{
        word-break: break-all;
    }
</style>
<div id="module-container">
    <div id="ez-wms-edit-dialog" style="display:none;">
        <table class="dialog-module" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <input type="hidden" name="E0" id="E0" value=""/>

                <tr>
                    <td class="dialog-module-title">发送状态:</td>

                    <td>
                        <!-- <input type="text" name="E3" id="E3" class="input_text"/>-->

                        <select name="E3" id="E3" class="input_text2">
                            <option value="">全部</option>
                            <{foreach from=$orderQueueSendStatusArr item=val key=key}>
                            <option value="<{$key}>"><{$val}></option>
                            <{/foreach}>
                        </select>

                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <div id="search-module">
        <form id="searchForm" name="searchForm" class="submitReturnFalse">
            <div style="padding:0">
                <div class="search-module-condition">
                    <span class="searchFilterText" style="">发送状态：</span>
                    <select name="E3" id="E3" class="input_text2">
                        <option value="">全部</option>
                        <{foreach from=$orderQueueSendStatusArr item=val key=key}>
                            <option value="<{$key}>"><{$val}></option>
                        <{/foreach}>
                    </select>
                </div>
                <div class="search-module-condition">
                    <span class="searchFilterText" style="">物流是否成功：</span>
                    <select name="E5" id="E5" class="input_text2">
                        <option value="">全部</option>
                        <{foreach from=$orderQueueLogisticsStatusArr item=val key=key}>
                        <option value="<{$key}>"><{$val}></option>
                        <{/foreach}>
                    </select>
                </div>

                <div class="search-module-condition">
                    <span class="searchFilterText" >订单序列：</span>
                    <input type="text" name="E2" id="E2" class="input_text keyToSearch"/>
                </div>

                <div class="search-module-condition">
                    <span class="searchFilterText" >&nbsp;</span>
                    <input type="button" value="<{t}>search<{/t}>" class="baseBtn submitToSearch"/>
                    &nbsp;&nbsp;
                    <input type="button" id="createButton" value="<{t}>create<{/t}>" class="baseBtn"/>
                </div>

            </div>
        </form>
    </div>

    <div id="module-table">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module">
            <tr class="table-module-title">
                <td width="3%" class="ec-center">NO.</td>
                <td>订单序列</td>
                <td>发送状态</td>
                <td>队列组ID</td>

                <td>物流是否成功</td>
                <td>信息</td>
                <td>错误代码</td>
                <td>错误信息</td>
                <td>同步信息</td>

                <td>加入时间</td>
                <td>发送时间</td>
                <td><{t}>operate<{/t}></td>
            </tr>
            <tbody id="table-module-list-data"></tbody>
        </table>
    </div>
    <div class="pagination"></div>
</div>
