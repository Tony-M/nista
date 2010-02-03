it works
<?php
define('IN_SITE', true);

//****************** system variables **************************
$SYS = array(); 		// массив системных настроек и переменных
$DOCUMENT = array(); 	// данные всей страницы, для работы с пользователем
$ROOT_WAY = "";			// путь к корню сайта
$ROOT_WAY = str_repeat("../", substr_count($URL_PARAMETERS['dirname'], "/"));
if($URL_PARAMETERS['dirname']=="/")$ROOT_WAY="";
//---------------------------
echo $ROOT_WAY;
//определяем адрес, который запрашивает клиент
$SYS['HTTP_HOST'] = "http://".$_SERVER['HTTP_HOST'];

$DOCUMENT['REFERER'] = $_SERVER['HTTP_REFERER'];
if(trim($DOCUMENT['REFERER'])=="")$DOCUMENT['REFERER'] = "index.php";



?>