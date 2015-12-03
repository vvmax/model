<?php
/**
 * Категории модели
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.10.14
 */
class Utils_User {
    private $userId;
    public function __construct() {
	if(empty($_COOKIE['USERHASH']))
	{
	    srand();
	    $this->userId=md5(rand(0, 999999));
	    setcookie('USERHASH',$this->userId,time()+60*60*24*30*12,'/');
	}
	else
	{
	    $this->userId=$_COOKIE['USERHASH'];	    
	}
    }
}
