<?php

/**
 * Полезные функции
 *
 * @author Maxim Vorobyev
 * @version 1.0
 * @changed 2015.12.05
 *
*/
class Utils_Util {
	const version='v 3.0';
    static function printDebug($value)
    {
	print "<pre>";
	if(is_array($value) || is_object($value))
	{
	    print_r($value);
        }
	else
	{
	    print $value;
	}
	print "\n----------\n";
	$arLog=  debug_backtrace();
	foreach ($arLog as $arRow)
	{
	    print "{$arRow['file']} [{$arRow['line']}] {$arRow['class']}{$arRow['type']}{$arRow['function']}\n";
	}
	print "</pre>"; 
    }
    
}
