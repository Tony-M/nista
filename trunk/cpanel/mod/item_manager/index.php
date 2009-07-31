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
if(!class_exists("partition_manager"))
{
	header("Location: index.php");
	exit;
}
if(!class_exists("item_manager"))
{
	header("Location: index.php");
	exit;
}
$partition_manager_obj = new partition_manager($SYS, $nista->get_module_info_by_par("site"), $MY_USER_DATA);
$partition_manager_obj->create_root_partition();

$item_manager_obj = new item_manager($SYS, $ThisModuleInfo, $MY_USER_DATA);

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
		
		// статистика		
		$DOCUMENT['mod']['data']['total_item_num'] = $item_manager_obj->count_all_items();
		
		//список статей для выбранного раздела
		$prt_id = ( isset($HTTP_POST_VARS['prt_id']) ) ? $HTTP_POST_VARS['prt_id'] : $HTTP_GET_VARS['prt_id'];
		if((int)$prt_id==0)$prt_id=$partition_manager_obj->get_root_partition_id(); // Если не задан id раздела то отображать корневой
		$DOCUMENT['mod']['data']['item_list'] =$item_manager_obj->get_item_list_for_partition((int)$prt_id);
		
		//*** начинаем генерацию страниц и меню страниц статей
		$pagination_obj = new pagination_manager();
		$pagination_obj->set_total_records(count($DOCUMENT['mod']['data']['item_list']));
		$pagination_obj->set_records_on_page_limit($SYS['mod']['settings'][$ThisModuleInfo['mod_name']]['pagination']['row_on_page']); // количество строк на страницу
		$pagination_obj->set_current_page(trim($_GET['page'])); // устанавливаем номер текущей страницы
		$pagination_obj->set_left_page_num_limit(5);
		$pagination_obj->set_right_page_num_limit(5);
		$DOCUMENT['mod']['data']['item_page_list'] = $pagination_obj->get_result();
		$pagination_obj->set_full_data($DOCUMENT['mod']['data']['item_list']);
		$DOCUMENT['mod']['data']['item_list'] = $pagination_obj->get_generated_content();
		
		$DOCUMENT['mod']['data']['sub_tpl_pagination_item_list']=$THIS_MODULE_DIR_NAME."page_list.tpl";
		//------------------
		
		
		$DOCUMENT['mod']['data']['sub_tpl']=$THIS_MODULE_DIR_NAME."item_list.tpl"; // шаблон листа статей
		
		$DOCUMENT['mod']['data']['ptr_id'] = (int)$prt_id;
		
		break;
	case "get_ls_item":
		$layout_template = $THIS_MODULE_DIR_NAME."item_list.tpl";
		//список статей для выбранного раздела
		$prt_id = (isset($HTTP_POST_VARS['prt_id'])) ? $HTTP_POST_VARS['prt_id'] : $HTTP_GET_VARS['prt_id'];
		$DOCUMENT['mod']['data']['ptr_id'] = (int)$prt_id;
		$DOCUMENT['mod']['data']['item_list'] =$item_manager_obj->get_item_list_for_partition((int)$prt_id);
		
		//*** начинаем генерацию страниц и меню страниц статей
		$page_num = (isset($HTTP_POST_VARS['page'])) ? $HTTP_POST_VARS['page'] : $HTTP_GET_VARS['page'];
		
		$pagination_obj = new pagination_manager();
		$pagination_obj->set_total_records(count($DOCUMENT['mod']['data']['item_list']));
		$pagination_obj->set_records_on_page_limit($SYS['mod']['settings'][$ThisModuleInfo['mod_name']]['pagination']['row_on_page']); // количество строк на страницу
		$pagination_obj->set_current_page(trim($page_num)); // устанавливаем номер текущей страницы
		$pagination_obj->set_left_page_num_limit(5);
		$pagination_obj->set_right_page_num_limit(5);
		$DOCUMENT['mod']['data']['item_page_list'] = $pagination_obj->get_result();
		$pagination_obj->set_full_data($DOCUMENT['mod']['data']['item_list']);
		$DOCUMENT['mod']['data']['item_list'] = $pagination_obj->get_generated_content();
				
		$DOCUMENT['mod']['data']['sub_tpl_pagination_item_list']=$THIS_MODULE_DIR_NAME."page_list.tpl";
		//------------------
		break;
	case "get_ls_category":
		$prt_id = (isset($HTTP_POST_VARS['prt_id'])) ? $HTTP_POST_VARS['prt_id'] : $HTTP_GET_VARS['prt_id'];
		$xml = $partition_manager_obj->get_xml_category_list_for_partition((int)$prt_id);
		header ("content-type: text/xml");
		echo $xml;		
		exit;
		break;
	case "add_item": //* форма создания статьи
		$errmsg = trim(rawurldecode(trim($_GET['errmsg'])));
		if($errmsg != "") $DOCUMENT['ERR_MSG'] = $errmsg;
		$DOCUMENT['OPTION']['xinha'] = 'enabled'; // включаем ксинху
		$MOD_TEMPALE = "item_form.tpl";
		$MOD_ACTION = 'create_item';
		
		$DOCUMENT['POST_LIST']=$nista->get_sys_post_list();
		
		$DOCUMENT['mod']['data']['partition_tree'] = $partition_manager_obj->get_all_partition_trees();
		$DOCUMENT['mod']['data']['category_list'] = $partition_manager_obj->get_category_list_4_partition($partition_manager_obj->get_root_partition_id());
		if((int)$_GET['prt_id']!=0)
		{
			$DOCUMENT['mod']['data']['item_info']['pid'] = (int)$_GET['prt_id'];
			$DOCUMENT['mod']['data']['category_list'] = $partition_manager_obj->get_category_list_4_partition((int)$_GET['prt_id']);
		}
		break;
	case "create_item": //* Создание новой статьи
		
		if($item_manager_obj->set_title($_POST['title']))
		{
			$item_manager_obj->set_text($_POST['text']);
			$item_manager_obj->set_meta_keyword($_POST['meta_keyword']);
			$item_manager_obj->set_meta_description($_POST['meta_description']);
			$item_manager_obj->set_owner_id($_POST['owner_partition']);
			$item_manager_obj->set_category_id($_POST['category_id']);
				
			$item_manager_obj->set_status($_POST['publish']);
			$item_manager_obj->set_penname($_POST['penname']);
			$item_manager_obj->set_access_level($_POST['access_level']);
			
			if($item_manager_obj->save_item())
			{
				$MOD_MESSAGE = "Статья сайта с заглавием '".$_POST['title']."' успешно создана ";
				header("Location: index.php?p=item&prt_id=".(int)$_POST['owner_partition']."&msg=".rawurlencode($MOD_MESSAGE));
				exit;
			}
			else 
			{
				$MOD_MESSAGE = "Статья сайта с заглавием '".$_POST['title']."' не создана ";
				header("Location: index.php?p=item&errmsg=".rawurlencode($MOD_MESSAGE));
				exit;
			}
			
		}
		//exit;
		
		break;
	case "edit_item": //* форма редактирования статьи
		$errmsg = trim(rawurldecode(trim($_GET['errmsg'])));
		if($errmsg != "") $DOCUMENT['ERR_MSG'] = $errmsg;
		$DOCUMENT['OPTION']['xinha'] = 'enabled';
		$MOD_TEMPALE = "item_form.tpl";
		$MOD_ACTION = 'update_item';
		
		$DOCUMENT['POST_LIST']=$nista->get_sys_post_list();
		
		
		
		$DOCUMENT['mod']['data']['partition_tree'] = $partition_manager_obj->get_all_partition_trees();
		
		
		$DOCUMENT['mod']['data']['item_info'] = $item_manager_obj->get_item($_GET['id']);
		
		if($DOCUMENT['mod']['data']['item_info'] == false)
		{
			$MOD_MESSAGE = "Данной статьи не существует";
			header("Location: index.php?p=item&errmsg=".rawurlencode($MOD_MESSAGE));
			exit;			
		}

		$DOCUMENT['mod']['data']['category_list'] = $item_manager_obj->get_category_list_4_partition($DOCUMENT['mod']['data']['item_info']['pid']);		
		break;
	case "update_item"://* Производится обновление данных статьи после редактирования
		
		
		//{
			$item_manager_obj->purge_variables();
			
			if(($item_manager_obj->set_title($_POST['title'])) && ($item_manager_obj->set_id((int)$_POST['item_id'])))
			{
				
				
				$item_manager_obj->set_text($_POST['text']);
				$item_manager_obj->set_meta_keyword($_POST['meta_keyword']);
				$item_manager_obj->set_meta_description($_POST['meta_description']);
				$item_manager_obj->set_owner_id($_POST['owner_partition']);
				$item_manager_obj->set_category_id($_POST['category_id']);
									
				$item_manager_obj->set_status($_POST['publish']);
				$item_manager_obj->set_penname($_POST['penname']);
				$item_manager_obj->set_access_level($_POST['access_level']);
				
				if($item_manager_obj->save_item())
				{
					$MOD_MESSAGE = "Статья сайта с заглавием '".htmlentities($_POST['title'],ENT_QUOTES, "UTF-8")."' успешно обновлёна ";
					header("Location: index.php?p=item&prt_id=".(int)$_POST['owner_partition']."msg=".rawurlencode($MOD_MESSAGE));
					exit;
				}
				else 
				{
					$MOD_MESSAGE = "Информация о Статье сайта не была обновлена из-за некорректных данных";
					header("Location: index.php?p=item&errmsg=".rawurlencode($MOD_MESSAGE));
					exit;
				}
				
			}
			else 
				{
					$MOD_MESSAGE = "Информация о Статье сайта не была обновлена из-за некорректных данных";
					header("Location: index.php?p=item&errmsg=".rawurlencode($MOD_MESSAGE));
					exit;
				}
		//}
		//exit;
		
		break;	
	case "update_item_status"://* производится обновление статуса статей по выделенным чекбоксам в индексе модуля
		
		$id = ( isset($HTTP_POST_VARS['item_id']) ) ? $HTTP_POST_VARS['item_id'] : $HTTP_GET_VARS['item_id'];
		$status = ( isset($HTTP_POST_VARS['status_action']) ) ? $HTTP_POST_VARS['status_action'] : $HTTP_GET_VARS['status_action'];
		
		if($status != "none")
		{
			$item_manager_obj->purge_variables();
			$item_manager_obj->set_status($status);
			
			$err_flag = 0;
			if(!is_array($id))
			{
				$item_manager_obj->set_id($id);			
				if(!$item_manager_obj->update_item_status())$err_flag=1;
			}
			else
			{
				$n = count($id);
				for($i=0; $i<$n; $i++)
				{
					$item_manager_obj->set_id($id[$i]);			
					if(!$item_manager_obj->update_item_status())$err_flag=1;
				}
			}
		}
		if($err_flag==0)
			$MOD_MESSAGE = "Статутсы статей успешно обновлены";
		else 
			$MOD_MESSAGE = "Во время обновления статусов статей произошли ошибки";
		header("Location: index.php?p=item&prt_id=".(int)$_POST['owner_partition']."msg=".rawurlencode($MOD_MESSAGE));
		exit;
		break;
	case "rm_item":
		$item_id = ( isset($HTTP_POST_VARS['item_id']) ) ? $HTTP_POST_VARS['item_id'] : $HTTP_GET_VARS['item_id'];
		$prt_id = (isset($HTTP_POST_VARS['prt_id'])) ? $HTTP_POST_VARS['prt_id'] : $HTTP_GET_VARS['prt_id'];
		
		$item = $item_manager_obj->get_item((int)$item_id);
		if($item)
		{
			if($item_manager_obj->remove_item((int)$item_id))
			{
				$MOD_MESSAGE = "Статья '".htmlentities($item['title'],ENT_QUOTES, "UTF-8")."' успешно удалена.";
				header("Location: index.php?p=item&prt_id=".(int)$item['pid']."&msg=".rawurlencode($MOD_MESSAGE));
				exit;
			}
			else 
			{
				$MOD_MESSAGE = "Во время удаления Статьи '".htmlentities($item['title'],ENT_QUOTES, "UTF-8")."' возникли ошибки.";
				header("Location: index.php?p=item&prt_id=".(int)$item['pid']."&errmsg=".rawurlencode($MOD_MESSAGE));
				exit;
			}
		}
		else 
		{
			$MOD_MESSAGE = "Статьи '".htmlentities($item['title'],ENT_QUOTES, "UTF-8")."' не существует.";
			header("Location: index.php?p=item&prt_id=".(int)$prt_id."&errmsg=".rawurlencode($MOD_MESSAGE));
			exit;
		}
		break;
}





$tpl->assign("MOD_ACTION", $MOD_ACTION); // присвоение действия внутри модуля для форм


//$nista->debug($template_data);



// *************** присваиваем значение шаблона модуля *************
$tpl->assign("MOD_TEMPLATE", $THIS_MODULE_DIR_NAME.$MOD_TEMPALE);
?>