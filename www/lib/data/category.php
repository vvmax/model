<?php

/**
 * Категории модели
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.10.14
 */
class Data_Category extends Data_Table {
    function __construct() {
        $this->tableName = 'CATEGORY';
        $this->arFields = array(
            'ID' => array(
              'NAME'=>'ID',
              'TYPE'=>self::FIELD_TYPE_INTEGER
            ),
            'NAME'=> array(
              'NAME'=>'NAME',
              'TYPE'=>  self::FIELD_TYPE_STRING
            ),
            'MODELID' => array(
              'NAME'=>'ID',
              'TYPE'=>self::FIELD_TYPE_INTEGER               
            )
        );
    }
}
