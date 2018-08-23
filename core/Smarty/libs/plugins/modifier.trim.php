<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsModifier
 */

/**
 * Smarty modifier trim to string 
 * 
 * Type:     modifier<br>
 * Name:     replace<br>
 * Purpose:  simple search/replace
 *  
 * @author Reynier Reytor 
 * @param string $string  input string 
 * @return string 
 */
function smarty_modifier_trim($string)
{   
    return trim($string);
} 

?>