<?php
/*
 * Справочник школ
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.12.14
 */
class Data_Schools extends Data_Lists{
        function __construct() 
    {
        $this->tableName = 'schools';
        $this->arFields = array(
            'ID' => array(
              'NAME'=>'ID',
              'TYPE'=>self::FIELD_TYPE_INTEGER
            ),
            'NAME'=> array(
              'NAME'=>'NAME',
              'TYPE'=>  self::FIELD_TYPE_STRING
            ),
            'TOWNID' => array(
              'NAME'=>'TOWNID',
              'TYPE'=>self::FIELD_TYPE_INTEGER
            )	    
        );
    }
}
