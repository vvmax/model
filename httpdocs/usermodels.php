<?php
include 'lib/include.php';
if(isset($_REQUEST['DID']) && intval($_REQUEST['DID'])>0)
{
	Utils_Currentuser::getInstance()->deleteMyAnswer($_REQUEST['DID']);
}
$arAnswers=Utils_Currentuser::getInstance()->getAnswerList();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
						<li><a href="readymodel.php?CODE=<?= $arAnswer['CODE'] ?>" >
								<span><?= $arAnswer['MODEL_NAME'] ?></span>
								<span><?= $arAnswer['MODEL_DESCRIPTION'] ?></span>
								<span><?= $arAnswer['ADATE'] ?></span>
							</a>
							<a 
								href="usermodels.php?DID=<?=$arAnswer['ID']?>" 
								class="delete"
								>&times;</a></li>
					<? endforeach; ?>
                </ul>
            </section>
			<?php include 'footer.php'; ?>
        </div>
    </body>
</html>
