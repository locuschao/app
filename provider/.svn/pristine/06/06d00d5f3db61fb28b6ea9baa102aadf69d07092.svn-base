<{foreach from=$results item=result0 }>	
	<div style="width:20.2cm;margin:0 auto;<{if !$smarty.foreach.results.last}>page-break-after:always<{/if}>">
	<{foreach from=$result0 item=result key=key}>
		<div style="width:20cm;height:220px;line-height:25px;text-algin:center; margin:0 0 0px 0; float:left;border-bottom:2px dashed #999;<{if $key=='0'}>border-top:2px dashed #999;<{/if}>">
			<div style="height:1cm"></div>
			<div style="height:1.4cm;overflow:hidden;width:100%;text-align:center"><img src="/default/print/barcode?code=<{$result}>" style="width:10cm"/></div>
			<div style="height:2.4cm;line-height:2.4cm;width:100%;text-align:center;font-size:2.4cm;"><{$result}></div>
		</div>	
	<{/foreach}>
	<div style="clear:both;font-size:1px;height:1px;line-height:1px;"></div>
	</div>
<{/foreach}>