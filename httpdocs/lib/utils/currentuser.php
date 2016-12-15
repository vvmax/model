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
			'FIELDS' => array('ID', 'USERTYPEID', 'CANMAKE'),
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
				$_SESSION['USERTYPEID'] = $arUser['USERTYPEID'];
				$_SESSION['CANMAKE'] = $arUser['CANMAKE'];
				setcookie('history', $secret, time() + 2678400);
				return true;
			}
		}
		return array('global' => 'Неверно введен логин или пароль');
	}

	public function isTeacher()
	{
		return $_SESSION['USERTYPEID'] == Data_Usertype::USER_TYPE_TEACHER;
	}

	public function isMaker()
	{
		return $_SESSION['CANMAKE'] == 1;
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
						'ADATE', "CODE", 'ID'
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
	/**
	 * @todo поместить новые функции для админа на места
	 */
	public function getAnswers($id)
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
						)
					)
				)
		);
		$arResult = array();
		Utils_Util::printDebug($rsAnswers);
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

	public function addStudent($id)
	{
		$obTableFriends = new Data_Friends();
		return $obTableFriends->insert(array(
					'FIELDS' => array
						(
						'TEACHERID'	 => $this->id,
						'STUDENTID'	 => $id
					)
		));
	}

	public function getTeacherList($aid)
	{
		$obTableFriends = new Data_Friends();
		$rsTeacherList = $obTableFriends->select(array(
			"FIELDS" => array(
				'ACCEPTED'
			),
			'FILTER' => array(
				'STUDENTID' => $this->id
			),
			'JOIN'	 => array(
				array(
					'TYPE'	 => 'inner',
					'TABLE'	 => 'users',
					'ON'	 => array(
						'ID' => 'TEACHERID'
					),
					'PARENT' => 'friends',
					'FIELDS' => array(
						'FIRSTNAME',
						'SECONDNAME',
						'ID',
						'LASTNAME'
					)
				),
				array(
					'TYPE'	 => 'left',
					'TABLE'	 => 'answeraccess',
					'ON'	 => array(
						'TEACHERID'	 => 'TEACHERID',
						'USERID'	 => 'STUDENTID',
						'#ANSWERID'	 => $aid
					),
					'PARENT' => 'friends',
					"FIELDS" => array(
						'ANSWERID'
					)
				)
			)
		));
		$arResult = array();
		if ($rsTeacherList === false)
		{
			//@todo добавить обработку ошибок
			return array();
		}
		while ($arTeacher = $rsTeacherList->fetch_assoc())
		{
			$arResult[] = $arTeacher;
		}
		return $arResult;
	}

	public function getTeacherListAll()
	{
		$obTableFriends = new Data_Friends();
		$rsTeacherList = $obTableFriends->select(array(
			"FIELDS" => array(
				'ACCEPTED'
			),
			'FILTER' => array(
				'STUDENTID' => $this->id
			),
			'JOIN'	 => array(
				array(
					'TYPE'	 => 'inner',
					'TABLE'	 => 'users',
					'ON'	 => array(
						'ID' => 'TEACHERID'
					),
					'PARENT' => 'friends',
					'FIELDS' => array(
						'FIRSTNAME',
						'SECONDNAME',
						'ID',
						'LASTNAME'
					)
				)
			)
		));
		$arResult = array();
		if ($rsTeacherList === false)
		{
			//@todo добавить обработку ошибок
			return array();
		}
		while ($arTeacher = $rsTeacherList->fetch_assoc())
		{
			$arResult[] = $arTeacher;
		}
		return $arResult;
	}

	public function accept($id)
	{
		$obTableFriends = new Data_Friends();
		$obTableFriends->update(array(
			"FIELDS" => array(
				'ACCEPTED' => 1
			),
			'FILTER' => array(
				'TEACHERID'	 => $id,
				'STUDENTID'	 => $this->id
			)
		));
	}

	/**
	 * удаление учителя из списка моих учителей
	 * @param int $id id учителя
	 */
	public function del($id)
	{
		$obTableFriends = new Data_Friends();
		$obTableFriends->delete(array(
			'TEACHERID'	 => $id,
			'STUDENTID'	 => $this->id
				)
		);
	}

	public function delStudent($id)
	{
		$obTableFriends = new Data_Friends();
		$obTableFriends->delete(array(
			'STUDENTID'	 => $id,
			'TEACHERID'	 => $this->id
				)
		);
	}

	public function getStudentsList()
	{
		$obTableFriends = new Data_Friends();
		$rsStudentsList = $obTableFriends->select(array(
			"FIELDS" => array(
				'ACCEPTED'
			),
			'FILTER' => array(
				'TEACHERID' => $this->id
			),
			'JOIN'	 => array(
				array(
					'TYPE'	 => 'inner',
					'TABLE'	 => 'users',
					'ON'	 => array(
						'ID' => 'STUDENTID'
					),
					'PARENT' => 'friends',
					'FIELDS' => array(
						'FIRSTNAME',
						'SECONDNAME',
						'ID',
						'LASTNAME'
					)
				)
			)
		));
		$arResult = array();
		if ($rsStudentsList === false)
		{
			//@todo добавить обработку ошибок
			return array();
		}
		while ($arStudent = $rsStudentsList->fetch_assoc())
		{
			$arResult[] = $arStudent;
		}
		return $arResult;
	}

}
