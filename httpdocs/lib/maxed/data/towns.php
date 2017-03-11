<?php
namespace Maxed\Data;

/*
 * Справочник городов
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.12.14
 */

class Towns extends Lists
{

	/**
	 * Стандартный метод для создания объекта
	 */
	function __construct()
	{
		$this->tableName = 'towns';
		$this->arFields = array(
			'ID'	 => array(
				'NAME'	 => 'ID',
				'TYPE'	 => self::FIELD_TYPE_INTEGER
			),
			'NAME'	 => array(
				'NAME'	 => 'NAME',
				'TYPE'	 => self::FIELD_TYPE_STRING
			)
		);
	}

}
