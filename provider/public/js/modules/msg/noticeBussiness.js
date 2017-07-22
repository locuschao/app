function NoticeBussinessList() {
    var body = 'body',
        dialogEditAlertTip = '.dialog-edit-alert-tip',
        noticeApplication = null;

    function init() {
        //初始化环境
        initEvn();

        //绑定弹出框选择“通知应用”事件
        initSelectApplicationEven();

        //初始化添加
        initAdd();

        //初始化编辑按钮事件
        initEdit();

        //初始化删除事件
        initDel();
    }

    /**
     * @desc 初始化环境
     * @author zhengyu
     * @date 2016-11-04 11:15:09
     */
    function initEvn() {
        EZ.url = '/msg/Noticebussiness/';
        EZ.getListData = function (json) {
            var html = [];
            var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
            $.each(json.data, function (key, val) {
                html.push(((key + 1) % 2 == 1 ? '<tr class="table-module-b1">' : '<tr class="table-module-b2">'));
                html.push('<td class="ec-center"><input class="check-item" type="checkbox" data-val="' + val['E0'] + '" /></td>');

                html.push('<td>' + i + '：' + val['E4'] + '</td>');
                html.push('<td>' + (val['E3'] == 1 ? '系统' : '客户') + '</td>');
                html.push('<td>' + val['E5'] + '</td>');
                html.push('<td>' + val['EF1'] + ' / ' + val['E1'] + '</td>');

                var stateName = '';
                switch (parseInt(val['E2'])) {
                    case 0:
                        stateName = '停用';
                        break;
                    case 1:
                        stateName = '启用';
                        break;
                    case 2:
                        stateName = '草稿';
                        break;

                }
                html.push('<td>' + stateName + '</td>');
                html.push('<td>创建：' + (val['EF2'] ? val['EF2'] : '系统') + '<br>修改：' + (val['EF3'] ? val['EF3'] : '系统') + '</td>');
                html.push('<td>创建：' + val['E9'] + '<br>修改：' + val['E10'] + '</b></td>');

                html.push('<td><a class="editItem" data-val="'+val['E0']+'" href="javascript:void(0)">' + EZ.edit + '</a>');
                html.push('&nbsp;&nbsp;|&nbsp;&nbsp;');
                html.push('<a href="javascript:deleteById(\'' + val['E0'] + '\')">' + EZ.del + '</a></td></tr>');

                i++;
            });
            return html.join('');
        };

        //全局方法,搜索所有的信息
        submitSearch();

        //checkbox联动
        linkage('#check-all', '.check-item');

        $('#select-notice-application').chosen({
            search_contains:true,
            width: '200px',
            placeholder_text_multiple:$.getMessage("sys_all")
        });
    }

    /**
     * @desc 绑定弹出框选择“通知应用”事件
     * @author zhengyu
     * @date 2016-11-04 16:59:01
     */
    function initSelectApplicationEven() {
        $(body).on('change', '#E1-dialog', function () {
            if ($(this).val() != '') {
                $.ajax({
                    type: "post",
                    async: false,
                    dataType: "json",
                    url: EZ.url + 'getrules',
                    data: {'paramId': $(this).val()},
                    success: function (json) {
                        if (json.state == 1) {
                            _genRuleTable(json.data);
                        } else {
                            _genRuleTable('');
                            alertTip('获取通知应用规则失败');
                        }
                    }
                });
            }
        });

        //绑定规则通知人、抄送选择事件
        $(body).on('click', '.select-rule-user', function () {
            _selectUserPanel($(this).data('val'), false);
        });

        $(body).on('click', '.select-rule-cc-user', function () {
            _selectUserPanel($(this).data('val'), true);
        });
    }

    /**
     * @desc 添加按钮事件
     * @author zhengyu
     * @date 2016-11-16 11:37:48
     */
    function initAdd(){
        $('#createButton').on('click', function(){
            _genAddAppDialogObj().EzWmsEditDataDialogX({
                editUrl: EZ.url + "edit",
                dWidth: '60%',
                dHeight: 'auto',
                dTitle: '添加业务',
                beforSubmit: _submitAddAppDialog
            });
        });
    }

    /**
     * @desc 初始化编辑按钮
     * @author zhengyu
     * @date 2016-11-08 21:41:16
     */
    function initEdit() {
        $(body).on('click', '.editItem', function(){
            var id = $(this).data('val');

            _genAddAppDialogObj().EzWmsEditDataDialogX({
                paramId: id,
                url: EZ.url + "get-by-json",
                editUrl: EZ.url + "edit",
                dWidth: '60%',
                dHeight: 'auto',
                dTitle: '修改业务',
                successCB: function(json){
                    if (json['EF6']){
                        _genRuleTable(json['EF6']);
                    }
                },
                beforSubmit: _submitAddAppDialog
            });
        });
    }

    /**
     * @desc 提交前先做的检查
     * @author zhengyu
     * @date 2016-11-24 10:02:46
     * @returns {boolean}
     * @private
     */
    function _submitAddAppDialog(){
        var $dialogRule = $('.rule-bg-div'),
            app = $dialogRule.find('#E1-dialog').val(),
            bussPerfix = $dialogRule.find('#E5').val(),
            bussName = $dialogRule.find('#E4').val();

        if (!app){
            alertTip('请选择通知应用');
            return false;
        }

        if (!bussPerfix){
            alertTip('请输入单号前缀');
            return false;
        }else{
            if (/[^_\-a-zA-Z0-9]/.test(bussPerfix)){
                alertTip('单号前缀仅支持字母，数字，下划线和中横线');
                return false;
            }
        }

        if (!bussName){
            alertTip('请输入通知业务名称');
            return false;
        }

        //遍历节点名称信息
        var emptyNoticeName = false;
        $dialogRule.find('.user-info').each(function(){
            if (!emptyNoticeName){
                if (!$(this).val()){
                    emptyNoticeName = true;
                }
            }
        });

        if (emptyNoticeName){
            alertTip('请选择通知人');
            return false;
        }

        return true;
    }

    /**
     * @desc 生成添加业务对话框对象
     * @author zhengyu
     * @date 2016-11-23 10:52:25
     * @returns {*|jQuery|HTMLElement}
     * @private
     */
    function _genAddAppDialogObj(){
        var dialogHtml = [];

        dialogHtml.push('<div><div class="rule-bg-div"><table class="dialog-module edit_business" border="0" cellpadding="0" cellspacing="0">');

        dialogHtml.push('<tbody><tr><td class="dialog-module-title">通知应用:</td><td><select title="通知应用" name="E1" id="E1-dialog" class="input_text2">');
        dialogHtml.push('<option value="">请选择</option>');

        for (var nai in noticeApplication){
            if (noticeApplication.hasOwnProperty(nai)){
                dialogHtml.push('<option value="'+noticeApplication[nai]['na_code']+'">'+ noticeApplication[nai]['nt_name'] + '-' + noticeApplication[nai]['na_name']+'</option>')
            }
        }

        dialogHtml.push('</select><input type="hidden" name="E0" id="E0" value=""/></td></tr>');
        dialogHtml.push('<tr><td class="dialog-module-title">状态:</td><td>');
        dialogHtml.push('<select title="状态" name="E2" id="E2" class="input_text2">');
        dialogHtml.push('<option value="2">草稿</option><option value="1">启用</option><option value="0">停用</option>');
        dialogHtml.push('</select></td></tr><tr><td class="dialog-module-title">单号前缀:</td><td>');
        dialogHtml.push('<input type="text" name="E5" id="E5" class="input_text" placeholder="仅支持字母，数字，下划线和中横线"/></td></tr>');
        dialogHtml.push('<tr><td class="dialog-module-title">名称:</td><td><input title="" type="text" name="E4" id="E4" class="input_text"/>');
        dialogHtml.push('</td></tr><tr><td class="dialog-module-title">内容:</td><td>');
        dialogHtml.push('<textarea title="" name="E6" id="E6" cols="30" rows="5"></textarea></td></tr></tbody></table>');
        dialogHtml.push('<div class="application-rule-div">');

        dialogHtml.push('<table class="table-module" style="width: 100%;" border="0" cellspacing="0" cellpadding="0"><tr class="table-module-title">');
        dialogHtml.push('<td>No.</td><td>名称</td><td>通知人</td><td>抄送人</td></tr></table>');

        dialogHtml.push('<table class="table-module" style="width: 100%;" border="0" cellspacing="0" cellpadding="0">');
        dialogHtml.push('<tbody><tr class="hide_title_tr table-module-title">');
        dialogHtml.push('<td></td><td></td><td></td><td></td></tr></tbody><tbody class="add-application-rule-table"></tbody></table>');
        dialogHtml.push('<input name="applicationRuleData" type="hidden" class="application-rule-data" />');

        dialogHtml.push('</div></div></div>');

        return $(dialogHtml.join(''));
    }

    /**
     * @desc 初始化删除事件
     * @author zhengyu
     * @date 2016-11-11 13:52:54
     */
    function initDel(){
        $(body).on('click', '#submit-to-delete', function(){
            var delIds = [];

            $('.check-item:checked').each(function () {
                delIds.push($(this).data('val'));
            });

            if (delIds.length > 0){
                $.ajax({
                    type: "POST",
                    async: false,
                    dataType: "json",
                    url: EZ.url + 'delete',
                    data: {'paramId': delIds},
                    success: function (json) {
                        if (json.state == 1) {
                            alertTip('删除成功');

                            submitSearch();
                        } else {
                            alertTip(json.message);
                        }
                    }
                });
            }
        });
    }

    /**
     * @desc 生成规则表格
     * @author zhengyu
     * @date 2016-11-04 17:23:48
     * @param ruleData
     * @private
     */
    function _genRuleTable(ruleData) {
        var html = [];

        for (var i in ruleData) {
            if (ruleData.hasOwnProperty(i)) {
                var name = '',
                    userName = '选择',
                    userRule = '',
                    userCccName = '选择',
                    userRuleCc = '';

                if (ruleData[i].hasOwnProperty('EF1')){
                    if (ruleData[i]['EF1'].hasOwnProperty('info') && ruleData[i]['EF1']['info'].length > 0){
                        userRule = JSON.stringify(ruleData[i]['EF1']['info']);
                        userName = ruleData[i]['EF1']['info'][0]['name'];
                    }

                    if (ruleData[i]['EF1'].hasOwnProperty('cc') && ruleData[i]['EF1']['cc'].length > 0){
                        userRuleCc = JSON.stringify(ruleData[i]['EF1']['cc']);
                        userCccName = ruleData[i]['EF1']['cc'][0]['name'];
                    }
                }

                if (i % 2 == 0){
                    html.push('<tr class="table-module-b1">');
                }else{
                    html.push('<tr class="table-module-b1 table-module-b2">');
                }

                html.push('<td>' + (parseInt(i) + 1) + '</td>');
                html.push('<td>' + ruleData[i]['E3'] + '</td>');
                html.push('<td><a id="select-rule-user-'+ ruleData[i]['E2'] +'" class="select-rule-user" href="javascript:void(0);" data-val="' + ruleData[i]['E2'] + '">'+userName+'</a>');
                html.push('<input class="user-info" id="user-info-'+ ruleData[i]['E2'] +'" name="selectRuleUser[]" type="hidden" value=\''+userRule+'\'></td>');
                html.push('<td><a id="select-rule-cc-user-'+ ruleData[i]['E2'] +'" class="select-rule-cc-user" href="javascript:void(0);" data-val="' + ruleData[i]['E2'] + '">'+userCccName+'</a>');
                html.push('<input id="user-info-cc-'+ ruleData[i]['E2'] +'" name="selectRuleCcUser[]" type="hidden" value=\''+userRuleCc+'\'></td><tr>');
            }
        }

        $(dialogEditAlertTip).find('.add-application-rule-table').html(html.join(''));
    }

    /**
     * @desc 生成选择用户面板
     * @author zhengyu
     * @date 2016-11-07 11:16:34
     * @private
     */
    function _selectUserPanel(code, isCc) {
        //生成弹框
        var dialogHtml = [];
        dialogHtml.push('<div title="选择通知人" id="dialog-edit-alert-tip" class="dialog-edit-alert-tip">');
        dialogHtml.push('<form id="editDataForm" name="editDataForm" class="submitReturnFalse">');

        //用户筛选
        dialogHtml.push('<div class="search-user-div">');
        dialogHtml.push('<div class="search-user-input-div"><input title="输入用户名" id="search-user-name" type="text">');
        dialogHtml.push('<input id="search-user-name-btn" type="button" value="搜索"/></div>');
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
                            nodes = treeObj.getNodes();

                        //判断当前节点是否全选
                        for (var ni in nodes) {
                            if (nodes.hasOwnProperty(ni)) {
                                if (nodes[ni]['type'] == 'group') {
                                    //是分组时判断选择树是否处于全选状态
                                    nodes[ni]['check_all'] = (userTreeObj.getNodeByParam('search-key', nodes[ni]['search-key']).check_Child_State == 2);
                                }

                                nodes[ni]['narCode'] = code;
                            }
                        }

                        //保存节点信息
                        if (!isCc){
                            $('#user-info-'+code).val(JSON.stringify(nodes));

                            if (nodes[0]['check_all']){
                                $('#select-rule-user-'+code).html(nodes[0]['name']);
                            }else{
                                $('#select-rule-user-'+code).html(nodes[0]['children'][0]['name']);
                            }

                        }else{
                            $('#user-info-cc-'+code).val(JSON.stringify(nodes));

                            if (nodes[0]['check_all']){
                                $('#select-rule-cc-user-'+code).html(nodes[0]['name']);
                            }else{
                                $('#select-rule-cc-user-'+code).html(nodes[0]['children'][0]['name']);
                            }
                        }

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
        var userData = _getUserData({});

        //生成选择后的用户列表
        _genUserTree('#selected-user', [], false);
        //用户列表
        _genUserTree('#user-tree', userData, true, {
            onCheck: _userTreeCheck
        });

        //绑定搜索事件
        $(body).on('click', '#search-user-name-btn', function () {
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
        $(body).on('click', '#clear-select-btn', function () {
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

    function setNoticeApplication(appJson){
        noticeApplication = JSON.parse(appJson);
    }

    return {
        'init': init,
        'setNoticeApplication': setNoticeApplication
    };
}