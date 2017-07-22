<script type="text/javascript">
    EZ.url = '/msg/notice-bussiness-list-user/';
    EZ.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html += "<td class='ec-center'>" + (i++) + "</td>";
            
                    html += "<td>" + val.E2 + "</td>";
                    html += "<td>" + val.E3 + "</td>";
                    html += "<td>" + val.E4 + "</td>";
                    html += "<td>" + val.E5 + "</td>";
                    html += "<td>" + val.E6 + "</td>";
                    html += "<td>" + val.E7 + "</td>";
            html += "<td><a href=\"javascript:editById(" + val.E0 + ")\">" + EZ.edit + "</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"javascript:deleteById(" + val.E0 + ")\">" + EZ.del + "</a></td>";
            html += "</tr>";
        });
        return html;
    }
</script>
<div id="module-container">
    <div id="ez-wms-edit-dialog" style="display:none;">
        <table class="dialog-module" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <input type="hidden" name="E0" id="E0" value=""/>
            
        <tr>
            <td class="dialog-module-title">通知用户ID:</td>
            <td><input type="text" name="E2" id="E2"   class="input_text"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">通知用户分组ID:</td>
            <td><input type="text" name="E3" id="E3"   class="input_text"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">通知抄送用户ID:</td>
            <td><input type="text" name="E4" id="E4"   class="input_text"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">通知抄送用户分组ID:</td>
            <td><input type="text" name="E5" id="E5"   class="input_text"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">创建时间:</td>
            <td><input type="text" name="E6" id="E6"   class="input_text"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">修改时间:</td>
            <td><input type="text" name="E7" id="E7"   class="input_text"/></td>
        </tr>
            </tbody>
        </table>
    </div>

    <div id="search-module">
        <form id="searchForm" name="searchForm" class="submitReturnFalse">
            <div style="padding:0">
                
                &nbsp;&nbsp;<input type="button" value="<{t}>search<{/t}>" class="baseBtn submitToSearch"/>
                <input type="button" id="createButton" value="<{t}>create<{/t}>" class="baseBtn"/>
            </div>
        </form>
    </div>

    <div id="module-table">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module">
            <tr class="table-module-title">
                <td width="3%" class="ec-center">NO.</td>
                
       <td>通知用户ID</td>
       <td>通知用户分组ID</td>
       <td>通知抄送用户ID</td>
       <td>通知抄送用户分组ID</td>
       <td>创建时间</td>
       <td>修改时间</td>
                <td><{t}>operate<{/t}></td>
            </tr>
            <tbody id="table-module-list-data"></tbody>
        </table>
    </div>
    <div class="pagination"></div>
</div>
