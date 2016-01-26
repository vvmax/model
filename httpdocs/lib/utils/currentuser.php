<?php

/**
 * Класс текущего пользователя
 * использует паттерн програмирования "одиночка"
 * для обеспечения единственого объекта класса
 * @category utils
 * @version 1.0
 * @author Максим Воробьев
 */
class Utils_Currentuser extends Utils_User
{

	/**
	 * айди пользователя
	 * @var int 
	 */
	private $id;

	/**
	 * объект класса
	 * @var object 
	 */
	protected static $_instance;

	/**
	 * приватный конструктор класса для безопасности 
	 */
	public function __construct()
	{
		if (isset($_REQUEST['logout']) && $_REQUEST['logout'] == 'y')
		{
			$this->logout();
		}
		elseif (isset($_SESSION['USERID']))
		{
			$this->id = $_SESSION['USERID'];
		}
		parent::__construct();
	}

	public function getId()
	{
		return $this->id;
	}

	/**
	 * получение информации о профиле пользователя
	 * @return array
	 */
	public function getUserInfo()
	{
		if (!isset($_SESSION['USERID']))
		{
			return array();
		}
		$obTableUsers = new Data_Users();
		$rsUser = $obTableUsers->select(array(
			'FIELDS' => array(
				'LOGIN',
				'SCHOOLID',
				"FIRSTNAME",
				'SECONDNAME',
				'LASTNAME',
				'FORM',
				'USERTYPEID',
				'TOWNID'),
			'FILTER' => array(
				'ID' => $_SESSION['USERID']
			),
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
					'TABLE'	 => 'usertype',
					'ON'	 => array(
						'ID' => 'USERTYPEID'
					),
					'PARENT' => 'users',
					'FIELDS' => array(
						'NAME'
					)
				)
			)
		));
		$arUser = $rsUser->fetch_assoc();
		return $arUser;
	}

	/**
	 * запрет копирования объекта класса
	 */
	private function __clone()
	{
		
	}

	/**
	 * Метод возвращает экземпляр класса 
	 * 
	 * @return Single
	 */
	public static function getInstance()
	{
		if (null === self::$_instance)
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * авторизация пользователя
	 * @param array $arRequest
	 */
	public function checkLogin($arRequest)
	{
		//$this->logout();
		$arError = array();
		foreach ($arRequest as &$value)
		{
			$value = trim($value);
		}
		if (empty($arRequest['login']))
		{
			$arError['login'] = 'Заполните поле "Логин"';
		}
		if (empty($arRequest['password']))
		{
			$arError['password'] = 'Заполните поле "Пароль"';
		}
		if (!empty($arError))
		{
			return $arError;
		}
		$obUserTable = new Data_Users();
		$rsUser = $obUserTable->select(array(
			'FIELDS' => array('ID'),
			'FILTER' => array(
				'LOGIN'		 => $arRequest['login'],
				'PASSWORD'	 => $this->codec($arRequest['password'])
		)));
		if ($rsUser !== false && $rsUser->num_rows !== 0)
		{
			if ($arUser = $rsUser->fetch_assoc())
			{
				$this->id = $arUser['ID'];
				$_SESSION['USERID'] = $arUser['ID'];
				$secret = $this->codec($this->id . date('YmdHis'));
				$_SESSION['secret'] = $secret;
				setcookie('history', $secret, time() + 2678400);
				return true;
			}
		}
		return array('global' => 'Неверно введен логин или пароль');
	}

	public function isLogged()
	{
		return isset($_SESSION['secret']);
	}

	public function logout()
	{
		unset($_SESSION['secret']);
		unset($_SESSION['USERID']);
		setcookie('history', $secret, 0);
		$this->id = 0;
	}

	public function getAnswerList()
	{
		$obTableAnswer = new Data_Answer();
		$rsAnswers = $obTableAnswer->select(
				array(
					'FIELDS' => array(
						'ADATE', "CODE",'ID'
					),
					"FILTER" => array(
						'USERID' => $this->id
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

	public function deleteMyAnswer($id)
	{
		$obTableAnswer = new Data_Answer();
		return $obTableAnswer->delete(array(
			'ID'	 => $id,
			'USERID' => $this->getId()
				)
		);
	}

}
