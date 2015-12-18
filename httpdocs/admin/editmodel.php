<?php
include '../lib/include.php';
$arError = array();
if (isset($_REQUEST['OBJECT'])) {
    if (empty($_REQUEST['OBJECT'])) {
	$arError[] = 'Необходимо заполнить поле "Объект рассмотрения"';
    } else {
	$obTableModel = new Data_Model();
	$modelId = $obTableModel->insert(array(
	    'FIELDS' => array(
		'NAME' => $_REQUEST['OBJECT']
	    )
	));
	if ($modelId != FALSE) {
	    
	}
    }
}
//Utils_Util::printDebug($_REQUEST);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Cоздание логическо-смысловых моделей по химии</title>
        <meta charset="UTF-8">
	<meta name="keywords" content="Логико-смысловая модель,химия" />
	<meta name="description" content="Cоздание логическо-смысловых моделей по химии" />
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
	<link rel="stylesheet" type="text/css" href="/opt/fancybox/jquery.fancybox-1.3.4.css">
	<script type="text/javascript" src="/opt/jquery-1.4.3.min.js"></script>
	<script type="text/javascript" src="/opt/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    </head>
    <body>
        <div id="wrap">
<?php include '../header.php'; ?>
	    <section>
		<h1>Добавление модели</h1>
	    <? if (!empty($arError)): ?>
    		<div class="error">
    <? print implode('<br>', $arError); ?>
    		</div>
		<? endif; ?>
		<form action="editmodel.php" method="POST">
		    <table class='elements'><tr><th>Объект рассмотрения</th>
			    <td><input type='text' name='OBJECT'></td></tr></table>
		<? for ($i = 1; $i < 9;  ++$i): ?>
    		    <table class="elements">
    			<tr><th>Название оси <?= $i ?></th><td><input type="text" name="CATEGORY[<?= $i ?>]"></td></tr>
			<? for ($u = 1; $u < 9;  ++$u): ?>
				<tr><th>Название характеристики <?= $u ?></th><td><input type="text" name="ELEMENT[<?= $i ?>][<?= $u ?>]"></td></tr>
    <? endfor; ?>
    		    </table>
			<? endfor; ?>
		    <button type="submit">Сохранить модель</button>
		</form>
	    </section>
		    <?php include '../footer.php'; ?>
        </div>
    </body>
</html>