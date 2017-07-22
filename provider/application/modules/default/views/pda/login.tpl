<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>用户登录</title>
    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#userName").focus();
        });
        function enter(type) {
            if (type == '0') {
                $("#loginForm").submit();
                $("#userName").focus();
            } else {
                $("#userPass").focus();
            }
        }
    </script>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 25px;
        }

        #loginBox {
            width: 100%;
            border: 1px solid #ccc;
            background: #FFF;
        }

        h1 {
            height: 35px;
            line-height: 35px;
            background: #e8e8e8;
            font-size: 14px;
            border-bottom: 1px solid #ccc;
            text-indent: 5px;
        }

        .inputCss {
            width: 130px;
            height: 25px;
            border: 1px solid #ccc;
            margin: 0 0 0 0px;
            padding: 0 0 0 5px;
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
    </style>
</head>
<body>
<div style="text-align:center;margin: auto">
    <form name="login" id="loginForm" method="post" action="/default/pda/login">
        <div id="loginBox" style="text-align:left;margin: auto;">
            <h1>用户登录</h1>

            <div id="msg" style="margin-top:5px;margin-left:5px;font-size:13px;color:red;text-align:center;">
                <span><{$errMsg}></span></div>
            <div style="margin-top:5px;margin-left:5px;font-size:13px;">
                帐号：
                <input type="text" class="inputCss" name="userName" id="userName"
                       onkeyup="if(event.keyCode==13){enter(1)}"
                       onfocus="this.value=''" tabindex="1"/>
            </div>
            <div style="margin-top:5px;margin-left:5px;font-size:13px;margin-bottom: 5px;">
                密码：
                <input type="password" class="inputCss" id='userPass' name="userPass"
                       onkeyup="if(event.keyCode==13){enter(0)}" onfocus="this.value=''" tabindex="2"/>
            </div>
        </div>
    </form>
</div>
</body>
</html>