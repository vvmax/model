<?php

/*
 * Справочник типов пользователей
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.12.14
 */

class Data_Usertype extends Data_Table
{

	/**
	 * Тип АДМИНИСТРАТОР
	 */
	const USER_TYPE_ADMIN = 1;

	/**
	 * Тип УЧИТЕЛЬ
	 */
	const USER_TYPE_TEACHER = 10;

	/**
	 * Тип УЧЕНИК
	 */
	const USER_TYPE_STUDENT = 20;

	/**
	 * Стандартный метод для создания объекта
	 */
	function __construct()
	{
		$this->tableName = 'usertype';
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
