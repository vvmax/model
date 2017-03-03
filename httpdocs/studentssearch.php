<?php
include 'lib/include.php';
$obTableTown = new Data_Towns();
$arTowns = $obTableTown->getOptions();
$obTableSchool = new Data_Schools();
$arSchools = $obTableSchool->getOptions();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Поиск учеников</title>
        <meta charset="UTF-8">
		<meta name="keywords" content="Логико-смысловая модель" />
		<meta name="description" content="Cоздание логическо-смысловых моделей" />
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
		<script type="text/javascript" src="/opt/jquery-1.4.3.min.js"></script>
		<script type="text/javascript" src="/js/studentssearch.js"></script>
    </head>
    <body>
        <div id="wrap">
			<?php include 'header.php'; ?>
            <section>
				<h1>Поиск</h1>
				<form method="post" class="studentsearch" action="studentssearch.php" id="searchform">
					<div class="formitem">
						<label>Город</label>
						<select name="town" id="town">
							<option value="-1" >   </option>
							<? foreach ($arTowns as $arValue): ?>
								<option value="<?= $arValue['ID'] ?>">
									<?= $arValue['NAME'] ?>
								</option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="formitem"  id="school" style="display:none">
						<label>Школа</label>
						<select name="school">
							<option value="-1" >   </option>
							<? foreach ($arSchools as $arValue): ?>
								<option value="<?= $arValue['ID'] ?>">
									<?= $arValue['NAME'] ?>
								</option>
							<? endforeach; ?>
						</select>
					</div>
					<div class="formitem">
						<label>Класс</label>
						<input type="text" name="class" id="class">
						<div class="note">Пример: 8 или 10 В</div>
					</div>
					<div class="formitem">
						<label>Фамилия</label>
						<input type="text" name="secondname" id="secondname">
					</div>
					<div class="formitem">
						<label>Имя</label>
						<input type="text" name="firstname" id="firstname">
					</div>
					<div class="formitem">
						<label>Логин</label>
						<input type="text" name="login" id="login">
					</div>
					<button type="submit">Поиск</button>
				</form>
				<table class="elements searchresult" id="searchtable">
				
				</table>
            </section>
			<?php include 'footer.php'; ?>
        </div>
    </body>
</html>
