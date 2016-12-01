<?php

/**
 * Работа с таблицей моделей
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.10.14
 */
class Data_Model extends Data_Table
{

	function __construct()
	{
		$this->tableName = 'model';
		$this->arFields = array(
			'ID'			 => array(
				'NAME'	 => 'ID',
				'TYPE'	 => self::FIELD_TYPE_INTEGER
			),
			'NAME'			 => array(
				'NAME'	 => 'NAME',
				'TYPE'	 => self::FIELD_TYPE_STRING
			),
			'DESCRIPTION'	 => array(
				'NAME'	 => 'DESCRIPTION',
				'TYPE'	 => self::FIELD_TYPE_STRING
			),
			'AUTHORID'	 => array(
				'NAME'	 => 'AUTHORID',
				'TYPE'	 => self::FIELD_TYPE_INTEGER
			),
			'OBJECT'		 => array(
				'NANE'	 => 'OBJECT',
				'TYPE'	 => self::FIELD_TYPE_STRING
			)
		);
	}

}
