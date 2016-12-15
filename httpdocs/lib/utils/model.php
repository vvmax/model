<?php

/**
 * Обработка модели
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.10.14
 */
class Utils_Model
{

	static function getFillModel($answerId)
	{
		$obTableAnsweraccess = new Data_Answeraccess();
		$rsAccess = $obTableAnsweraccess->select(array(
			'FILTER' => array(
				'ANSWERID' => $answerId
			),
			'FIELDS' => array(
				'USERID', 'TEACHERID'
			)
		));
		$answerExist = false;
		$CanLook = false;
		while ($arAccess = $rsAccess->fetch_assoc())
		{
			if (Utils_Currentuser::getInstance()->GetId() == $arAccess['USERID'] ||
					Utils_Currentuser::getInstance()->GetId() == $arAccess['TEACHERID'])
			{
				$CanLook = true;
				break;
			}
			$answerExist = true;
		}

		//hhkhkh
		/* 		if ($answerExist === false)
		  {


		  }
		 * 
		 */
		$obTableAnswer = new Data_Answer();
		$rsAnswer = $obTableAnswer->select(
				array(
					'FIELDS' => array('MODELID', 'ANSWER', 'USERID'),
					'FILTER' => array('ID' => $answerId)
		));
		if ($rsAnswer === FALSE)
		{
			return FALSE;
		}
		$arAnswer = $rsAnswer->fetch_assoc();
		if ($arAnswer == false ||
				($CanLook === false && Utils_Currentuser::getInstance()->GetId() != $arAnswer['USERID'] ))
		{
			ob_end_clean();
			header('Location: /models.php');
			ob_end_flush();
			exit();
		}
		$arAnswer['DATA'] = unserialize($arAnswer['ANSWER']);
		if (!isset($arAnswer['MODELID']) || intval($arAnswer['MODELID']) < 1)
		{
			ob_end_clean();
			header('Location: /models.php');
			ob_end_flush();
			exit();
		}
		$obTableModel = new Data_Model();
		$rsModels = $obTableModel->select(array(
			'FIELDS' => array('NAME', 'OBJECT'),
			"FILTER" => array(
				'ID' => $arAnswer['MODELID']
		)));
		$arModel = $rsModels->fetch_assoc();
		if (!$arModel)
		{
			ob_end_clean();
			header('Location: /models.php');
			ob_end_flush();
			exit();
		}
		$obTableCategory = new Data_Category();
		$rsCategory = $obTableCategory->select(array(
			'FIELDS' => array('NAME', 'ID'),
			'FILTER' => array(
				'MODELID' => $arAnswer['MODELID']
		)));
		$arCategories = array();
		while ($arRow = $rsCategory->fetch_assoc())
		{
			$arRow['ELEMENTS'] = array();
			$arCategories[$arRow['ID']] = $arRow;
		}
		$obTableElement = new Data_Element();
		$rsElenent = $obTableElement->select(array(
			'FILTER' => array(
				'MODELID' => $arAnswer['MODELID']
		)));
		while ($arRow = $rsElenent->fetch_assoc())
		{
			$arCategories[$arRow['CATEGORYID']]['ELEMENTS'][] = $arRow;
		}
		return array(
			"ANSWER"	 => $arAnswer,
			"MODEL"		 => $arModel,
			"CATEGORIES" => $arCategories
		);
	}

	static function getUsersFillModel($answerId, $id)
	{
		$obTableAnsweraccess = new Data_Answeraccess();
		$rsAccess = $obTableAnsweraccess->select(array(
			'FILTER' => array(
				'ANSWERID' => $answerId
			),
			'FIELDS' => array(
				'USERID', 'TEACHERID'
			)
		));
		$answerExist = false;
		$CanLook = false;
		while ($arAccess = $rsAccess->fetch_assoc())
		{
			$CanLook = true;
			$answerExist = true;
		}

		//hhkhkh
		/* 		if ($answerExist === false)
		  {


		  }
		 * 
		 */
		$obTableAnswer = new Data_Answer();
		$rsAnswer = $obTableAnswer->select(
				array(
					'FIELDS' => array('MODELID', 'ANSWER', 'USERID'),
					'FILTER' => array('ID' => $answerId)
		));
		if ($rsAnswer === FALSE)
		{
			return FALSE;
		}
		$arAnswer = $rsAnswer->fetch_assoc();
		if ($arAnswer == false)
		{
			ob_end_clean();
			header('Location: /models.php');
			ob_end_flush();
			exit();
		}
		$arAnswer['DATA'] = unserialize($arAnswer['ANSWER']);
		if (!isset($arAnswer['MODELID']) || intval($arAnswer['MODELID']) < 1)
		{
			ob_end_clean();
			header('Location: /models.php');
			ob_end_flush();
			exit();
		}
		$obTableModel = new Data_Model();
		$rsModels = $obTableModel->select(array(
			'FIELDS' => array('NAME', 'OBJECT'),
			"FILTER" => array(
				'ID' => $arAnswer['MODELID']
		)));
		$arModel = $rsModels->fetch_assoc();
		if (!$arModel)
		{
			ob_end_clean();
			header('Location: /models.php');
			ob_end_flush();
			exit();
		}
		$obTableCategory = new Data_Category();
		$rsCategory = $obTableCategory->select(array(
			'FIELDS' => array('NAME', 'ID'),
			'FILTER' => array(
				'MODELID' => $arAnswer['MODELID']
		)));
		$arCategories = array();
		while ($arRow = $rsCategory->fetch_assoc())
		{
			$arRow['ELEMENTS'] = array();
			$arCategories[$arRow['ID']] = $arRow;
		}
		$obTableElement = new Data_Element();
		$rsElenent = $obTableElement->select(array(
			'FILTER' => array(
				'MODELID' => $arAnswer['MODELID']
		)));
		while ($arRow = $rsElenent->fetch_assoc())
		{
			$arCategories[$arRow['CATEGORYID']]['ELEMENTS'][] = $arRow;
		}
		return array(
			"ANSWER"	 => $arAnswer,
			"MODEL"		 => $arModel,
			"CATEGORIES" => $arCategories
		);
	}

	public static function save($arData)
	{
		if (isset($arData['NAME']) && !empty($arData['NAME']))
		{
			$obTableModel = new Data_Model();

			$id = $obTableModel->insert(array(
				'FIELDS' => array(
					'NAME'			 => $arData['NAME'],
					'DESCRIPTION'	 => $arData['DESCRIPTION'],
					'OBJECT'		 => $arData['OBJECT'],
					'AUTHORID'		 => Utils_Currentuser::getInstance()->getId()
				)
			));
			if ($id === false)
			{
				return false;
			}
			$obTableCategory = new Data_Category();
			foreach ($arData['CATEGORY'] as $arCategory)
			{
				$cId = $obTableCategory->insert(array(
					'FIELDS' => array(
						'MODELID'	 => $id,
						'NAME'		 => $arCategory['NAME']
					)
				));
				if ($cId === false)
				{
					break;
				}
				$obTableElement = new Data_Element();
				if (!empty($arCategory['ELEMENT']))
				{
					foreach ($arCategory['ELEMENT'] as $element)
					{
						$obTableElement->insert(array(
							'FIELDS' => array(
								'MODELID'	 => $id,
								'CATEGORYID' => $cId,
								'NAME'		 => $element
							)
						));
					}
				}
			}
			return $id;
		}
		return false;
	}

	public function update($arOption)
	{

		if (isset($arOption['NAME']) && !empty($arOption['NAME']) && isset($arOption['ID']) && $arOption['ID'] > 0)
		{
			$obTableModel = new Data_Model();
			$rsModel = $obTableModel->select(array(
				'FIELDS' => array('ID'),
				'FILTER' => array(
					'ID'		 => $arOption['ID'],
					'AUTHORID'	 => Utils_Currentuser::getInstance()->getId())
			));
			$arModel = $rsModel->fetch_assoc();
			if (!$arModel)
			{
				return false;
			}
			$id = $obTableModel->update(array(
				'FIELDS' => array(
					'NAME'			 => $arOption['NAME'],
					'DESCRIPTION'	 => $arOption['DESCRIPTION'],
					'OBJECT'		 => $arOption['OBJECT']
				),
				'FILTER' => array(
					'ID' => $arOption['ID']
				)
					)
			);
			if ($id !== false)
			{
				$obTableElement = new Data_Element;
				$obTableCategory = new Data_Category;
				foreach ($arOption['CATEGORY'] as $key => $arCategory)
				{
					$rsCategory = $obTableCategory->select(array(
						'FIELDS' => array('ID'),
						'FILTER' => array(
							'MODELID'	 => $arOption['ID'],
							'ID'		 => $key
						)
					));
					$arCategories = $rsCategory->fetch_assoc();
					if (!$arCategories)
					{

						$res = $obTableCategory->insert(array(
							'FIELDS' => array(
								'NAME'		 => $arCategory['NAME'],
								'MODELID'	 => $arOption['ID']
							)
						));
						$catId = $res;
					}
					else
					{
						$res = $obTableCategory->update(array(
							'FIELDS' => array('NAME' => $arCategory['NAME']),
							'FILTER' => array(
								'MODELID'	 => $arOption['ID'],
								'ID'		 => $key
							)
						));
						$catId = $key;
					}
					if ($res !== false)
					{

						if (!empty($arCategory['ELEMENT']))
						{
							foreach ($arCategory['ELEMENT'] as $uKey => $Element)
							{
								$rsElement = $obTableElement->select(array(
									'FIELDS' => array('ID'),
									'FILTER' => array(
										'MODELID'	 => $arOption['ID'],
										'ID'		 => $uKey,
										'CATEGORYID' => $catId
									)
								));
								$arElements = $rsElement->fetch_assoc();
								if (!$arElements)
								{
									$obTableElement->insert(array(
										'FIELDS' => array(
											'NAME'		 => $Element,
											'MODELID'	 => $arOption['ID'],
											'CATEGORYID' => $catId
										)
									));
								}
								else
								{
									$obTableElement->update(array(
										'FIELDS' => array('NAME' => $Element),
										'FILTER' => array(
											'MODELID'	 => $arOption['ID'],
											'CATEGORYID' => $catId,
											'ID'		 => $uKey
										)
									));
								}
							}
						}
					}
				}
			}
		}
		return false;
	}

	public static function deleteCategory($arOptions)
	{
		if (!isset($arOptions['ID']) || !isset($arOptions['catid']) || intval($arOptions['ID']) <= 0 || intval($arOptions['catid']) <= 0)
		{
			return false;
		}
		$obTableModel = new Data_Model();
		$check = $obTableModel->select(array(
			'FIELDS' => array('ID'),
			'FILTER' => array(
				'ID'		 => $arOptions['ID'],
				'AUTHORID'	 => Utils_Currentuser::getInstance()->getId()
			)
		));
		if ($check->field_count !== 1)
		{
			return false;
		}
		$obTableCategory = new Data_Category();
		$res = $obTableCategory->delete(array(
			'MODELID'	 => $arOptions['ID'],
			'ID'		 => $arOptions['catid']
		));
		return ($res !== false);
	}

	public static function deleteElement($arOptions)
	{
		if (!isset($arOptions['ID']) || !isset($arOptions['catid']) || intval($arOptions['ID']) <= 0 || intval($arOptions['catid']) <= 0 || !isset($arOptions['elid']) || intval($arOptions['elid']) <= 0)
		{
			return false;
		}
		$obTableModel = new Data_Model();
		$check = $obTableModel->select(array(
			'FIELDS' => array('ID'),
			'FILTER' => array(
				'ID'		 => $arOptions['ID'],
				'AUTHORID'	 => Utils_Currentuser::getInstance()->getId()
			)
		));
		if ($check->field_count !== 1)
		{
			return false;
		}
		$obTableElement = new Data_Element();
		$res = $obTableElement->delete(array(
			'MODELID'	 => $arOptions['ID'],
			'CATEGORYID' => $arOptions['catid'],
			'ID'		 => $arOptions['elid']
		));
		return ($res !== false);
	}

	public static function deleteModel($arOptions)
	{
		return self::deleteUserModel($arOptions, Utils_Currentuser::getInstance()->getId());
	}

	public static function deleteUserModel($arOptions,$uid=0)
	{
		if (!isset($arOptions['ID']) || intval($arOptions['ID']) <= 0)
		{
			return false;
		}
		$arFilter=array(
			'ID'		 => $arOptions['ID']
		);
		if ($uid > 0) {
			$arFilter['AUTHORID'] = $uid; 
		};
		$obTableModel = new Data_Model();
		$res = $obTableModel->delete($arFilter);
		return ($res !== false);
	}

}
