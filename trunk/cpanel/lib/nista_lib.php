<?php
if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");
class nista{
	/*
	*  Kernell information
	*/

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

	private $SYS_STRUC = array(); // system structure

	private $MY_DATA = array(); // user information

	/**
     * Конструктор объекта Nista CMS
     * Input: has 2 arguments - associative arrays $SYS and $USER
     * $SYS: contains all system information needed to establish base facility of CMS
     * $USER: contains base information about current user after his|her validation in system
     *
     * @param array $SYS
     * @param array $USER
     */
	public function __construct($SYS, $USER=0)
	{
		$this->SYS_STRUC['SYS'] = $SYS;
		
		if(!$this->get_sys_structure())return false;
	
		//    	if(!$this->get_sys_structure())return false;
		//    	$this->get_libs_by_mod_name("site_common_settings");
		// 		creating user information
		//    	$this->MY_DATA = $MY_DATA;
		//    	$this->generate_SDTC();
		//    	$this->init_forbidden_dir();// инициализация базовых системных каталогов
	}

	public function debug($inp)
	{
		echo "<hr><pre>";
		print_r($inp);
		echo "</pre>";
	}

	public function debug_STRUCT()
	{
		echo "<hr><pre>";
		print_r($this->SYS_STRUC);
		echo "</pre>";
	}

	public function get_my_user_id()
	{
		if(eregi("[0-9]", $this->MY_DATA['uid']) && ($this->MY_DATA['uid'] != 0))
		return $this->MY_DATA['uid'];
		else return false;
	}

	/**
	 * Метод создаёт из всех возможных языковых файлов единый сводный файл
	 * что обеспечивает большее быстродействие
	 *
	 * @return array
	 */
	public function generate_i18n_data()
	{
		if($this->SYS_STRUC['SYS']['LANG_DIR']=="") 
			return  false;
		
		if(file_exists($this->SYS_STRUC['SYS']['LANG_DIR']."nista_lang.xml"))
			$nisla_lang_xml = file_get_contents($this->SYS_STRUC['SYS']['LANG_DIR']."nista_lang.xml");
			
		$xml_i18n = new SimpleXMLElement($nisla_lang_xml);
//		$this->debug($xml_i18n);
		
		$LANG = array();
		
		foreach ($xml_i18n->file->body->group as $group)
		{ 
			$i = 0;
			foreach ($group->trans_unit as $trans_unit)
			{
				$LANG[(string)$group['type']][$i]['source'] = (string)$trans_unit->source;
				$LANG[(string)$group['type']][$i][(string)$trans_unit->source['lang']] = (string)$trans_unit->source;
				if(count($trans_unit->target))
				{
					foreach ($trans_unit->target as $target)
					{
						$LANG[(string)$group['type']][$i][(string)$target['lang']] = (string)$target;
						
					}
				}
				
				$i++;
			}
//			
		}
		
		//$this->debug($LANG);
		return $LANG;
	}

	/**
     * Функция возвращает иформацию о текущем пользоватее, для импорта в другие библиотеки модулей
     *
     * @return array
     */
	public function get_my_data()
	{
		$result = array();
		$result['uid'] = $this->get_my_user_id();

		return $result;
	}
	
	/**
     * Функция возвращает информацию о пользователе, от лица которого идёт работа в сеансе
     *
     * @param unknown_type $inf
     * @return unknown
     */
	public function get_current_user_info($inf = "")
	{
		if(($inf=="") || ($inf=="passwd"))return false;

		if(array_key_exists($inf, $this->MY_DATA))return $this->MY_DATA[$inf];
		else return false;
	}

	/*
	*     Return system kernell information
	*/
	public function get_kernell_info()
	{
		$result = array('version' => $this->KERNELL_VERSION, 'version_type' => $this->KERNELL_VERSION_TYPE);
		return $result;
	}


	/**
	 * Метод возвращает информацию о системе
	 *
	 * @return array
	 */private function get_sys_structure()
	{
		//функция для сбора системной информации (глобально)
		$query = "select * from ".$this->PREFIX."mod" ;
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			while ($tmp_ar=mysql_fetch_array($result_id, MYSQL_ASSOC))
			{
				$this->SYS_STRUC['mod_tab'][] = $tmp_ar;
			}
			mysql_free_result($result_id);
			return true;
		}
		else return false;
	}
	
	/**
	 * Метод возвращает список системных уровней доступа
	 *
	 * @return array
	 */
	public function get_sys_post_list()
	{
		return $this->SYS_POST;
	}

	public function get_level_mod_creator($inp=0)
	{
		if(!ereg("[0-9]", $inp))  return false;

		$query = "select * from ".$this->PREFIX."object_hierarchy where level_id='".$inp."'";

		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);

			$tmp_ar = $this->get_module_info_by_id($result[mod_id]);
			if(is_array($tmp_ar))
			$result = array_merge($result, $tmp_ar);
			else
			return false;
			return $result;
		}
	}



	/*
	*    get post name by numeric identificator
	*/
	public function get_post_name($post_id = 0)
	{
		$n = count($this->SYS_POST);
		if(($post_id >$n-1) || ($post_id<0))return "indefinite";
		else return  $this->SYS_POST[$post_id];
	}//end of   function get_post_name

	//
	// function returns string value of your post in system
	//
	public function get_my_post($tmp_par="")
	{    	Global $TBL_NISTA_ADMINS; // variables

	Global  $user_class; // classes


	$my_uid = $user_class->check_valid_user($opt_par="uid");
	$query = "select post from ".$TBL_NISTA_ADMINS." where uid='".$my_uid."'";
	if(mysql_num_rows($result_id=mysql_query($query))>0)
	{        	$my_tmp_info = mysql_fetch_array($result_id, MYSQL_ASSOC);
	$my_post_info = $my_tmp_info['post'];
	mysql_free_result($result_id);
	}
	else $my_post_info = 0;

	if($tmp_par=="")return array($my_tmp_info['post'], $this->get_post_name($my_post_info));
	if($tmp_par=="name")return  $this->get_post_name($my_post_info);
	if($tmp_par=="num")return  $my_tmp_info['post'];
	//$user_class->check_valid_user();
	}





	public function get_proper_module_way($mod_par="ind")
	{
		// running module defined by parametr $p
		$query = "SELECT  *
                         FROM ".$this->PREFIX."mod 
                         WHERE status ='on' AND par='$mod_par'";
//		echo $query;
		$result_id = mysql_query($query);

		if(@mysql_num_rows($result_id)>0)
		{
			$mod_info =  mysql_fetch_array($result_id, MYSQL_ASSOC) ;
			mysql_free_result($result_id);
		}//end of if
		else
		{        	$mod_par="ind";
		// running module defined by parametr $p
		$query = "SELECT  *
                         FROM ".$this->PREFIX."mod 
                         WHERE status ='on' AND par='$mod_par'";
		$result_id = mysql_query($query);        	if(@mysql_num_rows($result_id)>0)
		{
			$mod_info =  mysql_fetch_array($result_id, MYSQL_ASSOC) ;
			mysql_free_result($result_id);
		}//end of if
		}

		return $mod_info['way'];

	}//end of function run_module

	public function get_module_by_id($id=0)
	{
		global $TBL_NISTA_MOD;

		if(!(int)$id)  return false;
		// running module defined by parametr $p
		$query = "SELECT  *
                         FROM ".$this->PREFIX."mod 
                         WHERE modid='$id'";
		//echo $query."<br>";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$mod_info =  mysql_fetch_array($result_id, MYSQL_ASSOC) ;
			mysql_free_result($result_id);
			return $mod_info;
		}
		else return False;


	}//end of function

	/**
     * returns mod_id by it`s par from URI 
     *
     * @param string $par
     * @return integer
     */
	public function get_module_id($par="ind")
	{
		if($par == "")return  false;

		$n = count ($this->SYS_STRUC[mod_tab]);
		for($i=0; $i<$n; $i++)
		{
			$tmp_ar = $this->SYS_STRUC[mod_tab][$i];

			if($tmp_ar['par'] == $par)
			{
				return $tmp_ar['modid'];
			}
		}
		return false;

	}//end of function get_module_id

	public function get_proper_module_name($mod_par="ind")
	{
		global $TBL_NISTA_MOD;
		// running module defined by parametr $p
		$query = "SELECT  *
                         FROM ".$TBL_NISTA_MOD."
                         WHERE status ='on' AND par='$mod_par'";
		//echo $query;
		$result_id = mysql_query($query);

		if(@mysql_num_rows($result_id)>0)
		{
			$mod_info =  mysql_fetch_array($result_id, MYSQL_ASSOC) ;
			mysql_free_result($result_id);
		}//end of if

		return $mod_info['name'];

	}//end of function run_module



	public function get_libs_by_mod_name($name="")
	{
		if($name == "")return  false;

		$n = count ($this->SYS_STRUC[mod_tab]);
		for($i=0; $i<$n; $i++)
		{
			$tmp_ar = $this->SYS_STRUC[mod_tab][$i];

			if($tmp_ar['mod_name'] == $name)
			{

				return $tmp_ar['private_class'];
			}

		}
		return false;

	}

	/**
	 * Метод возвращает базовое системное описание модуля по его имени
	 *
	 * @param string $name
	 * @return array
	 */
	public  function get_module_info_by_name($name="")
	{
		if ($name=="") return  false;

		$n = count ($this->SYS_STRUC[mod_tab]);
		for($i=0; $i<$n; $i++)
		{
			$tmp_ar = $this->SYS_STRUC[mod_tab][$i];

			if($tmp_ar['mod_name'] == $name)
			{

				return $tmp_ar;
			}

		}
		return false;

	}
	
	/**
	 * Метод возвращает базовое системное описание модуля по вызывающему параметру
	 *
	 * @param string $par
	 * @return array
	 */
	public  function get_module_info_by_par($par="")
	{
		if ($par=="") return  false;

		$n = count ($this->SYS_STRUC[mod_tab]);
		for($i=0; $i<$n; $i++)
		{
			$tmp_ar = $this->SYS_STRUC[mod_tab][$i];

			if($tmp_ar['par'] == $par)
			{

				return $tmp_ar;
			}

		}
		return false;

	}
	
	

	/**
     * Функция возвращает системную информацию о всех модулях системы.
     *
     * @return ассоциативный массив
     */
	public function get_module_struc_info()
	{
		return $this->SYS_STRUC['mod_tab'];
	}

	public  function get_module_info_by_id($id="")
	{
		if(!ereg("[0-9]", $id))  return false;

		$n = count ($this->SYS_STRUC[mod_tab]);
		for($i=0; $i<$n; $i++)
		{
			$tmp_ar = $this->SYS_STRUC[mod_tab][$i];

			if($tmp_ar['modid'] == $id)
			{

				return $tmp_ar;
			}

		}
		return false;

	}


	public   function can_i_do( $func_name = "none", $mod_id = 0)
	{
		if(!ereg("[0-9]", $mod_id))  return false;
		if($func_name == "none") return false;

		if($_SESSION['UNAME'] == 'root') return true; // доделать более качественную проверку пользователя на предмет подделки рута

	}

	/**
     * Функция возвращает список библиотек модулей расположенных в каталогах моделуй и занесённых в БД в поле private_class
     *
     * @return array
     */
	public  function get_mod_libs()
	{
		$result = array();
		foreach ($this->SYS_STRUC['mod_tab'] as  $value)
		{
			if(eregi("^(mod)+[\\/a-zA-Z0-9_@\.\-]+(_lib).(php)", $value['private_class']))
			{
				$result[] = $value['private_class'];
			}//end of if
		}

		return $result;
	}

	/**
     * Функция устанавливает путь к корню сайта
     *
     * @param string $root_way
     */
	public function set_root_way($root_way="")
	{
		$this->SYS_STRUC['root_way'] = $root_way;
		return true;
	}
	/**
     * Функция устанавливает путь к административной части относительно корня сайта
     *
     * @param string $root_way
     */
	public function set_admin_way($admin_way="")
	{
		$this->SYS_STRUC['admin_way'] = $admin_way;
		$this->init_forbidden_dir($admin_way);
		return true;
	}

	public function get_forbidden_dirs()
	{
		return $this->SYS_STRUC['forbidden_public_dirs'];
	}
	/**
     * Функция возвращает список шаблонов отображения сайта  и его элементов
     *
     * @param string $type
     * @return array
     */
	public function get_templates($type = "")
	{
		if(file_exists($this->SYS_STRUC['root_way']."includes/etc/templates.xml")) $file_content = file_get_contents($this->SYS_STRUC['root_way']."includes/etc/templates.xml");
		else return false;
		$template_arr = array();

		$xml = new SimpleXMLElement($file_content);
		$i=0;
		foreach ($xml->template as $template_el)
		{
			$template_arr[$i]['title'] = iconv("utf-8", "cp1251",  (string)$template_el[0]);
			$template_arr[$i]['comment'] =  iconv("utf-8", "cp1251",(string)$template_el['comment']);
			$template_arr[$i]['status'] = (string)$template_el['status'];
			$template_arr[$i]['src'] = (string)$template_el['src'];
			$template_arr[$i]['type'] = (string)$template_el['type'];
			$template_arr[$i]['default'] = (string)$template_el['default'];
			$template_arr[$i]['img'] = (string)$template_el['img'];
			$i++;
		}

		if($type!="")
		{
			$n= count($template_arr);
			$result = array();
			for ($i = 0; $i<$n ;$i++ )
			{
				if($template_arr[$i]['type'] == $type) $result[] = $template_arr[$i];
			}
			return $result;
		}
		else return $template_arr;
	}

	/**
     * Функция инициализируетс список каталогов, используемых системой и недоступных для использования пользоватеями фронтэнда
     *
     * @param string dir way $dir_way
     */
	public function init_forbidden_dir($dir_way="")
	{
		if($dir_way=="")
		{
			$this->SYS_STRUC['forbidden_public_dirs'][count($this->SYS_STRUC['forbidden_public_dirs'])]="/img";
			$this->SYS_STRUC['forbidden_public_dirs'][count($this->SYS_STRUC['forbidden_public_dirs'])]="/src";
			$this->SYS_STRUC['forbidden_public_dirs'][count($this->SYS_STRUC['forbidden_public_dirs'])]="/includes";
		}
		else
		{
			if(!in_array( $dir_way, $this->SYS_STRUC['forbidden_public_dirs']))
			$this->SYS_STRUC['forbidden_public_dirs'][count($this->SYS_STRUC['forbidden_public_dirs'])]=$dir_way;
		}
	}
	
	/**
	 * Метод возвращает список доступных расширений рисунков
	 *
	 * @return Array or false
	 */
	public function get_image_types()
	{
		if(count($this->p_IMG_TYPES)>0)
			return $this->p_IMG_TYPES;
		else 
			return false;
	}
	
	/**
	 * Метод выдаёт список фронтенд иконок (с возможной фильтрацией по типу файла)
	 *
	 * @param string $type типа файла без точки
	 * @return Array or False
	 */
	public function get_ico_list($type = "")
	{
		$dir = ROOT_WAY."img/ico";
		$types = $this->get_image_types();
		if(!$types) return false;
		
		if($type!="")
			if(!in_array($type, $types)) return false;
		$result = array();
		$dir = opendir($dir);
		while (false !==($file = readdir($dir)))
		{
		    $file;
		
		    if(eregi("^(ico_)", $file))
		    {
		    	if($type !="")
		    	{
		    		if(strtolower(substr($file, -strlen($file) + strrpos($file, ".")+1))==$type)
		    			$result[] = $file;		    
		    	}
		    	else 
		    		$result[] = $file;
		    	
		    }
		}
		closedir($dir);
		if(!count($result))
			return false;
		else 
			return $result;
	}



}//end of class


?>