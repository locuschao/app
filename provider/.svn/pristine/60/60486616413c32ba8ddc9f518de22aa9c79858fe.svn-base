
jQuery.fn.pagination=function(maxentries,opts){opts=jQuery.extend({first_text:"First",prev_text:"< Previous",next_text:"Next >",last_text:"Last",ellipse_text:"...",perpage_text:'PerPage',total_text:'Total',items_per_page:10,num_display_entries:10,num_edge_entries:0,current_page:0,link_to:"#",prev_show_always:true,next_show_always:true,changePageSizeFunc:'onchange="changePageSize(this)"',callback:function(){return false;}},opts||{});return this.each(function(){function numPages(){return Math.ceil(maxentries/opts.items_per_page);}
    function getInterval(){var ne_half=Math.ceil(opts.num_display_entries/2);var np=numPages();var upper_limit=np-opts.num_display_entries;var start=current_page>ne_half?Math.max(Math.min(current_page-ne_half,upper_limit),0):0;var end=current_page>ne_half?Math.min(current_page+ne_half,np):Math.min(opts.num_display_entries,np);return[start,end];}
    function pageSelected(page_id,evt){current_page=page_id;drawLinks();var continuePropagation=opts.callback(page_id,panel);if(!continuePropagation){if(evt.stopPropagation){evt.stopPropagation();}
    else{evt.cancelBubble=true;}}
        return continuePropagation;}
    function drawLinks(){panel.empty();var interval=getInterval();var np=numPages();var getClickHandler=function(page_id){return function(evt){pageSelected(page_id,evt);return false;}}
        var appendItem=function(page_id,appendopts){page_id=page_id<0?0:(page_id<np?page_id:np-1);appendopts=jQuery.extend({text:page_id+1,classes:""},appendopts||{});if(page_id==current_page||maxentries==0){var lnk=$("<span class='current'>"+(appendopts.text)+"</span>");}
        else
        {var lnk=$("<a>"+(appendopts.text)+"</a>").bind("click",getClickHandler(page_id)).attr('href',opts.link_to.replace(/__id__/,page_id));}
            if(appendopts.classes){lnk.addClass(appendopts.classes);}
            panel.append(lnk);}
        if(opts.first_text&&(current_page>0||opts.prev_show_always)){appendItem(0,{text:opts.first_text,classes:"prev"});}
        if(opts.prev_text&&(current_page>0||opts.prev_show_always)){appendItem(current_page-1,{text:opts.prev_text,classes:"prev"});}
        if(interval[0]>0&&opts.num_edge_entries>0)
        {var end=Math.min(opts.num_edge_entries,interval[0]);for(var i=0;i<end;i++){appendItem(i);}
            if(opts.num_edge_entries<interval[0]&&opts.ellipse_text)
            {jQuery("<span>"+opts.ellipse_text+"</span>").appendTo(panel);}}
        for(var i=interval[0];i<interval[1];i++){appendItem(i);}
        if(interval[1]<np&&opts.num_edge_entries>0)
        {if(np-opts.num_edge_entries>interval[1]&&opts.ellipse_text)
        {jQuery("<span>"+opts.ellipse_text+"</span>").appendTo(panel);}
            var begin=Math.max(np-opts.num_edge_entries,interval[1]);for(var i=begin;i<np;i++){appendItem(i);}}
        if(opts.next_text&&(current_page<np-1||opts.next_show_always)){appendItem(current_page+1,{text:opts.next_text,classes:"next"});}
        if(opts.last_text&&(current_page<np-1||opts.next_show_always)){appendItem(np-1,{text:opts.last_text,classes:"next"});}
        onlyNum=function(event){if(!(event.keyCode==46)&&!(event.keyCode==8)&&!(event.keyCode==37)&&!(event.keyCode==39))
        {if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105)))
        {event.returnValue=false;return false;}}};var pageSizeStr='<label>'+opts.perpage_text+'&nbsp;<input type="text" id="pageSize" value="'+opts.items_per_page+'"';pageSizeStr+=' style="width:25px;text-align:center;height:13px;line-height:13px;ime-mode:Disabled;" '+opts.changePageSizeFunc+' onKeydown="return onlyNum(event)"/>&nbsp;</label>';jQuery(pageSizeStr).appendTo(panel);var total='<label style="margin-left:5px;">'+opts.total_text+'<span style="font-weight:bold;">'+maxentries+'</span></label>';jQuery(total).appendTo(panel);}
    var current_page=opts.current_page;maxentries=(!maxentries||maxentries<0)?0:maxentries;opts.items_per_page=(!opts.items_per_page||opts.items_per_page<0)?1:opts.items_per_page;var panel=jQuery(this);this.selectPage=function(page_id){pageSelected(page_id);}
    this.prevPage=function(){if(current_page>0){pageSelected(current_page-1);return true;}
    else{return false;}};this.nextPage=function(){if(current_page<numPages()-1){pageSelected(current_page+1);return true;}
    else{return false;}};drawLinks();});};function pageselectCallback(page_id,jq){paginationCurrentPage=page_id+1;initData(page_id);}
function changePageSize(obj){paginationPageSize=$(obj).val();if(paginationPageSize<=0){paginationPageSize=20;}
    if(Math.ceil(paginationTotal/paginationPageSize)<=paginationCurrentPage){paginationCurrentPage=Math.ceil(paginationTotal/paginationPageSize);}
    if(paginationCurrentPage==0){paginationCurrentPage=1;}
    initData(paginationCurrentPage-1);}
function initData(pageIndex){var curPage=pageIndex;if(typeof(paginationTotal)!='undefined'){if(Math.ceil(paginationTotal/paginationPageSize)<=paginationCurrentPage){paginationCurrentPage=Math.ceil(paginationTotal/paginationPageSize);pageIndex=paginationCurrentPage-1;}}else{$(".pagination").html('');paginationPageSize=0;}
    if(curPage<1){pageIndex=0;paginationCurrentPage=1;}
    loadData(pageIndex+1,paginationPageSize);if(paginationTotal<1){$(".pagination").html('');return;}
    if(pageIndex<0){pageIndex=0;}
    $(".pagination").pagination(paginationTotal,{callback:pageselectCallback,items_per_page:paginationPageSize,num_display_entries:6,current_page:pageIndex,num_edge_entries:2});}
function handInitData(pageIndex,paginationTotal,paginationPageSize){var curPage=pageIndex;if(typeof(paginationTotal)!='undefined'){if(Math.ceil(paginationTotal/paginationPageSize)<=paginationCurrentPage){paginationCurrentPage=Math.ceil(paginationTotal/paginationPageSize);pageIndex=paginationCurrentPage-1;}}else{$(".pagination").html('');paginationPageSize=0;}
    if(curPage<1){pageIndex=0;paginationCurrentPage=1;}
    if(paginationTotal<1){$(".pagination").html('');return;}
    if(pageIndex<0){pageIndex=0;}
    $(".pagination").pagination(paginationTotal,{callback:pageselectCallback,items_per_page:paginationPageSize,num_display_entries:6,current_page:pageIndex,num_edge_entries:2});}