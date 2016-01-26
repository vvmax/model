<?php
include 'lib/include.php';
$arUserInfo = Utils_Currentuser::getInstance()->getUserInfo();
?>
<!DOCTYPE html>
<html>
    <head>
		<title>Профиль</title>
        <meta charset="UTF-8">
		<meta name="keywords" content="Логико-смысловая модель,химия" />
		<meta name="description" content="Cоздание логическо-смысловых моделей по химии" />
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
		<script type="text/javascript" src="/opt/jquery-1.4.3.min.js"></script>
		<script type="text/javascript" src="/js/useredit.js"></script>
    </head>
    <body>
        <div id="wrap">
			<?php include 'header.php'; ?>
            <section>
                <h1>Профиль</h1>
				<table class="elements">	
					<tr><th>Тип пользователя</th><td><?= $arUserInfo['USERTYPE_NAME'] ?></td></tr>
					<tr><th>Имя</th><td><?= $arUserInfo['FIRSTNAME'] ?></td></tr>
					<tr><th>Фамилия</th><td><?= $arUserInfo['SECONDNAME'] ?></td></tr>
					<tr><th>Отчество</th><td><?= $arUserInfo['LASTNAME'] ?></td></tr>
					<tr><th>Логин</th><td><?= $arUserInfo['LOGIN'] ?></td></tr>
					<tr><th>Город</th><td><?= $arUserInfo['TOWNS_NAME'] ?></td></tr>
					<tr><th>Школа</th><td><?= $arUserInfo['SCHOOLS_NAME'] ?></td></tr>
					<tr><th>Класс</th><td><?= $arUserInfo['FORM'] ?></td></tr>
				</table>
				<form action="useredit.php">
					<button type="submit" >Редаткировать</button>
				</form>
            </section>
			<?php include 'footer.php'; ?>
        </div>
    </body>
</html>
