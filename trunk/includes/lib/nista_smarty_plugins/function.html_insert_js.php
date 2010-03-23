<?php
  
/** 
 * Smarty plugin 
 * @package Smarty 
 * @subpackage plugins 
 */  
  
/** 
 * Smarty {html_insert_js} plugin 
 * 
 * Type:     function 
 * Name:     html_insert_js 
 * Purpose:  outputs js including section
 * @author Morozov A.A. <morozov_aa at tonymstudio dot ru> 
 * @param array 
 * @param Smarty 
 * @return string 
 */  

function smarty_function_html_insert_js($params, &$smarty) {  
    $js = $smarty->get_template_vars("DOCUMENT");
    $js = $js['js'];
	$n = count($js);
	for($i=0;$i<$n;$i++)
		return  "<script language=\"JavaScript\" type=\"text/javascript\" src=\"".$js[$i]."\"></script> ";
} 
?>