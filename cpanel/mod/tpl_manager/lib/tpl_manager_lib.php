<?php
if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");

class tpl_manager
{
	private $DATA = array();
	
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
	
	public function __construct($SYS = array(), $USER_DATA = array())
	{
		if(!is_array($SYS))return false; 
		if(!is_array($USER_DATA))return false;
		if(count($SYS)== 0)return false;
		if(count($USER_DATA)== 0)return false;
		if((int)($USER_DATA['uid'])==0) return false;
		
		$this->DATA = array();
		$this->DATA['default']['zone_name_lenght'] = 50;
		$this->DATA['default']['title_lenght'] = 200;
		$this->DATA['default']['description_lenght'] = 200;
		$this->DATA['SYS'] = $SYS;
		
		$this->load_config(); // загрузка конфига		
	}
	
	/**
	 * Метод загружает конфигурационную информацию из файла конфигурации
	 *
	 * @return array
	 */
	public function load_config()
	{
		$this->DATA['config'] = Spyc::YAMLLoad($this->DATA['SYS']['CONFIG_DIR'].'tpl.yaml');
				
		return $this->DATA['config'];
	}
	
	/**
	 * Метод осуществляет проверку корректности имени файла layout
	 *
	 * @param string $layout_file имя файла, которое следует проверить
	 * @return boolean
	 */
	public function is_valid_layout_file($layout_file = "")
	{
		$layout_file = trim($layout_file);
		if($layout_file == "")return false;
		
		return true;
	}
	
	/**
	 * Метод осуществляет проверку корректности имени информационной зоны
	 *
	 * @param string $zone_name имя файла, которое следует проверить
	 * @return boolean
	 */
	public function is_valid_zone_name($zone_name = "")
	{
		$zone_name = trim($zone_name);
		if($zone_name == "") return false;
		
		return true;
	}
	
	/**
	 * Метод осуществляет проверку корректности имени шаблона меню
	 *
	 * @param string $menu_name
	 * @return boolean
	 */
	public function is_valid_menu_name($menu_name = "")
	{
		$menu_name = trim($menu_name);
		if($menu_name == "") return false;
		
		return true;
	}
	
	/**
	 * Метод првязывает информационную зону к layout
	 *
	 * @param string $zone_name имя информационной зоны
	 * @param string $layout_file имя файла layout
	 * @return boolean
	 */
	public function set_new_zone_link($zone_name = "", $layout_file="")
	{
		
		if(!$this->is_valid_layout_file($layout_file))return false;
		if(!$this->is_valid_zone_name($zone_name))return false;
		
		$layout_file_link_location = $this->get_layout_zones_location($layout_file); // получаем массив с индексами элементов массива
		
		$n = count($layout_file_link_location);
		$flag = 0;
		for($i=0; $i<$n; $i++)
		{
			if($this->DATA['config']['layout_zone_link'][$layout_file_link_location[$i]]['file'] == $layout_file)
			{
				if(is_array($this->DATA['config']['layout_zone_link'][$layout_file_link_location[$i]]['contain']))
				{
					if(!in_array($zone_name, $this->DATA['config']['layout_zone_link'][$layout_file_link_location[$i]]['contain']))
					{
						$this->DATA['config']['layout_zone_link'][$layout_file_link_location[$i]]['file'] = $layout_file;
						$this->DATA['config']['layout_zone_link'][$layout_file_link_location[$i]]['contain'] = array_merge($this->DATA['config']['layout_zone_link'][$layout_file_link_location[$i]]['contain'], array($zone_name));
					}
				}
				else 
				{
					$this->DATA['config']['layout_zone_link'][$layout_file_link_location[$i]]['file'] = $layout_file;
					$this->DATA['config']['layout_zone_link'][$layout_file_link_location[$i]]['contain'] = array($zone_name);
					
				}
				$flag = 1;
			}
		}
		if($flag!=1)
		{
			$n = count($this->DATA['config']['layout_zone_link']);
			$this->DATA['config']['layout_zone_link'][$n]['file'] = $layout_file;
			$this->DATA['config']['layout_zone_link'][$n]['contain'] = array($zone_name);
					
		}
		
		
		return true;				
	}
	
	/**
	 * Метод удаляет привязку информационной зоны к Layout
	 *
	 * @param string $zone_name имя инфомационной зоны
	 * @param string $layout_file имя файлв layout
	 * @return boolean
	 */
	public function remove_zone_link($zone_name = "", $layout_file="")
	{
		if(!$this->is_valid_layout_file($layout_file))return false;
		if(!$this->is_valid_zone_name($zone_name))return false;
		
		$layout_file_link_location = $this->get_layout_zones_location($layout_file);// получаем массив с индексами элементов массива
		$n = count($layout_file_link_location);
		for($ii=0;$ii<$n;$ii++)
		{
			if(is_array($this->DATA['config']['layout_zone_link'][$layout_file_link_location[$ii]]['contain']))
			{
				if(in_array($zone_name, $this->DATA['config']['layout_zone_link'][$layout_file_link_location[$ii]]['contain']))
				{
					$pos = array_search($zone_name, $this->DATA['config']['layout_zone_link'][$layout_file_link_location[$ii]]['contain']);
					$lenght = count($this->DATA['config']['layout_zone_link'][$layout_file_link_location[$ii]]['contain']);
					$result =  array();
					$j=0;
					for($i=0; $i<$lenght; $i++)
					{
						if($i != $pos)
						{
							$result[] = $this->DATA['config']['layout_zone_link'][$layout_file_link_location[$ii]]['contain'][$i];
						}
					}
					$result[] = $this->DATA['config']['layout_zone_link'][$layout_file_link_location[$ii]]['contain'] = $result;
					
				}
			}
		}
	
		return true;
	}
	
	/**
	 * Метод возвращает информацию о номере элемента массива, содержащего информацию о прилинкованых информационных зонах
	 *
	 * @param string $layout_file
	 * @return array 
	 */
	public function get_layout_zones_location($layout_file = "")
	{
		if(!$this->is_valid_layout_file($layout_file))return false;
		$layout_zone_link = $this->DATA['config']['layout_zone_link'];
		
		$n = count($layout_zone_link);
		if($n == 0) return false;
		$result = array();
		for($i=0; $i<$n; $i++)
		{
			if($layout_zone_link[$i]['file']==$layout_file) $result[] = $i;
		}
		return $result;
	}
	
	/**
	 * Метод возвращает параметры информационной зоны по имени зоны
	 *
	 * @param string $zone_name имя информационной зоны
	 * @return Array or False
	 */
	public function get_zone_info($zone_name = '')
	{
		if(!$this->is_valid_zone_name($zone_name))return false;
		
		$n = count($this->DATA['config']['zone']);
		for($i=0; $i<$n; $i++)
		{
			if($this->DATA['config']['zone'][$i]['name'] == $zone_name)
				return $this->DATA['config']['zone'][$i];				
		}
		return false;
	}
	
	/**
	 * Метод возвращает параметры шаблона меню по имени меню
	 *
	 * @param string $menu_name
	 * @return Array or false
	 */
	public function get_menu_info($menu_name = '')
	{
		if(!$this->is_valid_menu_name($menu_name))return false;
		
		$n = count($this->DATA['config']['menu']);
		for($i=0; $i<$n; $i++)
		{
			if($this->DATA['config']['menu'][$i]['name'] == $menu_name)
				return $this->DATA['config']['menu'][$i];				
		}
		return false;
	}
	
	/**
	 * Метод возвращает параметры layout по имени файла
	 *
	 * @param string $layout_file имя файла layout
	 * @return Array or False
	 */
	public function get_layout_info($layout_file = '')
	{
		if(!$this->is_valid_layout_file($layout_file))return false;
		
		$n = count($this->DATA['config']['layout']);
		for($i=0; $i<$n; $i++)
		{
			if($this->DATA['config']['layout'][$i]['file'] == $layout_file)
				return $this->DATA['config']['layout'][$i];				
		}
		return false;
	}
	
	/**
	 * Метод возвращает список информационых зон, привязанных к Layout
	 *
	 * @param string $layout_file имя файла Layout
	 * @return Array or False
	 */
	public function get_layout_zones($layout_file='')
	{
		if(!$this->is_valid_layout_file($layout_file))return false;
		
		$layout_zone_link = $this->DATA['config']['layout_zone_link'];
		
		$n=count($layout_zone_link);
		for($i=0; $i<$n; $i++)
		{
			if($layout_zone_link[$i]['file']==$layout_file)
			{
				return $layout_zone_link[$i]['contain'];
			}
				
		}
		return false;
		
	}
	
	/**
	 * Метод возвращает список зон не привязанных к данному layout
	 *
	 * @param string $layout_file имя файла Layout
	 * @return Array or False
	 */
	public function get_not_layout_zones($layout_file='')
	{
		if(!$this->is_valid_layout_file($layout_file))return false;
		
		$layout_zone_link = $this->DATA['config']['layout_zone_link'];
		
		$n=count($layout_zone_link);
		for($i=0; $i<$n; $i++)
		{
			if($layout_zone_link[$i]['file']==$layout_file)
			{
				$linked = $layout_zone_link[$i]['contain'];
			}
				
		}
		
		$zones =  $this->get_zones_list();
		$n = count($zones);
		$m = count($linked);
		
		$result = array();
		for ($i=0; $i<$n; $i++)
		{
			$flag = 0;
			for($j=0; $j<$m; $j++)
			{
				if($zones[$i]['name'] == $linked[$j]) $flag =1;
			}
			
			if($flag!=1)
				$result[]=$zones[$i];
				
			
		}
		if(count($result)>0)return $result;
		return false;
		
	}
	
	/**
	 * метод возвращает список всех информационных зон
	 *
	 * @return array
	 */
	public function get_zones_list()
	{
		return $this->DATA['config']['zone'];
	}
	
	/**
	 * метод возвращает список всех layout
	 *
	 * @return array
	 */
	public function get_layout_list()
	{
		return $this->DATA['config']['layout'];
	}
	
	/**
	 * метод сохраняет конфигурацию в yaml конфиг файле
	 *
	 */
	public function save_config()
	{
		$template_data_yaml = Spyc::YAMLDump($this->DATA['config']);
		file_put_contents($this->DATA['SYS']['CONFIG_DIR'].'tpl.yaml',$template_data_yaml);
		//$this->debug($this->DATA['config']);exit;
	}
	
	/**
	 * Метод устанавливает значение имени информационной зоны
	 *
	 * @param string $zone_name имя информационной зоны
	 * @return boolean
	 */
	public function set_zone_name($zone_name = '')
	{
		$zone_name = trim($zone_name);
		if($zone_name=="")return false;
		if(strlen($zone_name)>$this->DATA['default']['zone_name_lenght'])return false;
		
		$zone_name = eregi_replace('[ ]+','_',$zone_name);
		
		$this->DATA['tmp']['zone_name'] = $zone_name;
		return true;
	}
	
	/**
	 * Метод устанавливает значение названия элемента шаблона
	 *
	 * @param string $title
	 * @return boolean
	 */
	public function set_title($title = '')
	{
		$title = trim($title);
		if($title=="")return false;
		if(strlen($title)>$this->DATA['default']['title_lenght'])return false;
		
		$this->DATA['tmp']['title'] = $title;
		return true;
	}
	
	/**
	 * Метод устанавливает описание элемента шаблона
	 *
	 * @param string $description
	 * @return boolean
	 */
	public function set_description($description = '')
	{
		$description = trim($description);
		if(strlen($description)>$this->DATA['default']['description_lenght'])return false;
		
		$this->DATA['tmp']['description'] = $description;
		return true;
	}
	
	/**
	 * Метод создаёт новую информационную зону
	 *
	 * @return boolean
	 */
	public function create_zone()
	{
		if($this->DATA['tmp']['zone_name']=="")return false;
		if($this->DATA['tmp']['title']=="")return false;
		
		if($this->get_zone_info($this->DATA['tmp']['zone_name'])!=false)return false;
		
		$n=count($this->DATA['config']['zone']);
		$this->DATA['config']['zone'][$n]['name'] = $this->DATA['tmp']['zone_name'];
		$this->DATA['config']['zone'][$n]['title'] = $this->DATA['tmp']['title'];
		$this->DATA['config']['zone'][$n]['description'] = $this->DATA['tmp']['description'];
		$this->DATA['tmp'] = array();
		$this->save_config();
		return true;
	}
	
	/**
	 * Метод обновляет параметры информационной зоны
	 *
	 * @return boolean
	 */
	public function update_zone()
	{
		if($this->DATA['tmp']['zone_name']=="")return false;
		if($this->DATA['tmp']['title']=="")return false;
		
		if($this->get_zone_info($this->DATA['tmp']['zone_name'])==false)return false;
		
		$n=count($this->DATA['config']['zone']);
				
		for($i=0; $i<$n; $i++)
		{
			if($this->DATA['config']['zone'][$i]['name']==$this->DATA['tmp']['zone_name'])
			{
				$this->DATA['config']['zone'][$i]['title'] = $this->DATA['tmp']['title'];
				$this->DATA['config']['zone'][$i]['description'] = $this->DATA['tmp']['description'];
				return true;
			}
		}
//		$this->debug($this->DATA['config']['zone']);
		return false;
	}
}
?>