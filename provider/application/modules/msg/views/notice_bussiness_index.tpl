<link rel="stylesheet" href="/css/zTreeStyle/zTreeStyle.css" />
<link rel="stylesheet" href="/css/msg/notice_bussiness.css" />
<style type="text/css">
    .chosen-container{
        min-width: 300px;
    }
</style>

<div id="module-container">
    <div id="search-module">
        <form id="searchForm" name="searchForm" class="submitReturnFalse">
            <div style="padding:0">
                <div class="pack_manager_content" style="padding:0">
                    <table id="searchfilterArea" class="searchfilterArea" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <div class="searchFilterText">数据来源：</div>
                                <div class="pack_manager">
                                    <input class="input_text keyToSearch" id="E3" name="E3" value="" type="hidden">
                                    <a onclick="searchFilterSubmit('E3','',this)" href="javascript:;">全部<!-- 全部 --></a>
                                    <a onclick="searchFilterSubmit('E3','1',this)" href="javascript:;">系统</a>
                                    <a onclick="searchFilterSubmit('E3','0',this)" href="javascript:;">客户</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="searchFilterText">通知类型：</div>
                                <div class="pack_manager">
                                    <input class="input_text keyToSearch" id="EF4" name="EF4" value="" type="hidden">
                                    <a onclick="searchFilterSubmit('EF4','',this)" href="javascript:;">全部<!-- 全部 --></a>
                                    <{foreach from=$noticeType item=val key=key}>
                                    <a onclick="searchFilterSubmit('EF4','<{$val.nt_code}>',this)" href="javascript:;"><{$val.nt_name}></a>
                                    <{/foreach}>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="searchFilterText">状态：</div>
                                <div class="pack_manager">
                                    <input class="input_text keyToSearch" id="E2" name="E2" value="" type="hidden">
                                    <a onclick="searchFilterSubmit('E2','',this)" href="javascript:;">全部<!-- 全部 --></a>
                                    <a onclick="searchFilterSubmit('E2','2',this)" href="javascript:;">草稿</a>
                                    <a onclick="searchFilterSubmit('E2','1',this)" href="javascript:;">启用</a>
                                    <a onclick="searchFilterSubmit('E2','0',this)" href="javascript:;">停用</a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="search-module-condition">
                    <span class="searchFilterText">通知应用：</span>
                    <select id="E1" name="E1[]" class="selectCss input_text2 custom_chosen" title="通知应用" multiple="multiple">
                        <option value="">全部</option>
                        <{foreach from=$noticeApplication item=val key=key}>
                        <option value="<{$val.na_code}>"><{$val.na_name}> / <{$val.na_code}></option>
                        <{/foreach}>
                    </select>
                </div>


                <div class="search-module-condition">
                    <span class="searchFilterText">通知代码：</span>
                    <input type="text" name="EF5" id="EF5" class="input_text keyToSearch" placeholder="支持前后模糊搜索"/>
                </div>
                <div class="search-module-condition">
                    <span class="searchFilterText">名称：</span>
                    <input type="text" name="E4" id="E4" class="input_text keyToSearch" placeholder="支持前后模糊搜索"/>
                </div>
                <div class="search-module-condition">
                    <span class="searchFilterText">&nbsp;</span>
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
                <td width="3%" class="ec-center">
                    <input title="全选" id="check-all" type="checkbox" data-checkclass="check-item">
                </td>
                <td>名称</td>
                <td width="5%">数据来源</td>
                <td>单号前缀</td>
                <td>通知应用</td>
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

<script type="text/javascript" src="/js/ztree.3.5.26/jquery.ztree.all.min.js"></script>
<script type="text/javascript" src="/js/modules/msg/extFn.js?201611040001"></script>
<script type="text/javascript" src="/js/modules/msg/noticeBussiness.js?201611040011"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var noticeBussinessList = new NoticeBussinessList();
        noticeBussinessList.setNoticeApplication('<{$noticeApplicationJson}>');
        noticeBussinessList.init();
    });
</script>
