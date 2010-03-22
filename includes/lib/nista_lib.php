<?php
if(!defined('IN_SITE')) header("Location: http://".$_SERVER['SERVER_NAME']."");
class nista_manager{
	
	private $DATA = array();
	public $PREFIX = "tbl_nista_"; // table prefix
	
	private $KERNELL_VERSION = "3.0.0";
	private $KERNELL_VERSION_TYPE = "alpha";

	private $SYS_POST = array ("guest" => 0,
	"registered" => 1,
	"subscriber" => 2,
	"author" => 3,
	"front_moderator" => 4,
	"moderator" => 5,
	"sudo" => 6,
	"root" => 7);

	private $p_IMG_TYPES = array("jpg", "jpeg", "png", "gif"); // список расширений рисунков
	
	private $p_TBL_NISTA_MOD = 'mod';
	private $TBL_NISTA_MOD = 'mod';

	private $SYS_STRUC = array(); // system structure

	private $MY_DATA = array(); // user information
	
	public function __construct()
	{
		$this->TBL_NISTA_MOD = $this->PREFIX.$this->p_TBL_NISTA_MOD;

		$this->SYS_STRUC = $this->get_system_module_structure();
	}
	
	public function debug($inp)
	{
		echo "<hr><pre>";
		print_r($inp);
		echo "</pre>";
	}
	
	/**
	 * метод возвращает структуру активных модулей из БД
	 *
	 * @return array or False
	 */
	private function get_sys_struct()
	{
		$query = "select * from ".$this->TBL_NISTA_MOD." where status='on'";
		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result=array();
			while ($tmp = mysql_fetch_array($result_id, MYSQL_ASSOC))
				$result[] = $tmp;
				
			mysql_free_result($result_id);
			return $result;
		}
		return false;
	}
	
	/**
	 * Метод возвращает сисок доступных модулей
	 *
	 * @return array or false;
	 */
	public function get_system_module_structure()
	{
		$tmp = $this->get_sys_struct();
		if(!$tmp)return false;
		
		$n = count($tmp);
		for($i=0;$i<$n;$i++)
		{
			$result[$i] = $tmp[$i];
			$result[$i]['lib_way'] = substr($result[$i]['way'], 0, strpos($result[$i]['way'], "index.php"))."lib/";
		}
		
		return $result;
	}
	
	/**
	 * Метод проверяет, активен ли модуль по его имени
	 *
	 * @param string $mod_name название модуля
	 * @return boolean
	 */
	public function is_active_module($mod_name="")
	{
		$mod_name = trim(strtolower($mod_name));
		if($mod_name=="")return false;
		
		$n = count($this->SYS_STRUC);
		for($i=0;$i<$n;$i++)
		{
			if($this->SYS_STRUC[$i]['mod_name']==$mod_name)
				return true;
		}
		return false;
	}
	
	/**
	 * Метод возвращает информацию о модуле по его имени
	 *
	 * @param string $mod_name
	 * @return array or false
	 */
	public function get_module($mod_name='')
	{
		$mod_name = trim(strtolower($mod_name));
		if($mod_name=="")return false;
		$result = false;
		$n = count($this->SYS_STRUC);
		for($i=0;$i<$n;$i++)
		{
			if($this->SYS_STRUC[$i]['mod_name']==$mod_name)
				$result = $this->SYS_STRUC[$i];
		}
		if(!$result)return false;
		
		$result['lib_way'] = substr($result['way'], 0, strpos($result['way'], "index.php"))."lib/";
		return $result;
		
	}
	
	/**
	 * Метод возвращает путь к каталогу библиотек модулей
	 *
	 * @param string $mod_name
	 * @return array or false
	 */
	public function get_module_lib_way($mod_name="")
	{
		$mod_name = trim(strtolower($mod_name));
		$result = array();
		if($mod_name!="")
		{
			$mod_data = $this->get_module($mod_name);
			if($mod_data)
				$result[0] = $mod_data['lib_way'];
			else 
				return false;
		}
		else
		{
			$mod_data = $this->SYS_STRUC;
			$n = count($mod_data);
			for($i=0;$i<$n;$i++)
			{
				if(is_dir(ROOT_WAY."includes/".$mod_data[$i]['lib_way']))
					$result[] = $mod_data[$i]['lib_way'];
			}
		}
		return $result;
	}
	
	/**
	 * Метод ищет модуль по его id
	 *
	 * @param integer $id
	 * @return array or false;
	 */
	public function get_module_by_id($id=0)
	{
		$id = (int)$id;
		if(!$id)
			return false;
		$result = false;
		$n = count($this->SYS_STRUC);
		for($i=0;$i<$n;$i++)
		{
			if($this->SYS_STRUC[$i]['modid']==$id)
				$result = $this->SYS_STRUC[$i];
		}
		if(!$result)return false;
		
		$result['lib_way'] = substr($result['way'], 0, strpos($result['way'], "index.php"))."lib/";
		return $result;		
	}
}

?>