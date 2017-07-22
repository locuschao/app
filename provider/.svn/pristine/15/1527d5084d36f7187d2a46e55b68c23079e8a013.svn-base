<script type="text/javascript" src="/js/jquery-ui-timepicker-addon.js" ></script>
<script type="text/javascript">
    EZ.url = '/order/exceptions/';
    EZ.getListData = function (json) {
        console.log(json);
        var html = '';
        $('.checkAll').attr('checked',false);
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += (key + 1) % 2 == 1 ? "<tr class='table-module-b1'>" : "<tr class='table-module-b2'>";
            html +="<input type='hidden' class='uteId' value='"+val.E12+"'>";
            html +="<input type='hidden' class='status' value='"+val.E19+"'>";
            html +=" <td class='ec-center'><input type='checkbox' class='checkItem' name='orderId[]'  ref_id='"+val.E0+"' value='"+val.E0+"'></td>";
            html += "<td class='ec-center'>" + (i++) + "</td>";
            html += "<td class='ec-center'>" + '采购单号：' + val.E2 + "<br>";
            html += "产品SKU：" + val.E4;
            html += "</td>";
            html +=" <td class='ec-center'>"+val.E6+"</td>";
            html +=" <td class='ec-center'>"+val.E10+"</td>";
            html +=" <td class='ec-center'>"+val.E11+"</td>";
            html +=" <td class='ec-center'>"+val.E12+"</td>";
            html +=" <td class='ec-center'>"+val.E14+"</td>";
            html +=" <td class='ec-center'>"+val.E15+"</td>";
            html +=" <td class='ec-center'>"+val.E16+"</td>";
           if(val.E18=="1") {
                html += "<td class='ec-center'>QC异常</td>";
               switch(val.E19) {
                   case '0':
                       html += "<td class='ec-center'>待确认</td>";
                       break;
                   case '1':
                       html += "<td class='ec-center'>销毁，采购方承担</td>";
                       break;
                   case '2':
                       html += "<td class='ec-center'>销毁，供应商承担</td>";
                       break;
                   case '3':
                       html += "<td class='ec-center'>退回，供应商退回款项</td>";
                       break;
                   case '4':
                       html += "<td class='ec-center'>不良品上架</td>";
                       break;
                   case '6':
                       html += "<td class='ec-center'>换货，供应商重新发货</td>";
                       break;
                   default :
                       html += '<td></td>';
                       break;
               }
               switch (val.E21){
                   case '0':
                       html += "<td class='ec-center'>已作废</td>";
                       break;
                   case '1':
                       html += "<td class='ec-center'>未处理</td>";
                       break;
                   case '2':
                       html +="<td class='ec-center' >已确认</td>";
                       break;
                   case '3':
                       html +="<td class='ec-center'>已审核</td>";
                       break;
                   case '4':
                       html += "<td class='ec-center'>已完成</td>";
                       break;
                   default :
                       html +="<td class='ec-center'></td>";
                       break;

               }
            }else{
               html += "<td class='ec-center'>收货异常</td>";
               switch(val.E20) {
                   case '0':
                       html +="<td class='ec-center'>待确认</td>";
                       break;
                   case '1':
                       html += "<td class='ec-center'>入库</td>";
                       break;
                   case '2':
                       html += "<td class='ec-center'>退货</td>";
                       break;
                   default :
                       html += '<td></td>';
                       break;
               }
               switch (val.E22){
                   case '0':
                       html += "<td class='ec-center'>已作废</td>";
                       break;
                   case '1':
                       html +="<td class='ec-center'>未处理</td>";
                       break;
                   case '2':
                       html += "<td class='ec-center'>已确认</td>";
                       break;
                   case '3':
                       html +="<td class='ec-center'>已审核</td>";
                       break;
                   case '4':
                       html += "<td class='ec-center'>已完成</td>";
                       break;
                   default :
                       html += '<td></td>';
                       break;

               }
           }

            html +="<td class='ec-center'>";
            html +="<select class='operation-select' >";
            html +="<option value='0'>操作</option>";
            html += "<option oe_id='" + val.E0 + "'value='1' oeol_id='"+val.E9+"'>退货处理</option> ";
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
                var oe_id = self.find("option:selected").attr("oe_id");
                var oeol_id = self.find("option:selected").attr("oeol_id");
                TuiHuo(oe_id,oeol_id);
                break;
            default:
                break;
        }
        self.val(0);
    })
    $(function(){
        $("#tuihuo-dialog").dialog({
            autoOpen: false,
            modal: true,
            width: 950,
            height: 550,
            show: "slide",
            buttons: [{
                text: "确认",
                click: function () {
                    var data=$('#editDataForm').serialize();
                    $.ajax({
                        type:'get',
                        url:'/order/exceptions/handle-add?'+data,
                        dataType:'json',
                        async:false,
                        success:function(json) {
                            alertConfirmTip(json.message,function(){
                            });
                            $("#tuihuo-dialog").dialog('close');
                            //关闭自动刷当前页面
                            window.location.reload();
                        }
                    });
                }
            },
                {
                    text: "取消",
                    click: function () {
                        $("#tuihuo-dialog").dialog('close');
                    }
                }
            ], close: function () {
                $(this).dialog('close');
            }
        });
    });
   function TuiHuo(id,oeol_id){
       if(id == null || id== undefined){
           alertConfirmTip('请选择要退货的订单号',function(){
           });
       }else {
           if(oeol_id>0){
               alertConfirmTip('订单退货已处理',function(){
               });
           }else{
           $.ajax({
               type:'POST',
               url:'/order/exceptions/return-single',
               dataType:'json',
               data: {'id':id},
               async:false,
               success:function(json) {
                   var SB='';
                   SB +=" <td>"+json.data.E2+"</td>";
                   SB +=" <td>"+json.data.E4+"</td>";
                   SB +=" <td>"+json.data.E12+"</td>";
                   SB +=" <td>"+json.data.E6+"</td>";
                   SB +=" <td>"+json.data.E16+"</td>";
                   var returnNo=json.data.returnNo;
                   var totalAmount=json.data.E16;
                   var oe_create_time=json.data.E23;
                   var oe_id=json.data.E0;
                   $("#SB").html(SB);
                   $("#returnNo").val(returnNo);
                   $("#totalAmount").val(totalAmount);
                   $("#oe_create_time").val(oe_create_time);
                   $("#oe_id").val(oe_id);
               }
               });
           $("#tuihuo-dialog").dialog('open');
           }
       }
   }

</script>
<style type="text/css">
    .boundBtn {
        float: right;
        margin: 28px 25px 0 0;
    }
    .order-details-table {
        margin: 0px auto;
        text-align: center;
    }
    .table_order_details td{
        border: 1px solid #000;
        height: 45px;
    }
</style>

<div id="module-container">
    <div id="ez-wms-edit-dialog" style="display:none;">
        <table class="dialog-module" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <input type="hidden" name="E0" id="E0" value=""/>
            </tbody>
        </table>
    </div>

    <div id="print-edit-dialog" style="display:none;">
        <span>请选择您所需的打印方式！</span>
    </div>

    
    <div id="module-table">
        <div class="module-head">
            <span class="module-title">异常列表</span>
        </div>
        <div id="search-module">
            <form id="searchForm" name="searchForm" class="submitReturnFalse">
                <div style="padding:0">
                    <div class="notice-type-div">
                        <div class="searchFilterText">产品状态：</div>
                        <div class="pack_manager">
                            <input id="E14" class="input_text keyToSearch" name="E14" value="" type="hidden">
                            <a class="nt-code current" href="javascript:void(0)" onclick="searchFilterSubmit('E14', '', this)">全部</a>
                            <{foreach from=$statusTypes item=val key=key}>
                            <a class="nt-code <{if $val == $statusTypes}>current<{/if}>" href="javascript:void(0)" onclick="searchFilterSubmit('E7', '<{$key}>', this)">
                                <{$val}>
                            </a>
                            <{/foreach}>
                        </div>
                    </div>

                    <div class="search-module-condition">
                        <span class="searchFilterText" >订单号：</span>
                        <input type="text" name="E2" id="E2" class="input_text keyToSearch" placeholder="请输入订单号">
                    </div>

                    <div class="search-module-condition">
                        <span class="searchFilterText" >SKU：</span>
                        <input type="text" name="E4" id="E4" class="input_text keyToSearch" placeholder="请输入SKU">
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
                <td width="4%" class="ec-center">NO.</td>
                <td width="10%" class="ec-center">订单号</td>
                <td width="8%" class="ec-center">产品名称</td>
                <td class="ec-center">订单数量</td>
                <td class="ec-center">送货数</td>
                <td class="ec-center">质检数</td>
                <td class="ec-center">问题件数</td>
                <td class="ec-center">需补数量</td>
                <td class="ec-center">需退数量</td>
                <td class="ec-center">异常类型</td>
                <td class="ec-center">处理类型</td>
                <td  class="ec-center">状态</td>
                <td class="ec-center"><{t}>操作<{/t}></td>
            </tr>
            <tbody id="table-module-list-data"></tbody>
        </table>
    </div>
    <div class="pagination"></div>
</div>
<!-- 退货处理详情  -->
<div style="display:none" id="tuihuo-dialog" title="退货单" >
      <form id="editDataForm" name="editDataForm" class="submitReturnFalse">
          <input type="hidden" name="oe_id" value="" id="oe_id">
           <div class="order-details">
               <table class="order-details-table" style="width: 750px;height: 150px;">
                     <tbody>
                     <tr >
                          <td>采购单号<span id="order_no"></span></td>
                          <td>产品编码<span id="oi_sku"></span></td>
                          <td>产品图片<span id="picture"></span></td>
                          <td>产品名称<span id="oi_name"></span></td>
                          <td>退货数量<span id="oe_return_amount"></span></td>
                     </tr>
                      <tr id="SB">
                      </tr>
                     </tbody>
                     </table>
           </div>
           <hr>
               <div class="item-details" style="width:515px;margin: 20px auto;">
                  <table width="100%" border="0" class="table_order_details" style="text-align: center;border: 1px solid #000;">
                    <tbody>
                       <tr >
                        <td>退货单号</td>
                        <td ><input type="text" id="returnNo" name="oeol_return_no" value=""></td>
                        <td>创建时间</td>
                         <td ><input type="text" id="oe_create_time" name="oe_create_time" value=""></td>
                       </tr>
                       <tr >
                           <td>退货总数量</td>
                           <td><input type="text"  id="totalAmount" name="totalAmount" value=" "></td>
                           <td>总重量</td>
                           <td> <input type="text" name="totalWeight" id="totalWeight" class="input_text keyToSearch" placeholder="请输入总重量"></td>
                       </tr>
                       <tr >
                           <td>快递公司</td>
                           <td>
                               <select name="oeol_ship_company" style="height: 29px; width: 153px;">
                                   <option value="0">请选择快递公司</option>
                                   <option value="1">顺丰快递</option>
                                   <option value="2">圆通快递</option>
                               </select>
                           </td>
                           <td>快递单号</td>
                           <td><input type="text" name="oeol_ship_no" id="oeol_ship_no" class="input_text keyToSearch" placeholder="请输入快递单号"></td>
                       </tr>
                       <tr >
                           <td>支付方式</td>
                           <td>
                               <select name="oeol_pay_way" style="height: 29px; width: 153px;">
                                   <option value="0">请选择支付方式</option>
                                   <option value="1">现付</option>
                                   <option value="2">到付</option>
                               </select>
                           </td>
                           <td>运费</td>
                           <td><input type="text" name="oeol_ship_fee" id="oeol_ship_fee" class="input_text keyToSearch" placeholder="请输入费用"></td>
                       </tr>
                    </tbody>
                  </table>
               </div>
      </form>
</div>




