<?php
    include 'lib/include.php';
    //print_r($_REQUEST);
    if (!isset($_REQUEST['ID']) ||  intval ($_REQUEST['ID'])<1)
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
	    'ID'=>$_REQUEST['ID']
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
	 'MODELID'=>$_REQUEST['ID']   
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
	    'MODELID'=>$_REQUEST['ID']
	)));
	while ($arRow=$rsElenent->fetch_assoc())
	{
	   $arCategories[$arRow['CATEGORYID']]['ELEMENTS'][] =$arRow;
	   
	}
	//print_r($arCategories);
	?>
<html>
    <head>
        <title>Логические схемы</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
    </head>
    <body>
        <div id="wrap">
             <?php include 'header.php';?>
            <section>
                <h1>Заполните модель</h1>
		<h2><?php print $arModel['NAME'] ?></h2>
		<form action="readymodel.php" method="POST">
		    <table class='elements'><tr><th><?= $arModel['OBJECT']?></th><td><input type='text' name='OBJECT'></td></tr></table>
		<?foreach ($arCategories as $key=>$arCategory):	?>
		<h3><?= $arCategory['NAME']?></h3>
		<table class="elements">
		    <?foreach ($arCategory['ELEMENTS'] as $arElement):	?>
		<tr><th><?= $arElement['NAME']?></th><td><input type="text" name="ELEMENTS[<?= $arElement['ID']?>]"></td></tr>
		    <?  endforeach;	?>
		</table>
		<?  endforeach;	?>
		<input type="hidden" name="MODELID" value="<?=$_REQUEST['ID']?>">
		<button type="submit">Соcтавить схему</button>
		</form>
            </section>
            <?php include 'footer.php';?>
        </div>
    </body>
</html>