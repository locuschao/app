<style>
    .dialog-module td {
        padding: 10px 0px;
    }
</style>
<script language="javascript" src="/lodop/LodopFuncs.js"></script>
<script type="text/javascript" src="/lodop/lodop_print.js?V=20140729"></script>
<script type="text/javascript">
    //重新打印
    function getOrdersReprint2(code) {
        $.ajax({
            type: "post",
            async: false,
            dataType: "json",
            url: "/shipment/orders-one-pack/get-order-info",
            data:{
                orderCode:code
            },
            success: function (json) {
                var html = '';
                if (isJson(json)) {
                    if(json.state=='1'){
                        shipPrint2(json.data,json.data.order.sm_code);
                    }else{
                        alertTip(json.message);
                    }
                }
            }});
    }


    function shipPrint2(orderData, OperationCode) {
        var printMode = orderData.printMode.toLowerCase();
        printMode = orderData.labelError == 'y' && printMode == 'pdf' ? printMode + '_err' : printMode;
        switch (printMode){
            case 'pdf':
                var url = lodopDomain + "default/system/print-label/orderCode/" + orderData.order.order_code + "/t/" + (new Date().getTime());
                //alertTip("打印PDF中,请稍等...");
                if ($("#pdfIframeWrap").size()) {
                    $("#iframePrint").attr("src", url);
                    setTimeout(function () {
                        $("#iframePrint").load(function () {
                            $("#dialog-auto-alert-tip").dialog("close");
                        });
                    }, 1000);
                } else {
                    $("#module-container").prepend("<div id='pdfIframeWrap' style='height:1px;width:1px;'><iframe id='iframePrint' src='" + url + "' frameborder='0' scrolling='no' noresize='noresize' style='width: 100%; height: 100%;'></iframe></div>");
                    setTimeout(function () {
                        $("#dialog-auto-alert-tip").dialog("close");
                    }, 3000);
                }
                //判断是否加载完成
                if ($("#iframePrint").size()) {
                    var iframe = document.getElementById("iframePrint");
                    iframe.src=url;
                    if (iframe.attachEvent){
                        iframe.attachEvent("onload", function(){
                            $("#iframePrint").attr("src", '#');
                        });
                    }else{
                        iframe.onload = function(){
                            $("#iframePrint").attr("src", '#');
                        };
                    }
                }
                return;
                break;
            case 'script':
                if (!LODOP) {
                    LODOP = getLodop(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
                }
                var printerNo = getPrinterNo('stylus_printer');
                if (printerNo === null) {
                    printerSetup();
                    return;
                }
                LODOP.SET_PRINTER_INDEX(printerNo);
                LODOP.SET_LICENSES(lodopCp, lodopKey, lodopToken, "");
                var url = lodopDomain + "default/system/get-script/orderCode/" + orderData.order.order_code + "/t/" + (new Date().getTime());
                $.ajax({
                    type: "POST",
                    async: false,
                    url: url,
                    dataType: 'script',
                    success: function () {
                        print_lodop();
                    }
                });
                //统一指向HTML打印
                /*
                 var url = lodopDomain + "default/system/get-script/orderCode/" + orderData.order.order_code + "/t/" + (new Date().getTime());
                 $.getScript(url, function (data, textStatus, json) {
                 if (json.status == '200') {
                 print_lodop();
                 }
                 });
                 */
                break;
            case 'gif-old':
                if (!LODOP) {
                    LODOP = getLodop(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
                }
                var l = -1.5, t = 0;
                var printerNo = getPrinterNo(OperationCode);
                if (printerNo === null) {
                    printerSetup();
                    return;
                }

                if (!LODOP) {
                    LODOP = getLodop(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
                }
                var printerNo = getPrinterNo(orderData.order.sm_code);
                LODOP.SET_PRINTER_INDEX(printerNo);
                LODOP.SET_LICENSES(lodopCp, lodopKey, lodopToken, "");
                var url = lodopDomain + "default/system/print-order-gif/code/" + orderData.order.order_code + "/t/" + (new Date().getTime());
                $.ajax({
                    type: "POST",
                    async: false,
                    url: url,
                    dataType: 'script',
                    success: function () {
                        print_lodop();
                    }
                });
                break;

            case 'gif':
                if (!LODOP) {
                    LODOP = getLodop(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
                }
                var l = -1.5, t = 0;
                var printerNo = getPrinterNo(OperationCode);
                if (printerNo === null) {
                    printerSetup();
                    return;
                }

                if (!LODOP) {
                    LODOP = getLodop(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
                }
                var printerNo = getPrinterNo(orderData.order.sm_code);
                LODOP.SET_PRINTER_INDEX(printerNo);
                LODOP.SET_LICENSES(lodopCp, lodopKey, lodopToken, "");
                var url = lodopDomain + "default/system/print-gif-src/code/" + orderData.order.order_code + "/t/" + (new Date().getTime());
                $.ajax({
                    type: "POST",
                    async: false,
                    url: url,
                    dataType: 'script',
                    success: function () {
                        print_lodop();
                    }
                });
                break;

            case 'png':
                if (!LODOP) {
                    LODOP = getLodop(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
                }
                var l = -1.5, t = 0;
                var printerNo = getPrinterNo(OperationCode);
                if (printerNo === null) {
                    printerSetup();
                    return;
                }

                if (!LODOP) {
                    LODOP = getLodop(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
                }
                var printerNo = getPrinterNo(orderData.order.sm_code);
                LODOP.SET_PRINTER_INDEX(printerNo);
                LODOP.SET_LICENSES(lodopCp, lodopKey, lodopToken, "");
                var url = lodopDomain + "default/system/print-order-png/code/" + orderData.order.order_code + "/t/" + (new Date().getTime());
                $.ajax({
                    type: "POST",
                    async: false,
                    url: url,
                    dataType: 'script',
                    success: function () {
                        print_lodop();
                    }
                });
                break;
            case 'pdf2png':
                if (!LODOP) {
                    LODOP = getLodop(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
                }
                var l = -1.5, t = 0;
                var printerNo = getPrinterNo(OperationCode);
                if (printerNo === null) {
                    printerSetup();
                    return;
                }

                if (!LODOP) {
                    LODOP = getLodop(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
                }
                var printerNo = getPrinterNo(orderData.order.sm_code);
                LODOP.SET_PRINTER_INDEX(printerNo);
                LODOP.SET_LICENSES(lodopCp, lodopKey, lodopToken, "");
                var url = lodopDomain + "default/system/print-order-pdf2png/code/" + orderData.order.order_code + "/t/" + (new Date().getTime());
                $.ajax({
                    type: "POST",
                    async: false,
                    url: url,
                    dataType: 'script',
                    success: function () {
                        print_lodop();
                    }
                });
                break;
            default:
                if (!LODOP) {
                    LODOP = getLodop(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
                }
                var l = -1.5, t = 0;
                var printerNo = getPrinterNo(OperationCode);
                if (printerNo === null) {
                    printerSetup();
                    return;
                }

                if (!LODOP) {
                    LODOP = getLodop(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
                }
                var printerNo = getPrinterNo(orderData.order.sm_code);
                LODOP.SET_LICENSES(lodopCp, lodopKey, lodopToken, "");
                var url = lodopDomain + "default/system/print-order/code/" + orderData.order.order_code + "/t/" + (new Date().getTime());
                $.ajax({
                    type: "POST",
                    async: false,
                    url: url,
                    dataType: 'script',
                    success: function () {
                        print_lodop();
                    }
                });

                break;
        }
        //附加打印内容
        if (orderData.printAttach.toLowerCase() == 'script') {
            if (!LODOP) {
                LODOP = getLodop(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
            }
            var printerNo = getPrinterNo('stylus_printer');
            if (printerNo === null) {
                printerSetup();
                return;
            }
            LODOP.SET_PRINTER_INDEX(printerNo);
            LODOP.SET_LICENSES(lodopCp, lodopKey, lodopToken, "");
            var url = lodopDomain + "default/system/get-script/orderCode/" + orderData.order.order_code + "/t/" + (new Date().getTime());
            $.ajax({
                type: "POST",
                async: false,
                url: url,
                dataType: 'script',
                success: function () {
                    print_lodop();
                }
            });
        }
    }
</script>
<object id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
    <embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0 pluginspage="/lodop/install_lodop32.exe"></embed>
</object>
<div style="width:80%;margin:auto;">
    <div style="width:100%;height:100px;"></div>
    <div style="width:100%;height:24px;border-bottom:2px solid #ccc;">系统打印</div>
    <table class="dialog-module" border="0" cellpadding="0" cellspacing="0" width="80%">
        <tbody>
        <tr class="table-module-b1">
            <td>
                SO711501020998&nbsp;&nbsp;<a href=javascript:void(0);getOrdersReprint('SO711501020998');>打印标签</a>
            </td>
        </tr>
        <tr class="table-module-b1">
            <td>
                SO821501020997&nbsp;&nbsp;<a href=javascript:void(0);getOrdersReprint('SO821501020997');>打印标签</a>
            </td>
        </tr>
        <tr class="table-module-b1">
            <td>
                SO271501020996&nbsp;&nbsp;<a href=javascript:void(0);getOrdersReprint('SO271501020996');>打印标签</a>
            </td>
        </tr>
        </tbody>
    </table>


    <div style="width:100%;height:24px;border-bottom:2px solid #ccc;margin-top:10px;">测试打印美国网络</div>
    <table class="dialog-module" border="0" cellpadding="0" cellspacing="0" width="80%">
        <tbody>
        <tr class="table-module-b1">
            <td>
                AM711412310476&nbsp;&nbsp;<a href=javascript:void(0);getOrdersReprint2('AM711412310476');>打印标签</a>
            </td>
        </tr>
        <tr class="table-module-b1">
            <td>
                AM261501020708&nbsp;&nbsp;<a href=javascript:void(0);getOrdersReprint2('AM261501020708');>打印标签</a>
            </td>
        </tr>
        <tr class="table-module-b1">
            <td>
                AM121412310559&nbsp;&nbsp;<a href=javascript:void(0);getOrdersReprint2('AM121412310559');>打印标签</a>
            </td>
        </tr>
        </tbody>
    </table>
</div>