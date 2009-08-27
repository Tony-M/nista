<?php
if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");

class menu_manager
{
	private $DATA = array();

	// незыблимые прототипы
	private $p_TBL_NISTA_MENU = "menu";
	
	private $p_STATUS_LIST = array("on", "off", "wait", "del");

	// Рабочие переменные
	private $TBL_NISTA_MENU = "menu";

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



}