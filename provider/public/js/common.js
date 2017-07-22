/**
 * @deprecated 公共方法
 * @author Frank_MBA
 * @date 2015-12-5 16:54:15
 */

/**
 * 封装控制台的log方法，防止报错
 */
var console = console || {
    log : function(){
        return false;
    }
}

$(function(){
	//预览图片放大
	comomPreviewImg();
});

/**
 * 图片放大的公共方法
 * 使用方法：在Img上加上class元素，值为： imgPreview
 * 样式支持：/css/spinners.css
 */
function comomPreviewImg(){
	//移除旧的绑定事件
	$('.imgPreview').off('mouseover').off('mouseout');
	
	//新的图片放大方法
    $('body').append('<div id="preview_div"></div>');
	var _pr_div = $('#preview_div');
	var _pr_div_img_timeID = null;
    $('.imgPreview').on('mouseover',function(e){
    	$(this).css('cursor','-moz-zoom-in');
    	var maxWidth = 300;							//预览图片最大宽度
    	var display_height =  $(window).height();	//获取屏幕显示的高度
    	var srcollTop_height = $(document).scrollTop();	//被卷去的高度
    	var real_height = display_height + srcollTop_height;
    	
        var off = $(this).offset();
    	var x = off.left + 105;
    	x = Math.round(x);
    	var y = off.top - 15;
    	y = Math.round(y);
    	
    	//清除旧数据
    	_pr_div.children().remove();
    	//等等图片
    	var loading = '<div class="card">' +
        				'<span class="spinner-loader">Loading…</span>' +
    				'</div>';
    	/**
    	 * Tom 2016-4-5
    	 * 拥有更高堆叠顺序
    	 */
    	_pr_div.html(loading).css({'position':'absolute','top':y+'px','left':x+'px','border':'2px solid #ccc','border-radius':'3px','z-index':'999'}).show();
    	
    	//显示图片
    	var tempIMG = new Image();
    	var tempIMG_width = maxWidth;
    	var tempIMG_height = 0;
        tempIMG.src = $(this).attr('src');
    	tempIMG.onload = function(){
    	    tempIMG_width = tempIMG.width;
    	    tempIMG_height = tempIMG.height;
    	    tempIMG_width = tempIMG_width>maxWidth?maxWidth:tempIMG_width;
    	    
    	    //计算缩放比例
    	    var proportion = 1;
    	    if(tempIMG_width == maxWidth){
    	    	proportion = maxWidth / tempIMG.width;
    	    }
    	    /*
    	     * 调试
    	    $(".pagination").html(
    	    		'Y:' + y + '<br>' +'p:' + proportion + '<br>' +'imgH:' + tempIMG_height + '<br>' +
    	    		'imgH_p:' + (tempIMG_height * proportion) + '<br>' +'displayH:' + display_height + '<br>' +'srcollTopH:' + srcollTop_height + '<br>' +'realH:' + real_height + '<br>'
    	    );
    	    */
    	    
    	    if((y + (tempIMG_height * proportion)) > real_height){
    	    	y = real_height - (tempIMG_height * proportion) - 5;
    	    	y = Math.round(y);
    	    	_pr_div.css('top',y+'px');
    	    }
    	    /*
    	     * 调试
    	    $(".pagination").append('<hr>' +'Y:' + y + '<br>');
    	    */
    	    
    	    //清除旧的执行函数
    	    clearTimeout(_pr_div_img_timeID);
    	    
    	    //延时执行显示图片
    	    _pr_div_img_timeID = setTimeout(function () {
    	    	$(".card").slideUp().remove();
    	    	var img = '<img src="'+tempIMG.src+'" width="'+tempIMG_width+'" style="display:none;"/>'
    	    	_pr_div.append(img).children().slideDown(200);
    	    }, 200);
    	};
    	
    }).on('mouseout',function(e){
    	//清除旧数据
    	_pr_div.children().remove();
    	//隐藏
    	$('#preview_div').hide();    	
    });
}

/*
 * 判断Json数据是否返回正常
 */
function isJson(obj) {
    var jsonData = typeof(obj) == "object" && Object.prototype.toString.call(obj).toLowerCase() == "[object object]" && !obj.length;
    if (jsonData && obj.reLogin) {
        alertReLoginTip("<span class='tip-warning-message'>" + obj.message + "</span>");
        return false;
    }
    return jsonData;
}
