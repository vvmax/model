
<header>
    <menu>
		<li><a href="/">Главная</a></li>
		<li><a href="models.php">Все тесты</a></li>
		<? if (Utils_Currentuser::getInstance()->isLogged()): ?>
			<li><a href="usermodels.php">Пройденные тесты</a></li> 
			<li><a href="profile.php">Профиль</a></li>	
			<li><a href="/?logout=y">Выход</a></li>
		<? else: ?>
			<li><a href="login.php">Вход</a></li>
			<li><a href="useredit.php">Регистрация</a></li>
		<? endif; ?>      
    </menu>       
</header>         

