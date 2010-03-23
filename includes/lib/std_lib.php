<?php

class std_lib{
	
	/**
	 * Метод возвращает значение переменной, передаваемой методом POST или GET. приоритетнее метод POST
	 *
	 * @param string $var_name имя переменной
	 * @return mixed
	 */
	public static function POST_GET($var_name = "")
	{
		$var_name = trim($var_name);
		if($var_name=="")return false;
		
		global $_POST, $_GET;
		
		$result = ( isset($_POST[$var_name]) ) ? $_POST[$var_name] : $_GET[$var_name];
				
		return $result;
	}
	
	/**
	 * метод записывает запрос к БД в файл /query.log
	 *
	 * @param string $query
	 */
	public static function log_query($query)
	{
		file_put_contents(ROOT_WAY."/query.log", $query."\n", FILE_APPEND);
	}
	
	
	/**
	 * Метод записывает в лог требуемый текст
	 *
	 * @param string $text
	 */
	public static function log_text($text)
	{
		file_put_contents(ROOT_WAY."/text.log", $text."\n", FILE_APPEND);
	}
	
	/**
	 * Метод возвращает текущую дату
	 *
	 * @return string
	 */
	public static function get_date()
	{
		return date("Y-m-d H:i:s");
	}
	
	/**
	 * Метод возвращает текстовое соотбщение ok|err на основании результата выполнения операции
	 *
	 * @param boolean $result результат выполнения операции
	 * @return string ok|err
	 */
	public function get_ok_err_result($result)
	{
		if($result)
			return "ok";
		else 
			return "err";
	}
	
	/**
	 * Метод перенаправляет страницу по заданному адресу
	 *
	 * @param string $location
	 * @return boolean
	 */
	public function LOCATION($location = "")
	{
		$location = trim($location);
		if($location == "")
			return false;
		if(!filter_var($location, FILTER_VALIDATE_URL))
			return false;
		header("Location ".$location);
		exit;
	}
	
	/**
	 * метод генерирует событие 404 страницы
	 *
	 */
	public function Page404()
	{ // not found
		die("<b>Page 404</b>");
	}
	
	/**
	 * метод генерирует список основных css стилей сайта
	 *
	 * @return array
	 */
	public function get_site_css()
	{
		global $SYS;
		$css_dir = ROOT_WAY."includes/css/";
		$dir = opendir($css_dir);
		$result = array()   ;
		while (false !==($file = readdir($dir)))
		{
		    $file;
		
		    if(preg_match("/[a-zA-Z0-9_@\.\-]+\.(css)/", $file))
		    {
		    	if(file_exists($css_dir.$file))
		    	{
		    		$f = $SYS['HTTP_HOST']."/".preg_replace("/\.\.\//","",$css_dir.$file);
		    		
		    		$result[count($result)] = $f;
		    	}
		    }
		    $result = array_unique($result);
		}
		closedir($dir);
		return $result;
	}
	
	/**
	 * Метод генерирует список основных javascript файлов сайта
	 *
	 * @return array
	 */
	public function get_site_js()
	{
		global $SYS;
		$css_dir = ROOT_WAY."includes/js/";
		$dir = opendir($css_dir);
		$result = array()   ;
		while (false !==($file = readdir($dir)))
		{
		    $file;
		
		    if(preg_match("/[a-zA-Z0-9_@\.\-]+\.(js)/", $file))
		    {
		    	if(file_exists($css_dir.$file))
		    	{
		    		$f = $SYS['HTTP_HOST']."/".preg_replace("/\.\.\//","",$css_dir.$file);
		    		
		    		$result[count($result)] = $f;
		    	}
		    }
		    $result = array_unique($result);
		}
		closedir($dir);
		return $result;
	}
	
}

?>