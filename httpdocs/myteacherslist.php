<?php
include 'lib/include.php';
if (isset($_REQUEST['act']) && isset($_REQUEST['ID']))
{
	if ($_REQUEST['act'] == 'accept' )
	{
		Utils_Currentuser::getInstance()->accept($_REQUEST['ID']);
	}
	elseif ($_REQUEST['act'] == 'del')
	{
		Utils_Currentuser::getInstance()->del($_REQUEST['ID']);
	}
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Мои учителя</title>
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
				<h1>Учителя</h1>
				<table class="elements searchresult">
					<colgroup>
						<col>
						<col width="1%">
						<col width="1%">
					</colgroup>
					<? foreach (Utils_Currentuser::getInstance()->getTeacherListAll() as $arUser): ?>
						<tr>
							<td><?= $arUser['USERS_FIRSTNAME'] . ' ' . $arUser['USERS_SECONDNAME'] . ' ' . $arUser['USERS_LASTNAME'] ?></td>
							<td>
								<? if ($arUser['ACCEPTED'] == 0): ?>
									<a class="button" href="/myteacherslist.php?ID=<?= $arUser['USERS_ID'] ?>&act=accept" >Принять</a>
								<? endif; ?>
							</td>
							<td><a class="button" href="/myteacherslist.php?ID=<?= $arUser['USERS_ID'] ?>&act=del" >Удалить</a></td>
						</tr>
					<? endforeach; ?>
				</table>
            </section>
			<?php include 'footer.php'; ?>
        </div>
    </body>
</html>
