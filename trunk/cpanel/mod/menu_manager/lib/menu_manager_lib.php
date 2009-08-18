<?php
if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");

class menu_manager
{
	private $DATA = array();

	// незыблимые прототипы
	private $p_TBL_NISTA_MENU = "data_structure";
	private $p_TBL_NISTA_MENU_CATEGORY  = "data_structure_category";
	private $p_STATUS_LIST = array("on", "off", "wait", "del");

	// Рабочие переменные
	private $TBL_NISTA_MENU = "data_structure";
	private $TBL_NISTA_MENU_CATEGORY = "data_structure_category";
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
		$this->TBL_NISTA_MENU_CATEGORY=$this->PREFIX.$this->p_TBL_NISTA_MENU_CATEGORY;
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