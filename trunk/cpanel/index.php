<?php
header ("Content-Type: text/html; charset=utf-8\n\n");
if(!session_id())session_start();

define('IN_NISTA', true);

//****************** system variables **************************
$SYS = array(); 		// массив системных настроек и переменных
$DOCUMENT = array(); 	// данные всей страницы, для работы с пользователем
$ROOT_WAY = "";			// путь к корню сайта
$ADMIN_WAY = "";		// путь к административной части
//--------------------------------------------------------------



//определяем адрес, который запрашивает клиент
$SYS['HTTP_HOST'] = "http://".$_SERVER['HTTP_HOST'];

// определяем путь к корню сайта
$ROOT_WAY = str_repeat ("../", substr_count($_SERVER['PHP_SELF'], "/")-1);
define('ROOT_WAY',$ROOT_WAY);  
$SYS['ROOT_WAY'] = ROOT_WAY;

// определяем путь к административной части
preg_match("/^[\/]+[a-zA-Z0-9_]+/", $_SERVER['PHP_SELF'], $matches);
$ADMIN_WAY = $matches[0]."/";
define('ADMIN_WAY',$ADMIN_WAY); 
$SYS['ADMIN_WAY'] = ADMIN_WAY;

$DOCUMENT['SERVER_URL'] = 'http://'.$_SERVER['HTTP_HOST'];
$DOCUMENT['NISTA_URL'] = $DOCUMENT['SERVER_URL'].ADMIN_WAY;

$DOCUMENT['REFERER'] = $_SERVER['HTTP_REFERER'];
if(trim($DOCUMENT['REFERER'])=="")$DOCUMENT['REFERER'] = "index.php";

//****** подцепляем базовый набор конфигурационных файлов ******
if(file_exists('etc/config.php'))
{
	require_once('etc/config.php');
	$SYS['php_conf'][count($SYS['php_conf'])] = "etc/config.php";
}
if(file_exists('etc/db_connection.php'))
{
	require_once('etc/db_connection.php');
	$SYS['php_conf'][count($SYS['php_conf'])] = "etc/db_connection.php";
}

if(file_exists('etc/forbidden_dir.php'))
{
	require_once('etc/forbidden_dir.php');
	$SYS['php_conf'][count($SYS['php_conf'])] = "etc/forbidden_dir.php";
}
//--------------------------------------------------------------

$DOCUMENT['TEMPLATE_IMG_DIR_LINK'] = $SYS['HTTP_HOST'].$SYS['ADMIN_WAY'].$SYS['TPL_DIR']."img/";

// Подключаем все прикладные библиотеки требуемые для обеспечения работы модулей
$dir = opendir(LIB_DIR);
    
if(file_exists(LIB_DIR."filter_base_validation_lib.php"))
{
	require_once(LIB_DIR."filter_base_validation_lib.php"); // загрузка базового класса системы
	$SYS['php_lib'][count($SYS['php_lib'])] = LIB_DIR."filter_base_validation_lib.php";
	
}

if(file_exists($SYS['ROOT_WAY']."includes/lib/spyc.php"))
{
	require_once($SYS['ROOT_WAY']."includes/lib/spyc.php"); // загрузка базового класса системы
	$SYS['php_lib'][count($SYS['php_lib'])] =$SYS['ROOT_WAY']."includes/lib/spyc.php";
	
}
    
while (false !==($file = readdir($dir)))
{
    $file;

    if(eregi("[a-zA-Z0-9_@\.\-]+(_lib).(php)", $file))
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


// Подключаем все JavaScript библиотеки требуемые для обеспечения работы модулей
$dir = opendir(JS_DIR);

//$SYS_JS_LIB_ARRAY = array(); // системная переменная хранящая все js файлы, которые надо подгрузить
while (false !==($file = readdir($dir)))
{
	if(eregi("[a-zA-Z0-9_@\.\-]+.(js)$", $file))
    {
    	$DOCUMENT['js'][] =  $DOCUMENT['NISTA_URL'].JS_DIR.$file;
    }
}
closedir($dir);


// Подключаем все css требуемые для обеспечения работы модулей
$dir = opendir(CSS_DIR);
while (false !==($file = readdir($dir)))
{
	if(eregi("[a-zA-Z0-9_@\.\-]+.(css)$", $file))
    {
    	$DOCUMENT['css'][] =  $DOCUMENT['NISTA_URL'].CSS_DIR.$file;
    }
}
closedir($dir);

unset($dir);


//
// Set p
//
if( isset( $HTTP_POST_VARS['p'] ) || isset( $HTTP_GET_VARS['p'] ) )
{
        $p = ( isset($HTTP_POST_VARS['p']) ) ? $HTTP_POST_VARS['p'] : $HTTP_GET_VARS['p'];
}
else
{
        $p = '';
}
// указываем путь к директории Smarty
define('SMARTY_DIR', ROOT_WAY.'includes/lib/smarty/');
require_once(SMARTY_DIR.'Smarty.class.php');


$tpl = new Smarty();
$tpl->template_dir= TPL_DIR;
$tpl->compile_dir= TPL_DIR.'tpl_c/';
$tpl->config_dir= TPL_DIR.'configs/';
$tpl->cache_dir= TPL_DIR.'cache/';

$tpl->assign('SYS' , $SYS);
$tpl->plugins_dir[] = '../includes/lib/nista_smarty_plugins'; 

//*********** устанавливаем коннект с сервером баз данных ****************
if(file_exists(LIB_DIR.'func_lib_mysql.php'))
{
	require_once(LIB_DIR.'func_lib_mysql.php');
	$SYS['db_lib'][count($SYS['db_lib'])] = LIB_DIR.'func_lib_mysql.php';
}

$SYS['db_connection_id'] = func_lib_mysql::db_connect();
if(!$SYS['db_connection_id']) die ("No database connection"); // сюда впендюрить генерацию сообщения и посыл страницы с извинениями по шаблону
mysql_query("SET NAMES 'UTF8'");
//-------------------------------------------------------------------------

//******************* Авторизация пользователя в системе *****************

$user_obj = new user_class();
$MY_USER_DATA = $user_obj->check_valid_user();
if($MY_USER_DATA == false)
{
	$_SESSION = array();
	@session_destroy();
	if(!$user_obj->is_empty($_POST['lgn']) && !$user_obj->is_empty($_POST['pswd']))
	{
		
		$user_obj->set_login($_POST['lgn']);
		$user_obj->set_password($_POST['pswd']);
		
		if($user_obj->login())
		{
			header("Location: index.php");
			exit;
		}
		else 
		{
			header("Location: index.php?msg=lgn1");
			exit;
		}
	}
	
	$tpl->assign('DOCUMENT', $DOCUMENT);
	$tpl->display('login.tpl');
	exit;
}
//$user_obj->debug($MY_USER_DATA);

//************************** Подключаем библиотеки модулей ***************


$dir_elementes = scandir(MOD_DIR);
$n = count($dir_elementes);
for($i=0; $i<$n; $i++)
{
	if(($dir_elementes[$i] != '.') && ($dir_elementes[$i] != '..'))
	{
		if(is_dir(MOD_DIR.$dir_elementes[$i]))
		{
			if(is_dir(MOD_DIR.$dir_elementes[$i].'/lib'))
			{
				$dir = opendir(MOD_DIR.$dir_elementes[$i].'/lib');
				
				while (false !==($file = readdir($dir)))
				{
				    $file;
				
				    if(eregi("[a-zA-Z0-9_@\.\-]+(_lib).(php)", $file))
				    {
				    	if(file_exists(MOD_DIR.$dir_elementes[$i].'/lib/'.$file))
				    	{
				    		require_once(MOD_DIR.$dir_elementes[$i].'/lib/'.$file);
				    		$SYS['php_lib'][count($SYS['php_lib'])] = MOD_DIR.$dir_elementes[$i].'/lib/'.$file;
				    	}
				    }
				    $SYS['php_lib'] = array_unique($SYS['php_lib']);
				}
				closedir($dir);
			}
		}
	}
}

print_r($files1);

// **********проверяем необходимость отображения системного сообщения********
$msg =  stripcslashes(trim(rawurldecode(trim($_GET['msg']))));
if($msg != "") $DOCUMENT['MSG'] = $msg;
		
$err_msg = stripcslashes(trim(rawurldecode(trim($_GET['errmsg']))));
if($err_msg != "") $DOCUMENT['ERR_MSG'] = $err_msg;

//********** создание основного объекта системы Night Stalker *************
if(!class_exists('nista'))
{
	//
	//
	//
	//Сюда навпихать гору всяких обоснований почему ядра нет и нифига не работает
	//
	die('Kernel panic. No kernel library');
	//
	//
}
$nista = new nista($SYS);


// создаём все подписи на всех языках			
$I18N = $nista->generate_i18n_data();
$DOCUMENT['i18n'] = $I18N;

//list($KERNELL_VERSION['version'],$KERNELL_VERSION['version_type']) = $nista2->get_kernell_info();
$SYS['kernel_version']  = $nista->get_kernell_info();
$DOCUMENT['kernel_version'] = $SYS['kernel_version'];


if(!empty($p))
{
	$Mod_Way = $nista->get_proper_module_way($p);
	if(file_exists($Mod_Way))require_once($Mod_Way);
}
//-------------------------------------------------------------------------













//****************** настройка главного меню CMS **************************
$myDirPath = "lib/phplayersmenu-3.2.0/";
$myWwwPath = "";//"lib/phplayersmenu-3.2.0";//$DOCUMENT['NISTA_URL'];//."lib/phplayersmenu-3.2.0/";

require_once ('lib/phplayersmenu-3.2.0/lib/PHPLIB.php');
require_once  ('lib/phplayersmenu-3.2.0/lib/layersmenu-common.inc.php');
require_once ('lib/phplayersmenu-3.2.0/lib/layersmenu.inc.php');

$mid = new LayersMenu(0, 2, 1, 1);	// Keramik-like


//$mid->setLibjsdir('lib/phplayersmenu-3.2.0/libjs/');

/* TO USE RELATIVE PATHS: */
$mid->setDirroot($myDirPath);
$mid->setLibjsdir('lib/phplayersmenu-3.2.0/libjs/');
$mid->setImgdir('lib/phplayersmenu-3.2.0/menuimages/');
$mid->setImgwww('lib/phplayersmenu-3.2.0/menuimages/');
$mid->setIcondir('lib/phplayersmenu-3.2.0/menuicons/');
$mid->setIconwww('lib/phplayersmenu-3.2.0/menuicons/');
/* either: */
$mid->setTpldir('lib/phplayersmenu-3.2.0/templates/');
$mid->setHorizontalMenuTpl('lib/phplayersmenu-3.2.0/templates/layersmenu-horizontal_menu-keramik.ihtml');
$mid->setSubMenuTpl('lib/phplayersmenu-3.2.0/templates/layersmenu-sub_menu-keramik.ihtml');
/* or: (disregarding the tpldir) */
//$mid->setHorizontalMenuTpl('templates/layersmenu-horizontal_menu.ihtml');
//$mid->setSubMenuTpl('templates/layersmenu-sub_menu.ihtml');

$mid->setMenuStructureFile($myDirPath . 'layersmenu-horizontal-1.txt');
$mid->setIconsize(16, 16);
$mid->parseStructureForMenu('hormenu1');
$mid->newHorizontalMenu('hormenu1');

$b = $mid->getHeader();
$a = $mid->getMenu('hormenu1');
$tpl->assign('MENU', $a);
$tpl->assign("MENU_HEADER", $b);
$footer = $mid->getFooter();
$tpl->assign("MENU_FOOTER", $footer);
//-------------------------------------------------------------------------


$tpl->assign('DOCUMENT', $DOCUMENT);
$tpl->assign('I_AM', $MY_USER_DATA);

if(!isset($layout_template) || ($layout_template == ""))$layout_template="index.tpl";
$tpl->display($layout_template);
?>