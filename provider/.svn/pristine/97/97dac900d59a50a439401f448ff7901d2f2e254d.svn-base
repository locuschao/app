
function pageselectCallback2(page_id,jq){customCurrentPage=page_id+1;initData2(page_id);}
function changePageSize2(obj){customPageSize=$(obj).val();if(customPageSize<=0){customPageSize=20;}
    if(Math.ceil(customTotal/customPageSize)<=customCurrentPage){customCurrentPage=Math.ceil(customTotal/customPageSize);}
    if(customCurrentPage==0){customCurrentPage=1;}
    initData2(customCurrentPage-1);}
function initData2(pageIndex){var customPagination=$(_customPagination);var curPage=pageIndex;if(typeof(customTotal)!='undefined'){if(Math.ceil(customTotal/customPageSize)<=customCurrentPage){customCurrentPage=Math.ceil(customTotal/customPageSize);pageIndex=customCurrentPage-1;}}else{customPagination.html('');customPageSize=0;}
    if(curPage<1){pageIndex=0;customCurrentPage=1;}
    loadData2(pageIndex+1,customPageSize);if(customTotal<1){customPagination.html('');return;}
    if(pageIndex<0){pageIndex=0;}
    customPagination.pagination(customTotal,{callback:pageselectCallback2,items_per_page:customPageSize,num_display_entries:6,current_page:pageIndex,num_edge_entries:2,changePageSizeFunc:'onchange="changePageSize2(this)"'});}