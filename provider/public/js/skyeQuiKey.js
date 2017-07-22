EC.addMods({
    "column": function () {
        var self = this, params = this.urlParams;
        var $this = this.$element;
        var getLoadData,getList;
        var setHtml;
        var userId = EZ.userId;
        var quickData = '';
        var sName = 'SkyeQuiKeyData_';
        var sHtml = "";
        this.init = function () {
            getLoadData = function (call) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    async: true,
                    url: "/default/system/get-Skye-Qui-Key",
                    success: function (json) {
                        if (json.state == '1' && isJson(json)) {
                            quickData = json.data;
                            call('');
                            if (sessionStorage && typeof JSON !== 'undefined') {
                                sessionStorage.setItem('version', EZ.version);
                                sessionStorage.setItem(sName + json.userId, JSON.stringify(quickData));
                            }
                        }else{
                            sHtml += '<dl><a href="javascript:void (0);" id="SkyeQuiKey"><dt><img src="/images/header/icon_nav088.png"/></dt><dd>添加</dd></a></dl>';
                            $this.parents().find(".nav2").html(sHtml);
                            $("#SkyeQuiKey").click(function () {
                                getList();
                            });
                        }
                    }
                });
            };
            setHtml = function (data) {
                sHtml = '';
                data = data == '' ? quickData : data;
                $.each(data, function (key, val) {
                        sHtml += '<dl title="'+val.title+'">';
                        sHtml += '<a href="javascript:void(0)" onclick=\'leftMenu("' + val.urlId + '","' + val.title + '","' + val.url + '?quick=' + val.urlId + '")\'>';
                        if (val.icon != '') {
                            sHtml += ' <dt><img src="/images/header/' + val.icon + '"/></dt>';
                        } else {
                            sHtml += ' <dt><img src="/images/header/20120326105253418.png"/></dt>';
                        }
                        sHtml += '<dd>' + val.title + '</dd></a>';
                        sHtml += '</dl>';
                    }
                );
                sHtml += '<dl><a href="javascript:void (0);" id="SkyeQuiKey"><dt><img src="/images/header/icon_nav088.png"/></dt><dd>添加</dd></a></dl>';
                $this.parents().find(".nav2").html(sHtml);
                $("#SkyeQuiKey").click(function () {
                    getList();
                });
            };

            if (sessionStorage && typeof JSON !== 'undefined') {
                var sStorage = sessionStorage;
                if (sStorage.getItem(sName + userId) && sStorage.getItem(sName + userId) != "undefined" && sStorage.getItem(sName + userId) != "" && sStorage.getItem('version') == EZ.version) {
                    quickData = JSON.parse(sStorage.getItem(sName + userId));
                    setHtml(quickData);
                } else {
                    getLoadData(setHtml);
                }
            } else {
                getLoadData(setHtml);
            }
        };
        getList=function(){
            var sHtml = '';
            checkAll = function (obj) {
                var cName = obj
                if ($('#'+cName).attr("checked") == 'checked') {
                    $('.' + cName).attr('checked', 'true');
                } else {
                    $('.' + cName).attr('checked', false);
                }
            };
            $.ajax({
                type: "POST",
                async: false,
                dataType: "json",
                url: "/default/system/get-Skye-Qui-Key-All-list",
                success: function (json) {
                    if (isJson(json) && json.state == '1') {
                        var data = json.data;
                        var menu = '';
                        var checkedCss = '';
                        var checked = '';
                        var topMenu='';
                        $.each(data, function (k, v) {
                            if (v.menu_id != menu && menu != '') {
                                sHtml += "</div>";
                            }
                            //顶级菜单
                            if(topMenu !=v.topMenu_id){
                                if(topMenu !=''){
                                    sHtml += "</div></div>";
                                }
                                topMenu=v.topMenu_id;
                                sHtml +="<div  id='search-module2' style='margin-bottom: 6px;padding: 0px 0px 5px 0px;'>";
                                sHtml += '<div class="allurl-module" style="margin-bottom: 2px;background:url(/images/base/bg_guild01.gif) repeat-x scroll 0% 0% transparent"><span  style="line-height: 28px;vertical-align: middle;" class="url-module-title"  ref="' + v.topMenu_id + '" >&nbsp;&nbsp;<b style="font-size: 13px;">' + v.topMenu + "</b></span></div>";
                                sHtml +='<div style="padding:0px 20px 0px 20px" >';
                            }
                            //二级菜单
                            if (v.menu_id != menu) {

                                menu = v.menu_id;
                                sHtml += "<div class='url-module'  style='height: 24px;border: 1px solid #CCC;background:url(/images/pack/bg_manage_form01.gif) repeat-x scroll 0px 0px transparent'>";
                                sHtml += '<input onclick="checkAll(\'checkbox' + menu + '\')" style="vertical-align: middle;" type="checkbox"   id="checkbox' + menu + '"><label onclick="checkAll(\'checkbox' + menu + '\')"  class="url-module-title" style="vertical-align: middle;cursor:pointer;" for="checkbox' + menu + '" >' + v.menu + "</label>";
                                sHtml += "</div>";
                                sHtml += "<div style='padding-top: 3px;' class='url-Box action_" + menu + "'>";
                            }
                            //低级菜单
                            checkedCss = v.selected == '1' ? 'url-checked' : '';
                            checked = v.selected == '1' ? 'checked' : '';
                            sHtml += "<div class='url-Box' style='line-height: 24px;'><label style='vertical-align: middle;cursor:pointer;'>";
                            sHtml += "<input style='vertical-align: middle;' type='checkbox' value='" + v.id + "' " + checked + "  name='actionId[" + v.id + "]' class='shortcutsKey checkbox" + menu + "' /><span style='vertical-align: middle;' class='" + checkedCss + "'>" + v.title + '</span>';
                            sHtml += "</label></div>";
                            //结束
                            if (k == (data.length-1)) {
                                sHtml += "</div>";sHtml += "</div></div>";
                            }

                        });
                    }
                }
            });
            $('<div title="快捷导航" id="dialog-SkyeQuiKey-alert-tip"><form id="editSkyeQuiKeyForm" name="editSkyeQuiKeyForm" class="submitReturnFalse">' + sHtml + '</form></div>').dialog({
                autoOpen: true,
                width: 650,
                maxHeight:500,
                modal: true,
                show: "slide",
                buttons: [
                    {
                        text: '确定(Ok)',
                        click: function () {
                            if ($(".shortcutsKey:checked").size() > 6) {
                                alertTip('只允许绑定六个以内.');
                                return false;
                            }
                            $.ajax({
                                type: "POST",
                                async: false,
                                dataType: "json",
                                data: $("#editSkyeQuiKeyForm").serializeArray(),
                                url: "/default/system/update-Skye-Qui-Key",
                                success: function (json) {
                                    if (isJson(json) && json.state == '1') {
                                        // location.reload();
                                        if (sessionStorage) {
                                            sessionStorage.removeItem(sName + userId);
                                        }
                                        getLoadData(setHtml);
                                    } else {
                                        alertTip('操作失败.');
                                    }
                                }
                            });
                            $('#dialog-SkyeQuiKey-alert-tip').dialog("close");
                        }
                    },
                    {
                        text: '取消(Cancel)',
                        click: function () {
                            $(this).dialog("close");
                        }
                    }
                ],
                close: function () {
                    $(this).detach();
                }
            });
            $(".url-module-title").click(function () {
                var isClass = $(this).attr('ref');
                var obj = $(".action_" + isClass);
                if (obj.css('display') == 'none') {
                    obj.show();
                } else {
                    obj.hide();
                }
            });
        }
    }
});