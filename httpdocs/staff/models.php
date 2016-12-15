<?php
include '../lib/include.php';
if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'modeldel')
{
	Utils_Model::deleteUserModel($_REQUEST);
	header('Location: models.php');
	exit();
}
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
                <h1>Cписок тестов</h1>    
                <ul class="list">
					<?php
					$obTableModel = new Data_Model();
					$rsModels = $obTableModel->select();
					while ($arRow = $rsModels->fetch_assoc()):
						?> 
						<li>
							<a href="model.php?ID=<?= $arRow['ID'] ?>" ><span><?= $arRow['NAME'] ?></span><span><?= $arRow['DESCRIPTION'] ?></span></a>
								<div class="tools">
									<a href="models.php?action=modeldel&ID=<?= $arRow['ID'] ?>">Удалить</a>
								</div>
						</li>

					<? endwhile; ?>
                </ul>
            </section>
			<?php include 'footer.php'; ?>
        </div>
    </body>
</html>
