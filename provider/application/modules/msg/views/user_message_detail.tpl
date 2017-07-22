<link rel="stylesheet" type="text/css" href="/css/msg/message_details.css?201611081534">
<link rel="stylesheet" type="text/css" href="/css/ystep.css?201611071736">
<div id="module-container" class="module-container" data-umid="<{$messages.E0}>">
    <div class="op-div">
        <div class="btn-group">
            <a class="btn-gray" href="/msg/user-message/list"><< 返回</a>
            <input type="button" class="btn-sepline">
            <a class="btn-gray" href="#" hidefocus>回复</a>
            <a class="btn-gray" href="/msg/user-message/write-letter/reward/<{$messages.E0}>">转发</a>
            <{if $messages.E4 eq "USER"}>
                <a class="btn-gray btn-pass">确认/通过</a>
            <{else}>
            <{/if}>
            <select name="" id="" class="mark">
                <option value="">标记为</option>
                <{foreach from=$noticeTypes item=val key=key}>
                    <optgroup label="－－－－">
                    <{foreach from=$val item=v key=k}>
                        <option value="<{$k}>"><{$v}></option>
                    <{/foreach}>
                    </optgroup>
                <{/foreach}>
            </select>
        </div>
        <div class="message-page">
            <a href="<{if $messages.G1 eq null}>javascript:void(0);<{else}>/msg/user-message/message-details/umid/<{$messages.G1}><{/if}>" class="<{if $messages.G1 eq null}>non-click<{else}><{/if}>">上一封</a>
            <a href="<{if $messages.G2 eq null}>javascript:void(0);<{else}>/msg/user-message/message-details/umid/<{$messages.G2}><{/if}>" class="<{if $messages.G2 eq null}>non-click<{else}><{/if}>">下一封</a>
        </div>
    </div>
    <div class="read-mail-info">
        <div class="info-div">
            <table>
                <tbody>
                    <tr>
                        <td colspan="2" class="title">
                            <span class="title-span">
                                <{$messages.E5}>
                            </span>
                            <span id="star" class="<{if $messages.E9 eq 1}>star<{else}>unstar<{/if}>"></span>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="15%" class="td-title">消息类型：</td>
                        <td class="">
                            <{if $messages.E4 eq "SYSTEM"}>
                                消息
                            <{else}>
                               流程 <a href="javascript:void(0);" title="流程详情" class="flow-name" id="flow-name"><<{$messages.EF14}>></a>
                            <{/if}>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%" class="td-title">发&nbsp件&nbsp人：</td>
                        <td class="">
                            <{$messages.EF5}><
                            <{$messages.EF9}>>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%" class="td-title">时&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp间：</td>
                        <td class=""><{$messages.E10|date_format:"%Y-%m-%d %H:%M"}></td>
                    </tr>
                    <tr>
                        <td width="15%" class="td-title">收 件 人：</td>
                        <td class="">
                            <{$messages.EF10}><
                            <{$messages.EF11}>>
                        </td>
                    </tr>
                    <tr>
                        <{if $messages.cc != null}>
                            <td width="15%" class="td-title">抄&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp送：</td>
                            <td class="">
                                <{foreach from=$messages.cc item=val key=key}>
                                   <{$val.EF1}><
                                   <{$val.EF13}>>;
                                <{/foreach}>
                            </td>
                        <{/if}>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="middle-div erp-no-div">
        <div class="middle-div-head erp-no-div-head">
            <img src="/images/base/arrow-down.png" class="flow-op" id="erp-no-down"></img>
            <img src="/images/base/arrow-up.png" class="flow-op down" id="erp-no-up"></img>
        </div>
        <div class="process" id="erp-no">
            <span class="erp-no-title">业务单号：</span>
            <span class="erp-no-text"><{$messages.EF15}></span>
        </div>
    </div>
    <{if $messages.flow neq ''}>
        <div class="middle-div flow-div">
            <div class="middle-div-head flow-div-head">
                <img src="/images/base/arrow-down.png" class="flow-op" id="flow-down"></img>
                <img src="/images/base/arrow-up.png" class="flow-op down" id="flow-up"></img>
            </div>
            <div class="process" id="process">
                
            </div>
        </div>
    <{/if}>
    <div class="content-div">
        <div class="mail-content-container">
            <{$messages.EF12}>
        </div>
    </div>
    <div class="tool-bar">
        <div class="btn-group">
            <a class="btn-gray" href="/msg/user-message/list"><< 返回</a>
            <input type="button" class="btn-sepline">
            <a class="btn-gray" href="#" hidefocus>回复</a>
            <a class="btn-gray" href="/msg/user-message/write-letter/reward/<{$messages.E0}>">转发</a>
            <{if $messages.E4 eq "USER"}>
                <a class="btn-gray btn-pass">确认/通过</a>
            <{else}>
            <{/if}>
            <select name="" id="" class="mark">
                <option value="">标记为</option>
                <{foreach from=$noticeTypes item=val key=key}>
                    <optgroup label="－－－－">
                    <{foreach from=$val item=v key=k}>
                        <option value="<{$k}>"><{$v}></option>
                    <{/foreach}>
                    </optgroup>
                <{/foreach}>
            </select>
        </div>
        <div class="message-page">
            <a href="<{if $messages.G1 eq null}>javascript:void(0);<{else}>/msg/user-message/message-details/umid/<{$messages.G1}><{/if}>" class="<{if $messages.G1 eq null}>non-click<{else}><{/if}>">上一封</a>
            <a href="<{if $messages.G2 eq null}>javascript:void(0);<{else}>/msg/user-message/message-details/umid/<{$messages.G2}><{/if}>" class="<{if $messages.G2 eq null}>non-click<{else}><{/if}>">下一封</a>
        </div>
    </div>
</div>

<script type="text/javascript" src="/js/modules/msg/extFn.js?201611081630"></script>
<script type="text/javascript" src="/js/ystep.js?201611071736"></script>
<script type="text/javascript" src="/js/modules/msg/userMessageDetails.js?201611081631"></script>
<script type="text/javascript">
    $(function() {
        var messageDetails = new MessageDetails();
        messageDetails.init();

        messageDetails.setMessageUnReadTotal('<{$messageUnReadTotal}>', '#messageUnReadTotal');
        messageDetails.initFlowData(<{if $messages.flow neq null}><{$messages.flow}><{else}>{}<{/if}>);
        messageDetails.flowDetails();
    })
</script>
