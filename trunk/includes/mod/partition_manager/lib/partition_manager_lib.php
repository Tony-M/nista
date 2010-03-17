<?php
if(!defined('IN_SITE')) header("Location: http://".$_SERVER['SERVER_NAME']."");

class partition_manager{
	
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
	
	public function set_id($id = 0)
	{
		$id = intval($id);
		$this->DATA['id'] = 0;
		if(!$id)
			return false;
		
		$this->DATA['id'] = $id;
		return true;
	}
	
	public function detect_partition()
	{
		$partition = array(); // result partition info 
		
		// если data задано то пробуем найти по нему
		$data = (int)std_lib::POST_GET('data');
		
		if($data!=0)
		{	
			
			$link = $_SERVER['PHP_SELF']."?data=".$data;
			
			if($partition = $this->get_partition_by_link($link))
				return $partition;
			else
			{
				//$link = dirname($_SERVER['PHP_SELF']);
				//if($partition = $this->get_partition_by_link($link))
				//	return $partition;
				//else 
				//{
					//std_lib::Page404();
					$flag = 0;
					echo $data_pid = $data;
					
					if($data ==1)
						$root_flag =1;
					//$i=0;	
					while(!$flag)
					{
						//echo $i++;
						//if($i==10)exit;
						if($this->set_id($data_pid))
						{
							if($partition=$this->get_record())
							{
								if($partition['type']=='prt')
								{
									$link = dirname($_SERVER['PHP_SELF']);
									$pos = strpos($partition['link'], $link);
									if($pos===false)
										std_lib::Page404();
									else 
									{
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
												$this->debug($par_array);
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
											}
												
										}
										die($adres);
									}
								}
								else 
								{
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
					///////					
					
				//}
			}
				
			
//			$flag = 0;
//			$data_pid = $data;
//			
//			if($data ==1)
//				$root_flag =1;
//				
//			while(!$flag)
//			{
//				if($this->set_id($data_pid))
//				{
//					if($partition=$this->get_record())
//					{
//						if($partition['type']=='prt')
//							return $partition;
//						else 
//						{
//							if($root_flag)
//								return false; // т к id==1 и это не root partition
//								
//							if($partition['pid']==$partition['id'])
//								return false;
//								
//							$data_pid = $partition['pid'];
//						}
//					}
//				}
//				else 
//					return false; // в data не число
//			}
		}
		else 
		{
			$link = dirname($_SERVER['PHP_SELF']);
			if($partition = $this->get_partition_by_link($link))
				return $partition;
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
		echo $query."<br>";
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
		echo $query."<br>";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)==1))
		{
			$result = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);
			
			return $result;
		}
	}
	
	
}
?>