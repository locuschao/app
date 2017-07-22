jQuery.fn.EzWmsEditDataDialogX = function (options) {
    var defaults = {
        jsonData: {},
        Field: 'paramId',
        paramId: 0,
        url: '/',
        editUrl: '/',
        dWidth: "550",
        dHeight: "500",
        dTitle: "系统操作/Operations",
        successMsg: "",
        beforClose: null,
        successCB: null,
        beforSubmit: null
    };

    options = $.extend(defaults, options);
    var div = $(this);
    $('<div title="' + options.dTitle + '" id="dialog-edit-alert-tip" class="dialog-edit-alert-tip"><form id="editDataForm" name="editDataForm" class="submitReturnFalse">' + div.html() + '</form><div class="validateTips" id="validateTips"></div></div>').dialog({
        autoOpen: true,
        width: options.dWidth,
        maxHeight: options.dHeight,
        modal: true,
        show: "slide",
        buttons: [
            {
                text: "确定(Ok)",
                click: function () {

                    var canSubmit = true;
                    if (typeof options.beforSubmit == 'function') {
                        canSubmit = options.beforSubmit.call(this);
                    }

                    if (canSubmit){
                        if (options.editUrl == '/') {
                            return;
                        }
                        $("#editDataForm").submit();
                    }


                }
            },
            {
                text: "取消(Cancel)",
                click: function () {
                    $(this).dialog("destroy");
                }
            }
        ], close: function () {
            if (typeof options.beforClose == 'function') {
                options.beforClose.call(this);
            }

            $(this).dialog("destroy");
        }
    });

    var getJson = function () {
        $.ajax({
            type: "post",
            async: false,
            dataType: "json",
            url: options.url,
            data: options.Field + "=" + options.paramId,
            success: function (json) {
                if (json.state) {
                    $.each(json.data, function (k, v) {
                        $(":input[name=" + k + "]", "#dialog-edit-alert-tip").val(v);
                        $(":checkbox[name=" + k + "]", "#dialog-edit-alert-tip").attr('checked', parseInt(v) && parseInt(v) > 0 ? true : false);
                    });

                    if (typeof options.successCB == 'function') {
                        options.successCB.call(this, json.data);
                    }
                }
            }
        });
    };

    var $dialogEditAlertTip = $("#dialog-edit-alert-tip");
    var editSuccess = function (json) {
        switch (json.state) {
            case 1:
                $dialogEditAlertTip.dialog("close");
                initData(0);
                break;
            case 2:
                $dialogEditAlertTip.dialog("close");
                loadData(paginationCurrentPage, paginationPageSize);
                alertTip(json.message);
                break;
            default:
                var html = '';
                var tipObj = $("#validateTips");
                if (json['errorMessage'] == null)return;
                $.each(json['errorMessage'], function (key, val) {
                    html += '<span class="tip-error-message">' + val + '</span>';
                });
                tipObj.html(html);
                break;
        }
    };
    if (options.url != '/' && options.paramId != '0') {
        getJson()
    }
    $("#editDataForm").myAjaxForm({api: options.editUrl, success: editSuccess});
};

/**
 * @desc checkbox联动
 * @author zhengyu
 * @date 2016-11-04 11:24:48
 * @param allId
 * @param itemClass
 * @param checkCallBack
 * @param unCheckCallBack
 */
function linkage(allId, itemClass, checkCallBack, unCheckCallBack) {
    var body = 'body';

    $(body).on('click', allId, function () {
        var allBtn = $(this);

        if (allBtn.attr('checked') != undefined) {
            //全选
            $(itemClass).each(function () {
                $(this).attr('checked', 'checked');

                if (checkCallBack && typeof checkCallBack == 'function'){
                    //勾选时调用
                    checkCallBack.call(this, this);
                }
            });
        } else {
            $(itemClass).each(function () {
                $(this).removeAttr('checked');

                if (unCheckCallBack && typeof unCheckCallBack == 'function'){
                    //取消勾选时调用
                    unCheckCallBack.call(this, this);
                }
            });
        }
    });

    $('body').on('click', itemClass, function () {
        var isAll = true;
        $(itemClass).each(function () {
            if ($(this).attr('checked') == undefined) {
                isAll = false;
                return false;
            }
        });

        //是否全选
        if (isAll) {
            $(allId).attr('checked', 'checked');
        } else {
            $(allId).removeAttr('checked');
        }

        if ($(this).attr('checked') == undefined){
            //取消勾选
            if (unCheckCallBack && typeof unCheckCallBack == 'function'){
                //取消勾选时调用
                unCheckCallBack.call(this, this);
            }
        }else{
            //勾选
            if (checkCallBack && typeof checkCallBack == 'function'){
                //勾选时调用
                checkCallBack.call(this, this);
            }
        }
    });
}

/**
 * @desc 生成选择用户面板
 * @author zhengyu
 * @date 2016-11-07 11:16:34
 * @private
 */
function _selectUserPanel() {
    //生成弹框
    var dialogHtml = [];
    dialogHtml.push('<div title="选择通知人" id="dialog-edit-alert-tip" class="dialog-edit-alert-tip">');
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
                    $.each(nodes[0]['children'], function (index, item) {
                        userArray[item.id] = item.name;
                    });

                    $(this).dialog("close");
                    return userArray;
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
    var userData = _getUserData({});

    //生成选择后的用户列表
    _genUserTree('#selected-user', [], false);
    //用户列表
    _genUserTree('#user-tree', userData, true, {
        onCheck: _userTreeCheck
    });

    //绑定搜索事件
    $('#search-user-name-btn').on('click', function () {
        var filterStr = $('#search-user-name').val(),
            treeObj = $.fn.zTree.getZTreeObj("user-tree");

        //清空之前的高亮
        _updateNodeHightLight('user-tree', treeObj.getNodesByParamFuzzy('name', ''), false);

        if (filterStr) {
            //设置筛选后的
            _updateNodeHightLight('user-tree', treeObj.getNodesByParamFuzzy('name', filterStr), true);
        }
    });

    //绑定清空选择事件
    $('#clear-select-btn').on('click', function () {
        $.fn.zTree.init($("#selected-user"), {}, []);
        $('#selected-number').html(0);

        // 清空勾选
        var userData = _getUserData({});

        //用户列表
        _genUserTree('#user-tree', userData, true, {
            onCheck: _userTreeCheck
        });
    });
}

/**
 * @desc 获取用户信息
 * @author zhengyu
 * @date 2016-11-07 15:12:58
 * @private
 */
function _getUserData() {
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
function _genUserTree(treeId, userData, checked, callbackSetting) {
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
function _updateNodeHightLight(treeId, nodeList, flag) {
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
function _userTreeCheck(e, treeId, treeNode) {
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