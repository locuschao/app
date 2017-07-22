<script type="text/javascript">
    EZ.url = '/product/Proofing/';
    EZ.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html +=" <td class='ec-center'><input type='checkbox' class='checkItem' name='biddingId[]'  ref_id='"+val.bidding_id+"' value='"+val.bidding_id+"'></td>";
            html += "<td>" + (i++) + "</td>";
            html +=" <td>"+val.sample_no+"</td>";
            html +=" <td><img src='"+val.bp_url+"'style='width: 100px;height: 70px;'/></td>";
            html +=" <td>"+val.bidding_name+ (val.bidding_name_en ? "["+val.bidding_name_en+"]" : '')+"</td>";
            html +=" <td>长：" + val.bidding_long +val.bidding_size_unit+"<br>";
            html += "宽：" + val.bidding_width+val.bidding_size_unit+"<br>";
            html += "高：" + val.bidding_heigh +val.bidding_size_unit;
            html += "</td>"
            html +=" <td>"+val.bidding_color+"</td>";
            html +=" <td>"+val.bidding_create_time+"</td>";
            html +=" <td>"+val.user_name+(val.user_name_en ? "["+val.user_name_en+"]" : '')+"</td>";
            if(val.sample_result=='0'){
                html += "<td>未通过</td>";
            }else{
                html +="<td>已通过</td>";
            }
            html +=" <td>"+val.sample_reason+"</td>";
            html +=" <td>"+val.sample_price+val.sample_price_unit+"</td>";
            html += "</tr>";
        });
        return html;
    }
    //全选
    $(function(){
        $(".checkAll").live('click', function() {
            $(".checkItem").attr('checked', $(this).is(':checked'));
        });
    });
    $(function(){
        //打样列表
        $("#detail_list").dialog({
            autoOpen: false,
            width: 750,
            height: 'auto',
            modal: true,
            show: "slide",
            buttons: [
                {
                    text: "确认(OK)",
                    click: function () {
                        $(this).dialog("close");
                        var trObject = $('#detail_data').find("input[name='buddingId']");
                        var string = '';
                        trObject.each(function(){
                            string+=$(this).val()+',';
                        });
                        string = string.substr(0,string.length-1);
                        $.ajax({
                            async: false,
                            type: 'Post',
                            url: '/product/Proofing/detail-save',
                            data: {
                                idString:string,
                                deliverNo:$('#deliverNo').text(),
                            },
                            dataType: 'json',
                            success: function (json) {
                                if (json.state == 1) {
                                    $('.submitToSearch').click();
                                    alertTip("<span class='tip-success-message'>"+json.message+"</span>");
                                }else{
                                    alertTip("<span class='tip-error-message'>"+json.message+"</span>");
                                }
                                ///  alertTip(json.message);
                            }
                        })
                    }
                },

                {
                    text: "取消(Cancel)",
                    click: function () {
                        $(this).dialog("close");
                    }
                }
            ]
        });
    });
    // 生成送样单
    function deliverSingleGeneration(){
        if($(".checkItem:checked").size()<1){
            alertTip("至少选择一条打样信息.");return false;
        }
        var string = '';
        $(".checkItem:checked").each(function(){
            string+=$(this).val()+",";
        });
        string = string.substr(0,string.length-1);
        $.ajax({
            async:true,
            type:'Post',
            url:'/product/proofing/detail',
            data:{
                idString:string,
            },
            dataType:'json',
            success:function(json){
                var html = '';
                $.each(json.data, function (key, val) {
                    html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
                    html +=" <td>"+val.sample_no+"</td>";
                    html +=" <td>"+val.bidding_name+ (val.bidding_name_en ? "["+val.bidding_name_en+"]" : '')+"</td>";
                    html +=" <td>长：" + val.bidding_long +val.bidding_size_unit+"<br>";
                    html += "宽：" + val.bidding_width+val.bidding_size_unit+"<br>";
                    html += "高：" + val.bidding_heigh +val.bidding_size_unit;
                    html += "</td>"
                    html +=" <td>"+val.bidding_color+"</td>";
                    html +=" <td>";
                    html +="<a href='javascript:;' onclick=del(this)>" + EZ.del + "</a>";
                    html +="</td>";
                    html +="<input name='buddingId' value='"+val.bidding_id+"' type='hidden'>";
                    html += "</tr>";
                });
                $('#deliverNo').text(json.deliverNo);
                $('#detail_data').html('');
                $('#detail_data').append(html);
            }
        });
        /* 清空客户代码 end*/
        $("#detail_list").dialog('open');
    }
    function del(object)
    {
        var trObject = $(object).parents('table').find("input[name='buddingId']");
        var string = '';
        trObject.each(function(){
            string+=$(this).val();
        });
        if(string.length <= 1){
            alertTip("至少保留一条送样单信息.");return false;
        }
        $(object).parents('tr').remove();
    }
</script>
<style type="text/css">
    .boundBtn {
        float: right;
        margin: 10px 5px 0 0;
        font-size: 14px;
    }
</style>
<div id="module-container">
    <div id="ez-wms-edit-dialog" style="display:none;">
        <table class="dialog-module" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <input type="hidden" name="E0" id="E0" value=""/>
            
            </tbody>
        </table>
    </div>


    <div id="module-table">
        <div class="module-head">
            <span class="module-title">产品列表</span>
            <input type="button" value="生成送样单" class="initBtn otherBtn boundBtn" onclick="deliverSingleGeneration();" />
        </div>
        <div id="search-module">
            <form id="searchForm" name="searchForm" class="submitReturnFalse">
                <input type="hidden" value="120" id="filterActionId">
                <div class="search-module-condition">
                    <span class="searchFilterText">样品编号：</span>
                    <input type="text" name="sample_no" class="input_text keyToSearch" id="txt" placeholder="支持模糊搜素">
                </div>
                <div class="search-module-condition">
                    <span class="searchFilterText">采购商：</span>
                    <input type="text" name="ute_erp_name" class="input_text keyToSearch" id="txt" placeholder="支持模糊搜素">
                </div>

                <!-- <div style="margin-top:10px;" class="pack_manager_content">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" id="searchfilterArea" class="searchfilterArea">
                        <tbody>
                        <tr>
                            <td>
                                <div class="searchFilterText" style="width: 120px;">审核结果：</div>
                                <div class="pack_manager">
                                    <input type="hidden" name="sample_result" id="sample_result" class="input_text keyToSearch">
                                    <{foreach from=$statusTypes item=val key=key}>
                                    <a class="nt-code <{if $val == $statusTypes}>current<{/if}>" href="javascript:void(0)" onclick="searchFilterSubmit('do_status', '<{$key}>', this)">
                                        <{$val}>
                                    </a>
                                    <{/foreach}>
                                    <a href="javascript:void(0)" onclick="searchFilterSubmit('sample_result','',this)">全部</a>
                                    <a href="javascript:void(0)" onclick="searchFilterSubmit('sample_result','1',this)">审核通过</a>
                                    <a href="javascript:void(0)" onclick="searchFilterSubmit('sample_result','2',this)">待审核</a>
                                    <a href="javascript:void(0)" onclick="searchFilterSubmit('sample_result','0',this)">审核不通过</a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div> -->
                &nbsp;&nbsp;
                <div class="search-module-condition">
                    <span class="searchFilterText">&nbsp;</span>
                    <input type="button" value="搜索" class="initBtn otherBtn submitToSearch">
                </div>
            </form>
        </div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module">
            <tr class="table-module-title">
                <td width="2%" class="ec-center"><input type="checkbox" class="checkAll"></td>
                <td width="4%">序号</td>
                <td>样品编号</td>
                <td>图片</td>
                <td>产品名称</td>
                <td>规格尺寸</td>
                <td>颜色</td>
                <td>提交时间</td>
                <td>采购商</td>
                <td>评审结果</td>
                <td>原因</td>
                <td>报价</td>
            </tr>
            <tbody id="table-module-list-data"><tr class="table-module-b1"><td colspan="12">请搜索...</td></tr>

            </tbody>
        </table>
    </div>
    <div class="pagination"></div>
    <div class="to_top_div" data-show="false"><span style="float: left;cursor: pointer;padding: 0px 2px;" title="返回顶部" class="iconToTop" onclick="toTop();"></span><span style="float: left;cursor: pointer;padding: 0px 2px;" title="前往底部" class="iconToBottom" onclick="toBottom();"></span>
    </div>
    <!----------打样单列表------>
    <div id="detail_list" title="打样单列表" style="display: none; clear: both">
        <div>
            <legend style="margin-bottom: 8px;">送样单号:<span id="deliverNo"></span></legend>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module">
                <tr class="table-module-title">
                    <td width="20%">样品编号</td>
                    <td width="30%">产品名称</td>
                    <td width="20%">规格尺寸</td>
                    <td width="20%">颜色</td>
                    <td width="10%">操作</td>
                </tr>
                <tbody id="detail_data"><tr class="table-module-b1"></tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
