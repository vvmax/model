<?php

/*
 * Общий класс для справочных таблиц
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.10.14
 */
class Data_Lists extends Data_Table{
   public function getIdAdd($name,$extend=FALSE)
   {
       $arFilter=array(
	       'NAME'=>$name
	   );
       if(is_array($extend))
       {
	   $arFilter=  array_merge($arFilter,$extend);
       }
       $rsList=$this->select(array(
	   'FIELDS'=>array(
	       'ID'
	   ),
	   "FILTER"=>$arFilter
	       ));
       if($rsList==FALSE || $rsList->num_rows==0)
       {
	   $id=$this->insert(array('FIELDS'=>$arFilter
		   ));
       }
	else 
	{
	    $arId=$rsList->fetch_assoc();
	    $id=$arId['ID'];
	}
       return $id;
   }
}
