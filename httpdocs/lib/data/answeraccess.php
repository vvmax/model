<?php

/**
 * Заполненная модель
 *
 * @author Maxim Vorobyev
 * @version 1.0
 */
class Data_Answeraccess extends Data_Table
{

	function __construct()
	{
		$this->tableName = 'answeraccess';
		$this->arFields = array(
		'TEACHERID' => array(
		//'NAME'
		'TYPE' => self::FIELD_TYPE_INTEGER
		),
		'ANSWERID' => array(
		//'NAME'
		'TYPE' => self::FIELD_TYPE_INTEGER
		),
		'USERID' => array(
		//'NAME'
		'TYPE' => self::FIELD_TYPE_INTEGER
				)
		);
	}

}
