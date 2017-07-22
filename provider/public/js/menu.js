function showThisSubMenuHeader(obj,id){
    var mLeft=$(obj).children().position().left;
    $("#"+id).css("left",mLeft-1);
    $("#"+id).show();
    $(obj).children("li").addClass("headNavA");
    $(obj).children("li").children("a").css("color","#0090E1");
}
function closeThisSubMenuHeader(obj,id){
    $(obj).children("li").removeClass("headNavA");
    $(obj).children("li").children("a").css("color","#fff");
    $("#"+id).hide();
}
function headMenu(id, title, url,obj) {}