<?php
if(!defined('IN_SITE')) header("Location: http://".$_SERVER['SERVER_NAME']."");

class item_manager{
	
	private $PREFIX = 'tbl_nista_';
	private $p_TBL_DATA_STRUCTURE = 'data_structure';
	
	private $TBL_DATA_STRUCTURE = 'data_structure';
	
	private $DATA = array(); // Массив данных
	
	public function __construct()
	{
		$this->TBL_DATA_STRUCTURE = $this->PREFIX.$this->TBL_DATA_STRUCTURE;
	}
	
	
	public function __destruct()
	{}
	
	public function debug($inp)
	{
		echo "<hr><pre>";
		print_r($inp);
		echo "</pre>";
	}
		
	/**
	 * Метод задаёт префикс таблиц базы данных
	 *
	 * @param string $prefix
	 * @return boolean
	 */
	public function set_tbl_prefix($prefix='')
	{
		$prefix = trim($prefix);
		if(!preg_match("/[a-zA-Z_/]+", $prefix))
			return false;
		
		if($prefix!=$this->PREFIX)
		{
			$this->TBL_DATA_STRUCTURE = $prefix.$this->TBL_DATA_STRUCTURE;
		}
		else 
		{
			$this->TBL_DATA_STRUCTURE = $this->PREFIX.$this->TBL_DATA_STRUCTURE;
		}
		return true;
	}
	
	/**
	 * Метод устанавливает значение id
	 *
	 * @param integer $id
	 * @return boolean
	 */
	public function set_id($id = 0)
	{
		$id = intval($id);
		$this->DATA['id'] = 0;
		if(!$id)
			return false;
		
		$this->DATA['id'] = $id;
		return true;
	}
	
	/**
	 * Метод возвращает данные статьи по её id
	 *
	 * @return Array or boolean
	 */
	public function get_item()
	{
		$this->DATA['id'] = (int)$this->DATA['id'];
		if(!$this->DATA['id'])
			return false;
			
		$query = "select * from `".$this->TBL_DATA_STRUCTURE."` 
							where
								status='on' and
								type='item' and 
								id='".$this->DATA['id']."' 
								limit 1";
		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)))
		{
			$result = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);
			return $result;
		}
		return false;
	}
	
}
?>