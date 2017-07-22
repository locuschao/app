<link href="/css/msg/notice_application.css" rel="stylesheet" />

<div id="module-container">
    <div id="add-application-rule-dialog" style="display:none;">
        <div style="background-color: #FFFFFF; width: 99%;height: 60px;padding: 5px;">
            <table class="dialog-module" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <input type="hidden" name="E0" id="E0" value=""/>
                <tr>
                    <td class="dialog-module-title">节点名称:</td>
                    <td>
                        <input title="" type="text" name="E3" id="E3" class="input_text"/>
                    </td>
                </tr>

                <tr>
                    <td class="dialog-module-title">排序值:</td>
                    <td>
                        <input title="" type="text" name="E4" id="E4" class="input_text" />
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div id="search-module">
        <form id="searchForm" name="searchForm" class="submitReturnFalse">
            <div style="padding:0;">

                <div class="search-module-condition">
                    <div class="searchFilterText">数据来源：</div>
                    <div class="pack_manager">
                        <input class="input_text keyToSearch" id="E9" name="E9" value="" type="hidden">
                        <a onclick="searchFilterSubmit('E9','',this)" href="javascript:;">全部<!-- 全部 --></a>
                        <a onclick="searchFilterSubmit('E9','1',this)" href="javascript:;">系统</a>
                        <a onclick="searchFilterSubmit('E9','0',this)" href="javascript:;">客户</a>
                    </div>
                </div>

                <div class="search-module-condition">
                    <div class="searchFilterText">类型：</div>
                    <div class="pack_manager">
                        <input class="input_text keyToSearch" id="E1" name="E1" value="" type="hidden">
                        <a onclick="searchFilterSubmit('E1','',this)" href="javascript:;">全部<!-- 全部 --></a>
                        <{foreach from=$noticeType item=val key=key}>
                        <a onclick="searchFilterSubmit('E1','<{$val.nt_code}>',this)" href="javascript:;"><{$val.nt_name}></a>
                        <{/foreach}>
                    </div>
                </div>

                <div class="search-module-condition">
                    <div class="searchFilterText">状态：</div>
                    <div class="pack_manager">
                        <input class="input_text keyToSearch" id="E4" name="E4" value="" type="hidden">
                        <a onclick="searchFilterSubmit('E4','',this)" href="javascript:;">全部<!-- 全部 --></a>
                        <a onclick="searchFilterSubmit('E4','0',this)" href="javascript:;">停用</a>
                        <a onclick="searchFilterSubmit('E4','1',this)" href="javascript:;">启用</a>
                    </div>
                </div>

                <div class="search-module-condition">
                    <span class="searchFilterText" >名称：</span>
                    <input type="text" name="E3" id="E3" class="input_text keyToSearch" placeholder="支持前后模糊搜索"/>
                </div>
                <div class="search-module-condition">
                    <span class="searchFilterText" >代码：</span>
                    <input type="text" name="E2" id="E2" class="input_text keyToSearch" placeholder="支持前后模糊搜索"/>
                </div>
                <div class="search-module-condition">
                    <span class="searchFilterText" >&nbsp;</span>
                    <input type="button" value="<{t}>search<{/t}>" class="baseBtn submitToSearch"/>
                </div>
            </div>
        </form>
    </div>

    <div class="btn-div">
        <input id="submit-to-delete" type="button" value="删除" class="baseBtn"/>
        <input type="button" id="createButton" value="添加" class="baseBtn btn-add"/>
    </div>

    <div id="module-table">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module">
            <tr class="table-module-title">
                <td width="3%" class="ec-center"><input title="全选" id="check-all" type="checkbox" data-checkclass="check-item"></td>

                <td>名称</td>
                <td width="5%">数据来源</td>
                <td width="5%">类型</td>
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
<script type="text/javascript" src="/js/modules/msg/noticeApplication.js?201611150001"></script>
<script type="text/javascript">
    $(function(){
        var noticeApplication = new NoticeApplication();
        noticeApplication.setNoticeType('<{$noticeTypeJson}>');
        noticeApplication.init();
    });
</script>