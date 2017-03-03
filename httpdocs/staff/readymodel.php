<?
include '../lib/include.php';
$uid = $_REQUEST['ID'];
$obTableAnswer = new Data_Answer();
if (isset($_REQUEST['answerid']))
{
	$aid = $_REQUEST['answerid'];
	$obTableAnsweraccess = new Data_Answeraccess();
	$obTableAnsweraccess->delete(array(
		'USERID'	 => $uid,
		'ANSWERID'	 => $aid
			)
	);
	if (!empty($_REQUEST['teachers']))
	{
		foreach ($_REQUEST['teachers'] as $teacherId)
		{
			$obTableAnsweraccess->insert(array(
				'FIELDS' => array(
					'ANSWERID'	 => $aid,
					'USERID'	 => $uid,
					'TEACHERID'	 => $teacherId
				)
			));
		}
	}
}
elseif (isset($_REQUEST['OBJECT']) && isset($_REQUEST['ELEMENTS']))
{
	//сохранение нового ответа
	$aid = $obTableAnswer->addAnswer($_REQUEST);
	$_REQUEST['CODE'] = $obTableAnswer->getCode($aid);
}
elseif (isset($_REQUEST['CODE']))
{
	$aid = $obTableAnswer->getId($_REQUEST['CODE']);
}
else
{
	ob_end_clean();
	header('Location: /models.php');
	ob_end_flush();
	exit();
}
$arData = Utils_Model::getUsersFillModel($aid, $_REQUEST['id']);
if ($arData === FALSE)
{
	ob_end_clean();
	header('Location: /models.php');
	ob_end_flush();
	exit();
}
?>
<html>
    <head>
        <title>Логические схемы</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
		<script type="text/javascript" src="/opt/jquery-2.1.4.min.js"></script>
    </head>
    <body>
        <div id="wrap">
			<?php include 'header.php'; ?>
            <section>
                <h1>Заполните модель</h1>
				<h2><?php print $arData['MODEL']['NAME'] ?></h2>
				<div class="textimg">
					<img class="miniImage" src="image.php?CODE=<?= $_REQUEST['CODE'] ?>&id=<?= $_REQUEST['id']?>">
					<div class="imgmenu"> 
						<a href="/readymodel.php?CODE=<?= $_REQUEST['CODE'] ?>&id=<?= $_REQUEST['id']?>">Ссылка на ответ</a>
						<a href="image.php?CODE=<?= $_REQUEST['CODE'] ?>&id=<?= $_REQUEST['id']?>">Ссылка на схему</a>
						<a onclick="window.print();
								return false;" href="javascript:void(0)">Печать  схемы</a>
					</div>
					<? if (count($arTeach) > 0): ?>
						<form action="/readymodel.php" method="POST">
							<input type="hidden" name="answerid" value="<?= $aid ?>">
							<input type="hidden" name="CODE" value="<?= $_REQUEST['CODE'] ?>">
						</form>
					<? endif; ?>
				</div>
				<table class='elements'><tr><th><?= $arData['MODEL']['OBJECT'] ?></th><td><?= $arData['ANSWER']['DATA']['OBJECT'] ?></td></tr></table>
				<? foreach ($arData['CATEGORIES'] as $key => $arCategory): ?>
					<h3><?= $arCategory['NAME'] ?></h3>
					<table class="elements">
						<? foreach ($arCategory['ELEMENTS'] as $arElement): ?>
							<tr><th><?= $arElement['NAME'] ?></th><td class="newelenments"><?= $arData['ANSWER']['DATA']['ELEMENTS'][$arElement['ID']] ?></td></tr>
								<? endforeach; ?>
					</table>
				<? endforeach; ?>
            </section>
			<?php include '../footer.php'; ?>
        </div>
		<script>
			$(document).ready(function () {
				$('.miniImage').click(function (e) {
					var ob = $(this);
							var box = $('<div/>' {class: 'imagebox', css: {'background-image': 'url(' + ob.attr('src') + ')'}});
				$('body').append(box);
				box.click(function () {
					box.remove();
				});
			});
			});

		</script>
    </body>
</html>
