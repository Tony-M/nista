<?php
if(!defined('IN_SITE')) header("Location: http://".$_SERVER['SERVER_NAME']."");

class menu_manager{
	
	private $PREFIX = 'tbl_nista_';
	
	private $p_TBL_MENU = 'menu';
	private $p_TBL_MENU_LINKS = 'menu_links';
	private $p_TBL_MENU_RELATION = 'menu_relation';
	
	private $TBL_MENU = 'menu';
	private $TBL_MENU_LINKS = 'menu_links';
	private $TBL_MENU_RELATION = 'menu_relation';
	
	private $TEMPLATE = ""; // Ссылка на объект template_manager
	
	private $DATA = array(); // Массив данных
	
	public function __construct($TEMPLATE = "")
	{
		$this->TBL_MENU = $this->PREFIX.$this->p_TBL_MENU;
		$this->TBL_MENU_LINKS = $this->PREFIX.$this->p_TBL_MENU_LINKS;
		$this->TBL_MENU_RELATION = $this->PREFIX.$this->p_TBL_MENU_RELATION;
		
		//if(!class_exists("Spyc"))
		//	return false;
		
		$this->TEMPLATE = &$TEMPLATE;
		//$this->TEMPLATE->debug();
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
			$this->TBL_MENU = $prefix.$this->p_TBL_MENU;
			$this->TBL_MENU_LINKS = $prefix.$this->p_TBL_MENU_LINKS;
			$this->TBL_MENU_RELATION = $prefix.$this->p_TBL_MENU_RELATION;
		}
		else 
		{
			$this->TBL_MENU = $this->PREFIX.$this->TBL_MENU;
			$this->TBL_MENU_LINKS = $this->PREFIX.$this->TBL_MENU_LINKS;
			$this->TBL_MENU_RELATION = $this->PREFIX.$this->TBL_MENU_RELATION;
		}
		return true;
	}
	
	public function get_zones_content()
	{
		$zones = $this->TEMPLATE->get_layout_zonez();
		if(!$zones) return false;
		
		$n = count($zones);
		if(!$n) return false;
		
		if((int)$this->DATA['partition_id'] == 0)
			return false;
		
		
		$container_list = $this->get_menu_container_list();
		if(!$container_list)return false;

		$m = count($container_list);
		
		$this->debug($container_list);
		
		$result = array();
		for($i=0; $i<$n; $i++)
		{
			$result[$zones[$i]] = array();
			$k =0;
			for($j=0; $j<$m; $j++)
			{
				if($zones[$i]==$container_list[$j]['zone_name'])
				{
					$result[$zones[$i]]['menu_container'][$k] = $container_list[$j];
					if($this->set_menu_container_id($container_list[$j]['menu_id']))
					{
						$result[$zones[$i]]['menu_container'][$k]['items'] = $this->get_menu_container_content();
					}
				}
			}
			
			
		}
			
		
		$this->debug($result	);exit;
	}
	
	public function set_partition_id($id =0)
	{
		$id = (int)$id;
		if(!$id)return false;
		
		$this->DATA['partition_id'] = $id;
		return true;
	}
	
	/**
	 * Метод возвращает список всех контейнеров меню для данного раздела
	 *
	 * @return Array or false
	 */
	private function get_menu_container_list()
	{
		if((int)$this->DATA['partition_id'] == 0)
			return false;
			
		$query = "select m.* , l.* from `".$this->TBL_MENU."` as m, `".$this->TBL_MENU_LINKS."` as l
						where
							m.menu_id=l.menu_id and
							m.status='on' and
							m.type='container' and
							l.status='on' and
							l.prt_id='".$this->DATA['partition_id']."'  
							order by l.order asc";
		//echo $query;
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result = array();
			while($tmp = mysql_fetch_array($result_id, MYSQL_ASSOC))
			{
				$result[] = $tmp;
			}
			mysql_free_result($result_id);
			return $result;
		}
		return false;
		
	}
	
	/**
	 * Метод возвращает список пунктов для выбранного контейнера меню
	 *
	 * @return Array or false
	 */
	public function get_menu_container_content()
	{
		$this->DATA['menu_container_id'] = (int)$this->DATA['menu_container_id'];
		if(!$this->DATA['menu_container_id'])
			return false;
			
		if((int)$this->DATA['partition_id'] == 0)
			return false;
		
		if(!$this->is_menu_container())	
			return false;
			
		$query = "select m.* , r.* from `".$this->TBL_MENU."` as m, `".$this->TBL_MENU_RELATION."` as r
						where
							r.parent_id='".$this->DATA['menu_container_id']."' and
							r.item_id=m.menu_id and 
							r.status='on' and
							m.status='on' and
							m.type='item' and 
							r.prt_id in ( '".$this->DATA['partition_id']."', '0' )
							order by m.sequence asc";
		echo $query;
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result = array();
			while ($tmp = mysql_fetch_array($result_id, MYSQL_ASSOC))
			{
				$result[] = $tmp;
			}
			mysql_free_result($result_id);
			return $result;
		}
		return false;
	}
	
	/**
	 * Метод устанавливает значение id контейнера меню
	 *
	 * @param integer $id
	 * @return boolean
	 */
	public function set_menu_container_id($id = 0)
	{
		$id = (int)$id;
		if(!$id)
		{
			$this->DATA['menu_container_id'] = 0;
			return false;
		}
		
		$this->DATA['menu_container_id'] = $id;
		return true;		
	}
	
	/**
	 * Метод проверяет, является ли данная запись контейнером меню
	 *
	 * @return Array or false
	 */
	public function is_menu_container()
	{
		if((int)$this->DATA['menu_container_id'] == 0)	
			return false;
		
		$query = "select * from `".$this->TBL_MENU."` 
						where
							status = 'on' and
							type='container' and
							menu_id='".$this->DATA['menu_container_id']."'
							limit 1";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);
			return $result;
		}
		return false;
		
	}
}
?>