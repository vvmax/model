<?php
/**
 * Таблица с сообщениями обратной связи
 *
 * @author Maxim Vorobyev
 * @version 3.0
 * @changed 2017.01.14
 */
class Data_Feedback extends Data_Table
{

	/**
	 * Стандартный метод для создания объекта
	 */
	function __construct()
	{
		$this->tableName = 'feedback';
		$this->arFields = array(
			'ID'			 => array(
				'TYPE' => self::FIELD_TYPE_INTEGER
			),
			'THEME'			 => array(
				'TYPE' => self::FIELD_TYPE_STRING
			),
			'AUTHORID'		 => array(
				'TYPE' => self::FIELD_TYPE_INTEGER
			),
			'ADATE'			 => array(
				'TYPE' => self::FIELD_TYPE_DATE
			),
			'DESCRIPTION'	 => array(
				'TYPE' => self::FIELD_TYPE_STRING
			)
		);
	}
	/**
	 * Функция сохраниения письма и его отправки на почту
	 * @param array $arMess
	 *  - DESCRIPTION обязательный
	 *  - THEME 
	 * @return boolean
	 */
	public function addMessage($arMess)
	{
		if (empty($arMess['DESCRIPTION']) || !Utils_Currentuser::getInstance()->isLogged())
		{
			return false;
		}
		$arOptions= ['FIELDS'=>[]];
		$arOptions['FIELDS']['AUTHORID'] = Utils_Currentuser::getInstance()->getId();
		$arOptions['FIELDS']['ADATE'] = date('Y-m-d H:i:s');
		$arOptions['FIELDS']['THEME'] = $arMess['THEME'];
		$arOptions['FIELDS']['DESCRIPTION'] = $arMess['DESCRIPTION'];
		mail(Settings::MAIL , $arMess['THEME'], $arMess['DESCRIPTION']);
		return self::insert($arOptions);
	}

}
