<link rel="stylesheet" type="text/css" href="/css/msg/write_letter.css?201611081534">
<link rel="stylesheet" type="text/css" href="/css/zTreeStyle/zTreeStyle.css?201611081533">

<div id="module-container" class="module-container">
    <div class="message-div" id="message-div">
        <table class="write-table-message">
            <tbody>
                <tr>
                    <td width="10%" class="title">消息类型</td>
                    <td>
                        <select name="E4" id="E4" class="input_text2 w100">
                            <{foreach from=$messageTypeArr item=val key=key}>
                                <option value="<{$key}>" <{if $reward neq 0 && $key eq 'USER'}>disabled<{/if}>><{$val}></option>
                            <{/foreach}>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="title"><a href="#" id="select-receiver">收件人</a></td>
                    <td>
                        <div class="div-text" id="receiver-text">
                            <div class="user-text" id="user-text">
                                <input title="收件人" type="text" value="">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="title"><a href="#" id="select-cc">抄送</a></td>
                    <td>
                        <div class="div-text" id="cc-text">
                            <div class="user-text" id="cc-user-text">
                                <input type="text">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="title">主题</td>
                    <td><input type="text" class="w100 input_text" style="padding:0;" name="E5" id="E5" value="<{if $msg}>转发：<{$msg['um_subject']|replace:'转发：':''}><{/if}>"></td>
                </tr>
                <tr>
                    <td class="title">正文</td>
                    <td>
                        <textarea class="eheditor-simple w100 input_text" id="message-editor">
                            <{if $msgInfos}>
                            <br/><br/><br/><br/><br/><br/>
                            <{foreach from=$msgInfos item=msgItem}>
                                ------------------ 原始消息 ------------------
                                <br/>发信人: "<{$msgItem['send_user_name']}>"< <{$msgItem['receive_user_code']}> >
                                <br/>发送时间:<{$msgItem['um_create_time']}>
                                <br/>收信人:
                                <{foreach from=$msgItem['user_name'] item=msgItemUser}>
                                    <{if $msgItemUser['user_name'] != ''}>
                                        "<{$msgItemUser['user_name']}>"< <{$msgItemUser['user_code']}> >;
                                    <{/if}>
                                <{/foreach}>
                                <br/>抄送:
                                <{foreach from=$msgItem['cc_user_name'] item=msgItemUser}>
                                    <{if $msgItemUser['user_name'] != ''}>
                                        "<{$msgItemUser['user_name']}>"< <{$msgItemUser['user_code']}> >;
                                    <{/if}>
                                <{/foreach}>
                                <br/>主题: <{$msgItem['um_subject']|replace:'转发：':''}>
                                <br/><br/><{$msgItem['mnc_content']}><br/><br/>

                            <{/foreach}>
                            <{/if}>
                        </textarea>
                        <input type="hidden" id="E1" value="<{if $rewardId}><{$rewardId}><{/if}>">
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="btn-div">
            <button type="button" id="message-send">发送</button>
            <button type="button" id="message-cancel">取消</button>
        </div>
    </div>
    <div class="flow-div" id="flow-div">
        <table class="write-table-message">
            <tbody>
                <tr>
                    <td width="10%" class="title">消息类型</td>
                    <td>
                        <select name="E4" id="flow-E4" class="input_text2 w100">
                            <{foreach from=$messageTypeArr item=val key=key}>
                                <option value="<{$key}>"><{$val}></option>
                            <{/foreach}>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="title">通知业务</td>
                    <td>
                        <input type="text" class="w50 input_text" name="" id="business" data-businessid="">
                        <a href="javascript:void(0);" id="select-business">选择</a>
                    </td>
                </tr>
                <tr>
                    <td class="node-td" colspan="2">
                        <div id="node-div" class="node-div">
                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="title">主题</td>
                    <td><input type="text" class="w100 input_text" style="padding:0;" name="" id="flow-E5" value="<{if $msg}>转发：<{$msg['um_subject']|replace:'转发：':''}><{/if}>"></td>
                </tr>
                <tr>
                    <td class="title">正文</td>
                    <td><textarea class="eheditor-simple w100" id="flow-editor"></textarea></td>
                </tr>
            </tbody>
        </table>
        <div class="btn-div">
            <button type="button" class="btnBase" id="flow-send">发送</button>
            <button type="button" class="btnBase" id="flow-cancel">取消</button>
        </div>
    </div>
</div>

<script type="text/javascript" src="/js/modules/msg/extFn.js?201611081630"></script>
<script type="text/javascript" src="/js/xheditor-1.2.2/xheditor-1.2.2.min.js?201611081630"></script>
<script type="text/javascript" src="/js/ztree.3.5.26/jquery.ztree.all.min.js?201611091020"></script>
<script type="text/javascript" src="/js/modules/msg/writeLetter.js?201611081631"></script>
<script type="text/javascript">
    /*EZ.url = '/msg/user-message/';
    EZ.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html += "<td class='ec-center'>" + (i++) + "</td>";
            html += "<td>" + val.E4 + "</td>";
            html += "<td>" + val.E6 + "</td>";
            html += "<td>" + val.E7 + "</td>";
            html += "<td>" + val.E8 + "</td>";
            html += "<td>" + val.E10 + "</td>";
            html += "<td>" + val.E11 + "</td>";
            html += "<td><a href=\"javascript:editById(" + val.E0 + ")\">" + EZ.edit + "</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"javascript:deleteById(" + val.E0 + ")\">" + EZ.del + "</a></td>";
            html += "</tr>";
        });
        return html;
    }*/
    $(function () {
        var writeLetter = new WriteLetter();
        writeLetter.init();

        writeLetter.setMessageUnReadTotal('<{$messageUnReadTotal}>', '#messageUnReadTotal');
    });
</script>
