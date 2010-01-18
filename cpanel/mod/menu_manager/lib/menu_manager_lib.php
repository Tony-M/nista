<?php
if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");

class menu_manager extends base_validation
{
	private $DATA = array();

	// незыблимые прототипы
	private $p_TBL_NISTA_MENU = "menu";
	private $p_TBL_NISTA_MENU_LINKS = "menu_links";
	private $p_TBL_NISTA_MENU_RELATION = "menu_relation";
	
	private $p_STATUS_LIST = array("on", "off", "wait", "del");

	// Рабочие переменные
	private $TBL_NISTA_MENU = "menu";
	private $TBL_NISTA_MENU_LINKS = "menu_links";
	private $TBL_NISTA_MENU_RELATION = "menu_relation";
	
	private $_TARGET = array("_self", "_parent", "_top", "_blank");
	
	public $PREFIX = "tbl_nista_";

	/**
	 * Метод отображает структурноедерево данных передаваемого аргумента в целях отладки
	 *
	 * @param mixed $inp
	 */
	public function debug($inp = "")
	{
		echo "<hr><pre>";
		if($inp == "") print_r($this->DATA);
		else print_r($inp);
		echo "</pre>";
	}

	public function __construct($SYS = array(), $MOD_DATA=array() ,$USER_DATA=array())
	{
		if(!is_array($SYS))return false;
		if(count($SYS)== 0)return false;
		if(count($USER_DATA)== 0)return false;
		if(count($MOD_DATA)== 0)return false;
		if((int)($USER_DATA['uid'])==0) return false;

		$this->DATA = array();

		$this->DATA['SYS'] = $SYS;
		$this->DATA['USER_DATA'] = $USER_DATA;
		$this->DATA['MOD_DATA'] = $MOD_DATA;

		$this->DATA['STATUS_LIST']= $this->p_STATUS_LIST;

		$this->TBL_NISTA_MENU = $this->PREFIX.$this->p_TBL_NISTA_MENU;
		$this->TBL_NISTA_MENU_LINKS = $this->PREFIX.$this->p_TBL_NISTA_MENU_LINKS;
		$this->TBL_NISTA_MENU_RELATION = $this->PREFIX.$this->p_TBL_NISTA_MENU_RELATION;
		
		$this->load_config();
		
		//		$this->debug();
	}
	
	
	/**
	 * Метод загружает конфигурационную информацию из файла конфигурации
	 *
	 * @return array
	 */
	public function load_config()
	{
		$this->DATA['config'] = Spyc::YAMLLoad($this->DATA['SYS']['CONFIG_DIR'].'menu_manager.yaml');
		//$this->debug($this->DATA['config']);		
		return $this->DATA['config'];
	}

	/**
	 * Метод устанавливет menu_id 
	 *
	 * @param integer $menu_id
	 * @return boolean
	 */
	public function set_menu_id($menu_id="")
	{

		$menu_id=trim($menu_id);
		$menu_id = (int)$menu_id;
		if($menu_id==0)return false;
		$this->DATA['menu_id']=$menu_id;
		return true;
	}

	/**
	 * Метод устанавливает значение заголовка статьи 
	 *
	 * @param string $title заголовок статьи
	 * @return boolean
	 */
	public function set_title($title="")
	{

		$title=htmlentities(strip_tags($title),ENT_QUOTES, "UTF-8");
		$title=trim($title);
		if($title == "")return false;
		$this->DATA['title']=$title;
		return true;
	}

	/**
	 * Метод устанавливает значение всплывающей подсказки alt меню
	 *
	 * @param string $alt
	 * @return boolean
	 */
	public function set_alt($alt="")
	{

		$alt=htmlentities(strip_tags($alt),ENT_QUOTES, "UTF-8");
		$alt=trim($alt);
		$this->DATA['alt']=$alt;
		return true;
	}
	
	/**
	 * Метод устанавливает значение опционного поля текст для меню
	 *
	 * @param string $text
	 * @return boolean
	 */
	public function set_text($text="")
	{

		$text=htmlentities(strip_tags($text),ENT_QUOTES, "UTF-8");
		$text=trim($text);
		$this->DATA['text']=$text;
		return true;
	}

	/**
	 * Метод устанавливает значение флака show_title для заголовка меню
	 *
	 * @param string $show_title values: show | hide
	 * @return boolean
	 */
	public function set_show_title($show_title="show")
	{
		$show_title=htmlentities(strip_tags($show_title),ENT_QUOTES, "UTF-8");
		$show_title=trim($show_title);
		if($show_title == "")$show_title =  "show";
		$show_title = strtolower($show_title);
		if(($show_title!="show") && ($show_title!="hide"))$show_title = "show";
		if($show_title=="show")$this->DATA['show_title'] = 1;
		else $this->DATA['show_title'] = 0;
		
		return true;
	}

	/**
	 * Метод устанавливает комментарий к элементам меню
	 *
	 * @param string $comment
	 * @return boolean
	 */
	public function set_comment($comment="")
	{
		$comment=htmlentities(strip_tags($comment),ENT_QUOTES, "UTF-8");
		$comment=trim($comment);
		$this->DATA['comment']=$comment;
		return true;
	}
	
	/**
	 * Метод устанавливает значение иконки меню
	 *
	 * @param string $ico
	 * @return boolean
	 */
	public function set_ico($ico="")
	{
		$ico=htmlentities(strip_tags($ico),ENT_QUOTES, "UTF-8");
		$ico=trim($ico);
		$this->DATA['ico']=$ico;
		return true;
	}
	
	/**
	 * Методу устанавливает url ссылки
	 *
	 * @param string $url
	 * @return boolean
	 */
	public function set_url($url="")
	{

		$url=htmlentities(strip_tags($url),ENT_QUOTES, "UTF-8");
		$url=trim($url);
		if($url == "")return false;
		$this->DATA['url']=$url;
		return true;
	}

	/**
	 * Метод устанавливает свойство _target ссылки
	 *
	 * @param string $target
	 * @return boolean
	 */
	public function set_target($target = "")
	{
		$target = strtolower(trim($target));
		if(!in_array($target, $this->_TARGET))return false;
		
		$this->DATA['target'] = $target;
		return true;
	}
	
	/**
	 * Метод устанавливает статус 
	 *
	 * @param string $status статус  (поумолчанию = wait)
	 * @return boolean
	 */
	public function set_status($status="wait")
	{
		$status = trim(strip_tags($status));
		if($status == "")$status = "wait" ;
		$status = htmlentities($status,ENT_QUOTES, "UTF-8");
		if(!in_array($status, $this->DATA['STATUS_LIST']))
			return false;		
		$this->DATA['status'] = $status;
		return true;
	}
	
	/**
	 * Метод создаёт запись об исходных данных для формирования данной строки в таблице
	 *
	 * @param array $obj
	 * @return boolean
	 */
	public function set_obj($obj = array())
	{
		if(!is_array($obj))return false;
		
		$n=count($obj);
		for($i=0; $i<$n; $i++)
			$obj[$i] = htmlentities($obj[$i],ENT_QUOTES, "UTF-8");
		
		$obj = serialize($obj);
		$this->DATA['obj'] = $obj;
		return true;
	}
	
	
	/**
	 * Метод создаёт новый контейнер меню (plain)
	 *
	 * @return integer or False
	 */
	public function create_new_menu_container()
	{
		if($this->DATA['title'] == "") return false;
		$query = "insert into ".$this->TBL_NISTA_MENU." set 
					type='container', ";
		$query .= " title='".$this->DATA['title']."' ";
		$query .= " , comment='".$this->DATA['comment']."' ";

		if(($this->DATA['show_title']!=1) && ($this->DATA['show_title']!=0))$this->DATA['show_title']=1;

		$query .= " , show_title='".$this->DATA['show_title']."'";
		if(mysql_query($query))
			return mysql_insert_id();
		else
			return false;
	}
	
	/**
	 * Метод обновляет информацию о контейнере меню по его id
	 *
	 * @return boolean
	 */
	public function update_menu_container()
	{
		if($this->DATA['title'] == "") return false;
		if($this->DATA['menu_id'] == "") return false;
		
		$query = "update ".$this->TBL_NISTA_MENU." set ";
		$query .= " title='".$this->DATA['title']."' ";
		$query .= " , comment='".$this->DATA['comment']."' ";

		if(($this->DATA['show_title']!=1) && ($this->DATA['show_title']!=0))$this->DATA['show_title']=1;

		$query .= " , show_title='".$this->DATA['show_title']."' ";
		
		$query .= " where  type='container' and menu_id='".$this->DATA['menu_id']."'";
		return mysql_query($query);
	}
	
	/**
	 * Метод обновляет статус контейнера меню по его id
	 *
	 * @return boolean
	 */
	public function update_menu_container_status()
	{
		if($this->DATA['menu_id'] == "") return false;
		
		if(!in_array($this->DATA['status'], $this->DATA['STATUS_LIST'])) return false;		
		
		$query = "update ".$this->TBL_NISTA_MENU." 
					set
						status='".$this->DATA['status']."' 
					where
						type='container'
						and menu_id='".$this->DATA['menu_id']."'";
		//echo $query."<br>";
		return mysql_query($query);
	}
	
	/**
	 * Метод возвращает информацию о контейнере мееню по его id
	 *
	 * @param integer $id
	 * @return Array or False
	 */
	public function get_menu_container_by_id($id = 0)
	{
		$id = (int)$id;
		if(!$id)return false;
		
		$query = "select * from ".$this->TBL_NISTA_MENU." where type='container' and menu_id='".$id."'";
		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)==1))
		{
			$result = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);
			$this->DATA['menu_container']=$result;
			return $result;
		}
		return false;
	}

	/**
	 * Метод проверяет является ли создаваемый контейнер меню по своим параметрам дупликатом существующего
	 *
	 * @return boolean
	 */
	public function is_duplicate_new_menu_container()
	{
		$query = "select * from ".$this->TBL_NISTA_MENU."
					where 
						type = 'container'
						and title='".$this->DATA['title']."'
						and comment = '".$this->DATA['comment']."'";
		if((int)$this->DATA['menu_id']!=0) $query .= " and menu_id!='".$this->DATA['menu_id']."'";
		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			mysql_free_result($result_id);
			return true;
		}
		
		return false;
	}
	
	/**
	 * Метод проверяет, является и запись пунктом меню или нет
	 *
	 * @param integer $id
	 * @return Array or False
	 */
	public function is_menu_item($id = 0)
	{
		$id = (int)$id;
		if(!$id)return false;
		
		$query = "select * from ".$this->TBL_NISTA_MENU." where type='item' and menu_id='".$id."'";
		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)==1))
		{
			$result = mysql_fetch_array($result_id,MYSQL_ASSOC);
			mysql_free_result($result_id);
			
			$query = "select * from ".$this->TBL_NISTA_MENU_RELATION." where item_id='".$id."' limit 1";
			if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)==1))
			{
				$tmp = mysql_fetch_array($result_id,MYSQL_ASSOC);
				$result['menu_container_id'] = $tmp['parent_id'];
				mysql_free_result($result_id);
				
				return $result;
			}
			
			return false;
		}
		return false;
		
		
	}
	
	/**
	 * Метод возвращяет полный смисок контейнеров меню
	 *
	 * @return Array or False
	 */
	public function get_menu_list($prt_id=0)
	{
		$prt_id=(int)$prt_id;
		if(!$prt_id)
			$query = "select * from ".$this->TBL_NISTA_MENU." where type='container' order by title asc" ;
		else 
			$query = "select tb1.* from ".$this->TBL_NISTA_MENU." as tb1, ".$this->TBL_NISTA_MENU_LINKS." as tb2 
							where 
								tb1.type='container' and 
								tb1.menu_id=tb2.menu_id and
								tb2.prt_id='".$prt_id."'
							order by title asc" ;
		std_lib::log_query($query);
//		echo $query."<br>";
		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result = array();
			while ($tmp=mysql_fetch_array($result_id,MYSQL_ASSOC)) 
			{
				$result[] = $tmp;
			}
			mysql_free_result($result_id);
			return $result;
		}
		return false;
	}

	/**
	 * Метод возвращаеттекущую дату и время для datecreated
	 *
	 * @return string
	 */
	public function get_date()
	{
		return date("Y-m-d H:i:s");
	}


	/**
	 * метод возвращает максимальное значение порядка следования последовательностей
	 *
	 * @return integer
	 */
	public function get_max_sequence()
	{
		$query = "select max(sequence) as num from ".$this->TBL_NISTA_MENU;
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$sequence = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);
			return $sequence['num'];
		}
		else
		return 0;
	}

	/**
	 * Метод возвращает новое значение для последовательности
	 *
	 * @return integer
	 */
	public function get_new_sequence()
	{
		$seq = $this->get_max_sequence() + 1;
		return $seq;
	}

	/**
	 * Метод очищает переменные
	 *
	 */
	public function purge_variables()
	{
		$query = "describe ".$this->TBL_NISTA_MENU;
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{

			while ($tmp = mysql_fetch_array($result_id, MYSQL_ASSOC))
			{
				$desc = $tmp['Field'];
				$this->DATA[$desc] = '';
			}
		}
	}

	/**
	 * Метод возвращает список разделов, к которым привязано меню
	 *
	 * @param integer $menu_id
	 * @return array or False
	 */
	public function get_menu_links_2_partition($menu_id = 0)
	{
		$menu_id = (int)$menu_id;
		if(!$menu_id)return false;
		
		$query = "select * from ".$this->TBL_NISTA_MENU_LINKS." where menu_id='".$menu_id."'";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result= array();
			while($tmp = mysql_fetch_array($result_id,MYSQL_ASSOC))
			{
				$result[] = $tmp;
			}
			mysql_free_result($result_id);
			return $result;
		}
		return false;
	}
	
	public function set_menu_links_2_partition($partition_id = array(), $zone_name = array(), $template_file=array())
	{
		if((!is_array($partition_id)) || (!count($partition_id))) return false;
		if((!is_array($zone_name)) || (!count($zone_name))) return false;
		if((!is_array($template_file)) || (!count($template_file))) return false;
		
		if((count($partition_id) != count($zone_name)) || (count($partition_id) !=  count($template_file)))return  false;
		
		//выбираем уже существующие привязки этого меню к разделам
		if($this->DATA['menu_id']==0)return false;
		$old_menu_links_array = $this->get_menu_links_2_partition($this->DATA['menu_id']);
		
		// для удобства объединим 3 переменные в один массив
		$input_links_array = array();
		$inp_num = count($partition_id);
		for($t=0; $t<$inp_num; $t++)
		{
			$input_links_array[$t]['prt_id'] = $partition_id[$t];
			$input_links_array[$t]['zone_name'] = $zone_name[$t];
			$input_links_array[$t]['tpl_file'] = $template_file[$t];
		}
		
		
		//$this->debug($input_links_array);
		//$this->debug($old_menu_links_array);
		
		
		if($old_menu_links_array)$old_num = count($old_menu_links_array);
		else $old_num = 0;
		
		if($old_num>0)
		{				
			
			//Начинаем искать линки меню, которы требуется удалить
			// для этого открываем цик по массиву существующих ссылок
			// и вложенный цикл по новому набору ссылок
			// Если в новом наборе нет старой ссылки то делаем делит из БД этой ссылки
			
			for($i=0; $i<$old_num; $i++)
			{
				
				$flag_exist = 0; // флаг равен 0 если строка ненайдена в новом наборе
				for($j=0; $j<$inp_num; $j++)
				{
					if(($input_links_array[$j]['prt_id']==$old_menu_links_array[$i]['prt_id'])&&($input_links_array[$j]['zone_name']==$old_menu_links_array[$i]['zone_name'])&&($input_links_array[$j]['tpl_file']==$old_menu_links_array[$i]['tpl_file']))
						$flag_exist = 1;					
				}
				
				if(!$flag_exist)
				{
					$query = "delete from ".$this->TBL_NISTA_MENU_LINKS." where id='".$old_menu_links_array[$i]['id']."'";
					mysql_query($query); // сюда вставить не просто удаление а удаление пунктов этого меню, чтоб они не заполоняли БД мёртвым грузом
					//echo $query."<br>";
					$query ="";
				}
				$flag_exist = 0;
			}
			
			// Теперь необходимо найти те линки, которые надо добавить в БД
			// для этого открываем цикл по новым линкам и ищем в старом списке те пункты, которых нет
			
			for($i=0;$i<$inp_num; $i++)
			{
				$this->set_new_link_menu_2_partition($input_links_array[$i]['prt_id'], $input_links_array[$i]['zone_name'], $input_links_array[$i]['tpl_file']);
			}
//			for($j=0; $j<$inp_num; $j++)
//			{
//				$flag_exist = 0; // флаг равен 0 если строка ненайдена в старом наборе
//				for($i=0; $i<$old_num; $i++)
//				{
//					if(($input_links_array[$j]['prt_id']==$old_menu_links_array[$i]['prt_id'])&&($input_links_array[$j]['zone_name']==$old_menu_links_array[$i]['zone_name'])&&($input_links_array[$j]['tpl_file']==$old_menu_links_array[$i]['tpl_file']))
//						$flag_exist = 1;					
//				}
//				
//				if(!$flag_exist)
//				{
//					
//					$this->set_new_link_menu_2_partition($input_links_array[$i]['prt_id'], $input_links_array[$i]['zone_name'], $input_links_array[$i]['tpl_file']);
//				}
//				$flag_exist = 0;
//			}
		}
		else 
		{
			for($i=0;$i<$inp_num; $i++)
			{
				$this->set_new_link_menu_2_partition($input_links_array[$i]['prt_id'], $input_links_array[$i]['zone_name'], $input_links_array[$i]['tpl_file']);
			}
		}
	}
	
	/**
	 * Метод создаёт связь меню и раздела
	 *
	 * @param integer $prt_id
	 * @param string $zone_name
	 * @param string $tpl_file
	 * @return boolean
	 */
	private  function set_new_link_menu_2_partition($prt_id=0, $zone_name="", $tpl_file="")
	{
		if((int)$prt_id == 0)return false;
		if(!eregi("[0-9a-z_]+", $zone_name))return false;
		if(!eregi("[0-9a-z_]+", $tpl_file))return false;
		
		// проверяем существует ли уже эта связь или нет
		$query = "select * from ".$this->TBL_NISTA_MENU_LINKS."
					where
						menu_id='".$this->DATA['menu_id']."' and  
						prt_id='".$prt_id."' and  
						zone_name='".$zone_name."' and 
						tpl_file='".$tpl_file."'";
		//echo $query."<br>";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			mysql_free_result($result_id);
			return false;
		}
		
		
		$query = "insert into ".$this->TBL_NISTA_MENU_LINKS."
						set
							menu_id='".$this->DATA['menu_id']."' , 
							prt_id='".$prt_id."' , 
							zone_name='".$zone_name."' ,
							tpl_file='".$tpl_file."'";
		return mysql_query($query); 
		//$query."<br>";
	}
	
	/**
	 * Метод проверяет существование связи меню и раздела
	 *
	 * @param integer $menu_id
	 * @param integer $prt_id
	 * @param string $zone_name
	 * @param string $tpl_file
	 * @return array or False
	 */
	public function check_menu_link_existanse($menu_id=0, $prt_id=0, $zone_name="", $tpl_file="")
	{
		$prt_id = (int)$prt_id;
		if(!$prt_id)return false;
		
		$menu_id = (int)$menu_id;
		if(!$menu_id)return false;
		
		$query = "select * from ".$this->TBL_NISTA_MENU_LINKS." 
						where
							menu_id='".$menu_id."' and
							prt_id='".$prt_id."' and
							zone_name='".$zone_name."' and
							tpl_file='".$tpl_file."'";
		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);
			return $result;
		}
		return false;		
	}

	
	/**
	 * Загрузка иконки меню
	 *
	 * @param string $file_field_name
	 * @return boolean
	 */
	public function upload_ico($file_field_name="")
	{
		if($file_field_name == "")return false;
		
		if(!in_array($_FILES[$file_field_name]["type"], $this->DATA['config']['ico_type']))
			return false;

		if($_FILES[$file_field_name]["size"]>$this->DATA['config']['ico_max_size'])return false;
		
		if($_FILES[$file_field_name]["error"] > 0)return false;
		
		if(!is_dir(ROOT_WAY.$this->DATA['config']['ico_dir']))return false;
		
		$new_file_name = $_FILES[$file_field_name]["name"];
		
		$flag=0;		
		while(!$flag)
		{
			if(file_exists(ROOT_WAY.$this->DATA['config']['ico_dir'].$new_file_name))
			{
				sleep(1);
				$new_file_name = mktime()."_".$_FILES[$file_field_name]["name"];
			}
			else 
				$flag = 1;
		}
		
		if(move_uploaded_file($_FILES[$file_field_name]['tmp_name'], ROOT_WAY.$this->DATA['config']['ico_dir'].$new_file_name))
			return $this->DATA['config']['ico_dir'].$new_file_name;
		else 
			return false;
				
	}
	
	/**
	 * Метод создаёт в БД новый пункт меню
	 *
	 * @return integer or False
	 */
	public function create_menu_item()
	{
		$query = "";
		
		$query .= "insert into ".$this->TBL_NISTA_MENU." set ";
		
		if($this->DATA['title']!="") $query .= " title='".$this->DATA['title']."' ";
		else return false;
		
		if($this->DATA['url']!="") $query .= ", url='".$this->DATA['url']."' ";
		else return false;
		
		$query .= ", type='item' ";
		
		$query .= ", status='wait' ";
		
		$query .= ", sequence='".$this->get_new_sequence()."' ";
		
		if($this->DATA['alt']!="") $query .= ", alt='".$this->DATA['alt']."' ";
		
		if($this->DATA['text']!="") $query .= ", text='".$this->DATA['text']."' ";
		
		if($this->DATA['show_title']!="") $query .= ", show_title='".$this->DATA['show_title']."' ";
		
		if($this->DATA['target']!="") $query .= ", target='".$this->DATA['target']."' ";
		
		if($this->DATA['ico']!="") $query .= ", ico='".$this->DATA['ico']."' ";
		
		if($this->DATA['obj']!="") $query .= ", obj='".$this->DATA['obj']."' ";
		
		//echo $query."<br>";
		if(mysql_query($query))
			return mysql_insert_id();
		else 
			return false;
	}
	
	/**
	 * Метод задаёт массив id контейнеров меню, содержащих  пункт меню
	 *
	 * @param array of integers $id
	 * @return boolean
	 */
	public function set_relation_container_id($id = array())
	{
		if(!is_array($id))return false;
		$n =count($id);
		if(!$n)return false;
		
		for($i=0; $i<$n; $i++)
			if((int)$id[$i] == 0) return false;
				
		$this->DATA['rel_parent_id'] = $id;
		return true;
	}
	
	/**
	 * Метод задаёт массив id разделов к которым привязывается пункт меню.
	 * если элемент массива = 0 то пункт привязывается ко всем разделам,
	 * к которым привязан контейнер меню
	 *
	 * @param array $id
	 * @return boolean
	 */
	public function set_relation_partition_id($id = array())
	{
		if(!is_array($id))return false;
		$n = count($id);
		if(!$n)return false;
		
		for($i=0; $i<$n; $i++)
			if((int)$id[$i] != $id[$i]) return false;
		
		$this->DATA['rel_prt_id'] = $id;
		return true;
	}
	
	/**
	 * Метод задаёт id пункта меню
	 *
	 * @param integer $id
	 * @return boolean
	 */
	public function set_relation_menu_item_id($id = 0)
	{
		if((int)$id==0)return false;
				
		$this->DATA['item_id'] = $id;
		return true;
	}
	
	/**
	 * метод устанавливает массив статусов для пункта меню в контейнерах и разделах
	 *
	 * @param array $status_array
	 * @return boolean
	 */
	public function set_relation_status($status_array = array())
	{
		if(!is_array($status_array))return false;
		if(!count($status_array))return false;
		
		$n = count($status_array);
		for($i=0; $i<$n; $i++)
		{
			if(!in_array($status_array[$i], $this->p_STATUS_LIST))
				return false; // error
		}
		
		$this->DATA['rel_status'] = $status_array;
		return true;
		
		
	}
	
	
	/**
	 * Метод создаёт связь пункта меню с контейнером для требуемых разделов
	 *
	 * @param штеупук $item_id
	 * @return boolean
	 */
	public function create_relation($item_id=0)
	{
		$item_id = (int)$item_id;
		if(!$item_id)return false;
		
		if(!is_array($this->DATA['rel_parent_id']))return false;
		$rel_parent_num = count($this->DATA['rel_parent_id']);
		if(!$rel_parent_num)return false;
		
		$rel_status_num = count($this->DATA['rel_status']);
		if(!$rel_status_num)return false;
		
		$rel_prt_id_num = count($this->DATA['rel_prt_id']);
		if(!$rel_prt_id_num)return false;	
		
		if(($rel_parent_num!=$rel_prt_id_num) || ($rel_prt_id_num!=$rel_status_num) || ($rel_parent_num!=$rel_status_num))	
			return false;
			
		for($i=0; $i<$rel_parent_num; $i++)
		{
			
			$query = "insert into ".$this->TBL_NISTA_MENU_RELATION."
						set
							parent_id='".$this->DATA['rel_parent_id'][$i]."', 
							item_id='".$item_id."',  
							prt_id='".$this->DATA['rel_prt_id'][$i]."',  
							status ='".$this->DATA['rel_status'][$i]."'";
			if(!mysql_query($query))
				return false;
		}
		
		return true;
			
	}
	
	public  function create_mass_menu_items()
	{
		if(!is_array($this->DATA['rel_parent_id']))return false;
		$rel_parent_num = count($this->DATA['rel_parent_id']);
		if(!$rel_parent_num)return false;
		
		$rel_status_num = count($this->DATA['rel_status']);
		if(!$rel_status_num)return false;
		
		$rel_prt_id_num = count($this->DATA['rel_prt_id']);
		if(!$rel_prt_id_num)return false;	
		
		if(($rel_parent_num!=$rel_prt_id_num) || ($rel_prt_id_num!=$rel_status_num) || ($rel_parent_num!=$rel_status_num))	
			return false;
			
		$unique_menu_ids = array(); // массив с уникальными контейнерами меню, к которым создавать пункты
		$unique_menu_ids = array_values(array_unique($this->DATA['rel_parent_id']));
		
		$unique_num = count($unique_menu_ids);
		
		if($unique_num)
		{
			for($j=0; $j<$unique_num; $j++) //цикл по уникальным меню
			{
				$item_id=$this->create_menu_item();
				if($item_id) // создали пункт для уникального меню и получили id пункта
				{
					for($i=0; $i<$rel_parent_num; $i++)
					{
						if($this->DATA['rel_parent_id'][$i] == $unique_menu_ids[$j])
						{
							$query = "insert into ".$this->TBL_NISTA_MENU_RELATION."
										set
											parent_id='".$this->DATA['rel_parent_id'][$i]."', 
											item_id='".$item_id."',  
											prt_id='".$this->DATA['rel_prt_id'][$i]."',  
											status ='".$this->DATA['rel_status'][$i]."'";
							//echo $query."<br>";
							if(!mysql_query($query))
							{
								$query = "delete from ".$this->TBL_NISTA_MENU." where menu_id='".$item_id."' limit 1";
								//echo $query."<br>";
								mysql_query($query);
								return false;
							}							
						}
					}					
				}
				else 
					return false;
			}
			return true;
		}
		
		return false;
				
	}
	
	
	public function get_menu_for_partition($partition_id = 0)
	{
		$partition_id = (int)$partition_id;
		if(!$partition_id)return false;
		
		$query = "select tb1.menu_id as menu_id, tb1.title as title, tb1.comment as comment  
					from 
						".$this->TBL_NISTA_MENU." as tb1, ".$this->TBL_NISTA_MENU_LINKS." as tb2
					where
						tb1.menu_id=tb2.menu_id and tb2.prt_id='".$partition_id."'";
		
		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$xml = new XMLWriter();
			$xml->openMemory();			
			$xml->startDocument('1.0', 'UTF-8');			
    		$xml->endDtd();			
    		$xml->startElement('items');
    		
    		while($tmp = mysql_fetch_array($result_id, MYSQL_ASSOC))
			{
				$xml->startElement('item');
				$xml->writeAttribute( 'id', $tmp['menu_id']);
				$xml->writeAttribute( 'title', $tmp['title']);
				$xml->writeAttribute( 'comment', $tmp['comment']);
				$xml->endElement(); 				
			}
			
			$xml->endElement();   
   			//$xml->endDtd();   			 
   			mysql_free_result($result_id);			
   			return  $xml->outputMemory(true);
		}
		else return false;
	}
	
	/**
	 * Метод возвращает список уникальных пунктов меню по id контейнера меню
	 *
	 * @param integer $menu_id
	 * @return Array or False
	 */
	public function get_distinct_item_list_for_menu_container($menu_id = 0)
	{
		$menu_id=(int)$menu_id;
		if(!$menu_id)return false;
		
		$query = "select distinct tb1.menu_id, tb1.* from ".$this->TBL_NISTA_MENU." as tb1, ".$this->TBL_NISTA_MENU_RELATION." as tb2
					where 
						tb2.parent_id='".$menu_id."' and 
						tb1.menu_id = tb2.item_id and
						tb1.type='item' 
					order by tb1.sequence asc";
//		echo $query."<br>";
		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result = array();
			while ($tmp = mysql_fetch_array($result_id, MYSQL_ASSOC))
			{
				$result[] = $tmp;
			}
			mysql_free_result($result_id);
			return $result;
		}
		return false;
	}
	
	/**
	 * Метод возвращает список разделов сайта для выбранного пункта меню по id меню
	 *
	 * @param integer $item_id
	 * @return Array or false
	 */
	public function get_partitions_for_menu_item($item_id = 0)
	{
		$item_id = (int)$item_id;
		
		$query = "select * from ".$this->TBL_NISTA_MENU_RELATION." where item_id='".$item_id."' order by rid asc";
		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result = array();
			while ($tmp = mysql_fetch_array($result_id,MYSQL_ASSOC)) 
			{
				$result[] = $tmp;	
			}
			mysql_free_result($result_id);
			return $result;
		}
		return false;		
	}
	
	/**
	 * Метод обновляет статус relation пункта меню по id
	 *
	 * @param integer $relation_id
	 * @param string $status
	 * @return boolean
	 */
	public function update_rid_status($relation_id = 0, $status = "wait")
	{
		$relation_id = (int)$relation_id;
		if($relation_id == 0)return false;
		
		if(!in_array($status, $this->p_STATUS_LIST)) return false;
		$query = "update ".$this->TBL_NISTA_MENU_RELATION." set status='".$status."' where rid='".$relation_id."'";
		//echo $query."<br>";
		return mysql_query($query);
		
	}
	
	/**
	 * Метод обновляет статус пункта меню
	 *
	 * @param integer $item_id
	 * @param string $status
	 * @return boolean
	 */
	public function update_menu_item_status($item_id = 0, $status = "wait")
	{
		$item_id = (int)$item_id;
		if($item_id == 0)return false;
		
		if(!in_array($status, $this->p_STATUS_LIST)) return false;
		$query = "update ".$this->TBL_NISTA_MENU." set status='".$status."' where menu_id='".$item_id."' and type='item'";
		//echo $query."<br>";
		return mysql_query($query);
		
	}
	
	
	/**
	 * Метод удаляе связь пункта меню и раздела сайта
	 *
	 * @param integer $rid
	 * @return boolean
	 */
	public function remove_relation_by_id($rid = 0)
	{
		$rid = (int)$rid;
		if(!$rid)return false;
		// необходимо узнать являетсяли данная relation единственной для данного пункта меню
		$query = "SELECT * FROM ".$this->TBL_NISTA_MENU_RELATION." WHERE parent_id in (select parent_id from ".$this->TBL_NISTA_MENU_RELATION." where rid='".$rid."')";
		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$rid_num = mysql_num_rows($result_id);
			if($rid_num==1)
			{
				// relatio - была единственная, а это значит что если её просто удалить, то потеряется привязка пункта меню к меню
				// а следовательно нужно удалить и пункт меню чтоб не засорять БД
				$row = mysql_fetch_array($result_id, MYSQL_ASSOC);
				$query = "delete from ".$this->TBL_NISTA_MENU." where menu_id='".$row['item_id']."' and type='item' limit 1";
				if(!mysql_query($query))
					return false;
				$flag = 1; 
			}
			mysql_free_result($result_id);
			
			$query = "delete from ".$this->TBL_NISTA_MENU_RELATION." where rid='".$rid."'";
			if(mysql_query($query))
			{
				if(!$flag)
					return "ok"; // была просто удалена relation
				else 
					return "ok+menu"; // была удалена relation + пункт меню
			}
		}
		
	}
	
	/**
	 * Метод удаляет пункт меню по его id (вместе со всеми relations)
	 *
	 * @param integer $id
	 * @return bolean
	 */
	public function remove_menu_item($id = 0)
	{
		$id = (int)$id;
		if(!$id)return false;
		
		$query = "delete from ".$this->TBL_NISTA_MENU." where menu_id='".$id."' and type='item' limit 1";
		if(mysql_query($query))
		{
			$query = "delete from ".$this->TBL_NISTA_MENU_RELATION." where item_id='".$id."'";
			return mysql_query($query);
		}
		else 
			return false;
	}
	
	/**
	 * Метод изменяет порядок следования пунктов меню
	 *
	 * @param integer $item_id id пункта меню
	 * @param string $direction направление перемещения up/down
	 * @return boolean
	 */
	public function change_menu_item_order($item_id = 0, $direction = "")
	{ 
		$item_id = (int)$item_id;
		if(!$item_id)return false;
		
		if(($direction!="up") && ($direction!="down"))
			return false;
			
		
		$query = "select * from ".$this->TBL_NISTA_MENU." where menu_id='".$item_id."' and type='item'";
		//std_lib::log_query($query);
		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)==1))
		{
			$current_item = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);
			
			$query = "select * from ".$this->TBL_NISTA_MENU_RELATION." where item_id='".$item_id."' limit 1";
			//std_lib::log_query($query);
			if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)==1))
			{
				$current_item['relation'] = mysql_fetch_array($result_id, MYSQL_ASSOC);
				mysql_free_result($result_id);
			}
			else 
				return false;
		
			$query = "";
			switch ($direction)
			{
				case "up":
					$query = "select tb1.* from ".$this->TBL_NISTA_MENU." as tb1, ".$this->TBL_NISTA_MENU_RELATION." as tb2
									where
										tb1.menu_id=tb2.item_id and
										tb1.sequence<'".$current_item['sequence']."' and
										tb2.parent_id='".$current_item['relation']['parent_id']."' 
									order by sequence desc
									limit 1";
					break;
				case "down";
					$query = "select tb1.* from ".$this->TBL_NISTA_MENU." as tb1, ".$this->TBL_NISTA_MENU_RELATION." as tb2
									where
										tb1.menu_id=tb2.item_id and
										tb1.sequence>'".$current_item['sequence']."' and
										tb2.parent_id='".$current_item['relation']['parent_id']."' 
									order by sequence asc
									limit 1";
					break;
			}
			//std_lib::log_query($query);
			if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)>0))
			{
				$neighbour_item = mysql_fetch_array($result_id, MYSQL_ASSOC);
				mysql_free_result($result_id);
				
				$query = "update ".$this->TBL_NISTA_MENU." set sequence='".$neighbour_item['sequence']."' where menu_id='".$current_item['menu_id']."' and type='item'";
				//std_lib::log_query($query);
				if(!mysql_query($query))
					return false;
					
				$query = "update ".$this->TBL_NISTA_MENU." set sequence='".$current_item['sequence']."' where menu_id='".$neighbour_item['menu_id']."' and type='item'";
				//std_lib::log_query($query);
				if(!mysql_query($query))
					return false;					
			}
			return true;
			
		}
		else 
			return false;

	}
}