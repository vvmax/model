<?php
include 'lib/include.php';
If (!empty($_REQUEST['NAME']))
{
	if (isset($_REQUEST['ID']) && intval($_REQUEST['ID']) > 0)
	{
		$check = Utils_Model::update($_REQUEST);
	}
	else
	{
		$check = Utils_Model::save($_REQUEST);
	}
	if ($check != false)
	{
		$_REQUEST['ID'] = $check;
		header('Location: edittest.php?ID=' . $_REQUEST['ID']);
		exit();
	}
}
elseif (isset($_REQUEST['action']))
{
	if ($_REQUEST['action'] === 'delcat')
	{
		Utils_Model::deleteCategory($_REQUEST);
		header('Location: edittest.php?ID=' . $_REQUEST['ID']);
		exit();
	}
	elseif ($_REQUEST['action'] === 'delelem')
	{
		Utils_Model::deleteElement($_REQUEST);
		header('Location: edittest.php?ID=' . $_REQUEST['ID']);
		exit();
	}
}
if (isset($_REQUEST['ID']) && intval($_REQUEST['ID']) > 0)
{
	$obTableModel = new Data_Model();
	$rsModels = $obTableModel->select(array(
		'FIELDS' => array('NAME', 'OBJECT', 'DESCRIPTION'),
		"FILTER" => array(
			'ID'		 => $_REQUEST['ID'],
			'AUTHORID'	 => Utils_Currentuser::getInstance()->getId()
	)));
	$arModel = $rsModels->fetch_assoc();
	if (!$arModel)
	{
		ob_end_clean();
		header('Location: /models.php');
		ob_end_flush();
		exit();
	}
	$obTableCategory = new Data_Category();
	$rsCategory = $obTableCategory->select(array(
		'FIELDS' => array('NAME', 'ID', 'SORT'),
		'FILTER' => array(
			'MODELID' => $_REQUEST['ID']
		),
		'ORDER'	 => array(
			'SORT'	 => 'ASC',
			'ID'	 => 'ASC'
	)));
	$arCategories = array();
	while ($arRow = $rsCategory->fetch_assoc())
	{
		$arRow['ELEMENTS'] = array();
		$arCategories[$arRow['ID']] = $arRow;
	}
	$obTableElement = new Data_Element();
	$rsElenent = $obTableElement->select(array(
		'FILTER' => array(
			'MODELID' => $_REQUEST['ID']
	)));
	while ($arRow = $rsElenent->fetch_assoc())
	{
		$arCategories[$arRow['CATEGORYID']]['ELEMENTS'][] = $arRow;
	}
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Логические схемы</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
		<script type="text/javascript" src="/opt/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="/js/edittest.js"></script>
    </head>
	<body>
        <div id="wrap">
			<?php include 'header.php'; ?>
			<? if ($check != false): ?>
				<p><b>Схема сохранена</b></p>
			<? endif; ?>
			<form action="/edittest.php" method="POST">
				<? if (isset($_REQUEST['ID'])): ?>
					<input type="hidden" name="ID" value="<?= $_REQUEST['ID'] ?>">
				<? endif; ?>
				<table class="elements" id="edittesttable" >
					<tr>
						<td colspan="4">
							<input type="text"  value="<? if (isset($arModel)) print($arModel['NAME']) ?>" placeholder="Название схемы" name="NAME">
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<input type="text" value="<? if (isset($arModel)) print($arModel['OBJECT']) ?>" placeholder="Обьект описания" name="OBJECT">
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<textarea name="DESCRIPTION" placeholder="Описание схемы" ><? if (isset($arModel)) print($arModel['DESCRIPTION']) ?></textarea>
						</td>
					</tr>
					<tr>
						<th class="tonkyi">
							Сорт.
						</th>
						<td colspan="3"></td>
					</tr>
					<? if (isset($arCategories)): ?>
						<? foreach ($arCategories as $arCategory): ?>
							<? if (!empty($arCategory)): ?>
								<tr class="jscategory" data-index="<?= $arCategory['ID'] ?>">
									<td>
										<input class="centered" type="text" value="<?= $arCategory['SORT'] ?>" name="CATEGORY[<?= $arCategory['ID'] ?>][SORT]" size="1">
									</td>
									<td>
										<input name="CATEGORY[<?= $arCategory['ID'] ?>][NAME]" type="text" value="<?= $arCategory['NAME'] ?>" placeholder="Ветвь схемы">
									</td>
									<td>
										<button type="button" class="jsaddelement">+ Элемент</button>
									</td>
									<td>
										<a  class="delete" href="/edittest.php?action=delcat&catid=<?= $arCategory['ID'] ?>&ID=<?= $_REQUEST['ID'] ?>" >&times;</a>
									</td>
								</tr>
								<? foreach ($arCategory['ELEMENTS'] as $arElement): ?>
									<tr class="jselement">
										<td colspan="3">
											<input name="CATEGORY[<?= $arCategory['ID'] ?>][ELEMENT][<?= $arElement['ID'] ?>]" type="text" placeholder="Название элемента" value="<?= $arElement['NAME'] ?>">
										</td>
										<td>
											<a  class="delete" href="/edittest.php?action=delelem&elid=<?= $arElement['ID'] ?>catid=<?= $arCategory['ID'] ?>&ID=<?= $_REQUEST['ID'] ?>" >&times;</a>
										</td>
									</tr>
								<? endforeach; ?>
							<? endif; ?>
						<? endforeach; ?>
					<? endif; ?>

					<tr>
						<td colspan="4">
							<button type="button" id="addcategory" >+ Ветвь</button>
						</td>
					</tr>
				</table>
				<button type="submit" >Сохранить</button>
			</form>
			<?php include 'footer.php'; ?>
        </div>
    </body>