<script type="text/javascript">
    EZ.userId='<{$userCode}>';
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
    function headMenu(id, title, url,obj) {

    }
    $(function() {
        $('.nav_menu').hover(function() {
            var self = $(this);
            self.find('ul').show();
        }, function() {
            var self = $(this);
            self.find('ul').hide();
        })
    })
</script>

<style>
    .sub_menu {
        display: none;
        width: 100px;
        margin-left: -20px;
        font-size: 10px;
        background-color: #FFF;
        border: solid 1px #ccc;
        border-top: none;
    }

    .sub_menu > li {
        padding: 8px 0 5px 5px;
    }

    .sub_menu > li > a {
        text-align: left;
    }
</style>

<div class="wrapper">
    <header class="main-header">
        <div class="pull-left header-logo">
            <img src="images/logo/logo.png" alt="">
        </div>
        <div class="pull-right header-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown nav-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <{$userName}><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" onclick="leftMenu('user_set_1024','个人设置','/user/user/user-set')">
                                <i class="fa fa-pencil"></i>
                                <span>账户资料设置</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- <li class="nav-menu">
                    <a href="#" data-toggle="control-sidebar">
                        <i class="fa fa-envelope"></i>
                        <span class="badge">5</span>
                    </a>
                </li> -->
                <li class="nav-menu">
                    <a href="/default/index/logout" data-toggle="control-sidebar">
                        <i class="fa fa-sign-out"></i>
                        <span>退出</span>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <!--aside-->
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
            <{foreach from=$menu key=key item=submenu1}>
                <{foreach from=$submenu1.item name=submenu item=submenu key=kk}>
                    <{if isset($submenu.item)}>
                        <li class="treeview">
                            <a href="#">
                                <b class="fa fa-<{$submenu.src}>"></b>
                                <span><{$submenu.title}></span>
                                <i class="fa fa-angle-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <{foreach from=$submenu.item name=sub item=sub key=sm}>
                                    <li><a href="javascript:void(0);" class="sub-menu-id-<{$sm}>" onclick="leftMenu('<{$kk}><{$sm}>','<{$sub.title}>','<{$sub.url}>')"><{$sub.title}></a></li>
                                    <!-- <li><a href="javascript:void(0);" class="sub-menu-id-<{$sm}>" onclick="leftMenu('<{$kk}><{$sm}>','<{$sub.title}>','<{$sub.url}>')"><{$sub.title}></a></li> -->
                                <{/foreach}>
                            </ul>
                        </li>
                    <{else}>
                        <li class="treeview">
                            <a href="javascript:void(0);" class="sub-menu-id-<{$kk}>" onclick="leftMenu('<{$kk}>','<{$submenu.title}>','<{$submenu.url}>')">
                                <b class="fa fa-<{$submenu.src}>"></b>
                                <span><{$submenu.title}></span>
                            </a>
                        </li>
                    <{/if}>
                <{/foreach}>
            <{/foreach}>
            </ul>
        </section>
    </aside>

    <footer class="main-footer">
        <div><strong>Copyright &copy; 2017 <a href="#">深圳易仓科技有限公司</a>. </strong>All rights reserved.</div>
    </footer>

    <!--伸缩侧边栏的按钮-->
    <div class="toggle-navbar" id="toggle-navbar">
        <i class="fa fa-angle-double-left"></i>
    </div>
</div>

<script type="text/javascript">
    $(function () {
    // 点击侧边栏导航条，添加active状态
    $(".treeview").on("click",function () {
        if(!$(this).hasClass("active")){
            $(".treeview.active").removeClass("active");
        }
        $(this).toggleClass("active");
    })
    
    // 点击子菜单防止冒泡
    $(".treeview-menu").on("click",function (e) {
        e = e || window.event;
        e.stopPropagation();
    })
    // 收缩或展开侧边栏
    $("#toggle-navbar").on("click",function () {
        $(".main-sidebar").toggleClass("toggle-sidebar");
        $(this).toggleClass("toggle-sidebar");
        $("#main-container").toggleClass("toggle-sidebar");
    })

    // 按钮组的点击状态
    $(".labels-group>.button").on("click",function () {
        $(".labels-group>.button.clicked").removeClass("clicked");
        $(this).addClass("clicked");
    })


    //模态框的展示
    //$('#messModal').modal();

})
</script>