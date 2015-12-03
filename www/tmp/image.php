<?php
//putenv('GDFONTPATH=' . realpath('.'));
$font = 'arial.ttf';
$im = ImageCreate(2100,1350) or die('Неьзя создать image');
$bgColor = imagecolorallocate($im, 250,250,255);
$txColor = imagecolorallocate($im,233,12,91);
ImageString($im,1,5,5,"A sumple text строка",$txColor);
//@imagettftext($im, 10, 0, 10, 10, $txColor, $font, "Текст");
$black = imagecolorallocate($im, 0, 0, 0);
// Текст надписи
$text = 'Тест...';
// Замена пути к шрифту на пользовательский
$font = 'calibri.ttf';
$tb = imagettfbbox(18, 0, 'calibri.ttf', 'Hello world!');
//imagettftext($im, 20, 0, 10, 20, $black, $font, $text);
// создаем рамку для текста
$bbox = imagettfbbox(10, 45, $font, 'Powered by PHP ' . phpversion());

// наши координаты X и Y
$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2) - 25;
$y = $bbox[1] + (imagesy($im) / 2) - ($bbox[5] / 2) - 5;

// Пишем текст
imagettftext($im, 30, 45, $x, $y, $black, $font, 'Powered by PHP ' . phpversion());

imageellipse($im,160,120,200,150,$txColor);

$width = 2100;
$height = 1350;
$w = $width-300;
$h = $height-300;
$x0=$width/2;
$y0=$height/2;
$rB=$w / 2;
$rM=$h / 2;
//$rM = 200;
$delta= 360 / 7;


//$x0 = 1000;
//$y0 = 500;
//$rM = 200;
//$delta=45;
for ($alfa=0;$alfa<360;$alfa=$alfa+$delta)
{
    $x1= intval($x0 + $rB * cos(deg2rad($alfa)));
    $y1= intval($y0 - $rM * sin(deg2rad($alfa)));
//    print "$alfa\t$x0\t$y0\t$x1\t$y1<br>";
//    print (int)$alfa." $x0 ".(int)$y0." ".(int)$x1.' '.(int)$y1."<br>";
    imageline($im, $x0, $y0, $x1, $y1, $txColor);
    imageellipse($im,$x1,$y1,40,40,$txColor);
}



header('Content-Type: image/png');
ImagePng($im);
imagedestroy($im);