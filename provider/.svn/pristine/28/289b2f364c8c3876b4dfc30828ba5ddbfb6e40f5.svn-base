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
            <span class="module-title">合同管理</span>
        </div>
        <div id="search-module">
            <form id="searchForm" name="searchForm" class="submitReturnFalse">
                <div style="padding:0">
                    <div class="notice-type-div">
                        <div class="searchFilterText">合同状态：</div>
                        <div class="pack_manager">
                            <input id="E10" class="input_text keyToSearch" name="E7" value="" type="hidden">
                            <a class="nt-code current" href="javascript:void(0)" onclick="searchFilterSubmit('E7', '', this)">全部</a>
                            <{foreach from=$contractStatus item=val key=key}>
                            <a class="nt-code <{if $val == $contractStatus}>current<{/if}>" href="javascript:void(0)" onclick="searchFilterSubmit('E7', '<{$key}>', this)">
                                <{$val}>
                            </a>
                            <{/foreach}>
                        </div>
                    </div>

                    <div class="search-module-condition">
                        <span class="searchFilterText" >采购商：</span>
                        <input type="text" name="E2" id="E2" class="input_text keyToSearch" placeholder="请输入采购商">
                    </div>

                    <div class="search-module-condition">
                        <span class="searchFilterText" >采购单：</span>
                        <input type="text" name="EF1" id="EF1" class="input_text keyToSearch" placeholder="请输入采购单">
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
                <td width="4%" class="ec-center">NO.</td>
                <td>订单编号</td>
                <td>总金额</td>
                <td>仓库</td>
                <td>合同下载时间</td>
                <td>订单状态</td>
                <td>合同状态</td>
                <td>采购商</td>
            </tr>
            <tbody id="table-module-list-data"></tbody>
        </table>
    </div>
    <div class="pagination"></div>
</div>

<script type="text/javascript" src="/js/moment.js"></script>
<script type="text/javascript">
    EZ.url = '/order/contract-logs/';
    EZ.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html += "<td class='ec-center'>" + (i++) + "</td>";
            html += "<td>" + val.EF1 + "</td>";
            html += "<td>" + val.EF2 + " (" + val.EF3 + ")" + "</td>";

            html += "<td>";
            html += "<span>" + val.E4 + "</span><br>";
            html += "<span>" + val.E5 + "</span>";
            html += "</td>";

            html += "<td>" + ((val.E6 == '0000-00-00 00:00:00')? '' : moment(val.E6).format('YYYY-MM-DD HH:mm')) + "</td>";
            switch(val.EF4) {
                case '1':
                    html += '<td>待确认</td>';
                    break;
                case '2':
                    html += '<td>已确认</td>';
                    break;
                case '3':
                    html += '<td>已取消</td>';
                    break;
                default :
                    html += '<td></td>';
                    break;
            }
            switch(val.E7) {
                case '1':
                    html += '<td>已打印</td>';
                    break;
                case '2':
                    html += '<td>已下载</td>';
                    break;
                default :
                    html += '<td></td>';
                    break;
            }
            html += "<td>" + val.E2 + "</td>";
            html += "</tr>";
        });
        return html;
    }
</script>