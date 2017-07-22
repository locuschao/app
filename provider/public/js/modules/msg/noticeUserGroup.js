function NoticeUserGroup(){
    var body = 'body',
        selectedUser = [];

    function init(){
        initEvn();

        //添加用户分组
        createGroup();

        // 编辑分组用户
        editGroupUser();

        //初始化删除事件
        initDel();

        // 删除分组用户
        deleteGroupUser();

        // 搜索用户
        searchUser();
    }

    /**
     * @desc 初始化环境
     * @author zhengyu
     * @date 2016-11-10 11:19:10
     */
    function initEvn(){
        EZ.url = '/msg/notice-user-group/';
        EZ.editUrl = '/msg/notice-user-group/edit';
        EZ.getListData = function (json) {
            var html = [];
            $.each(json.data, function (key, val) {
                html.push('<tr class="table-module-b2">');
                html.push('<td class="ec-center"><input class="check-item" type="checkbox" data-id="' + val['E0'] + '"></td>');
                html.push('<td>' + val['E2'] + '</td>');
                html.push('<td>' + val['E4'] + '</td>');
                html.push('<td>' + ((val['E3'] == 1)? 'Y' : 'N') + '</td>');
                html.push('<td>' + ((val['E1'] == 1)? '启用' : '未启用') + '</td>');
                html.push('<td>创建：' + val['E5'] + '<br>修改：' + val['E6'] + '</td>');
                html.push('<td>创建：' + val['E7'] + '<br>修改：' + val['E8'] + '</td>');
                html.push('<td><a href="javascript:editById(\'' + val['E0'] + '\')">' + EZ.edit + '</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:deleteById(\'' + val['E0'] + '\')">' + EZ.del + '</a></td>');
                html.push('</tr>');
                html.push('<tr><td style="background-color:#fff"></td><td colspan="6" class="group-user" style="border:0;" data-val="'+ val['E0'] +'">');
                html.push('<table class="settings" border="0" width="100%" cellspacing="0" cellpadding="0"><tbody><tr class="table-module-b1"><td colspan="6" style="text-align: left;border: 0;color:#0090e1;" title="编辑分组用户">组内用户：');

                // 分组组员
                for (var i in val['F1']) {
                    if (val['F1'].hasOwnProperty(i)){
                        html.push(val['F1'][i] + '、'); 
                    }
                }
                var template = html.pop();
                html.push(template.substring(0, template.length - 1));
                html.push('</td></tr></tbody></table></td><td style="background-color:#fff"></td></tr>');
            });
            return html.join('');
        };

        //全局方法,搜索所有的信息
        submitSearch();

        //checkbox联动
        linkage('#check-all', '.check-item');
    }


    // 添加用户分组
    function createGroup() {
        $('#createButton').on('click', function(){
            var div = $('#ez-wms-edit-dialog'),
                template = '<div title="添加用户分组" id="dialog-edit-alert-tip"' +
                    ' class="dialog-edit-alert-tip"><form id="editDataForm"' +
                    ' name="editDataForm" class="submitReturnFalse">' + div.html() +
                    '</form><div class="validateTips" id="validateTips"></div></div>';
            $(template).EzWmsEditDataDialog({
                dWidth: '500px',
                dHeight: '550px',
                paramId: 0,
                editUrl: EZ.editUrl
            });
        })
    }

    // 编辑分组用户
    function editGroupUser() {
        $(body).on('click', '.group-user', function(){
            var dialogHtml = [];
            dialogHtml.push('<div title="编辑分组用户" id="dialog-edit-alert-tip" class="dialog-edit-alert-tip user-group-div">');
            dialogHtml.push('<form id="editDataForm" name="editDataForm" class="submitReturnFalse">');

            //对话框主体
            dialogHtml.push('<div class="users"><div class="search-bar"><input type="text" placeholder="名称模糊搜索" class="search-text input_text" id="search-text">');
            dialogHtml.push('<input id="search-user" type="button" value="搜索" class="baseBtn search-user"/></div><div class="group-user-div">');
            dialogHtml.push('<table id="user-system-table" class="users-table">');
            dialogHtml.push('</table></div></div>');

            dialogHtml.push('<div class="user-selected">');
            dialogHtml.push('<ul><li class="top-li"><span>已选( <span id="selected-user-count">0</span> )</span><a href="javascript:void(0);" class="clear" id="clear-select">清空</a></li>');
            dialogHtml.push('<li class="user-selected-li"><table id="user-selecte-table" class="user-selected-table">');
            dialogHtml.push('</table></li></ul></div>');
            dialogHtml.push('<input name="paramId" type="hidden" value="'+$(this).data('val')+'" />');
            dialogHtml.push('</form><div class="validateTips" id="validateTips"></div></div>');

            var editdialog = $(dialogHtml.join('')).dialog({
                autoOpen: true,
                width: 'auto',
                maxHeight: 'auto',
                modal: true,
                show: "slide",
                buttons: [
                    {
                        text: "确定(Ok)",
                        click: function () {
                            $("#editDataForm").submit();
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


            $.ajax({
                type: "post",
                async: false,
                dataType: "json",
                url: EZ.url + 'get-group-user',
                data: {'paramId': $(this).data('val')},
                success: function (json) {
                    var systemUser = [];
                    //系统用户
                    for (var j in json['data']['su']){
                        if (json['data']['su'].hasOwnProperty(j)){
                            systemUser[json['data']['su'][j]['E0']] = json['data']['su'][j];
                        }
                    }

                    //获取已选择的用户信息
                    var userCount = 0;
                    selectedUser = [];
                    if (json.data.gu && json['data']['gu']['length'] > 0){
                        for (var i in json['data']['gu']){
                            if (json['data']['gu'].hasOwnProperty(i)){
                                selectedUser[json['data']['gu'][i]['E2']] = json['data']['gu'][i];
                                userCount++;
                            }
                        }
                    }
                    var $selectedUserCount = $('#selected-user-count');
                    $('#user-system-table').html(_genSystemUserTable(systemUser, selectedUser));
                    $('#user-selecte-table').html(_genGroupUserTable(selectedUser));
                    $selectedUserCount.html(parseInt($selectedUserCount.html()) + userCount);
                }
            });

            $("#editDataForm").myAjaxForm({api: EZ.url + 'edit-group-user', success: function(json){
                if (json.state == 1){
                    //全局方法,搜索所有的信息
                    submitSearch();

                    editdialog.dialog("close");
                }else{
                    alertTip(json.message);
                }
            }});
        });

        //绑定分组勾选事件
        linkage('#group-user-table', '.user-check', _userCheckEven, _userUnCheckEven);
    }

    /**
     * @desc 初始化删除事件
     * @author zhengyu
     * @date 2016-11-11 13:52:54
     */
    function initDel(){
        $(body).on('click', '#deleteButton', function(){
            var delIds = [];

            $('.check-item:checked').each(function () {
                delIds.push($(this).data('id'));
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
     * @desc 生成系统用户列表
     * @author zhengyu
     * @date 2016-11-10
     * @param data
     * @param selectedIds
     * @returns {string}
     * @private
     */
    function _genSystemUserTable(data, selectedIds){
        var html = [];

        html.push('<thead><tr><th><input id="group-user-table" type="checkbox"></th><th>名称</th></tr></thead>');

        if (data.length > 0){
            for (var i in data){
                if (data.hasOwnProperty(i)){
                    var id = data[i]['E0'];

                    html.push('<tr>');
                    html.push('<td><input name="userIds[]" type="checkbox" class="user-check" value="'+data[i]['E0']+'" data-uname="'+data[i]['E3']+'" '+ (selectedIds.hasOwnProperty(id) ? 'checked' : '') +'></td>');
                    html.push('<td class="user-name">'+data[i]['E3']+'</td>');
                    html.push('</tr>');
                }
            }
        }

        return html.join('');
    }

    /**
     * @desc 生成分组用户列表信息
     * @author zhengyu
     * @date 2016-11-10 18:09:25
     * @param data
     * @returns {string}
     * @private
     */
    function _genGroupUserTable(data){
        var html = [];

        html.push('<thead><tr><th>名称</th><th>操作</th></tr></thead>');

        if (data.length > 0){
            for (var i in data){
                if (data.hasOwnProperty(i)){
                    html.push('<tr>');
                    html.push('<td>'+data[i]['EF1']+'</td>');
                    html.push('<td><a href="javascript:void(0);" data-val="'+data[i]['E2']+'" class="delete-user">删除</a></td>');
                    html.push('</tr>');
                }
            }
        }

        return html.join('');
    }

    /**
     * @desc 用户勾选触发事件
     * @author zhengyu
     * @date 2016-11-11 09:55:38
     * @param checkObj
     * @private
     */
    function _userCheckEven(checkObj){
        checkObj = $(checkObj);

        //装入以选择用户列表
        selectedUser[checkObj.val()] = {'EF1': checkObj.data('uname'), 'E2': checkObj.val()};
        $('#user-selecte-table').html(_genGroupUserTable(selectedUser));
        //重置计数
        _setCount()
    }

    /**
     * @desc 用户取消勾选触发事件
     * @author zhengyu
     * @date 2016-11-11 09:55:38
     * @param checkObj
     * @private
     */
    function _userUnCheckEven(checkObj){
        checkObj = $(checkObj);

        if (selectedUser.hasOwnProperty(checkObj.val())){
            var tmp = [];
            for (var i in selectedUser){
                if (i != checkObj.val()){
                    tmp[i] = selectedUser[i];
                }
            }

            selectedUser = tmp;
        }

        $('#user-selecte-table').html(_genGroupUserTable(selectedUser));
        //重置计数
        _setCount();
    }

    function _setCount(){
        var $selectedUserCount = $('#selected-user-count'),
            count = 0;

        $('.user-check:checked').each(function(){
            count++;
        });

        $selectedUserCount.html(count);
    }

    // 删除分组用户
    var deleteGroupUser = function() {
        $(body).on('click', '.delete-user', function() {
            var self = $(this),
                userId = self.data('val'),
                userList = $('#user-system-table');
            self.closest('tr').remove();
            userList.find('tbody tr td input[value="' + userId + '"]').prop('checked', false);
            selectedUser.splice(userId, 1);
            //重置计数
            _setCount();
        })

        $(body).on('click', '#clear-select', function() {
            var userSelect = $('#user-selecte-table').find('tbody'),
                userList = $('#user-system-table');
            userSelect.empty();
            userList.find('tbody tr td input').prop('checked', false);
            selectedUser = [];
            //重置计数
            _setCount();
        })
    }

    // 搜索用户
    var searchUser = function() {
        $(body).on('click', '#search-user', function() {
            var keyWord = $('#search-text').val(),
                userName = $('.user-name');
            userName.removeClass('bingo');
            if (userName != undefined) {
                $.each(userName, function(index, item) {
                    var item = $(item);
                    if (item.text().indexOf(keyWord) >= 0) {
                        item.addClass('bingo');
                    }
                })
            }
            return ;
        })
    }

    return {
        'init': init
    }
}