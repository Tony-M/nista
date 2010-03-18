<?php
if(!defined('IN_SITE')) header("Location: http://".$_SERVER['SERVER_NAME']."");

class partition_manager{
	
	private $PREFIX = 'tbl_nista_';
	private $p_TBL_DATA_STRUCTURE = 'data_structure';
	
	private $TBL_DATA_STRUCTURE = 'data_structure';
	
	private $DATA = array(); // Массив данных
	
	private $DETECT_REPORT = array(); // Массив содержащий отчёт о результатах работы метода $this->detect_partition();
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
	 * Метод определяет текущий раздел сайта
	 *
	 * @return Array or false
	 */
	public function detect_partition()
	{
		$partition = array(); // result partition info 
		
		// если data задано то пробуем найти по нему
		$data = (int)std_lib::POST_GET('data');
		
		if($data!=0)
		{	// пробуем найти цель по заданному id (data)
			
			$link = $_SERVER['PHP_SELF']."?data=".$data; // собираем текущий путь для поиска по БД
			
			if($partition = $this->get_partition_by_link($link))
			{
				// найдено соответствие пути с разделом в бд - найден нужный раздел
				$this->DETECT_REPORT['partition'] = $partition; // данные раздела
				$this->DETECT_REPORT['initial_is_partition'] = true; // была ссылка на раздел а не на чтото стороннее в нём
				
				return $partition; 
			}
			else
			{	
				// раздел не был найден, значит попробуем найти целевой обект и его родительский раздел
		
				$this->DETECT_REPORT['initial_is_partition'] = false; // ссылка была не на раздел а на его содержимое
			
				$flag = 0; // флаг для выхода из цикла поиска родительского раздела
				$data_pid = $data; // id - родительского элемента
				
				if($data ==1) 
					$root_flag =1; //если pid =1 то это корневой раздел и там бескоечная рекурсия.
				
				$flag_first_iteration = 0; // флаг первой итерации
				while(!$flag)
				{					
					$flag_first_iteration ++;
					
					if($this->set_id($data_pid))
					{
						if($partition=$this->get_record())
						{
							if($partition['type']=='prt')
							{	
								// родительский элемент - раздел. проверяем сходная ли ссылка у раздела с нашей искомой
								$link = dirname($_SERVER['PHP_SELF']);
								$pos = strpos($partition['link'], $link);
								if($pos===false) 
								{
									$flag =1;
									std_lib::Page404(); // ссылки не совпали, значит раздел не найден.
								}
								else 
								{
									// поскольку раздел найден, то теперь надо редиректнуть на него.
									$pos = strpos($partition['link'], "index.php");
									if($pos === false)
									{
										if(substr($partition['link'], -1)=="/")
											$adres=$partition['link']."index.php?data=".$data;
										else 
											$adres=$partition['link']."/index.php?data=".$data;												
									}
									else 
									{
										$pos=strpos($partition['link'], "?");
										if($pos === false)
											$partition['link'] .= "?";
																				
										$pos=strpos($partition['link'], "data");
										
										if($pos === false)
											$adres = $partition['link']."&data=".$data;
										else 
										{
											
											$params =  parse_url($partition['link'], PHP_URL_QUERY);
											$par_array = explode("&", $params);
											//$this->debug($par_array);
											$n = count($par_array);
											for($i=0;$i<$n;$i++)
											{
												$pos = strpos($par_array[$i],"data=");
												if($pos !== false)
												{
													$par_array[$i] = "data=".$data;
												}
											}
											
											$adres = substr($partition['link'],0,strpos($partition['link'], "?")+1).implode("&", $par_array);
											
											/*
											$arg = $_SERVER['QUERY_STRING'];
											$arg_arr = explode("&", $arg);
											$n=count($arg_arr);
											$additional_arg = "";
											for($i=0;$i<$n;$i++)
											{
												if(strpos($arg_arr[$i],"data=")!==0)
												{
													$additional_arg .= "&".$arg_arr[$i];
												}
											}
											$adres .= $additional_arg;
											*/
										}
											
									}
									//die($adres);
									$link = $_SERVER['PHP_SELF']."?data=".$data;
									if($adres == $link)
									{
										$this->DETECT_REPORT['partition'] = $partition;
										return $partition;
									}
									else 
										std_lib::Page404();
								}
							}
							else 
							{
								if($flag_first_iteration==1)
								{
									// результат который мы получили - некое содержимое раздела
									$this->DETECT_REPORT['content'] = $partition;
									$this->DETECT_REPORT['content_exists'] = true;
								}
								
								if($root_flag)
									std_lib::Page404(); // т к id==1 и это не root partition
									
								if($partition['pid']==$partition['id'])
								{
									std_lib::Page404();
									//std_lib::LOCATION()
								}
									//std_lib::Page404();
									
								$data_pid = $partition['pid'];
							}
						}
						else 
						{
							$flag=1;
							
							
						}
					}
					else 
						return false; // в data не число
				}
			}				
		}
		else 
		{
			$link = dirname($_SERVER['PHP_SELF']);
			if($partition = $this->get_partition_by_link($link))
			{
				$this->DETECT_REPORT['partition'] = $partition;
				return $partition;
			}
			else 
				std_lib::Page404();
		}
		
		std_lib::Page404();
		
		
		
	}
	
	/**
	 * Метод возвращает дынные раздела по его id
	 *
	 * @return Array or false
	 */
	public function get_partition()
	{
		$this->DATA['id'] = intval($this->DATA['id']);
		if(!$this->DATA['id'])
			return false;
		
		$query = "select * from `".$this->TBL_DATA_STRUCTURE."` where status='on' and type='ptr' and id='".$this->D['id']."' limit 1";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)==1))
		{
			$result = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);
			return $result;
		}
		
	}
	
	public function get_partition_by_link($link="")
	{
		$link = trim($link);
		if($link=="")return false;
		
		$query = "select * from `".$this->TBL_DATA_STRUCTURE."` where status='on' and type='prt' and link='".$link."' limit 1";
		//echo $query."<br>";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)==1))
		{
			$result = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);
			return $result;
		}
		
	}
	
	/**
	 * метод возвращает данные записи из таблицы data_structure
	 *
	 * @return array or false
	 */
	public function get_record()
	{
		
		$this->DATA['id'] = intval($this->DATA['id']);
		if(!$this->DATA['id'])
			return false;
		
		$query = "select * from `".$this->TBL_DATA_STRUCTURE."` where status='on' and id='".$this->DATA['id']."' limit 1";
		//echo $query."<br>";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)==1))
		{
			$result = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);
			
			return $result;
		}
	}
	
	
}
?>