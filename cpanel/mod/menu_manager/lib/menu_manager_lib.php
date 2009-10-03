<?php
if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");

class menu_manager extends base_validation
{
	private $DATA = array();

	// незыблимые прототипы
	private $p_TBL_NISTA_MENU = "menu";
	private $p_TBL_NISTA_MENU_LINKS = "menu_links";
	
	private $p_STATUS_LIST = array("on", "off", "wait", "del");

	// Рабочие переменные
	private $TBL_NISTA_MENU = "menu";
	private $TBL_NISTA_MENU_LINKS = "menu_links";
	
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
		
		//		$this->debug();
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
	 * Метод возвращяет полный смисок контейнеров меню
	 *
	 * @return Array or False
	 */
	public function get_menu_list()
	{
		$query = "select * from ".$this->TBL_NISTA_MENU." where type='container' order by title asc" ;
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
			// для этого открываем цик по массиву существующих ссылко
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
			// для этого открываем цикл по новоым линкам и ищем в старом списке тепункты, которых нет
			for($j=0; $j<$inp_num; $j++)
			{
				$flag_exist = 0; // флаг равен 0 если строка ненайдена в старом наборе
				for($i=0; $i<$old_num; $i++)
				{
					if(($input_links_array[$j]['prt_id']==$old_menu_links_array[$i]['prt_id'])&&($input_links_array[$j]['zone_name']==$old_menu_links_array[$i]['zone_name'])&&($input_links_array[$j]['tpl_file']==$old_menu_links_array[$i]['tpl_file']))
						$flag_exist = 1;					
				}
				
				if(!$flag_exist)
				{
					$query = "insert into ".$this->TBL_NISTA_MENU_LINKS."
									set
										menu_id='".$this->DATA['menu_id']."' , 
										prt_id='".$input_links_array[$j]['prt_id']."' , 
										zone_name='".$input_links_array[$j]['zone_name']."' ,
										tpl_file='".$input_links_array[$j]['tpl_file']."'";
					mysql_query($query); // сюда вставить не просто удаление а удаление пунктов этого меню, чтоб они не заполоняли БД мёртвым грузом
//					echo $query."<br>";
					$query ="";
				}
				$flag_exist = 0;
			}
		}
		else 
		{
			for($i=0;$i<$inp_num; $i++)
			{
				$query = "insert into ".$this->TBL_NISTA_MENU_LINKS."
								set
									menu_id='".$this->DATA['menu_id']."' , 
									prt_id='".$input_links_array[$i]['prt_id']."' , 
									zone_name='".$input_links_array[$i]['zone_name']."' ,
									tpl_file='".$input_links_array[$i]['tpl_file']."'";
				mysql_query($query); // сюда вставить не просто удаление а удаление пунктов этого меню, чтоб они не заполоняли БД мёртвым грузом
//				echo $query."<br>";
				$query ="";
			}
		}
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

}