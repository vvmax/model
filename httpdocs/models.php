<?php include 'lib/include.php';?>
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
            <?php include 'header.php';?>
            <section>
                <h1>Cписок тестов</h1>    
                <ul class="list">
          <?php
          $obTableModel = new Data_Model();
          $rsModels = $obTableModel->select();
          while ($arRow=$rsModels->fetch_assoc()):
          ?> 
                    <li><a href="model.php?ID=<?= $arRow['ID']?>" ><span><?= $arRow['NAME']?></span><span><?= $arRow['DESCRIPTION']?></span></a></li>
                    <?endwhile;?>
                </ul>
            </section>
                <?php include 'footer.php';?>
        </div>
    </body>
</html>
