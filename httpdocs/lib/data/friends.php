<?php


/*
 * Таблица связей учителей и учеников
 *
 * @author Maxim Vorobyev
 * @version 2.0
 */
class Data_Friends extends Data_Table{
        function __construct() 
    {
        $this->tableName = 'friends';
        $this->arFields = array(
            'TEACHERID' => array(
              'NAME'=>'TEACHERID',
              'TYPE'=>self::FIELD_TYPE_INTEGER
            ),
            'STUDENTID' => array(
              'NAME'=>'STUDENTID',
              'TYPE'=>self::FIELD_TYPE_INTEGER
            ),
			'ACCEPTED' => array(
              'NAME'=>'ACCEPTED',
              'TYPE'=>self::FIELD_TYPE_INTEGER
            )	    
        );
    }
}
