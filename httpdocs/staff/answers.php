<?php
include '../lib/include.php';
if(isset($_REQUEST['DID']) && intval($_REQUEST['DID'])>0)
{
	$obUser = new Utils_User();
	$obUser->deleteAnswer($_REQUEST['DID'],$_REQUEST['ID']);
}
$arAnswers=Utils_Currentuser::getInstance()->getAnswers($_REQUEST['ID']);
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
                <h1>Cписок пройденых тестов</h1>    
                <ul class="list">         
					<?
					foreach($arAnswers as $arAnswer):
						?> 
						<li><a href="readymodel.php?CODE=<?= $arAnswer['CODE'] ?>&id=<?= $_REQUEST['ID']?>" >
								<span><?= $arAnswer['MODEL_NAME'] ?></span>
								<span><?= $arAnswer['MODEL_DESCRIPTION'] ?></span>
								<span><?= $arAnswer['ADATE'] ?></span>
							</a>
							<a 
								href="answers.php?DID=<?=$arAnswer['ID']?>&ID=<?=$_REQUEST['ID']?>" 
								class="delete"
								>&times;</a></li>
					<? endforeach; ?>
                </ul>
            </section>
			<?php include '../footer.php'; ?>
        </div>
    </body>
</html>
