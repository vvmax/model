<?php
include '../lib/include.php';
$obTableUsers = new Data_Users();
if (isset($_REQUEST['ID']) && isset($_REQUEST['action']) && intval($_REQUEST['ID']) > 0)
{
	$arFilter = array(
		'ID' => $_REQUEST['ID']
	);
	switch ($_REQUEST['action'])
	{
		case 'delete' :
			$rsDel = $obTableUsers->delete($arFilter);
			/**
			 * @todo выкинуть пользователя из сеанса и удалить его ответы
			 */
			break;
		case 'disallow' :
			$rsDallow = $obTableUsers->update(array(
				'FILTER' => $arFilter,
				'FIELDS' => array(
					'CANMAKE' => 0
				)
			));
			break;
		case 'allow' :
			$rsAllow = $obTableUsers->update(array(
				'FILTER' => $arFilter,
				'FIELDS' => array(
					'CANMAKE' => 1
				)
			));
			break;
	}
	header('Location: /staff/users.php');
	die();
}
$rsUsers = $obTableUsers->select(array(
	'FIELDS' => array(
		'ID', 'USERTYPEID', 'LOGIN', 'FIRSTNAME', 'SECONDNAME', 'LASTNAME', 'CANMAKE'
	)
		));
$obTableUsertype = new Data_Usertype();
$rsType = $obTableUsertype->select(array('FIELDS' => array('ID', 'NAME')));
$arTypes = array();
while ($arType = $rsType->fetch_assoc())
{
	$arTypes[$arType['ID']] = $arType['NAME'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cоздание логико-смысловых моделей</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
		<link rel="stylesheet" type="text/css" href="/opt/fancybox/jquery.fancybox-1.3.4.css">
		<script type="text/javascript" src="/opt/jquery-1.4.3.min.js"></script>
    </head>
    <body>
        <div id="wrap">
			<?php include 'header.php'; ?>
            <section>
				<table class="elements searchresult">
					<? while ($arRow = $rsUsers->fetch_assoc()): ?>
						<tr>
							<td>
								<?=
								$arRow['FIRSTNAME']
								. ' ' . $arRow['SECONDNAME']
								. ' ' . $arRow['LASTNAME']
								?>
							</td>
							<td>
								<?= $arRow['LOGIN'] ?>
							</td>
							<td>
								<?= $arTypes[$arRow['USERTYPEID']] ?>
							</td>
							<td>
								<? if (intval($arRow['USERTYPEID']) <= Data_Usertype::USER_TYPE_TEACHER): ?>
									<? if (intval($arRow['CANMAKE']) === 1): ?>
										<a class="button"  href="users.php?action=disallow&ID=<?= $arRow['ID'] ?>">Запретить</a>
									<? else : ?>
										<a class="button"  href="users.php?action=allow&ID=<?= $arRow['ID'] ?>">Разрешить</a>
									<? endif ?>
								<? endif; ?>
							</td>
							<td>
							<td>
								<a class="button"
								   href="answers.php?ID=<?= $arRow['ID'] ?>"
								   >Тесты</a>

							</td>
							</td>
							<td>
								<a class="button"
								   href="users.php?action=delete&ID=<?= $arRow['ID'] ?>" 
								   class="delete"
								   >Удалить</a>
							</td>
						</tr>
					<? endwhile; ?>
				</table>
			</section>
			<?php include 'footer.php'; ?>
        </div>
    </body>
</html>
