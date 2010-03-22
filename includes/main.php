<?php
define('IN_SITE', true);

//****************** system variables **************************
$SYS = array(); 		// массив системных настроек и переменных
$DOCUMENT = array(); 	// данные всей страницы, для работы с пользователем
$ROOT_WAY = "";			// путь к корню сайта
$ROOT_WAY = str_repeat("../", substr_count($URL_PARAMETERS['dirname'], "/"));
$USER = array();
if($URL_PARAMETERS['dirname']=="/")$ROOT_WAY="";
define('ROOT_WAY', $ROOT_WAY);
//---------------------------
//echo $ROOT_WAY;
//определяем адрес, который запрашивает клиент
$SYS['HTTP_HOST'] = "http://".$_SERVER['HTTP_HOST'];
$SYS['PHP_SELF'] = $_SERVER['PHP_SELF'];
$SYS['DIR_NAME'] = dirname($_SERVER['PHP_SELF']);

$DOCUMENT['REFERER'] = $_SERVER['HTTP_REFERER'];
if(trim($DOCUMENT['REFERER'])=="")$DOCUMENT['REFERER'] = "index.php";
//-------------------------------------------------------------------------
//**************** подключаем основные библиотеки **********************
define('LIB_DIR', ROOT_WAY."includes/lib/");

$dir = opendir(LIB_DIR);
$SYS['php_lib'] = array()   ;
while (false !==($file = readdir($dir)))
{
    $file;

    if(eregi("[a-zA-Z0-9_@\.\-]+\.(php)", $file))
    {
    	if(file_exists(LIB_DIR.$file))
    	{
    		require_once(LIB_DIR.$file);
    		$SYS['php_lib'][count($SYS['php_lib'])] = LIB_DIR.$file;
    	}
    }
    $SYS['php_lib'] = array_unique($SYS['php_lib']);
}
closedir($dir);
//-------------------------------------------------------------------------
//****************   подключаем конфиги  **********************

define('ETC_DIR', ROOT_WAY."includes/etc/");
$dir = opendir(ETC_DIR);
$SYS['php_conf'] = array()   ;
while (false !==($file = readdir($dir)))
{
    $file;

    if(eregi("[a-zA-Z0-9_@\.\-]+.(php)", $file))
    {
    	if(file_exists(ETC_DIR.$file))
    	{
    		require_once(ETC_DIR.$file);
    		$SYS['php_conf'][count($SYS['php_conf'])] = ETC_DIR.$file;
    	}
    }
    $SYS['php_conf'] = array_unique($SYS['php_conf']);
}
closedir($dir);

//-------------------------------------------------------------------------
//*********** устанавливаем коннект с сервером баз данных ****************

$SYS['db_connection_id'] = func_lib_mysql::db_connect();
if(!$SYS['db_connection_id']) die ("No database connection"); // сюда впендюрить генерацию сообщения и посыл страницы с извинениями по шаблону
mysql_query("SET NAMES 'UTF8'");
//-------------------------------------------------------------------------
if(class_exists('nista_manager'))
{
	$nista = new nista_manager();
}
else 
	die("No main lib.");
	
//****************** подключение библиотек модулей *************	
$SYS['mod_lib'] = $nista->get_module_lib_way();

$n = count($SYS['mod_lib']);

for($i=0;$i<$n; $i++)
{
	$SYS['php_mod_lib'][$i]['mod_lib'] = $SYS['mod_lib'][$i];
	$SYS['php_mod_lib'][$i]['php_lib'] =array();
	$dir = opendir(ROOT_WAY."includes/".$SYS['mod_lib'][$i]);
	
	while (false !==($file = readdir($dir)))
	{
	    $file;
	
	    if(eregi("[a-zA-Z0-9_@\.\-]+\.(php)", $file))
	    {
	    	if(file_exists(ROOT_WAY."includes/".$SYS['mod_lib'][$i].$file))
	    	{
	    		require_once(ROOT_WAY."includes/".$SYS['mod_lib'][$i].$file);
	    		$SYS['php_mod_lib'][$i]['php_lib'][count($SYS['php_mod_lib'][$i]['php_lib'])] = ROOT_WAY."includes/".$SYS['mod_lib'][$i].$file;
	    	}
	    }
	    $SYS['php_mod_lib'][$i]['php_lib'] = array_unique($SYS['php_mod_lib'][$i]['php_lib']);
	}
	closedir($dir);
}
$SYS['mod_lib'] = $SYS['php_mod_lib'];
unset($SYS['php_mod_lib']);
//-------------------------------------------------------------------------
//******************** определение раздела сайта **************************
$partition = new partition_manager();
$DOCUMENT['partition'] = $partition->detect_partition();
//-------------------------------------------------------------------------

if(!$partition->is_detected_target_partition())
{
	if($tmp = $partition->get_target_object())
	{
		if($tmp_mod = $nista->get_module_by_id($tmp['modid']))
		{
			$nista->debug($tmp_mod);
		}
	}
}

$nista->debug($DOCUMENT);
$nista->debug($SYS);



?>