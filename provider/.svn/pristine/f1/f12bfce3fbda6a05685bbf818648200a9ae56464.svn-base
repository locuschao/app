<link rel="stylesheet" type="text/css" href="/css/msg/notice_business_message.css?201611071736">
<link rel="stylesheet" type="text/css" href="/css/ystep.css?201611071736">
<div id="module-container">
    <div id="ez-wms-edit-dialog" style="display:none;">
        <table class="dialog-module" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <input type="hidden" name="E0" id="E0" value=""/>
            
        <tr>
            <td class="dialog-module-title">业务类型:</td>
            <td><input type="text" name="E2" id="E2"   class="input_text"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">通知应用码:</td>
            <td><input type="text" name="E3" id="E3"   class="input_text"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">状态:</td>
            <td><input type="text" name="E4" id="E4"   class="input_text"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">业务单号:</td>
            <td><input type="text" name="E5" id="E5"   class="input_text"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">当前通知人:</td>
            <td><input type="text" name="E6" id="E6"   class="input_text"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">当前通知分组:</td>
            <td><input type="text" name="E7" id="E7"   class="input_text"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">ERP传入的业务单号:</td>
            <td><input type="text" name="E8" id="E8"   class="input_text"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">参考号:</td>
            <td><input type="text" name="E9" id="E9"   class="input_text"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">创建时间:</td>
            <td><input type="text" name="E10" id="E10"   class="input_text"/></td>
        </tr>
        <tr>
            <td class="dialog-module-title">修改时间:</td>
            <td><input type="text" name="E11" id="E11"   class="input_text"/></td>
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
               <td>业务类型</td>
               <td>通知应用码</td>
               <td>状态</td>
               <td>业务单号</td>
               <td>当前通知人</td>
               <td>当前通知分组</td>
               <td>ERP传入的业务单号</td>
               <td>参考号</td>
               <td>创建时间</td>
               <td>修改时间</td>
                <td><{t}>operate<{/t}></td>
            </tr>
            <tbody id="table-module-list-data"></tbody>
        </table>
    </div>
    <div class="pagination"></div>
</div>

<script type="text/javascript" src="/js/ystep.js?201611071736"></script>
<script type="text/javascript">
    EZ.url = '/msg/notice-bussiness-message/';
    EZ.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html += "<td class='ec-center' onclick='processWindow(" + val.E0 + ")'>" + (i++) + "</td>";
            html += "<td>" + val.E2 + "</td>";
            html += "<td>" + val.E3 + "</td>";
            html += "<td>" + val.E4 + "</td>";
            html += "<td>" + val.E5 + "</td>";
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

    // 节点进度弹窗
    var processWindow = function(nbmId) {
        $.ajax({
            url: '/msg/notice-bussiness-message/get-business-message',
            type: 'POST',
            dataType: 'json',
            data: {E0 : nbmId},
            success: function(json) {
                var tp = [],
                    template = '',
                    flag = 0;

                // 拼接通知人信息
                $.each(json.F1, function(index, item) {
                    var node = {title: '', content: '通知人：'};
                    node.title = item.E3;
                    if (item.E3 == json.E6) {
                        flag = index + 1;
                    }
                    $.each(item.F1, function(i, user) {
                        node.content += user;
                    });
                    tp.push(node);
                })

                // 弹窗
                template += '<div title="通知进度" id="" class="dialog-edit-alert-tip"><p id="process" class="process"></p></div>';
                $(template).dialog({
                    autoOpen: true,
                    width: '850px',
                    maxHeight: '550px',
                    modal: true,
                    show: "slide",
                    buttons: [], close: function () {
                        $(this).detach();
                    }
                });

                // 节点插件
                $('#process').loadStep({
                    size: 'large',
                    color: 'green',
                    steps: tp
                });
                $('#process').setStep(flag);
            },
            statusCode: {
                // 如果你想处理各状态的错误的话
                404: function(){alert('不能访问网络');},
                500: function(){alert('服务器错误');}
            }
        })
    }
</script>
