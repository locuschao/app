<script type="text/javascript">
    EZ.url = '/user/Usertoerp/';
    EZ.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html += "<td class='ec-center'>" + (i++) + "</td>";
            html += "<td class='ec-center'>" + val.E3 + "</td>";
            html += "<td class='ec-center'>";
            if (val.E4) {
                html += val.E4;
            }else {
                html += '********************************';
            }
            html += "</td>";
            html += "<td class='ec-center'>" + ((val.E7 == '0000-00-00 00:00:00')? '' : moment(val.E7).format('YYYY-MM-DD')) + "</td>";
            html += "<td class='ec-center'>";
            switch(val.E5) {
                case '0':
                    html += "禁用";
                    break;
                case '1':
                    html += "启用";
                    break;
                default:
                    break;
            }
            html += "</td>";
            /*html += "<td class='ec-center'>&nbsp;&nbsp;<a href=\"javascript:deleteById(" + val.E0 + ")\">" + EZ.del + "</a></td>";*/
            html += "</tr>";
        });
        return html;
    }

    $(function() {
        var boundNewErp = function() {
            $('#bound_new_erp').on('click', function() {
                var div = $('#bound_new_erp_dialog');
                $(div).EzWmsEditDataDialog({
                    dWidth: '500px',
                    dHeight: '550px',
                    paramId: 0,
                    dTitle: '绑定ERP',
                    editUrl: '/user/user-to-erp/bound-new-erp'
                });
            })
        }
        boundNewErp();
    })

</script>
<style type="text/css">
    .boundBtn {
        float: right;
        margin: 10px 5px 0 0;
        font-size: 14px;
    }
</style>
<div id="module-container">
    <div id="bound_new_erp_dialog" style="display:none;">
        <table class="dialog-module" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td class="dialog-module-title">用户名:</td>
                    <td>
                        <input type="text" name="user_name" id="user_name" class="input_text" />
                    </td>
                </tr>
                <tr>
                    <td class="dialog-module-title">密码:</td>
                    <td>
                        <input type="password" name="password" id="password" class="input_text" />
                    </td>
                </tr>
                <tr>
                    <td class="dialog-module-title">token:</td>
                    <td>
                        <input type="password" name="token" id="token" class="input_text" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="module-table">
        <div class="module-head">
            <span class="module-title">供应商与ERP关联列表</span>
            <input type="button" value="绑定ERP" id="bound_new_erp" class="initBtn otherBtn boundBtn">
        </div>
        <div id="search-module">
            <form id="searchForm" name="searchForm" class="submitReturnFalse">
                <div style="padding:0">
                    <div class="search-module-condition">
                        <span class="searchFilterText" >ERP用户名：</span>
                        <input type="text" name="ute_erp_name" id="E2" class="input_text keyToSearch" placeholder="请输入ERP用户名">
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
                <td width="6%" class="ec-center">NO.</td>
                <td class="ec-center">ERP用户名</td>
                <td class="ec-center">token</td>
                <td class="ec-center">时间</td>
                <td class="ec-center">状态</td>
                <!-- <td class="ec-center"><{t}>操作<{/t}></td> -->
            </tr>
            <tbody id="table-module-list-data"><tr class="table-module-b1"><td colspan="5">请搜索...</td></tr>

            </tbody>
        </table>
    </div>
    <div class="pagination"></div>
</div>
<script type="text/javascript" src="/js/moment.js"></script>
