<?php
class Service_StockReportQueue extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_StockReportQueue|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_StockReportQueue();
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
    public static function update($row, $value, $field = "srq_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "srq_id")
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
    public static function getByField($value, $field = 'srq_id', $colums = "*")
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
        
              'E0'=>'srq_id',
              'E1'=>'user_id',
              'E2'=>'ute_id',
              'E3'=>'erp_no',
              'E4'=>'token',
              'E5'=>'execute_times',
              'E6'=>'frq_status',
              'E7'=>'frq_create_time',
              'E8'=>'frq_update_time',
        );
        return $row;
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function deleteIn($value, $field = "srq_id")
    {
        $model = self::getModelInstance();
        return $model->deleteIn($value, $field);
    }


    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function generateTasks() {
        $model = self::getModelInstance();
        return $model->generateTasks();
    }

    /**
     * @desc 摘取任务
     * @param int $taskNumber 需要摘取的任务数量
     * @return array 如果任务队列表不空，则取出任务并锁定，空则返回空数组
     *
     * @date 2017-04-10
     */
    public function pickTask($taskNumber){
        $model = self::getModelInstance();
        $taskArray = array();
        $selections = array('srq_id','user_id','ute_id', 'erp_no', 'erp_url', 'token');
        $condition = array('srq_status' => 0, 'execute_times' => 3);
        // 此处排序顺序很重要，不能改
        $taskArray = $model->getByCondition($condition, $selections, $taskNumber, 1, array('execute_times desc'));
        if($taskArray){
            // 查询到有任务记录，锁定
            $taskIds = Common_Common::getArrayColumn($taskArray, 'srq_id');
            self::lockTask($taskIds);
        }
        return $taskArray;
    }

    /**
     * @desc 给一个或多个任务上锁(状态转到{处理中}, 任务被执行次数累加1)
     * @param mixed $taskId 任务ID或任务ID数组
     * @return 锁定成功，返回true；否则返回false
     *
     * @date 2017-04-10
     */
    public static function lockTask($taskId){
        if(empty($taskId)){
            return false;
        }
        if(is_array($taskId)){
            $taskId = implode(',', $taskId);
        }
        $model = self::getModelInstance();
        return $model->lockTask($taskId);
    }

    /**
     * @param array $taskId
     * @return mixed
     */
    public static function releaseTask($taskId) {
        if (empty($taskId)) {
            return false;
        }
        $taskId = implode(',', $taskId);
        $model = self::getModelInstance();
        return $model->releaseTask($taskId);
    }
}