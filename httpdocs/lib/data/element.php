<?php


/**
 * Элементы категорий
 *
 * @author Maxim Vorobyev
 * @version 1.1
 * @changed 2015.12.05
 */
class Data_Element extends Data_Table {
     function __construct() {
        $this->tableName = 'element';
        $this->arFields = array(
            'ID' => array(
              'NAME'=>'ID',
              'TYPE'=>self::FIELD_TYPE_INTEGER
            ),
            'NAME'=> array(
              'NAME'=>'NAME',
              'TYPE'=>  self::FIELD_TYPE_STRING
            ),
            'CATEGORYID' => array(
              'NAME'=>'CATEGORYID',
              'TYPE'=>self::FIELD_TYPE_INTEGER               
            ),
	    'MODELID'=>  array(
		'NAME'=>'MODELID',
                'TYPE'=>self::FIELD_TYPE_INTEGER               
		
	    )
        );
    }
}
