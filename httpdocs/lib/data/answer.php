<?php
/**
 * Заполненная модель
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.10.14
 */
class Data_Answer extends Data_Table {
   function __construct() {
        $this->tableName = 'answer';
        $this->arFields = array(
	    'ID' => array(
		//'NAME' => ''
		'TYPE'=>  self::FIELD_TYPE_INTEGER
	    ),
	    'ANSWER' => array(
		//'NAME'
		'TYPE'=> self::FIELD_TYPE_STRING
	    ),
	    'USERID' => array(
		//'NAME'
		'TYPE'=> self::FIELD_TYPE_INTEGER
	    ),
	    'MODELID' => array(
		//'NAME'
		'TYPE'=> self::FIELD_TYPE_INTEGER
	    ),
	    'ADATE' => array(
		//'NAME'
		'TYPE'=> self::FIELD_TYPE_DATE
	    ),
	    'CODE' => array(
		//'NAME'
		'TYPE'=> self::FIELD_TYPE_GENERATE
	    )
	);
   }
   public function addAnswer($arAnswer)
   {
       if (!isset($arAnswer['MODELID']) || intval($arAnswer['MODELID'])==0)
       {
	   return false;
       }
	   $arOptions['FIELDS']['USERID']= Utils_Currentuser::getInstance()->getId();;
       $arOptions['FIELDS']['ADATE']= date('Y-m-d H:i:s');
       $arOptions['FIELDS']['ANSWER']=  serialize($arAnswer);
       $arOptions['FIELDS']['MODELID']= $arAnswer['MODELID'];
       $arOptions['FIELDS']['CODE']='';
	return self::insert($arOptions);
   }
   /**
    * Метод получения кода по айди
    * @param integer $id айди ответа
    * @return booleaт| integer
    */
    public function getCode($id)
    {
	$obCodes=$this->select(array(
	    'FIELDS'=> array('CODE'),
	    "FILTER"=>  array(
		'ID'=>$id
	    )));
	$arCode=$obCodes->fetch_assoc();
	if($arCode)
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
	$obId=$this->select(array(
	    'FIELDS'=> array('ID'),
	    "FILTER"=>  array(
		'CODE'=>$code
	    )));
	if ($obId===FALSE){return FALSE;}
	$arId=$obId->fetch_assoc();
	if($arId)
	{
	    return $arId['ID'];
	}
	return FALSE;
    }
}
