<?php
include 'lib/include.php';
if (isset($_REQUEST['DID']) && intval($_REQUEST['DID']) > 0)
{
	Utils_Currentuser::getInstance()->delStudent($_REQUEST['DID']);
}
$arResult = Utils_Currentuser::getInstance()->GetStudentsList();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Мои ученики</title>
        <meta charset="UTF-8">
		<meta name="keywords" content="Логико-смысловая модель" />
		<meta name="description" content="Cоздание логическо-смысловых моделей" />
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
		<script type="text/javascript" src="/opt/jquery-1.4.3.min.js"></script>
    </head>
    <body>
        <div id="wrap">
			<?php include 'header.php'; ?>
            <section>
				<h1>Ученики</h1>
				<table class="elements searchresult">
					<? foreach ($arResult as $arStudent): ?>
						<tr>
							<td>
								<?=
								$arStudent['USERS_FIRSTNAME']
								. ' ' . $arStudent['USERS_SECONDNAME']
								. ' ' . $arStudent['USERS_LASTNAME']
								?>
							</td>
							<td>
								<?if (intval($arStudent['ACCEPTED']) === 1): ?>
								<a class="button"  href="viewmodels.php?ID=<?= $arStudent['USERS_ID'] ?>">Тесты</a>
								<? else : ?>
									Не подтвержден
								<? endif ?>
							</td>
							<td>
								<a class="button"
									href="mystudents.php?DID=<?= $arStudent['USERS_ID'] ?>" 
									class="delete"
									>Удалить</a>
							</td>
						</tr>
					<? endforeach; ?>
				</table>
            </section>
			<?php include 'footer.php'; ?>
        </div>
    </body>
</html>
