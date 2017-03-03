
<header>
    <menu>
		<li><a href="/">Главная</a></li>
		<? if (Utils_Currentuser::getInstance()->isLogged()): ?>
			<li><a href="users.php">Пользователи</a></li>
			<li><a href="models.php">Тесты</a></li>
			<li><a href="/?logout=y">Выход</a></li>
		<? else: ?>
			<li><a href="/login.php">Вход</a></li>
		<? endif; ?>      
    </menu>   
</header>