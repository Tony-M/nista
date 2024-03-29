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
		
		$phpversion =  self::get_phpversion ();
		
		if ($phpversion<=40100)
		{
			global $HTTP_POST_VARS, $HTTP_GET_VARS;
			$result = ( isset($HTTP_POST_VARS[$var_name]) ) ? $HTTP_POST_VARS[$var_name] : $HTTP_GET_VARS[$var_name];
		}
		else
		{
			global $_POST, $_GET;
			$result = ( isset($_POST[$var_name]) ) ? $_POST[$var_name] : $_GET[$var_name];
		}
			
		return $result;
	}
	
	public static function POST($var_name = "")
	{
		$var_name = trim($var_name);
		if($var_name=="")return false;
		
		$phpversion =  self::get_phpversion ();
		
		if ($phpversion<=40100)
		{
			global $HTTP_POST_VARS;
			$result =  $HTTP_POST_VARS[$var_name];
		}
		else
		{
			global $_POST;
			$result =$_POST[$var_name];
		}
			
		return $result;
	}
	
	public static function GET($var_name = "")
	{
		$var_name = trim($var_name);
		if($var_name=="")return false;
		
		$phpversion =  self::get_phpversion ();
		
		if ($phpversion<=40100)
		{
			global $HTTP_GET_VARS;
			$result =  $HTTP_GET_VARS[$var_name];
		}
		else
		{
			global $_GET;
			$result =$_GET[$var_name];
		}
			
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
	 * Метод возвращает текущую версию php например 50200 40100
	 * @return integer
	 */
	public static function get_phpversion () 
	{
		$a = phpversion ();
		$a = explode ('-', $a);
		$a = $a[0];
		$version = explode('.',$a);
    	$PHP_VERSION_ID = $version[0] * 10000 + $version[1] * 100 + $version[2];
		return $PHP_VERSION_ID;
	}
	
	
}

?>