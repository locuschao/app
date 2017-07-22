<script type="text/javascript">
    EZ.url='/admin/index/';
    EZ.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 || paginationCurrentPage < 0 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr>" : "<tr class='even-tr'>";
            html += "<td >" + (i++) + "</td>";
            
                    html += "<td >" + val.EZ1 + "</td>";
                    html += "<td >" + val.EZ2 + "</td>";
                    html += "<td >" + val.EZ3 + "</td>";
                    html += "<td >" + val.EZ4 + "</td>";
                    html += "<td >" + val.EZ6 + "</td>";
            html += "<td class=\"center\"><a href=\"javascript:editById(" + val.EZ0 + ")\">" + EZ.editTitle + "</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"javascript:deleteById(" + val.EZ0 + ")\">" + EZ.delTitle + "</a></td>";
            html += "</tr>";
        });
        return html;
    }
</script>
<div id="ez-wms-edit-dialog" style="display:none;">
    <table class="dialog-module" border="0" cellpadding="0" cellspacing="0">
        <tbody>
        <input type="hidden" name="EZ0" id="EZ0" value=""/>
        
        <tr>
            <td class="dialog-module-title">上架单:</td>
            <td><input type="text" name="EZ1" id="EZ1" class="input_text" tagName='' validator="required"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">类型:</td>
            <td><input type="text" name="EZ2" id="EZ2" class="input_text" tagName='' validator="required"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">ASN:</td>
            <td><input type="text" name="EZ3" id="EZ3" class="input_text"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">仓库:</td>
            <td><input type="text" name="EZ4" id="EZ4" class="input_text"/></td>
        </tr>
        </tbody>
    </table>
</div>

<div class="search-module" id="search-module">
    <div class="module-title">
        <form id="searchForm" name="searchForm" class="submitReturnFalse">
            <div style="padding:0">
                
       上架单：<input type="text" name="EZ1" id="EZ1" class="input_text keyToSearch"/>
       类型：<input type="text" name="EZ2" id="EZ2" class="input_text keyToSearch"/>
       ASN：<input type="text" name="EZ3" id="EZ3" class="input_text keyToSearch"/>

                &nbsp;&nbsp;<input type="button"  value="搜索" class="publicBtn submitToSearch"/>
                <input type="button" id="createButton" value="添加" class="publicBtn"/>

            </div>
        </form>
    </div>
</div>
<div id="getData-module">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-module">
    <thead>
    <tr>
        <th width="26">NO.</th>
        
       <th>上架单</th>
       <th>类型</th>
       <th>送货单号</th>
       <th>仓库</th>
       <th>货架</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody id="listData"></tbody>
</table>
</div>
<div class="pagination"></div>
