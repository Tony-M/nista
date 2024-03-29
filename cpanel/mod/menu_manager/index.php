<?php
if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");
$THIS_MODULE_DIR_NAME= "../".str_ireplace("index.php", "",$Mod_Way)."tpl/";


$MOD_TEMPALE = "mod_index.tpl"; // Шаблон модуля поумолчанию

$ThisModuleInfo = $nista->get_module_info_by_par($p); // информация о данном модуле

$SYS['mod']['settings'][$ThisModuleInfo['mod_name']]['pagination']['row_on_page'] = $SYS['settings']['all']['pagination']['row_on_page']; // количество строк отображаемых на 1 страницу
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
//if( isset( $HTTP_POST_VARS['sp'] ) || isset( $HTTP_GET_VARS['sp'] ) )
//{
//        $sp = ( isset($HTTP_POST_VARS['sp']) ) ? $HTTP_POST_VARS['sp'] : $HTTP_GET_VARS['sp'];
//}
//else
//{
//        $sp = 'ind';
//}
$sp = std_lib::POST_GET('sp');
if($sp=="")$sp = 'ind';

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

// проверяем необходимость отображения системного сообщения
$msg =  stripcslashes(trim(rawurldecode(trim(std_lib::GET('msg')))));
if($msg != "") $DOCUMENT['MSG'] = $msg;

$err_msg = stripcslashes(trim(rawurldecode(trim(std_lib::GET('errmsg')))));
if($err_msg != "") $DOCUMENT['ERR_MSG'] = $err_msg;

switch ($sp)
{
	default:
	case "ind":
		
		
		$DOCUMENT['mod']['data']['partition_tree'] = $partition_manager_obj->get_all_partition_trees();
		
		//список статей для выбранного раздела
		$prt_id = std_lib::POST_GET('prt_id1');
		if((int)$prt_id==0)$prt_id=0; // Если не задан id раздела то отображать все меню
		//$DOCUMENT['mod']['data']['item_list'] =$item_manager_obj->get_item_list_for_partition((int)$prt_id);
		
		$DOCUMENT['mod']['data']['menu_containers'] = $menu_manager_obj->get_menu_list($prt_id);
		
		//*** начинаем генерацию страниц и меню страниц статей
		$pagination_obj = new pagination_manager();
		$pagination_obj->set_total_records(count($DOCUMENT['mod']['data']['menu_containers']));
		$pagination_obj->set_records_on_page_limit($SYS['mod']['settings'][$ThisModuleInfo['mod_name']]['pagination']['row_on_page']); // количество строк на страницу
		$pagination_obj->set_current_page(trim(std_lib::GET('page'))); // устанавливаем номер текущей страницы
//		$pagination_obj->set_left_page_num_limit(5);
//		$pagination_obj->set_right_page_num_limit(5);
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
		$prt_id = std_lib::POST_GET(prt_id) ;
		$DOCUMENT['mod']['data']['ptr_id'] = (int)$prt_id;
		$DOCUMENT['mod']['data']['menu_containers'] = $menu_manager_obj->get_menu_list($prt_id);
		
		//*** начинаем генерацию страниц и меню страниц статей
		$page_num = std_lib::POST_GET('page') ;
		$DOCUMENT['mod']['data']['page_number'] = $page_num;
		
		
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
		
		$err_msg = stripcslashes(trim(rawurldecode(trim(std_lib::GET('errmsg')))));
		if($err_msg != "") $DOCUMENT['ERR_MSG'] = $err_msg;
		
		$DOCUMENT['title'] = stripcslashes(trim(rawurldecode(trim(std_lib::GET('title')))));
		$DOCUMENT['show_title'] = stripcslashes(trim(rawurldecode(trim(std_lib::GET('show_title')))));
		$DOCUMENT['comment'] = stripcslashes(trim(rawurldecode(trim(std_lib::GET('comment')))));
		
		$DOCUMENT['mod']['data']['template_content'] = $template_data;
		break;
	case "edit_menu":
		$MOD_TEMPALE = "menu_form.tpl";
		$MOD_ACTION = 'update_menu';
		
		$err_msg = stripcslashes(trim(rawurldecode(trim(std_lib::GET('errmsg')))));
		if($err_msg != "") $DOCUMENT['ERR_MSG'] = $err_msg;
		
		$DOCUMENT['title'] = stripcslashes(trim(rawurldecode(trim(std_lib::GET('title')))));
		$DOCUMENT['show_title'] = stripcslashes(trim(rawurldecode(trim(std_lib::GET('show_title')))));
		$DOCUMENT['comment'] = stripcslashes(trim(rawurldecode(trim(std_lib::GET('comment')))));
		
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
		
		$DOCUMENT['mod']['data']['menu_links'] = $menu_manager_obj->get_menu_links_2_partition($DOCUMENT['mod']['data']['menu_id']);
		if($DOCUMENT['mod']['data']['menu_links'] == false)$DOCUMENT['mod']['data']['menu_links'] = NULL;
		$n =  count($DOCUMENT['mod']['data']['menu_links']);
		
		for($i=0; $i<$n; $i++)
		{
			$DOCUMENT['mod']['data']['menu_links'][$i]['partition_info'] = $partition_manager_obj->get_partition($DOCUMENT['mod']['data']['menu_links'][$i]['prt_id']);
			$DOCUMENT['mod']['data']['menu_links'][$i]['zones_list'] = $tpl_manager_obj->get_layout_zones($DOCUMENT['mod']['data']['menu_links'][$i]['partition_info']['template']);
			$m = count($DOCUMENT['mod']['data']['menu_links'][$i]['zones_list']);
			for($j=0; $j<$m; $j++)
			{
				$DOCUMENT['mod']['data']['menu_links'][$i]['zones_list'][$j] = $tpl_manager_obj->get_zone_info($DOCUMENT['mod']['data']['menu_links'][$i]['zones_list'][$j]);
			}
			
			
		}
//		$menu_manager_obj->debug($DOCUMENT['mod']['data']['menu_links']);
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
		
		$MOD_MESSAGE = "Изменения внесены";
		header("Location: index.php?p=menu&sp=link_menu&msg=".rawurlencode($MOD_MESSAGE)."&id=".$menu_id);
		exit;
		break;
	case "ln":// принимаем ссылку на объект модуля, для формирования пункта меню и выводим форму создания пункта меню
		$MOD_TEMPALE = "menu_item_form.php";
		$MOD_ACTION = 'create_item';
		$object_link = std_lib::GET('obj');
		$DOCUMENT['mod']['data']['http_referer'] = rawurlencode($_SERVER['HTTP_REFERER']); // ссылка на страницу источник для возврата
		//$menu_manager_obj->debug($object_link);
		
		$DOCUMENT['mod']['data']['menu_containers'] = $menu_manager_obj->get_menu_list();// получаем список всех меню
		$DOCUMENT['mod']['data']['partition_tree'] = $partition_manager_obj->get_all_partition_trees(); // Список всех разделов сайта
		if((int)($object_link[0]))
		{
			$module = $nista->get_module_by_id((int)$object_link[0]);
						
			if($module!=false)
			{
				//$menu_link_provider_obj = new $$module['mod_name'];
				$task_class = $module['mod_name'];
				if(class_exists($task_class))
				{
					$task_obj=new $task_class($SYS, $module, $MY_USER_DATA);
					$object = $task_obj->get_task_object($object_link);
					if($object)
					{
						$DOCUMENT['mod']['data']['object'] = $object;
						$DOCUMENT['mod']['data']['menu_item'] = $object['object_title'];
						$DOCUMENT['mod']['data']['object_link'] = $object_link;
						
					}
				}

			}
		}
		break;
	case "create_item":// создание нового пункиа меню в одном или более контейнерах меню
		
		$DOCUMENT['mod']['data']['http_referer'] = std_lib::POST('page_referer'); // ссылка на страницу источник для возврата
		
		$menu_manager_obj->set_title(std_lib::POST('title'));
		$menu_manager_obj->set_alt(std_lib::POST('alt'));
		$menu_manager_obj->set_text(std_lib::POST('text'));
		$menu_manager_obj->set_show_title(std_lib::POST('show_title'));
		$menu_manager_obj->set_url(std_lib::POST('link_url'));
		$menu_manager_obj->set_target(std_lib::POST('target'));
		$menu_manager_obj->set_obj(std_lib::POST('obj'));
		
		$menu_manager_obj->set_ico(std_lib::POST_GET('ico_src'));
		
		if($uploaded_ico_name = $menu_manager_obj->upload_ico("ico_img"))
			$menu_manager_obj->set_ico($uploaded_ico_name);
			
		$menu_manager_obj->set_relation_container_id(std_lib::POST('mc_id'));
		$menu_manager_obj->set_relation_status(std_lib::POST('it_status'));
		$menu_manager_obj->set_relation_partition_id(std_lib::POST('mc_prt_id'));
		
		if($menu_manager_obj->create_mass_menu_items())
		{
			//Связи успешно созданы
			$MOD_MESSAGE = "Пункт меню '".std_lib::POST('title')."' успешно создан ";
			header("Location: index.php?p=menu&sp=item_creation_result&msg=".rawurlencode($MOD_MESSAGE)."&pr=".$DOCUMENT['mod']['data']['http_referer']);
			exit;
		}
		else 
		{
			//при создании были косяки
			$MOD_MESSAGE = "В процессе создания пункта меню '".std_lib::POST('title')."' возникли ошибки ";
			header("Location: index.php?p=menu&sp=item_creation_result&errmsg=".rawurlencode($MOD_MESSAGE)."&pr=".$DOCUMENT['mod']['data']['http_referer']);
			exit;
		}
		
		header("Location: index.php?p=menu&sp=item_creation_result");
		exit;
		break;
	case "item_creation_result": // диалог после создания пункта меню
		$MOD_TEMPALE =  "menu_item_after_creation_dialog.tpl";
		$DOCUMENT['mod']['data']['http_referer'] = trim(rawurldecode(std_lib::GET('pr'))); // страница источник
		
		break;
	case "get_prt_menu": // Возвращаем список меню для выбранного раздела в формате xml
		$xml = $menu_manager_obj->get_menu_for_partition(std_lib::GET('id'));
		if($xml)
		{
			header ("content-type: text/xml");	
			echo $xml;			
		}
		else echo "";
		exit;
		break;
	case "item_list":// для выбранного меню выводим список его пунктов
		$MOD_TEMPALE = "item_list.tpl";
	
		$menu_id = std_lib::POST_GET('mid');
		$menu_id = (int)$menu_id;
		
		$item_id = std_lib::POST_GET('it_id') ;
		$item_id = (int)$item_id;
				
		if($menu_id) // список пунктов меню по id меню
		{
			$DOCUMENT['mod']['data']['menu_container_id'] = $menu_id;
			$DOCUMENT['mod']['data']['menu_data'] = $menu_manager_obj->get_menu_container_by_id($menu_id);
			$DOCUMENT['mod']['data']['menu_item_list'] = $menu_manager_obj->get_distinct_item_list_for_menu_container($menu_id);
		}
		
		if(!$menu_id && $item_id) // Список пунктов мею по id одного из этих пунктов
		{
			// Данный кусок кода можно будет написать только тогда, когда
			// будет реализована галочка при создании меню, указывающая на то что
			// пункт меню создаётся для каждого меню свой а не как сейчас единый
		}
		
		if(!$menu_id && !$item_id)
		{
			//не задан ни id контейнера меню ни пункта меню, для поиска контейнера
		}
		break;
	case "add_rel": // добавляем ajax запросом relation пункта меню к меню и разделу из списка пунктов меню
		$item_id = std_lib::POST_GET("item_id");
		$prt_id = std_lib::POST_GET("prt_id");
		$menu_id = std_lib::POST_GET("menu_id");
		
		if($menu_manager_obj->add_relation($item_id, $prt_id, $menu_id))
			echo "ok";
		else 
			echo "err";
		exit;
		break;
	case "get_item_prt":// возвращает html таблицу со списком разделов, к которым привязан пункт меню
		$item_id = ( isset($HTTP_POST_VARS['it_id']) ) ? $HTTP_POST_VARS['it_id'] : $HTTP_GET_VARS['it_id'];
		$item = $menu_manager_obj->is_menu_item($item_id);
		if($item)
		{	
			$DOCUMENT['mod']['data']['item_id'] = $item_id;
			$partitions = $menu_manager_obj->get_partitions_for_menu_item($item_id, $partition_manager_obj);
			if($partitions)
			{
				$n = count($partitions);
				for($i=0; $i<$n; $i++)
				{
					if($partitions[$i]['prt_id'])
						$partitions[$i]['partition'] = $partition_manager_obj->get_partition($partitions[$i]['prt_id']);
				}
			}
			
			
			$DOCUMENT['mod']['data']['partitions'] = $partitions;
			$partitions_num = count($partitions);
			$menu_links = $menu_manager_obj->get_menu_links_2_partition($item['menu_container_id']);
			$n = count($menu_links);
			//$partition_manager_obj->debug($partitions);
			
			$partition_tree = $partition_manager_obj->get_all_partition_trees();
			$m = count($partition_tree);
			$k = 0;
			for($j=0; $j<$m; $j++)
			{
				for($i=0; $i<$n; $i++)
				{
					$flag = 0;
					$tmp_partition = $partition_manager_obj->get_partition($menu_links[$i]['prt_id']);
					if($tmp_partition['id'] == $partition_tree[$j]['id'])
					{
						for($l=0; $l<$partitions_num; $l++)
						{
							if($partitions[$l]['partition']['id'] == $partition_tree[$j]['id'])
								$flag = 1;
						}
						if(!$flag)
						{
							$DOCUMENT['mod']['data']['partitions_for_menu'][$k] =$partition_tree[$j];
							if($tmp_partition['pid'] != $partition_tree[$j-1]['id'])
								$DOCUMENT['mod']['data']['partitions_for_menu'][$k]['not_subprt'] = "yes";
							$k++;
						}
					}
					 
				}
			}
			
			
			
			
		}
		
//		$menu_manager_obj->debug($partitions);
		$layout_template = $THIS_MODULE_DIR_NAME."html_item_prt_list.tpl";
		break;
	case "update_rel_status": // обновляем статус связи relation ajax запросом
		$rid = ( isset($HTTP_POST_VARS['rid']) ) ? $HTTP_POST_VARS['rid'] : $HTTP_GET_VARS['rid'];
		$status = ( isset($HTTP_POST_VARS['status']) ) ? $HTTP_POST_VARS['status'] : $HTTP_GET_VARS['status'];
		
		if($menu_manager_obj->update_rid_status($rid, $status))
		{
			switch ($status)
			{
				case "on":
					echo $DOCUMENT['ACP_IMG_WAY']."publish.gif";
					break;
				case "off":
					echo $DOCUMENT['ACP_IMG_WAY']."unpublish.gif";
					break;
				case "wait":
					echo $DOCUMENT['ACP_IMG_WAY']."draft.gif";
					break;
			}
		}
		else 
			echo "err";
		exit;
		break;
	case "update_item_status": // ajax обновление статуса пункта меню
		$it_id = ( isset($HTTP_POST_VARS['it_id']) ) ? $HTTP_POST_VARS['it_id'] : $HTTP_GET_VARS['it_id'];
		$status = ( isset($HTTP_POST_VARS['status']) ) ? $HTTP_POST_VARS['status'] : $HTTP_GET_VARS['status'];
		
		if($menu_manager_obj->update_menu_item_status($it_id, $status))
		{
			switch ($status)
			{
				case "on":
					echo $DOCUMENT['ACP_IMG_WAY']."publish.gif";
					break;
				case "off":
					echo $DOCUMENT['ACP_IMG_WAY']."unpublish.gif";
					break;
				case "wait":
					echo $DOCUMENT['ACP_IMG_WAY']."draft.gif";
					break;
			}
		}
		else 
			echo "err";
		exit;
		break;
	case "rm_mitem_relation":// удаление привязки пункта меню к разделу
		$rid = ( isset($HTTP_POST_VARS['rid']) ) ? $HTTP_POST_VARS['rid'] : $HTTP_GET_VARS['rid'];
		
		$result = $menu_manager_obj->remove_relation_by_id($rid);
		
		switch ($result)
		{
			case false:
				echo "err";
				break;
			case "ok+menu": // была удалена не только relation но и сам пункт меню
				echo "reload";
				break;
			case "ok":
				echo "ok"; // была удалена relation
				break;				
		}		
		exit;
		break;
	case "rm_mitem": //удаление пункта меню
		$menu_id = ( isset($HTTP_POST_VARS['menu_id']) ) ? $HTTP_POST_VARS['menu_id'] : $HTTP_GET_VARS['menu_id'];
		echo std_lib::get_ok_err_result($menu_manager_obj->remove_menu_item($menu_id));
		exit;		
		break;
	case "mv_item": // изменение порядка пунктов меню в меню
		$direction = std_lib::POST_GET("direction");
		$item_id = std_lib::POST_GET("menu_id");
		
		$menu_manager_obj->change_menu_item_order($item_id, $direction);
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
		
		break;
	case "rm_menu": // удаление контейнера меню		
		echo std_lib::get_ok_err_result($menu_manager_obj->remove_menu_container(std_lib::POST_GET('menu_id')));
		exit;
		break;
	case "edit_mitem": // форма редактирования пункта меню
		$MOD_TEMPALE =  "menu_item_not_mass_form.tpl";
		$DOCUMENT['mod']['data']['sub_tpl_ico']=$THIS_MODULE_DIR_NAME."el_ico_html_code.tpl";
		$MOD_ACTION = "update_mitem";
		
		$DOCUMENT['mod']['data']['http_referer'] = rawurlencode($_SERVER['HTTP_REFERER']);
		
		$DOCUMENT['data']['ico_list'] =$nista->get_ico_list('png');
		
		$item = $menu_manager_obj->is_menu_item(std_lib::POST_GET('menu_id'));
		if($item)
		{
			$DOCUMENT['mod']['data']['menu_item'] = $item;
			if($item['ico']!="")$DOCUMENT['mod']['data']['menu_item']["ico_way"] = $DOCUMENT['SERVER_URL']."/".$item['ico'];
		}
		else 
		{
			header('Location: '.$_SERVER['HTTP_REFERER']);
			exit;
		}
		break;
	case "new_mitem":
		$MOD_TEMPALE =  "menu_item_not_mass_form.tpl";
		$DOCUMENT['mod']['data']['sub_tpl_ico']=$THIS_MODULE_DIR_NAME."el_ico_html_code.tpl";
		$MOD_ACTION = "create_item";
		$DOCUMENT['mod']['data']['http_referer'] = rawurlencode($_SERVER['HTTP_REFERER']);
		
		$DOCUMENT['data']['ico_list'] =$nista->get_ico_list('png');
		$menu_container = $menu_manager_obj->is_menu_container(std_lib::POST_GET('menu_id'));
		if($menu_container)
		{
			$DOCUMENT['mod']['data']['menu_item']['menu_id'] = $menu_container['menu_id'];
			$DOCUMENT['mod']['data']['object_link'] = array("url");
			
		}
		else 
		{
			header('Location : '.$_SERVER['HTTP_REFERER']);
			exit;
		}
		
		break;	
	case "update_mitem":// обновление записи в БД для пункта меню после редактирования его формы
		
		//$menu_manager_obj->debug(std_lib::POST);
		
		$menu_manager_obj->set_menu_id(std_lib::POST_GET('menu_id'));
		
		$menu_manager_obj->set_title(std_lib::POST_GET('title'));
		$menu_manager_obj->set_alt(std_lib::POST_GET('alt'));
		$menu_manager_obj->set_text(std_lib::POST_GET('text'));
		$menu_manager_obj->set_show_title(std_lib::POST_GET('show_title'));			
		$menu_manager_obj->set_url(std_lib::POST_GET('link_url'));
		$menu_manager_obj->set_target(std_lib::POST_GET('target'));
		$menu_manager_obj->set_obj(std_lib::POST_GET('obj'));
		
		$menu_manager_obj->set_ico(std_lib::POST_GET('ico_src'));
		
		if($uploaded_ico_name = $menu_manager_obj->upload_ico("ico_img"))
			$menu_manager_obj->set_ico($uploaded_ico_name);
		
		$menu_manager_obj->update_menu_item();
		//$menu_manager_obj->debug();
		
		header("Location: ".trim(rawurldecode(std_lib::POST_GET('page_referer'))));
		exit;
		break;
	case "get_ico": // аякс запрос html код рисунка по его имени (для иконок)
		$layout_template = $THIS_MODULE_DIR_NAME."el_ico_html_code.tpl";
		
		if(!file_exists(ROOT_WAY."img/ico/".std_lib::POST_GET('ico')))
		{
			echo std_lib::get_ok_err_result(false);
			exit;
		}
		
		$DOCUMENT['mod']['data']['menu_item']['ico']="img/ico/".std_lib::POST_GET('ico');
		$DOCUMENT['mod']['data']['menu_item']['ico_way'] = $DOCUMENT['SERVER_URL']."/img/ico/".std_lib::POST_GET('ico');
		
		break;
		
}





$tpl->assign("MOD_ACTION", $MOD_ACTION); // присвоение действия внутри модуля для форм


//$nista->debug($template_data);



// *************** присваиваем значение шаблона модуля *************
$tpl->assign("MOD_TEMPLATE", $THIS_MODULE_DIR_NAME.$MOD_TEMPALE);
?>