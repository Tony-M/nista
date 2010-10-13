<?php
if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");
$THIS_MODULE_DIR_NAME= "../".str_ireplace("index.php", "",$Mod_Way)."tpl/";


$MOD_TEMPALE = "mod_index.tpl"; // Шаблон модуля поумолчанию

$ThisModuleInfo = $nista->get_module_info_by_par($p); // информация о данном модуле

$DOCUMENT['mod']['data'] = array(); // очищаем данные модуля для вывода


//
// Set sp
//
$sp = std_lib::POST_GET('sp');
if($sp=="")$sp = 'ind';

if(!class_exists("tpl_manager"))
{
	header("Location: index.php");
	exit;
}

$tpl_manager_obj = new tpl_manager($SYS, $MY_USER_DATA);
$template_data = $tpl_manager_obj->load_config();


switch ($sp)
{
	default:
	case "ind":
		// проверяем необходимость отображения системного сообщения
		$msg = trim(rawurldecode(trim(std_lib::GET('msg'))));
		if($msg != "") $DOCUMENT['MSG'] = $msg;
		
		$err_msg = trim(rawurldecode(trim(std_lib::GET('errmsg'))));
		if($err_msg != "") $DOCUMENT['ERR_MSG'] = $err_msg;
		
		$DOCUMENT['mod']['data']['file_content'] = $template_data;
		break;
	case "add_tpl": //** Форма добавления новгого layout
		// проверяем необходимость отображения системного сообщения об ошибках
		$errmsg = trim(rawurldecode(trim(std_lib::GET('errmsg'))));
		if($errmsg != "") $DOCUMENT['ERR_MSG'] = $errmsg;
	
		$MOD_TEMPALE = "layout_form.tpl";
		$MOD_ACTION = 'upload_tpl';
		break;
	case "upload_tpl"://** Загрузка и создание новго Layout
		$title = trim(std_lib::POST('title'));
		$description = trim($_POST['description']);
		
		$MOD_MESSAGE = ""; //сообщение об ошибках или удачах
			
		if(strtolower(substr($_FILES["tpl_file"]["name"], -4)) <> ".tpl")
		{
			$MOD_MESSAGE .= "Недопустимый формат файла<br>";
		}
		
		if($title == "") $MOD_MESSAGE .= "Недопустимое имя Layout<br>";
		if($MOD_MESSAGE != "")
		{
			header("Location: index.php?p=tpl&sp=add_tpl&errmsg=".rawurlencode($MOD_MESSAGE));
			exit;
		}
		
		if(copy($_FILES["tpl_file"]["tmp_name"], $SYS['ROOT_WAY']."includes/tpl/layout_".$_FILES["tpl_file"]["name"]))
		{
			$MOD_MESSAGE = "<b>Файл успешно загружен<b><br>";
			$MOD_MESSAGE .= "<b>Характеристики файла:</b> <br>";
			$MOD_MESSAGE .= "<b>Имя файла:</b> ";
			$MOD_MESSAGE .= "layout_".$_FILES["tpl_file"]["name"];
			$MOD_MESSAGE .= "<br><b>Размер файла:</b> ";
			$MOD_MESSAGE .= $_FILES["tpl_file"]["size"];
			
			$n = count($template_data['layout']);
			$template_data['layout'][$n]['title']=$title;
			$template_data['layout'][$n]['description']=$description;
			$template_data['layout'][$n]['file']="layout_".$_FILES["tpl_file"]["name"];
			
			$template_data_yaml = Spyc::YAMLDump($template_data);
			file_put_contents(PUBLIC_CONFIG_DIR.'tpl.yaml', $template_data_yaml);
			
			header("Location: index.php?p=tpl&msg=".rawurlencode($MOD_MESSAGE));
			exit;
		} 
		else 
		{
			$MOD_MESSAGE = "Ошибка загрузки файла";
			header("Location: index.php?p=tpl&sp=add_tpl&errmsg=".rawurlencode($MOD_MESSAGE));
			exit;
		}

		
		break;
	case "add_zone": //** Форма добавления новой информационной зоны
		// проверяем необходимость отображения системного сообщения об ошибках
		$errmsg = trim(rawurldecode(trim(std_lib::GET('errmsg'))));
		if($errmsg != "") $DOCUMENT['ERR_MSG'] = $errmsg;
	
		$MOD_TEMPALE = "zone_form.tpl";
		$MOD_ACTION = 'create_zone';
		
		
		//print_r(array_splice($template_data['layout'],1,1));
		break;
	case "edit_zone":
		$errmsg = trim(rawurldecode(trim(std_lib::GET('errmsg'))));
		if($errmsg != "") $DOCUMENT['ERR_MSG'] = $errmsg;
		
		$zone_name = trim(std_lib::GET('zone_name'));
		$DOCUMENT['mod']['data']['current_zone']=$tpl_manager_obj->get_zone_info($zone_name);
		if($DOCUMENT['mod']['data']['current_zone'] == false)
		{
			$MOD_MESSAGE = "Информационной зоны с таким именем не существует";
			header("Location: index.php?p=tpl&errmsg=".rawurlencode($MOD_MESSAGE));
			exit;
		}
		
		$MOD_TEMPALE = "zone_form.tpl";
		$MOD_ACTION = 'update_zone';
		break;
	case "create_zone": //** создание новой информационной зоны
		$name = trim(std_lib::POST('name'));
		$title = trim(std_lib::POST('title'));
		$description = trim(std_lib::POST('description'));
		
		
		if($name == "")
		{
			$MOD_MESSAGE = "Не задано имя информационной зоны";
			header("Location: index.php?p=tpl&sp=add_zone&errmsg=".rawurlencode($MOD_MESSAGE));
			exit;
		}
		
		$tpl_manager_obj->set_zone_name($name);
		$tpl_manager_obj->set_title($title);
		$tpl_manager_obj->set_description($description);
		
		if(!$tpl_manager_obj->create_zone())
		{
			$MOD_MESSAGE = "Зона с таким именем уже существует";
			header("Location: index.php?p=tpl&sp=add_zone&errmsg=".rawurlencode($MOD_MESSAGE));
			exit;
		}
		
		$MOD_MESSAGE = "Информационная зона с именем <b>".$name."</b> успешно создана";
		header("Location: index.php?p=tpl&msg=".rawurlencode($MOD_MESSAGE));
		exit;
		
		break;
	case "update_zone":
		$name = trim(std_lib::POST('name'));
		$current_name = trim(std_lib::POST('current_name'));
		$title = trim(std_lib::POST('title'));
		$description = trim(std_lib::POST('description'));
		
		if(($current_name=="") || ($title==""))
		{
			$MOD_MESSAGE = "Не задано имя или название информационной зоны";
			header("Location: index.php?p=tpl&sp=edit_zone&zone_name=".$current_name."&errmsg=".rawurlencode($MOD_MESSAGE));
			exit;
		}
		
		$tpl_manager_obj->set_zone_name($current_name);
		$tpl_manager_obj->set_title($title);
		$tpl_manager_obj->set_description($description);
		
		if($tpl_manager_obj->update_zone())
		{
			$tpl_manager_obj->save_config();
			$MOD_MESSAGE = "Информация о параметрах информационной зоны обновлена";
			header("Location: index.php?p=tpl&msg=".rawurlencode($MOD_MESSAGE));
			exit;
		}
		
		$MOD_MESSAGE = "Сбой обновления параметров информационной зоны";
		header("Location: index.php?p=tpl&errmsg=".rawurlencode($MOD_MESSAGE));
		exit;
		
		break;
	case "ls_zone_link":
		$zone_name = trim(std_lib::GET('zone_name'));
				
		if($zone_name != "")
		{
			$DOCUMENT['mod']['data']['current_zone']=$tpl_manager_obj->get_zone_info($zone_name);
			
			$DOCUMENT['mod']['data']['zone_name'] = $zone_name;
//			$DOCUMENT['mod']['data']['flag']['zone'] = "on";
			$MOD_TEMPALE = "zone_links_to.tpl";
			
			$n = count($template_data['layout_zone_link']);
			
			$search_result = array();
			
			// поиск привязок зоны к лайауту
			for($i=0; $i<$n; $i++)
			{
				if(in_array($zone_name, $template_data['layout_zone_link'][$i]['contain']))
					$search_result[] = $template_data['layout_zone_link'][$i]['file'];				
			}
			
			// формирование массива с имеющимися привязками и свободного массива
			$m = count($search_result);
			$n = count($template_data['layout']);
			
			$DOCUMENT['mod']['data']['linked_layouts'] = array();
			$DOCUMENT['mod']['data']['not_linked_layouts'] = array();
			$k1 = 0;
			$k2 = 0;
			for($i=0; $i<$n; $i++)
			{
				$exist_flag = 0;
				for($j=0; $j<$m; $j++)
				{
					if($template_data['layout'][$i]['file'] == $search_result[$j])
					{
						// элемент найден
						$DOCUMENT['mod']['data']['linked_layouts'][$k1]['title'] =  $template_data['layout'][$i]['title'];
						$DOCUMENT['mod']['data']['linked_layouts'][$k1]['file'] =  $template_data['layout'][$i]['file'];
						$DOCUMENT['mod']['data']['linked_layouts'][$k1]['description'] =  $template_data['layout'][$i]['description'];
						$exist_flag = 1;
						$k1++;
					}
				}
				
				if($exist_flag==0)
				{
					// элемент не найден
					$DOCUMENT['mod']['data']['not_linked_layouts'][$k2]['title'] =  $template_data['layout'][$i]['title'];
					$DOCUMENT['mod']['data']['not_linked_layouts'][$k2]['file'] =  $template_data['layout'][$i]['file'];
					$DOCUMENT['mod']['data']['not_linked_layouts'][$k2]['description'] =  $template_data['layout'][$i]['description'];
					
					$k2++;
				}
				$exist_flag = 1;
				
			}
			
		}
		break;
	case "zone_link_update":
		$link_file = std_lib::POST('link_file');
		
		$unlink_file = std_lib::POST('unlink_file');
		$zone_name = std_lib::POST('zone_name');
		
		
		// подлинковка зоны к лайауту
		$link_num = count($link_file);
		
		for($i=0; $i<$link_num; $i++)
		{
			$tpl_manager_obj->set_new_zone_link($zone_name, $link_file[$i]);
		}
		$tpl_manager_obj->save_config();
		
		
		// отлинковка зон от лайаутов
		$unlink_num = count($unlink_file);
		
		for($i=0; $i<$unlink_num; $i++)
		{
			$tpl_manager_obj->remove_zone_link($zone_name, $unlink_file[$i]);
		}
		$tpl_manager_obj->save_config();
		
		
		$MOD_MESSAGE = "Информация о привязках информационных зон обновлена";
		header("Location: index.php?p=tpl&msg=".rawurlencode($MOD_MESSAGE));
		exit;
		break;		
	case "ls_layout_zones":
		$errmsg = trim(rawurldecode(trim(std_lib::GET('errmsg'))));
		if($errmsg != "") $DOCUMENT['ERR_MSG'] = $errmsg;
	
		$file = trim(std_lib::GET('file'));
		$DOCUMENT['mod']['data']['current_layout'] = $tpl_manager_obj->get_layout_info($file);
		
		$linked_zones = $tpl_manager_obj->get_layout_zones($file);
		
		if($linked_zones != false)
		{
			$n = count($linked_zones);
			for($i=0; $i<$n; $i++)
			{
				$linked_zones[$i] = $tpl_manager_obj->get_zone_info($linked_zones[$i]);
			}
			$DOCUMENT['mod']['data']['linked_zones'] = $linked_zones;
		}
		
		$DOCUMENT['mod']['data']['unlinked_zones'] = $tpl_manager_obj->get_not_layout_zones($file);
		
		$MOD_TEMPALE = "layout_link_content.tpl";
		
		break;
		
	case "update_link_layout":
		
		$link_zone = std_lib::POST('link_zone');		
		$unlink_zone = std_lib::POST('unlink_zone');
		
		$layout_file = std_lib::POST('layout_file');
		
		
		// подлинковка зоны к лайауту
		$link_num = count($link_zone);
		
		for($i=0; $i<$link_num; $i++)
		{
			$link_zone[$i];
			$tpl_manager_obj->set_new_zone_link( $link_zone[$i], $layout_file);
		}
		$tpl_manager_obj->save_config();
		
		
		// отлинковка зон от лайаутов
		$unlink_num = count($unlink_zone);
		
		for($i=0; $i<$unlink_num; $i++)
		{
			$tpl_manager_obj->remove_zone_link($unlink_zone[$i], $layout_file);
		}
		$tpl_manager_obj->save_config();
		//$tpl_manager_obj->debug();
		
		$MOD_MESSAGE = "Информация о привязках информационных зон обновлена";
		header("Location: index.php?p=tpl&msg=".rawurlencode($MOD_MESSAGE));
		exit;
		break;		
	case "add_menu": //** Форма добавления шаблона меню
		// проверяем необходимость отображения системного сообщения об ошибках
		$errmsg = trim(rawurldecode(trim(std_lib::GET('errmsg'))));
		if($errmsg != "") $DOCUMENT['ERR_MSG'] = $errmsg;
	
		$MOD_TEMPALE = "menu_form.tpl";
		$MOD_ACTION = 'create_menu';
		break;
	case "create_menu":
		$name = std_lib::POST_GET('name');
		$title = std_lib::POST_GET('title');
		$description = std_lib::POST_GET('description');
				
		$MOD_MESSAGE = ""; //сообщение об ошибках или удачах
			
		if(strtolower(substr($_FILES["tpl_file"]["name"], -4)) <> ".tpl")
		{
			$MOD_MESSAGE .= "Недопустимый формат файла<br>";
		}
		
		if($title == "") $MOD_MESSAGE .= "Недопустимое имя шаблона меню<br>";
		if($MOD_MESSAGE != "")
		{
			header("Location: index.php?p=tpl&sp=add_menu&errmsg=".rawurlencode($MOD_MESSAGE));
			exit;
		}
		
		if(copy($_FILES["tpl_file"]["tmp_name"], $SYS['ROOT_WAY']."includes/tpl/menu_".$_FILES["tpl_file"]["name"]))
		{
			
			$MOD_MESSAGE = "<b>Файл успешно загружен<b><br>";
			$MOD_MESSAGE .= "<b>Характеристики файла:</b> <br>";
			$MOD_MESSAGE .= "<b>Имя файла:</b> ";
			$MOD_MESSAGE .= "menu_".$_FILES["tpl_file"]["name"];
			$MOD_MESSAGE .= "<br><b>Размер файла:</b> ";
			$MOD_MESSAGE .= $_FILES["tpl_file"]["size"];
			
			$n = count($template_data['menu']);
			$template_data['menu'][$n]['name']=$name;
			$template_data['menu'][$n]['title']=$title;
			$template_data['menu'][$n]['description']=$description;
			$template_data['menu'][$n]['file']="menu_".$_FILES["tpl_file"]["name"];
			
			$template_data_yaml = Spyc::YAMLDump($template_data);
			file_put_contents(PUBLIC_CONFIG_DIR.'tpl.yaml', $template_data_yaml);
			
			header("Location: index.php?p=tpl&msg=".rawurlencode($MOD_MESSAGE));
			exit;
		} 
		else 
		{
			$MOD_MESSAGE = "Ошибка загрузки файла";
			header("Location: index.php?p=tpl&sp=add_menu&errmsg=".rawurlencode($MOD_MESSAGE));
			exit;
		}		
		break;
	case "ls_menu":
		$MOD_TEMPALE = "ls_menu.tpl";
		
		// проверяем необходимость отображения системного сообщения
		$msg = trim(rawurldecode(trim(std_lib::GET('msg'))));
		if($msg != "") $DOCUMENT['MSG'] = $msg;
		
		$err_msg = trim(rawurldecode(trim(std_lib::GET('errmsg'))));
		if($err_msg != "") $DOCUMENT['ERR_MSG'] = $err_msg;
		
		$DOCUMENT['mod']['data']['file_content'] = $template_data;
		break;
	case "edit_menu":
		$errmsg = trim(rawurldecode(trim(std_lib::GET('errmsg'))));
		if($errmsg != "") $DOCUMENT['ERR_MSG'] = $errmsg;
		
		$menu_name = trim(std_lib::GET('menu_name'));
		$DOCUMENT['mod']['data']['current_menu']=$tpl_manager_obj->get_menu_info($menu_name);
		if($DOCUMENT['mod']['data']['current_menu'] == false)
		{
			$MOD_MESSAGE = "Шаблона меню с таким именем не существует";
			header("Location: index.php?p=tpl&sp=ls_menu&errmsg=".rawurlencode($MOD_MESSAGE));
			exit;
		}
		
		$MOD_TEMPALE = "menu_form.tpl";
		$MOD_ACTION = 'update_menu';
		break;
	case "update_menu":
		$name = std_lib::POST_GET('name');
		$current_name = std_lib::POST_GET('current_name');
		$title = std_lib::POST_GET('title');
		$description = std_lib::POST_GET('description');
				
		$MOD_MESSAGE = ""; //сообщение об ошибках или удачах
			
		if($_FILES["tpl_file"]["name"] != "")
		{
			if(strtolower(substr($_FILES["tpl_file"]["name"], -4)) <> ".tpl")
			{
				$MOD_MESSAGE .= "Недопустимый формат файла<br>";
			}
		}	
		
		if($title == "") $MOD_MESSAGE .= "Недопустимое имя шаблона меню<br>";
		if($MOD_MESSAGE != "")
		{
			header("Location: index.php?p=tpl&sp=add_menu&errmsg=".rawurlencode($MOD_MESSAGE));
			exit;
		}
		
		if($_FILES["tpl_file"]["tmp_name"] != "")
		{
			if(copy($_FILES["tpl_file"]["tmp_name"], $SYS['ROOT_WAY']."includes/tpl/menu_".$_FILES["tpl_file"]["name"]))
			{
				
				$MOD_MESSAGE = "<b>Файл успешно загружен<b><br>";
				$MOD_MESSAGE .= "<b>Характеристики файла:</b> <br>";
				$MOD_MESSAGE .= "<b>Имя файла:</b> ";
				$MOD_MESSAGE .= "menu_".$_FILES["tpl_file"]["name"];
				$MOD_MESSAGE .= "<br><b>Размер файла:</b> ";
				$MOD_MESSAGE .= $_FILES["tpl_file"]["size"];
				
				$n = count($template_data['menu']);
				for($i = 0; $i<$n; $i++)
				{
					if($template_data['menu'][$i]['name']==$current_name)
					{
						$template_data['menu'][$i]['title']=$title;
						$template_data['menu'][$i]['description']=$description;
						$template_data['menu'][$i]['file']="menu_".$_FILES["tpl_file"]["name"];
					}
				}
				$template_data_yaml = Spyc::YAMLDump($template_data);
				file_put_contents(PUBLIC_CONFIG_DIR.'tpl.yaml', $template_data_yaml);
				
				header("Location: index.php?p=tpl&sp=ls_menu&msg=".rawurlencode($MOD_MESSAGE));
				exit;
			} 
			else 
			{
				$MOD_MESSAGE = "Ошибка загрузки файла";
				header("Location: index.php?p=tpl&sp=add_menu&errmsg=".rawurlencode($MOD_MESSAGE));
				exit;
			}		
		}
		else 
		{
				$n = count($template_data['menu']);
				for($i = 0; $i<$n; $i++)
				{
					if($template_data['menu'][$i]['name']==$current_name)
					{
						$template_data['menu'][$i]['title']=$title;
						$template_data['menu'][$i]['description']=$description;
					}
				}
				$template_data_yaml = Spyc::YAMLDump($template_data);
				file_put_contents(PUBLIC_CONFIG_DIR.'tpl.yaml', $template_data_yaml);
				
				$MOD_MESSAGE = "Данные меню успешно обновлены";
				header("Location: index.php?p=tpl&sp=ls_menu&msg=".rawurlencode($MOD_MESSAGE));
				exit;
		}
		break;
		
	
}






$tpl->assign("MOD_ACTION", $MOD_ACTION); // присвоение действия внутри модуля для форм


//$nista->debug($template_data);



// *************** присваиваем значение шаблона модуля *************
$tpl->assign("MOD_TEMPLATE", $THIS_MODULE_DIR_NAME.$MOD_TEMPALE);
?>