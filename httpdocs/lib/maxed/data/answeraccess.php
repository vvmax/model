<?php
namespace Maxed\Data;

/**
 * Таблица прав доступа к ответам
 * @author Maxim Vorobyev
 * @version 3.0
 */
class Answeraccess extends Table
{

	/**
	 * Стандартный метод для создания объекта
	 */
	function __construct()
	{
		$this->tableName = 'answeraccess';
		$this->arFields = array(
			'TEACHERID'	 => array(
				'TYPE' => self::FIELD_TYPE_INTEGER
			),
			'ANSWERID'	 => array(
				'TYPE' => self::FIELD_TYPE_INTEGER
			),
			'USERID'	 => array(
				'TYPE' => self::FIELD_TYPE_INTEGER
			)
		);
	}

}
