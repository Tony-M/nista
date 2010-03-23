<?php
  
/** 
 * Smarty plugin 
 * @package Smarty 
 * @subpackage plugins 
 */  
  
/** 
 * Smarty {html_insert_css} plugin 
 * 
 * Type:     function 
 * Name:     html_insert_css 
 * Purpose:  outputs css including section
 * @author Morozov A.A. <morozov_aa at tonymstudio dot ru> 
 * @param array 
 * @param Smarty 
 * @return string 
 */  

function smarty_function_html_insert_css($params, &$smarty) {  
    $css = $smarty->get_template_vars("DOCUMENT");
    $css = $css['css'];
	$n = count($css);
	for($i=0;$i<$n;$i++)
		return  "<link href=\"".$css[$i]."\" rel=\"stylesheet\" type=\"text/css\" />";
} 
?>