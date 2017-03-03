<?php

/**
 * Категории модели
 *
 * @author Maxim Vorobyev
 * @version 3.0
 * @changed 2016.11.14
 */
class Data_Category extends Data_Table
{

	/**
	 * Стандартный метод для создания объекта
	 */
	function __construct()
	{
		$this->tableName = 'category';
		$this->arFields = array(
			'ID'		 => array(
				'NAME'	 => 'ID',
				'TYPE'	 => self::FIELD_TYPE_INTEGER
			),
			'NAME'		 => array(
				'NAME'	 => 'NAME',
				'TYPE'	 => self::FIELD_TYPE_STRING
			),
			'MODELID'	 => array(
				'NAME'	 => 'MODELID',
				'TYPE'	 => self::FIELD_TYPE_INTEGER
			),
			'SORT'	 => array(
				'NAME'	 => 'SORT',
				'TYPE'	 => self::FIELD_TYPE_INTEGER
			)
		);
	}

}
