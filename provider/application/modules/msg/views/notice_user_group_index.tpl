<link rel="stylesheet" type="text/css" href="/css/msg/notice_user_group.css?201611031743">
<div id="module-container">
    <div id="ez-wms-edit-dialog" style="display:none;">
        <table class="dialog-module" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <input type="hidden" name="E0" id="E0" value=""/>
            <tr>
                <td class="dialog-module-title">分组名:</td>
                <td><input type="text" name="E2" id="E2" validator="required" err-msg="<{t}>require<{/t}>"
                           class="input_text"/><span class="msg">*</span></td>
            </tr>
            <tr>
                <td class="dialog-module-title">状态:</td>
                <td>
                    <select name="E1" id="E1" class="input_text2 w150">
                        <{foreach from=$noticeUserGroupStatusArr item=val key=key}>
                        <option value="<{$key}>"><{$val}></option>
                        <{/foreach}>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div id="search-module">
        <form id="searchForm" name="searchForm" class="submitReturnFalse">
            <div class="search-module-condition">
                <div class="searchFilterText">是否应用：</div>
                <div class="pack_manager">
                    <input class="input_text keyToSearch" id="E3" name="E3" value="" type="hidden">
                    <a onclick="searchFilterSubmit('E3','',this)" href="javascript:;">全部<!-- 全部 --></a>
                    <{foreach from=$noticeUserGroupDistributeStatusArr item=val key=key}>
                    <a onclick="searchFilterSubmit('E3','<{$key}>',this)" href="javascript:;"><{$val}></a>
                    <{/foreach}>
                </div>
            </div>

            <div class="search-module-condition">
                <div class="searchFilterText">状&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp态：</div>
                <div class="pack_manager">
                    <input class="input_text keyToSearch" id="E1" name="E1" value="" type="hidden">
                    <a onclick="searchFilterSubmit('E1','',this)" href="javascript:;">全部<!-- 全部 --></a>
                    <{foreach from=$noticeUserGroupStatusArr item=val key=key}>
                    <a onclick="searchFilterSubmit('E1','<{$key}>',this)" href="javascript:;"><{$val}></a>
                    <{/foreach}>
                </div>
            </div>

            <div class="search-module-condition">
                <span class="searchFilterText" style="">分组名称：</span>
                <input type="text" name="E2" id="E2" class="input_text keyToSearch" placeholder="支持前后模糊搜索">&nbsp&nbsp
            </div>
            <div class="search-module-condition">
                <span class="searchFilterText" style="">用户名称：</span>
                <input type="text" name="G1" id="G1" class="input_text keyToSearch" placeholder="支持前后模糊搜索">
            </div>
            <input type="button" value="<{t}>搜索<{/t}>" class="baseBtn submitToSearch btn-search"/>
        </form>
    </div>

    <div class="btn-div">
        <input type="button" id="deleteButton" value="<{t}>删除<{/t}>" class="baseBtn"/>
        <input type="button" id="createButton" value="<{t}>添加<{/t}>" class="baseBtn btn-add"/>
    </div>

    <div id="module-table">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module">
            <tr class="table-module-title">
                <td width="3%" class="ec-center"><input title="全选" id="check-all" type="checkbox"></td>
                <td>分组名</td>
                <td width="5%">分组人数</td>
                <td width="5%">是否应用</td>
                <td width="5%">状态</td>
                <td width="15%">操作人</td>
                <td width="15%">时间</td>
                <td width="10%"><{t}>operate<{/t}></td>
            </tr>
            <tbody id="table-module-list-data"></tbody>
        </table>
    </div>
    <div class="pagination"></div>
</div>

<script type="text/javascript" src="/js/modules/msg/extFn.js?201611040001"></script>
<script type="text/javascript" src="/js/modules/msg/noticeUserGroup.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var noticeUserGroup = new NoticeUserGroup();
        noticeUserGroup.init();
    });
</script>