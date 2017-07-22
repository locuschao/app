function WriteLetter() {
    var flow;
    function init() {
        initMessageEditor();
        sendMessage();
        selectReceiver();
        selectCc();
        selectBusiness();
        sendFlow();
        messageTypeSelect();
        messageTypeSelect2();
        searchFlow();
    }
    var messageEditor,
        flowEditor;
    // 初始化消息文本编辑器
    var initMessageEditor = function()  {
        messageEditor = $('#message-editor').xheditor({
            tools: 'Cut,Copy,Paste,|,Fontface,FontSize,Bold,Italic,Underline,Fontcolor,Align,|,Link,Emot',
            skin: 'default',
            showBlocktag:true,
            internalScript:false,
            internalStyle:false,
            forcePtag:true,
            upImgUrl:"",
            upImgExt:"jpg,jpeg,gif,png"
        });
    }

    // 初始化流程文本编辑器
    var initFlowEditor = function()  {
        flowEditor = $('#flow-editor').xheditor({
            tools: 'Cut,Copy,Paste,|,Fontface,FontSize,Bold,Italic,Underline,Fontcolor,Align,|,Link,Emot',
            skin: 'default',
            showBlocktag:true,
            internalScript:false,
            internalStyle:false,
            forcePtag:true,
            upImgUrl:"",
            upImgExt:"jpg,jpeg,gif,png"
        });
    }

    // 选择发件人
    var selectReceiver = function() {
        $('#select-receiver').on('click', function()  {
            selectUserPanel('选择收件人', $('#user-text'));
        })
    }

    // 选择抄送人
    var selectCc = function() {
        $('#select-cc').on('click', function()  {
            selectUserPanel('选择抄送人', $('#cc-user-text'));
        })
    }

    // 发送消息
    var sendMessage = function() {
        $('#message-send').on('click', function() {
            var sendTo = [],
                ccTo = [],
                send = $('#receiver-text .user-base'),
                cc = $('#cc-text .user-base'),
                postData = {E4: $('#E4').val(),
                            E5: $('#E5').val(),
                            F1: messageEditor.getSource(),
                            F2: sendTo,
                            F3: ccTo,
                            E1: $('#E1').val()
                        };
            // 获取收件人
            $.each(send, function(index, item) {
                var item = $(item);
                sendTo.push(item.data('id'));
            });

            // 获取抄送人
            $.each(cc, function(index, item) {
                var item = $(item);
                ccTo.push(item.data('id'));
            });

            $.ajax({
                url: '/msg/user-message/send-message',
                type: 'POST',
                dataType: 'json',
                data: postData,
                success: function(json) {
                    if (json.state) {
                        alertTip('发送成功！');
                        setTimeout(function() {
                            window.location.href = '/msg/user-message/list';
                        }, 2000)
                        return ;
                    }
                    alertTip(json.message);
                }
            })
        })
    }

    /**
     * @desc 生成选择用户面板
     * @author zhengyu
     * @date 2016-11-07 11:16:34
     * @private
     */
     var selectUserPanel = function(title, selector) {
        //生成弹框
        var dialogHtml = [];
        dialogHtml.push('<div title="' + title + '" id="dialog-edit-alert-tip" class="dialog-edit-alert-tip">');
        dialogHtml.push('<form id="editDataForm" name="editDataForm" class="submitReturnFalse">');

        //用户筛选
        dialogHtml.push('<div class="search-user-div">');
        dialogHtml.push('<div class="search-user-input-div"><input title="输入用户名" id="search-user-name" type="text">');
        dialogHtml.push('<input id="search-user-name-btn" class="search-user-name-btn" type="button" value="搜索"/></div>');
        dialogHtml.push('<ul id="user-tree" class="ztree"></ul>');
        dialogHtml.push('</div>');

        //选择后的用户信息
        dialogHtml.push('<div class="selected-user-div">');
        dialogHtml.push('<div class="selected-user-haeder">');
        dialogHtml.push('<div class="selected-number-div">已选（<span id="selected-number">0</span>）</div>');
        dialogHtml.push('<div class="selected-user-clear"><a id="clear-select-btn" href="javascript:void(0)">清空</a></div>');
        dialogHtml.push('</div>');
        dialogHtml.push('<div class="selected-user-list">');
        dialogHtml.push('<ul id="selected-user" class="ztree"></ul>');
        dialogHtml.push('</div>');
        dialogHtml.push('</div>');

        dialogHtml.push('</form><div class="validateTips" id="validateTips"></div></div>');

        $(dialogHtml.join('')).dialog({
            autoOpen: true,
            width: '600',
            maxHeight: 'auto',
            modal: true,
            show: "slide",
            buttons: [
                {
                    text: "确定(Ok)",
                    click: function () {
                        var userTreeObj = $.fn.zTree.getZTreeObj("user-tree"),
                            treeObj = $.fn.zTree.getZTreeObj("selected-user"),
                            nodes = treeObj.getNodes(),
                            userArray = {};

                        // 获取用户id、用户名
                        if (nodes[0] != undefined) {
                            var templete = '';
                            $.each(nodes[0]['children'], function(index, item) {
                                templete += '<div class="user-base" data-id="' + item.id + '"unselectable="on" tabindex="-1" style="float: left;white-space: nowrap;">';
                                templete += item.name;
                                templete += ';</div>';
                            })
                            selector.before(templete);
                        }
                        userClick();
                        $(this).dialog("close");
                        
                    }
                },
                {
                    text: "取消(Cancel)",
                    click: function () {
                        $(this).dialog("close");
                    }
                }
            ], close: function () {
                $(this).detach();
            }
        });

        //生成折叠信息
        var userData = getUserData({});

        //生成选择后的用户列表
        genUserTree('#selected-user', [], false);
        //用户列表
        genUserTree('#user-tree', userData, true, {
            onCheck: userTreeCheck
        });

        //绑定搜索事件
        $('#search-user-name-btn').on('click', function () {
            var filterStr = $('#search-user-name').val(),
                treeObj = $.fn.zTree.getZTreeObj("user-tree");

            //清空之前的高亮
            updateNodeHightLight('user-tree', treeObj.getNodesByParamFuzzy('name', ''), false);

            if (filterStr) {
                //设置筛选后的
                updateNodeHightLight('user-tree', treeObj.getNodesByParamFuzzy('name', filterStr), true);
            }
        });

        //绑定清空选择事件
        $('#clear-select-btn').on('click', function () {
            $.fn.zTree.init($("#selected-user"), {}, []);
            $('#selected-number').html(0);

            // 清空勾选
            var userData = getUserData({});

            //用户列表
            genUserTree('#user-tree', userData, true, {
                onCheck: userTreeCheck
            });
        });
    }

    /**
     * @desc 获取用户信息
     * @author zhengyu
     * @date 2016-11-07 15:12:58
     * @private
     */
     var getUserData = function() {
        var userData = [];
        $.ajax({
            type: "POST",
            async: false,
            cache: true,
            dataType: "json",
            url: '/msg/notice-user-group/get-user-group',
            data: {'paramId': 1},
            success: function (json) {
                if (json.state == 1) {
                    userData = json.data;
                } else {
                    alertTip(json.message);
                }
            }
        });

        return userData;
    }

    /**
     * @desc 生成用户树
     * @author zhengyu
     * @date 2016-11-07 11:44:21
     * @param treeId
     * @param userData
     * @param checked
     * @param callbackSetting
     * @private
     */
     var genUserTree = function(treeId, userData, checked, callbackSetting) {
        var setting = {
            check: {
                enable: checked
            },
            view: {
                fontCss: function (treeId, treeNode) {
                    return (!!treeNode.highlight) ? {color: "#A60000", "font-weight": "bold"} : {
                        color: "#333",
                        "font-weight": "normal"
                    };
                }
            }
        };

        if (callbackSetting) {
            setting['callback'] = callbackSetting;
        }

        $.fn.zTree.init($(treeId), setting, userData);
    }

    /**
     * @desc 高亮和取消高亮
     * @author zhengyu
     * @date 2016-11-07 15:13:32
     * @param treeId
     * @param nodeList
     * @param flag
     * @private
     */
     var updateNodeHightLight = function(treeId, nodeList, flag) {
        var treeObj = $.fn.zTree.getZTreeObj(treeId);

        for (var i = 0, l = nodeList.length; i < l; i++) {
            //高亮设置
            nodeList[i].highlight = flag;

            if (flag) {
                //展开
                treeObj.expandNode(nodeList[i].getParentNode(), flag);
            } else {
                //折叠
                if (nodeList[i].children) {
                    treeObj.expandNode(nodeList[i], flag);
                }
            }

            treeObj.updateNode(nodeList[i]);
        }
    }

    /**
     * @desc 点击用户列表时发生的事件
     * @author zhengyu
     * @date 2016-11-08 09:54:27
     * @param e
     * @param treeId
     * @param treeNode
     * @private
     */
     var userTreeCheck = function(e, treeId, treeNode) {
        var userTreeObj = $.fn.zTree.getZTreeObj('user-tree'),
            treeObj = $.fn.zTree.getZTreeObj('selected-user'),
            $selectedNumber = $('#selected-number'),
            parentNode = null;

        if (treeNode.checked) {
            //勾选时
            if (!treeObj.getNodeByParam('search-key', treeNode['search-key'])) {

                //判断当前是否有父节点
                if (treeNode['type'] == 'user') {
                    //需要添加父节点
                    parentNode = userTreeObj.getNodeByParam('search-key', treeNode['search-key']).getParentNode();
                    //判断是否需要添加父节点
                    if (!treeObj.getNodeByParam('search-key', parentNode['search-key'])) {
                        //需要
                        parentNode = treeObj.copyNode(null, parentNode);
                        treeObj.removeChildNodes(parentNode);
                    } else {
                        parentNode = treeObj.getNodeByParam('search-key', parentNode['search-key']);
                    }
                }

                treeObj.addNodes(parentNode, -1, treeNode);

                //增加计数
                if (treeNode.children && treeNode.children.length > 0) {
                    $selectedNumber.html(parseInt($selectedNumber.html()) + treeNode.children.length);
                } else {
                    $selectedNumber.html(parseInt($selectedNumber.html()) + 1);
                }
            }
        } else {
            //取消勾选
            var node = treeObj.getNodeByParam('search-key', treeNode['search-key']),
                nodeLength = 1;

            if (treeNode['type'] == 'user') {
                //取消的节点为用户时
                //判断当前父节点长度是否为1，如果是，最后需要移除
                parentNode = node.getParentNode();

                //移除当前节点
                treeObj.removeNode(node);

                if (parentNode.children.length == 0) {
                    treeObj.removeNode(parentNode);
                }
            } else {
                nodeLength = node.children.length;
                treeObj.removeNode(node);
            }

            $selectedNumber.html(parseInt($selectedNumber.html()) - nodeLength);
        }
    }

    // 游标聚焦
    /* var cursorFocus = function() {
        $('#receiver-text').on('click', function() {
            $('#user-text input').focus();
        })
    }*/

    // 用户名点击
    var userClick = function() {
        $('.user-base').unbind();
        $('.user-base').on('click', function() {
            var selector = $('.user-base'),
                self = $(this);
            selector.removeClass('user-selected');
            self.addClass('user-selected');
        }).mouseenter(function() {
             var self = $(this);
             if (self.hasClass('user-base-select')) {
                return ;
             }else if (self.hasClass('user-selected')) {
                return ;
             }
             self.addClass('user-base-select');
        }).mouseleave(function() {
            var self = $(this);
            self.removeClass('user-base-select');
        })

        $('#receiver-text').on('blur', '.user-selected', function() {
            var self = $(this);
            self.removeClass('user-selected');
        }).on('keypress', '.user-selected', function(e) {
            var self = $(this);
            // delete
            if (e.which == 46) {
                self.remove();
            }
        })

        $('#cc-text').on('blur', '.user-selected', function() {
            var self = $(this);
            self.removeClass('user-selected');
        }).on('keypress', '.user-selected', function(e) {
            var self = $(this);
            // delete
            if (e.which == 46) {
                self.remove();
            }
        })
    }

    // 选择通知业务
    var selectBusiness = function() {
        $('#select-business').on('click', function() {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '/msg/notice-bussiness/get-user-business',
                data: {},
                success: function (json) {
                    if (json.state == 1) {
                        flow = json.data;
                        var html = generateSelectBusinessDiv(json.data);
                        SelectBusinessDialog(html);
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
        })
    }

    // 生产选择通知业务弹窗
    var generateSelectBusinessDiv = function(business) {
        var template = '';
        template += '<div class="business-div" title="选择通知业务">';
        template += '<div class="search-bar">';
        template += '<input type="text" class="input_text" id="search-input" placeholder="模糊搜索（通知业务名称）">';
        template += '<button type="button" class="search-btn baseBtn" id="search-flow">搜索</button>';
        template += '</div>';
        template += '<div class="business-list" id="business-list">';
        // 拼接流程
        $.each(business, function(index, item) {
            template += '<div class="business-base">';
            template += '<table class="business-table"><thead><tr><th colspan="2" data-nbid="' + item.E0 + '">';
            template += item.E4;
            template += '</th>';
            template += '<th class="business-content">' + item.E6 + '</th>';
            template += '</tr></thead>';
            template += '<tbody class="business-table-body">';
            for (var i = 0; i < item.F1.length; i++) {
                if (i%2 == 0 ) {template += '<tr>';}
                template += '<td>';
                template += '<span data-nblid="' + item.F1[i]['F0'] + '">' + item.F1[i]['G1'] + '</span>';
                template += ' - ';
                if (item.F1[i]['H0'] && item.F1[i]['H0'] != null) {
                    var userId = item.F1[i]['H0'],
                        userName = item.F1[i]['H1'];
                    template += '<span data-userid="' + userId + '">' + userName + '</span>';
                }else if (item.F1[i]['I0'] && item.F1[i]['I0'] != null) {
                    var groupId = item.F1[i]['I0'],
                        groupName = item.F1[i]['I1'];
                    template += '<span data-groupid="' + groupId + '">' + groupName + '</span>';
                }else {
                    template += '<span></span>';
                }
                template += '</td>';
                if (i%2 == 1) {template += '</tr>';}
            };
            template += '</tr></tbody></table>';
            template += '</div>';
        })
        template += '</div>';

        return template;
    }

    // 选择通知业务对话框
    var SelectBusinessDialog = function(module) {
        $(module).dialog({
            autoOpen: true,
            width: '600',
            maxHeight: 'auto',
            modal: true,
            show: "slide",
            buttons: [{
                text: '确定',
                click: function () {
                    generateNodeDiv();
                    $(this).dialog("close");
                }
            }], close: function () {
                $(this).detach();
            }
        });
        selectFlow();
    }

    // 选择流程
    var selectFlow = function() {
        $('.business-list').on('click', '.business-base', function() {
            var businessBase = $('.business-base'),
                self = $(this);
            businessBase.removeClass('business-selected');
            self.addClass('business-selected');
        })
    }

    // 生成节点div
    var generateNodeDiv = function() {
        var nodeDiv = $('#node-div'),
            businessInput = $('#business'),
            flowEditor = $('#flow-editor'),
            businessSelect = $('.business-selected'),
            th = businessSelect.find('table thead tr th[data-nbid]'),
            businessContent = businessSelect.find('table thead tr .business-content').text(),
            nbId = th.data('nbid'),
            nbName = th.text(),
            td = businessSelect.find('table tbody tr td'),
            template = '<table><tbody>';
        $.each(td, function(index, item) {
            var item = $(item),
                nbl = item.find('span[data-nblid]'),
                nblId = nbl.data('nblid');
                nblName = nbl.text();
                user = item.find('span[data-userid]');
                userId = user.data('userid');
                userName = user.text();
                group = item.find('span[data-groupid]');
                groupId = group.data('groupid');
                groupName = group.text();
            template += '<tr><td class="node-title">节点' + ++index + '</td>';
            template += '<td class="flow-node" data-nblid="' + nblId + '" data-userid="' + userId + '" data-groupid="' + groupId + '">';
            template += '<input type="text" class="w50" value="' + nblName + ' - ' + ((userId == undefined)? groupName:userName) + '" disabled></td>';
            template += '</tr>';
        })
        template += '</tbody></table>';
        nodeDiv.empty();
        nodeDiv.append(template);
        nodeDiv.show();
        businessInput.val(nbName);
        businessInput.data('businessid', nbId);
        flowEditor.text('');
        flowEditor.text(businessContent);
    }

    // 流程通知
    var sendFlow = function() {
        $('#flow-send').on('click', function() {
            var businessId = $('#business').data('businessid'),
                nodeList = $('.flow-node'),
                content = flowEditor.getSource(),
                subject = $('#flow-E5').val(),
                postData = {businessId: businessId, subject:subject, content: content, nodeList: []};
            $.each(nodeList, function(index, item) {
                var item = $(item),
                    node = {};
                node.nblId = item.data('nblid');
                if (item.data('userid') != 'undefined') {
                    node.userId = item.data('userid');
                }
                if (item.data('groupid') != 'undefined') {
                    node.groupId = item.data('groupid');
                }
                postData.nodeList.push(node);
            })
          
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '/msg/notice-bussiness-message/add-flow-message',
                data: postData,
                success: function (json) {
                    if (json.state == 1) {
                        alertTip(json.message);
                        setTimeout(function() {
                            window.location.href = '/msg/user-message/list';
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
        })
    }

    // 消息类型选择(通知消息模板)
    var messageTypeSelect = function() {
        $('#E4').on('click', function() {
            var self = $(this);
            if (self.val() == 'USER') {
                $('#message-div').hide();
                $('#flow-div').show();
                $('#flow-E4').val('USER');
                initFlowEditor();
            }
        })
    }

    // 消息类型选择(流程通知模板)
    var messageTypeSelect2 = function() {
        $('#flow-E4').on('click', function() {
            var self = $(this);
            if (self.val() == 'SYSTEM') {
                $('#flow-div').hide();
                $('#message-div').show();
                $('#E4').val('SYSTEM');
            }
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

     // 搜索流程
    var searchFlow = function () {
        $('body').on('click', '#search-flow', function() {
            var keyWord = $('#search-input').val(),
                flowList = $('#business-list'),
                template = '';
            flowList.empty();
            // 拼接流程
            $.each(flow, function(index, item) {
                if (item.E4.indexOf(keyWord) < 0 && keyWord != '') {
                    return true;
                }
                template += '<div class="business-base">';
                template += '<table class="business-table"><thead><tr><th colspan="2" data-nbid="' + item.E0 + '">';
                template += item.E4;
                template += '</th>';
                template += '<th class="business-content">' + item.E6 + '</th>';
                template += '</tr></thead>';
                template += '<tbody class="business-table-body">';
                for (var i = 0; i < item.F1.length; i++) {
                    if (i%2 == 0 ) {template += '<tr>';}
                    template += '<td>';
                    template += '<span data-nblid="' + item.F1[i]['F0'] + '">' + item.F1[i]['G1'] + '</span>';
                    template += ' - ';
                    if (item.F1[i]['H0'] && item.F1[i]['H0'] != null) {
                        var userId = item.F1[i]['H0'],
                            userName = item.F1[i]['H1'];
                        template += '<span data-userid="' + userId + '">' + userName + '</span>';
                    }else if (item.F1[i]['I0'] && item.F1[i]['I0'] != null) {
                        var groupId = item.F1[i]['I0'],
                            groupName = item.F1[i]['I1'];
                        template += '<span data-groupid="' + groupId + '">' + groupName + '</span>';
                    }else {
                        template += '<span></span>';
                    }
                    template += '</td>';
                    if (i%2 == 1) {template += '</tr>';}
                };
                template += '</tr></tbody></table>';
                template += '</div>';
            })
            flowList.append(template);
        })
    }
    
    return {
        'init': init,
        'setMessageUnReadTotal': setMessageUnReadTotal
    }
}