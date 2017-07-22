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
                <div class="read-status-div">
                    <div class="searchFilterText">读取类型：</div>
                    <div class="pack_manager">
                        <input id="E8" class="input_text keyToSearch" name="E8" value="" type="hidden">
                        <a class="nt-code current" href="javascript:void(0)" onclick="searchFilterSubmit('E8', '', this)">全部</a>
                        <{foreach from=$messageReadStatus item=val key=key}>
                        <a class="nt-code <{if $key == $messageReadStatus}>current<{/if}>" href="javascript:void(0)" onclick="searchFilterSubmit('E8', '<{$key}>', this)">
                            <{$val}>
                        </a>
                        <{/foreach}>
                    </div>
                </div>

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

                <div>
                    <div class="searchFilterText">
                        <select class="input_text2" name="search_name" title="选择条件">
                            <{foreach from=$messageSearch item=val key=key}>
                            <option value="<{$key}>"><{$val}></option>
                            <{/foreach}>
                        </select>&nbsp;
                    </div>
                    <div class="pack_manager">
                        <input class="input_text" name="search_key" type="text" placeholder="模糊搜索，多个单号，请用空格隔开" style="width:200px;">
                    </div>
                </div>
                <div class="search-module-condition">
                    <span class="searchFilterText">&nbsp;</span>
                    <input type="button" value="<{t}>search<{/t}>" class="baseBtn submitToSearch"/>
                    <input type="hidden" value="<{$idArr}>" name="E0" />
                </div>
            </div>
        </form>
        <div class="windows-inform" id="windows-inform" data-msg="" data-warn="" data-process="">
            <span class="inform-title">桌面通知：</span>
            <span class="inform-text" id="inform-text"></span>
        </div>
    </div>

    <div class="count-info">
        收件箱
        <span class="count-text">(共：
            <span id="email-count"><{$messageTotal}></span>
            <span> 封 </span>
            <span>，其中 <a class="unread-text">未读邮件 </a>
                <span id="email-unread-count"><{$messageUnReadTotal}></span>
                 封
            </span>
            )
        </span>
    </div>

    <div id="btn-module">
        <form>
            <input id="fw-mail-btn" class="baseBtn" type="button" title="转发" value="转发" />
            <input id="all-read-btn" class="baseBtn" type="button" title="全部已读" value="全部已读" />

            <select title="标记为" id="mark-select" class="input_text2" style="height:24px;">
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
<script type="text/javascript" src="/js/modules/msg/messagePush.js"></script>
<script type="text/javascript" src="/js/modules/msg/noticeMessageList.js"></script>
<script type="text/javascript" src="/js/modules/msg/messagePush.js?20161261911"></script>
<script type="text/javascript">
    $(function () {
        var noticeMessageList = new NoticeMessageList();
        noticeMessageList.init();

        noticeMessageList.setMessageUnReadTotal('<{$messageUnReadTotal}>', '#messageUnReadTotal');

        //轮询消息
        var messagePush = new MessagePush();
        messagePush.intervalPush();
    });

</script>
