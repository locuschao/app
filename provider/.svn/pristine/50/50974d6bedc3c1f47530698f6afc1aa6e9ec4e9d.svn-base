function NoticeApplication(){
    var body = 'body',
        noticeTypeObj = { },
        ruleNumber = 0,
        ruleObj = { };

    function init(){
        initEvn();

        //绑定添加按钮
        bindAddApplicationBtn();

        //初始化添加节点按钮
        initAddApplicationRuleBtn();

        //初始化搜索
        submitSearch();

        //关联勾选框
        linkage('#check-all', '.check-item');

        //绑定批量删除
        initDelAllBtn();

        //绑定编辑按钮
        initEditAppBtn();

        //绑定删除按钮
        initDelBtn();

        initNoticeEve();
    }

    /**
     * @desc 初始化环境
     * @author zhengyu
     * @date 2016-11-23 09:36:35
     */
    function initEvn(){
        EZ.url = '/msg/notice-application/';
        EZ.getListData = function (json) {
            var html = [];
            var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
            $.each(json.data, function (key, val) {
                html.push(((key + 1) % 2 == 1 ? '<tr class="table-module-b1">' : '<tr class="table-module-b2">'));
                html.push('<td class="ec-center"><input class="check-item" type="checkbox" data-val="' + val['E0'] + '" /></td>');
                html.push('<td>' + i + ' : ' + val['E3'] + ' / ' + val['E2'] + '</td>');
                html.push('<td>' + (val['E9'] == 1 ? '系统' : '客户') + '</td>');
                html.push('<td>' + (val['E_F1'] ? val['E_F1'] : '') + '</td>');
                html.push('<td>' + (val['E4'] == 1 ? '启用' : '停用') + '</td>');
                html.push('<td>创建：' + (val['E_F2'] ? val['E_F2'] : '系统') + '<br/>修改：' + (val['E_F3'] ? val['E_F3'] : '系统') + '</td>');
                html.push('<td>创建：' + val['E7'] + '<br/>修改：' + val['E8'] + '</td>');

                html.push('<td><a class="edit-app-btn" data-val="' + val['E0'] + '" >' + EZ.edit + '</a>');
                html.push('&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:deleteById(' + val['E0'] + ')">' + EZ.del + '</a></td>');
                html.push('</tr>');

                i++;
            });
            return html.join('');
        };
    }

    /**
     * @desc 绑定添加应用按钮
     * @author zhengyu
     * @date 2016-11-23 10:04:51
     */
    function bindAddApplicationBtn(){
        //绑定添加按钮
        $(body).on('click', '#createButton', function(){
            _genAddAppDialogObj().EzWmsEditDataDialogX({
                editUrl: EZ.url + "edit",
                dWidth: '60%',
                dHeight: 'auto',
                dTitle: '添加应用',
                beforClose: _closeAddAppDialog,
                beforSubmit: _submitAddAppDialog
            });
        });

        //绑定代码输入框，只能输入字母，数字，下划线和中横线
        $(body).on('keyup', '.dialog-add-app #E2', function(){
            var reg = /[^\-_a-zA-Z0-9]/g,
                val = $(this).val();

            if (reg.test(val)){
                alertTip('代码，仅支持字母，数字，下划线和中横线');
                $(this).blur();
            }
        });
    }

    /**
     * @desc 生成添加应用对话框对象
     * @author zhengyu
     * @date 2016-11-23 10:52:25
     * @returns {*|jQuery|HTMLElement}
     * @private
     */
    function _genAddAppDialogObj(){
        var dialogHtml = [];
        dialogHtml.push('<div><div class="dialog-add-app">');
        dialogHtml.push('<table class="dialog-module application-edit">');
        dialogHtml.push('<tbody><tr><td>&nbsp;<input type="hidden" name="E0" id="E0" value=""/></td></tr><tr><td class="dialog-module-title">类型:</td>');
        dialogHtml.push('<td><select title="类型" name="E1" id="E1-NT" class="input_text2"><option value="">请选择</option>');

        for (var nti in noticeTypeObj){
            if (noticeTypeObj.hasOwnProperty(nti)){
                dialogHtml.push('<option value="' + noticeTypeObj[nti]['nt_code'] + '">' + noticeTypeObj[nti]['nt_name'] +'</option>');
            }
        }

        dialogHtml.push('</select></td></tr><tr><td class="dialog-module-title">状态:</td><td>');
        dialogHtml.push('<select title="状态" name="E4" id="E4" class="input_text2">');
        dialogHtml.push('<option value="1">启用</option><option value="0">停用</option></select></td></tr>');
        dialogHtml.push('<tr><td class="dialog-module-title">名称:</td><td><input title="" type="text" name="E3" id="E3" class="input_text"/>');
        dialogHtml.push('</td></tr><tr><td class="dialog-module-title">代码:</td><td>');
        dialogHtml.push('<input title="" type="text" name="E2" id="E2" class="input_text" placeholder="仅支持字母，数字，下划线和中横线"/></td>');
        dialogHtml.push('</tr><tr><td class="dialog-module-title"></td><td>Tips：该代码保存后，不能修改</td></tr></tbody></table>');

        dialogHtml.push('<div class="application-rule-div">');
        dialogHtml.push('<p><input id="add-application-rule-btn" class="baseBtn" type="button" value="添加节点"/></p>');

        dialogHtml.push('<table class="table-module" border="0" cellpadding="0" cellspacing="0"><tr class="table-module-title">');
        dialogHtml.push('<td>NO.</td><td width="40%">名称</td><td>排序</td><td>操作</td>');
        dialogHtml.push('</tr></table>');

        dialogHtml.push('<div class="add-application-rule-div"><table class="table-module add-application-rule-table" style="width: 100%;" cellspacing="0" cellpadding="0" border="0">');
        dialogHtml.push('<tr class="hide_title_tr table-module-title"><td></td><td width="40%"></td><td></td><td></td></tr>');
        dialogHtml.push(_genRuleTable({ }) + '</table></div>');
        dialogHtml.push('<input name="applicationRuleData" type="hidden" class="application-rule-data" value="0"/></div></div></div>');

        return $(dialogHtml.join(''));
    }

    /**
     * @desc 关闭添加应用对话框时触发的函数
     * @author zhengyu
     * @date 2016-11-23 16:40:25
     * @private
     */
    function _closeAddAppDialog(){
        ruleNumber = 0;
        ruleObj = { };
    }

    /**
     * @desc 提交前先做的检查
     * @author zhengyu
     * @date 2016-11-24 10:02:46
     * @returns {boolean}
     * @private
     */
    function _submitAddAppDialog(){
        var $dialogAddApp = $('.dialog-add-app'),
            appType = $dialogAddApp.find('#E1-NT').val(),
            appName = $dialogAddApp.find('#E3').val(),
            appCode = $dialogAddApp.find('#E2').val();

        if (!appType){
            alertTip('请选择应用类型');
            return false;
        }

        if (!appName){
            alertTip('请输入应用名称');
            return false;
        }

        if (!appCode){
            alertTip('请输入应用代码');
            return false;
        }else{
            var reg = /[^\-_a-zA-Z0-9]/g;

            if (reg.test(appCode)){
                alertTip('代码，仅支持字母，数字，下划线和中横线');
                return false;
            }
        }

        //遍历节点名称信息
        var emptyName = false;
        $dialogAddApp.find('.rule-name').each(function(){
            if (!emptyName){
                if (!$(this).val()){
                    emptyName = true;
                }
            }
        });

        if (emptyName){
            alertTip('请输入节点名称');
            return false;
        }

        //遍历节点等级信息
        var emptyLevel = false;
        $dialogAddApp.find('.rule-level').each(function(){
            if (!emptyLevel){
                if (!$(this).val()){
                    emptyLevel = true;
                }
            }
        });

        if (emptyLevel){
            alertTip('请输入节点排序值');
            return false;
        }

        return true;
    }

    //初始化添加规则按钮
    function initAddApplicationRuleBtn(){
        $(body).on('click', '#add-application-rule-btn', function(){
            var noticeType = $('#editDataForm').find('#E1-NT').val();

            if (noticeType){
                var $addApplicationRuleTable = $('.add-application-rule-table'),
                    ruleNum = $addApplicationRuleTable.find('.table-module-b1').length,
                    isEven = ((ruleNum + 1) % 2 == 0);

                if (noticeType == 'MSG' || noticeType == 'WARN'){
                    if (ruleNum == 0){
                        $addApplicationRuleTable.append(_genRuleTableItem({
                            code: '',
                            name: '',
                            level: ''
                        }, isEven, ruleNum + 1, false));
                    }else{
                        alertTip('通知和警告只能添加一个节点');
                    }
                }else{
                    $addApplicationRuleTable.append(_genRuleTableItem({
                        code: '',
                        name: '',
                        level: ''
                    }, isEven, ruleNum + 1, false));
                }
            }else{
                alertTip('请选择应用类型');
            }


        });

        //关联勾选框
        linkage('#rule-check-all', '.rule-check-item');

        //绑定节点排序输入验证
        $(body).on('keyup', '.rule-level', function(){
            if (!/^[1-9][0-9]*$/.test($(this).val())){
                alertTip('排序值格式错误，请输入数字，并且最小值为1');
            }
        });

        //绑定升降等级方法
        $(body).on('click', '.up-level', function(){
            var $tr = $(this).parent().parent();

            $prev = $tr.prev('.table-module-b1');

            //对换no
            $trRuleNo = $tr.find('.application-rule-no').html();
            $applicationRuleNo = $prev.find('.application-rule-no').html();
            $prev.find('.application-rule-no').html($trRuleNo);
            $tr.find('.application-rule-no').html($applicationRuleNo);

            if ($prev.length >= 1){
                $tr.remove();
                $prev.before($tr);

                if ($tr.hasClass('table-module-b2')){
                    $tr.removeClass('table-module-b2');
                    $prev.addClass('table-module-b2');
                }else{
                    $prev.removeClass('table-module-b2');
                    $tr.addClass('table-module-b2');
                }
            }
        });

        $(body).on('click', '.down-level', function(){
            var $tr = $(this).parent().parent();

            $prev = $tr.next('.table-module-b1');

            //对换no
            $trRuleNo = $tr.find('.application-rule-no').html();
            $applicationRuleNo = $prev.find('.application-rule-no').html();
            $prev.find('.application-rule-no').html($trRuleNo);
            $tr.find('.application-rule-no').html($applicationRuleNo);

            if ($prev.length >= 1){
                $tr.remove();
                $prev.after($tr);

                if ($tr.hasClass('table-module-b2')){
                    $tr.removeClass('table-module-b2');
                    $prev.addClass('table-module-b2');
                }else{
                    $prev.removeClass('table-module-b2');
                    $tr.addClass('table-module-b2');
                }
            }
        });
    }

    /**
     * @desc 生成规则表格
     * @author zhengyu
     * @date 2016-11-02 15:57:47
     * @private
     */
    function _genRuleTable(ruleInfo, readOnly){
        var html = [];

        readOnly = readOnly ? readOnly : false;

        html.push('');

        var ruleNo = 1;
        for (var code in ruleInfo){
            if (ruleInfo.hasOwnProperty(code)){
                if (ruleNo % 2 == 0){
                    html.push(_genRuleTableItem(ruleInfo[code], true, ruleNo, readOnly));
                }else{
                    html.push(_genRuleTableItem(ruleInfo[code], false, ruleNo, readOnly));
                }

                ruleNo++;
            }
        }

        return html.join('');
    }

    function _genRuleTableItem(ruleItem, isEven, number, readOnly){
        var html = [],
            readOnlyStr = '';

        if (isEven){
            html.push('<tr class="table-module-b1 table-module-b2">');
        }else{
            html.push('<tr class="table-module-b1">');
        }

        if (readOnly){
            readOnlyStr = 'disabled="disabled"';
        }

        html.push('<td class="application-rule-no">' + (number ? number : 1) + '</td>');
        html.push('<td class="application-rule-name" width="40%"><input class="rule-name" name="rulename[]" type="text" value="'+ ruleItem['name'] +'" '+ readOnlyStr +'/></td>');
        html.push('<td><a href="javascript:void(0)" class="up-level">↑</a>&nbsp;&nbsp;<a href="javascript:void(0)" class="down-level">↓</a>');
        html.push('</td>');
        html.push('<td><input name="nar_id[]" type="hidden" value="'+ (ruleItem['id'] ? ruleItem['id'] : '') +'" /><a class="del-rule-btn">删除</a></td>');
        html.push('</tr>');

        return html.join('');
    }

    /**
     * @desc 绑定批量删除按钮
     * @author zhengyu
     * @date 2016-11-23 18:32:40
     */
    function initDelAllBtn(){
        $(body).on('click', '#submit-to-delete', function(){
            var delIds = [];

            $('.check-item:checked').each(function () {
                delIds.push($(this).data('val'));
            });

            if (delIds.length > 0){
                $.EzWmsDel(
                    {
                        paramId: delIds,
                        Field: "paramId",
                        url: EZ.url + "delete"
                    }, submitSearch
                );
            }
        });
    }

    function initEditAppBtn(){
        $(body).on('click', '.edit-app-btn', function(){
            _genAddAppDialogObj().EzWmsEditDataDialogX({
                paramId: $(this).data('val'),
                url: EZ.url + "get-by-json",
                editUrl: EZ.url + "edit",
                dWidth: '800px',
                dHeight: 'auto',
                dTitle: '编辑应用',
                successCB: _editCallBack,
                beforSubmit: _submitAddAppDialog
            });
        });
    }

    function _editCallBack(jsonData){
        //整理数据
        var ruleArr = [];

        for(var i in jsonData['E_F5']){
            if (jsonData['E_F5'].hasOwnProperty(i)){
                ruleArr.push({
                    'id': jsonData['E_F5'][i]['E0'],
                    'name': jsonData['E_F5'][i]['E3'],
                    'code': jsonData['E_F5'][i]['E2'],
                    'level': jsonData['E_F5'][i]['E4']
                });
            }
        }

        //禁止编辑代码
        var $applicationEdit = $('.application-edit');
        $applicationEdit.find('#E2').attr('disabled', 'disabled');

        //如果为系统创建应用，只读
        if (jsonData['E5'] == '0'){
            $applicationEdit.find('#E1-NT').attr('disabled', 'disabled');
            $applicationEdit.find('#E4').attr('disabled', 'disabled');
            $applicationEdit.find('#E3').attr('disabled', 'disabled');

            $buttonObjs = $('.ui-dialog-buttonset').find('button');
            $($buttonObjs[0]).attr('disabled', 'disabled');
            $($buttonObjs[0]).attr('title', '系统应用禁止修改');

            $('.add-application-rule-table').append(_genRuleTable(ruleArr, true));
        }else{
            $('.add-application-rule-table').append(_genRuleTable(ruleArr, false));
        }


    }

    function initDelBtn(){
        $(body).on('click', '.del-rule-btn', function(){
            $(this).parent().parent().remove();
        });
    }

    function initNoticeEve(){
        $(body).on('change', '#E1-NT', function(){
            $('.add-application-rule-table').html(_genRuleTable({}, false));
        });
    }

    function setNoticeType(typeJson){
        noticeTypeObj = JSON.parse(typeJson);
    }

    return {
        'init': init,
        'setNoticeType': setNoticeType
    };
}

