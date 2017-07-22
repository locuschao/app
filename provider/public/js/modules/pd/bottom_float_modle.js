$(function(){
	//自动固定底部
	$('.float_bottom_modle').each(function(){
		var current_iframe_height =$($(window.parent.document).find("iframe")[0]).height();
		var current_page_height =$(document.body).height();
		if(current_iframe_height!=null && current_page_height >= current_iframe_height){
			$('.float_bottom_modle').css({
			    'position' : 'fixed',
			    'bottom' : '0px',
			    'width' : '100%',
			    'clear':'left',
			    'text-align':'left',
			    'height': 'auto',
				'background': 'transparent url("/images/pack/bg_search01.gif") repeat-x scroll center bottom',
				'padding': '10px'
			});
			$(".float_bottom_modle").parent().append("<div style='height:40px;clear: left;'></div>");
		}
	});
});