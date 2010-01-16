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
		
		global $HTTP_POST_VARS, $HTTP_GET_VARS;
		
		$result = ( isset($HTTP_POST_VARS[$var_name]) ) ? $HTTP_POST_VARS[$var_name] : $HTTP_GET_VARS[$var_name];
				
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
}

?>