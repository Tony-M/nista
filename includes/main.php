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


$SYS['TPL_DIR'] = ROOT_WAY.'includes/tpl/';
define('TPL_DIR', $SYS['TPL_DIR']);

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

if($DOCUMENT['partition']['template']!="")
{
	$LAYOUT_TEMPLATE = $DOCUMENT['partition']['template'];
}

if($partition->is_detected_target_partition())
{
	$DOCUMENT['content'] =  $DOCUMENT['partition'];
}
$DOCUMENT['title'] = $DOCUMENT['partition']['title'];
$DOCUMENT['meta']['keywords'] = $DOCUMENT['partition']['meta_keyword'];
$DOCUMENT['meta']['description'] = $DOCUMENT['partition']['meta_description'];

//-------------------------------------------------------------------------
//***************** загрузка конфигурации шаблонов ************************
if(!class_exists("template_manager"))
	die("no template configuration manager.");
	
$template_obj = new template_manager();
if($template_obj->set_layout($DOCUMENT['partition']['template']))
{
	$DOCUMENT['zone_list'] = $template_obj->get_layout_zonez();
}
else 
	die("no template");
//-------------------------------------------------------------------------
//******************** построени структуры меню ***************************	
if(!class_exists("menu_manager"))
	die("no menu manager");
	
$menu_manager_obj = new menu_manager(&$template_obj);
if($menu_manager_obj->set_partition_id($DOCUMENT['partition']['id']))
{
	$DOCUMENT['zone_content']=$menu_manager_obj->get_zones_content();
}
//-------------------------------------------------------------------------
//***************** поиск целевого объекта ********************************

if(!$partition->is_detected_target_partition())
{
	if($tmp = $partition->get_target_object())
	{
		if($tmp_mod = $nista->get_module_by_id($tmp['modid']))
		{
			if(class_exists($tmp_mod['mod_name']))
			{
				$class_name = $tmp_mod['mod_name'];
				$obj = new $class_name();
				$DOCUMENT['content'] = $obj->api_get_object(array("data"=>std_lib::POST_GET('data')));
				if($DOCUMENT['content'])
				{
					$DOCUMENT['title'] = $DOCUMENT['content']['title'];
					$DOCUMENT['meta']['keywords'] = $DOCUMENT['content']['meta_keyword'];
					$DOCUMENT['meta']['description'] = $DOCUMENT['content']['meta_description'];
				}
			}
		}
	}
}

//******************* Подключение CSS файлов стилей ***********************
$DOCUMENT['css'] = std_lib::get_site_css();
//-------------------------------------------------------------------------
//**************** Подключение JavaScript файлов стилей *******************
$DOCUMENT['js'] = std_lib::get_site_js();
//-------------------------------------------------------------------------
$nista->debug($DOCUMENT);
//$nista->debug($SYS);

// указываем путь к директории Smarty
define('SMARTY_DIR', ROOT_WAY.'includes/lib/smarty/');
require_once(SMARTY_DIR.'Smarty.class.php');


$tpl = new Smarty();
$tpl->template_dir= TPL_DIR;
$tpl->compile_dir= TPL_DIR.'tpl_c/';
$tpl->config_dir= TPL_DIR.'configs/';
$tpl->cache_dir= TPL_DIR.'cache/';
$tpl->plugins_dir[] = ROOT_WAY.'includes/lib/nista_smarty_plugins'; 


$tpl->assign('DOCUMENT', $DOCUMENT);

if(!isset($LAYOUT_TEMPLATE ) || ($LAYOUT_TEMPLATE == ""))$LAYOUT_TEMPLATE ="index.tpl";


$LAYOUT = "sys_layout.tpl"; // глобальный неизменный шаблон. всё остальное - только body
$tpl->assign('LAYOUT_TEMPLATE', $LAYOUT_TEMPLATE);
$tpl->display($LAYOUT);

?>