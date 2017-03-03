<?php

/*
 * Таблица пользователей
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.12.14
 */

class Data_Users extends Data_Table
{

	/**
	 * Стандартный метод для создания объекта
	 */
	function __construct()
	{
		$this->tableName = 'users';
		$this->arFields = array(
			'ID'		 => array(
				'NAME'	 => 'ID',
				'TYPE'	 => self::FIELD_TYPE_INTEGER
			),
			'SCHOOLID'	 => array(
				'NAME'	 => 'SCHOOLID',
				'TYPE'	 => self::FIELD_TYPE_INTEGER
			),
			'TOWNID'	 => array(
				'NAME'	 => 'TOWNID',
				'TYPE'	 => self::FIELD_TYPE_INTEGER
			),
			'USERTYPEID' => array(
				'NAME'	 => 'USERTYPEID',
				'TYPE'	 => self::FIELD_TYPE_INTEGER
			),
			'ACTIVE'	 => array(
				'NAME'	 => 'ACTIVE',
				'TYPE'	 => self::FIELD_TYPE_INTEGER
			),
			'FIRSTNAME'	 => array(
				'NAME'	 => 'FIRSTNAME',
				'TYPE'	 => self::FIELD_TYPE_STRING
			),
			'SECONDNAME' => array(
				'NAME'	 => 'SECONDNAME',
				'TYPE'	 => self::FIELD_TYPE_STRING
			),
			'LASTNAME'	 => array(
				'NAME'	 => 'LASTNAME',
				'TYPE'	 => self::FIELD_TYPE_STRING
			),
			'LOGIN'		 => array(
				'NAME'	 => 'LOGIN',
				'TYPE'	 => self::FIELD_TYPE_STRING
			),
			'PASSWORD'	 => array(
				'NAME'	 => 'PASSWORD',
				'TYPE'	 => self::FIELD_TYPE_STRING
			),
			'FORM'		 => array(
				'NANE'	 => 'FORM',
				'TYPE'	 => self::FIELD_TYPE_CLASS
			),
			'CANMAKE'	 => array(
				'NANE'	 => 'CANMAKE',
				'TYPE'	 => self::FIELD_TYPE_BOOLEAN
			)
		);
	}

}
