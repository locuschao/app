//页面加载，获取所有的分类的信息
$(document).ready(function(){
	getCatList();
});

function getCatList(){
	$("#catHtml").myLoading();
	$.ajax({
        type: "post",
        dataType: "json",
        url: '/common/product-category-new/get-cat-list',
        success: function (json) {
        	html = "";
        	$.each(json,function(k,v){
        		
        		
        		html += '<div class="mail_menu" style="">';
                html +="<dl><dt><a href='javascript:void(0)' onclick=\"showThisMail(this,'"+v.pc_id+"',1)\">";
        		html += v.pc_name;
                html +="</a></dt>";
                html+="<div style='display: none'>";
        		$.each(v.second, function(kk,vv){
        			html += "<dd onmouseout='hidenBi("+vv.pc_id+");' onmouseover='showBi("+vv.pc_id+");'>";
        			html += '<a href="javascript:void(0)" onclick="showThisMail(this,\''+vv.pc_id+'\',1)">'+vv.pc_name;
                    html+='<img onclick="updateCat('+vv.pc_id+');" id="imgBi'+vv.pc_id+'" ' +'src="/images/sidebar/bi.jpg" ' +
                    'style="display:none;float:right;padding:3px;" />';
        			html += '</a></dd>';
                    html+="<div style='display: none'>";
        			$.each(vv.third,function(kkk, vvv){
        				html += "<p style='height:auto;padding-left: 5px;' onmouseout='hidenBi("+vvv.pc_id+");' onmouseover='showBi("+vvv.pc_id+");'>";
        				html += '<a class="catColor" id="catColor'+vvv.pc_id+'" onclick="showThisMail(this,\''+vvv.pc_id+'\',0)" href="javascript:void(0); setAddTemplate('+vvv.pc_id+')" >'+vvv.pc_name;
        				html += '<img onclick="updateCat('+vvv.pc_id+');" id="imgBi'+vvv.pc_id+'" src="/images/sidebar/bi.jpg" style="display:none;float:right;padding:3px;" /></a>';
                        html += '</p>';
        			});
                    html += '</div>';
        		});
                html += '</div>';
        		html += '</div>';
        	});
        	$("#catHtml").html(html);
            $("#prompt").html("");
        }
    });
}

/**
 * 修改分类
 */
function updateCat(id){

    //获取分类的数据
    $.ajax({
        type: "post",
        dataType: "json",
        url: '/message/template/get-group-info',
        data:{group_id:id},
        success: function (json) {
            $("#update_group_name_cn").val(json.data.group_name_cn);
            $("#update_group_name_en").val(json.data.group_name_en);
            $("#update_group_note").val(json.data.group_note);
            $("#update_platform").val(json.data.platform);
            $("#nowGroupId").val(id);
            $("#updateCatHtml").html(json.html);
            $("#crumbs").html(json.crumbs);
        }
    });
    $("#updateCatHtmlNew").dialog("open");

}

function showCurrtGroup(id){
	editGroupShow();
    //获取分类的数据
    $.ajax({
        type: "post",
        dataType: "json",
        url: '/common/product-category-new/get-category-info',
        data:{pc_id:id},
        success: function (json) {
            $("#pc_name_edit").val(json.pc_name);
            $("#pc_name_en_edit").val(json.pc_name_en);
//            $("#pc_shortname_edit").val(json.pc_shortname);
            $("#pc_hs_code_edit").val(json.pc_hs_code);
            $("#pc_level_edit").html(json.pc_level_name);
            
            $("#pc_id_edit").val(json.pc_id);
        }
    });
}

/**
 * 修改分类
 */
function updateCurtGroup(){

	var pc_name = $("#pc_name_edit").val();
	var pc_name_en = $("#pc_name_en_edit").val();
//	var pc_shortname = $("#pc_shortname_edit").val();
	var pc_hs_code = $("#pc_hs_code_edit").val();
	var pc_id_edit = $("#pc_id_edit").val();

    $.ajax({
        type: "post",
        dataType: "json",
        url: '/common/product-category-new/edit-category',
        data: {pc_name:pc_name,pc_name_en:pc_name_en,pc_hs_code:pc_hs_code,pc_id:pc_id_edit},
        success: function (json) {
            if(json.state){
            	var nowLevel = $("#nowLevel").val();
            	nowLevel = "topCat";
            	if(nowLevel == "topCat"){
					//重新填充第一级
					showAddCatHtml();
				} 
				if(nowLevel == "CatTwo"){
					//重新填充第二级
					getTwoCat('topCat');
				}
				if(nowLevel == "CatThird"){
					//重新填充第三级
					getThirdCat('CatTwo');
				}
            }else{
            	alertTip(json.message);
            }
        }
    });

}


function showBi(id){
//	$("#imgBi"+id).css('display','block');
}

function hidenBi(id){
//	$("#imgBi"+id).css('display','none');
}

/**
 * 设置模板的分类
 */
function setAddTemplate(groupid){
	$(".catColor").css("color","#666666");
	$("#catColor"+groupid).css({"color":"#008000","font-weight":"bold"});
	//$("#groupTemplateId").css("display","block");
	$("#setAddTemplate").val(groupid);
    $("#E3").val(groupid);
    $("#E1").val("");
    $("#E2").val("");
//    getMessageTemplateList();
}

function showAddCatHtml(){
	//获取第一级分类的值
	$.ajax({
        type: "post",
        dataType: "json",
        url: '/common/product-category-new/get-cat-top',
        success: function (json) {
    		html = "";
    		html += '<select style="height:200px;WIDTH:200px" id="topCat" size="10" onclick="getTwoCat(\'topCat\');">';
        	$.each(json,function(k,v){
        		html += '<option value="'+v.pc_id+'">'+v.pc_name+'</option>';
        	});
        	html += '</select>';
        	$("#oneCatHtml").html(html);
        }
    });
	$("#twoCatHtml").html("");
	$("#thirdCatHtml").html("");
	
	$("#showAddCatHtml").dialog("open");
	$("#add_two").css("display","none");
	$("#add_third").css("display","none");
    $("#editGroup").css("display","none");
    $("#prompt").html("&nbsp;");

}

/**
 * 获取第二级
 */
function getTwoCat(selectId){
	
	$("#thirdCatHtml").html("");
	var selectId = $("#"+selectId).val();
   // $("#prompt").html("&nbsp;");
	if(selectId == '' || selectId == null || selectId.length ==0){
		return;
	}
	if(objCate >= 2){
		$.ajax({
	        type: "post",
	        dataType: "json",
	        url: '/common/product-category-new/get-cat-top',
	        data:{pid:selectId},
	        success: function (json) {
	    		$("#nowLevel").val("topCat");
	    		html = "";
	    		html += '<select style="height:200px;WIDTH:200px" id="CatTwo" size="10" onclick="getThirdCat(\'CatTwo\');">';
	    		
	        	$.each(json,function(k,v){
	        		html += '<option value="'+v.pc_id+'">'+v.pc_name+'</option>';
	        	});
	        	html += '</select>';
	    		$("#twoCatHtml").html(html);
	        	$("#add_two").css("display","block");
	            $("#add_third").css("display","none");
	        }
	    });
	}
	
	showCurrtGroup(selectId);
}

/**
 * 获取第三级
 */
function getThirdCat(selectId){
	var selectId = $("#"+selectId).val();
   // $("#prompt").html("&nbsp;");
	
	if(selectId == '' || selectId == null || selectId.length ==0){
		return;
	}
	
	if(objCate == 3){
		$.ajax({
	        type: "post",
	        dataType: "json",
	        url: '/common/product-category-new/get-cat-top',
	        data:{pid:selectId},
	        success: function (json) {
	    		$("#nowLevel").val("CatThird");
	    		html = "";
	    		html += '<select style="height:200px;WIDTH:200px" id="CatThird" size="10" onclick="getThirdInfo(\'CatThird\');">';
	        	$.each(json,function(k,v){
	        		html += '<option value="'+v.pc_id+'">'+v.pc_name+'</option>';
	        	});
	        	html += '</select>';
	        	
	    		$("#thirdCatHtml").html(html);
	        	$("#add_third").css("display","block");
	        }
	    });
	}
	
	
	showCurrtGroup(selectId);
}


/**
 * 获取第三级
 */
function getThirdInfo(selectId){
	$("#nowLevel").val(selectId);
	var selectId = $("#"+selectId).val();
	if(selectId == '' || selectId == null || selectId.length ==0){
		return;
	}
    showCurrtGroup(selectId);
}

/**
 * 编辑分类的显示框
 */
function editGroupShow(){
    $("#addCatText").css("display","none");
    $("#editGroup").css("display","block");
        //添加第二级,获取第一级选中的分类
        var topCat = $("#topCat option:selected").text();
        var CatTwo = '  >  ' + $("#CatTwo option:selected").text();
        var CatThird = '  >  ' + $("#CatThird option:selected").text();
        
        var prompt = topCat+CatTwo+CatThird;
    
//    if($("#CatTwo option:selected").text() != ""){
//    	prompt = prompt+CatTwo;
//    }
//    if($("#CatThird option:selected").text() != ""){
//    	prompt = prompt+CatThird;
//    }
    $("#currtGroup").html(prompt);
}

/**
 * 添加分类的显示框
 */
function addCat(nowLevel){
	$("#addCatText").css("display","block");
    $("#editGroup").css("display","none");
	var prompt = "";
	if(nowLevel == "CatTwo"){
		//添加第二级,获取第一级选中的分类
		var topCat = $("#topCat option:selected").text();
		var CatTwo = '';
		$("#pc_level").html('1');
		$("#pc_level_text").html('2级品类');
	} 
	
	if(nowLevel == "CatThird"){
		//添加第三级,获取第二级选中的分类
		var topCat = $("#topCat option:selected").text();
		var CatTwo = '  >  ' + $("#CatTwo option:selected").text();
		$("#pc_level").html('2');
		$("#pc_level_text").html('3级品类');
	} 
	if(nowLevel == "topCat"){
		var topCat = '';
		var CatTwo = '';
		$("#pc_level").html('0');
		$("#pc_level_text").html('1级品类');
	} 
	
//	else {
//	    //添加第三极，获取三级全部的分类
//		var topCat = $("#topCat option:selected").text();
//		var CatTwo = "";
//		$("#CatTwo option:selected").attr("selected",false);
//	}
	
	//清空文本框
	$("#pc_name").val("");
	$("#pc_name_en").val("");
//	$("#pc_shortname").val("");
	$("#pc_hs_code").val("");
	
	prompt = (prompt)?prompt:topCat+CatTwo;
	$("#prompt").html(prompt);
	$("#nowLevel").val(nowLevel);
}

/**
 * 添加分类
 */
function addCategory(){
	var nowLevel = $("#nowLevel").val();
	
	//上级ID
	var parentId = 0;
	if(nowLevel == "CatTwo") {
		//上级ID
		parentId = $("#topCat").val();
		$("#pc_level").val(1);
	}
	
	if(nowLevel == "topCat"){
		parentId = 0;
		$("#pc_level").val(0);
	}
	if(nowLevel == "CatThird"){
		parentId = $("#CatTwo").val();
		$("#pc_level").val(2);
	}
	
	var pc_name = $("#pc_name").val();
	var pc_name_en = $("#pc_name_en").val();
//	var pc_shortname = $("#pc_shortname").val();
	var pc_hs_code = $("#pc_hs_code").val();
	var pc_level = $("#pc_level").val();
	
	if(pc_name == ''){
		$(".msg-1").html("不能为空");
		$("#pc_name").focus();
		return false;
	}
	
	if(pc_name_en == ''){
		$(".msg-2").html("不能为空");
		$("#pc_name_en").focus();
		return false;
	}
	
	if(nowLevel != "topCat" && pc_level ==''){
		$(".msg-2").html("请选择父级品类");
		$("#pc_name").focus();
		return false;
	}
	
//	if(pc_shortname == ''){
//		$(".msg-3").html("不能为空");
//		$("#pc_shortname").focus();
//		return false;
//	}
//	
//	if(pc_sort_id == ''){
//		$(".msg-4").html("不能为空");
//		$("#pc_sort_id").focus();
//		return false;
//	}
	
	$.ajax({
        type: "post",
        dataType: "json",
        url: '/common/product-category-new/edit-category',
        data: {pc_name:pc_name,pc_name_en:pc_name_en,pc_level:pc_level,pc_hs_code:pc_hs_code,pc_pid:parentId},
        success: function (json) {
        	if (json.state == 1) {
        		var nowLevel = $("#nowLevel").val();
				if(nowLevel == "topCat"){
					//重新填充第一级
					showAddCatHtml();
				} 
				if(nowLevel == "CatTwo"){
					//重新填充第二级
					getTwoCat('topCat');
				}
				if(nowLevel == "CatThird"){
					//重新填充第三级
					getThirdCat('CatTwo');
				}
				$("#pc_name").val("");
				$("#pc_name_en").val("");
//				$("#pc_shortname").val("");
				$("#pc_hs_code").val("");
				$("#pc_level").val("");
				
        	} else {
        		alertTip('<span class="tip-error-message">' + json.message + '</span>');
        	}
        }
    });
}


//加载框
$(function () {
    $("#showAddCatHtml").dialog({
        autoOpen: false,
        modal: true,
        width: 800,
        height: 500,
        show: "slide",
        buttons: {
            'Cancel': function () {
            	getCatList();
                $(this).dialog('close');
            }
        },
        close: function () {
        	getCatList();
        	$("#addTemplateHtml input").val('');
            $(this).dialog('close');
        }
    });

    $("#updateCatHtmlNew").dialog({
        autoOpen: false,
        modal: true,
        width: 700,
        height: 500,
        show: "slide",
        buttons: {
        	'Ok': function () {
               updateCatClick();
            },
            'Cancel': function () {
                $(this).dialog('close');
            }
        },
        close: function () {
        	$("#addTemplateHtml input").val('');
            $(this).dialog('close');
        }
    });
});


function deleteCategroy(){
	
	var id = $("#pc_id_edit").val();
	
	alertTip("<span class='tip-warning-message'>该品类如果存在子类，所有下属子类也会全部删除。确定要<span style='color:red;'>删除</span>该品类？</span>");
	$('#dialog-auto-alert-tip').dialog('option',
		'buttons',{
			"确认(Ok)" : function() {
				$(this).dialog("close");
				$.ajax({
			        type: "post",
			        dataType: "json",
			        url: '/common/product-category-new/delete',
			        data: {paramId:id},
			        success: function (json) {
			            if(json.state){
			            	var nowLevel = $("#nowLevel").val();
			            	nowLevel = "topCat";
			            	if(nowLevel == "topCat"){
								//重新填充第一级
								showAddCatHtml();
							} 
							if(nowLevel == "CatTwo"){
								//重新填充第二级
								getTwoCat('topCat');
							}
							if(nowLevel == "CatThird"){
								//重新填充第三级
								getThirdCat('CatTwo');
							}
			                
			            }else{
			            	alertTip("<span class='tip-warning-message'>"+json.message+"</span>");
			            }
			        }
			    });
			},
			"取消(Cancel)" : function() {
				$(this).dialog("close");
			}
		});
}

function showThisMail(obj,pc_id,check){
	$("#pc_type").val(pc_id);
	submitSearch();
	if(check == '0'){
		return;
	}
    var tmpObj= $(obj).parent().next("div").css("display");
    if(tmpObj=="none"){
        $(obj).parent().next("div").show();
        $(obj).css("background-image","url(/images/sidebar/bg_mail_menu01.gif)");

    }else{
        $(obj).parent().next("div").hide();
        $(obj).css("background-image","url(/images/sidebar/bg_mail_menu02.gif)");
    }

}

function showThis(obj){
    $(obj).show();
}

function closeThis(obj){
    $(obj).hide();
}