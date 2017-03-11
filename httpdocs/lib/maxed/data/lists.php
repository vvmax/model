<?php
namespace Maxed\Data;

/*
 * Общий класс для справочных таблиц
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.10.14
 */

class Lists extends Table
{
	/**
	 * Получение айди элемента справочника по значению ,
	 *  в случае отсутствия добавление
	 * @param string $name значение
	 * @param array $extend дополнительный фильтр
	 * @return integer id строчки справочника
	 */
	public function getIdAdd($name, $extend = FALSE)
	{
		/**
		 * Построение фильтра
		 */
		$arFilter = array(
			'NAME' => $name
		);
		if (is_array($extend))
		{
			/**
			 * Добавление условий в фильтр
			 */
			$arFilter = array_merge($arFilter, $extend);
		}

		$rsList = $this->select(array(
			'FIELDS' => array('ID'),
			"FILTER" => $arFilter
		));
		/**
		 * Длбавляем строку если такой нет
		 */
		if ($rsList == FALSE || $rsList->num_rows == 0)
		{
			$id = $this->insert(array('FIELDS' => $arFilter));
		}
		else
		{
			$arId = $rsList->fetch_assoc();
			$id = $arId['ID'];
		}
		return $id;
	}

}
