<?php
namespace Maxed\Data;

/**
 * Заполненная модель
 *
 * @author Maxim Vorobyev
 * @version 3.0
 * @changed 2017.01.24
 */
class Answer extends Table
{

	/**
	 * Стандартный метод для создания объекта
	 */
	function __construct()
	{
		/**
		 * Имя таблицы
		 */
		$this->tableName = 'answer';
		/**
		 * Структура таблицы
		 */
		$this->arFields = array(
			'ID'		 => array(
				'TYPE' => self::FIELD_TYPE_INTEGER
			),
			'ANSWER'	 => array(
				'TYPE' => self::FIELD_TYPE_STRING
			),
			'USERID'	 => array(
				'TYPE' => self::FIELD_TYPE_INTEGER
			),
			'MODELID'	 => array(
				'TYPE' => self::FIELD_TYPE_INTEGER
			),
			'ADATE'		 => array(
				'TYPE' => self::FIELD_TYPE_DATE
			),
			'CODE'		 => array(
				'TYPE' => self::FIELD_TYPE_GENERATE
			)
		);
	}
	/**
	 * Добавление нового ответа в таблицу
	 * @param array $arAnswer заполненный массив ответа
	 * @return boolean результат вставления ответа
	 */
	public function addAnswer($arAnswer)
	{
		if (!isset($arAnswer['MODELID']) || intval($arAnswer['MODELID']) == 0)
		{
			return false;
		}
		$arOptions = array('FIELDS'=>array());
		$arOptions['FIELDS']['USERID'] = Utils_Currentuser::getInstance()->getId();
		$arOptions['FIELDS']['ADATE'] = date('Y-m-d H:i:s');
		$arOptions['FIELDS']['ANSWER'] = serialize($arAnswer);
		$arOptions['FIELDS']['MODELID'] = $arAnswer['MODELID'];
		$arOptions['FIELDS']['CODE'] = '';
		return self::insert($arOptions);
	}

	/**
	 * Метод получения кода по айди
	 * @param integer $id айди ответа
	 * @return boolean| integer
	 */
	public function getCode($id)
	{
		$obCodes = $this->select(array(
			'FIELDS' => array('CODE'),
			"FILTER" => array(
				'ID' => $id
		)));
		$arCode = $obCodes->fetch_assoc();
		if ($arCode)
		{
			return $arCode['CODE'];
		}
		return FALSE;
	}

	/**
	 * Метод получения айди по коду
	 * @param integer $code код ответа
	 * @return boolean| string
	 */
	public function getId($code)
	{
		$obId = $this->select(array(
			'FIELDS' => array('ID'),
			"FILTER" => array(
				'CODE' => $code
		)));
		if ($obId === FALSE)
		{
			return FALSE;
		}
		$arId = $obId->fetch_assoc();
		if ($arId)
		{
			return $arId['ID'];
		}
		return FALSE;
	}

}
