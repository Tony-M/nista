<?php
if(!defined('IN_SITE')) header("Location: http://".$_SERVER['SERVER_NAME']."");

class template_manager{
		
	private $DATA = array(); // Массив данных
	
	
	
	public function __construct()
	{
		$this->load_config();
		//$this->debug();
		
	}
	
	
	public function __destruct()
	{}
	
	public function debug($inp="")
	{
		echo "<hr><pre>";
		if($inp!="")print_r($inp);
		else print_r($this->DATA);
		echo "</pre>";
	}
	
	/**
	 * Метод загружает конфигурационную информацию из файла конфигурации
	 *
	 * @return array
	 */
	public function load_config()
	{
		$this->DATA['config'] = Spyc::YAMLLoad(ROOT_WAY.'includes/etc/'.'tpl.yaml');
				
		return $this->DATA['config'];
	}
	
	/**
	 * Метод задаёт файл layout 
	 *
	 * @param string $layout_file
	 * @return boolean
	 */
	public function set_layout($layout_file="")
	{
		$layout_file = trim($layout_file);
		if($layout_file == "")return false;
		
		if($this->find_layout($layout_file)===false) return false;
		$this->DATA['layout_file'] = $layout_file;
		return true;
	}
	
	/**
	 * метод ищет layout по файлу. В случае если находит, то возвращает ключь элемента массива.
	 *
	 * @param string $layout_name
	 * @return integer or Flase
	 */
	public function find_layout($layout_file="")
	{
		$layout_file = trim($layout_file);
		if($layout_file == "")return false;
		
		$n = count($this->DATA['config']['layout']);
		for($i=0; $i<$n; $i++)
		{
			if($this->DATA['config']['layout'][$i]['file']==$layout_file) return $i;
		}
			
		return false;
	}
	
	/**
	 * Метод выдаёт список всех информационных зон данного layout
	 *
	 * @return array or false
	 */
	public function get_layout_zonez()
	{
		if($this->DATA['layout_file']=="")return false;
		
		$n = count($this->DATA['config']['layout_zone_link']);
		for($i=0; $i<$n; $i++)
		{
			if($this->DATA['config']['layout_zone_link'][$i]['file']==$this->DATA['layout_file'])
			{
				$this->DATA['zones'] = $this->DATA['config']['layout_zone_link'][$i]['contain'];
				return $this->DATA['config']['layout_zone_link'][$i]['contain'];
			}
		}
		return false;
	}
}
?>
	