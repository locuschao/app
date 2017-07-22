<script type="text/javascript">
    EZ.url='/TTTTTT/MMMMMMM/';
    EZ.getListData  = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1  ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr>" : "<tr class='even-tr'>";
            html += "<td >" + (i++) + "</td>";
            /*EZDATALIST*/
            html += "<td class=\"center\"><a href=\"javascript:editById(" + val.PRI + ")\">" + EZ.edit + "</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"javascript:deleteById(" + val.PRI + ")\">" + EZ.del + "</a></td>";
            html += "</tr>";
        });
        return html;
    }
</script>
<div id="ez-wms-edit-dialog" style="display:none;">
    <table class="dialog-module" border="0" cellpadding="0" cellspacing="0">
        <tbody>
        <input type="hidden" name="PRI" id="PRI" value=""/>
        /*EZTBODYCON*/
        </tbody>
    </table>
</div>

<div class="search-module" id="search-module">
    <div class="module-title">
        <form id="searchForm" name="searchForm" class="submitReturnFalse">
            <div style="padding:0">
                /*EZSEARCHINPUT*/

                &nbsp;&nbsp;<input type="button"  value="<{t}>search<{/t}>" class="publicBtn submitToSearch"/>
                <input type="button" id="createButton" value="<{t}>create<{/t}>" class="publicBtn"/>

            </div>
        </form>
    </div>
</div>
<div id="module-container">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-module">
    <thead>
    <tr>
        <th width="26">NO.</th>
        /*EZTHEADTH*/
        <th><{t}>action<{/t}></th>
    </tr>
    </thead>
    <tbody id="listData"></tbody>
</table>
</div>
<div class="pagination"></div>
