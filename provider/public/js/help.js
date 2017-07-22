/**
 * 帮助文档的事件函数
 * @author Frank
 * @date 2013-10-26 11:19:39
 */
var _stepContent; 
	$(function(){
		/**
		 *	‘问号’的点击事件
		 */
		$(".sys_help").click(function(){
			var objIframe =$("#main-right-container-iframe > .iframe-container:visible");
			if(objIframe != null && objIframe.length > 0){
				//获取权限ID参数
				var iframeId = objIframe.attr('id');
				var uId = iframeId.substring(17,iframeId.length);

				//加载对应流程状态，状态描述等等数据
				var options = {};
				var bodyWidth = parseInt($("body").css('width'));
				options['dWidth'] = parseInt(bodyWidth * 0.88);
				var guildMenu = $("#menu" + uId);
				options['dTitle'] = guildMenu.find("a").attr('title');
				options['url'] = '/default/system/get-help-data';
				options['paramId'] = uId;
				$("#sys_help_dialog").OpenSysHelpDialog(options);
			}
		});

		/**
		 *	设置帮助弹出窗
		 */
		jQuery.fn.OpenSysHelpDialog = function (options) {
		    var defaults = {
		        jsonData: {},
		        Field: 'paramId',
		        paramId: 0,
		        url: '/',
		        editUrl: '/',
		        dWidth: "550",
		        dHeight: "auto",
		        dTitle: "帮助/Help",
		        successMsg: ""
		    };
		    var options = $.extend(defaults, options);
		    options['dTitle'] += "--帮助说明";
		    var div = $(this);
		    var divHtml = div.html();
		    div.html("");
		    $('<div title="' + options.dTitle + '" id="dialog-edit-alert-tip" class="dialog-edit-alert-tip"><form id="editDataForm" name="editDataForm" class="submitReturnFalse">' + divHtml + '</form><div class="validateTips" id="validateTips"></div></div>').dialog({
		        autoOpen: true,
		        width: options.dWidth,
		        height: options.dHeight,
		        position: ['center',50],
		        modal: true,
		        show: "slide",
//		        buttons: [
//		            {
//		                text: "关闭(Close)",
//		                click: function () {
//		                    div.html(divHtml);
//		                    $(this).dialog("close");
//		                }
//		            }
//		        ],
		    	 close: function () {
		            $(this).detach();
		            div.html(divHtml);
		        }
		    });

			//主线步骤数据
	    	var mainStepListJson;
	    	//并行步骤数据
	    	var parallelStepListJson;
		    var getJson = function () {
		        $.ajax({
		            type: "post",
		            async: false,
		            dataType: "json",
		            url: options.url,
		            data: options.Field + "=" + options.paramId,
		            success: function (json) {
		                if (json.state) {
		                	mainStepListJson = json.main;
		                	parallelStepListJson = json.parallel;
		                	_stepContent = json.content;
		                	//当前进行到第几步
		    		    	var currentStep = mainStepListJson[0].StepCode;
		    		    	/*
		    		    	 * 设置状态流程图插件
		    		    	 */
		    		    	var StepTool = new Step_Tool("stateFlow","流程图","helpMycall");
		    		    	//使用工具对页面绘制相关流程步骤图形显示
		    		    	var tmp = parseInt($(".stateFlow").css('width'));
		    		    	var tmp1 = tmp / mainStepListJson.length;
		    		    	var tmp2 = (tmp1 / tmp) * 100;
		    		    	var nodeWidth = parseInt(tmp2);
		    		    	StepTool.drawStep(nodeWidth,mainStepListJson,parallelStepListJson);
		    		    	StepTool.belongsStep(currentStep,true);
		    		    	_StepTool = StepTool;

		    		    	/*
		    		    	 * 设置帮助内容
		    		    	 */
		    		    	setHelpContent(currentStep);
		                }else{
		                	setNotContent();
			            }
		            }
		        });
		    };
		    
		    if (options.url != '/' && options.paramId != '' && options.paramId != '0') {
		    	getJson();
		    }else{
		    	setNotContent();
		    }
		};
	});
	
	/**
	 * 没有帮助内容
	 */
	function setNotContent(){
		var tips = '<div class="noExist">'+
			    	'<div class="noExist_pic">'+
			        	'<img src="/images/help/base/no_exist_01.gif" style="border: 0px;" align="absmiddle">'+
			        '</div>'+
			    	'<div class="noExist_text" style="margin-top:25px;">'+
			        	'对不起，您查看的页面还没有帮助信息...<br>'+
			            '<span style="font-size:18px;" class="word_gray">Sorry, the page you are viewing has no help information ...</span>'+
			        '</div>'+
			        '<div class="clr"></div>'+
			        '</div>';
		$("#stateContent").html(tips);
	}

	/**
	 * 设置帮助内容
	 */
	function setHelpContent(currentStep){
		//获取帮助内容
		var content = '';
		for ( var int = 0; int < _stepContent.length; int++) {
			var array_element = _stepContent[int];
			if(array_element.key == currentStep){
				content = array_element.val;
				break;
			}
		}
		var bodyheight = parseInt($("body").css('height'));
		var contentHeight = parseInt(bodyheight * 0.6);
		$("#stateContent").parent().css("height",contentHeight);
		$("#stateContent").css("max-height",contentHeight);
		$("#stateContent").css("height",contentHeight);
		$("#stateContent").html(content);
	}

	/**
	 * 流程插件回调函数
	 */
	var _StepTool;
	function helpMycall(restult,bol){
		//这里可以填充点击步骤的后加载相对应数据的代码
		//alert(restult.StepNum + "--" + restult.StepCode + "--" + restult.StepText + "\n" + bol);
		_StepTool.belongsStep(restult.StepCode,!bol);
		//帮助文档变化
		setHelpContent(restult.StepCode);
	}