<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>获取货架号</title>
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
        }

        .putaway-info {
            border: 1px solid #ccc;
            margin: 2px 0 2px 0;
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
            width: 30%;
            text-align: right;
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
        $("#productBarcode").focus();
        $(".submitReturnFalse").submit(function () {
            return false;
        });
        $("#productBarcode").keyup(function (e) {
            var key = e.which;
            if (key == 13) {
                submitSearch();
            }
        });
    });

    function alertMessage(tip) {
        $("#vaid-msg").html(tip);
    }


    function submitSearch() {
        var obj = $("#productBarcode");
        $("#putaway-info").html('');
        alertMessage('');
        var code = obj.val();
        if (code == '') {
            obj.css("background-color", "#FFFFCC");
            return;
        }
        $.ajax({
            type: "POST",
            async: false,
            dataType: "json",
            url: "/default/pda/get-shelf",
            data: {
                'productBarcode': code
            },
            success: function (json) {
                if (json.state == '1') {
                    var data = json.data;
                    var html = '';
                    var title = '';
                        html += '<table cellpadding="0" align="center" width="100%">';
                        html += '<tr>';
                        html += '<td class="title">推荐货架：</td>';
                        html += '<td class="content bold">' + data.lc_code + '</td>';
                        html += '</tr>';
                        html += '</table>';
                    $("#putaway-info").html(html);
                    $("#productBarcode").focus().select();
                } else {
                    $("#productBarcode").focus().select();
                    alertMessage('没有找到记录');
                }
            }
        });
    }
</script>
<div style="text-align:center;margin: auto">
    <div class="main">
        <div class="main-header">
            <div style="float:left;padding-left:10px"><a href="/default/pda/main">导航</a>&nbsp;>&nbsp;获取货架号</div>
            <div style="float:right;padding-right:10px"><a href="/default/pda/logout">退出</a></div>
        </div>
        <form id="putawayForm" name="putawayForm" class="submitReturnFalse">
            <div class="main-container">
                <ul>
                    <li>产品代码：<input name="productBarcode" id="productBarcode" type="text" class="inputCss code"></li>
                </ul>
            </div>
            <div class="putaway-info" id="putaway-info">
            </div>
            <div id="vaid-msg">
            </div>
        </form>
    </div>
</div>
</body>
</html>