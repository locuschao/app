<link href="/css/order/order_index.css?20170517" rel="stylesheet" />

<div id="module-container">
    <div id="ez-wms-edit-dialog" style="display:none;">
        <table class="dialog-module" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <input type="hidden" name="E0" id="E0" value=""/>
                
            </tbody>
        </table>
    </div>

    <div id="print-edit-dialog" style="display:none;">
        <span>请选择您所需的打印方式！</span>
    </div>

    <!-- <div><button id="test">test</button></div> -->
    <div id="module-table">
        <div class="module-head">
            <span class="module-title">销售单列表</span>
            <div class="order-btn-div">
                <button type="button" class="initBtn otherBtn" id="confirm_order">确认销售单</button>
                <button type="button" class="initBtn otherBtn" id="cancel_order">取消销售单</button>
            </div>
        </div>
        <div id="search-module">
            <!--过滤的form表单-->
            <form id="searchForm" name="searchForm" class="submitReturnFalse">
                <div style="padding:0">
                    <div class="notice-type-div">
                        <div class="searchFilterText">销售单状态：</div>
                        <div class="pack_manager">
                            <input id="E10" class="input_text keyToSearch" name="E10" value="" type="hidden">
                            <a class="nt-code current" href="javascript:void(0)" onclick="searchFilterSubmit('E10', '', this)">全部</a>
                            <{foreach from=$statusTypes item=val key=key}>
                            <a class="nt-code <{if $val == $statusTypes}>current<{/if}>" href="javascript:void(0)" onclick="searchFilterSubmit('E10', '<{$key}>', this)">
                                <{$val}>
                            </a>
                            <{/foreach}>
                        </div>
                    </div>

                    <div class="search-module-condition">
                        <span class="searchFilterText" >销售单号：</span>
                        <input type="text" name="E2" id="E2" class="input_text keyToSearch" placeholder="请输入销售单号">
                    </div>

                    <div class="search-module-condition">
                        <span class="searchFilterText" >SKU：</span>
                        <input type="text" name="EF1" id="EF1" class="input_text keyToSearch" placeholder="请输入SKU">
                    </div>

                    <div class="search-module-condition">
                        <span class="searchFilterText" >采购商：</span>
                        <input type="text" name="E6" id="E6" class="input_text keyToSearch" placeholder="请输入采购商名称">
                    </div>

                    &nbsp;&nbsp;
                    <div class="search-module-condition">
                        <span class="searchFilterText">&nbsp;</span>
                        <input type="button" value="<{t}>搜索<{/t}>" class="initBtn otherBtn submitToSearch"/>
                        <!-- <input type="hidden" value="<{$idArr}>" name="E0" /> -->
                    </div>
                </div>
            </form>
        </div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module">
            <tr class="table-module-title">
                <td width="2%" class="ec-center"><input type="checkbox" class="checkAll"></td>
                <td width="4%" class="ec-center">NO.</td>
                <td class="ec-center">销售单</td>
                <td class="ec-center">产品代码</td>
                <td class="ec-center">数量</td>
                <td class="ec-center">总价（￥）</td>
                <td class="ec-center">预计交货时间</td>
                <td class="ec-center">状态</td>
                <td class="ec-center">创建时间</td>
                <td class="ec-center"><{t}>操作<{/t}></td>
            </tr>
            <tbody id="table-module-list-data"></tbody>
        </table>
    </div>
    <div class="pagination"></div>
</div>

<script type="text/javascript" src="/js/moment.js"></script>
<script type="text/javascript" src="/js/modules/orders/orders.js?201705251418"></script>
<script type="text/javascript">
    $(function () {
        var orders = new Orders();
        orders.init();
    })
    
</script>
