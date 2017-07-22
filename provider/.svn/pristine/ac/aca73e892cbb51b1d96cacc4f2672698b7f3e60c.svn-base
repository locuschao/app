/**
 * 步骤引导，工具类
 * @author Frank
 * @date 2013-10-14 15:36:24
 */

/**
 * 步骤工具对象
 * @param	className	放置步骤引导栏的，类名，
 * @param	title		步骤栏描述
 * @param	callFun		回调函数
 */
var Step_Tool =function(className,title,callFun){
	this.className = className,				//顶级容器的className
    this.stepToolTitle =	title,			//步骤栏的Title
    this.callFun =		callFun,			//回调函数
    this.step,
    this.stepAllHtml="";
};

/**
 * 步骤工具属性、方法
 */
Step_Tool.prototype={
	/*
	 * 绘制步骤
	 */
	drawStep:function(nodeWidth,mainStepListJson,parallelStepListJson){
		var Step_Obj = new Step($("."+this.className),this.stepToolTitle,nodeWidth,mainStepListJson,parallelStepListJson);
		this.step = Step_Obj;
		Step_Obj.clear();
		if(Step_Obj.createStepHtml()){
			Step_Obj.createEvent(this.callFun);			
		}
	},
	/*
	 * 当前所在步骤
	 */
	belongsStep:function(currentStep,isThroughParallelStepBol){
		if(this.step != null){
			var o = this.step;
			setTimeout(function(){
				if(typeof(isThroughParallelStepBol) == "unfinished"){
					isThroughParallelStepBol = false;
				}
				o.modifyStyle(currentStep,isThroughParallelStepBol);
			},200);
		}
	}
};

/**
 * 步骤类
 */
var Step = function(topContainer,title,nodeWidth,mainStepListJson,parallelStepListJson){
	this.stepTitle = title,
	this.stepNodeWidth = (nodeWidth != 0)?nodeWidth:8;
	this.topContainer = topContainer,		//放置步骤进度的顶级容器（jquery对象，一个div）
    this.mainStepsContainer,				//主线步骤容器
    this.parallelStepsContainer,			//并行步骤容器
    this.mainStepListJson = mainStepListJson;
	this.parallelStepListJson = parallelStepListJson,
	this.mainStepCode = new Array(),
	this.parallelStepCode = new Array();
};

/**
 * 步骤属性、方法
 */
Step.prototype={
	createStepHtml:function(){
		/*
		 * 1.新增步骤栏容器
		 */
		var stepContainer = $("<div>").appendTo(this.topContainer);
		stepContainer.addClass("step_div");
		
		/*
		 * 2.构建步骤栏的Title
		 */
		if(this.stepTitle != ''){
			var titleDiv = $("<div>").appendTo(stepContainer);
			titleDiv.addClass("posr");
			titleDiv.css("padding","5px 5px");
			var titleText = $("<h3>").appendTo(titleDiv);
			titleText.html(this.stepTitle);
		}
		
		/*
		 * 3.构建主线步骤容器、并行步骤容器
		 */
		var parallelStepContainer = $("<div>").appendTo(stepContainer);
		parallelStepContainer.addClass("posr parallel_steps");
		this.parallelStepsContainer = parallelStepContainer;

		var mainStepContainer = $("<div>").appendTo(stepContainer);
		mainStepContainer.addClass("posr main_steps");
		this.mainStepsContainer = mainStepContainer;
		
		
		/*
		 * 4.构建主线步骤内容
		 */
		var nodeWidth = this.stepNodeWidth;		//为适应宽度问题，宽度单位使用"%"
		var mainJsonData = this.mainStepListJson;
		var mainStepListJsonLength = mainJsonData.length;
		var tmpMainStepCodeArr = new Array();
		for ( var int = 0; int < mainStepListJsonLength; int++) {
			var array_element = mainJsonData[int];
			//节点容器
			var nodeContainer = $("<div>").appendTo(mainStepContainer);
			nodeContainer.addClass("left tx-cen");
			nodeContainer.css("width",nodeWidth + "%");

			//节点图标
			var nodeIcon = $("<span>").appendTo(nodeContainer);
			nodeIcon.attr("id","main_span_icon_"+array_element.StepNum);
			nodeIcon.attr("name","step_code_" + array_element.StepCode);
			
			//控制节点图标的样式
			if(int == 0){
				nodeIcon.addClass("t_start_0");
			}else if(int == mainStepListJsonLength -1){
				nodeIcon.addClass("t_end_0");
			}else{
				nodeIcon.addClass("t_process_0");
			}
			
			//节点文字
			var nodeText = $("<p>").appendTo(nodeContainer);
			nodeText.html(array_element.StepText);
			nodeText.data("jsonData",array_element);
			nodeText.data("isMainStep",true);
			
			tmpMainStepCodeArr.push(array_element.StepCode);
		}
		this.mainStepCode = tmpMainStepCodeArr;
		
		/*
		 * 5.判断是否存在并行步骤，构建并行步骤内容
		 */
		if(objIsJson(this.parallelStepListJson)){
			//并行步骤节点数据
			var parallenJsonData = this.parallelStepListJson;
			var parallelNode = parallenJsonData.ParallelNodeDetail;
			var parallelNodeLength = parallelNode.length;
			//计算并行步骤跨越的节点数
			var intervalNum = (parallenJsonData.StepNumEnd - parallenJsonData.StepNumStart) - 1;
			//确保并行节点与比跨越节点少
			if(intervalNum > parallelNodeLength){
				//计算并行节点的总宽度
				var parallelTotalWidth = intervalNum * nodeWidth;
				//得出并行节点的宽度
				var parallelNodeWidth = parallelTotalWidth / parallelNodeLength;
			}
			
			var parallelNodeIndex = 0;
			var tmpParallelStepCodeArr = new Array();
			for ( var int2 = 0; int2 < mainStepListJsonLength; int2++) {
				var array_element2 = mainJsonData[int2];
				//节点容器
				var nodeContainer = $("<div>").appendTo(parallelStepContainer);
				
				if(array_element2.StepNum < parallenJsonData.StepNumStart){
					nodeContainer.addClass("left tx-cen");
					nodeContainer.css("width",nodeWidth + "%");					
					nodeContainer.html("&nbsp;");
				}else if(array_element2.StepNum == parallenJsonData.StepNumStart){
					nodeContainer.addClass("left tx-cen");
					nodeContainer.css("width",nodeWidth + "%");
					//节点图标
					var nodeIcon = $("<span>").appendTo(nodeContainer);
					nodeIcon.addClass("t_turn_right_start_0");
				}else if(array_element2.StepNum == parallenJsonData.StepNumEnd){
					nodeContainer.addClass("left tx-cen");
					nodeContainer.css("width",nodeWidth + "%");
					//节点图标
					var nodeIcon = $("<span>").appendTo(nodeContainer);
					nodeIcon.addClass("t_turn_right_end_0");
				}else{
					if(parallelNodeLength == 0){
						if(array_element2.StepNum < parallenJsonData.StepNumEnd){
							nodeContainer.addClass("left tx-cen");
							nodeContainer.css("width",nodeWidth + "%");
							
							//节点图标
							var nodeIcon = $("<span>").appendTo(nodeContainer);
							nodeIcon.addClass("t_process_unnode_0");
						}
					}else if(parallelNodeIndex < parallelNodeLength){
						nodeContainer.addClass("left tx-cen");
						nodeContainer.css("width",parallelNodeWidth + "%");
						
						//节点图标
						var nodeIcon = $("<span>").appendTo(nodeContainer);
						nodeIcon.attr("id","parallel_span_icon_"+parallelNode[parallelNodeIndex].StepNum);
						nodeIcon.attr("name","step_code_" + parallelNode[parallelNodeIndex].StepCode);
						nodeIcon.addClass("t_process_0");
						
						//节点文字
						var nodeText = $("<p>").appendTo(nodeContainer);
						nodeText.html(parallelNode[parallelNodeIndex].StepText);
						nodeText.data("jsonData",parallelNode[parallelNodeIndex]);
						nodeText.data("isMainStep",false);
						
						tmpParallelStepCodeArr.push(parallelNode[parallelNodeIndex].StepCode);
						parallelNodeIndex += 1;
					}else{
						nodeContainer.remove();
					}
				}
			}
			this.parallelStepCode = tmpParallelStepCodeArr;
			//清除浮动
			var clearDiv = $("<div>").appendTo(parallelStepContainer);
			clearDiv.addClass("clear");
		}
		
		//清除浮动
		var clearDiv = $("<div>").appendTo(stepContainer);
		clearDiv.addClass("clear");
		
		return true;
	},
	modifyStyle:function(currentStep,isThroughParallelStepBol){
		//多次改变样式影响较大，先清除，然后重新构建
		this.clear();
		this.createStepHtml();
		
		var mainStepIndex = $.inArray(currentStep, this.mainStepCode);
		var parallelStepIndex = $.inArray(currentStep, this.parallelStepCode);
		var mainStepNodeIndex = -1;
		var parallelStepNodeIndex = -1;
		
		if(mainStepIndex != -1){
			mainStepNodeIndex = mainStepIndex;
		}else if(parallelStepIndex != -1){
			parallelStepNodeIndex = parallelStepIndex;
			mainStepNodeIndex = this.parallelStepListJson.StepNumStart - 1;
		}
		
		//主线步骤到达了并行步骤的结尾处
		var mainStepToParallelStepBol = (mainStepIndex >= this.parallelStepListJson.StepNumEnd - 1)?true:false;
		var parallelLights = false;
		if(isThroughParallelStepBol){
			if(parallelStepIndex == -1 && mainStepToParallelStepBol){
				parallelStepNodeIndex = this.parallelStepCode.length - 1;
				parallelLights = true;
			}
		}
		
		//主线步骤样式更改
		var elementMainArr = $("span[id^='main_span_icon_']");
		for ( var int3 = 0; int3 < mainStepNodeIndex+1; int3++) {
			var array_element3 = $(elementMainArr[int3]);
			if((mainStepNodeIndex == this.parallelStepListJson.StepNumStart - 1) && (int3 == this.parallelStepListJson.StepNumStart - 1)){
				array_element3.attr("class","t_node_trun_0");
			}else{
				var tmpClaasName = array_element3.attr("class");
				newTmpClaasName = tmpClaasName.substring(0,tmpClaasName.length - 1) + "1";
				array_element3.attr("class",newTmpClaasName);
			}
		}
		
		//并行步骤样式更改
		if(parallelStepNodeIndex != -1){
			//亮起拐弯开始处
			$(".t_turn_right_start_0").attr("class","t_turn_right_start_1");
			
			var elementParallelArr = $("span[id^='parallel_span_icon_']");
			for ( var int4 = 0; int4 < parallelStepNodeIndex+1; int4++) {
				var array_element4 = $(elementParallelArr[int4]);
				var tmpClaasName = array_element4.attr("class");
				newTmpClaasName = tmpClaasName.substring(0,tmpClaasName.length - 1) + "1";
				array_element4.attr("class",newTmpClaasName);	
			}
			//是否亮起拐角结尾处
			if(mainStepToParallelStepBol){
				$(".t_turn_right_end_0").attr("class","t_turn_right_end_1");
			}
		}
		
		//是否关闭主线与并行线相交处的亮起
		if(mainStepToParallelStepBol && parallelLights){
			var tmpStartIndex = this.parallelStepListJson.StepNumStart;
			var tmpEndIndex = this.parallelStepListJson.StepNumEnd;
			var loopNum = this.parallelStepListJson.StepNumEnd - this.parallelStepListJson.StepNumStart - 1;
			for ( var int5 = 0; int5 < loopNum; int5++) {
				var element = $("span[id='main_span_icon_"+ (tmpStartIndex + 1 + int5) +"']");
				if(element.length > 0){
					var tmpClaasName = element.attr("class");
					newTmpClaasName = tmpClaasName.substring(0,tmpClaasName.length - 1) + "0";
					element.attr("class",newTmpClaasName);					
				}
			}
			
			//改变主线与并行步骤的交叉处样式
			var element = $("span[id='main_span_icon_"+tmpStartIndex +"']");
			element.attr("class","t_node_trun_0");
			
			var element = $("span[id='main_span_icon_"+tmpEndIndex +"']");
			if(tmpEndIndex == this.mainStepListJson[this.mainStepListJson.length - 1].StepNum){
				//已经结尾
				element.attr("class","t_node_trun_1");
			}else{
				//还未结尾
				element.attr("class","t_node_trun_2");
			}
		}
	},
	/*
	 * 清理
	 */
	clear:function(){
		//删除容器中的标签
		this.topContainer.children().remove();
	},
	/*
	 * 创建事件
	 */
	createEvent:function(callFun){
		this.topContainer.find("p").live('click',function(){
			var jsonData = $(this).data("jsonData");
			var isMainStep = $(this).data("isMainStep");
			var result = jsonData;
			//判断路线问题
//			alert(jsonData + "--" + isMainStep);
            eval(callFun+"(result,isMainStep)");
        });
	}
};

/**
 * 判断是否属于json对象
 * @param obj
 * @returns {Boolean}
 */
function objIsJson(obj) {
    return typeof(obj) == "object" && Object.prototype.toString.call(obj).toLowerCase() == "[object object]" && !obj.length;
}