<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>实物上架</title>
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui-1.9.2.custom.min.js"></script>
    <style type="text/css">
        ul {
            list-style: none;
        }

        * {
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 25px;
        }

        html, body {
            border: 0px solid #333333;
            color: #333333;
            font: 12px/150% Arial, Helvetica, sans-serif, '宋体';
            margin: 0;
            padding: 0;
            font-family: Arial, Tahoma, Verdana, sans-serif;
            font-size: 12px;
        }

        .main {
            width: 100%;
            height: auto;
        }

        .main-header {
            height: 35px;
            line-height: 35px;
            background: #e8e8e8;
            font-size: 14px;
            border-bottom: 1px solid #ccc;
            text-indent: 5px;
            width: 100%;
        }

        .main-header div {
            line-height: 34px;
        }

        .main-container {
            width: 100%;
            height: auto;
        }

        .main-container li {
            width: 100%;
            text-align: center;
            height: 30px;
            line-height: 30px;
            padding-top: 4px;
        }

        .putaway-info {
            border: 1px solid #ccc;
            margin: 2px 0 2px 0;
            text-align:center;
        }
        .putaway-info table{
            text-align:center;
            margin:auto;
        }

        a:active {
            text-decoration: underline;
        }

        .inputCss {
            width: 160px;
            height: 25px;
            border: 1px solid #ccc;
            margin: 0 0 0 0px;
            padding: 0 0 0 5px;
            font-size:14px;
        }

        .code {
            font-weight: bold;
        }

        .bold {
            font-weight: bold;
        }

        .title {
            text-align:left;
            width:60px;
        }

        .content {
            text-align: left;
        }

        #putaway-button {
            width: 100%;
            padding-top: 10px;
        }

        #vaid-msg {
            color: red;
            font-weight: bold;
        }

        #submit-putaway {
            border: none;
            background-color: #CCC;
            width: 60%;
            height: 30px;
            line-height: 30px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<script type="text/javascript">
    $(function () {
        $("#operationCode").focus();
        $(".submitReturnFalse").submit(function () {
            return false;
        });
        $("#operationCode").keyup(function (e) {
            var key = e.which;
            if (key == 13) {
                submitSearch();
            }
        });
        $("#lc_code").keyup(function (e) {
            var key = e.which;
            if (key == 13) {
                var code = $(this).val();
                if (code == '') {
                    $(this).css("background-color", "#FFFFCC");
                    return;
                }
                if (confirm('确认上架吗')) {
                    submitPutaway();
                }else{
                    $("#lc_code").focus().select();
                }
            }
        });
        $("#submit-putaway").keyup(function (e) {
            var key = e.which;
            if (key == 13) {
                submitPutaway();
            }
        });
    });

    function alertMessage(tip) {
        $("#vaid-msg").html(tip);
    }


    function submitSearch() {
        $("#putaway-button").hide();
        $("#lcCode").hide();
        $("#lc_code").val('');
        var obj = $("#operationCode");
        var code = obj.val();
        if (code == '') {
            obj.css("background-color", "#FFFFCC");
            return;
        }
        $.ajax({
            type: "POST",
            async: false,
            dataType: "json",
            url: "/default/pda/get-putaway-by-json",
            data: {
                'operationCode': code,
                'operationType': '0'
            },
            success: function (json) {
                if (json.state == '1') {
                    var data = json.data;
                    var html = '';
                    var title = '';
                    $.each(data, function (key, val) {
                        title = val.product.product_title;
                        title = title.length > 15 ? title.substring(0, 15) + '...' : title;
                        html += "<input type='hidden' value='" + val.E0 + "' name='pdId' >";
                        html += '<table cellpadding="0" align="center" width="231">';
                        html += '<tr>';
                        html += '<td class="title">产品代码：</td>';
                        html += "<td class='content bold'>" + val.E7 + "<input type='hidden' value='" + val.E7 + "' name='product_barcode'></td>";
                        html += '</tr>';

                        html += '<tr style="display:none;">';
                        html += '<td class="title">货品名称：</td>';
                        html += '<td class="content">' + title + '</td>';
                        html += '</tr>';

                        html += '<tr>';
                        html += '<td class="title">上架数量：</td>';
                        html += '<td class="content bold">' + val.E9 + '</td>';
                        html += '</tr>';

                        html += '<tr>';
                        html += '<td class="title">推荐货架：</td>';
                        html += '<td class="content bold">' + val.lc_code + '</td>';
                        html += '</tr>';
                        html += '</table>';

                    });
                    $("#putaway-info").html(html);
                    $("#putaway-button").show();
                    $("#lcCode").show();
                    $("#lc_code").focus();
                } else {
                    $("#operationCode").focus().select();
                    alertMessage('没有找到记录');
                }
            }
        });
    }

    function submitPutaway() {
        if ($.trim($("#lc_code").val()) == '') {
            $("#lc_code").focus().select();
            alertMessage('货位号不能为空.');
            return;
        }
        $.ajax({
            type: "post",
            async: false,
            dataType: "json",
            url: "/default/pda/putaway",
            data: $("#putawayForm").serialize(),
            success: function (json) {
                var html = '';
                if (json.state == '1') {
                    html += '<span>' + json.message + '</span>';
                    $("#putaway-button").hide();
                    $("#putaway-info").html('');
                    $("#lcCode").hide();
                    $("#operationCode").focus().select();
                } else {
                    $.each(json.error, function (k, v) {
                        html += '<span>' + v.errorMsg + '</span>';
                    });
                    $("#lc_code").focus().select();
                }
                alertMessage(html);
                return;
            }
        });
    }
</script>
<div style="text-align:center;margin: auto">
    <div class="main">
        <div class="main-header">
            <div style="float:left;padding-left:10px"><a href="/default/pda/main">导航</a>&nbsp;>&nbsp;实物上架</div>
            <div style="float:right;padding-right:10px"><a href="/default/pda/logout">退出</a></div>
        </div>
        <form id="putawayForm" name="putawayForm" class="submitReturnFalse">
            <div class="main-container">
                <ul>
                    <li>质检单号：<input name="operationCode" id="operationCode" type="text" class="inputCss code"></li>
                </ul>
            </div>
            <div class="putaway-info" id="putaway-info">
            </div>
            <div id="lcCode" style="display:none">
                <ul>
                    <li>货位条码：<input name="lc_code" id="lc_code" type="text" class="inputCss code"></li>
                </ul>
            </div>
            <div id="vaid-msg">
            </div>
            <div id="putaway-button-" style="display:none">
                <input id="submit-putaway" class="baseBtn" type="button" value="确认上架">
            </div>
        </form>
    </div>
</div>
</body>
</html>