<?php

include 'lib/include.php';
$arResult = array('error' => -1);
If (isset($_REQUEST['action']))
{
	switch ($_REQUEST['action'])
	{
		case 'addStudent':
			if (Utils_Currentuser::getInstance()->addStudent($_REQUEST['STUDENTID']) === false)
			{
				$arResult['error'] = 1;
			}
			else
			{
				$arResult['error'] = 0;
			};
			break;
		case 'search':
			$obUser = new Utils_User();
			$arResult['users'] = $obUser->search($_REQUEST);
			$arResult['error'] = 0;
			break;
		case 'getSchool':
			if (isset($_REQUEST['Id']))
			{
				$obTableSchool = new Data_Schools();
				$arResult['schools'] = $obTableSchool->getOptions(array('TOWNID' => $_REQUEST['Id']));
				$arResult['error'] = 0;
			}
			break;
	}
}
header('Content-Type: application/json');
echo json_encode($arResult);
