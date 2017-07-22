<?php
class Common_Service
{
    public  function getFields()
    {
        $row = array(
            'demo' => 'demo'
        );
        return $row;
    }

    /**
     * @param array $params
     * @param int $type
     * @return array
     */
    public  function getMatchFields($params = array(), $type = 1)
    {

        $row =$this->getFields();
        $fieldsArr = array();
        foreach ($row as $key => $val) {
            if (isset($params[$key]) && $params[$key] != $val) {
                $fieldsArr[$val] = trim($params[$key]);
            } else {
                $fieldsArr[$val] = '';
                if ($type == '1') {
                    unset($fieldsArr[$val]);
                }
            }
        }
        return $fieldsArr;
    }

    /**
     * @param array $params
     * @param int $type
     * @return array
     */
    public  function getVirtualFields($params = array(), $type = 0)
    {
        $fieldsArr =$this->getFields();
        $convertFieldsArr = array();
        foreach ($fieldsArr as $key => $val) {
            if (isset($params[$val])) {
                $convertFieldsArr[$key] = $params[$val];
            }
        }
        return $convertFieldsArr;
    }

    /**
     * @param array $params
     * @param int $type
     * @return array
     */
    public function getFieldsAlias($params = array(), $type = 0)
    {
        $fieldsArr =$this->getFields();
        $convertFieldsArr = $row = array();
        $params = array_combine($params, $params);
        foreach ($fieldsArr as $key => $val) {
            $convertFieldsArr[$val] = $key;
            if (isset($params[$val])) {
                $row[] = $val . ' as ' . $key;
            }
        }
        if ($type) {
            return $convertFieldsArr;
        }
        return $row;
    }

    /**
     * @param array $editFields
     * @param array $params
     * @return array
     */
    public function getEditFields($editFields = array(), $params = array())
    {
        foreach ($editFields as $key => $val) {
            if (isset($params[$key])) {
                $editFields[$key] = $params[$key];
            }
        }
        return $editFields;
    }


    /**
     * @param array $params
     * @param array $editFields
     * @return array
     */
    public function getMatchEditFields($params = array(), $editFields = array())
    {
        $row = $this->getFields();
        $fieldsArr = array();
        foreach ($row as $key => $val) {
            if (isset($params[$key]) && $params[$key] != $val) {
                $fieldsArr[$val] = trim($params[$key]);
            } else {
                $fieldsArr[$val] = '';
            }
            if (!isset($editFields[$val])) {
                unset($fieldsArr[$val]);
            }
        }
        return $fieldsArr;
    }
}