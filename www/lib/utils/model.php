<?php
/**
 * Обработка модели
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.10.14
 */
class Utils_Model
{
    static function getFillModel($answerId)
    {
	$obTableAnswer = new Data_Answer();
	$rsAnswer = $obTableAnswer->select(
		array(
		    'FIELDS'=>array('MODELID','ANSWER'),
		    'FILTER'=>array('ID'=>$answerId)
		    ));
	$arAnswer = $rsAnswer->fetch_assoc();
	if ($arAnswer==false)
	{
	    ob_end_clean();
	    header('Location: /models.php');
	    ob_end_flush();
	    exit();
	}
	$arAnswer['DATA']=  unserialize($arAnswer['ANSWER']);
	if (!isset($arAnswer['MODELID']) ||  intval ($arAnswer['MODELID'])<1)
	{
	    ob_end_clean();
	    header('Location: /models.php');
	    ob_end_flush();
	    exit();
	}
	$obTableModel= new Data_Model();
	$rsModels = $obTableModel->select(array(
	    'FIELDS'=> array('NAME','OBJECT'),
	    "FILTER"=>  array(
		'ID'=>$arAnswer['MODELID']
	    )));
	$arModel=$rsModels->fetch_assoc();
	if (!$arModel)
	{
	    ob_end_clean();
	    header('Location: /models.php');
	    ob_end_flush();
	    exit();    
	}
	$obTableCategory = new Data_Category();
	$rsCategory = $obTableCategory->select(array(
	    'FIELDS' => array('NAME','ID'),
	    'FILTER'=>  array(
	    'MODELID'=>$arAnswer['MODELID']   
	    )));
	$arCategories= array();
	while ($arRow=$rsCategory->fetch_assoc())
	{
	    $arRow['ELEMENTS']= array();
	    $arCategories[$arRow['ID']]=$arRow;
	}
	$obTableElement =new Data_Element();
	$rsElenent = $obTableElement->select(array(
	    'FILTER' => array(
	    'MODELID'=>$arAnswer['MODELID']
	    )));
	while ($arRow=$rsElenent->fetch_assoc())
	{
	   $arCategories[$arRow['CATEGORYID']]['ELEMENTS'][] =$arRow;
	   
	}
	return array(
	    "ANSWER"=>$arAnswer,
	    "MODEL"=>$arModel,
	    "CATEGORIES"=>$arCategories
	);
    }
}