<?php
class Admin_ToolController extends Ec_Controller_Action
{

    public function indexAction()
    {
        $start = explode(' ', microtime());
        $db = Zend_Registry::get("db");
        $dbprefix = "";

        $sql = "show tables";
        $result = $db->query($sql);
        $rows = $result->fetchAll();

        // print_r($rows);exit;
        $tables = array();

        foreach ($rows as $k => $v) {
            foreach ($v as $k0 => $v0) {
                if (strpos($v0, 'copy') === false && strpos($v0, 'tmp') === false && strpos($v0, 'sql_query') === false) {
                    $tables[] = $v0;
                }
            }
        }


        $dir = APPLICATION_PATH . "/modules";
        $Ld = dir($dir);
        $allModules=array();
        while (false !== ($entry = $Ld->read())) {
            $checkdir = $dir . "/" . $entry;
            if (is_dir($checkdir) && ! preg_match("[^\.]", $entry)) {
                $allModules[]=$entry;
            }
        }
        $Ld->close();



        $this->view->page = '1';
        $this->view->msg = '';
        $this->view->tables = $tables;
        $this->view->modules =$allModules;


        $runFiles='';//已生成文件
        if ($this->_request->isPost()) {
            $selectTable = $this->_request->select_table;

            $modules = ucfirst(strtolower($this->_request->modules));
            $fileName = (strtolower($this->_request->fileName));
            $fileDir = (strtolower($this->_request->fileDir));//tpl 文件夹

            $myControllerName = ucfirst(strtolower($this->_request->ControllerName));

            if(empty($modules)){
                die('请选择模块....');
            }

            $isController = $this->_request->Controller;
            $isTpl = $this->_request->tpl;

            //自定义字段
            $field = $this->_request->field;
            if(empty($field)){
                die('请填写自定义字段....');
            }
            $columns = $this->_request->columns;
            $titles = $this->_request->titles;
            $replaceFile = $this->_request->replaceFile;

            //需要验证字段
            $validator = $this->_request->validator;

            //设置搜索条件字段
            $search = $this->_request->search;
            if(!empty($search)){
                $search = array_filter($search);
            }


            //清除时间类型字段
            $dataType = $this->_request->dataType;

            //编辑字段
            $editTitles = $this->_request->editTitles;
            $editColumns = $this->_request->editColumns;
            $editTitles = array_filter($editTitles);
//print_r($editTitles);die;
            //转换字段值
            $newEditTitles=array();
            foreach($editTitles as $eek =>$eev){
                if(isset($editColumns[$eek])){
                    $newEditTitles[$eek]=array(
                        'name'=>$editColumns[$eek],
                        'title'=>$eev,
                        'valueClass'=>''
                    );
                }
            }

            //整理验证字段匹配修改内容才验证
            $newValidator=array();
            $validator = array_filter($validator);
            foreach($validator as $eek =>$eev){
                if(isset($editTitles[$eek])){
                    $newValidator[$eek]=array(
                        'title'=>$editTitles[$eek],
                        'value'=>$eev
                    );
                }
            }

            //整合验证文本规则
            if(!empty($newEditTitles) && !empty($newValidator) ){
                foreach($newEditTitles as $kkk =>$vvv){
                    if(isset($newValidator[$kkk])){
                        $newEditTitles[$kkk]['valueClass']=$newValidator[$kkk]['value'];
                    }
                }
            }
         //   print_r($newEditTitles);die;
//print_r($fileName);die;

            $showFields=array();
            foreach($titles as $k =>$v){
                if($v!=''){
                    $showFields[$k]=$v;
                }
            }

            //列表转化后的JS字段
            $jsShowFields=array();
            foreach($showFields as $k =>$v){
                if(!isset($editColumns[$k])){
                    die('转化后的JS字段 err.');
                }
                $jsShowFields[$editColumns[$k]]=$v;
            }

            //列表转化后的搜索字段

            if(!empty($search)){
                $searchShowFields=array();
                foreach($search as $k =>$v){
                    if(!isset($editColumns[$k])){
                        die('搜索字段 err.');
                    }
                    $searchShowFields[$k]=array(
                        'title'=>isset($editTitles[$k])?$editTitles[$k]:$k,
                        'fields'=>$editColumns[$k]
                    );
                }
            }


//print_r($searchShowFields);die;




            if ($selectTable != 'ALL') {
                $tables = array($selectTable);
            }
            foreach ($tables as $tableName) {

                $sql1 = "desc $tableName";
                $result = $db->query($sql1);
                $rows = $result->fetchAll();

                $columns =$clearColumns= array();
                $pri = "";
                foreach ($rows as $v) {
                    if ($v["Key"] == "PRI") {
                        $pri = $v["Field"];
                    } else {
                        $columns[] = $v;
                        if($v["Type"]=='datetime' && $dataType ){
                            continue;
                        }
                        $clearColumns[] = $v;

                    }
                }

                $arr[] = array(
                    "table" => $tableName,
                    "pri" => $pri,
                    "columns" => $columns,
                    "clearColumns" => $clearColumns
                );
            }

            $fileName=!empty($fileName)?$fileName:strtolower($selectTable);//tpl文件名
         //  $fileDir=!empty($fileDir)?$fileDir:strtolower($selectTable);//tpl文件夹
            $fileDir=!empty($fileDir)?('/'.$fileDir.'/'):'/';//tpl文件夹
//die($fileName);
            foreach ($arr as $v) {
                $table = preg_replace("/^" . $dbprefix . "/", "", $v['table']);

                $pri = $v['pri'];
                $columns = $v['columns'];
                $clearColumns = $v['clearColumns'];
                // print_r($columns);exit;
                $table = ucfirst($table);
                $class = preg_replace("/_([a-z]{1})/e", "strtoupper('\\1')", $table);
                $model = file_get_contents(APPLICATION_PATH . "/../data/template/Model.php");
                $model = preg_replace("/MMMMMMM/", "{$class}", $model);
                $model = preg_replace("/PRI/", "{$pri}", $model);
                $model = preg_replace("/TTTTTT/", "{$modules}", $model);
                $where = "";
                foreach ($clearColumns as $column) {
                    $where .= '
        if(isset($condition["' . $column["Field"] . '"]) && $condition["' . $column["Field"] . '"] != ""){';
                    $where .= '
            $select->where("' . $column["Field"] . ' = ?",$condition["' . $column["Field"] . '"]);';
                    $where .= "
        }";
                }

                $model = preg_replace("/\/\*SELECT_WHERE\*\//", $where, $model);
                $url = APPLICATION_PATH . "/models/Table/" . ucfirst($class) . ".php";
                if (!file_exists($url) || $replaceFile ) {
                    file_put_contents($url, $model);
                    $runFiles.=$url."<br/>";
                }

              //  continue;

                $table = strtolower($table);

                $dbTable = file_get_contents(APPLICATION_PATH . "/../data/template/DbTable.php");
                $dbTable = preg_replace("/MMMMMMM/", ucfirst($class), $dbTable);
                $dbTable = preg_replace("/TABLE/", "{$table}", $dbTable);
                $dbTable = preg_replace("/PRI/", "{$pri}", $dbTable);
                $dbTable = preg_replace("/TTTTTT/", "{$modules}", $dbTable);
                // $model = preg_replace("//","",$model);
                $url = APPLICATION_PATH . "/models/DbTable/" . ucfirst($class) . ".php";
                if (!file_exists($url) || $replaceFile ) {
                    file_put_contents($url, $dbTable);
                    $runFiles.=$url."<br/>";
                }

                $service = file_get_contents(APPLICATION_PATH . "/../data/template/Service.php");
                $service = preg_replace("/MMMMMMM/", ucfirst($class), $service);
                $service = preg_replace("/PRI/", "{$pri}", $service);

                $service = preg_replace("/TTTTTT/", "{$modules}", $service);

                //修改验证字段
                /*                $updateFields = '';
                                foreach ($clearColumns as $column) {
                                    $updateFields .= '
                        $validateArr[] = array("name" =>"' . $column["Field"] . '", "value" =>$val["' . $column["Field"] . '"], "regex" => array("require"));';

                                }*/


                //验证字段
                $updateFields = '';
                $regex='';
                foreach ($newValidator as $column =>$vvvv) {
                    switch($vvvv['value']){
                        case 1:
                            $regex='"regex" => array("require",));';
                            break;
                        case 2:
                            $regex='"regex" => array("require","integer",));';
                            break;
                        case 3:
                            $regex='"regex" => array("positive"));';
                            break;
                    }
                    //转化为系统语言
                    $title=str_replace('<{t}>','',$vvvv["title"]);
                    $title=str_replace('<{/t}>','',$title);
                    $title='EC::Lang(\''.$title.'\')';
                    $updateFields .= '
        $validateArr[] = array("name" =>'.$title.', "value" =>$val["' . $column . '"], '.$regex;

                }

                $service = preg_replace("/\/\*validatorFiles\*\//", "{$updateFields}", $service);

                //修改字段
                $editFields = '';
                $editFields .= '
              \''.$pri.'\'=>\'\',';
                foreach ($clearColumns as $column) {
                    $editFields .= '
              \''.$column['Field'].'\'=>\'\',';
                }
                $service = preg_replace("/\/\*postFields\*\//", "{$editFields}", $service);



                //替换字段对照数组
                $conditionFields = '';
                foreach ($editColumns as $ek =>$ev) {
                    $conditionFields .= '
              \''.$ev.'\'=>\''.$ek.'\',';
                }
                $service = preg_replace("/\/\*MatchFields\*\//", "{$conditionFields}", $service);


                $url = APPLICATION_PATH . "/models/Service/" . ucfirst($class) . ".php";
                if (!file_exists($url) || $replaceFile ) {
                    file_put_contents($url, $service);
                    $runFiles.=$url."<br/>";
                }



                $controller = file_get_contents(APPLICATION_PATH . "/../data/template/Controller.php");
                $controller = preg_replace("/MMMMMMM/", ucfirst($class), $controller);
                $controller = preg_replace("/PRI/", "{$pri}", $controller);
                $controller = preg_replace("/TPLFILE/", "{$fileName}", $controller);
                $tplModule=strtolower($modules);
                $controller = preg_replace("/TTTTTT/", "{$modules}", $controller);
                $controller = preg_replace("/TT-DIR/", "{$tplModule}", $controller);

                $controller = preg_replace("/TPL-DIR/", "{$fileDir}", $controller);

                $controllerName = preg_replace("/" . ucfirst($modules) . "/", "", ucfirst($class));
                //自定义
                if(!empty($myControllerName)){
                    $controllerName=$tplControllerName=$myControllerName;
                }else{
                   // $moduleAction=strtolower(str_replace('_','-',$table));
                    $tplControllerName=strtolower(str_replace('_','-',$table));
                }
//die($controllerName);
                $controller = preg_replace("/MYACTION/", $controllerName, $controller);



                $editFields='';
                $i=0;
                foreach($showFields as $kkk =>$vvv ){
                    $editFields .= '
                \''.$kkk.'\',';
                }
                //返回主键字段
                if(!isset($showFields[$pri])){
                    $editFields .= '
                \''.$pri.'\',';
                }
                $controller = preg_replace("/\/\*REPLACEFILDS\*\//", "{$editFields}", $controller);


                //匹配提交修改字段
                $editFields = '
              \''.$pri.'\'=>\'\',';
                foreach ($editTitles as $column =>$v) {
                    $editFields .= '
              \''.$column.'\'=>\'\',';
                }
                $controller = preg_replace("/\/\*EDITFIELDSARRAY\*\//", "{$editFields}", $controller);




                //搜索字段
                /*                $conditionFields = '';
                                foreach ($clearColumns as $column) {
                                    $conditionFields .= '
                              \''.$column['Field'].'\'=>\'\',';
                                }
                                $controller = preg_replace("/\/\*conditionFields\*\//", "{$conditionFields}", $controller);*/


                $url = APPLICATION_PATH . "/modules/" . $modules . "/controllers/" . $controllerName . "Controller.php";
                if ((!file_exists($url) || $replaceFile ) && $isController) {
                    file_put_contents($url, $controller);
                    $runFiles.=$url."<br/>";
                }

                //生成 tpl 文件===================================================todo

                $tpl = file_get_contents(APPLICATION_PATH . "/../data/template/index.tpl");

                //  $tpl = preg_replace("/EZTABLENAME/", "{$fileName}", $tpl);
                //主键必须为0

                $tpl = preg_replace("/PRI/", "{$field}0", $tpl);

                $modules=strtolower($modules);
               // $moduleAction='';
                $tpl = preg_replace("/controllerName/", $tplControllerName, $tpl);
                $tpl = preg_replace("/TTTTTT/", "{$modules}", $tpl);
                $tpl = preg_replace("/moduleAction/", "{$modules}", $tpl);


                /*               $tplFields = '';
                                foreach ($clearColumns as $column) {
                                    $tplFields .= '
                        <tr>
                            <td class="dialog-module-title">'.$column['Field'].':</td>
                            <td><input type="text" name="'.$column['Field'].'" id="'.$column['Field'].'" class="input_text"/></td>
                        </tr>';
                                }*/
                $tplFields='';
                foreach($jsShowFields as $kkk =>$vvv ){
                    $tplFields .= '
                    html += "<td>" + val.'.$kkk.' + "</td>";';
                }

                $tpl = preg_replace("/\/\*EZDATALIST\*\//", "{$tplFields}", $tpl);

                $tplFields = '';
                foreach ($newEditTitles as $eek =>$newval) {

                    $regex='';
                    $errMsg='';
                    $showErr='';
                        switch($newval['valueClass']){
                            case 1:
                                $regex='validator="required"';
                                $errMsg='err-msg="<{t}>require<{/t}>"';
                                $showErr='<span class="msg">*</span>';
                                break;
                            case 2:
                                $regex='validator="required numeric"';
                                $errMsg='err-msg="<{t}>require<{/t}>|<{t}>numeric<{/t}>"';
                                $showErr='<span class="msg">*</span>';
                                break;
                            case 3:
                                $regex='validator="numeric"';
                                $errMsg='err-msg="<{t}>numeric<{/t}>"';
                                break;
                        }

                    $tplFields .= '
        <tr>
            <td class="dialog-module-title">'.$newval['title'].':</td>
            <td><input type="text" name="'.$newval['name'].'" id="'.$newval['name'].'" '.$regex.' '.$errMsg.' class="input_text"/>'.$showErr.'</td>
        </tr>';
                }

                $tpl = preg_replace("/\/\*EZTBODYCON\*\//", "{$tplFields}", $tpl);

///搜索
                /*                $tplFields = '';
                                foreach ($clearColumns as $column) {
                                    $tplFields .= '
                       '.$column['Field'].'：<input type="text" name="'.$column['Field'].'" id="'.$column['Field'].'" class="input_text keyToSearch"/>';
                                }*/


                $tplFields = '';
               if(!empty($searchShowFields)){


                foreach ($searchShowFields as $column) {
                    $tplFields .= '
       '.$column['title'].'：<input type="text" name="'.$column['fields'].'" id="'.$column['fields'].'" class="input_text keyToSearch"/>';
                }
               }

                $tpl = preg_replace("/\/\*EZSEARCHINPUT\*\//", "{$tplFields}", $tpl);

///列表
                $tplFields = '';
//                foreach ($columns as $column) {
//                    $tplFields .= '
//       <th>'.$column['Field'].'</th>';
//                }


                foreach($showFields as $kkk =>$vvv ){
                    $tplFields .= '
       <td>'.$vvv.'</td>';

                }


                $tpl = preg_replace("/\/\*EZTHEADTH\*\//", "{$tplFields}", $tpl);
              //  if(!is_dir(APPLICATION_PATH . "/modules/" . $modules . "/views/" . $controllerName)){
                  //  mkdir(APPLICATION_PATH . "/modules/" . $modules . "/views/" . $controllerName,'0777');
              //  }
              //  $url = APPLICATION_PATH . "/modules/" . $modules . "/views/" . $fileDir . "/".$fileName.'_index.tpl';
                $url = APPLICATION_PATH . "/modules/" . $modules . "/views" . $fileDir . "".$fileName.'_index.tpl';
                if ((!file_exists($url) || $replaceFile) && $isTpl ) {
                    file_put_contents($url, $tpl);
                    $runFiles.=$url."<br/>";
                }



                //生成 js 文件===================================================
                /*
                                $js = file_get_contents(APPLICATION_PATH . "/../data/template/index.js");

                                $urlController=str_replace('_','-',strtolower($table));
                                $modules=strtolower($modules);
                                $controllerName=strtolower($controllerName);
                                $js = preg_replace("/MMMMMMM/", $controllerName, $js);
                               // $js = preg_replace("/PRI/", "{$pri}", $js);
                                $js = preg_replace("/PRI/", "{$field}0", $js);

                                $js = preg_replace("/TTTTTT/", "{$modules}", $js);

                                $js = preg_replace("/EZTABLENAME/", "{$fileName}", $js);

                                ///列表
                                $tplFields = '';
                //                foreach ($columns as $column) {
                //                    $tplFields .= '
                //             html += "<td >" + val.'.$column['Field'].' + "</td>";';
                //                }


                                foreach($jsShowFields as $kkk =>$vvv ){
                                    $tplFields .= '
                                    html += "<td >" + val.'.$kkk.' + "</td>";';
                                }

                                $js = preg_replace("/\/\*EZDATALIST\*\//", "{$tplFields}", $js);

                                $url = APPLICATION_PATH . "/../public/js/modules/".$fileName.'_index.js';
                                if (!file_exists($url) || $replaceFile ) {
                                    file_put_contents($url, $js);
                                    $runFiles.=$url."<br/>";
                                }
                */



            }
            $end = explode(' ', microtime());
            $this->view->msg = "耗时：" . ($end[1] - $start[1]) . "s";
        }
        $this->view->runFiles = $runFiles;
        echo Ec::renderTpl("admin/views/tool/init-system.tpl", "admin/layout");
    }

    public function getTableAction()
    {
        $db = Zend_Registry::get("db");
        $selectTable = $this->_request->tableName;
        $sql1 = "desc $selectTable";
        $result = $db->query($sql1);
        $rows = $result->fetchAll();
        $columns=array();
        foreach ($rows as $v) {
            $columns[] = $v;
        }

        die(Zend_Json::encode($columns));
    }

    public function getViewAction()
    {
        $modules=$this->_request->getParam('modules','');
        $dir = APPLICATION_PATH . "/modules/".$modules."/views";
        $Ld = dir($dir);
        $dirAll=array();
        while (false !== ($entry = $Ld->read())) {
            $checkdir = $dir . "/" . $entry;
            if (is_dir($checkdir) && ! preg_match("[^\.]", $entry)) {
                $dirAll[]=$entry;
            }
        }
        $Ld->close();
        die(Zend_Json::encode($dirAll));
    }

    public function addLanguageAction()
    {
        if($this->_request->isPost()){
            $file=$this->_request->getParam('files');
            $cnValue=$this->_request->getParam('cnValue');
            $enValue=$this->_request->getParam('enValue');
            if(empty($file) || empty($cnValue) || empty($enValue) ){
                die('任何值都不能为空.');
            }
            $url = APPLICATION_PATH . "/languages/zh_CN.php";
            $files="".'\''.$file.'\'=>\''.$cnValue.'\',';
            $files.="\n". '/*ADDLANG*/';

            $lang = preg_replace("/\/\*ADDLANG\*\//", "{$files}", file_get_contents($url));
            file_put_contents($url, $lang);

            $url = APPLICATION_PATH . "/languages/en_US.php";
            $files="".'\''.$file.'\'=>\''.$enValue.'\',';
            $files.="\n". '/*ADDLANG*/';
            $lang = preg_replace("/\/\*ADDLANG\*\//", "{$files}", file_get_contents($url));
            file_put_contents($url, $lang);
        }

        $this->view->page = '2';
        echo Ec::renderTpl("admin/views/tool/init-system.tpl", "admin/layout");
    }

    public function addAclAction()
    {
       $aclObj=new Ec_ActionTool();
       $list=$aclObj->addAcl();
        print_r($list);
    }

    public function updateJsonAction()
    {

        $lang=Common_Languages::getLang();
        $json=json_encode($lang);

        $url = APPLICATION_PATH . "/../public/js/json/languages.json";
        file_put_contents($url, $json);

    }

}