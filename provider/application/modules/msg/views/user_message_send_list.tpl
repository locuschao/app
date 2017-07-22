<link href="/css/msg/user_message_list.css" rel="stylesheet" />
<div id="module-container" style="float: left;margin-left: 185px;">
    <div id="ez-wms-edit-dialog" style="display:none;">
        <table class="dialog-module" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <input type="hidden" name="E0" id="E0" value=""/>

            <tr>
                <td class="dialog-module-title">消息类型:</td>
                <td><input type="text" name="E4" id="E4" validator="required" err-msg="<{t}>require<{/t}>"
                           class="input_text"/><span class="msg">*</span></td>
            </tr>
            <tr>
                <td class="dialog-module-title">发件人:</td>
                <td><input type="text" name="E6" id="E6" validator="required" err-msg="<{t}>require<{/t}>"
                           class="input_text"/><span class="msg">*</span></td>
            </tr>
            <tr>
                <td class="dialog-module-title">收件人:</td>
                <td><input type="text" name="E7" id="E7" validator="required" err-msg="<{t}>require<{/t}>"
                           class="input_text"/><span class="msg">*</span></td>
            </tr>
            <tr>
                <td class="dialog-module-title">是否已读:</td>
                <td><input type="text" name="E8" id="E8" class="input_text"/></td>
            </tr>
            <tr>
                <td class="dialog-module-title">创建时间:</td>
                <td><input type="text" name="E10" id="E10" class="input_text"/></td>
            </tr>
            <tr>
                <td class="dialog-module-title">修改时间:</td>
                <td><input type="text" name="E11" id="E11" class="input_text"/></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div id="search-module">
        <form id="searchForm" name="searchForm" class="submitReturnFalse">
            <div style="padding:0">
                <div class="notice-type-div">
                    <div class="searchFilterText">通知类型：</div>
                    <div class="pack_manager">
                        <input id="EF4" class="input_text keyToSearch" name="EF4" value="<{$selectedTypeCode}>" type="hidden">

                        <{foreach from=$noticeTypes item=val key=key}>
                        <a class="nt-code <{if $val.nt_code == $selectedTypeCode}>current<{/if}>" href="javascript:void(0)" onclick="searchFilterSubmit('EF4', '<{$val.nt_code}>', this)">
                            <{$val.nt_name}>
                        </a>
                        <{/foreach}>
                    </div>
                </div>

                <select class="input_text2" name="search_name" title="选择条件">
                    <option value="E5">主题</option>
                    <option value="EF5">发件人</option>
                    <option value="EF6">通知/业务单号</option>
                </select>

                <input class="input_text" name="search_key" type="text" placeholder="模糊搜索" />

                &nbsp;&nbsp;<input type="button" value="<{t}>search<{/t}>" class="baseBtn submitToSearch"/>
            </div>
        </form>
    </div>

    <div id="btn-module">
        <form>
            <input id="fw-mail-btn" class="baseBtn" type="button" title="转发" value="转发" />
            <input id="all-read-btn" class="baseBtn" type="button" title="全部已读" value="全部已读" />

            <select title="标记为" id="mark-select" class="input_text2">
                <option>标记为</option>
                <option value="read">已读</option>
                <option value="unread">未读</option>
                <option disabled>---------------</option>
                <option value="start">星标</option>
                <option value="unstart">取消星标</option>
            </select>
        </form>
    </div>

    <div id="module-table">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module">
            <tr class="table-module-title">
                <td width="8%" class="ec-center"><input id="check-all" title="全选" type="checkbox" /></td>

                <td class="send-user-name">发件人</td>
                <td class="code">通知/业务单号</td>
                <td class="msg-subject">主题</td>
                <td class="create-time">时间</td>
                <td class="opt-td">操作</td>
            </tr>
            <tbody id="table-module-list-data"></tbody>
        </table>
    </div>
    <div class="pagination"></div>
</div>

<script type="text/javascript" src="/js/modules/msg/extFn.js"></script>
<script type="text/javascript" src="/js/modules/msg/noticeMessageSendList.js"></script>
<script type="text/javascript">
    $(function () {
        var noticeMessageList = new NoticeMessageSendList();
        noticeMessageList.init();

        noticeMessageList.setMessageUnReadTotal('<{$messageUnReadTotal}>', '#messageUnReadTotal');
    });

</script>
