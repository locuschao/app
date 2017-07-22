<style type="text/css">
table {
	border-collapse: collapse;
	border-spacing: 0;
}

.data-table th {
	text-align: right;
	font-weight: bold;
	padding: 8px 5px;
	border: 1px solid #D8E0E4;
	/*background: none repeat scroll 0 0 #f4faff;*/
	background: none repeat scroll 0 0 #e1effb;
}

.data-table td {
	padding: 8px 3px;
	border: 1px solid #D8E0E4;
}

.data-table td.left {
	width: 20%;
	font-weight: bold;
	text-align: right;
	border: 1px solid #D8E0E4;
}

.data-table td.right {
	width: 30%;
	text-align: left;
	border: 1px solid #D8E0E4;
}

#message_tip DIV {
	line-height: 20px;
	height: 20px;
}

.table_module TD {
	padding: 8px 3px;
	border: 1px solid #D8E0E4;
}

.module-title {
	font-weight: bold;
	padding-right: 5px;
	text-align: right;
    width:100px;
}
</style>
<input type="hidden" id="lodop_init" value="0">
<div id="content" style='padding:10px 20px;'>
	<div style="">
		<div style="padding-left: 5px; padding-top: 5px; width: 360px; float: left;">
			<h2 style="color: #E06B26;">安装打印控件：</h2>
			<table border="0" cellspacing="0" cellpadding="0" class="table_module" style="width: 100%;">
				<tbody>
					<tr style="height: 36px;">
						<td>检测到您的电脑未安装打印控件(或需要升级),请您按操作系统安装相应的打印控件版本。</td>
					</tr>
				</tbody>
			</table>
			<table border="0" cellspacing="0" cellpadding="0" class="table_module paper_printer_list" style="width: 100%; margin-top: 5px;">
				<tbody>
                    <tr class="table-module-b2">
                        <td class="module-title">
                            32位
                        </td>
                        <td style="text-align: center;">
                            <a href='/lodop/install_lodop32.exe' target='_self'>点击下载</a><br>
                            (兼容64位系统)
                        </td>
                    </tr>
                    <tr class="table-module-b1" style="display:none;">
                        <td class="module-title">
                            64位
                        </td>
                        <td style="text-align: center;">
                            <a href='/lodop/install_lodop64.exe' target='_self'>点击下载</a>
                        </td>
                    </tr>
                    <tr class="table-module-b1">
                        <td class="module-title">
                            卸载方法
                        </td>
                        <td style="text-align: center;">
                            在安装文件名前添加"un",如<b>un</b>install_lodop32.exe
                        </td>
                    </tr>
				</tbody>
			</table>
		</div>
		<div style="clear: both;"></div>
	</div>
</div>