<?php

/**
 * Категории модели
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.10.14
 */
class Utils_User
{

	private $userId;

	public function __construct()
	{
		if (empty($_COOKIE['USERHASH']))
		{
			srand();
			$this->userId = md5(rand(0, 999999));
			setcookie('USERHASH', $this->userId, time() + 60 * 60 * 24 * 30 * 12, '/');
		}
		else
		{
			$this->userId = $_COOKIE['USERHASH'];
		}
	}

	/**
	 * Функция проверки регистрационного листа
	 * @param array $arRequest  массив получаемый из формы
	 * @return boolean | array
	 */
	static function checkForm(&$arRequest)
	{
		$arError = array();
		foreach ($arRequest as &$value)
		{
			$value = trim($value);
		}
		if ($arRequest['usertype'] < Data_Usertype::USER_TYPE_TEACHER)
		{
			$arRequest['usertype'] = Data_Usertype::USER_TYPE_STUDENT;
		}
		if (empty($arRequest['firstname']))
		{
			$arError['firstname'] = 'Заполните поле "Имя"';
		}
		if (empty($arRequest['secondname']))
		{
			$arError['secondname'] = 'Заполните поле "Фамилия"';
		}
		if (empty($arRequest['login']))
		{
			$arError['login'] = 'Заполните поле "Логин"';
		}
		if (!Utils_Currentuser::getInstance()->isLogged() || !empty($arRequest['password']))
		{
			if (empty($arRequest['password']))
			{
				$arError['password'] = 'Заполните поле "Пароль"';
			}

			if (empty($arRequest['password2']))
			{
				$arError['password2'] = 'Заполните поле "Подтверждение пароля"';
			}
			if ($arRequest['password'] != $arRequest['password2'])
			{
				$arError['password2'] = 'Неверно заполнено поле "Подтверждение пароля"';
			}
		}
		return (empty($arError) ? TRUE : $arError);
	}

	public function addUser(&$arRequest)
	{
		$arError = $this->checkForm($arRequest);

		if ($arError === TRUE)
		{
			if (intval($arRequest['town']) === -1)
			{
				if (trim($arRequest['newtown']) == '')
				{
					$townId = -1;
				}
				else
				{
					$obTableTown = new Data_Towns();
					$townId = $obTableTown->getIdAdd($arRequest['newtown']);
				}
			}
			else
			{
				$townId = $arRequest['town'];
			}
			//обработка школы
			if ($townId > -1)
			{
				if (intval($arRequest['school']) === -1)
				{
					if (trim($arRequest['newschool']) == '')
					{
						$schoolId = -1;
					}
					else
					{
						$obTableSchool = new Data_Schools();
						$schoolId = $obTableSchool->getIdAdd($arRequest['newschool'], array(
							'TOWNID' => $townId
						));
					}
				}
				else
				{
					$schoolId = $arRequest['school'];
				}
			}
			$obUserTable = new Data_Users();
			$obUserTable->insert(array('FIELDS' => array(
					'LOGIN'		 => $arRequest['login'],
					'PASSWORD'	 => $this->codec($arRequest['password']),
					'SCHOOLID'	 => $schoolId,
					'FIRSTNAME'	 => $arRequest['firstname'],
					'SECONDNAME' => $arRequest['secondname'],
					"LASTNAME"	 => $arRequest['lastname'],
					'FORM'		 => $arRequest['form'],
					'USERTYPEID' => $arRequest['usertype'],
					'TOWNID'	 => $townId
			)));
		}
		return $arError;
	}

	/**
	 * кодирование пароля
	 * @param string $password незашифрованный пароль
	 * @return string
	 */
	public function codec($password)
	{
		return md5($password . Settings::sol);
	}

	public function updateUser(&$arRequest)
	{
		$arError = $this->checkForm($arRequest);

		if ($arError === TRUE)
		{
			if (intval($arRequest['town']) === -1)
			{
				if (trim($arRequest['newtown']) == '')
				{
					$townId = -1;
				}
				else
				{
					$obTableTown = new Data_Towns();
					$townId = $obTableTown->getIdAdd($arRequest['newtown']);
				}
			}
			else
			{
				$townId = $arRequest['town'];
			}
			//обработка школы
			if ($townId > -1)
			{
				if (intval($arRequest['school']) === -1)
				{
					if (trim($arRequest['newschool']) == '')
					{
						$schoolId = -1;
					}
					else
					{
						$obTableSchool = new Data_Schools();
						$schoolId = $obTableSchool->getIdAdd($arRequest['newschool'], array(
							'TOWNID' => $townId
						));
					}
				}
				else
				{
					$schoolId = $arRequest['school'];
				}
			}
			$arFields=array(
					'LOGIN'		 => $arRequest['login'],
					'SCHOOLID'	 => $schoolId,
					'FIRSTNAME'	 => $arRequest['firstname'],
					'SECONDNAME' => $arRequest['secondname'],
					"LASTNAME"	 => $arRequest['lastname'],
					'FORM'		 => $arRequest['form'],
					'USERTYPEID' => $arRequest['usertype'],
					'TOWNID'	 => $townId
			);
			if(!empty($arRequest['password']))
			{
				$arFields['PASSWORD']=$this->codec($arRequest['password']);
			}
			$obUserTable = new Data_Users();
			$obUserTable->update(array(
				'FIELDS' => $arFields,
				'FILTER'=> array(
					'ID'=>$_SESSION['USERID']
				)
				));
		}
		return $arError;
	}

}
