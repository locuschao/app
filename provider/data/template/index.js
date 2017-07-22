/**
 *@EzWms
 */
var paginationTotal = 10;
function submitSearch() {
    initData(0);
}
function loadData(page, pageSize) {
    var formVal = $("#searchForm").serializeArray();
    $.ajax({
        type: "POST",
        async: false,
        dataType: "json",
        url: "/TTTTTT/MMMMMMM/list/page/" + page + "/pageSize/" + pageSize,
        data: formVal,
        success: function (json) {
            var html = "";
            paginationTotal = json.count;
            var i = page < 1 || page < 0 ? 1 : pageSize * (page - 1) + 1;
            if (json.ask == '1') {
                $.each(json.data, function (key, val) {
                    html += (key + 1) % 2 == 1 ? "<tr>" : "<tr class='even-tr'>";
                    html += "<td >" + (i++) + "</td>";
                    /*EZDATALIST*/
                    html += "<td class=\"center\"><a href=\"javascript:editById(" + val.PRI + ")\">编辑</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"javascript:deleteById(" + val.PRI + ")\">删除</a></td>";
                    html += "</tr>";
                });
                $("#listData").html(html);
            } else {
                $("#listData").EzWmsSetSearchData({ask:1});
            }
        }
    });
}

//Del
function deleteById(id) {
    if (id == '' || id == undefined) {
        return false;
    }
    $.EzWmsDel(
        {paramId: id,
            Field: "paramId",
            url: "/TTTTTT/MMMMMMM/delete"
        }, submitSearch
    );
}

//Edit
function editById(id) {
    var options={
        paramId:id,
        url: "/TTTTTT/MMMMMMM/get-by-json",
        editUrl: "/TTTTTT/MMMMMMM/edit"
    }
    $("#EZTABLENAME_edit").EzWmsEditDataDialog(options);
}

//init
$(function () {
    $("#listData").EzWmsSetSearchData();
    $("#createButton").click(function () {
        var options={
            editUrl: "/TTTTTT/MMMMMMM/edit"
        }
        $("#EZTABLENAME_edit").EzWmsEditDataDialog(options);
    });
});