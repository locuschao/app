<?php

class Default_QueueController extends Zend_Controller_Action
{
    private $pageSize = 100;
    private $page = 1;
    private $taskNumber = 10;
    private $maxReleaseLimit = 100;

    public function init()
    {   
        error_reporting(0);
    }

    /**
     * @desc 生成获取产品库存报表任务
     * @author gan
     * @date 2017-04-10
     * @return string
     */
    public function generateStockReportQueueAction() {
        Service_StockReportQueue::generateTasks();
        exit;
    }

    /**
     * @desc 执行获取产品库存报表任务
     * @author gan
     * @date 2017-04-10
     * @return string
     */
    public function getStockReportAction(){
        set_time_limit(0);
        $service = new Service_StockReportQueue();
        // 任务id数组，每个任务执行后扔到相应的处理数组
        $taskIdsToHandle = array('picked' => array(), 'delete' => array(), 'release' => array());
        while(true){
            $taskArray = $service::pickTask($this->taskNumber);
            if(empty($taskArray)){
                // 所有任务执行完，退出线程循环
                break;
            }
            try{
                $breakCurrentProcess = false;
                $taskIdsToHandle['delete'] = array();
                $paramsJson = json_encode(array('pagination' => array('pageSize' => $this->pageSize, 'page' => $this->page)));

                foreach($taskArray as $task){
                    array_push($taskIdsToHandle['picked'], $task['srq_id']);
                    array_push($taskIdsToHandle['delete'], $task['srq_id']);
                    $params = array(
                        'erp_url' => $task['erp_url'],
                        'supplierToken' => $task['token'],
                        'service' => 'getProductInventoryData',
                        'paramsJson'=> $paramsJson
                    );
                    $queueArray = array(
                        'srq_id' => $task['srq_id'],
                        'ute_id' => $task['ute_id'],
                        'erp_no' => $task['erp_no'],
                        'user_id' => $task['user_id']
                    );

                    $downResult = Process_ApiProcess::getStockReport($params, $queueArray);

                    if(!$downResult){
                        array_pop($taskIdsToHandle['delete']);
                        array_push($taskIdsToHandle['release'], $task['srq_id']);
                    }
                }
                // 删除已完成任务
                if($taskIdsToHandle['delete']){
                    $service::deleteIn($taskIdsToHandle['delete']);
                }
                if(count($taskIdsToHandle['release']) > $this->maxReleaseLimit){
                    // 待释放任务过多，结束进程并释放，避免php爆内存
                    $breakCurrentProcess = true;
                }
                if($breakCurrentProcess){
                    // 退出当前进程
                    break;
                }
            } catch(Exception $ex){
                // 程序异常，退出进程循环并释放任务
                break;
            }
        }
        // 释放未完成任务
        if($taskIdsToHandle['release']){
            $service->releaseTask($taskIdsToHandle['release']);
        }
        exit;
    }


    /**
     * @desc 生成获取产品反馈报表任务
     * @author Zijie Yuan
     * @date 2017-04-03
     * @return string
     */
    public function generateFeedbackReportQueueAction() {
        Service_FeedbackReportQueue::generateTask();
        exit;
    }

    /**
     * @desc 执行获取产品反馈报表任务
     * @author Zijie Yuan
     * @date 2017-03-20
     * @return string
     */
    public function getFeedbackReportAction(){
        set_time_limit(0);
        $service = new Service_FeedbackReportQueue;
        // 任务id数组，每个任务执行后扔到相应的处理数组
        $taskIdsToHandle = array('picked' => array(), 'delete' => array(), 'release' => array());
        while(true){
            $taskArray = $service::pickTask($this->taskNumber);
            if(empty($taskArray)){
                // 所有任务执行完，退出线程循环
                break;
            }
            try{
                $breakCurrentProcess = false;
                $taskIdsToHandle['delete'] = array();
                foreach($taskArray as $task){
                    array_push($taskIdsToHandle['picked'], $task['frq_id']);
                    array_push($taskIdsToHandle['delete'], $task['frq_id']);
                    $paramsJson = json_encode(
                        array(
                            'pagination' => array('pageSize' => $this->pageSize, 'page' => $this->page),
                            'updateTimeFrom' => $task['start_time'],
                            'updateTimeTo' => $task['end_time']
                        )
                    );
                    $params = array(
                        'erp_url' => $task['erp_url'],
                        'supplierToken' => $task['token'],
                        'service' => 'getProductTroubleData',
                        'paramsJson'=> $paramsJson
                    );
                    $queueArray = array(
                        'frq_id' => $task['frq_id'],
                        'erp_no' => $task['erp_no'],
                        'user_id' => $task['user_id'],
                        'ute_id' => $task['ute_id']
                    );

                    $downResult = Process_ApiProcess::getFeedbackReport($params, $queueArray);

                    if(!$downResult){
                        array_pop($taskIdsToHandle['delete']);
                        array_push($taskIdsToHandle['release'], $task['frq_id']);
                    }
                }
                // 删除已完成任务
                if($taskIdsToHandle['delete']){
                    $service::deleteIn($taskIdsToHandle['delete']);
                }
                if(count($taskIdsToHandle['release']) > $this->maxReleaseLimit){
                    // 待释放任务过多，结束进程并释放，避免php爆内存
                    $breakCurrentProcess = true;
                }
                if($breakCurrentProcess){
                    // 退出当前进程
                    break;
                }
            } catch(Exception $ex){
                // 程序异常，退出进程循环并释放任务
                break;
            }
        }
        // 释放未完成任务
        if($taskIdsToHandle['release']){
            $service->releaseTask($taskIdsToHandle['release']);
        }
        exit;
    }

    /**
     * @desc 生成获取销售报表任务
     * @author Zijie Yuan
     * @date 2017-04-03
     * @return string
     */
    public function generateSaleReportQueueAction() {
        Service_SaleReportQueue::generateTask();
        exit;
    }

    /**
     * @desc 获取销售报表
     * @author Zijie Yuan
     * @date 2017-04-03
     * @return string
     */
    public function getSaleReportAction() {
        set_time_limit(0);
        $service = new Service_SaleReportQueue;
        // 任务id数组，每个任务执行后扔到相应的处理数组
        $taskIdsToHandle = array('picked' => array(), 'delete' => array(), 'release' => array());
        while(true){
            $taskArray = $service::pickTask($this->taskNumber);
            if(empty($taskArray)){
                // 所有任务执行完，退出线程循环
                break;
            }
            try{
                $breakCurrentProcess = false;
                $taskIdsToHandle['delete'] = array();
                $paramsJson = json_encode(array('pagination' => array('pageSize' => $this->pageSize, 'page' => $this->page)));
                foreach($taskArray as $task){
                    array_push($taskIdsToHandle['picked'], $task['srq_id']);
                    array_push($taskIdsToHandle['delete'], $task['srq_id']);
                    $params = array(
                        'erp_url' => $task['erp_url'],
                        'supplierToken' => $task['token'],
                        'service' => 'getProductSaleData',
                        'paramsJson'=> $paramsJson
                    );
                    $queueArray = array(
                        'srq_id' => $task['srq_id'],
                        'erp_no' => $task['erp_no'],
                        'user_id' => $task['user_id'],
                        'ute_id' => $task['ute_id']
                    );
                    $downResult = Process_ApiProcess::getSaleReport($params, $queueArray);
                    if(!$downResult){
                        array_pop($taskIdsToHandle['delete']);
                        array_push($taskIdsToHandle['release'], $task['srq_id']);
                    }
                }
                // 删除已完成任务
                if($taskIdsToHandle['delete']){
                    $service::deleteIn($taskIdsToHandle['delete']);
                }
                if(count($taskIdsToHandle['release']) > $this->maxReleaseLimit){
                    // 待释放任务过多，结束进程并释放，避免php爆内存
                    $breakCurrentProcess = true;
                }
                if($breakCurrentProcess){
                    // 退出当前进程
                    break;
                }
            } catch(Exception $ex){
                // 程序异常，退出进程循环并释放任务
                break;
            }
        }
        // 释放未完成任务
        if($taskIdsToHandle['release']){
            $service->releaseTask($taskIdsToHandle['release']);
        }
        exit;
    }

    /**
     * @desc 生成产品管理数据的任务
     * @author gan
     * @date 2017-06-12
     * @return string
     */
    public function generateProductQueueAction() {
        Service_ProductQueue::generateTask();
        exit;
    }

    /**
     * @desc 获取产品管理数据
     * @author gan
     * @date 2017-06-12
     * @return string
     */
    public function getProductAction(){
        set_time_limit(0);
        $service = new Service_ProductQueue();
        // 任务id数组，每个任务执行后扔到相应的处理数组
        $taskIdsToHandle = array('picked' => array(), 'delete' => array(), 'release' => array());
        while(true){
            $taskArray = $service::pickTask($this->taskNumber);

            if(empty($taskArray)){
                // 所有任务执行完，退出线程循环
                break;
            }
            try{
                $breakCurrentProcess = false;
                $taskIdsToHandle['delete'] = array();

                $paramsJson = json_encode(array('pagination' => array('pageSize' => $this->pageSize, 'page' => $this->page)));
                foreach($taskArray as $task){
                    array_push($taskIdsToHandle['picked'], $task['pq_id']);
                    array_push($taskIdsToHandle['delete'], $task['pq_id']);
                    $params = array(
                        'erp_url' => $task['erp_url'],
                        'supplierToken' => $task['token'],
                        'service' => 'getProductList',
                        'paramsJson'=> $paramsJson
                    );
                    $queueArray = array(
                        'pq_id' => $task['pq_id'],
                        'erp_no' => $task['erp_no'],
//                        'user_id' => $task['user_id'],
                        'ute_id' => $task['ute_id']
                    );
                    $downResult = Process_ApiProcess::getProduct($params, $queueArray);
                    if(!$downResult){
                        array_pop($taskIdsToHandle['delete']);
                        array_push($taskIdsToHandle['release'], $task['pq_id']);
                    }
                }

                // 删除已完成任务
                if($taskIdsToHandle['delete']){
                    $service::deleteIn($taskIdsToHandle['delete']);
                }
                if(count($taskIdsToHandle['release']) > $this->maxReleaseLimit){
                    // 待释放任务过多，结束进程并释放，避免php爆内存
                    $breakCurrentProcess = true;
                }
                if($breakCurrentProcess){
                    // 退出当前进程
                    break;
                }
            } catch(Exception $ex){
                // 程序异常，退出进程循环并释放任务
                break;
            }
        }
        // 释放未完成任务
        if($taskIdsToHandle['release']){
            $service->releaseTask($taskIdsToHandle['release']);
        }
        exit;

    }
    
    /**
     * @desc 生成异常管理QC数据任务
     * @date 2017-06-20
     * @return string
     */
    public function generateExceptionQcQueueAction() {
        Service_OrderQcExceptionQueue::generateTask();
        exit;
    }

    /**
     * @desc 获取管理QC数据
     * @date 2017-06-20
     * @return string
     */
    public function getExceptionQcAction(){
        set_time_limit(0);
        $service = new Service_OrderQcExceptionQueue();
        // 任务id数组，每个任务执行后扔到相应的处理数组
        $taskIdsToHandle = array('picked' => array(), 'delete' => array(), 'release' => array());
        while(true){
            $taskArray = $service::pickTask($this->taskNumber);
            if(empty($taskArray)){
                // 所有任务执行完，退出线程循环
                break;
            }
            try{
                $breakCurrentProcess = false;
                $taskIdsToHandle['delete'] = array();
                $paramsJson = json_encode(array('pagination' => array('pageSize' => $this->pageSize, 'page' => $this->page)));
                foreach($taskArray as $task){
                    array_push($taskIdsToHandle['picked'], $task['oqeq_id']);
                    array_push($taskIdsToHandle['delete'], $task['oqeq_id']);
                    $params = array(
                        'erp_url' => $task['erp_url'],
                        'supplierToken' => $task['token'],
                        'service' => 'getQcException',
                        'paramsJson'=> $paramsJson
                    );
                    $queueArray = array(
                        'oqeq_id' => $task['oqeq_id'],
                        'erp_no' => $task['erp_no'],
                        'user_id' => $task['user_id'],
                        'ute_id' => $task['ute_id']
                    );
                    $downResult = Process_ApiProcess::getQcException($params, $queueArray);
                    if(!$downResult){
                        array_pop($taskIdsToHandle['delete']);
                        array_push($taskIdsToHandle['release'], $task['oqeq_id']);
                    }
                }
                // 删除已完成任务
                if($taskIdsToHandle['delete']){
                    $service::deleteIn($taskIdsToHandle['delete']);
                }
                if(count($taskIdsToHandle['release']) > $this->maxReleaseLimit){
                    // 待释放任务过多，结束进程并释放，避免php爆内存
                    $breakCurrentProcess = true;
                }
                if($breakCurrentProcess){
                    // 退出当前进程
                    break;
                }
            } catch(Exception $ex){
                // 程序异常，退出进程循环并释放任务
                break;
            }
        }
        // 释放未完成任务
        if($taskIdsToHandle['release']){
            $service->releaseTask($taskIdsToHandle['release']);
        }
        exit;

    }

    /**
     * @desc 生成收货异常管理数据任务
     * @date 2017-06-20
     * @return string
     */
    public function generateExceptionQueueAction() {
        Service_OrderReceiveExceptionQueue::generateTask();
        exit;
    }

    /**
     * @desc 获取收货管理数据
     * @date 2017-06-20
     * @return string
     */
    public function getExceptionAction(){
        set_time_limit(0);
        $service = new Service_OrderReceiveExceptionQueue();
        // 任务id数组，每个任务执行后扔到相应的处理数组
        $taskIdsToHandle = array('picked' => array(), 'delete' => array(), 'release' => array());
        while(true){
            $taskArray = $service::pickTask($this->taskNumber);
            if(empty($taskArray)){
                // 所有任务执行完，退出线程循环
                break;
            }
            try{
                $breakCurrentProcess = false;
                $taskIdsToHandle['delete'] = array();
                $paramsJson = json_encode(array('pagination' => array('pageSize' => $this->pageSize, 'page' => $this->page)));
                foreach($taskArray as $task){
                    array_push($taskIdsToHandle['picked'], $task['oreq_id']);
                    array_push($taskIdsToHandle['delete'], $task['oreq_id']);
                    $params = array(
                        'erp_url' => $task['erp_url'],
                        'supplierToken' => $task['token'],
                        'service' => 'getReceivingException',
                        'paramsJson'=> $paramsJson
                    );
                    $queueArray = array(
                        'oreq_id' => $task['oreq_id'],
                        'erp_no' => $task['erp_no'],
                        'user_id' => $task['user_id'],
                        'ute_id' => $task['ute_id']
                    );
                    $downResult = Process_ApiProcess::getReceivingException($params, $queueArray);
                    if(!$downResult){
                        array_pop($taskIdsToHandle['delete']);
                        array_push($taskIdsToHandle['release'], $task['oreq_id']);
                    }
                }
                // 删除已完成任务
                if($taskIdsToHandle['delete']){
                    $service::deleteIn($taskIdsToHandle['delete']);
                }
                if(count($taskIdsToHandle['release']) > $this->maxReleaseLimit){
                    // 待释放任务过多，结束进程并释放，避免php爆内存
                    $breakCurrentProcess = true;
                }
                if($breakCurrentProcess){
                    // 退出当前进程
                    break;
                }
            } catch(Exception $ex){
                // 程序异常，退出进程循环并释放任务
                break;
            }
        }
        // 释放未完成任务
        if($taskIdsToHandle['release']){
            $service->releaseTask($taskIdsToHandle['release']);
        }
        exit;

    }
    


}