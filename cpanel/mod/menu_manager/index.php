<?php
if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");
$THIS_MODULE_DIR_NAME= "../".str_ireplace("index.php", "",$Mod_Way)."tpl/";


$MOD_TEMPALE = "mod_index.tpl"; // Шаблон модуля поумолчанию

$ThisModuleInfo = $nista->get_module_info_by_par($p); // информация о данном модуле

$SYS['mod']['settings'][$ThisModuleInfo['mod_name']]['pagination']['row_on_page'] = 20; // количество строк отображаемых на 1 страницу
$DOCUMENT['mod']['data'] = array(); // очищаем данные модуля для вывода

//****************** Подключаем JS библиотеки модуля ********************
$Mod_LIB_JS_DIR = eregi_replace("index.php", "lib/js/",$Mod_Way);
if(is_dir($Mod_LIB_JS_DIR))
{
	$dir = opendir($Mod_LIB_JS_DIR);
				
				while (false !==($file = readdir($dir)))
				{
				    $file;
				
				    if(eregi("[a-zA-Z0-9_@\.\-]+(_lib).(js)", $file))
				    {
				    	if(file_exists($Mod_LIB_JS_DIR.$file))
				    	{
				    		$DOCUMENT['js'][] = $DOCUMENT['NISTA_URL'].$Mod_LIB_JS_DIR.$file;
				    	}
				    }
				    $DOCUMENT['js'] = array_unique($DOCUMENT['js']);
				}
				closedir($dir);
}
//------------------------------------------------------------------------

//
// Set sp
//
if( isset( $HTTP_POST_VARS['sp'] ) || isset( $HTTP_GET_VARS['sp'] ) )
{
        $sp = ( isset($HTTP_POST_VARS['sp']) ) ? $HTTP_POST_VARS['sp'] : $HTTP_GET_VARS['sp'];
}
else
{
        $sp = 'ind';
}
if(!class_exists("menu_manager"))
{
	header("Location: index.php");
	exit;
}

$menu_manager_obj = new menu_manager($SYS, $nista->get_module_info_by_par("menu"), $MY_USER_DATA);

// получаем информацию о шаблонах
if(class_exists("tpl_manager"))
{
	$tpl_manager_obj = new tpl_manager($SYS, $MY_USER_DATA);
	$template_data = $tpl_manager_obj->load_config();
}


switch ($sp)
{
	default:
	case "ind":
		// проверяем необходимость отображения системного сообщения
		$msg =  stripcslashes(trim(rawurldecode(trim($_GET['msg']))));
		if($msg != "") $DOCUMENT['MSG'] = $msg;
		
		$err_msg = stripcslashes(trim(rawurldecode(trim($_GET['errmsg']))));
		if($err_msg != "") $DOCUMENT['ERR_MSG'] = $err_msg;
		
		$DOCUMENT['mod']['data']['menu_containers'] = $menu_manager_obj->get_menu_list();
		
		$DOCUMENT['mod']['data']['sub_tpl']=$THIS_MODULE_DIR_NAME."menu_list.tpl"; // шаблон списка меню
		break;
	case "add_menu": // Форма создания нового контейнера меню
		$MOD_TEMPALE = "menu_form.tpl";
		$MOD_ACTION = 'create_menu';
		
		$err_msg = stripcslashes(trim(rawurldecode(trim($_GET['errmsg']))));
		if($err_msg != "") $DOCUMENT['ERR_MSG'] = $err_msg;
		
		$DOCUMENT['title'] = stripcslashes(trim(rawurldecode(trim($_GET['title']))));
		$DOCUMENT['show_title'] = stripcslashes(trim(rawurldecode(trim($_GET['show_title']))));
		$DOCUMENT['comment'] = stripcslashes(trim(rawurldecode(trim($_GET['comment']))));
		
		$DOCUMENT['mod']['data']['template_content'] = $template_data;
		break;
	case "edit_menu":
		$MOD_TEMPALE = "menu_form.tpl";
		$MOD_ACTION = 'update_menu';
		
		$err_msg = stripcslashes(trim(rawurldecode(trim($_GET['errmsg']))));
		if($err_msg != "") $DOCUMENT['ERR_MSG'] = $err_msg;
		
		$DOCUMENT['title'] = stripcslashes(trim(rawurldecode(trim($_GET['title']))));
		$DOCUMENT['show_title'] = stripcslashes(trim(rawurldecode(trim($_GET['show_title']))));
		$DOCUMENT['comment'] = stripcslashes(trim(rawurldecode(trim($_GET['comment']))));
		
		$id = ( isset($HTTP_POST_VARS['id']) ) ? $HTTP_POST_VARS['id'] : $HTTP_GET_VARS['id'];
		if((int)$id != 0)
		{
			$menu_container = $menu_manager_obj->get_menu_container_by_id($id);
			if($menu_container!= false)
			{
				$DOCUMENT['title'] = $menu_container['title'];
				if($menu_container['show_title'] == 1)
					$DOCUMENT['show_title'] = "show";
				if($menu_container['show_title'] == 0) 
					$DOCUMENT['show_title'] = "hide";
				$DOCUMENT['comment'] = $menu_container['comment'];
				$DOCUMENT['menu_id'] = $id;
			}
			else 
			{
				$MOD_MESSAGE = "Контейнер меню с таким id не существует ";
				header("Location: index.php?p=menu&errmsg=".rawurlencode($MOD_MESSAGE));
				exit;
			}
		}
		else 
		{
			$id = ( isset($HTTP_POST_VARS['menu_id']) ) ? $HTTP_POST_VARS['menu_id'] : $HTTP_GET_VARS['menu_id'];
			$menu_container = $menu_manager_obj->get_menu_container_by_id($id);
			if($menu_container!= false)
				$DOCUMENT['menu_id'] = $id;
			else 
			{
				$MOD_MESSAGE = "Контейнер меню с таким id не существует ";
				header("Location: index.php?p=menu&errmsg=".rawurlencode($MOD_MESSAGE));
				exit;
			}
		}
		
		$DOCUMENT['mod']['data']['template_content'] = $template_data;
		break;
	case "create_menu": // Создаём в БД новый контейнер меню
		$title = ( isset($HTTP_POST_VARS['title']) ) ? $HTTP_POST_VARS['title'] : $HTTP_GET_VARS['title'];
		$show_title = ( isset($HTTP_POST_VARS['show_title']) ) ? $HTTP_POST_VARS['show_title'] : $HTTP_GET_VARS['show_title'];
		$comment = ( isset($HTTP_POST_VARS['comment']) ) ? $HTTP_POST_VARS['comment'] : $HTTP_GET_VARS['comment'];
		
		if($menu_manager_obj->set_title($title) && $menu_manager_obj->set_comment($comment))
		{
			// если в БД есть контейнер меню с такими же данными то это может привести к путанице => исключаем её
			if($menu_manager_obj->is_duplicate_new_menu_container())
			{
				$MOD_MESSAGE = "В базе данных уже существует контейнер меню с таким же заголовком и комментарием. ";
				header("Location: index.php?p=menu&sp=add_menu&errmsg=".rawurlencode($MOD_MESSAGE)."&title=".rawurlencode($title)."&comment=".rawurlencode($comment)."&show_title=".rawurlencode($show_title));
				exit;
			}
			// создаём контейнер меню
			$menu_manager_obj->set_show_title($show_title);
			if($menu_manager_obj->create_new_menu_container())
			{
				$MOD_MESSAGE = "Контейнер меню '".$title."' успешно создан ";
				header("Location: index.php?p=menu&msg=".rawurlencode($MOD_MESSAGE));
				exit;
			}
		}
		
		$MOD_MESSAGE = "Во время создания контейнера меню произошли ошибки ";
		header("Location: index.php?p=menu&sp=add_menu&errmsg=".rawurlencode($MOD_MESSAGE)."&title=".rawurlencode($title)."&comment=".rawurlencode($comment)."&show_title=".rawurlencode($show_title));
		exit;
		
		break;
	case "update_menu": // обновляем в БД  контейнер меню
		$title = ( isset($HTTP_POST_VARS['title']) ) ? $HTTP_POST_VARS['title'] : $HTTP_GET_VARS['title'];
		$show_title = ( isset($HTTP_POST_VARS['show_title']) ) ? $HTTP_POST_VARS['show_title'] : $HTTP_GET_VARS['show_title'];
		$comment = ( isset($HTTP_POST_VARS['comment']) ) ? $HTTP_POST_VARS['comment'] : $HTTP_GET_VARS['comment'];
		$menu_id = ( isset($HTTP_POST_VARS['menu_id']) ) ? $HTTP_POST_VARS['menu_id'] : $HTTP_GET_VARS['menu_id'];
		$menu_id = (int)$menu_id;
		
		$menu_container= $menu_manager_obj->get_menu_container_by_id($menu_id);
		if($menu_container == false)
		{
			$MOD_MESSAGE = "Контейнер меню с таким id не существует ";
			header("Location: index.php?p=menu&errmsg=".rawurlencode($MOD_MESSAGE));
			exit;
		}
		
		if($menu_manager_obj->set_title($title) && $menu_manager_obj->set_comment($comment) && ($menu_manager_obj->set_menu_id($menu_id)))
		{
			// если в БД есть контейнер меню с такими же данными то это может привести к путанице => исключаем её
			if($menu_manager_obj->is_duplicate_new_menu_container())
			{
				$MOD_MESSAGE = "В базе данных уже существует контейнер меню с таким же заголовком и комментарием. ";
				header("Location: index.php?p=menu&sp=edit_menu&errmsg=".rawurlencode($MOD_MESSAGE)."&title=".rawurlencode($title)."&comment=".rawurlencode($comment)."&show_title=".rawurlencode($show_title)."&menu_id=".rawurlencode($menu_id));
				exit;
			}
			// обновляем контейнер меню
			$menu_manager_obj->set_show_title($show_title);
			
						
			if($menu_manager_obj->update_menu_container())
			{
				$MOD_MESSAGE = "информация о контейнере меню '".$title."' успешно обновена ";
				header("Location: index.php?p=menu&msg=".rawurlencode($MOD_MESSAGE));
				exit;
			}
		}
		
		$MOD_MESSAGE = "Во время обновления контейнера меню произошли ошибки ";
		header("Location: index.php?p=menu&sp=edit_menu&errmsg=".rawurlencode($MOD_MESSAGE)."&title=".rawurlencode($title)."&comment=".rawurlencode($comment)."&show_title=".rawurlencode($show_title)."&menu_id=".rawurlencode($menu_id));
		exit;
		
		break;
}





$tpl->assign("MOD_ACTION", $MOD_ACTION); // присвоение действия внутри модуля для форм


//$nista->debug($template_data);



// *************** присваиваем значение шаблона модуля *************
$tpl->assign("MOD_TEMPLATE", $THIS_MODULE_DIR_NAME.$MOD_TEMPALE);
?>