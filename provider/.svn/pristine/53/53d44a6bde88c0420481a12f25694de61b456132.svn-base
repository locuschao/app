<{foreach from=$results item=result0 }>
        <div style="width:8.5cm;height:9cm; margin:0 auto;<{if !$smarty.foreach.results.last}>page-break-after:always<{/if}>">
	<{foreach from=$result0 item=result key=key}>
		<div style="width:8.2cm;height:4.2cm;line-height:25px;text-algin:center; margin:0 0 0px 0; float:left;<{if $key=='1'}>border-top:2px dashed #999;<{/if}>">
			<div style="height:0.4cm"></div>
			<div style="height:1.4cm;overflow:hidden;width:8cm;text-align:center"><img src="/default/index/barcode?code=<{$result}>" style="width:7cm"/></div>
			<div style="height:2cm;line-height:2cm;width:8cm;text-align:center;font-size:1.2cm"><span style="font-size:0.8cm">CNHW.</span><{$result|replace:"CNHW.":""}></div>
		</div>
	<{/foreach}>
	<div style="clear:both;font-size:1px;height:1px;line-height:1px;"></div>
<{/foreach}>