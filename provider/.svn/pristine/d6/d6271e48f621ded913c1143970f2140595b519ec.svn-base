<?php
class Service_Bidding extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_Bidding|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_Bidding();
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
    public static function update($row, $value, $field = "bidding_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "bidding_id")
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
    public static function getByField($value, $field = 'bidding_id', $colums = "*")
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
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getByConditionJoinPSU($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $model = self::getModelInstance();
        return $model->getByConditionJoinPSU($condition, $type, $pageSize, $page, $order);
    }
    public static function getByConditionJoinSamples($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $model = self::getModelInstance();
        return $model->getByConditionJoinSamples($condition, $type, $pageSize, $page, $order);
    }
    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getBiddingList($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $model = self::getModelInstance();
        $join = array(
            array('bidding_feedback', 'bidding_feedback.bidding_id = bidding.bidding_id', array('bf_id as EF1', 'bf_participant as EF2', 'bf_result as EF3'))
        );
        $lists = $model->getByLeftJoin($condition, $type, $pageSize, $page, $order, $join);
        if ($type == 'count(*)') {
            return $lists;
        }
        if (empty($lists)) {
            return $lists;
        }
        $biddingId = Common_Common::getArrayColumn($lists, 'E0');
        $biddingId = implode(',', $biddingId);
        $lists = Common_Common::arrayWithKey($lists, 'E0');
        // 获取竞标产品图片
        $pictures = Service_BiddingPictures::getByCondition(array('bidding' => $biddingId), array('bidding_id as E1', 'bp_url as E2', 0, 0));
        foreach ($pictures as $key => $picture) {
            if (isset($lists[$picture['E1']])) {
                $lists[$picture['E1']]['EF4'][] = $picture['E2'];
            }
        }
        return $lists;
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
          'E0'=>'bidding_id',
          'E1'=>'bidding_no',
          'E2'=>'bidding_name',
          'E3'=>'bidding_name_en',
          'E4'=>'bidding_long',
          'E5'=>'bidding_size_unit',
          'E6'=>'bidding_color',
          'E7'=>'bidding_amount',
          'E8'=>'bidding_status',
          'E9'=>'bidding_time_start',
          'E10'=>'bidding_product_url',
          'E11'=>'bidding_participant',
          'E12'=>'bidding_create_time',
          'E13'=>'bidding_update_time',
          'E14'=>'bidding_time_end',
          'E15'=>'bidding_width',
          'E16'=>'bidding_heigh',
        );
        return $row;
    }

}