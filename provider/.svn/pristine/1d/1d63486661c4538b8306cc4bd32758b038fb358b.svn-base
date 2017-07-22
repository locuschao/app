<link type="text/css" rel="stylesheet" href="/css/public/index.css?20170526"/>
<link type="text/css" rel="stylesheet" href="/css/delivery/list_index.css?20170518">
<script type="text/javascript" src="/js/ToolTip.js" xmlns="http://www.w3.org/1999/html"></script>
<script type="text/javascript" src="/js/ajaxfileupload.js"></script>
<script src="/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<script type="text/javascript">
    EZ.url = '/delivery/Index/';
    EZ.getListData = function (json) {
        var html = '';
        $('.checkAll').attr('checked',false);
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            console.log(val);
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html +="<input type='hidden' class='uteId' value='"+val.E12+"'>";
            html +=" <td class='ec-center'><input type='checkbox' class='checkItem' name='orderId[]'  ref_id='"+val.E0+"' value='"+val.E0+"'></td>";
            html += "<td class='ec-center'>" + (i++) + "</td>";
            html +="<td>"+val.E2+"</td>";
            html +=" <td>"+val.E3+"</td>";
            html +=" <td>"+(val.E4).replace(/(\d{4}).(\d{1,2}).(\d{1,2}).+/mg, '$1-$2-$3')+"</td>";
            html +=" <td>"+(val.E5).replace(/(\d{4}).(\d{1,2}).(\d{1,2}).+/mg, '$1-$2-$3')+"</td>";
            html +=" <td>"+val.E7+"</td>";
            html +=" <td>"+val.E6+"</td>";
            html +=" <td>"+val.E8+"</td>";
            switch(val.E9) {
                        case '1':
                            html += '<td>待处理</td>';
                            break;
                        case '2':
                            html += '<td>待审核</td>';
                            break;
                        case '3':
                            html += '<td>已确认</td>';
                            break;
                        case '4':
                            html += '<td>已发货</td>';
                            break;
                        case '5':
                            html += '<td>审核失败</td>';
                            break;
                        default :
                            html += '<td></td>';
                            break;
                    }
            html +="<td>";
            html +="<select class='operation-select' >";
            html +="<option value='0'>操作</option>";
            html +="<option do_id='"+val.E0+"'value='1'>查看详情</option> ";
            if(val.E9==3) {
                html += "<option do_url='" + val.E13 + "'value='2'> 打印清单</option> ";
            }
            html +="</select></td>";
            html += "</tr>";
        });

        return html;
    }
    //操作点击事件
    $('body').on('change', '.operation-select', function() {
        var self = $(this),
            type = self.val();

        switch(type) {
            case '1':
                var do_id = self.find("option:selected").attr("do_id");
                showDeliveryDetail(do_id);
                break;
            case '2':
                var do_url = self.find("option:selected").attr("do_url");
                var curWwwPath = window.document.location.href;
                var pathName = window.document.location.pathname;
                var pos = curWwwPath.indexOf(pathName);
                var localhostPaht = curWwwPath.substring(0, pos);
                var url=localhostPaht+do_url;
                window.open(url);
                break;
            default:
                break;
        }
        self.val(0);
    })
    //日期选择
    $(function(){
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

        $(".checkAll").live('click', function() {
            $(".checkItem").attr('checked', $(this).is(':checked'));
        });
    });
    //批量插入发货单
    $(function(){
        $("#upload-dialog").dialog({
            autoOpen: false,
            modal: true,
            width: 580,
            height: 350,
            show: "slide",
            buttons: {

                'Cancel(取消)': function () {
                    $(this).dialog('close');
                }
            },
            close: function () {
                $(this).dialog('close');
            }
        });
    });

    function more_add_delivery(){

        $("#upload-dialog").dialog('open');
            
    }

   function ajaxFileUpload() {
        if ($("#fileToUpload").val() == '') {
            alertTip('<span class="tip-error-message"><{t}>please_select_a_file<{/t}></span>');
            return false;
        }
        var load_tips = "<span class='tip-load-message'>数据上传中，请等待...</span>"; 
        alertTip(load_tips);
       var a =$('#ute_id option:selected').val();


        $.ajaxFileUpload
        (
                {
                    url: $('#upload_form').attr('action'),
                    secureuri: false,
                    fileElementId: 'fileToUpload',
                    dataType: 'json',
                    data:{id:a},
                    success: function (json) {

                        var html = "";
                        if(json.state=='1'){
                            $.each(json.message, function (k, v) {
                                html += v + '<br/>';
                            });
                            $('#dialog-auto-alert-tip p').html(html);
                            $(".submitToSearch").click();
                            $("#fileToUpload").val('');
                            $("#upload-dialog").dialog('close');

                        }else{
                            $.each(json.message, function (k, v) {
                                html += v ;
                            });

                            $('#dialog-auto-alert-tip p').html(html);
                        }
                    },
                    error: function (data, status, e) {

                    }
                }
        );
        return false;
    }
    // 弹框查看发货单详情
    $(function(){
        $("#dialogDeliveryDetail").dialog({
            autoOpen: false,
            modal: true,
            width: 1380,
            height: 350,
            show: "slide",
            title:'查看发货单详情',
            buttons: {

                'Cancel(取消)': function () {
                    $(this).dialog('close');
                }
            },
            close: function () {
                $(this).dialog('close');
            }
        });
    });
    // 查看发货单详情列表数据
    function showDeliveryDetail(id){
        $("#dialogDeliveryDetail").dialog('open');
        $.ajax({
            type:'POST',
            url:'/delivery/index/get-delivery-detail',
            dataType:'json',
            data: {'id':id},
            async:false,
            success:function(json){
                console.log(json);
                var html='';
                var datas ='';
                 if(json.state==1) {
                     html += "<table width='120%' id='tables' border='0' cellpadding='0' cellspacing='0'>";
                     html += "<tr height='35'>";
                     html += " <td>销售单号&nbsp;:&nbsp;<span>" + json.data.do_no + "</span></td>";

                     html += " <td>结算方式&nbsp;:&nbsp;<span>货到付款</span></td>";
                     html += " <td>发货单号&nbsp;:&nbsp;<span>" + json.data.do_ship_no + "</span></td>";
                     html += "</tr>";
                     html += "<tr height='35'>";
                     html += " <td>运输方式&nbsp;:&nbsp;<span>物流</span></td>";
                     html += " <td>运输费用(￥)&nbsp;:&nbsp;<span>" + json.data.do_ship_fee + "</span></td>";
                     html += " <td>承运&nbsp;:&nbsp;<span>" + json.data.do_ship_company + "</span></td>";
                     html += "</tr>";
                     html += "</table>";
                 $.each(json.data.deliveryOrderItemData, function (key, val) {
                     datas += (key + 1) % 2 == 1 ? "<tr class='table-module-b2'>" : "<tr class='table-module-b1'>";
                     datas += "<td>" + val.doi_sku + "</td>";
                     datas += "<td>" + val.doi_name + "</td>";
                     datas += "<td>" + val.doi_amount +  val.doi_unit +"</td>";
                     datas += "<td>" + val.doi_size + "</td>";
                     datas += "<td>" + val.doi_weight + "</td>";
                     datas += "<td>" + val.doi_total_box + "</td>";
                     datas += "<td>" + val.doi_box_gw + val.doi_box_gw_unit +"</td>";
                     datas += "<td>" + val.doi_box_total_gw + val.doi_box_total_gw_unit + "</td>";
                     datas += "<td>" + val.doi_box_nw + val.doi_box_nw_unit +"</td>";
                     datas += "<td>" + val.doi_box_total_nw + val.doi_box_total_nw_unit +"</td>";
                     datas += "<td>" + val.doi_total_cube + "</td>";
                     datas += "<td>" + val.doi_box_size + "</td>";
                     datas += "<td>" + val.doi_box_no + "</td>";
                     datas += "<td>" + val.doi_create_time.replace(/(\d{4}).(\d{1,2}).(\d{1,2}).+/mg, '$1-$2-$3') + "</td>";
                     datas += "<td>" + val.doi_update_time.replace(/(\d{4}).(\d{1,2}).(\d{1,2}).+/mg, '$1-$2-$3') + "</td>";
                     datas += "</tr>";
                  });
                     $("#delviry").html(html);
                     $("#deliveryData").html(datas);
                 }
            }
        });
    }

    //选择查询单号搜索类型
    $(function(){
        $("#order_types").on('change',function(){
          var values = this.value;
            if(values != null){
                $("#order_type").attr('name',values);
            }
        });
   })
    $(function(){
        $("#module-pack").dialog({
            autoOpen: false,
            modal: true,
            width: 1380,
            height: 350,
            show: "slide",
            buttons: {

                'Cancel(取消)': function () {
                    $(this).dialog('close');
                    //重新生成隐藏域
                    $('.do').remove();
                    $("#service_code").children().remove();
                }
            },
            close: function () {
                $(this).dialog('close');
                //重新生成隐藏域
                $('.do').remove();
                $("#service_code").children().remove();
            }
        });
    });

   function make_delivery_Packing_list(){
       var string='';
       $(".checkItem:checked").each(function() {
           string += $(this).val()+",";
       });
       string=string.substring(0,string.length-1);
       if($(".checkItem:checked").size()>0){
               $.ajax({
                   url: '/delivery/index/get-warehouse',
                   type: 'post',
                   data: {
                       id:string,
                      },
                   dataType: 'json',
                   success: function(data) {
                       if(false===data['data']){
                           alertConfirmTip('该商品的供应商token不正确',function(){
                           });
                       }else if(data['state']==2){
                           alertConfirmTip("<font color='#FF0000'>**</font>所选商品的供应商不一致,请重新选择",function(){
                           });
                       }else {
                           var E0 = data['do_id'];
                           var E12 = data['ute_id'];
                           $('#formdata').append("<input type='hidden' class='do' name='do_id' value=" + E0 + ">" + "<input type='hidden' class='do' name='ute_id' value=" + E12 + ">");
                           div = "<option value=''>全部</option>";
                           $.each(data['data'], function (key, val) {
                               div += "<option  value=" + val['serviceCode'] + ">" + val['serviceName'] + "</option>";
                           });
                           $("#service_code").append(div);
                           $("#module-pack").dialog('open');
                       }
                   },
                   error: function(data) {

                   }
               })
       }else{
           alertConfirmTip('请先选择要生成的装箱单的发货信息',function(){
           });
       }

    }

 //推送入库单
    function push_list() {
        var doIds='';
        $(".checkItem:checked").each(function() {
            doIds += $(this).val()+",";
        });
        doIds=doIds.substring(0,doIds.length-1);

            $.ajax({
                url:'/delivery/index/push-store-detail',
                type:'post',
                data:{doIds:doIds},
                dataType:'json',
                success:function(data){
                    console.log(data);
                    if(data['state']==0){
                        alertConfirmTip(data['message'],function(){
                        });
                    }else{
                        alertConfirmTip(data['message'],function(){
                        });
                    }
                }
            });


    }


    /**
     * @desc 头程发货推送
     * @author gan
     * @date 2017/06/21
     */
    function push_delivery_order(){
        var doIds='';
        $(".checkItem:checked").each(function() {
            doIds += $(this).val()+",";
        });

        doIds=doIds.substring(0,doIds.length-1);
        if($(".checkItem:checked").size()>0) {
            $.ajax({
                url: '/delivery/index/push-delivery-order',
                type: 'post',
                data:{doIds:doIds},
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data['state'] == 500) {
                        alertConfirmTip(data['message'], function () {
                        });
                    } else {
                        alertConfirmTip(data['message'], function () {
                        });
                    }
                }
            });
        }else{
            alertConfirmTip("请先选择要发货的订单", function () {
            });
        }
    }

</script>
<style type="text/css">
    .boundBtn {
        float: right;
        margin: 10px 5px 0 0;
        font-size: 14px;
    }
    .boundBtns {
        float: right;
        margin: 10px 5px 0 0;
        font-size: 14px;
    }
</style>

<div id="module-container">
    <form id="exportForm" action="/delivery/index/execute-pack-list" style="display: none;" method="POST"></form>
    <div id="module-table">
        <div class="module-head">
            <span class="module-title">商品发货列表</span>
            <button id="import" class="initBtn otherBtn boundBtn" style="width: 100px;" onclick="more_add_delivery()">批量导入</button>
            <button id="import" class="initBtn otherBtn boundBtns" style="width: 120px;"  onclick="push_delivery_order()">推送发货订单</button>
        </div>
        <div id="search-module">
            <form id="searchForm" name="searchForm" class="submitReturnFalse">
                <div style="padding:0">
                    <div class="notice-type-div">
                        <div class="searchFilterText">发货状态：</div>
                        <div class="pack_manager">
                            <input id="do_status" class="input_text keyToSearch" name="do_status" value="" type="hidden">
                            <a class="nt-code current" href="javascript:void(0)" onclick="searchFilterSubmit('do_status', '', this)">全部</a>
                            <{foreach from=$biddingStatus item=val key=key}>
                            <a class="nt-code <{if $val == $biddingStatus}>current<{/if}>" href="javascript:void(0)" onclick="searchFilterSubmit('E8', '<{$key}>', this)">
                                <{$val}>
                            </a>
                            <{/foreach}>
                        </div>
                    </div>
                    <div class="search-module-condition">
                      <span class="searchFilterText" style="width: 100px;">单号：</span>
                      <select class="selectCss2 " id="order_types"  style="width: 130px;height: 24px;">
                          <option >请选择查询类型</option>
                          <option value="do_no">销售单号</option>
                          <option value="do_ship_no">物流单号</option>
                      </select>
                      <label title="" style="cursor: pointer;">
                          <input type="text"  class="input_text keyToSearch" id="order_type" placeholder="请输入单号">
                      </label>
                    </div>
                    <div class="search-module-condition">
                        <span class="searchFilterText" style="width: 100px;">商品SKU号：</span>
                        <input type="text" name="doi_sku" class="input_text keyToSearch" id="txt" placeholder="请输入商品SKU号">
                    </div>
                    <div class="search-module-condition">
                        <span class="searchFilterText" style="width: 100px;">采购商：</span>
                        <input type="text" name="do_company" class="input_text keyToSearch" id="txt" placeholder="请输入采购商">
                    </div>
                    &nbsp;&nbsp;
                    <div class="search-module-condition">
                        <span class="searchFilterText">&nbsp;</span>
                        <input type="button" value="<{t}>搜索<{/t}>" class="initBtn otherBtn submitToSearch"/>
                    </div>
                </div>
            </form>
        </div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-module">
            <tr class="table-module-title">
                <td width="2%" class="ec-center"><input type="checkbox" class="checkAll"></td>
                <td width="4%">序号</td>
                <td>销售单号</td>
                <td>物流单号</td>
                <td>发货日期</td>
                <td>预计到货时间</td>
                <td>承运方公司</td>
                <td>采购商</td>
                <td>费用(￥)</td>
                <td>状态</td>
                <td>操作</td>
            </tr>
            <form id="listForm" method="POST" action=""></form>

            <tbody id="table-module-list-data"><tr class="table-module-b1"><td colspan="11">请搜索...</td></tr>

            </tbody>
        </table>
    </div>
    <div class="pagination"></div>
    <div class="to_top_div" data-show="false"><span style="float: left;cursor: pointer;padding: 0px 2px;" title="返回顶部" class="iconToTop" onclick="toTop();"></span><span style="float: left;cursor: pointer;padding: 0px 2px;" title="前往底部" class="iconToBottom" onclick="toBottom();"></span>
    </div>
</div>
<!--  批量插入发货单  -->
<div style="display:none" id="upload-dialog" title="批量导入">
    <form method='post' enctype="multipart/form-data" action='/delivery/index/upload' id='upload_form'
          class="submitReturnFalse">
        <div class="search-module-condition">
            上传文件：
            <input type="file" name="fileToUpload" id="fileToUpload" class="input_text"/>
            <input type="button" value="确认上传" onclick='return ajaxFileUpload();'>
        </div>
        <div class="search-module-condition" style="padding-left:28px;margin-top:20px">
            模板：<a href="/delivery/index/make-excel" style="color:#0090E1">模板下载</a>
        </div>
        <div class="search-module-condition" style="padding-left:28px;">
            <span style="color:#E9C341;">注意：仅支持 xls 文件</span>
        </div>
        <div class="search-module-condition" style="padding-left:28px;">
            提示：当导入数据存在异常时，全部都会失败;
        </div>
        <div class="search-module-condition">
            <span class="searchFilterText" style="width: 160px; padding-left:8px;">请选择要导入的ERP名：</span>
            <select  class="selectCss2 " id="ute_id"  style="width: 130px;height: 24px;">
                <{foreach from=$uteErpNameDatas item=w key=k }>
                <option  value="<{$k}>" class="ute_id"  name="ute_id=<{$k}>"><{$w}></option>
                <{/foreach}>

            </select>
        </div>
    </form>

</div>

<!-- 查看发货单详情  -->
<div id="dialogDeliveryDetail">
    <div id="delviry"></div>
     <table class="table_delivery_order_details" width="120%" border="0" cellpadding="0" cellspacing="0" class="table-module">
         <tr class="table_delivery_order_details_title">
             <td>产品代码</td>
             <td>商品名称</td>
             <!--  <td>产品状态</td>-->
              <td>产品数量</td>
              <td>产品尺寸</td>
              <td>产品重量</td>
              <td>总箱数</td>
              <td>单箱净重</td>
              <td>总净重</td>
              <td>单箱毛重</td>
              <td>总毛重</td>
              <td>总立方</td>
              <td>箱内尺寸</td>
              <td>箱号</td>
              <!-- <td>发货状态</td>-->
              <td>创建时间</td>
              <td>更新时间</td>
              <!-- <td>操作</td>-->
          </tr>
          <tbody id="deliveryData"></tbody>
      </table>
 </div>



