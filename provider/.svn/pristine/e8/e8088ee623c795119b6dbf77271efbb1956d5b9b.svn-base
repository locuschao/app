<div id="sidebarIcon" style="display: none;">
    <div class="categoryicon" style="text-align: center;padding-top:8px; font-size: 12px;    font-weight: bold;">
        <a href="#">
            <img src="/images/sidebar/icon_tab.png" align="absmiddle" alt="切换系统"/>
        </a>
    </div>
    <div class="menuicon">
        <{foreach from=$menu item=submenu}>
        <dl onmouseover="showThisSubMenu(this,'menuicon<{$submenu.menu.um_id}>')"
            onmouseout="closeThisSubMenu(this,'menuicon<{$submenu.menu.um_id}>')">
            <dt id="test">
                <a href="javascript:void(0)" style="width: 100%">
                    <img src="/images/sidebar/<{$submenu.menu.um_css}>" align="absmiddle"/>
                </a>
            </dt>
            <div class="submenu" id="menuicon<{$submenu.menu.um_id}>">
                <div class="submenu_cover"></div>
                <{foreach from=$submenu.item name=submenu item=sub}>
        <{if $smarty.foreach.submenu.first}>
        <ul>
        <{else}>
        <{if $smarty.foreach.submenu.index%2==0}>
        </ul> <ul>
        <{/if}>
        <{/if}>
        <{if $smarty.foreach.submenu.last}>
        <li class="noline">
        <{else}>
        <{if $smarty.foreach.submenu.index%2==0}>
        <li>
            <{else}>
        <li class="noline">
        <{/if}>
        <{/if}>
        <a href="javascript:void(0);" onclick="leftMenu('<{$sub.ur_id}>','<{$sub.value}>','<{$sub.ur_url}>?quick=<{$sub.ur_id}>')"><{$sub.value}></a>
        </li>
        <{if $smarty.foreach.submenu.last}>
        </ul>
        <{/if}>
        <{/foreach}>
    </div>
</dl>
        <{/foreach}>
    </div>
    <div class="menuiconquit">
        <a href="/default/index/logout"><img src="/images/sidebar/logout.png" align="absmiddle"/>退出</a>
    </div>
</div>

<div id="sidebar">
    <div class="category">
        <div class="category_down">
            <a href="#"></a>
        </div>
        <div class="category_text">仓储系统</div>
        <div class="category_up"></div>
    </div>
    <div class="menu" id="menu-module">
        <{foreach from=$menu item=submenu}>
        <dl>
            <dt class="sub-menu" state='1'>
                <img src="/images/sidebar/<{$submenu.menu.um_css}>" align="absmiddle"/><{$submenu.menu.value}>
            </dt>
            <{foreach from=$submenu.item name=submenu item=sub}>
            <{if $smarty.foreach.submenu.last}>
            <dd style="padding-bottom: 10px;">
                <{else}>
            <dd>
            <{/if}>
            <a href="javascript:void(0);" class="sub-menu-id-<{$sub.ur_id}>"
               onclick="leftMenu('<{$sub.ur_id}>','<{$sub.value}>','<{$sub.ur_url}>?quick=<{$sub.ur_id}>')"><{$sub.value}></a></dd>
            <{/foreach}>
        </dl>
        <{/foreach}>
    </div>
    <div class="quit">
        <a style="padding-bottom: 1px" href="/default/index/logout">
            <img src="/images/sidebar/logout.png" align="absmiddle"/>&nbsp;&nbsp;退出</a>
    </div>
</div>