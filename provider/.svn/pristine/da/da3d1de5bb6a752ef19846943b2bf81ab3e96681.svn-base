<script type="text/javascript">
    EZ.url = '/message/Message/';
    EZ.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            console.log(val);
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html +=" <td class='ec-center'><input type='checkbox' class='checkItem' name='orderId[]'  ref_id='"+val.E0+"' value='"+val.E0+"'></td>";
            html += "<td class='ec-center'>" + (i++) + "</td>";
            html += "<td class='ec-center'>" + val.E3 + "</td>";
            switch (val.E4){
                case "0":
                    html+= "<td  class='ec-center'>未读</td>";
                    break;
                case "1":
                    html += "<td  class='ec-center'>已读</td>";
                    break;
                default :
                    html += "<td></td>";
                    break;
            }
            switch (val.E2){
                case '1':
                    html +="<td  class='ec-center'>系统消息</td>";
                break;
                case '2':
                    html +="<td  class='ec-center'>ERP消息</td>";
                 break;
                default :
                    html += "<td></td>";
                    break;
            }
            html += "<td class='ec-center'>" + val.E5 + "</td>";
            html +="<td class='ec-center'>";
            html +="<select class='operation-select' >";
            html +="<option value='0'>操作</option>";
            html +="<option message_id='"+val.E0+"'value='1'>详情</option> ";
            html +="</select></td>";
//            html += "<td class='ec-center'><a href=\"javascript:editById(" + val.E0 + ")\">查看公告详情</a></td>";
            html += "</tr>";
        });
        return html;
    };


    //操作点击事件
    $('body').on('change', '.operation-select', function() {
        var self = $(this),
            type = self.val();
        switch(type) {
            case '1':
                var messageId = self.find("option:selected").attr("message_id");
                messageDetail(messageId);
                break;
            default:
                break;
        }
        self.val(0);
    })

    $(function(){
        $(".checkAll").live('click', function() {
            $(".checkItem").attr('checked', $(this).is(':checked'));
        });
    });

    // 查看历史报价
    $(function(){
        $("#messageDetail").dialog({
            autoOpen: false,
            modal: true,
            width: 600,
            height: 200,
            show: "slide",
            title:'消息内容',
            buttons: {
                'Cancel(取消)': function () {
                    $(this).dialog('close');
                }
            },
            close: function () {
                $(this).dialog('close');
            }
        });
    });

    //公告详细
    function messageDetail(messageId){
        $("#messageDetail").dialog('open');
        $.ajax({
            type:'POST',
            url:'/message/message/get-message-detail',
            dataType:'json',
            data: {'messageId':messageId},
            async:false,
            success:function(json){
                console.log(json);
                var datas ='';
                var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
                if(json) {
                    datas += "<table width='100%' id='tables' border='0' cellpadding='0' cellspacing='0'>";
                    datas += (i + 1) % 2 == 1 ? "<tr class='table-module-b2'>" : "<tr class='table-module-b1'>";
                    datas += "<td>" + json.data+ "</td>";
                    datas += "</tr>";
                    datas += "</table>";
                    $("#messageData").html(datas);
                }
            }
        });
    }
</script>

<div id="module-container">
    <form id="exportForm" action="/delivery/index/execute-pack-list" style="display: none;" method="POST"></form>
    <div id="module-table">
        <div class="module-head">
            <span class="module-title">消息列表</span>
        </div>
        <div id="search-module">
            <form id="searchForm" name="searchForm" class="submitReturnFalse">
                <div style="padding:0">
                    <div class="notice-type-div">
                        <div class="searchFilterText">公告状态：</div>
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
                <td width="2%" class="ec-center"><input type="checkbox" class="checkAll"></td>
                <td width="4%" class='ec-center'>序号</td>
                <td width="15%" class='ec-center'>标题</td>
                <td width="15%" class='ec-center'>状态</td>
                <td width="15%" class='ec-center'>消息类型</td>
                <td width="12%" class='ec-center'>发布时间</td>
                <td width="12%" class='ec-center'>操作</td>
            </tr>
            <form id="listForm" method="POST" action=""></form>

            <tbody id="table-module-list-data"><tr class="table-module-b1"><td colspan="7">请搜索...</td></tr>

            </tbody>
        </table>
    </div>
    <div class="pagination"></div>
    <div class="to_top_div" data-show="false"><span style="float: left;cursor: pointer;padding: 0px 2px;" title="返回顶部" class="iconToTop" onclick="toTop();"></span><span style="float: left;cursor: pointer;padding: 0px 2px;" title="前往底部" class="iconToBottom" onclick="toBottom();"></span>
    </div>
</div>

<div id="messageDetail">
    <div id="messageData"></div>
</div>



