
<header>
    <menu>
		<li><a href="/">Главная</a></li>
		<li><a href="models.php">Все тесты</a></li>
		<? if (Utils_Currentuser::getInstance()->isLogged()): ?>
			<? if (Utils_Currentuser::getInstance()->isMaker()): ?>
				<li><a href="edittest.php">Создание теста</a></li> 
			<? endif; ?>
			<? if (Utils_Currentuser::getInstance()->isTeacher()): ?>
				<li><a href="studentssearch.php">Поиск учеников</a></li> 
				<li><a href="mystudents.php">Ученики</a></li>
			<? else: ?>
				<li><a href="myteacherslist.php">Учителя</a></li>
			<? endif; ?>
			<li><a href="usermodels.php">Пройденные тесты</a></li> 
			<li><a href="profile.php">Профиль</a></li>	
			<li><a href="/?logout=y">Выход</a></li>
		<? else: ?>
			<li><a href="login.php">Вход</a></li>
			<li><a href="useredit.php">Регистрация</a></li>
		<? endif; ?>      
    </menu>   
</header>