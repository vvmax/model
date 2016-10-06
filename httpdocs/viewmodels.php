<?php
include 'lib/include.php';
if (!isset($_REQUEST['ID']) || intval($_REQUEST['ID']) <= 0)
{
	ob_end_clean();
	header('Location: /');
	ob_end_flush();
	exit();
}
$obUser = new Utils_User();
$arAnswers = $obUser->getStudentAnswerList($_REQUEST['ID']);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Логические схемы</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
		<script type="text/javascript" src="/opt/jquery-1.4.3.min.js"></script>
    </head>
    <body>
        <div id="wrap">
			<?php include 'header.php'; ?>
            <section>
                <h1>Cписок тестов ученика</h1>    
                <ul class="list">         
					<?
					foreach ($arAnswers as $arAnswer):
						?> 
						<li><a href="readymodel.php?CODE=<?= $arAnswer['CODE'] ?>" >
								<span><?= $arAnswer['MODEL_NAME'] ?></span>
								<span><?= $arAnswer['MODEL_DESCRIPTION'] ?></span>
								<span><?= $arAnswer['ADATE'] ?></span>
							</a>
						<? endforeach; ?>
                </ul>
            </section>
			<?php include 'footer.php'; ?>
        </div>
    </body>
</html>
