<?php

/*
 * Общий класс для всех таблиц
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.10.14
 */
class Data_Table {
    const FIELD_TYPE_INTEGER = 0;
    const FIELD_TYPE_STRING = 1;
    const FIELD_TYPE_DATE = 2;
    CONST FIELD_TYPE_GENERATE = 3;
    /**
     * Имя таблицы
     * @var string 
     */
    protected $tableName;
    /**
     * Массив полей
     * @var array 
     */
    protected $arFields;
    /**
     * Метод запроса данных из таблицы
     * @param array $arOption
     * @return mixed (mysql_result | boolen)
     */
    public function select($arOption = array())
    {
        $db = new mysqli(Settings::host,  Settings::user, Settings::password,  Settings::basename);
        $db->query('SET NAMES UTF8');
        $arFields=array();
        if(isset($arOption['FIELDS']) && !empty($arOption['FIELDS']))
        {
            foreach($arOption['FIELDS'] as $strField)
            {
                $strField = strtoupper($strField);
                if (!isset($this->arFields[$strField])) continue;
                $arFields[]=$strField;
            }
        }
	$arWhere = array();
	if(isset($arOption['FILTER']) && !empty($arOption['FILTER']))
	{
	    foreach($arOption['FILTER'] as $fieldName => $fieldValue)
	    {
		$fieldName = strtoupper($fieldName);
		if (!isset($this->arFields[$fieldName]) || (string)$fieldValue=='') 
		{
		    return FALSE;
		    
		}
		if ($this->arFields[$fieldName]["TYPE"] == self::FIELD_TYPE_INTEGER)
		{
		    $fieldValue = intval($fieldValue);
		    $arWhere[]="$fieldName=$fieldValue";
		}
		elseif ($this->arFields[$fieldName]["TYPE"] == self::FIELD_TYPE_GENERATE)
		{
		    $fieldValue = addslashes($fieldValue);
		    $arWhere[]="$fieldName='$fieldValue'";
		}
		else
		{
		    return FALSE; 
		}
	    }
	}
        $strFileds = (count($arFields)==0) ? '*' : implode(',',$arFields);
        $query="select $strFileds FROM ".$this->tableName;
	if(count($arWhere)>0)
	{
	    $query.= " where ". implode(' and ',$arWhere);
	}
        return $db->query($query);
    }
    public function insert($arOption)
    {
        if(!isset($arOption['FIELDS']) || empty($arOption['FIELDS']))
	{
	    return FALSE;
	}
	$arFields = array();
	foreach ($arOption['FIELDS'] as $key=> $arValue)
	{
	    $key = strtoupper($key);
	    if (!isset($this->arFields [$key] ) )
	    {
		continue;
	    }
	    switch ($this->arFields[$key]['TYPE'])
	    {
		case self::FIELD_TYPE_STRING:
		    $arValue="'".  addslashes($arValue)."'";
		    break;
		case self::FIELD_TYPE_INTEGER:
		    $arValue = intval($arValue);
		    break;
		case self::FIELD_TYPE_DATE:
		    $arValue ="'".$arValue."'";
		    break;
		case self::FIELD_TYPE_GENERATE:
		    $strIndex= date("YmdHis").mt_rand(0, 1000000000);
		    $arValue="'".md5($strIndex)."'";
		    break;
		default:
		    continue;
		    break;
	    }
	    $arFields[$key] = $arValue;
	}
	if (empty($arFields))
	{
	    return false;
	}
	$query = "insert into " .$this-> tableName;
	$query.="(".implode(',', array_keys($arFields)).") VALUES ";
	$query.="(".implode(",",$arFields).")";
        $db = new mysqli(Settings::host,  Settings::user, Settings::password,  Settings::basename);
      $db->query('SET NAMES UTF8');
	$resuls =$db->query($query);
	if($result===FALSE)
	{
	    return FALSE;
	}
	return $db->insert_id;
    }
    public function getOptions()
    {
	$rsList=$this->select(array(
	    'FIELDS'=>array(
		'ID','NAME'
	    )
	));
	$arResult= array();
	while ($arRow=$rsList->fetch_assoc())
	{
	   $arResult[]= $arRow;
	}
	return $arResult;
    }
}
