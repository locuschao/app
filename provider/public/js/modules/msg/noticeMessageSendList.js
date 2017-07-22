function NoticeMessageSendList(){
    var body = 'body';

    function init(){
        initEvn();

        //绑定星标点击事件
        bindStartEven();

        //绑定转发、全部已读、标记为等按钮事件
        bindBtnEven();
    }

    /**
     * @desc 初始化环境
     * @author zhengyu
     * @date 2016-11-14 11:27:57
     */
    function initEvn() {
        EZ.url = '/msg/user-message/send-list/';
        EZ.getListData = function (json) {
            var html = [];
            var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
            $.each(json.data, function (key, val) {
                html.push(((key + 1) % 2 == 1 ? '<tr class="table-module-b1">' : '<tr class="table-module-b2">'));
                html.push('<td><input class="check-item" type="checkbox" value="'+val['E0']+'" /></td>');
                html.push('<td class="send-user-name">' + val['EF1'] + '</td>');
                html.push('<td class="align-left code">' + (val['EF8'] ? val['EF8'] : '--') + '<br>' + (val['EF7'] ? val['EF7'] : '--') + '</td>');
                html.push('<td class="align-left msg-subject"><span id="ico-read-'+ val['E0'] +'" class="'+ (val['E8'] == '0' ? 'unread' : 'read') +'"></span>' + val['E5'] + '</td>');
                html.push('<td class="create-time">' + val['E10'] + '</td>');
                html.push('<td class="opt-td"><span id="ico-start-'+ val['E0'] +'" class="'+ (val['E9'] == '0' ? 'unstart' : 'start') +'" data-val="'+ val['E0'] +'"></span></td>');
                html.push('</tr>');

            });
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
            url: '/msg/user-message/set-start',
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
            alert('zuanfa');
        });

        //全部已读
        $(body).on('click', '#all-read-btn', function(){
            $.ajax({
                type: "post",
                async: false,
                dataType: "json",
                url: '/msg/user-message/set-read',
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
            url: '/msg/user-message/set-read',
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
            url: '/msg/user-message/get-msg-unread',
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

    return {
        'init': init,
        'setMessageUnReadTotal': setMessageUnReadTotal
    }
}