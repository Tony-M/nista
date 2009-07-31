<?php

// ***********************************************************************************************************
//
//	Name: 			Pagination Manager
//	Version: 		1.0
//	Description:		A PHP script for working pagination
//	Compatibility:		PHP5
//	
//	Author: 		Morozov Anton Andreevich
//	E-mail:			morozov_aa@tonymstudio.ru
//	lscript web site:	www.nista.ru
//	
//	Last Modified:	05/12/2008
//	
//	Copyright (c) Morozov Anton Andreevich
//	All rights reserved.
//		
//	This Software is distributed under the GPL. For a list of your obligations and rights 
//	under this license please visit the GNU website at http://www.gnu.org/
//
// ***********************************************************************************************************

class pagination_manager{
	
	private $MOD_DATA = array();
	
	private $VERSION = 1; // version of class
	
	public function __construct()
	{
		$this->set_default_values();		
	}
	
	/**
	 * Функция устанавливает стандартные настройки 
	 * значения по умолчанию
	 *
	 */
	private function set_default_values()
	{
		$this->MOD_DATA['display_first'] = 1; // отображать ли ссылку на первую страницу 1-отображать 0-не отображать
		$this->MOD_DATA['display_last'] = 1; // отображать ли ссылку на последнюю страницу 1-отображать 0-не отображать
		
		$this->MOD_DATA['display_previous'] = 1;  // отображать ли ссылку на предыдущую страницу 1-отображать 0-не отображать
		$this->MOD_DATA['display_next'] = 1; // отображать ли ссылку на следующую страницу 1-отображать 0-не отображать
		
		$this->MOD_DATA['display_dots'] = 1; // отображать многоточие 1 - отображать 0 - не отображать
		
		$this->MOD_DATA['current_page_number'] = 1; // номер текущей страницы
		
		$this->MOD_DATA['total_records_num'] = 0; // всего строк в БД
		$this->MOD_DATA['total_page_num']  = 0; //всего страниц
		
		$this->MOD_DATA['records_on_page_limit'] = 10; // количество записей на странице
		$this->MOD_DATA['page_num_limit'] = 10; // количество отображаемых номеров страниц
		$this->MOD_DATA['right_page_num_limit'] = 5; // количество отображаемых номеров страниц справа от текущей
		$this->MOD_DATA['left_page_num_limit'] = 5; // количество отображаемых номеров страниц слева от текущей
		
		$this->MOD_DATA['full_data'] = array(); //Массив, содержащий все данные, из которых требуется сформировать страницу
		
		$this->MOD_DATA['pagination_info_existanse'] = 0; // флаг, говорящий о том что  $this->MOD_DATA['pagination_info'] не сгенерирован
		$this->MOD_DATA['pagination_info'] = array(); // результаты, содержащие меню навигации
	}
	
	
	
	public  function debug($inp = "#none")
	{
		echo "<pre>";
		if($inp == "#none") print_r($this->MOD_DATA);
		else print_r($inp);
		echo "</pre>";
	}
	
	/**
	 * Функция возвращает версию текущего касса
	 *
	 * @return string
	 */
	public function get_version()
	{
		return $this->VERSION;
	}
	
	/**
	 * Функция задаёт общее количество записей
	 *
	 * @param  integer $num
	 * @return boolean
	 */
	public function set_total_records($num=0)
	{
		if(!eregi("[0-9]+", $num))return false;
		if($num <= 0)return false;
		
		$this->MOD_DATA['total_records_num'] = $num;
		
		return true;
	}
	
	/**
	 * Функция задаёт количество записей на 1 странице
	 *
	 * @param integer $num
	 * @return boolean
	 */
	public function set_records_on_page_limit($num=0)
	{
		if(!eregi("[0-9]+", $num))return false;
		if($num <= 0)return false;
		
		$this->MOD_DATA['records_on_page_limit'] = $num;
		return true;
	}
	
	/**
	 * Задаёт количество номеров страниц, отображаемых справа от номера текущей страницы
	 *
	 * @param integer $num
	 * @return boolean
	 */
	public function set_right_page_num_limit($num=0)
	{
		if(!eregi("[0-9]+", $num))return false;
		if($num < 0)return false;
		
		$this->MOD_DATA['right_page_num_limit'] = $num;
		return true;
	}
	
	/**
	 * Задаёт количество номеров страниц, отображаемых слева от номера текущей страницы
	 *
	 * @param integer $num
	 * @return boolean
	 */
	public function set_left_page_num_limit($num=0)
	{
		if(!eregi("[0-9]+", $num))return false;
		if($num < 0)return false;
		
		$this->MOD_DATA['left_page_num_limit'] = $num;
		return true;
	}
	
	/**
	 * Функция задаёт номер текущей страницы
	 *
	 * @param integer $num
	 * @return boolean
	 */
	public function set_current_page($num = 0)
	{
		if(!eregi("[0-9]+", $num))return false;
		if($num < 0)return false;
		
		if($num == 0) $num =1;
		
		$this->MOD_DATA['current_page_number'] = $num;
		return true;
	}
	
	/**
	 * Функция устанавливает флаг отображения ссылки на первую страницу
	 *
	 * @return true
	 */
	public function display_first()
	{
		$this->MOD_DATA['display_first'] = 1;
		return true;
	}
	
	/**
	 * Функция устанавливает флаг отображения ссылки на последнюю страницу
	 *
	 * @return true
	 */
	public function display_last()
	{
		$this->MOD_DATA['display_last'] = 1; 
		return true;
	}
	
	/**
	 * Функция устанавливает флаг отображения ссылки на предыдущую страницу
	 *
	 * @return true
	 */
	public function display_previous()
	{
		$this->MOD_DATA['display_previous'] = 1;
		return true;
	}
	
	/**
	 * Функция устанавливает флаг отображения ссылки на следующую страницу
	 *
	 * @return true
	 */
	public function display_next()
	{
		$this->MOD_DATA['display_next'] = 1;
		return true;
	}
	
	/**
	 * Функция устанавливает флаг отображения многоточия
	 *
	 * @return boolean
	 */
	public function display_dots()
	{
		$this->MOD_DATA['display_dots'] = 1;
		return true;
	}
	
	/**
	 *  Функция снимает флаг отображения ссылки на первую страницу
	 *
	 * @return true
	 */
	public function hide_first()
	{
		$this->MOD_DATA['display_first'] = 0;
		return true;
	}
	
	/**
	 * Функция снимает флаг отображения ссылки на последнюю страницу
	 *
	 * @return true
	 */
	public function hide_last()
	{
		$this->MOD_DATA['display_last'] = 0; 
		return true;
	}
	
	/**
	 * Функция снимает флаг отображения ссылки на предыдущую страницу
	 *
	 * @return true
	 */
	public function hide_previous()
	{
		$this->MOD_DATA['display_previous'] = 0;
		return true;
	}
	
	/**
	 * Функция снимает флаг отображения ссылки на следующую страницу
	 *
	 * @return true
	 */
	public function hide_next()
	{
		$this->MOD_DATA['display_next'] =0;
		return true;
	}
	
	/**
	 * Функция снимает флаг отображения многоточия
	 *
	 * @return boolean
	 */
	public function hide_dots()
	{
		$this->MOD_DATA['display_dots'] = 0;
		return true;
	}
	
	/**
	 * Функция возвращает количество возможных страниц
	 *
	 * @return integer of FALSE
	 */
	public function get_number_of_pages()
	{
		$result = $this->MOD_DATA['total_records_num'] / $this->MOD_DATA['records_on_page_limit'];
		if(eregi("\.", $result) )$result = (integer)$result + 1;
		
		$this->MOD_DATA['total_page_num'] = $result;
		return $result;
	}
	
	/**
	 * Функция генерирует и возвращает информацию о сгенерированном меню
	 *
	 * @return unknown
	 */
	public function get_result()
	{
		if($this->MOD_DATA['total_records_num'] == 0)return false; // нет записей а значит ет страниц
		$this->get_number_of_pages();
		//if($this->MOD_DATA['current_page_number'] != 0) $this->MOD_DATA['page_num_limit'] = 11;
		
		$this->check_page_counting();
		
		$result =  array();
		
		if($this->MOD_DATA['total_page_num'] > $this->MOD_DATA['page_num_limit'])
		{
			
			
			$left_minus = $this->MOD_DATA['current_page_number'] - $this->MOD_DATA['left_page_num_limit']  ;
			//echo "<br>страниц слева ".$left_minus;
			
			if($left_minus <= 0)
			{
				$right_limit = $this->MOD_DATA['current_page_number']+$this->MOD_DATA['right_page_num_limit'] + abs($left_minus);
				$left_limit = 1;
				
				
			}
			
			$right_minus = $this->MOD_DATA['right_page_num_limit'] -  ($this->MOD_DATA['total_page_num'] - $this->MOD_DATA['current_page_number']);
			//echo "<br>страниц справа ".$right_minus;
			
			if($right_minus >=0)
			{
				$left_limit = $this->MOD_DATA['current_page_number'] - $this->MOD_DATA['left_page_num_limit'] - $right_minus +1;
				$right_limit = $this->MOD_DATA['total_page_num'];
				
			}
			
			if(($left_minus > 0) && ($right_minus < 0))
			{
				$left_limit = $this->MOD_DATA['current_page_number'] - $this->MOD_DATA['left_page_num_limit'];
				$right_limit = $this->MOD_DATA['current_page_number'] + $this->MOD_DATA['right_page_num_limit'] ;
				
			}
			
			$page_list = array();
			for($i = $left_limit; $i <= $right_limit; $i++)
			{
				$page_list[] = $i;
				
			}
			
			if($this->MOD_DATA['current_page_number']<=1)
			{
				$this->MOD_DATA['display_previous'] = 0;
				$this->MOD_DATA['display_first'] = 0;
				$next = $this->MOD_DATA['current_page_number'] + 1;
			}
			
			if($this->MOD_DATA['current_page_number']>=$this->MOD_DATA['total_page_num'])
			{
				$this->MOD_DATA['display_next'] = 0;
				$this->MOD_DATA['display_last'] = 0;
				$previous = $this->MOD_DATA['current_page_number'] - 1;
			}
			
			if(($this->MOD_DATA['current_page_number']>1)&&($this->MOD_DATA['current_page_number']<$this->MOD_DATA['total_page_num']))
			{
				$previous = $this->MOD_DATA['current_page_number'] - 1;
				$next = $this->MOD_DATA['current_page_number'] + 1;
			}
			
			
			$result['pg_list'] = $page_list;
			$result['current_pg'] = $this->MOD_DATA['current_page_number'];
			$result['total_pg_num'] = $this->MOD_DATA['total_page_num'];
			
			$result['limit']=$this->MOD_DATA['records_on_page_limit'];
			$result['offset']=$this->MOD_DATA['records_on_page_limit'] * $this->MOD_DATA['current_page_number'] -$this->MOD_DATA['records_on_page_limit'] ;
			
			if(($this->MOD_DATA['current_page_number'] - $this->MOD_DATA['left_page_num_limit'] -1) > 0)
				$result['show_left_dots'] = $this->MOD_DATA['display_dots'];
			
			if(($this->MOD_DATA['current_page_number'] + $this->MOD_DATA['left_page_num_limit']) <= $this->MOD_DATA['total_page_num'])
				$result['show_right_dots'] = $this->MOD_DATA['display_dots'];
								
			
			
			if($this->MOD_DATA['display_previous'])$result['previous'] = $previous;
			if($this->MOD_DATA['display_next'])$result['next'] = $next;
			
			if($this->MOD_DATA['display_first'])$result['first'] = 1;
			if($this->MOD_DATA['display_last'])$result['last'] = $this->MOD_DATA['total_page_num'];
			
			//$this->debug($result);
			
			$this->MOD_DATA['pagination_info'] = $result;
			$this->MOD_DATA['pagination_info_existanse'] = 1; // флаг выставлен, что говорит о ом что информасия сгенерирована
			
			
			
			//echo "<br>страниц справа ".$this->MOD_DATA['current_page_number'] - $this->MOD_DATA['left_page_num_limit'];
		}
		else 
		{
			$page_list = array();
			for($i = 1; $i <=  $this->MOD_DATA['total_page_num']; $i++)
			{
				$page_list[] = $i;
				
			}
			
			if($this->MOD_DATA['current_page_number']<=1)
			{
				$this->MOD_DATA['display_previous'] = 0;
				$this->MOD_DATA['display_first'] = 0;
				$next = $this->MOD_DATA['current_page_number'] + 1;
			}
			
			if($this->MOD_DATA['current_page_number']>=$this->MOD_DATA['total_page_num'])
			{
				$this->MOD_DATA['display_next'] = 0;
				$this->MOD_DATA['display_last'] = 0;
				$previous = $this->MOD_DATA['current_page_number'] - 1;
			}
			
			if(($this->MOD_DATA['current_page_number']>1)&&($this->MOD_DATA['current_page_number']<$this->MOD_DATA['total_page_num']))
			{
				$previous = $this->MOD_DATA['current_page_number'] - 1;
				$next = $this->MOD_DATA['current_page_number'] + 1;
			}
			
			$result['pg_list'] = $page_list;
			$result['current_pg'] = $this->MOD_DATA['current_page_number'];
			$result['total_pg_num'] = $this->MOD_DATA['total_page_num'];
			
			$result['limit']=$this->MOD_DATA['records_on_page_limit'];
			$result['offset']=$this->MOD_DATA['records_on_page_limit'] * $this->MOD_DATA['current_page_number'] -$this->MOD_DATA['records_on_page_limit'] ;
			
			if(($this->MOD_DATA['current_page_number'] - $this->MOD_DATA['left_page_num_limit'] -1) > 0)
				$result['show_left_dots'] = $this->MOD_DATA['display_dots'];
			
			if(($this->MOD_DATA['current_page_number'] + $this->MOD_DATA['left_page_num_limit']) <= $this->MOD_DATA['total_page_num'])
				$result['show_right_dots'] = $this->MOD_DATA['display_dots'];
								
			
			
			if($this->MOD_DATA['display_previous'])$result['previous'] = $previous;
			if($this->MOD_DATA['display_next'])$result['next'] = $next;
			
			if($this->MOD_DATA['display_first'])$result['first'] = 1;
			if($this->MOD_DATA['display_last'])$result['last'] = $this->MOD_DATA['total_page_num'];
			
			//$this->debug($result);
			
			$this->MOD_DATA['pagination_info'] = $result;
			$this->MOD_DATA['pagination_info_existanse'] = 1; // флаг выставлен, что говорит о ом что информасия сгенерирована
			
			
			
//			$result['pg_list'] = $page_list;
//			$result['current_pg'] = $this->MOD_DATA['current_page_number'];
//			$result['total_pg_num'] = $this->MOD_DATA['total_page_num'];
//			
//			$result['limit']=$this->MOD_DATA['records_on_page_limit'];
//			$result['offset']=$this->MOD_DATA['records_on_page_limit'] * $this->MOD_DATA['current_page_number'] -$this->MOD_DATA['records_on_page_limit'] ;
//			
//			$result['previous'] = $result['current_pg'] - 1;
//			if($result['previous'] <0 )$result['previous'] =0;
//			
//			$result['next'] = $result['current_pg'] + 1;
//			if($result['next']>$result['total_pg_num'])$result['next'] = $result['total_pg_num'];
//			
//			if($this->MOD_DATA['display_first'])$result['first'] = 1;
//			if($this->MOD_DATA['display_last'])$result['last'] = $this->MOD_DATA['total_page_num'];
//			
//			//$this->debug($result);
//			
//			$this->MOD_DATA['pagination_info'] = $result;
//			$this->MOD_DATA['pagination_info_existanse'] = 1; // флаг выставлен, что говорит о ом что информасия сгенерирована
			
		}
		return $result;
	}
	
	/**
	 * Функция возвращает сгенерированную информацию о меню
	 *
	 * @return unknown
	 */
	public function return_result()
	{
		if($this->MOD_DATA['pagination_info_existanse'] != 1) return false;
		
		return $this->MOD_DATA['pagination_info'];
	}
	
	/**
	 * Функция создаёт массив данных, которые требуется обработать и реобразовать в меню и страницу
	 *
	 * @param array $data
	 * @return boolean
	 */
	public function set_full_data($data = "")
	{
		if(!is_array($data))return false;
		if(count($data)==0)return false;
		
		$this->MOD_DATA['full_data'] = $data;
		return true;
	}
	
	/**
	 * Функция генерирует содержимое текущей страницы на базе всего контента
	 *
	 * @return array or FALSE
	 */
	public function get_generated_content()
	{
		$n  = count($this->MOD_DATA['full_data']);
		if($n == 0) return false;
		
		$pagination_info = $this->get_result();
		
		$offset = $this->MOD_DATA['current_page_number']* $pagination_info['limit'] - $pagination_info['limit'];
		
		$limit = $this->MOD_DATA['current_page_number'] * $pagination_info['limit'] ;
		
				
		$result = array();
		
		if($limit > $n) $limit = $n;
		
		for($i=$offset; $i<$limit; $i++)
		{
			$result[] = $this->MOD_DATA['full_data'][$i];
		}
		//$this->debug($result);
		return $result;
	}
	
	/**
	 * Метод пересчитывает количество отображаемых страниц в меню
	 * в случае, если заданные количества страниц справа и слева в
	 * сумме дают значение меньшее значения количества страниц 
	 * меню по умолчанию
	 *
	 */
	private function check_page_counting()
	{
		if ($this->MOD_DATA['page_num_limit'] > ($this->MOD_DATA['left_page_num_limit'] + $this->MOD_DATA['right_page_num_limit']))
		{
			$this->MOD_DATA['page_num_limit'] = $this->MOD_DATA['left_page_num_limit'] + $this->MOD_DATA['right_page_num_limit'];
		}
	}
	
}
?>