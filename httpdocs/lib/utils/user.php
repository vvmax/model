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
			$arFields = array(
				'LOGIN'		 => $arRequest['login'],
				'SCHOOLID'	 => $schoolId,
				'FIRSTNAME'	 => $arRequest['firstname'],
				'SECONDNAME' => $arRequest['secondname'],
				"LASTNAME"	 => $arRequest['lastname'],
				'FORM'		 => $arRequest['form'],
				'USERTYPEID' => $arRequest['usertype'],
				'TOWNID'	 => $townId
			);
			if (!empty($arRequest['password']))
			{
				$arFields['PASSWORD'] = $this->codec($arRequest['password']);
			}
			$obUserTable = new Data_Users();
			$obUserTable->update(array(
				'FIELDS' => $arFields,
				'FILTER' => array(
					'ID' => $_SESSION['USERID']
				)
			));
		}
		return $arError;
	}

	public function search($arRequest)
	{
		$arFilter = array();
		if (intval($arRequest['town']) === -1)
		{
			return false;
		}
		$arFilter['TOWNID'] = $arRequest['town'];
		if (intval($arRequest['school']) > 0)
		{
			$arFilter['SCHOOLID'] = $arRequest['school'];
		}
		if (!empty($arRequest['class']))
		{
			$arFilter['%FORM'] = $arRequest['class'];
		}
		if (!empty($arRequest['firstname']))
		{
			$arFilter['%FIRSTNAME'] = $arRequest['firstname'];
		}
		if (!empty($arRequest['secondname']))
		{
			$arFilter['%SECONDNAME'] = $arRequest['secondname'];
		}
		if (!empty($arRequest['login']))
		{
			$arFilter['%LOGIN'] = $arRequest['login'];
		}
		$arFilter['USERTYPEID'] = Data_Usertype::USER_TYPE_STUDENT;
		$obTableUsers = new Data_Users();
		$rsStudentsList = $obTableUsers->select(array(
			"FIELDS" => array(
				'CLASS',
				'LOGIN',
				'FIRSTNAME',
				'SECONDNAME',
				'ID',
				'LASTNAME',
				'FORM'
			),
			'FILTER' => $arFilter,
			'JOIN'	 => array(
				array(
					'TYPE'	 => 'left',
					'TABLE'	 => 'towns',
					'ON'	 => array(
						'ID' => 'TOWNID'
					),
					'PARENT' => 'users',
					'FIELDS' => array(
						'NAME'
					)
				),
				array(
					'TYPE'	 => 'left',
					'TABLE'	 => 'schools',
					'ON'	 => array(
						'ID' => 'SCHOOLID'
					),
					'PARENT' => 'users',
					'FIELDS' => array(
						'NAME'
					)
				),
				array(
					'TYPE'	 => 'left',
					'TABLE'	 => 'friends',
					'ON'	 => array(
						'STUDENTID'	 => 'ID',
						'#TEACHERID' => Utils_Currentuser::getInstance()->getId()
					),
					'PARENT' => 'users',
					'FIELDS' => array(
						'STUDENTID'
					)
				)
			)
		));
		$arResult = array();
		while ($arStudent = $rsStudentsList->fetch_assoc())
		{
			$arResult[] = $arStudent;
		}
		return $arResult;
	}

	public function getStudentAnswerList($id)
	{
		$obTableAnswer = new Data_Answer();
		$rsAnswers = $obTableAnswer->select(
				array(
					'FIELDS' => array(
						'ADATE', "CODE", 'ID'
					),
					"FILTER" => array(
						'USERID' => $id
					),
					"JOIN"	 => array(
						array(
							'TYPE'	 => 'left',
							'TABLE'	 => 'model',
							'ON'	 => array(
								'ID' => 'MODELID'
							),
							'PARENT' => 'answer',
							'FIELDS' => array(
								'NAME', "DESCRIPTION"
							)
						),
						array(
							'TYPE'	 => '',
							'TABLE'	 => 'answeraccess',
							'ON'	 => array(
								'#TEACHERID'	 => Utils_Currentuser::getInstance()->getId(),
								'ANSWERID'	 => 'ID'
							),
							'PARENT' => 'answer',
							"FIELDS" => array(
								'ANSWERID'
							)
						)
					)
				)
		);
		$arResult = array();
		while ($arAnswer = $rsAnswers->fetch_assoc())
		{
			$arResult[] = $arAnswer;
		}
		return $arResult;
	}

}
