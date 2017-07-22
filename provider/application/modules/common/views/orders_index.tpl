<script type="text/javascript">
	var outboundBatchStatusJson=<{$outboundBatchStatusJson}>;
    EZ.url = '/common/orders/';
    EZ.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html += "<td class='ec-center'>" + (i++) + "</td>";
            html += "<td>" + val.E5 + "</td>";
            html += "<td>" + val.E1 + "</td>";
            html += "<td>" + val.E4 + "</td>";
            html += "<td>" + (outboundBatchStatusJson[val.E28]?outboundBatchStatusJson[val.E28]:'') + "</td>";
            html += "<td>" + val.E6 + "</td>";
            html += "<td>" + val.E29 + "</td>";
            html += "<td>" + val.E11 + "</td>";
            html += "<td>" + (outboundBatchStatusJson[val.E13]?outboundBatchStatusJson[val.E13]:'') + "</td>";
            html += "<td><a href=\"javascript:deleteById(" + val.E0 + ")\">" + EZ.del + "</a></td>";
            html += "</tr>";
        });
        return html;
    }
</script>
<style>
    .searchFilterText{
        width:100px;
    }
    .table-module td{
        word-break: break-all;
    }
</style>
<div id="module-container">
    <div id="ez-wms-edit-dialog" style="display:none;">
        <table class="dialog-module" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <input type="hidden" name="E0" id="E0" value=""/>

            <tr>
                <td class="dialog-module-title">总单号:</td>
                <td><input type="text" name="E1" id="E1" class="input_text"/></td>
            </tr>
            <tr>
                <td class="dialog-module-title">服务商代码:</td>
                <td><input type="text" name="E2" id="E2" class="input_text"/></td>
            </tr>
            <tr>
                <td class="dialog-module-title">文件路径:</td>
                <td><input type="text" name="E3" id="E3" class="input_text"/></td>
            </tr>
            <tr>
                <td class="dialog-module-title">失败次数:</td>
                <td><input type="text" name="E4" id="E4" class="input_text"/></td>
            </tr>
            <tr>
                <td class="dialog-module-title">状态:</td>
                <td><input type="text" name="E5" id="E5" class="input_text"/></td>
            </tr>
            <tr>
                <td class="dialog-module-title">同步状态:</td>
                <td><input type="text" name="E6" id="E6" class="input_text"/></td>
            </tr>
            <tr>
                <td class="dialog-module-title">失败原因:</td>
                <td><input type="text" name="E7" id="E7" class="input_text"/></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div id="search-module">
        <form id="searchForm" name="searchForm" class="submitReturnFalse">

            <div style="padding:0">
            	<!-- 单选过来条件 -->
	            <table id="searchfilterArea1" class="searchfilterArea" width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td>
								<div class="searchFilterText">类型：</div><!-- 类型 -->
								<div class="pack_manager">
									<input class="input_text keyToSearch" id="E28" name="E28" value="" type="hidden">
									<a onclick="searchFilterSubmit('E28','',this)" href="javascript:;">全部<!-- 全部 --></a>
	 								<{foreach from=$outboundBatchStatusArr item=val key=key}>
	                            		<a onclick="searchFilterSubmit('E28','<{$key}>',this)" href="javascript:;"><{$val}><!-- 全部 --></a>
	                        		<{/foreach}>
								</div>
							</td>
						</tr>	
					</tbody>
				</table>
				
            	<!-- 
                <div class="search-module-condition">
                    <span class="searchFilterText" style="">订单状态：</span>
                    <select name="E28" id="E28" class="input_text2">
                        <option value="">全部</option>
                        <{foreach from=$outboundBatchStatusArr item=val key=key}>
                            <option value="<{$key}>"><{$val}></option>
                        <{/foreach}>
                    </select>
                </div>
                 -->
                <div class="search-module-condition">
                    <span class="searchFilterText" >API导入物流订单状态：</span>
                    <select name="E13" id="E13" class="input_text2">
                        <option value="">全部</option>
                        <{foreach from=$outboundBatchStatusArr item=val key=key}>
                            <option value="<{$key}>"><{$val}></option>
                        <{/foreach}>
                    </select>
                </div>

                <div class="search-module-condition">
                    <span class="searchFilterText" >订单号：</span>
                    <input type="text" name="E1" id="E1" class="input_text keyToSearch"/>
                </div>
                <div class="search-module-condition">
                    <span class="searchFilterText" >跟踪号：</span>
                    <input type="text" name="E4" id="E4" class="input_text keyToSearch"/>
                </div>
                <div class="search-module-condition">
                    <span class="searchFilterText" >&nbsp;</span>
                    <input type="button" value="<{t}>search<{/t}>" class="baseBtn submitToSearch"/>
                </div>

            </div>
        </form>
    </div>

    <div id="module-table">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module">
            <tr class="table-module-title">
                <td width="3%" class="ec-center">NO.</td>

                <td>平台代码</td>
                <td>订单号</td>
                <td width="15%">跟踪号</td>
                <td>订单状态</td>
                <td>创建类型</td>
                <td>渠道代码</td>
                <td>同步物流时间</td>
                <td>API导入物流订单状态</td>
                <td><{t}>operate<{/t}></td>
            </tr>
            <tbody id="table-module-list-data"></tbody>
        </table>
    </div>
    <div class="pagination"></div>
</div>
