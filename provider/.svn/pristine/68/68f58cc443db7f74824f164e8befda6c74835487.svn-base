function NoticeMessageList(){
    var body = 'body';

    function init(){
        initEvn();

        //绑定星标点击事件
        bindStartEven();
        //绑定转发、全部已读、标记为等按钮事件
        bindBtnEven();
        //绑定读取信息的按钮
        bindReadBtn();
        // 绑定设置桌面通知点击事件
        openSetWindowsInform();
    }

    /**
     * @desc 初始化环境
     * @author zhengyu
     * @date 2016-11-14 11:27:57
     */
    function initEvn() {
        EZ.url = '/msg/user-message/';
        EZ.getListData = function (json) {
            var html = [];
            var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
            $.each(json.data, function (key, val) {
                html.push(((key + 1) % 2 == 1 ? '<tr class="table-module-b1">' : '<tr class="table-module-b2">'));
                html.push('<td><input class="check-item" type="checkbox" value="'+val['E0']+'" /></td>');
                html.push('<td class="send-user-name">' + val['EF1'] + '</td>');
                html.push('<td class="align-left code">' + (val['EF8'] ? val['EF8'] : '--') + '<br>' + (val['EF7'] ? val['EF7'] : '--') + '</td>');
                html.push('<td class="align-left msg-subject"><span id="ico-read-'+ val['E0'] +'" class="ico-read '+ (val['E8'] == '0' ? 'unread' : 'read') +'" data-val="'+val['E0']+'"></span>');
                html.push('<a class="read-item" href="javascript:void(0);" data-val="'+val['E0']+'">' + val['E5'] + '</a></td>');
                html.push('<td class="create-time">' + val['E10'] + '</td>');
                html.push('<td class="opt-td"><span id="ico-start-'+ val['E0'] +'" class="'+ (val['E9'] == '0' ? 'unstart' : 'start') +'" data-val="'+ val['E0'] +'"></span></td>');
                html.push('</tr>');
            });

            if (json.config) {
                var windowInform = $('#windows-inform'),
                    informText = $('#inform-text');
                windowInform.data('msg', json.config.msg);
                windowInform.data('warn', json.config.warn);
                windowInform.data('process', json.config.process);
                if (json.config.msg || json.config.warn || json.config.process) {
                    informText.addClass('ok');
                }else {
                    informText.addClass('remove');
                }
            }
            return html.join(''); 
        };

        //全局方法,搜索所有的信息
        submitSearch();

        //checkbox联动
        linkage('#check-all', '.check-item');
    }

    /**
     * @desc 绑定星标点击事件
     * @author zhengyu
     * @date 2016-11-14 15:28:21
     */
    function bindStartEven(){
        $(body).on('click', '.start', function(){
            _startMsg(false, $(this).data('val'));
        });


        $(body).on('click', '.unstart', function(){
            _startMsg(true, $(this).data('val'));
        });
    }

    /**
     * @desc 设置星标
     * @author zhengyu
     * @date 2016-11-14 15:38:29
     * @param isStart
     * @param id
     * @private
     */
    function _startMsg(isStart, id){
        $.ajax({
            type: "post",
            async: false,
            dataType: "json",
            url: EZ.url + 'set-start',
            data: {'paramId': id, 'start': (isStart ? 1 : 0)},
            success: function (json) {
                if (json.state == 1) {
                    if (typeof id == 'number' || typeof id == 'string'){
                        if (isStart){
                            $(body).find('#ico-start-'+id).removeClass('unstart').addClass('start');
                        }else{
                            $(body).find('#ico-start-'+id).removeClass('start').addClass('unstart');
                        }
                    }else{
                        //遍历数组
                        for (var i in id){
                            if (id.hasOwnProperty(i)){
                                if (isStart){
                                    $(body).find('#ico-start-'+id[i]).removeClass('unstart').addClass('start');
                                }else{
                                    $(body).find('#ico-start-'+id[i]).removeClass('start').addClass('unstart');
                                }
                            }
                        }
                    }
                } else {
                    alertTip(json.message);
                }
            }
        });
    }

    /**
     * @desc 绑定转发、全部已读、标记为等按钮事件
     * @author zhengyu
     * @date 2016-11-15 10:50:42
     */
    function bindBtnEven(){
        //转发
        $(body).on('click', '#fw-mail-btn', function(){
            var checkIds = _getCheckItem();

            if (checkIds.length == 1){
                window.location.href = '/msg/user-message/write-letter/reward/' + checkIds.pop();
            }else{
                alertTip('请选择一条信息进行转发');
            }
        });

        //全部已读
        $(body).on('click', '#all-read-btn', function(){
            $.ajax({
                type: "post",
                async: false,
                dataType: "json",
                url: EZ.url + 'set-read',
                data: {'paramId': 'all', 'read': 1},
                success: function (json) {
                    if (json.state == 1) {
                        window.location.reload();
                    } else {
                        alertTip(json.message);
                    }
                }
            });
        });

        //标记
        $(body).on('change', '#mark-select', function(){
            var changeItem = $(this).val(),
                checkIds = _getCheckItem();

            if (checkIds.length > 0){
                switch (changeItem){
                    case 'read':
                        _readMessage(true, checkIds);
                        break;
                    case 'unread':
                        _readMessage(false, checkIds);
                        break;
                    case 'start':
                        _startMsg(true, checkIds);
                        break;
                    case 'unstart':
                        _startMsg(false, checkIds);
                        break;
                }
            }

            $(this).find('option:eq(0)').attr('selected', 'selected');

            submitSearch();

            setMessageUnReadTotal(_getUnReadCount(), '#messageUnReadTotal');
        });
    }

    /**
     * @desc 获取已选择的信息id
     * @author zhengyu
     * @date 2016-11-15 11:03:18
     * @returns {Array}
     * @private
     */
    function _getCheckItem(){
        var checkArr = [];

        $(body).find('.check-item:checked').each(function(){
            checkArr.push(parseInt($(this).val()));
        });

        return checkArr;
    }

    /**
     * @desc 设置信息已读
     * @author zhengyu
     * @date 2016-11-15 11:31:10
     * @param isRead
     * @param id
     * @private
     */
    function _readMessage(isRead, id){
        $.ajax({
            type: "post",
            async: false,
            dataType: "json",
            url: EZ.url + 'set-read',
            data: {'paramId': id, 'read': (isRead ? 1 : 0)},
            success: function (json) {
                if (json.state == 1) {
                    if (typeof id == 'number' || typeof id == 'string'){
                        if (isRead){
                            $(body).find('#ico-read-'+id).removeClass('unread').addClass('read');
                        }else{
                            $(body).find('#ico-read-'+id).removeClass('read').addClass('unread');
                        }
                    }else{
                        //遍历数组
                        for (var i in id){
                            if (id.hasOwnProperty(i)){
                                if (isRead){
                                    $(body).find('#ico-read-'+id[i]).removeClass('unread').addClass('read');
                                }else{
                                    $(body).find('#ico-read-'+id[i]).removeClass('read').addClass('unread');
                                }
                            }
                        }
                    }
                } else {
                    alertTip(json.message);
                }
            }
        });
    }

    /**
     * @desc 获取未读信息数
     * @author zhengyu
     * @date 2016-11-15 14:19:39
     * @returns {number}
     * @private
     */
    function _getUnReadCount(){
        var count = 0;

        $.ajax({
            type: "post",
            async: false,
            dataType: "json",
            url: EZ.url + 'get-msg-unread',
            success: function (json) {
                if (json.state == 1) {
                    count = json.data;
                } else {
                    alertTip(json.message);
                }
            }
        });

        return count;
    }

    /**
     * @desc 绑定读取信息按钮
     * @author zhengyu
     * @date 2016-11-17 11:03:08
     */
    function bindReadBtn(){
        $(body).on('click', '.read-item', function(){
            window.location.href = '/msg/user-message/message-details/umid/' + $(this).data('val');
        });

        $(body).on('click', '.ico-read', function () {
            var self = $(this),
                umId = self.data('val'),
                title = self.next().text(),
                url = '/msg/user-message/message-details/umid/' + umId;

            leftMenu(umId, title, url);
        })
    }

    /**
     * @desc 设置未读消息数
     * @author zhengyu
     * @date 2016-11-14 11:26:53
     * @param totalNum
     * @param totalId
     */
    function setMessageUnReadTotal(totalNum, totalId){
        totalNum = parseInt(totalNum);
        if (totalNum > 0){
            $(totalId).html('(' + totalNum + ')');
        }
    }

    /**
     * @desc 设置桌面通知弹窗
     * @author Zijie Yuan
     * @date 2016-12-15 11:26:53
     */
    var openSetWindowsInform = function() {
        $('#windows-inform').on('click', function() {
            var windows = generateSetDiv();
            $(windows).EzWmsEditDataDialogX({
                dTitle:'测试浏览器支持',
                editUrl: '/msg/user-message/set-message',
            });
            setInform();
            testInform();
        })
    }

    /**
     * @desc 生成设置桌面通知弹窗
     * @author Zijie Yuan
     * @date 2016-12-15 11:26:53
     */
    var generateSetDiv = function() {
        var template = '';
        template += '<div class="set-windows-information" id="set-windows-information">';
        template += '<span>每当有与你相关的新动态，系统会弹出气泡提醒你(仅对Chrome 、Firefox 和 Safari 浏览器有效)。</span>';
        template += '<div class="select-inform-type">';
        template += '<div>';
        template += '<input type="radio" name="inform-type" value="1" id="open-inform">';
        template += '开启桌面通知(<a href="javascript:void(0);" id="test-inform">测试浏览器支持</a>)';
        template += '<div class="inform-type" id="inform-type">';
        template += '<input type="checkbox" value="1" id="msg" name="msg">通知';
        template += '<input type="checkbox" value="1" id="warn" name="warn">警告';
        template += '<input type="checkbox" value="1" id="process" name="process">流程';
        template += '</div>';
        template += '</div>';
        template += '<div>';
        template += '<input type="radio" name="inform-type" value="0" id="close-inform">';
        template += '关闭桌面通知';
        template += '</div>';
        template += '<div id="validateTips"></div>'
        template += '</div>';
        template += '</div>';

        return template;
    }

    /**
     * @desc 设置桌面通知
     * @author Zijie Yuan
     * @date 2016-12-15 11:26:53
     */
    var setInform = function() {
        var informConfig = $('#windows-inform'),
            msgStatus = informConfig.data('msg'),
            warnStatus = informConfig.data('warn'),
            processStatus = informConfig.data('process');

        // 选中单选
        if (msgStatus == 1 || warnStatus == 1 || processStatus == 1) {
            $('#open-inform').prop('checked', true);
            // 选中多选
            ((msgStatus == 1)? $('#msg').prop('checked', true):'');
            ((warnStatus == 1)? $('#warn').prop('checked', true):'');
            ((processStatus == 1)? $('#process').prop('checked', true):'');
        }else {
            $('#close-inform').prop('checked', true);
        }

        $('body').on('click', '#close-inform', function() {
            var checkbox = $('#inform-type').find('input');
            checkbox.prop('checked', false);
            checkbox.prop('disabled', true);
        });

        $('body').on('click', '#open-inform', function() {
            var checkbox = $('#inform-type').find('input');
            checkbox.prop('disabled', false);
        })
    }

    /**
     * @desc 测试浏览器是否支持消息推送
     * @author Zijie Yuan
     * @date 2016-12-19 11:26:53
     */
    var testInform = function() {
        $('body').on('click', '#test-inform', function() {
            var template = '',
                canPush = 0,
                messagePush = new MessagePush;
            canPush = messagePush.testMessage();
            switch(canPush.state) {
                case 0:
                    template += '<div class="" title="通知测试">';
                    template += '<span class="icon remove"></span>';
                    template += '<span>您的浏览器不支持消息推送！</span>';
                    template += '</div>';
                    $(template).dialog({
                        autoOpen: true,
                        width: 450,
                        maxHeight: 150,
                        modal: true,
                        show: "slide",
                        buttons: [
                            {
                                text: "确定(Ok)",
                                click: function () {
                                    $(this).dialog("destroy");
                                }
                            },
                        ], close: function () {
                            $(this).dialog("destroy");
                        }
                    });
                    break;
                case 1:
                    template += '<div class="" title="通知测试">';
                    template += '<span class="icon ok"></span>';
                    template += '<span>浏览器支持通知，请参考屏幕右下角通知信息。</span>';
                    template += '</div>';
                    $(template).dialog({
                        autoOpen: true,
                        width: 450,
                        maxHeight: 150,
                        modal: true,
                        show: "slide",
                        buttons: [
                            {
                                text: "确定(Ok)",
                                click: function () {
                                    $(this).dialog("destroy");
                                }
                            },
                        ], close: function () {
                            $(this).dialog("destroy");
                        }
                    });
                    break;
                case 2:
                    leftMenu('guide', '测试浏览器支持', '/msg/user-message/guide');
                    break;
                default:
            }
        })
    }

    return {
        'init': init,
        'setMessageUnReadTotal': setMessageUnReadTotal
    }
}