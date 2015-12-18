<!DOCTYPE html>
<?php include 'lib/include.php';?>
<html>
    <head>
        <title>Регистрация</title>
        <meta charset="UTF-8">
	<meta name="keywords" content="Логико-смысловая модель,химия" />
<meta name="description" content="Cоздание логическо-смысловых моделей по химии" />
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
	<script type="text/javascript" src="/opt/jquery-1.4.3.min.js"></script>
    </head>
    <body>
        <div id="wrap">
            <?php include 'header.php';?>
            <section>
                <h1>Регистрация</h1>
		<form action="/useredit.php" method="POST">
		    <div class="formrow singlerow" >
			<label>Ученик</label>
			<input checked type="radio" name="usertype" value="<?= Data_Usertype::USER_TYPE_STUDENT?>">
			<label>Учитель</label>
			<input type="radio" name="usertype" value="<?= Data_Usertype::USER_TYPE_TEACHER?>">
		    </div>
		    <DIV class="formrow">
			<label>Имя</label>
			<input type="text" name="firstname">
		    </div>
		    <DIV class="formrow">
			<label>Фамилия</label>
			<input type="text" name="secondname">
		    </div>
		    <DIV class="formrow">
			<label>Отчество</label>
			<input type="text" name="lastname">
		    </div>
		    <DIV class="formrow">
			<label>Логин</label>
			<input type="text" name="login">
		    </div>
		    <DIV class="formrow">
			<label>Пароль</label>
			<input type="password" name="password">
		    </div>
		    <DIV class="formrow">
			<label>Подтверждение пароля</label>
			<input type="password" name="password2">
		    </div>
		    <DIV class="formrow">
			<label>Город</label>
			<select>
			    <option value="-1">   </option>
			    <option value="0" selected>own</option>
			</select>
			<input type="text" name="newtown">
		    </div>
		    <DIV class="formrow">
			<label>Школа</label>
			<select>
			    <option value="-1">   </option>
			    <option value="0" selected>own</option>
			</select>
			<input type="text" name="newschool">
			
		    </div>
		    <DIV class="formrow">
			<label>Класс</label>
			<select class="short">
			    <option value="-1">1</option>
			    <option value="0" selected>2</option>
			</select>
			<select class="short">
			    <option value="-1">a</option>
			    <option value="0" selected>б</option>
			</select>
		    </div>
		</form>
            </section>
            <?php include 'footer.php';?>
        </div>
    </body>
</html>
