<?php
include 'lib/include.php';
if (isset($_REQUEST['DESCRIPTION']))
{
	$obTableFeedback = new Data_Feedback();
	$check = $obTableFeedback->addMessage($_REQUEST);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Логические схемы</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
		<script type="text/javascript" src="/opt/jquery-2.1.4.min.js"></script>
    </head>
	<body>
        <div id="wrap">
			<?php include 'header.php'; ?>
			<? if ($check != false): ?>
				<p><b>Сообщение отправлено</b></p>
			<? endif; ?>
			<form action="/feedback.php" method="POST">
				<table class="elements" id="edittesttable" >
					<tr>
						<td>
							<input type="text"  placeholder="Тема" name="THEME">
						</td>
					</tr>
					<tr>
						<td >
							<textarea name="DESCRIPTION" placeholder="Текст сообщения" ></textarea>
						</td>
					</tr>
				</table>
				<button type="submit" >Отправить</button>
			</form>
			<?php include 'footer.php'; ?>
        </div>
    </body>