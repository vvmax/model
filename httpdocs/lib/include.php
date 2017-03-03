<?php
/**
 * Общий файл 
 */
/**
 * Функция автозагрузки классов
 * @param string $name имя класса
 */
session_start();
ob_start();
function __autoload($name) {
    $name = strtolower(str_replace('_','/',$name));
    $path = realpath(dirname(__FILE__))."/$name.php";
    if (file_exists($path)) require_once $path;
}
$user= new Utils_User();
