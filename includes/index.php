<?php
header ("Content-Type: text/html; charset=utf-8\n\n");
define('IN_SITE', true);
$URL = $_SERVER['PHP_SELF'];
$URL_PARAMETERS = pathinfo($URL);

$slash_num =  substr_count($URL_PARAMETERS['dirname'], "/");
if($URL_PARAMETERS['dirname']=="/")$slash_num=0;
$main_way = str_repeat("../",$slash_num)."includes/main.php";

if(file_exists($main_way))
	require_once($main_way);
else 	
	die("Sorry, i can not  find input point");
?>