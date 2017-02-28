<?php

/**
 * Составленная схема
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.10.14
 * 
 *  @todo - Центрирование надписей
 *  @todo - В шахматном порядке
 */
class Utils_Image
{

	/**
	 * Ширина страницы
	 * @var integer
	 */
	static $pageWidth = 3507;

	/**
	 * Высота страницы
	 * @var integer
	 */
	static $pageHeight = 2480;

	/**
	 * Стандартный отступ
	 * @var integer
	 */
	static $margin = 100;

	/**
	 * Стандартный цвет фона
	 * @var array
	 */
	static $colorBackG = array(255, 255, 255);

	/**
	 * Ширина элипса 
	 * @var integer
	 */
	static $ellipseWidth = 0;

	/**
	 * Выстоа элипса
	 * @var integer
	 */
	static $ellipseHeight = 0;

	/**
	 * Радиус круга элемента
	 * @var integer
	 */
	static $roundSmall = 10;

	/**
	 * Радиус круга категории
	 * @var integer
	 */
	static $roundBig = 70;

	/**
	 * Коэффициент масштабирования
	 * @var real
	 */
	static $k = 0.25;

	/**
	 * Шрифт текста
	 * @var string
	 */
	static $font = 'calibri.ttf';

	/**
	 * Размер текста заголовка
	 * @var integer
	 */
	static $headTextSize = 40;

	/**
	 * Размер текста категории
	 * @var integer
	 */
	static $groupTextSize = 30;

	/**
	 * Размер текста элемента
	 * @var integer
	 */
	static $elementsTextSize = 20;

	/**
	 * Стандартный размер текста
	 * @var integer
	 */
	static $defaultFontSize = 25;

	/**
	 * Стандартный цвет текста
	 * @var array
	 */
	static $defaultFontColor = array(0, 0, 0);

	/**
	 * Преобразование Х координаты из одной системы координат в другую
	 * @param integer $value Х координата относительно центра схемы
	 * @return integer Х координата относительно начала картинки
	 */
	static function calcX($value)
	{
		return self::$pageWidth / 2 + $value;
	}

	/**
	 * Преобразование У координаты из одной системы координат в другую
	 * @param integer $value У координата относительно центра схемы
	 * @return integer У координата относительно начала картинки
	 */
	static function calcY($value)
	{
		return self::$pageHeight / 2 - $value;
	}

	/**
	 * Вывод текста на картинку
	 * @param type $image 
	 * @param type $xc
	 * @param type $yc
	 * @param string $text
	 * @param type $fontColor
	 * @param type $arOptions
	 */
	static function writeText($image, $xc, $yc, $text, $fontColor, $arOptions = array())
	{
		if (empty($text))
		{
			$text = '________';
		};
		$fullFont = $_SERVER['DOCUMENT_ROOT'] . '/lib/fonts/' . self::$font;
		$fontSize = (isset($arOptions['FONTSIZE']) ? $arOptions['FONTSIZE'] : self::$defaultFontSize);
		$arSizes = imagettfbbox($fontSize, 0, $fullFont, $text);
		$texWidht = $arSizes[2] - $arSizes[0];
		$textHeight = $arSizes[5] - $arSizes[1];
		$x = self::calcX($xc - $texWidht / 2);
		$y = self::calcY($yc + ($arSizes[5] - $arSizes[1]) / 2);
		if (isset($arOptions['ADDTEXT']))
		{
			$y+=$textHeight / 2;
		}
		if ($x < 0)
			$x = 0;
		if ($x + $texWidht > self::$pageWidth)
			$x = self::$pageWidth - $texWidht;
		if ($y - $textHeight < 0)
			$y = $textHeight;
		if ($y > self::$pageHeight)
			$y = self::$pageHeight;
		if (isset($arOptions['OFFSET_YZERO']) && intval($yc) == 0)
			$y-=$arOptions['OFFSET_YZERO'];
		if (isset($arOptions['ADDTEXT']))
		{
			$arSizes2 = imagettfbbox($fontSize, 0, $fullFont, $arOptions['ADDTEXT']);
			$textHeight2 = $arSizes2[5] - $arSizes2[1];
			$x2 = $x;
			$y2 = $y - $textHeight2 + 3;
			if ($y2 > self::$pageHeight)
			{
				$y2 = self::$pageHeight;
				$y = self::$pageHeight - $textHeight2 + 3;
			}
			imagettftext($image, $fontSize, 0, $x2, $y2, $fontColor, $fullFont, $arOptions['ADDTEXT']);
		}
		imagettftext($image, $fontSize, 0, $x, $y, $fontColor, $fullFont, $text);
	}

	static function getImage($arData)
	{
		$fullFont = $_SERVER['DOCUMENT_ROOT'] . '/lib/fonts/' . self::$font;
		$countGroup = count($arData['CATEGORIES']);
		$image = @imagecreate(self::$pageWidth, self::$pageHeight);
		$backgroung_color = imagecolorallocate($image, self::$colorBackG[0], self::$colorBackG[1], self::$colorBackG[2]);
		$text_color = imagecolorallocate($image, 0, 0, 0);
		self::$ellipseWidth = (self::$pageWidth / 2 - self::$margin) * self::$k;
		self::$ellipseHeight = (self::$pageHeight / 2 - self::$margin) * self::$k;
		imageellipse($image, self::calcX(0), self::calcY(0), self::$ellipseWidth, self::$ellipseHeight, $text_color);
		$angle = 360 / $countGroup;
		self::writeText($image, 0, 0, $arData['ANSWER']['DATA']['OBJECT'], $text_color);
		$i = 0;
		foreach ($arData['CATEGORIES'] as $categoryId => $arCategory)
		{
			$x = (self::$pageWidth / 2 - self::$margin) * cos(deg2rad($i * $angle));
			$y = (self::$pageHeight / 2 - self::$margin) * sin(deg2rad($i * $angle));
			$xm = (self::$pageWidth / 2 - self::$margin + self::$roundBig / 2) * cos(deg2rad($i * $angle));
			$ym = (self::$pageHeight / 2 - self::$margin + self::$roundBig / 2) * sin(deg2rad($i * $angle));
			$x0 = (self::$ellipseWidth / 2) * cos(deg2rad($i * $angle));
			$y0 = (self::$ellipseHeight / 2) * sin(deg2rad($i * $angle));
			imageline($image, self::calcX($x0), self::calcY($y0), self::calcX($x), self::calcY($y), $text_color);
			$countElements = count($arCategory['ELEMENTS']);
			$deltaX = ($x - $x0) / ($countElements + 1);
			imageellipse($image, self::calcX($xm), self::calcY($ym), self::$roundBig, self::$roundBig, $text_color);
			self::writeText(
					$image, $xm, $ym, $arCategory['NAME'], $text_color, array(
				'OFFSET_YZERO'	 => self::$roundBig,
				'FONTSIZE'		 => self::$groupTextSize
					)
			);
			for ($u = 1; $u <= $countElements; ++$u)
			{
				$coordX = $x0 + $u * $deltaX;
				$coordY = (($y - $y0) / ($x - $x0)) * ($coordX - $x0) + $y0;
				imageellipse($image, self::calcX($coordX), self::calcY($coordY), self::$roundSmall, self::$roundSmall, $text_color);
				$text = $arData['CATEGORIES'][$categoryId]['ELEMENTS'][$u - 1]['NAME'];
				self::writeText($image, $coordX, $coordY, $text, $text_color, array(
					'OFFSET_YZERO'	 => (intval($coordY) === 0 ) ? self::$roundSmall * 0.5 : self::$roundSmall * 2,
					'FONTSIZE'		 => self::$elementsTextSize,
					'ADDTEXT'		 => $arData['ANSWER']['DATA']['ELEMENTS'][$arCategory['ELEMENTS'][$u - 1]['ID']]
				));
			}
			$i++;
		}
		ob_end_clean();
		Header('Content-type: image/png');
		imagepng($image);
		ob_end_flush();
	}

}
