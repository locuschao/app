function MessageDetails() {
    var flow = '',
        umId = $('#module-container').data('umid');

    var init = function() {
        bindBtnEven();      // 绑定标记为事件
        flowUp();           // 流程显示
        flowDown();         // 流程隐藏
        erpUp();            // 业务单号显示
        erpDown();          // 业务单号隐藏
        initPassBtn();      // 初始化确认按钮
    }

    // 初始化流程数据
    var initFlowData = function (data) {
        flow = data;
        processWindow();    // 流程弹窗
    }

    // 节点进度弹窗
    var processWindow = function() {
        var tp = [],
            template = '',
            flag = 0;
        if (flow && flow.F1) {
            // 拼接通知人信息
            $.each(flow.F1, function(index, item) {
                var node = {title: '', content: ''};
                node.title = item.G1 + ' - ';
                if (item.F1 && item.F1.length > 0) {
                    $.each(item.F1, function(i, user) {
                        node.title += user;
                        node.title += ' ';
                    });
                }
                if (item.E3 == flow.E6) {
                    flag = index + 1;
                }
                node.content += '时间：' + item.E6 + '<br>';
                node.content += '事件：' + item.G1 + '<br>';
                node.content += '发起人：' + ((item.F5 == null)? '' : item.F5)  + '<br>';
                if (item.F2 && item.F2.length > 0) {
                    node.content += '抄送：';
                    $.each(item.F2, function(i, user) {
                        node.content += user;
                        node.content += ';';
                    });
                    node.content += '<br>';
                }
                tp.push(node);
            })

            // 节点插件
            $('#process').loadStep({
                size: 'large',
                color: 'green',
                html: true,
                steps: tp
            });
            $('#process').setStep(flag);
        }
    }
    
    // 流程收起
    var flowUp = function() {
        $('#flow-up').on('click', function() {
            var self = $(this),
                down = $('#flow-down');
            $('#process').hide();
            self.removeClass('down');
            down.addClass('down');
        })
    }

    // 流程展示
    var flowDown = function() {
        $('#flow-down').on('click', function() {
            var self = $(this),
                up = $('#flow-up');
            $('#process').show();
            self.removeClass('down');
            up.addClass('down');
        })
    }

    // 流程详情
    var flowDetail = function() {
        var template = '',
            flowName = $('#flow-name').text();
        $('body').on('click', '#flow-name', function() {
            template += '<div title="查看流程详情">';
            template += '<div class="flow-name-div"><ul class="flow-name-ul">';
            template += '<li>' + flowName + '</li>';
            template += '</ul></div>'; 

            template += '<div class="flow-details-div">';
            template += '<table class="flow-details-table"><tbody>';
            $.each(flow.F1, function(index, item) {
                template += '<tr>';
                template += '<td>' + item.G1 + '：';
                $.each(item.F1, function(i, user) {
                    template += user + ';';
                })
                template += '</td>';
                template += '<td>抄送：';
                if (item.F2) {
                    $.each(item.F2, function(i, user) {
                        template += user + ';';
                    })
                }
                template += '</td>';
                template += '</tr>';
            })
            template += '</div>';
            $(template).dialog({
                autoOpen: true,
                width: '600',
                maxHeight: 'auto',
                modal: true,
                show: "slide",
                buttons: [], close: function () {
                    $(this).detach();
                }
            });
        })
    }

    // 确认/通过
    var initPassBtn = function() {
        $('body').on('click', '.btn-pass', function(){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '/msg/notice-bussiness-message/pass-flow-message',
                data: {umid: umId},
                success: function (json) {
                    if (json.state == 1) {
                        alertTip(json.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    } else {
                        alertTip(json.message);
                    }
                },
                statusCode: {
                    // 如果你想处理各状态的错误的话
                    404: function(){alertTip('不能访问网络');},
                    500: function(){alertTip('服务器错误');}
                }
            });
        });

    };

    /**
     * @desc 标记为按钮事件
     * @author zhengyu
     * @date 2016-11-15 10:50:42
     */
    var bindBtnEven = function() {
        //标记
        $('.mark').on('change', function(){
            var self = $(this),
                changeItem = self.val();

            switch (changeItem){
                case 'r1':
                    _readMessage(true, umId);
                    break;
                case 'r0':
                    _readMessage(false, umId);
                    break;
                case 's1':
                    _startMsg(true, umId);
                    break;
                case 's0':
                    _startMsg(false, umId);
                    break;
            }
        });
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
                    if (isRead){
                        return ;
                    }else{
                        alertTip(json.message);
                        setTimeout(function() {
                            window.location.href = '/msg/user-message/list';
                        }, 2000);
                    }
                } else {
                    alertTip(json.message);
                }
            }
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
                    if (isStart){
                        $('#star').removeClass('unstar').addClass('star');
                    }else{
                        $('#star').removeClass('star').addClass('unstar');
                    }
                } else {
                    alertTip(json.message);
                }
            }
        });
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

    // 业务单号显示
    var erpUp = function() {
        $('#erp-no-up').on('click', function() {
            var self = $(this),
                down = $('#erp-no-down');
            $('#erp-no').hide();
            self.removeClass('down');
            down.addClass('down');
        })
    }

    // 业务单号隐藏
    var erpDown = function() {
        $('#erp-no-down').on('click', function() {
            var self = $(this),
                up = $('#erp-no-up');
            $('#erp-no').show();
            self.removeClass('down');
            up.addClass('down');
        })
    }

    return {
        'init': init,
        'initFlowData': initFlowData,
        'flowDetails': flowDetail,
        'setMessageUnReadTotal': setMessageUnReadTotal
    }
}