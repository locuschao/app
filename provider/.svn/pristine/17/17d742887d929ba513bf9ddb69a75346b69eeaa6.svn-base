$(function(){
	
	/**
	 * table表头浮动悬浮
	 * 使用方式：在table的父级DIV中，放置样式”.fixed_side“
	 */
	var _style = (!$("<style>"))?$("<style>").eq(0):$("<style>").insertBefore("body");
	_style.append(".fixed_div{display:none;position:fixed; top:1px; z-index:99;}");
	var _fixed_side = $(".fixed_side");
	window._fixed_side = _fixed_side;					//暴露到全局，适应部分特殊需求
	if(_fixed_side.length > 0) {
		//构造隐藏的DIV，用以放浮动的表头
		var scrollDiv = $("<div>").insertBefore(_fixed_side);
		scrollDiv.addClass("fixed_div");
		window._fixed_side_scrollDiv = scrollDiv;		//暴露到全局，适应部分特殊需求
        //添加操作导航
        var opArea = $(".opration_area");
        if(opArea.size()){
            scrollDiv.append(opArea.clone());
        }
		//向DIV中追加表头，设置table的属性
		var scrollTable = $("<table>").appendTo(scrollDiv);
		scrollTable.attr("width","100%");
		scrollTable.attr("border","0");
		scrollTable.attr("cellpadding","0");
		scrollTable.attr("cellspacing","0");
		scrollTable.addClass("table-module");

		//拿取.fixed_side样式中的第一个table，及tr（表头），copy到table中
		var tableTr= _fixed_side.find("table").first().find("tr");
		var tableTrTitle = tableTr.eq(0);
		var tmpTitle = tableTrTitle.clone();
		scrollTable.append(tmpTitle);

		var offset = _fixed_side.offset();
		window._fixed_side_offset = offset;				//暴露到全局，适应部分特殊需求
		var width = _fixed_side.width();			
		$(window).scroll(function () {
			var scrollTop = $(window).scrollTop();
			//如果距离顶部的距离小于浏览器滚动的距离，则显示或屏蔽浮动层
			//offset.top < scrollTop
			if (scrollTop - offset.top >25) {
				scrollDiv.show();
			}else{
				scrollDiv.hide();
			}
		});
		
	}
});