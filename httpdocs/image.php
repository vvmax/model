<?php
include 'lib/include.php';
$obTableAnswer = new Data_Answer();
Utils_Image::getImage(Utils_Model::getFillModel($obTableAnswer->getId($_REQUEST['CODE'])));
