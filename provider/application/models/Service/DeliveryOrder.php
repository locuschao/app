<?php
class Service_DeliveryOrder extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_DeliveryOrder|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_DeliveryOrder();
        }
        return self::$_modelClass;
    }

    /**
     * @param $row
     * @return mixed
     */
    public static function add($row)
    {
        $model = self::getModelInstance();
        return $model->add($row);
    }


    /**
     * @param $row
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function update($row, $value, $field = "do_id")
    {

        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "do_id")
    {
        $model = self::getModelInstance();
        return $model->delete($value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @param string $colums
     * @return mixed
     */
    public static function getByField($value, $field = 'do_id', $colums = "*")
    {

        $model = self::getModelInstance();
        return $model->getByField($value, $field, $colums);
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        $model = self::getModelInstance();
        return $model->getAll();
    }

    /**
     * @des 获取指定要装箱的订单商品详情
     * @return mixed
     * @date 2017-5-9
     * @author blank
     */
    public static function getInfoDetail($condition=array())
    {
        $model = self::getModelInstance();
        return $model->getInfoDetail($condition);
    }

    /**
     * @desc 通过订单号获取商品详情
     * @param array
     * @date 2017-6-5
     * @author blank
     * @return mixed
     */
    public static function getByDoNO($condition=array()){
        $model = self::getModelInstance();
        return $model->getByDoNO($condition);
    }

    /**
     * @desc 通过状态获取所有的订单号状态为1待审核
     * @param array
     * @date 2017-6-5
     * @author blank
     * @return mixed
     */
    public static  function getOrderBystatu($condition=array()){
        $model = self::getModelInstance();
        return $model->getOrderBystatu($condition);
    }

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getByCondition($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $model = self::getModelInstance();
        return $model->getByCondition($condition, $type, $pageSize, $page, $order);
    }

    /**
     * @param array $condition
     * @return mixed
     */
    public static function getErpByDoid($condition = array()){
        $model = self::getModelInstance();
        return $model->getErpByDoid($condition);
    }

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getByGroup($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "", $group = "")
    {
        $model = self::getModelInstance();
        return $model->getByGroup($condition, $type, $pageSize, $page, $order, $group);
    }

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getByConditions($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $model = self::getModelInstance();
        return $model->getByConditions($condition, $type, $pageSize, $page, $order);
    }

    /**
     * @param $val
     * @return array
     */
    public static function validator($val)
    {
        $validateArr = $error = array();

        return  Common_Validator::formValidator($validateArr);
    }

    /**
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(
              'E0'=>'do_id',
              'E1'=>'user_id',
              'E2'=>'do_no',
              'E3'=>'do_ship_no',
              'E4'=>'do_ship_time',
              'E5'=>'do_pre_receive_time',
              'E6'=>'do_company',
              'E7'=>'do_ship_company',
              'E8'=>'do_ship_fee',
              'E9'=>'do_status',
              'E10'=>'do_create_time',
              'E11'=>'do_update_time',
              'E12'=>'ute_id',
              'E13'=>'do_pack_pdf_url'
        );
        return $row;
    }

    /**
     * @desc 批量导入发货单
     */
    public static function uploadShelfTransaction($data,$uteId)
    {


        $return = array(
            'state' => 0,
            'message' => array()
        );
        if ($data['error']) {
            $return['message'] = array('请选择xls文件');
            return $return;
        }
        $fileName = $data['name'];
        $filePath = $data['tmp_name'];
        $pathinfo = pathinfo($fileName);
        // 开始标志
        Ec::showError('=========================开始========================','Upload_Shelf_Transaction_process'.date('Y-m-d-H'));
        // 上传开始
        Ec::showError('批量添加发货单，'.$fileName,'Upload_Shelf_Transaction_process'.date('Y-m-d-H'));
        $beginTime=time();
        Ec::showError('批量添加发货单，上传开始 ','Upload_Shelf_Transaction_process'.date('Y-m-d-H'));

        if (!isset($pathinfo["extension"]) && $pathinfo["extension"] != "xls") {

            $return['message'] = array('请选择xls文件');
            return $return;
        }

        $fileDatas = Common_Upload::readUploadFileBySheetNew($fileName, $filePath,0);


        if (!isset($fileDatas[1]) || !is_array($fileDatas[1])) {
            $return['state'] =0;
            $return['message'] = array('上传失败，产品信息表无法解析文件内容;');
            return $return;
        }else{//判断批量添加发货订单是否达到上限
            $conf=Service_Config::getByField('BATCH_SHARED_MAX','config_attribute',array('config_value'));//获取批量分销上限
            $max=$conf['config_value'] ? $conf['config_value'] : 500;
            if(count($fileDatas) > $max){
                $return['state'] =0;
                $return['message'] = array(
                    '上传失败，批量添加发货订单数量超过上限:'.$max,
                    '你可以减少批量添加发货订单数量或者联系技术支持处理.');
                return $return;
            }
        }

        /* *
         * 校验表格机构 （表头的各个字段是否正确，防止别人导错表，校验客户代码和sku，方式客户写错）
         * 校验数据是否有遗漏，空数据
         *
         */
        $error = array();
        $checkfileData=time(); // 产品效验时间
        Ec::showError('批量添加发货订单，数据处理，耗时：'.($checkfileData-$beginTime).'s','Upload_Shelf_Transaction_process'.date('Y-m-d-H'));
        //校验过程一：发货表信息，返回错误信息
        $check_delivery_order = self::checKDeliveryOrder($fileDatas);


        if(!empty($check_delivery_order)){
            $return['message']= $check_delivery_order[0];
            return $return;
        }
        // 产品效验结束
        $checkfileData1=time();
        Ec::showError('批量添加发货订单，效验产品信息表，耗时：'.($checkfileData1-$checkfileData).'s','Upload_Shelf_Transaction_process'.date('Y-m-d-H'));

        if (!empty($error)) {
            $return['state'] = 0;
            $return['message'] = $error;
            // 日志结束
            $endTime=time();
            Ec::showError('批量添加发货订单，上传结束,共耗时：'.($endTime-$beginTime).'s','Upload_Shelf_Transaction_process'.date('Y-m-d-H'));
            // 结束标志
            Ec::showError('==========================结束========================','Upload_Shelf_Transaction_process'.date('Y-m-d-H'));
            return $return;
        }
        $db = Common_Common::getAdapter();
        $db->beginTransaction();
        $attrErr=array();//产品属性错误信息
        try {
            $path_arr=array();//上传的文件路径
            foreach ($fileDatas as $keys =>$fileData) {
                //获取发货单的销售单号
                $deliveryOrderDoNo = $fileData["销售单号"];
                $deliveryOrderName = $fileData["商品名"];
                //获取商品sku
                $deliveryOrderDoiSku =  $fileData["商品sku"];
                $deliveryOrderData = self::getByField($deliveryOrderDoNo,'do_no');
                $Fields = array(
                    'order_id',
                );
                $deliveryData =array();
                $deliverySkus =array();
                //获取更新的销售号单id
                $doId = array();
                //判断销售单号与sku是否存在合法
                if(!empty($fileData['销售单号'])){
                    $orderNo = array();
                    $orderNo['order_no'] =  $fileData['销售单号'];
                    $orderData = Service_Orders::getByConditions($orderNo, $Fields);
                    if(empty($orderData)){
                        throw new Exception("发货单表第" . $keys . '行,'.'操作失败，原因：销售单号错误或不存在，',10015);
                    }else{
                        $orderSku['oi_sku'] = $fileData['商品sku'];
                        $showFields = array(
                            'oi_sku',
                        );
                        $orderId['order_id'] = $orderData[0]['order_id'];

                        $orderItemDatas = Service_OrderItem::getByConditions($orderId, $showFields);

                        $oi_sku =array();
                        foreach ($orderItemDatas as $key => $value){
                            foreach ($value as $k =>$v ){
                                $oi_sku[] = $v ;
                            }
                        }

                        //判断sku是否属于该销售单中包含的sku
                        if(!in_array($deliveryOrderDoiSku,$oi_sku)){
                            throw new Exception("发货单表第" . $keys . '行,'.'操作失败，原因：商品sku错误或不存在，请输入正确的商品sku号',10015);
                        }

                    }
                }


                if($deliveryOrderData != false){
                    $doId['do_id'] = $deliveryOrderData['do_id'];
                    //获取发货单详情表数据
                    $datas = Service_DeliveryOrderItem::getByCondition($doId);
                    foreach($datas as $k =>$v){

                        $deliveryData[] = $v;
                        $doiId= $v['doi_id'];

                        // $deliveryData = $v;
                        // $doiId= $v['doi_id'];

                        // $deliveryData[] = $v;
                    }


                }else{
                    // 发货订单数据信息入表-开始
                    $deliveryOrder = self::addDeliveryOrder($fileData,$uteId);
                    if (!$deliveryOrder) {
                        throw new Exception("发货单表第" . $keys . '行,'.'操作失败',10015);
                    }
                    //发货订单详情数据信息入表-开始
                    $deliveryOrderItem = self::addDeliveryOrderItem($fileData,$deliveryOrder);
                    if (!$deliveryOrderItem) {
                        throw new Exception("发货详情表第" . $keys . '行,'.'操作失败',10015);
                    }
                }

                if(!empty($deliveryData)){
                    //判断销售单号和商品名是否相同 如果相同则更新
                    foreach($deliveryData as $k => $v){
                        //如果发货单号（采购单号）和sku号相同则更新该销售单号中的所有信息
                        if($deliveryOrderDoiSku == $v['doi_sku'] && $deliveryOrderDoNo == $deliveryOrderData['do_no']){
                                //更新发货单信息
                                $updateDeliveryOrder =self::updteDeliveryOrder($fileData,$v['do_id'],$uteId);
                                if (!$updateDeliveryOrder) {
                                    throw new Exception("更新发货单表第" . $keys . '行,'.'操作失败',10015);
                                }
                                //当更新完成发货单时延时一秒在执行添加发货详情表
                                sleep(1);
                                //更新发货详情表信息
                                $updteDeliveryOrderItem = self::updteDeliveryOrderItem($fileData,$v['doi_id']);
                                if (!$updteDeliveryOrderItem) {
                                    throw new Exception("更新发货详情表第" . $keys . '行,'.'操作失败',10015);
                                }
                        }
                        $deliverySkus[] =  $v['doi_sku'];
                    }
                    //当销售单号相同，sku号不同，则更新发货单的信息并在该销售单号下的发货单详情表中新添加一行数据
                    if(!in_array($deliveryOrderDoiSku,$deliverySkus) && $deliveryOrderDoNo == $deliveryOrderData['do_no']){
                        $doIds = $doId['do_id'];
                        $updateDeliveryOrder =self::updteDeliveryOrder($fileData,$doIds,$uteId);
                        if (!$updateDeliveryOrder) {
                            throw new Exception("更新发货单表第" . $keys . '行,'.'操作失败',10015);
                        }
                        //当更新完成发货单时延时一秒在执行添加发货详情表
                        sleep(1);
                        $deliveryOrderItem = self::addDeliveryOrderItem($fileData,$doIds);
                        if (!$deliveryOrderItem) {
                            throw new Exception("添加发货详情表第" . $keys . '行,'.'操作失败',10015);
                        }
                    }

                }
            }

            // 发货订单数据信息入表-开始
            $addfileData1=time();
            Ec::showError('批量添加发货订单，发货订单数据信息入表，耗时：'.($addfileData1-$checkfileData).'s','Upload_Shelf_Transaction_process'.date('Y-m-d-H'));
            $db->commit();
            $return['state'] = 1;
            $return['message'] = array('操作成功');
        } catch (Exception $e) {
            $db->rollBack();
            // 异常信息开始
            $abnormalStart=time();
            Ec::showError('批量添加发货订单，上传存在异常','Upload_Shelf_Transaction_process'.date('Y-m-d-H'));
            if(!empty($path_arr)){//有异常则删除文件
                foreach ($path_arr as $k=>$path){
                    $path2=$path.'.thumb.jpg';
                    $path3=$path.'.1000.jpg';
                    if(file_exists($path)){unlink($path);}
                    if(file_exists($path2)){unlink($path2);}
                    if(file_exists($path3)){unlink($path3);}
                }
            }
            // 异常信息
            $abnormalEnd=time();
            Ec::showError('发货订单数据信息入表，有异常删除文件，耗时：'.($abnormalEnd-$abnormalStart).'s','Upload_Shelf_Transaction_process'.date('Y-m-d-H'));
            if($e->getCode()==10010){
                $return['message'] = $attrErr;
            }else{
                $return['message'] = array($e->getMessage());
            }
        }
        // 数据效验结束
        $endTime=time();
        Ec::showError('发货订单数据信息入表，上传结束,共耗时：'.($endTime-$beginTime).'s','Upload_Shelf_Transaction_process'.date('Y-m-d-H'));
        // 结束标志
        Ec::showError('==========================结束========================','Upload_Shelf_Transaction_process'.date('Y-m-d-H'));
        return $return;
    }

    /**
     * desc 批量插入发货订单表
     *
     */
    public static function addDeliveryOrder($data,$uteId){

        $doShipTime=(date('Y-m-d H:i:s',intval(($data['发货日期(格式：yyyy/mm/dd)'] - 25569) * 3600 * 24)));
        $doPreReceiveTime=(date('Y-m-d H:i:s',intval(($data['预计到货时间(格式：yyyy/mm/dd)'] - 25569) * 3600 * 24)));
        $useId=Service_User::getUserId();
        $condition = array();
        $condition['user_id'] = $useId;
        //获取用户对应得ute_id
        $datas = Service_UserToErp::getUserAndErpRelation($condition);
        $arr = array(
            'user_id'=>$useId,
            'ute_id'=>$uteId,
            'do_no'=>$data['销售单号'],
            'do_ship_no'=>$data['物流单号'],
            'do_ship_time'=>$doShipTime,
            'do_pre_receive_time'=>$doPreReceiveTime,
            'do_ship_company'=>$data['承运方公司'],
            'do_ship_fee'=>$data['物流费(￥)'],
            'do_company'=>$data['采购方公司'],
            'do_status'=>$data['状态(1为：待处理；2为：未发货；3为：已发货；4为：已签收)'],
            'do_create_time'=>date('Y-m-d H:i:s'),
        );
        $addDelivery = self::add($arr);

        return $addDelivery;
    }

    /**
     * desc 批量插入发货订单详情表
     */
    public static function addDeliveryOrderItem($data,$doId){

        if($data['备注'] =''){
            unset($data['备注']);
        }else{
            $remark = $data['备注'];
        }
        $arrs = array(
            'do_id'=>$doId,
            'doi_sku'=>$data['商品sku'],
            'doi_name'=>$data['商品名'],
            'doi_amount'=>$data['商品数量(个)'],
            'doi_unit'=>'个',
            'doi_box_size_long'=>$data['内盒规格尺寸(cm)内盒长(cm)'],
            'doi_box_size_width'=>$data['内盒宽(cm)'],
            'doi_box_size_heigh'=>$data['内盒高(cm)'],
            'doi_box_size'=>$data['内盒规格尺寸(cm)内盒长(cm)'].'*'.$data['内盒宽(cm)'].'*'.$data['内盒高(cm)'],
            'doi_box_outside_long'=>$data['外箱规格尺寸(cm)外箱长(cm)'],
            'doi_box_outside_width'=>$data['外箱宽(cm)'],
            'doi_box_outside_heigh'=>$data['外箱高(cm)'],
            'doi_box_outside_size' =>$data['外箱规格尺寸(cm)外箱长(cm)'].'*'.$data['外箱宽(cm)'].'*'.$data['外箱高(cm)'],
            'doi_size'=>$data['商品尺寸'],
            'doi_weight'=>$data['商品重量(kg)'],
            'doi_weight_unit'=>'kg',
            'doi_box_gw'=>$data['单箱净重(kg)'],
            'doi_box_gw_unit'=>'kg',
            'doi_box_total_gw'=>$data['总净重(kg)'],
            'doi_box_total_gw_unit'=>'kg',
            'doi_box_nw'=>$data['单箱毛重(kg)'],
            'doi_box_nw_unit'=>'kg',
            'doi_box_total_nw'=>$data['总毛重(kg)'],
            'doi_box_total_nw_unit'=>'kg',
            'doi_total_box'=>$data['总箱数'],
            'doi_total_cube'=>$data['总立方(m³)'],
            'doi_box_no'=>$data['箱号'],
            'doi_box_size_unit'=>'cm',
            'doi_create_time'=>date('Y-m-d H:i:s'),
            'doi_remark'=>$remark,

        );

        $addDeliveryItem = Service_DeliveryOrderItem::add($arrs);
        return $addDeliveryItem;
    }

    /**
     * 验证发货单信息是否合法
     * @param array $data
     * @return array $error  错误信息
     */
    public static function checKDeliveryOrder($data)
    {

        $error = array();
        $title = array();
        $arr =array(1,2,3,4);

        $trueTitle = array(
            '序号', '销售单号', '物流单号', '商品sku', '商品名', '商品数量(个)', '内盒规格尺寸(cm)内盒长(cm)','内盒宽(cm)','内盒高(cm)','外箱规格尺寸(cm)外箱长(cm)','外箱宽(cm)','外箱高(cm)','商品尺寸', '商品重量(kg)',  '单箱净重(kg)',  '总净重(kg)',  '单箱毛重(kg)', '总毛重(kg)', '总箱数', '总立方(m³)',  '箱号', '发货日期(格式：yyyy/mm/dd)', '预计到货时间(格式：yyyy/mm/dd)', '承运方公司', '采购方公司', '物流费(￥)', '状态(1为：待处理；2为：未发货；3为：已发货；4为：已签收)','备注'
        );
        foreach ($data[1] as $key => $reo) {
            if($key !='备注'){
                $title[] = $key;
            }
        }
        //判断数据表头信息是否正确
        $diff = array_diff_assoc($title, $trueTitle);
        if (!empty($diff)) {
            $string = '';
            foreach ($diff as $detail) {
                $string .= $detail . ';';
            }
            $error['error'] = '发货单信息的这些表头关键字不对:' . $string;
            return $error;
        }
        //判断要填的字段值是否空
        foreach ($data as $key => $row) {
            $ks = $key +1;
            if ($row["销售单号"] == "") {
                $error[] = '发货单信息表第' . $ks . '行 销售单号 不能为空';
            }
            if (strlen($row['销售单号'])>50) {
                $error[] = '发货单信息表第' . $ks . '行 销售单号  长度已超出范围';
            }
            if ($row["物流单号"] == "") {
                $error[] = '发货单信息表第' . $ks . '行 物流单号 不能为空';
            }
            if (strlen($row['物流单号'])>50) {
                $error[] = '发货单信息表第' . $ks . '行 物流单号 长度已超出范围';
            }
            if ($row['商品sku'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 商品sku 不能为空';
            }
            if (strlen($row['商品sku'])>100) {
                $error[] = '发货单信息表第' . $ks . '行   商品sku :  ' . $row['商品sku'] . '长度已超出范围';
            }
            if ($row['商品名'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' . '商品名 不能为空';
            }
            if (strlen($row['商品名'])>100) {
                $error[] = '发货单信息表第' . $ks . '行 ' . '商品名长度已超出范围';
            }
            if ($row['商品数量(个)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' . '商品数量  不能为空';
            }
            if (is_int($row['商品数量(个)'] == "")) {
                $error[] = '发货单信息表第' . $ks . '行 ' . '商品数量  必须为整数';
            }
            if ($row['内盒规格尺寸(cm)内盒长(cm)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' . '内盒长  不能为空';
            }
            if (!is_numeric($row['内盒规格尺寸(cm)内盒长(cm)'])) {
                $error[] = '发货单信息表第' . $ks . '行 ' . '内盒长  必须是数字';
            }
            if ($row['内盒宽(cm)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' . '内盒宽  不能为空';
            }
            if (!is_numeric($row['内盒宽(cm)'])) {
                $error[] = '发货单信息表第' . $ks . '行 ' . '内盒宽  必须是数字';
            }
            if ($row['内盒高(cm)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' . '内盒高  不能为空';
            }
            if (!is_numeric($row['内盒高(cm)'])) {
                $error[] = '发货单信息表第' . $ks . '行 ' . '内盒高  必须是数字';
            }
            if ($row['外箱规格尺寸(cm)外箱长(cm)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' . '外箱长  不能为空';
            }
            if (!is_numeric($row['外箱规格尺寸(cm)外箱长(cm)'])) {
                $error[] = '发货单信息表第' . $ks . '行 ' . '外箱长  必须是数字';
            }
            if ($row['外箱宽(cm)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' . '外箱宽  不能为空';
            }
            if (!is_numeric($row['外箱宽(cm)'])) {
                $error[] = '发货单信息表第' . $ks . '行 ' . '外箱宽  必须是数字';
            }
            if ($row['外箱高(cm)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' . '外箱高  不能为空';
            }
            if (!is_numeric($row['外箱高(cm)'])) {
                $error[] = '发货单信息表第' . $ks . '行 ' . '外箱高  必须是数字';
            }
            if ($row['商品尺寸'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '商品尺寸 不能为空';
            }
            if (!is_numeric($row['商品尺寸'])) {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '商品尺寸 必须是数字';
            }
            if ($row['商品重量(kg)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' . '商品重量 不能为空';
            }
            if (!is_numeric($row['商品重量(kg)'])) {
                $error[] = '发货单信息表第' . $ks . '行 ' . '商品重量 必须是数字';
            }
            if ($row['单箱净重(kg)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' . '单箱净重 不能为空';
            }
            if (!is_numeric($row['单箱净重(kg)'])) {
                $error[] = '发货单信息表第' . $ks . '行 ' . '单箱净重 必须是数字';
            }
            if ($row['总净重(kg)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '总净重 不能为空';
            }
            if (!is_numeric($row['总净重(kg)'])) {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '总净重 必须是数字';
            }
            if ($row['单箱毛重(kg)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '单箱毛重 不能为空';
            }
            if (!is_numeric($row['单箱毛重(kg)'])) {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '单箱毛重 必须是数字';
            }
            if ($row['总毛重(kg)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '总毛重 不能为空';
            }
            if (!is_numeric($row['总毛重(kg)'])) {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '总毛重 必须是数字';
            }
            if ($row['总箱数'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '总箱数 不能为空';
            }
            if (!is_numeric($row['总箱数'])) {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '总箱数 必须是数字';
            }
            if ($row['总立方(m³)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '总立方 不能为空';
            }
            if (!is_numeric($row['总立方(m³)'])) {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '总立方 必须是数字';
            }
            if ($row['箱号'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '箱号 不能为空';
            }
            if ($row['发货日期(格式：yyyy/mm/dd)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '发货日期 不能为空';
            }
            if (is_string($row['发货日期(格式：yyyy/mm/dd)']) == true) {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '发货日期 格式不对';
            }
            if ($row['预计到货时间(格式：yyyy/mm/dd)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '预计到货时间 不能为空';
            }
            if (is_string($row['预计到货时间(格式：yyyy/mm/dd)'] == true)) {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '预计到货时间 格式不对';
            }
            if ($row['承运方公司'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '承运方公司 不能为空';
            }
            if ($row['采购方公司'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '采购方公司 不能为空';
            }
            if ($row['物流费(￥)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '物流费 不能为空';
            }
            if (!is_numeric($row['物流费(￥)'])) {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '物流费 必须是数字';
            }
            if ($row['状态(1为：待处理；2为：未发货；3为：已发货；4为：已签收)'] == "") {
                $error[] = '发货单信息表第' . $ks . '行 ' .  '状态 不能为空';
            }
            if (!is_numeric($row['状态(1为：待处理；2为：未发货；3为：已发货；4为：已签收)'])){
                $error[] = '发货单信息表第' . $ks . '行 ' .  '状态 不能为空且只能填写数值';
            }elseif (!in_array($row['状态(1为：待处理；2为：未发货；3为：已发货；4为：已签收)'],$arr)){
                $error[] = '发货单信息表第' . $ks . '行 ' .  '状态填写的数字无法识别 只能填（1或2或3或4这几种状态码）';
            }
        }
        return $error;
    }

    /**
     * 更新发货单信息
     * @param array $data
     * @return array
     */
    public static function updteDeliveryOrder($data,$doId,$uteId){
        $doShipTime=(date('Y-m-d H:i:s',intval(($data['发货日期(格式：yyyy/mm/dd)'] - 25569) * 3600 * 24)));
        $doPreReceiveTime=(date('Y-m-d H:i:s',intval(($data['预计到货时间(格式：yyyy/mm/dd)'] - 25569) * 3600 * 24)));
        $userId=Service_User::getUserId();
        $condition = array();
        $condition['user_id'] = $userId;
        //获取用户对应得ute_id
        $datas = Service_UserToErp::getUserAndErpRelation($condition);
        $arr = array(
            'user_id'=>$userId,
            'ute_id'=>$uteId,
            'do_no'=>$data['销售单号'],
            'do_ship_no'=>$data['物流单号'],
            'do_ship_time'=>$doShipTime,
            'do_pre_receive_time'=>$doPreReceiveTime,
            'do_ship_company'=>$data['承运方公司'],
            'do_ship_fee'=>$data['物流费(￥)'],
            'do_company'=>$data['采购方公司'],
            'do_status'=>$data['状态(1为：待处理；2为：未发货；3为：已发货；4为：已签收)'],
            'do_update_time'=>date('Y-m-d H:i:s'),
        );
        $addDelivery = self::update($arr,$doId);
        return $addDelivery;
    }

    /**
     * 更新发货单详情信息
     * @param array $data $doId
     * @return array
     */
    public static function updteDeliveryOrderItem($data,$doiId){
        $arrs = array(
            'doi_sku'=>$data['商品sku'],
            'doi_name'=>$data['商品名'],
            'doi_amount'=>$data['商品数量(个)'],
            'doi_unit'=>'个',
            'doi_box_size_long'=>$data['内盒规格尺寸(cm)内盒长(cm)'],
            'doi_box_size_width'=>$data['内盒宽(cm)'],
            'doi_box_size_heigh'=>$data['内盒高(cm)'],
            'doi_box_size'=>$data['内盒规格尺寸(cm)内盒长(cm)'].'*'.$data['内盒宽(cm)'].'*'.$data['内盒高(cm)'],
            'doi_box_outside_long'=>$data['外箱规格尺寸(cm)外箱长(cm)'],
            'doi_box_outside_width'=>$data['外箱宽(cm)'],
            'doi_box_outside_heigh'=>$data['外箱高(cm)'],
            'doi_box_outside_size' =>$data['外箱规格尺寸(cm)外箱长(cm)'].'*'.$data['外箱宽(cm)'].'*'.$data['外箱高(cm)'],
            'doi_size'=>$data['商品尺寸'],
            'doi_weight'=>$data['商品重量(kg)'],
            'doi_weight_unit'=>'kg',
            'doi_box_gw'=>$data['单箱净重(kg)'],
            'doi_box_gw_unit'=>'kg',
            'doi_box_total_gw'=>$data['总净重(kg)'],
            'doi_box_total_gw_unit'=>'kg',
            'doi_box_nw'=>$data['单箱毛重(kg)'],
            'doi_box_nw_unit'=>'kg',
            'doi_box_total_nw'=>$data['总毛重(kg)'],
            'doi_box_total_nw_unit'=>'kg',
            'doi_total_box'=>$data['总箱数'],
            'doi_total_cube'=>$data['总立方(m³)'],
            'doi_box_no'=>$data['箱号'],
            'doi_box_size_unit'=>'cm',
            'doi_update_time'=>date('Y-m-d H:i:s'),
            'doi_remark'=>$data['备注']
        );
        $addDeliveryItem = Service_DeliveryOrderItem::update($arrs,$doiId);
        return $addDeliveryItem;
    }




}