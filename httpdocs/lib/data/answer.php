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
	    'USERHASH' => array(
		//'NAME'
		'TYPE'=> self::FIELD_TYPE_STRING
	    ),
	    'MODELID' => array(
		//'NAME'
		'TYPE'=> self::FIELD_TYPE_INTEGER
	    ),
	    'ADATE' => array(
		//'NAME'
		'TYPE'=> self::FIELD_TYPE_DATE
	    )
	);
   }
   public function addAnswer($arAnswer)
   {
       if (!isset($arAnswer['MODELID']) || intval($arAnswer['MODELID'])==0)
       {
	   return false;
       }
       $arOptions['FIELDS']['ADATE']= date('Y-m-d');
       $arOptions['FIELDS']['ANSWER']=  serialize($arAnswer);
       $arOptions['FIELDS']['MODELID']= $arAnswer['MODELID'];
      // $arOptions['FIELDS']['USERHASH']= md5($_SERVER['REMOTE_ADDR'].date('YmdHis'));
	return self::insert($arOptions);
    }
}
