<?php
if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");
$THIS_MODULE_DIR_NAME= "../".str_ireplace("index.php", "",$Mod_Way)."tpl/";


$MOD_TEMPALE = "mod_index.tpl"; // Шаблон модуля поумолчанию

$ThisModuleInfo = $nista->get_module_info_by_par($p); // информация о данном модуле

$SYS['mod']['settings'][$ThisModuleInfo['mod_name']]['pagination']['row_on_page'] = 5; // количество строк отображаемых на 1 страницу
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

$partition_manager_obj = new partition_manager($SYS, $nista->get_module_info_by_par("site"), $MY_USER_DATA);
$partition_manager_obj->create_root_partition();

switch ($sp)
{
	default:
	case "ind":
		// проверяем необходимость отображения системного сообщения
		$msg =  stripcslashes(trim(rawurldecode(trim($_GET['msg']))));
		if($msg != "") $DOCUMENT['MSG'] = $msg;
		
		$err_msg = stripcslashes(trim(rawurldecode(trim($_GET['errmsg']))));
		if($err_msg != "") $DOCUMENT['ERR_MSG'] = $err_msg;
		
		$DOCUMENT['mod']['data']['partition_tree'] = $partition_manager_obj->get_all_partition_trees();
		
		//список статей для выбранного раздела
		$prt_id = ( isset($HTTP_POST_VARS['prt_id']) ) ? $HTTP_POST_VARS['prt_id'] : $HTTP_GET_VARS['prt_id'];
		if((int)$prt_id==0)$prt_id=0; // Если не задан id раздела то отображать все меню
		//$DOCUMENT['mod']['data']['item_list'] =$item_manager_obj->get_item_list_for_partition((int)$prt_id);
		
		$DOCUMENT['mod']['data']['menu_containers'] = $menu_manager_obj->get_menu_list();
		
		//*** начинаем генерацию страниц и меню страниц статей
		$pagination_obj = new pagination_manager();
		$pagination_obj->set_total_records(count($DOCUMENT['mod']['data']['menu_containers']));
		$pagination_obj->set_records_on_page_limit($SYS['mod']['settings'][$ThisModuleInfo['mod_name']]['pagination']['row_on_page']); // количество строк на страницу
		$pagination_obj->set_current_page(trim($_GET['page'])); // устанавливаем номер текущей страницы
		$pagination_obj->set_left_page_num_limit(5);
		$pagination_obj->set_right_page_num_limit(5);
		$DOCUMENT['mod']['data']['menu_page_list'] = $pagination_obj->get_result();
		$pagination_obj->set_full_data($DOCUMENT['mod']['data']['menu_containers']);
		$DOCUMENT['mod']['data']['menu_containers'] = $pagination_obj->get_generated_content();
		
		$DOCUMENT['mod']['data']['sub_tpl_pagination_menu_list']=$THIS_MODULE_DIR_NAME."page_list.tpl";
		//------------------
				
		$DOCUMENT['mod']['data']['ptr_id'] = (int)$prt_id;
		
		$DOCUMENT['mod']['data']['sub_tpl']=$THIS_MODULE_DIR_NAME."menu_list.tpl"; // шаблон списка меню
		break;
	case "get_ls_menu":
		$layout_template = $THIS_MODULE_DIR_NAME."menu_list.tpl";
		//список статей для выбранного раздела
		$prt_id = (isset($HTTP_POST_VARS['prt_id'])) ? $HTTP_POST_VARS['prt_id'] : $HTTP_GET_VARS['prt_id'];
		$DOCUMENT['mod']['data']['ptr_id'] = (int)$prt_id;
		$DOCUMENT['mod']['data']['menu_containers'] = $menu_manager_obj->get_menu_list();
		
		//*** начинаем генерацию страниц и меню страниц статей
		$page_num = (isset($HTTP_POST_VARS['page'])) ? $HTTP_POST_VARS['page'] : $HTTP_GET_VARS['page'];
		
		$pagination_obj = new pagination_manager();
		$pagination_obj->set_total_records(count($DOCUMENT['mod']['data']['menu_containers']));
		$pagination_obj->set_records_on_page_limit($SYS['mod']['settings'][$ThisModuleInfo['mod_name']]['pagination']['row_on_page']); // количество строк на страницу
		$pagination_obj->set_current_page(trim($page_num)); // устанавливаем номер текущей страницы
		$pagination_obj->set_left_page_num_limit(5);
		$pagination_obj->set_right_page_num_limit(5);
		$DOCUMENT['mod']['data']['menu_page_list'] = $pagination_obj->get_result();
		$pagination_obj->set_full_data($DOCUMENT['mod']['data']['menu_containers']);
		$DOCUMENT['mod']['data']['menu_containers'] = $pagination_obj->get_generated_content();
				
		$DOCUMENT['mod']['data']['sub_tpl_pagination_menu_list']=$THIS_MODULE_DIR_NAME."page_list.tpl";
		//------------------
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
	case "update_menu_status":
		$menu_id = ( isset($HTTP_POST_VARS['menu_id']) ) ? $HTTP_POST_VARS['menu_id'] : $HTTP_GET_VARS['menu_id'];
		$status = ( isset($HTTP_POST_VARS['status_action']) ) ? $HTTP_POST_VARS['status_action'] : $HTTP_GET_VARS['status_action'];
		
		$n = count($menu_id);
		for($i=0; $i<$n; $i++)
		{
			$id = (int)$menu_id[$i];
			
			$mc_obj = new menu_manager($SYS, $nista->get_module_info_by_par("menu"), $MY_USER_DATA);
			if(($mc_obj->set_menu_id($id)) && ($mc_obj->set_status($status)))
				$mc_obj->update_menu_container_status();
		}
		header("Location: index.php?p=menu");
		exit;
		break;
	case  "link_menu": // вывод формы подлинковки меню к разделам
		$MOD_TEMPALE = "menu_link.tpl";
		$MOD_ACTION = 'update_menu_link';
		$DOCUMENT['mod']['data']['partition_tree'] = $partition_manager_obj->get_all_partition_trees();
		
		$DOCUMENT['mod']['data']['menu_tpl_list'] = $tpl_manager_obj->get_menu_list();
		$DOCUMENT['mod']['data']['menu_id'] = ( isset($HTTP_POST_VARS['id']) ) ? $HTTP_POST_VARS['id'] : $HTTP_GET_VARS['id'];
		
				
//		for($i=0; $i<$n; $i++)
//		{
//			if($info_zones = $tpl_manager_obj->get_layout_zones($DOCUMENT['mod']['data']['partition_tree'][$i]['template']))
//			{
//				foreach ($info_zones as $info_zone)
//					$DOCUMENT['mod']['data']['partition_tree'][$i]['info_zones'][] = $tpl_manager_obj->get_zone_info($info_zone);
//			}
//			unset($info_zones);
//		}
		//$partition_manager_obj->debug($DOCUMENT);
		break;
	case "get_zones":
		$layout_template = $THIS_MODULE_DIR_NAME."jq_zone_select_list.tpl";
		
		$prt_id = ( isset($HTTP_POST_VARS['prt_id']) ) ? $HTTP_POST_VARS['prt_id'] : $HTTP_GET_VARS['prt_id'];
		$partition_info = $partition_manager_obj->get_partition($prt_id);
		//$partition_manager_obj->debug($partition_info);
		$prt_file = $partition_info['template'];
		
		if($info_zones = $tpl_manager_obj->get_layout_zones($prt_file))
		{
			foreach ($info_zones as $info_zone)
				$DOCUMENT['mod']['data']['info_zones'][] = $tpl_manager_obj->get_zone_info($info_zone);
		}
		break;
	case "update_menu_link":
		
		$prt_id = ( isset($HTTP_POST_VARS['prt_id']) ) ? $HTTP_POST_VARS['prt_id'] : $HTTP_GET_VARS['prt_id'];
		$zone_name = ( isset($HTTP_POST_VARS['zone_name']) ) ? $HTTP_POST_VARS['zone_name'] : $HTTP_GET_VARS['zone_name'];
		$menu_tpl = ( isset($HTTP_POST_VARS['menu_tpl']) ) ? $HTTP_POST_VARS['menu_tpl'] : $HTTP_GET_VARS['menu_tpl'];
		$menu_id = ( isset($HTTP_POST_VARS['menu_id']) ) ? $HTTP_POST_VARS['menu_id'] : $HTTP_GET_VARS['menu_id'];
		
		$menu_manager_obj->set_menu_id($menu_id);
		$menu_manager_obj->set_menu_links_2_partition($prt_id, $zone_name, $menu_tpl);
		
		exit;
		break;
		
}





$tpl->assign("MOD_ACTION", $MOD_ACTION); // присвоение действия внутри модуля для форм


//$nista->debug($template_data);



// *************** присваиваем значение шаблона модуля *************
$tpl->assign("MOD_TEMPLATE", $THIS_MODULE_DIR_NAME.$MOD_TEMPALE);
?>