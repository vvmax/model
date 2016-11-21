<?php
include 'lib/include.php';
$obTableTown = new Data_Towns();
$arTowns = $obTableTown->getOptions();
$obTableSchool = new Data_Schools();
$arSchools = $obTableSchool->getOptions();
If (isset($_REQUEST['usertype']))
{

	$obUser = new Utils_User();
	if (Utils_Currentuser::getInstance()->isLogged())
	{
		$arRes = $obUser->updateUser($_REQUEST);
	}
	else
	{
		$arRes = $obUser->addUser($_REQUEST);
	}


	$arRes = $obUser->addUser($_REQUEST);
}
$arUserInfo = Utils_Currentuser::getInstance()->getUserInfo();
?>
<!DOCTYPE html>
<html>
    <head>
		<? if (Utils_Currentuser::getInstance()->isLogged()): ?>
			<title>Редактирование профиля</title>
		<? else: ?>
			<title>Регистрация</title>
		<? endif; ?>

        <meta charset="UTF-8">
		<meta name="keywords" content="Логико-смысловая модель" />
		<meta name="description" content="Cоздание логическо-смысловых моделей" />
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
		<script type="text/javascript" src="/opt/jquery-1.4.3.min.js"></script>
		<script type="text/javascript" src="/js/useredit.js"></script>
    </head>
    <body>
        <div id="wrap">
			<?php include 'header.php'; ?>
            <section>
				<? if (Utils_Currentuser::getInstance()->isLogged()): ?>
					<h1>Редактирование профиля</h1>
				<? else: ?>
					<h1>Регистрация</h1>
				<? endif; ?>
				<form action="/useredit.php" method="POST">
					<div class="formrow singlerow" >
						<? if (Utils_Currentuser::getInstance()->isLogged()): ?>
							<p><?= $arUserInfo['USERTYPE_NAME'] ?></p>
							<input type="hidden" value="<?=$arUserInfo['USERTYPEID']?>" name="usertype">
						<? else: ?>
							<label>Ученик</label>
							<input checked type="radio" name="usertype" value="<?= Data_Usertype::USER_TYPE_STUDENT ?>">
							<label>Учитель</label>
							<input type="radio" name="usertype" value="<?= Data_Usertype::USER_TYPE_TEACHER ?>">
						<? endif; ?>
					</div>
					<DIV class="formrow">
						<label>Имя</label>
						<input type="text" name="firstname" value='<?= $arUserInfo['FIRSTNAME'] ?>'>
						<? if (isset($arRes['firstname'])): ?><span class="error"><?= $arRes['firstname'] ?></span><? endif; ?>
					</div>
					<DIV class="formrow">
						<label>Фамилия</label>
						<input type="text" name="secondname" value='<?= $arUserInfo['SECONDNAME'] ?>'>
						<? if (isset($arRes['secondname'])): ?><span class="error"><?= $arRes['secondname'] ?></span><? endif; ?>
					</div>
					<DIV class="formrow">
						<label>Отчество</label>
						<input type="text" name="lastname" value='<?= $arUserInfo['LASTNAME'] ?>'>
					</div>
					<DIV class="formrow">
						<label>Логин</label>
						<input type="text" name="login" value='<?= $arUserInfo['LOGIN'] ?>'>
						<? if (isset($arRes['login'])): ?><span class="error"><?= $arRes['login'] ?></span><? endif; ?>			
					</div>
					<DIV class="formrow">
						<label>    
							<? if (Utils_Currentuser::getInstance()->isLogged()): ?>
								Новый пароль<span class="note">(Заполнять если необходимо сменить)</span>
							<? else: ?>
								Пароль
							<? endif; ?>
						</label>
						<input type="password" name="password">
						<? if (isset($arRes['password'])): ?><span class="error"><?= $arRes['password'] ?></span><? endif; ?>
					</div>
					<DIV class="formrow">
						<label>Подтверждение пароля</label>
						<input type="password" name="password2">
						<? if (isset($arRes['password2'])): ?><span class="error"><?= $arRes['password2'] ?></span><? endif; ?>			
					</div>
					<DIV class="formrow">
						<label>Город</label>
						<select name="town" id="town">
							<option value="-1" >   </option>
							<? foreach ($arTowns as $arValue): ?>
								<option 
								<? if ($arUserInfo['TOWNID'] == $arValue['ID']): ?>
										selected="selected"
									<? endif; ?>
									value="<?= $arValue['ID'] ?>"
									>
										<?= $arValue['NAME'] ?>
								</option>
							<? endforeach; ?>
						</select>
						<input type="text" name="newtown">
					</div>
					<DIV class="formrow">
						<label>Школа</label>
						<select 
							name="school" 
							<? if (!isset($arUserInfo['SCHOOLID'])): ?>
								style="display:none"
							<? endif; ?>
							id="school"
							>
							<option value="-1">   </option>
							<? foreach ($arSchools as $arValue): ?>
								<option 
								<? if ($arUserInfo['SCHOOLID'] == $arValue['ID']): ?>
										selected="selected"
									<? endif; ?>
									value="<?= $arValue['ID'] ?>"
									>
										<?= $arValue['NAME'] ?>
								</option>
							<? endforeach; ?>
						</select>
						<input type="text" name="newschool">

					</div>
					<DIV class="formrow">
						<label>Класс</label>
						<input type="text" name="form" value='<?= $arUserInfo['FORM'] ?>'>
					</div>
					<button type="submit" >Сохранить</button>
				</form>
            </section>
			<?php include 'footer.php'; ?>
        </div>
    </body>
</html>
