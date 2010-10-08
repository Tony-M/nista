<?php
if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");
$THIS_MODULE_DIR_NAME= "../".str_ireplace("index.php", "",$Mod_Way)."tpl/";


$MOD_TEMPALE = "mod_index.tpl"; // Шаблон модуля поумолчанию

$ThisModuleInfo = $nista->get_module_info_by_par($p); // информация о данном модуле

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
if($sp=="")$sp = "ind";
if(!class_exists("partition_manager"))
{
	header("Location: index.php");
	exit;
}

$partition_manager_obj = new partition_manager($SYS, $ThisModuleInfo, $MY_USER_DATA);

$partition_manager_obj->create_root_partition();


switch ($sp)
{
	default:
	case "ind":
		// проверяем необходимость отображения системного сообщения
		$msg =  stripcslashes(trim(rawurldecode(trim(std_lib::GET('msg')))));
		if($msg != "") $DOCUMENT['MSG'] = $msg;
		
		$err_msg = stripcslashes(trim(rawurldecode(trim(std_lib::GET('errmsg')))));
		if($err_msg != "") $DOCUMENT['ERR_MSG'] = $err_msg;
		
		$DOCUMENT['mod']['data']['partition_tree'] = $partition_manager_obj->get_all_partition_trees();
		
		// статистика		
		$DOCUMENT['mod']['data']['total_prt_num'] = $partition_manager_obj->count_all_partitions();
		
		//$DOCUMENT['mod']['data']['file_content'] = $template_data;
		break;
	case "add_partition": //* форма создания раздела
		$errmsg = trim(rawurldecode(trim(std_lib::GET('errmsg'))));
		if($errmsg != "") $DOCUMENT['ERR_MSG'] = $errmsg;
		$DOCUMENT['OPTION']['xinha'] = 'enabled';
		$MOD_TEMPALE = "partition_form.tpl";
		$MOD_ACTION = 'create_partition';
		
		$DOCUMENT['POST_LIST']=$nista->get_sys_post_list();
		
		if(class_exists("tpl_manager"))
		{
			$tpl_manager_obj = new  tpl_manager($SYS, $MY_USER_DATA);
			$DOCUMENT['mod']['data']['template_list'] = $tpl_manager_obj->get_layout_list();			
		}
		
		$DOCUMENT['mod']['data']['partition_tree'] = $partition_manager_obj->get_all_partition_trees();
		
//		$partition_manager_obj->debug($DOCUMENT['mod']['data']['partition_tree']);
		
		break;
	case "create_partition":
		//$partition_manager_obj->debug($_POST);
//		echo $_POST('text');exit;
		if($partition_manager_obj->set_title(std_lib::POST('title')))
		{
			$partition_manager_obj->set_text(std_lib::POST('text'));
			$partition_manager_obj->set_meta_keyword(std_lib::POST('meta_keyword'));
			$partition_manager_obj->set_meta_description(std_lib::POST('meta_description'));
			$partition_manager_obj->set_owner_id(std_lib::POST('subpart'));
			
			$inherit_tpl = trim(std_lib::POST('inherit_tpl'));
			if($inherit_tpl == "yes")
			{
				$partition_manager_parent_obj = new partition_manager($SYS, $ThisModuleInfo, $MY_USER_DATA);
				$parent_partition_info = $partition_manager_parent_obj->get_partition(std_lib::POST('subpart'));
				if(is_array($parent_partition_info))
				{
					$partition_manager_obj->set_template($parent_partition_info['template']);
				}
				else 
				{
					$parent_partition_info = $partition_manager_parent_obj->get_partition('1');
					if(is_array($parent_partition_info))
						$partition_manager_obj->set_template($parent_partition_info['template']);
				}
			}
			else 
				$partition_manager_obj->set_template(std_lib::POST('template'));
						
			$partition_manager_obj->set_status(std_lib::POST('publish'));
			$partition_manager_obj->set_penname(std_lib::POST('penname'));
			$partition_manager_obj->set_access_level(std_lib::POST('access_level'));
			
			if($partition_manager_obj->save_partition())
			{
				$MOD_MESSAGE = "Раздел сайта с заглавием '".std_lib::POST('title')."' успешно создан ";
				header("Location: index.php?p=site&msg=".rawurlencode($MOD_MESSAGE));
				exit;
			}
			else 
			{
				$MOD_MESSAGE = "Во время создания раздела сайта с заглавием '".std_lib::POST('title')."' произошли ошибки";
				header("Location: index.php?p=site&errmsg=".rawurlencode($MOD_MESSAGE));
				exit;
			}
			
		}
		//exit;
		
		break;
	case "edit_partition": //* форма редактирования раздела
		$errmsg = trim(rawurldecode(trim(std_lib::GET('errmsg'))));
		if($errmsg != "") $DOCUMENT['ERR_MSG'] = $errmsg;
		$DOCUMENT['OPTION']['xinha'] = 'enabled';
		$MOD_TEMPALE = "partition_form.tpl";
		$MOD_ACTION = 'update_partition';
		
		$DOCUMENT['POST_LIST']=$nista->get_sys_post_list();
		
		if(class_exists("tpl_manager"))
		{
			$tpl_manager_obj = new  tpl_manager($SYS, $MY_USER_DATA);
			$DOCUMENT['mod']['data']['template_list'] = $tpl_manager_obj->get_layout_list();			
		}
		
		$DOCUMENT['mod']['data']['partition_tree'] = $partition_manager_obj->get_all_partition_trees();
		$DOCUMENT['mod']['data']['partition_info'] = $partition_manager_obj->get_partition(std_lib::GET('id'));
		
		if($DOCUMENT['mod']['data']['partition_info'] == false)
		{
			$MOD_MESSAGE = "Данного раздела не существует";
			header("Location: index.php?p=site&errmsg=".rawurlencode($MOD_MESSAGE));
			exit;			
		}
//		$partition_manager_obj->debug($DOCUMENT['mod']['data']['partition_tree']);
		
		break;
	case "update_partition":
		//$partition_manager_obj->debug($_POST);
//		echo std_lib::POST('text');exit;
		if(($partition_manager_obj->set_title(std_lib::POST('title'))) && ($partition_manager_obj->set_id(std_lib::POST('prt_id'))))
		{
			$partition_manager_obj->set_text(std_lib::POST('text'));
			$partition_manager_obj->set_meta_keyword(std_lib::POST('meta_keyword'));
			$partition_manager_obj->set_meta_description(std_lib::POST('meta_description'));
			$partition_manager_obj->set_owner_id(std_lib::POST('subpart'));
			
			$inherit_tpl = trim(std_lib::POST('inherit_tpl'));
			if($inherit_tpl == "yes")
			{
				$partition_manager_parent_obj = new partition_manager($SYS, $ThisModuleInfo, $MY_USER_DATA);
				$parent_partition_info = $partition_manager_parent_obj->get_partition(std_lib::POST('subpart'));
				if(is_array($parent_partition_info))
				{
					$partition_manager_obj->set_template($parent_partition_info['template']);
				}
				else 
				{
					$parent_partition_info = $partition_manager_parent_obj->get_partition('1');
					if(is_array($parent_partition_info))
						$partition_manager_obj->set_template($parent_partition_info['template']);
				}
			}
			else 
				$partition_manager_obj->set_template(std_lib::POST('template'));
						
			$partition_manager_obj->set_status(std_lib::POST('publish'));
			$partition_manager_obj->set_penname(std_lib::POST('penname'));
			$partition_manager_obj->set_access_level(std_lib::POST('access_level'));
			
			if($partition_manager_obj->save_partition())
			{
				$MOD_MESSAGE = "Раздел сайта с заглавием '".htmlentities(std_lib::POST('title'),ENT_QUOTES, "UTF-8")."' успешно обновлён ";
				header("Location: index.php?p=site&msg=".rawurlencode($MOD_MESSAGE));
				exit;
			}
			else 
			{
				$MOD_MESSAGE = "Информация о разделе сайта не была обновлена из-за некорректных данных";
				header("Location: index.php?p=site&errmsg=".rawurlencode($MOD_MESSAGE));
				exit;
			}
			
		}
		//exit;
		
		break;
	case "add_category": //* форма создания категории
		$errmsg = trim(rawurldecode(trim(std_lib::GET('errmsg'))));
		if($errmsg != "") $DOCUMENT['ERR_MSG'] = $errmsg;
		
		$MOD_TEMPALE = "category_form.tpl";
		$MOD_ACTION = 'create_category';
		
		$DOCUMENT['mod']['data']['partition_tree'] = $partition_manager_obj->get_all_partition_trees();
		
//		$partition_manager_obj->debug($DOCUMENT['mod']['data']['partition_tree']);
		
		break;
	case "edit_category": //* форма редактирования категории
		$errmsg = trim(rawurldecode(trim(std_lib::GET('errmsg'))));
		if($errmsg != "") $DOCUMENT['ERR_MSG'] = $errmsg;
		
		$DOCUMENT['mod']['data']['category_info'] = $partition_manager_obj->get_category(std_lib::GET('id'));
		$DOCUMENT['mod']['data']['partition_info'] = $partition_manager_obj->get_partition($DOCUMENT['mod']['data']['category_info']['prt_id']);
		
		$MOD_TEMPALE = "category_form.tpl";
		$MOD_ACTION = 'update_category';
		
		$DOCUMENT['mod']['data']['partition_tree'] = $partition_manager_obj->get_all_partition_trees();
		
//		$partition_manager_obj->debug($DOCUMENT['mod']['data']['partition_tree']);
		
		break;
	case "create_category": //* Создание новой категории
		$partition_manager_obj->purge_variables();
		if($partition_manager_obj->set_title(std_lib::POST('title')))
		{
			if($partition_manager_obj->set_category_owner_id(std_lib::POST('subpart')))
			{
				if($partition_manager_obj->save_category())
				{
					$MOD_MESSAGE = "Категория с заглавием '".htmlentities(std_lib::POST('title'),ENT_QUOTES, "UTF-8")."' успешно создна ";
					header("Location: index.php?p=site&msg=".rawurlencode($MOD_MESSAGE));
					exit;
				}				
			}
		}
		$MOD_MESSAGE = "Категория создана не была из-за некорректных данных";
		header("Location: index.php?p=site&errmsg=".rawurlencode($MOD_MESSAGE));
		exit;
		
		break;
	case "update_category": //* изменение данных категории
		$partition_manager_obj->purge_variables();
		if($partition_manager_obj->set_id(std_lib::POST('ctgr_id')))
		{
			if($partition_manager_obj->set_title(std_lib::POST('title')))
			{		
				if($partition_manager_obj->save_category())
				{
					$MOD_MESSAGE = "Категория с заглавием '".htmlentities(std_lib::POST('title'),ENT_QUOTES, "UTF-8")."' успешно обновлена ";
					header("Location: index.php?p=site&msg=".rawurlencode($MOD_MESSAGE));
					exit;
				}				
			
			}
		}
		$MOD_MESSAGE = "Категория создана не была из-за некорректных данных";
		header("Location: index.php?p=site&errmsg=".rawurlencode($MOD_MESSAGE));
		exit;
		
		break;
	case "ls_category": //* отображение категорий для выбранного раздела сайта
		
		$MOD_TEMPALE = "ls_category.tpl";
		
		$id  = (int)trim(std_lib::GET('id'));
		$partition_info = $partition_manager_obj->get_partition($id);
		
			$DOCUMENT['mod']['data']['partition_info'] = $partition_info;
			$DOCUMENT['mod']['data']['category_list'] = $partition_manager_obj->get_category_list_4_partition($id);
		
		break;
	case "rm_category": //* удаление категории
		$id = ( isset($HTTP_POST_VARS['id']) ) ? $HTTP_POST_VARS['id'] : $HTTP_GET_VARS['id'];
		
		
		$result ="";
		if(is_array($id))
		{
			$n = count($id);
			for($i=0; $i<$n; $i++)
			{				
				$category_info = $partition_manager_obj->get_category();
				$result .= "removing '".$category_info."' .... ".$partition_manager_obj->remove_category((int)$id[$i])."\n";				
				
			}
		}
		else 
		{
			$category_info = $partition_manager_obj->get_category();
			$result .= "removing '".$category_info."' .... ".$partition_manager_obj->remove_category((int)$id)."\n";				
		}
		
		$MOD_MESSAGE = "Произведены изменения в списке категорий. Проверте целостность данных";
		header("Location: index.php?p=site&msg=".rawurlencode($MOD_MESSAGE));
		exit;

		break;
	case "update_prt":
		
		$id = std_lib::POST_GET('prt_id');
		$status = std_lib::POST_GET('status_action') ;
		
		if($status != "none")
		{
			$partition_manager_obj->purge_variables();
			$partition_manager_obj->set_status($status);
			
			$err_flag = 0;
			if(!is_array($id))
			{
				$partition_manager_obj->set_id($id);			
				if(!$partition_manager_obj->update_partition_status())$err_flag=1;
			}
			else
			{
				$n = count($id);
				for($i=0; $i<$n; $i++)
				{
					$partition_manager_obj->set_id($id[$i]);			
					if(!$partition_manager_obj->update_partition_status())$err_flag=1;
				}
			}
		}
		if($err_flag==0)
			$MOD_MESSAGE = "Статутсы разделов успешно обновлены";
		else 
			$MOD_MESSAGE = "Во время обновления статусов разделов произошли ошибки";
		header("Location: index.php?p=site&msg=".rawurlencode($MOD_MESSAGE));
		exit;
		break;
	case "choose_folder":
		$MOD_TEMPALE = "folder_form.tpl";		
		$DOCUMENT['mod']['data']['sub_tpl_folder_list']=$THIS_MODULE_DIR_NAME."folder_list.tpl";
		//$partition_manager_obj->debug($SYS);
		$DOCUMENT['mod']['data']['catalog_list'] = $partition_manager_obj->ls_dir();
		$DOCUMENT['mod']['data']['partition_info'] = $partition_manager_obj->get_partition(std_lib::GET('prt_id'));
		break;
	case "ls_dir_ajax":
		$layout_template = $THIS_MODULE_DIR_NAME."folder_list.tpl";
		//$partition_manager_obj->debug($SYS);
		$path = std_lib::POST_GET('path');
		$DOCUMENT['mod']['data']['current_path'] = trim($path);
		$DOCUMENT['mod']['data']['catalog_list'] = $partition_manager_obj->ls_dir($path);
		$DOCUMENT['mod']['data']['linked_full_path_to'] = $partition_manager_obj->get_linked_full_path_to($path);
		break;
	case "mkdir":
		$layout_template = $THIS_MODULE_DIR_NAME."folder_list.tpl";
		
		$new_name = std_lib::POST_GET('new_name');
		$current_path = std_lib::POST_GET('current_path');
		
		
		if($partition_manager_obj->set_catalog_owner($current_path))
		{
			if($partition_manager_obj->create_new_catalog($new_name))
				$DOCUMENT['mod']['data']['msg'] = "Каталог '".$new_name."' успешно создан.";				
			else 
				$DOCUMENT['mod']['data']['errmsg'] = "Во время создания каталога произошли ошибки";
		}
		
		
		
		
		$DOCUMENT['mod']['data']['current_path'] = trim($current_path);
		$DOCUMENT['mod']['data']['catalog_list'] = $partition_manager_obj->ls_dir($current_path);
		$DOCUMENT['mod']['data']['linked_full_path_to'] = $partition_manager_obj->get_linked_full_path_to($current_path);
		break;
	case "rmdir":
		
		$rmdir_name = std_lib::POST_GET('rmdir_name') ;
		$current_path = std_lib::POST_GET('current_path') ;
		
		if($partition_manager_obj->rm_catalog($rmdir_name))
			$DOCUMENT['mod']['data']['msg'] = "Каталог '".$rmdir_name."' успешно удалён.";
		else 
			$DOCUMENT['mod']['data']['errmsg'] = "Во время удаления каталога  '".$rmdir_name."' произошли ошибки";
		
		
		$layout_template = $THIS_MODULE_DIR_NAME."folder_list.tpl";
		//$partition_manager_obj->debug($SYS);
		$path = $current_path;
		$DOCUMENT['mod']['data']['current_path'] = trim($path);
		$DOCUMENT['mod']['data']['catalog_list'] = $partition_manager_obj->ls_dir($path);
		$DOCUMENT['mod']['data']['linked_full_path_to'] = $partition_manager_obj->get_linked_full_path_to($path);
		
		
		break;
	case "link_path":
		$id = std_lib::POST_GET('prt_id') ;
		$path = std_lib::POST_GET('path') ;
		$current_path = std_lib::POST_GET('current_path') ;
				
		$partition_manager_obj->link_catalog_to_partition($path, $id);
		
		$layout_template = $THIS_MODULE_DIR_NAME."folder_list.tpl";
		//$partition_manager_obj->debug($SYS);
		$path = $current_path;
		$DOCUMENT['mod']['data']['current_path'] = trim($path);
		$DOCUMENT['mod']['data']['catalog_list'] = $partition_manager_obj->ls_dir($path);
		$DOCUMENT['mod']['data']['linked_full_path_to'] = $partition_manager_obj->get_linked_full_path_to($path);
		break;
	case "unlink_path":
		$id = std_lib::POST_GET('prt_id') ;
		$current_path = std_lib::POST_GET('current_path') ;
		
		$partition_manager_obj->unlink_partition($id);
		
		$layout_template = $THIS_MODULE_DIR_NAME."folder_list.tpl";
		//$partition_manager_obj->debug($SYS);
		$path = $current_path;
		$DOCUMENT['mod']['data']['current_path'] = trim($path);
		$DOCUMENT['mod']['data']['catalog_list'] = $partition_manager_obj->ls_dir($path);
		$DOCUMENT['mod']['data']['linked_full_path_to'] = $partition_manager_obj->get_linked_full_path_to($path);
		break;
}





$tpl->assign("MOD_ACTION", $MOD_ACTION); // присвоение действия внутри модуля для форм


//$nista->debug($template_data);



// *************** присваиваем значение шаблона модуля *************
$tpl->assign("MOD_TEMPLATE", $THIS_MODULE_DIR_NAME.$MOD_TEMPALE);
?>