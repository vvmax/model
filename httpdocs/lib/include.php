<?php
/**
 * Общий файл
 */
session_start();
ob_start();
/**
 * Функция автозагрузки классов
 * @param string $name имя класса
 */
function __autoload($name)
{
    $name = strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $name));
    $path = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "$name.php";
    if (file_exists($path)) require_once $path;
}

$user = new \Maxed\Utils\User();
