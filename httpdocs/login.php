<?php
include 'lib/include.php';
If (isset($_REQUEST['login']))
{
	$obUser = new Utils_Currentuser();
	$arRes = $obUser->checkLogin($_REQUEST);
	if ($arRes === true)
	{
		header("Location: {$_SESSION['adress']}");
		exit ();
	}

}
else
{
	$_SESSION['adress']=  str_replace('?logout=y','',$_SERVER['HTTP_REFERER']);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Вход</title>
        <meta charset="UTF-8">
		<meta name="keywords" content="Логико-смысловая модель,химия" />
		<meta name="description" content="Cоздание логическо-смысловых моделей по химии" />
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
		<script type="text/javascript" src="/opt/jquery-1.4.3.min.js"></script>
    </head>
    <body>
        <div id="wrap">
			<?php include 'header.php'; ?>
            <section>
                <h1>Вход</h1>
				<?if(is_array($arRes)):?>
				<div class="error"><?= implode('<br>',$arRes)?></div>
					<?endif;?>
				<form action="/login.php" method="POST">
					<div class="formrow" >
						<label>Логин</label>
						<input type="text" name="login">
						<? if (isset($arRes['login'])): ?><span class="error"><?= $arRes['login'] ?></span><? endif; ?>			
					</div>
					<DIV class="formrow">
						<label>Пароль</label>
						<input type="password" name="password">
						<? if (isset($arRes['password'])): ?><span class="error"><?= $arRes['password'] ?></span><? endif; ?>
					</div>
					<button type="submit" >Войти</button>
				</form>
            </section>
			<?php include 'footer.php'; ?>
        </div>
    </body>
</html>
