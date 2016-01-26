<?php

/*
 * Общий класс для всех таблиц
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.10.14
 */

class Data_Table
{

	const FIELD_TYPE_INTEGER = 0;
	const FIELD_TYPE_STRING = 1;
	const FIELD_TYPE_DATE = 2;
	CONST FIELD_TYPE_GENERATE = 3;
	CONST FIELD_TYPE_CLASS = 4;

	/**
	 * Имя таблицы
	 * @var string 
	 */
	protected $tableName;

	/**
	 * Массив существующих полей
	 * @var array 
	 */
	protected $arFields;

	/**
	 * описание последней ошибки
	 * @var string 
	 */
	protected $arLastError;

	/**
	 * форматирование класса
	 * @param string $str
	 * @return string
	 */
	function parseClass($str)
	{
		setlocale(LC_CTYPE, array('ru_RU.utf8'));
		setlocale(LC_ALL, array('ru_RU.utf8'));
		$str = mb_strtoupper($str, 'UTF-8');
		$ar = array();
		preg_match("/[^\d]*(\d+)[^А-Я]*([\А-Я])?/u", $str, $ar);
		$result = '';
		$size = count($ar);
		if ($size > 1)
		{
			$result = $ar[1];
			if ($size > 2)
			{
				$result.=(' ' . $ar[2]);
			}
		}
		return $result;
	}

	/**
	 * Метод запроса данных из таблицы
	 * @param array $arOption
	 * @return mixed (mysql_result | boolen)
	 */
	public function select($arOption = array())
	{
		$db = new mysqli(Settings::host, Settings::user, Settings::password, Settings::basename);
		$db->query('SET NAMES UTF8');
		$arFields = array();
		if (isset($arOption['FIELDS']) && !empty($arOption['FIELDS']))
		{
			foreach ($arOption['FIELDS'] as $strField)
			{
				$strField = strtoupper($strField);
				if (!isset($this->arFields[$strField]))
					continue;
				$arFields[] = $this->tableName . '.' . $strField;
			}
		}
		$arJoin = array();
		if (isset($arOption['JOIN']) && !empty($arOption['JOIN']))
		{
			/**
			 * @todo добавить проверку наличия полй и таблиц
			 */
			foreach ($arOption['JOIN'] as $arValue)
			{
				$join = $arValue['TYPE'] . ' join ' . $arValue['TABLE'] . ' on ';
				$arOn = array();
				foreach ($arValue['ON'] as $childF => $parentF)
				{
					$arOn[] = $arValue['PARENT'] . '.' . $parentF . '=' .
							$arValue['TABLE'] . '.' . $childF;
				}
				$join.=implode(' and ', $arOn);
				$arJoin[] = $join;
				foreach ($arValue['FIELDS'] as $fieldName)
				{
					$arFields[] = $arValue['TABLE'] . '.' . $fieldName . ' ' .
							strtoupper($arValue['TABLE']) . '_' . $fieldName;
				}
			}
		}
		$arWhere = (isset($arOption['FILTER']) ?
						$this->getWhereArray($arOption['FILTER']) : array());
		if ($arWhere === false)
		{
			return false;
		}
		$strFileds = (count($arFields) == 0) ? '*' : implode(',', $arFields);
		$query = "select $strFileds FROM " . $this->tableName;
		$query.=' ' . implode(' ', $arJoin);
		if (count($arWhere) > 0)
		{
			$query.= " where " . implode(' and ', $arWhere);
		}
		$result = $db->query($query);
		$this->arLastError[] = $db->error;
		return $result;
	}

	public function insert($arOption)
	{
		if (!isset($arOption['FIELDS']) || empty($arOption['FIELDS']))
		{
			$this->arLastError[] = 'не переданы поля';
			return false;
		}
		$arFields = $this->getFieldsArray($arOption['FIELDS']);
		if ($arFields === false)
		{
			return false;
		}
		$query = "insert into " . $this->tableName;
		$query.="(" . implode(',', array_keys($arFields)) . ") VALUES ";
		$query.="(" . implode(",", $arFields) . ")";
		$db = new mysqli(Settings::host, Settings::user, Settings::password, Settings::basename);
		$db->query('SET NAMES UTF8');
		$resuls = $db->query($query);
		if ($result === false)
		{
			$this->arLastError[] = $db->error;
			return false;
		}
		return $db->insert_id;
	}

	/**
	 * Получение елементов справвочника
	 * @return array
	 */
	public function getOptions($arFilter = array())
	{
		$arOptions = array(
			'FIELDS' => array(
				'ID', 'NAME'
			)
		);
		if (!empty($arFilter))
		{
			$arOptions['FILTER'] = $arFilter;
		}
		$rsList = $this->select($arOptions);
		if ($rsList === false)
		{
			return false;
		};
		$arResult = array();
		while ($arRow = $rsList->fetch_assoc())
		{
			$arResult[] = $arRow;
		}
		return $arResult;
	}

	public function getLastError()
	{
		return $this->arLastError;
	}

	public function update($arOption)
	{
		if (!isset($arOption['FIELDS']) || empty($arOption['FIELDS']))
		{
			$this->arLastError[] = 'не переданы поля';
			return false;
		}
		$arFields = $this->getFieldsArray($arOption['FIELDS']);
		if ($arFields === false)
		{
			return false;
		}
		$arFieldsVal=array();
		foreach($arFields as $key=>$value)
		{
			$arFieldsVal[]=$key.' = '.$value;
		}
		$arWhere = (isset($arOption['FILTER']) ?
						$this->getWhereArray($arOption['FILTER']) : array());
		if ($arWhere === false)
		{
			return false;
		}
		$query = "update " . $this->tableName . ' set ';
		$query.=implode(',', $arFieldsVal);
		$db = new mysqli(Settings::host, Settings::user, Settings::password, Settings::basename);
		$db->query('SET NAMES UTF8');
		if (count($arWhere) > 0)
		{
			$query.= " where " . implode(' and ', $arWhere);
		}
		$result = $db->query($query);
		$this->arLastError[] = $db->error;
		return $result;
	}

	protected function getWhereArray($arFilter)
	{
		$arWhere = array();
		if (!empty($arFilter))
		{
			foreach ($arFilter as $fieldName => $fieldValue)
			{
				$fieldName = strtoupper($fieldName);
				/**
				 * Проверка существования запрашиваемого поля в списке доступных полей
				 */
				if (!isset($this->arFields[$fieldName]) || (string) $fieldValue == '')
				{
					$this->arLastError[] = 'Поле ' . $fieldName . ' не существует';
					return false;
				}
				switch ($this->arFields[$fieldName]["TYPE"])
				{
					case self::FIELD_TYPE_INTEGER:
						$fieldValue = intval($fieldValue);
						$arWhere[] = $this->tableName . '.' . "$fieldName=$fieldValue";
						break;
					case self::FIELD_TYPE_GENERATE:
					case self::FIELD_TYPE_STRING:
						$fieldValue = addslashes($fieldValue);
						$arWhere[] = $this->tableName . '.' . "$fieldName='$fieldValue'";
						break;
					case self::FIELD_TYPE_CLASS:
						$fieldValue = $this->parseClass($fieldValue);
						$arWhere[] = $this->tableName . '.' . "$fieldName='$fieldValue'";
						break;
					default :
						$this->arLastError[] = 'Неизвестный тип поля ' . $fieldName;
						return false;
						break;
				}
			}
		}
		return $arWhere;
	}

	protected function getFieldsArray($arFields)
	{
		$arRes = array();
		foreach ($arFields as $key => $arValue)
		{
			$key = strtoupper($key);
			//проверка существования полей
			if (!isset($this->arFields [$key]))
			{
				continue;
			}
			switch ($this->arFields[$key]['TYPE'])
			{
				case self::FIELD_TYPE_STRING:
					$arValue = "'" . addslashes($arValue) . "'";
					break;
				case self::FIELD_TYPE_INTEGER:
					$arValue = intval($arValue);
					break;
				case self::FIELD_TYPE_DATE:
					$arValue = "'" . $arValue . "'";
					break;
				case self::FIELD_TYPE_CLASS:
					$arValue = "'" . $this->parseClass($arValue) . "'";
					break;
				case self::FIELD_TYPE_GENERATE:
					$strIndex = date("YmdHis") . mt_rand(0, 1000000000);
					$arValue = "'" . md5($strIndex) . "'";
					break;
				default:
					continue;
					break;
			}
			$arRes[$key] = $arValue;
		}
		if (empty($arRes))
		{
			$this->arLastError[] = 'неверно заданы поля';
			return false;
		}
		return $arRes;
	}

	public function delete($arFilter)
	{
		$arWhere = $this->getWhereArray($arFilter);
		If ($arWhere === false)
		{
			return false;
		}
		$query = "delete from " . $this->tableName;
		$db = new mysqli(Settings::host, Settings::user, Settings::password, Settings::basename);
		$db->query('SET NAMES UTF8');
		if (count($arWhere) > 0)
		{
			$query.= " where " . implode(' and ', $arWhere);
		}
		$result = $db->query($query);
		$this->arLastError[] = $db->error;
		return $result;
	}

}
