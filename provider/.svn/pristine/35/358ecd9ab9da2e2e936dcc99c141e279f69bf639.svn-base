EC.addMods({
    "filterActionId": function () {
        var self = this, params = this.urlParams;
        var $this = this.$element;
        this.init = function () {
            var quick = null;
            var quickData = '';
            var sName = 'quickData_';
            var sHtml = "";
            if ($(this).attr('refUid') != '' && $(this).attr('refUid')!=null ) {
                params["quick"] = $(this).attr('refUid');
            }
            var getLoadData = function (call) {
                $.ajax({
                    type: "POST",
                    async: true,
                    dataType: "json",
                    url: "/default/system/get-Search-Filter/quick/" + quick,
                    success: function (json) {
                        if (json.state == '1' && isJson(json)) {
                            quickData = json.data;
                            call('');
                            if (sessionStorage && typeof JSON !== 'undefined') {
                                sessionStorage.setItem('version', EZ.version);
                                sessionStorage.setItem(sName + quick, JSON.stringify(quickData));
                            }
                        }
                    }
                });

            };
            var setHtml = function (data) {
                sHtml += '<div style="padding:0" class="pack_manager_content">';
                sHtml += '<table width="100%" border="0" cellpadding="0" cellspacing="0"  id="searchfilterArea" class="searchfilterArea"><tbody>';
                data = data == '' ? quickData : data;
                $.each(data, function (key, val) {
                        var fId = '';
                        sHtml += '<tr><td><div class="searchFilterText">'
                        sHtml += val.search_label + '：</div><div class="pack_manager">';
                        if(!val.item){
                            return;
                        }
                        $.each(val.item, function (key, val) {
                                if (fId != val.search_input_id && val.search_input_id != '') {
                                    sHtml += '<input type="hidden" name="' + val.search_input_id + '" id="' + val.search_input_id + '" class="input_text keyToSearch" />';
                                    fId = val.search_input_id;
                                }
                                var tmpOnclik = 'searchFilterSubmit(' + "'" + val.search_input_id + "'" + ',' + "'" + val.search_value + "'" + ',' + "this" + ')';
                                sHtml += '<a href="javascript:void(0)" onclick="' + tmpOnclik + '">';
                                sHtml += val.search_label + '</a>';
                            }
                        );
                        sHtml += '</div></td></tr>';
                    }
                );
                sHtml += "</tbody></table></div>";
                $this.parent().prepend(sHtml);
                $(".searchFilterText").css('width', $this.val() + 'px');
            };

            if (quick = params["quick"]) {
                if (sessionStorage && typeof JSON !== 'undefined') {
                    var sStorage = sessionStorage;
                    if (sStorage.getItem(sName + quick) && sStorage.getItem(sName + quick) != "undefined" && sStorage.getItem(sName + quick) != "" && sStorage.getItem('version') == EZ.version) {
                        quickData = JSON.parse(sStorage.getItem(sName + quick));
                        setHtml(quickData);
                    } else {
                        getLoadData(setHtml);
                    }
                } else {
                    getLoadData(setHtml);
                }
            }
        };
    }
});