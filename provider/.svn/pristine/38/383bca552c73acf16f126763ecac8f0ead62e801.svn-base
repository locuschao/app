function MessagePush(){
    var intervalObj = null;
    EZ.url = '/msg/user-message/';

    /**
     * @desc 弹出消息
     * @author zhengyu
     * @date 2016-12-16 13:45:36
     * @param title
     * @param body
     * @param url
     * @param type
     */
    function showMessage(title, body, url, type){
        type = type ? type : 'MSG';
        var icon = 'http://www.eccang.com/images/notify_msg.png';

        switch (type){
            case 'MSG':
                icon = 'http://www.eccang.com/images/notify_msg.png';
                break;
            case 'WARN':
                icon = 'http://www.eccang.com/images/notify_warn_48x48.png';
                break;
            case 'PROCESS':
                icon = 'http://www.eccang.com/images/notify_process.png';
                break;
        }

        if (!("Notification" in window)) {
            console.log('This browser does not support desktop notification');
        }
        else if (Notification.permission === "granted") {
            // If it's okay let's create a notification
            var notification = new Notification(title, {
                'body': body,
                'icon': icon,
                'data': {
                    'url': url
                }
            });

            notification.onclick = function(event){
                if ('currentTarget' in event){
                    if (event.currentTarget.data.url){
                        leftMenu(Math.round(Math.random() * 1000) + 100, event.currentTarget.title, event.currentTarget.data.url);
                    }
                }else{
                    leftMenu(Math.round(Math.random() * 1000) + 100, event.explicitOriginalTarget.title, event.explicitOriginalTarget.data.url);
                }
            };

        }
        else if (Notification.permission !== 'denied') {
            Notification.requestPermission(function (permission) {
                // If the user is okay, let'    s create a notification
                if (permission === "granted") {
                    var notification = new Notification(title, {
                        'body': body,
                        'icon': icon,
                        'data': {
                            'url': url
                        }
                    });

                    notification.onclick = function(event){
                        if (event.explicitOriginalTarget.data.url){
                            window.open(event.explicitOriginalTarget.data.url);
                        }
                    };
                }
            });
        }
    }

    /**
     * @desc 轮询推送
     * @author zhengyu
     * @date 2016-12-16 13:45:59
     * @param time
     */
    function intervalPush(time){
        time = time ? time : 900000;

        _getPushMessage();

        intervalObj = setInterval(function(){
            _getPushMessage();
        }, time);
    }

    /**
     * @desc 停止轮询
     * @author zhengyu
     * @date 2016-12-16 13:46:20
     * @private
     */
    function _stopIntervalPush(){
        if (intervalObj){
            clearInterval(intervalObj);
        }
    }

    /**
     * @desc 获取消息
     * @author zhengyu
     * @date 2016-12-16 13:45:04
     * @private
     */
    function _getPushMessage(){
        $.ajax({
            type: "POST",
            async: true,
            dataType: "JSON",
            url: EZ.url + 'get-push-message',
            success: function (json) {
                if (json.state == 1) {
                    if (json.hasOwnProperty('data')){
                        if (json['data'].hasOwnProperty('MSG')){
                            _showMsgNotice(json['data']['MSG']);
                        }

                        if (json['data'].hasOwnProperty('WARN')){
                            _showWarnNotice(json['data']['WARN']);
                        }

                        if (json['data'].hasOwnProperty('PROCESS')){
                            _showProcessNotice(json['data']['PROCESS']);
                        }
                    }
                }
            }
        });
    }

    /**
     * @desc 完成推送，更新状态
     * @author zhengyu
     * @date 2016-12-16 16:28:06
     * @param umid
     * @private
     */
    function _pushFinsh(umid){
        $.ajax({
            type: "POST",
            async: false,
            dataType: "JSON",
            data: {'umId': umid},
            url: EZ.url + 'finsh-push-message',
            success: function (json) {}
        });
    }

    /**
     * @desc 弹出通知
     * @author zhengyu
     * @date 2016-12-16 13:43:37
     * @param msgInfo
     * @private
     */
    function _showMsgNotice(msgInfo){
        if (msgInfo.length > 5){
            var ids = [];

            for(var j in msgInfo){
                if (msgInfo.hasOwnProperty(j)){
                    ids.push(msgInfo[j]['um_id']);

                    _pushFinsh(msgInfo[j]['um_id']);
                }
            }

            setTimeout(function(){
                showMessage(
                    '消息通知，有新消息',
                    '点击查看全部（'+ msgInfo.length +'）条消息',
                    '/msg/user-message/list/ids/' + ids,
                    'MSG'
                );
            }, 1000);
        }else{
            for(var i in msgInfo){
                if (msgInfo.hasOwnProperty(i)){
                    _pushFinsh(msgInfo[i]['um_id']);

                    showMessage(
                        '消息通知：' + msgInfo[i]['nbm_bus_no'],
                        msgInfo[i]['um_subject'],
                        '/msg/user-message/message-details/umid/' + msgInfo[i]['um_id'],
                        'MSG'
                    );
                }
            }
        }
    }

    /**
     * @desc 弹出警告
     * @author zhengyu
     * @date 2016-12-16 13:43:58
     * @param warnInfo
     * @private
     */
    function _showWarnNotice(warnInfo){
        if (warnInfo.length > 5){
            var ids = [];

            for(var j in warnInfo){
                if (warnInfo.hasOwnProperty(j)){
                    ids.push(warnInfo[j]['um_id']);

                    _pushFinsh(warnInfo[j]['um_id']);
                }
            }

            setTimeout(function(){
                showMessage(
                    '警告通知，有新消息',
                    '点击查看全部（'+ warnInfo.length +'）条消息',
                    '/msg/user-message/list/ids/' + ids,
                    'WARN'
                );
            }, 1000);
        }else{
            for(var i in warnInfo){
                if (warnInfo.hasOwnProperty(i)){
                    _pushFinsh(warnInfo[i]['um_id']);

                    showMessage(
                        '消息通知：' + warnInfo[i]['nbm_bus_no'],
                        warnInfo[i]['um_subject'],
                        '/msg/user-message/message-details/umid/' + warnInfo[i]['um_id'],
                        'MSG'
                    );
                }
            }
        }
    }

    /**
     * @desc 弹出处理流程
     * @author zhengyu
     * @date 2016-12-16 13:44:27
     * @param processInfo
     * @private
     */
    function _showProcessNotice(processInfo){
        if (processInfo.length > 5){
            var ids = [];

            for(var j in processInfo){
                if (processInfo.hasOwnProperty(j)){
                    ids.push(processInfo[j]['um_id']);

                    _pushFinsh(processInfo[j]['um_id']);
                }
            }

            setTimeout(function(){
                showMessage(
                    '工作流程，有新消息',
                    '点击查看全部（'+ processInfo.length +'）条消息',
                    '/msg/user-message/list/ids/' + ids,
                    'WARN'
                );
            }, 1000);
        }else{
            for(var i in processInfo){
                if (processInfo.hasOwnProperty(i)){
                    _pushFinsh(processInfo[i]['um_id']);

                    showMessage(
                        '工作流程：' + processInfo[i]['nbm_bus_no'],
                        processInfo[i]['um_subject'],
                        '/msg/user-message/message-details/umid/' + processInfo[i]['um_id'],
                        'PROCESS'
                    );
                }
            }
        }
    }

    /**
     * @desc 测试浏览器是否支持消息推送
     * @author Zijie Yuan
     * @date 2016-12-16 15:34
     * @param processInfo
     * @private
     */
    function testMessage() {
        var result = {state:2};
        if (!("Notification" in window)) {
            result.state = 0;
        }else if (Notification.permission == 'granted') {
            showMessage('通知测试', '通知测试', '', 'MSG');
            result.state = 1;
        }
        return result;
    }

    return {
        'testMessage': testMessage,
        'showMessage': showMessage,
        'intervalPush': intervalPush
    };
}