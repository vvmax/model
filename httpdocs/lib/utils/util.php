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
    static function printDebug($value)
    {
	print "<pre>";
	if(is_array($value))
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
