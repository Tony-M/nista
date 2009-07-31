<?php
if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");

class item_manager
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
	 * Метод устанавливет id статьи, с которой требуется произвести работу
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
	 * Метод устанавливает категорию для статьи. В случае если она не задана то 0
	 *
	 * @param integer $category_id
	 * @return true
	 */
	public function set_category_id($category_id="")
	{

		$category_id=(int)$category_id;
		if($category_id == "")$category_id = 0;
		$this->DATA['category_id']=$category_id;
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
	 * Метод устанавливает описание статьи 
	 *
	 * @param string $text описание статьи
	 * @return boolean
	 */
	public function set_text($text="")
	{
		$text=trim($text);
		$this->DATA['text']=htmlentities($text,ENT_QUOTES, "UTF-8");
		return true;
	}

	/**
	 * Метод устанавливает Ключевые слова статьи
	 *
	 * @param string $key_word ключевые слова статьи через запятую
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
	 * Метод устанавливает метаописание статьи
	 *
	 * @param string $description описание статьи 
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
	 * Метод устанавливает значение id родительского раздела
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
	 * Метод устанавливает уровень доступа к статье сайта
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
	 * Метод возвращает общее количество статей сайта
	 *
	 * @return integer
	 */
	public function count_all_items()
	{
		$query = "select count(id) as num from ".$this->TBL_NISTA_DATA_STRUCTURE." where type='item' and modid='".$this->DATA['MOD_DATA']['modid']."'";
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

	public function save_item()
	{
		if($this->DATA['id'] == "")
		{
			////// создаём новый раздел //////

			$query = "insert into ".$this->TBL_NISTA_DATA_STRUCTURE."
						set 
							type='item', 
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
			$query .= ", access_level='".$this->DATA['access_level']."' ";

			$this->DATA['category_id'] = (int)$this->DATA['category_id'];

			$query .= ", category_id='".$this->DATA['category_id']."' ";

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
			$query .= ", access_level='".$this->DATA['access_level']."' ";

			if($this->DATA['pid'] != "")
			{

				$query .= ", pid='".$this->DATA['pid']."' ";

				$this->DATA['category_id'] = (int)$this->DATA['category_id'];

				$query .= ", category_id='".$this->DATA['category_id']."' ";

				$query .= " where type='item' and modid='".$this->DATA['MOD_DATA']['modid']."' and id='".$this->DATA['id']."' ";
				//echo $query."<br>";exit;
				return mysql_query($query);
			}
		}

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
	 * Метод возвращает список статей данного статьи сайта
	 *
	 * @param integer $partition_id id родительского статьи
	 * @return Array or false
	 */
	public function get_item_list_for_partition($partition_id = 0)
	{
		$partition_id = (int)$partition_id;

		if($partition_id==0)return false;

		$query = "select * from ".$this->TBL_NISTA_DATA_STRUCTURE." where type='item' and modid='".$this->DATA['MOD_DATA']['modid']."' and pid='".$partition_id."' order by title asc";

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


	/**
	 * Метод возвращает инфорамцию о статье сайта по её id
	 *
	 * @param integer $id
	 * @return array or False
	 */
	public function get_item($id = 0)
	{
		$id = (int)$id;

		if($id==0)return false;

		$query = "select * from ".$this->TBL_NISTA_DATA_STRUCTURE." where type='item' and modid='".$this->DATA['MOD_DATA']['modid']."' and id='".$id."'";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)==1))
		{
			$result = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);

			return $result;
		}
		return false;
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
	 * Метод производит обновление статуса статьи
	 *
	 * @return boolean
	 */
	public function update_item_status()
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
								type='item' and 
								modid='".$this->DATA['MOD_DATA']['modid']."'" ;
				//				echo $query."<br>";
				return mysql_query($query);
			}
		}
		return false;
	}

	/**
	 * Метод удаляет статью по id (отправляет в корзину)
	 *
	 * @param integer $id
	 * @return boolean
	 */
	public function remove_item($id = 0)
	{
		$id = (int)$id;
		$query = "delete from ".$this->TBL_NISTA_DATA_STRUCTURE." 
					where 
						id='".$id."' and
						type='item' and 
						modid='".$this->DATA['MOD_DATA']['modid']."'" ;
		return mysql_query($query);
	}

}