<?php
if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");

class partition_manager
{
	private $DATA = array();
	
	// незыблимые прототипы
	private $p_TBL_NISTA_DATA_STRUCTURE = "data_structure";
	private $p_TBL_NISTA_DATA_STRUCTURE_CATEGORY  = "data_structure_category";
	private $p_STATUS_LIST = array("on", "off", "wait", "del");
	
	// Рабочие переменные
	private $TBL_NISTA_DATA_STRUCTURE = "data_structure";
	private $TBL_NISTA_DATA_STRUCTURE_CATEGORY = "data_structure_category";
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
		
		$this->TBL_NISTA_DATA_STRUCTURE = $this->PREFIX.$this->p_TBL_NISTA_DATA_STRUCTURE;
		$this->TBL_NISTA_DATA_STRUCTURE_CATEGORY=$this->PREFIX.$this->p_TBL_NISTA_DATA_STRUCTURE_CATEGORY;
//		$this->debug();	
	}
	
	/**
	 * Метод устанавливет id раздела, с которым требуется произвести работу
	 *
	 * @param integer $id
	 * @return boolean
	 */
	public function set_id($id="")
	{
		
		$id=trim($id); 
		$id = (int)$id;
		if($id==0)return false;
		$this->DATA['id']=$id;
		return true;
	}
	
	/**
	 * Метод устанавливает значение заголовка раздела 
	 *
	 * @param string $title заголовок раздела
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
	 * Метод устанавливает описание раздела 
	 *
	 * @param string $text описание раздела
	 * @return boolean
	 */
	public function set_text($text="")
	{
		$text=trim($text);
		$this->DATA['text']=htmlentities($text,ENT_QUOTES, "UTF-8");
		return true;
	}
	
	/**
	 * Метод устанавливает Ключевые слова раздела
	 *
	 * @param string $key_word ключевые слова раздела через запятую
	 * @return boolean
	 */
	public function set_meta_keyword($key_word = "")
	{
		$key_word = trim(strip_tags($key_word));
		$key_word = eregi_replace("[\n\l\t]+", " , ", $key_word);
		$key_word = eregi_replace("( ){2,}", " ", $key_word );
//		$key_word = eregi_replace("(, ){2,}", " ", $key_word );
		$key_word = htmlentities($key_word,ENT_QUOTES, "UTF-8");
		$this->DATA['meta_keyword'] = $key_word;
		return true;
	}
	
	/**
	 * Метод устанавливает метаописание раздела
	 *
	 * @param string $description описание раздела 
	 * @return boolean
	 */
	public function set_meta_description($description = "")
	{
		$description = trim(strip_tags($description));
		$description = htmlentities($description,ENT_QUOTES, "UTF-8");
		$this->DATA['meta_description'] = $description;
		return true;
	}
	
	/**
	 * Метод устанавливает статус материала
	 *
	 * @param string $status статус материала (поумолчанию = wait)
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
	 * Метод устанавливает псевдоним автора
	 *
	 * @param string $penname псевдоним автора
	 * @return boolean
	 */
	public function set_penname($penname = "")
	{
		$penname = trim(strip_tags($penname));
		$penname = htmlentities($penname,ENT_QUOTES, "UTF-8");
		$this->DATA['penname'] = $penname;
		return true;
	}
	
	/**
	 * Метод задаёт шаблон отображения раздела
	 *
	 * @param string $template_name шаблон отображения раздела
	 * @return boolean
	 */
	public  function set_template($template_name= "")
	{
		$template_name = trim(strip_tags($template_name));
		if($template_name == "")return false;
		
		if(!eregi("[a-zA-Z0-9_\.]+", $template_name))return false;
		
		$this->DATA['template'] = $template_name;
		return true;
	}
	
	/**
	 * Метод устанавливает значение id одительского разсдела
	 *
	 * @param integer $owner_id
	 * @return boolean
	 */
	public function set_owner_id($owner_id=0)
	{
		$owner_id = (int)$owner_id;
		if($owner_id==0)
		{
			$this->DATA['pid'] = 0;
			return false;
		}
		else 
		{
			$this->DATA['pid'] = $owner_id;
			return true;
		}
		
	}
	
	/**
	 * Метод устанавливает id раздела сайта для  категории
	 *
	 * @param integer $owner_id
	 * @return boolean
	 */
	public function set_category_owner_id($owner_id=0)
	{
		$owner_id = (int)$owner_id;
		if($owner_id==0)
		{
			$this->DATA['prt_id'] = 0;
			return false;
		}
		else 
		{
			$this->DATA['prt_id'] = $owner_id;
			return true;
		}
		
	}
	
	/**
	 * Метод устанавливает уровень доступа к разделу сайта
	 *
	 * @param integer $access_level
	 * @return boolean
	 */
	public function set_access_level($access_level = 0)
	{
		$access_level = (int)$access_level;
		if($access_level <0)return false;
		if($access_level >7)return false;
		$this->DATA['access_level'] = $access_level;
		return true;
	}

	/**
	 * Метод возвращает общее количество разделов сайта
	 *
	 * @return integer
	 */
	public function count_all_partitions()
	{
		$query = "select count(id) as num from ".$this->TBL_NISTA_DATA_STRUCTURE." where type='prt' and modid='".$this->DATA['MOD_DATA']['modid']."'";
		//echo $query."<br>";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$tmp =  mysql_fetch_array($result_id, MYSQL_ASSOC);
			$num = $tmp['num'];
			mysql_free_result($result_id);
			return $num;
			
		}
		return 0;
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
	
	public function save_partition()
	{
		if($this->DATA['id'] == "")
		{
			////// создаём новый раздел //////
			
			$query = "insert into ".$this->TBL_NISTA_DATA_STRUCTURE." 
						set 
							type='prt', 
							modid='".$this->DATA['MOD_DATA']['modid']."',
							sequence='".$this->get_new_sequence()."', 
							creator_uid = '".$this->DATA['USER_DATA']['uid']."',
							date_created='".$this->get_date()."', ";
			
			
			if($this->DATA['title'] == "")return false;
			$query .= " title='".$this->DATA['title']."' ";
			
			$query .= ", text='".$this->DATA['text']."' ";
			$query .= ", meta_keyword='".$this->DATA['meta_keyword']."' ";
			$query .= ", meta_description='".$this->DATA['meta_description']."' ";
			$query .= ", status='".$this->DATA['status']."' ";
			$query .= ", penname='".$this->DATA['penname']."' ";
			$query .= ", template='".$this->DATA['template']."' ";
			$query .= ", access_level='".$this->DATA['access_level']."' ";
			
			if($this->DATA['pid'] != "")
			{
				$query .= ", pid='".$this->DATA['pid']."' ";
//				echo $query."<br>";
				return mysql_query($query);
			}			
		}
		if((int)$this->DATA['id'] != 0)
		{
			////// создаём новый раздел //////
			
			$query = "update ".$this->TBL_NISTA_DATA_STRUCTURE." 
						set 
							creator_uid = '".$this->DATA['USER_DATA']['uid']."',
							date_created='".$this->get_date()."', ";
			
			
			if($this->DATA['title'] == "")return false;
			$query .= " title='".$this->DATA['title']."' ";
			
			$query .= ", text='".$this->DATA['text']."' ";
			$query .= ", meta_keyword='".$this->DATA['meta_keyword']."' ";
			$query .= ", meta_description='".$this->DATA['meta_description']."' ";
			$query .= ", status='".$this->DATA['status']."' ";
			$query .= ", penname='".$this->DATA['penname']."' ";
			$query .= ", template='".$this->DATA['template']."' ";
			$query .= ", access_level='".$this->DATA['access_level']."' ";
			
			if($this->DATA['pid'] != "")
			{
				
				// проверяем на петли при перелинковке
				if($this->check_partition_no_loop($this->DATA['id'], $this->DATA['pid']))
					$query .= ", pid='".$this->DATA['pid']."' ";
				else 
					return false; // при перелинковке образовалась петля

				
				$query .= " where type='prt' and modid='".$this->DATA['MOD_DATA']['modid']."' and id='".$this->DATA['id']."' ";
				//echo $query."<br>";exit;
				return mysql_query($query);
			}			
		}
		
		return false;
	}
	
	/**
	 * Метод создаёт корневой раздел сайта
	 *
	 * @return boolean
	 */
	public function create_root_partition()
	{
		if(!$this->is_exist_root_partition())
		{
			$query = "insert into ". 
							$this->TBL_NISTA_DATA_STRUCTURE." 
						set 
							id='1', 
							pid='1', 
							title='Корневой раздел сайта', 
							status='on', 
							modid='".$this->DATA['MOD_DATA']['modid']."', 
							type='prt',
							sequence='".$this->get_new_sequence()."', 
							creator_uid = '".$this->DATA['USER_DATA']['uid']."',
							date_created='".$this->get_date()."'";
							
			return mysql_query($query);
		}
		return true;
	}
		
	/**
	 * метод проверяет наличие корневого раздела сайта
	 *
	 * @return boolean
	 */
	public function is_exist_root_partition()
	{
		$query = "select * from ".$this->TBL_NISTA_DATA_STRUCTURE." where type='prt' and id='1' and pid='1' and modid='".$this->DATA['MOD_DATA']['modid']."'";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			mysql_free_result($result_id);
			return true;			
		}
		else 
			return false;
	}
	
	/**
	 * Метод возвращает id корневого раздела
	 *
	 * @return integer or False
	 */
	public function get_root_partition_id()
	{
		$query = "select * from ".$this->TBL_NISTA_DATA_STRUCTURE." where type='prt' and id='1' and pid='1' and modid='".$this->DATA['MOD_DATA']['modid']."'";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);
			return $result['id'];			
		}
		else 
			return false;
	}
	
	/**
	 * метод возвращает максимальное значение порядка следования последовательностей
	 *
	 * @return integer
	 */
	public function get_max_sequence()
	{
		$query = "select max(sequence) as num from ".$this->TBL_NISTA_DATA_STRUCTURE;
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
	 * Метод возвращает список подразделов данного раздела сайта
	 *
	 * @param integer $partition_id id родительского раздела
	 * @return Array or false
	 */
	public function get_daughter_partition($partition_id = 0)
	{
		$partition_id = (int)$partition_id;
		
		if($partition_id==0)return false;
		
		$query = "select * from ".$this->TBL_NISTA_DATA_STRUCTURE." where type='prt' and modid='".$this->DATA['MOD_DATA']['modid']."' and pid='".$partition_id."'";
		
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result=array();
			
			while ($tmp = mysql_fetch_array($result_id,MYSQL_ASSOC)) 
			{
				$result[] = $tmp;
			}
			
			mysql_free_result($result_id);
			return $result;
		}
		return false;
	}
	
	
	public function get_partition_tree_for($partition_id = 0, $tab = 0)
	{
		$partition_id = (int)$partition_id;
		if($partition_id == 0)return false;
		
		$tab = (int)$tab;
		
		$result = array();
		
		$query = "select * from ".$this->TBL_NISTA_DATA_STRUCTURE." where type='prt' and modid='".$this->DATA['MOD_DATA']['modid']."' and pid='".$partition_id."' and pid!=id";
		//echo $query."<br>".$tab."<br>";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$i=0;			
			while ($tmp = mysql_fetch_array($result_id, MYSQL_ASSOC)) 
			{
				$result[$i] = $tmp;
				$result[$i]['tab'] = $tab;
				$result[$i]['tab_char'] = str_repeat("--",$tab);
				//$result[$i]['title'] = html_entity_decode($result[$i]['title'],ENT_QUOTES, "UTF-8");
				
				$tmp_result = $this->get_partition_tree_for($tmp['id'], $tab +1);
				if((is_array($tmp_result)))
				{
					$result[$i]['has_child'] = "yes";
					$result = @array_merge($result, $tmp_result);
				}

				$i = count($result);			
			}
			
			mysql_free_result($result_id);
			return $result;
		}
		return false;
	}
	
	/**
	 * Метод возвращает полное дерево всех ветвей разделов
	 *
	 * @return array or False
	 */
	public function get_all_partition_trees()
	{
		
		$query = "select * from ".$this->TBL_NISTA_DATA_STRUCTURE." where type='prt' and modid='".$this->DATA['MOD_DATA']['modid']."'  and pid=id ";
		$query .= " order by id asc";
		//echo $query."<br>";
		$result = array();
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
						
			$i = 0; $tab=0;
			while ($tmp = mysql_fetch_array($result_id, MYSQL_ASSOC)) 
			{
				$result[$i] = $tmp;
				$result[$i]['tab'] = $tab;
				$result[$i]['tab_char'] = str_repeat("--",$tab);
				
				$tmp_result = $this->get_partition_tree_for($tmp['id'], $tab +1);
				if((is_array($tmp_result)))
				{
					$result[$i]['has_child'] = "yes";
					$result = @array_merge($result, $tmp_result);
				}	
				
				$i = count($result);
			}
			
			mysql_free_result($result_id);
			return $result;
		}
		return false;
	}
	
	/**
	 * Метод возвращает инфорамцию о разделе сайта по его id
	 *
	 * @param integer $id
	 * @return array or False
	 */
	public function get_partition($id = 0)
	{
		$id = (int)$id;
		
		if($id==0)return false;
		
		$query = "select * from ".$this->TBL_NISTA_DATA_STRUCTURE." where type='prt' and modid='".$this->DATA['MOD_DATA']['modid']."' and id='".$id."'";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)==1))
		{
			$result = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);
			
			return $result;
		}
		return false;
	}
	
	
	/**
	 * Метод проверяет зацикливание привязок разделов с образованием петли. 
	 * В случае если петли нет то возвращается True.
	 * Если петля есть то возвращается False
	 *
	 * @param integer $current_id id раздела, который пперелинковываем
	 * @param integer $parent_id id раздела, к которому линкуем
	 * @return boolean
	 */
	public function check_partition_no_loop($current_id = 0, $parent_id=0)
	{
		$current_id = trim($current_id);
		$parent_id = trim($parent_id);
		
		if((int)$current_id == 0)return false;
		if((int)$parent_id == 0)return false;
		
		if($current_id == 1)return false; // корневой раздел не может быть перелинкован
		
		$my_tree = $this->get_partition_tree_for($current_id);
		if(!is_array($my_tree))return true; // нет массива значит и петли нету
		
		$n = count($my_tree);
		for($i=0; $i<$n; $i++)
		{
			if($my_tree[$i]['id'] == $parent_id) return false;
		}
		
		return true;
	}
	
	
	/**
	 * Метод очищает переменные
	 *
	 */
	public function purge_variables()
	{
		$query = "describe ".$this->TBL_NISTA_DATA_STRUCTURE;
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			
			while ($tmp = mysql_fetch_array($result_id, MYSQL_ASSOC))
			{
				$desc = $tmp['Field'];
				$this->DATA[$desc] = '';
			}
		}
		
		$query = "describe ".$this->TBL_NISTA_DATA_STRUCTURE_CATEGORY;
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
	 * Метод сохраняет новую категорию или её изменения
	 *
	 * @return boolean
	 */
	public function save_category()
	{
		if((int)$this->DATA['id']==0)
		{
			if($this->DATA['title'] != "")
			{
				if((int)$this->DATA['prt_id']!=0)
				{
					if(!$this->check_category_existanse($this->DATA['title'], $this->DATA['prt_id']))
					{
						$query = "insert into ".$this->TBL_NISTA_DATA_STRUCTURE_CATEGORY."
									set
										title='".$this->DATA['title']."', 
										prt_id='".$this->DATA['prt_id']."'";
						return mysql_query($query);
					}					
				}
			}
		}
		
		if((int)$this->DATA['id']!=0)
		{
			if($this->DATA['title'] != "")
			{
				
					$query = "update ".$this->TBL_NISTA_DATA_STRUCTURE_CATEGORY."
									set
										title='".$this->DATA['title']."'
									where
										id='".$this->DATA['id']."'";
					//echo $query."<br>";
					return mysql_query($query);
									
				
			}
		}
		return false;
		
	}
	
	/**
	 * Метод проверяет существование категории title для раздела с заданным id
	 *
	 * @param string $title заголовок категории
	 * @param integer $prt_id id раздела
	 * @return integer of False
	 */
	public function check_category_existanse($title="", $prt_id=0)
	{
		$title=htmlentities(strip_tags($title),ENT_QUOTES, "UTF-8");
		$title=trim($title); 
		if($title == "")return false;
	
		$prt_id = (int)$prt_id;
		if($prt_id==0)return false;
		
		$query = "select * from ".$this->TBL_NISTA_DATA_STRUCTURE_CATEGORY." 
					where
						prt_id='".$prt_id."' and
						title='".$title."'";
		
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);
			return $result['id'];
		}
		else 
			return false;
	}
	
	/**
	 * метод возвращает список категорий для выбранного раздела
	 *
	 * @param integer $partition_id id раздела сайта
	 * @return array or False
	 */
	public function get_category_list_4_partition($partition_id = 0)
	{
		$partition_id = (int)trim($partition_id);
		if($partition_id == 0)return false;
		
		$query = "select * from ".$this->TBL_NISTA_DATA_STRUCTURE_CATEGORY." 
					where 
						prt_id='".$partition_id."' 
					order by title asc";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
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
	 * Метод удаляет категорию раздела и обновляет записи таблицы данных
	 *
	 * @param integer $id id категории
	 * @return "ok" on success of  "err_no_priv_delete" "err_no_priv_to_update" on fail
	 */public function remove_category($id = 0)
	{
		$id = (int)trim($id);
		if($id == 0) return false;
		
		$query = "update ".$this->TBL_NISTA_DATA_STRUCTURE." set category_id='0' where id='".$id."'";
		//echo $query."<br>";
		if(mysql_query($query))
		{
			$query = "delete from ".$this->TBL_NISTA_DATA_STRUCTURE_CATEGORY." where id='".$id."'";
			//echo $query."<br>";
			if(mysql_query($query))
			{
				return "ok";
			}
			else 
				return "err_no_priv_delete";
		}
		else 
			return "err_no_priv_to_update";
	}
	
	/**
	 * Метод возвращает информацию по выбранной категории
	 *
	 * @param integer $id  id категории
	 * @return array or False
	 */
	public function get_category($id = 0)
	{
		$id = (int)trim($id);
		if($id ==0)return false;
		
		$query = "select * from ".$this->TBL_NISTA_DATA_STRUCTURE_CATEGORY." 
					where 
						id='".$id."'";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);
			return $result;
		}
		else 
			return false;
	}
	
	
	/**
	 * Метод производит обновление статуса раздела
	 *
	 * @return boolean
	 */
	public function update_partition_status()
	{
		if((int)$this->DATA['id']!= 0)
		{
			if(in_array($this->DATA['status'], $this->DATA['STATUS_LIST']))
			{
				$query = "update ".$this->TBL_NISTA_DATA_STRUCTURE." 
							set 
								status='".$this->DATA['status']."' 
							where 
								id='".$this->DATA['id']."' and
								type='prt' and 
								modid='".$this->DATA['MOD_DATA']['modid']."'" ;
//				echo $query."<br>";
				return mysql_query($query);
			}
		}
		return false;
	}
	
	
		
	/**
	 * Метод возвращает xml список категорий для заданного раздела в формате id->title
	 *
	 * @param integer $partition_id
	 * @return array or False
	 */
	public function get_xml_category_list_for_partition($partition_id=0)
	{
		$partition_id = (int)$partition_id;
		
		if($partition_id == 0)return false;
		
		$query = "select * from ".$this->TBL_NISTA_DATA_STRUCTURE_CATEGORY." where prt_id='".$partition_id."' order by title asc";
		//echo $query."<br>";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result = array();
			
			$i = 0;
			
			$xml = new XMLWriter();
			$xml->openMemory();
			
			$xml->startDocument('1.0', 'UTF-8');
			
    		$xml->endDtd();
			
    		$xml->startElement('items');
    		
    		
			while($tmp = mysql_fetch_array($result_id, MYSQL_ASSOC))
			{
				$xml->startElement('item');
				
				$xml->writeAttribute( 'kay', $tmp['id']);
				$xml->writeAttribute( 'title', $tmp['title']);
				$xml->endElement(); 
				
				$i++;
			}
			
			$xml->endElement(); 
   
   			mysql_free_result($result_id);
			
   			return  $xml->outputMemory(true);
			
		}
		
		return false;
	}
	
	/**
	 * Метод возвращает содержимое каталога в виде массива
	 *
	 * @param string $dir_way 
	 * @return array or False
	 */
	public function ls_dir($dir_way = "")
	{
		if(is_dir(ROOT_WAY.$dir_way))
		{
			$dir = opendir(ROOT_WAY.$dir_way);
			
			$result = array();
			$i = 0;
			while (false !==($dir_content = readdir($dir)))
			{
				if(is_dir(ROOT_WAY.$dir_way."/".$dir_content))
					if(($dir_content!=".")&&($dir_content!=".."))
					{
						$result[$i]['title'] = $dir_content;
						$result[$i]['path'] = $dir_way."/".$dir_content;
						//echo $result[$i]['path']."<br>";
						if(in_array($result[$i]['path'], $this->DATA['SYS']['FORBIDDEN_DIR'] ))
						{
							$result[$i]['status'] = 'sys';
						}
						
						
						if(is_readable(ROOT_WAY.$dir_way."/".$dir_content))				
							$result[$i]['r'] = "r";
						else 
							$result[$i]['r'] = "-";
							
						if(is_writable(ROOT_WAY.$dir_way."/".$dir_content))				
							$result[$i]['w'] = "w";
						else 
							$result[$i]['w'] = "-";
					$i++;
					}
					
					
			}
			closedir($dir);
		}
		
//		$this->debug($result);
		return $result;		
	}
	
	/**
	 * Метод возвращает массив описывающий путь к текущему каталоги и ссылки на каждую составляющую
	 *
	 * @param string $catalog
	 * @return array or False
	 */
	public function get_linked_full_path_to($catalog="")
	{
		
		if($catalog == "") return false;
		if(is_dir(ROOT_WAY.$catalog))
		{
			$flag = 0;
			while(!$flag)
			{
				if((substr($catalog,0,1)==".")||(substr($catalog,0,1)=="/"))
					$catalog = substr($catalog, 1, strlen($catalog)-1);
				else 
					$flag = 1;				
			}
			
			$path_array = explode("/", $catalog);
			
			$n = count($path_array);
			
			$result= array();
			for($i=0; $i<$n; $i++)
			{
				$result[$i]['title'] = $path_array[$i];
				
				for($j=0; $j<=$i; $j++)
				{
					$result[$i]['path'] .= $path_array[$j];
					if($j!=$i) $result[$i]['path'] .= "/";
				}
			}
			//$this->debug($result);
			return $result;
		}
		return false;
	}
	
	/**
	 * Метод задаёт родительский каталог для нового (создаваемого)
	 *
	 * @param string $way
	 * @return bolean
	 */
	public function set_catalog_owner($way = "")
	{
		if(substr($way,0,1)=="/")$way = substr($way, 1, strlen($way)-1);
		if($way != "")
			if(!is_dir(ROOT_WAY.$way))return false;
		
		if(in_array($way, $this->DATA['SYS']['FORBIDDEN_DIR'])) return  false;
		
		$this->DATA['catalog_owner'] = ROOT_WAY.$way;
		return  true;
	}
	
	/**
	 * Мето создаёт новый каталог для. Используется после задания родительского каталога методом set_catalog_owner
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function create_new_catalog($name = "")
	{
		$name = trim($name);
		if(!eregi("[0-9a-zA-Z_]+", $name))return  false;
		if(eregi("( )+", $name))return  false;
		
		if($this->DATA['catalog_owner'] == "")return false;
		
		if(!is_dir($this->DATA['catalog_owner'].$name))
		{
			
			if(mkdir($this->DATA['catalog_owner']."/".$name , 0755))
				return copy($this->DATA['SYS']['PUB_CATALOG']['includes']."index.php", $this->DATA['catalog_owner']."/".$name."/index.php");
			
			return false;
		}
		return false;
	}
	
	/**
	 * Метод выводит просто полный список разделов упорядоченных по id
	 *
	 * @return array or False
	 */
	public function get_partition_array()
	{
		$query = "select * from ".$this->TBL_NISTA_DATA_STRUCTURE." 
					where 
						type='prt' and 
						modid='".$this->DATA['MOD_DATA']['modid']."' 
					order by id asc";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
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
	
	public function rm_catalog($path = "")
	{
		if($path == "")return false;
		
		if(substr($path,0,1)=="/")$path = substr($path, 1, strlen($path)-1);
		if($path != "")
			if(!is_dir(ROOT_WAY.$path))return false;			
			
		$dir = opendir(ROOT_WAY.$path);
			
		$result = array();
		$i = 0;
		while (false !==($dir_content = readdir($dir)))
		{
			if(($dir_content!=".")&&($dir_content!=".."))
			{
				$result[$i]['title'] = $dir_content;
				$result[$i]['path'] = $path."/".$dir_content;
				//echo $result[$i]['path']."<br>";
				if(in_array($result[$i]['path'], $this->DATA['SYS']['FORBIDDEN_DIR'] ))
				{
					$result[$i]['status'] = 'sys';
				}
				
				
				if(is_readable(ROOT_WAY.$path."/".$dir_content))				
					$result[$i]['r'] = "r";
				else 
					$result[$i]['r'] = "-";
						
				if(is_writable(ROOT_WAY.$path."/".$dir_content))				
					$result[$i]['w'] = "w";
				else 
					$result[$i]['w'] = "-";

				$i++;
			}
					
					
		}
		closedir($dir);
			
		//$this->debug($result);	
			
		if(count($result)>1)return false; // если содержимого больше чем 1 то значит там чтото ещё лежит кроме index.php
		
		if(count($result==1))  // если содржимого 1 то надо проверить index.php это или нет
		{
			if(is_file(ROOT_WAY.$result[0]['path']))// проверяем является ли содержимое файлом
			{
				if($result[0]['title']=="index.php")
				{
					$base_index_size = filesize($this->DATA['SYS']['PUB_CATALOG']['includes']."index.php"); // измеряем размер базового index.php
					$index_size = filesize(ROOT_WAY.$result[0]['path']); // измеряем размер текущего index.php
					if($base_index_size == $index_size) // если не равны, то значит раздел нестандартный и грохать его нельзя
					{
						//не делаем ничего и позволяем методу выполняться дальше
					}
					else 
						return false;				
				}
				else 
					return false;
			}
			else 
				return false;
		}
		
		
		if($this->unlink_catalog())
		{
			if(unlink(ROOT_WAY.$result[0]['path']))
				return rmdir(ROOT_WAY.$path);
		}
		
		return false;
			
			
	}
	
	public function unlink_catalog($path="")
	{
		return true;
	}
}