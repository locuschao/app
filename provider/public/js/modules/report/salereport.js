function SaleReport () {
    var init = function() {
        initList();
        initTimePicker();

    }

    var initList = function() {
        EZ.url = '/report/Sale-Report/';
        EZ.getListData = function (json) {
            var html = '';
            var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
            $.each(json.data, function (key, val) {
                html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
                html += "<td class='ec-center'><input type='checkbox' class='checkItem' name='orderId[]' ref_id='"+val.E0+"' value='" + val.E0 + "'/></td>";
                html += "<td class='ec-center'>" + (i++) + "</td>";
                html += "<td class='ec-center'>" + val.E1 + "</td>";
                html += "<td class='ec-center'>" + val.E2 + "</td>";
                html += "<td class='ec-center'>" + val.E3 + "</td>";
                /*html += "<td class='ec-center'>" + val.E4 + "</td>";
                html += "<td class='ec-center'>" + val.E6 + "</td>";*/
                html += "<td class='ec-center'>" + val.E7 + "</td>";
                html += "<td class='ec-center'>" + val.E9 + "</td>";
                html += "<td class='ec-center'>" + val.E10 + "</td>";
                html += "<td class='ec-center'>" + val.E11 + "</td>";
                /*html += "<td class='ec-center'>" + val.E13 +  "</td>";
                html += "<td class='ec-center'>" + val.E14 + "</td>";*/
                html += "<td class='ec-center'>" + val.E15 +  "</td>";
                html += "<td class='ec-center'>" + val.E16 + "</td>";
                html += "<td class='ec-center'>" + ((val.E12 == '0000-00-00 00:00:00')? '' : moment(val.E12).format('YYYY-MM-DD')) + "</td>";
                /*html += "<td class='ec-center'>" + val.E17 +  "</td>";
                html += "<td class='ec-center'>" + val.E18 + "</td>";
                html += "<td class='ec-center'>" + val.E19 +  "</td>";
                html += "<td class='ec-center'>" + val.E20 + "</td>";
                html += "<td class='ec-center'>" + val.E21 +  "</td>";
                html += "<td class='ec-center'>" + val.E22 + "</td>";
                html += "<td class='ec-center'>" + val.E23 +  "</td>";
                html += "<td class='ec-center'>" + val.E24 + "</td>";
                html += "<td class='ec-center'>" + val.E25 +  "</td>";
                html += "<td class='ec-center'>" + val.E26 + "</td>";
                html += "<td class='ec-center'>" + val.E27 +  "</td>";
                html += "<td class='ec-center'>" + val.E28 + "</td>";
                html += "<td class='ec-center'>" + val.E29 +  "</td>";*/
                html += "</tr>";
            });
            return html;
        }
    }

    var initTimePicker = function() {
        var dayNamesMin = ['日', '一', '二', '三', '四', '五', '六'];
        var monthNamesShort = ['01月', '02月', '03月', '04月', '05月', '06月', '07月', '08月', '09月', '10月', '11月', '12月'];
        $.timepicker.regional['ru'] = {
            timeText : '选择时间',
            hourText : '小时',
            minuteText : '分钟',
            secondText : '秒',
            millisecText : '毫秒',
            currentText : '当前时间',
            closeText : '确定',
            ampm : false
        };
        $.timepicker.setDefaults($.timepicker.regional['ru']);
        $('.dateFrom,.dateEnd,.date').datetimepicker({
            dayNamesMin : dayNamesMin,
            monthNamesShort : monthNamesShort,
            changeMonth : true,
            changeYear : true,
            dateFormat : 'yy-mm-dd'
        });


    }


    return {
        'init': init
    }
}
