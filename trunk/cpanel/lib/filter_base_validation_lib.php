<?php
/*******************************************************************************
*                                 Start script                                 *
********************************************************************************
*     Developed by Tony-M Studio (c)                                           *
*     Made by Morozov Anton Andreevich  (c)                                    *
*     Email: morozov_aa@tonymstudio.ru                                         *
*     on 3.02.2009 at 20:25                                                    *
*     Test: working propertly                                                  *
*     Description:                                                             *
*        base validation library                                               *
*******************************************************************************/

if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");

class base_validation{
	
	protected  $VALIDATION = array();
	
	protected  $TBL_NISTA_USERS = "tbl_nista_users";
	
	
	public function __construct()
	{
		$this->VALIDATION = array();
		
	}
	
	public function validate($inp = "")
	{
		return $inp;
	}
	
	/**
	 * Метод валидации почтового адреса
	 *
	 * @param string $email
	 * @return boolean
	 */
	public function validate_email($email = "") 
	{
  		$email = trim($email);
  		if($email == "") return false;
  		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) 
  		{
    		return  FALSE;
  		}
  		return true;
	}
	
	
	
	
	public function make_validate_text($text = "")
	{
		$text = trim($text);
		
		$text = htmlspecialchars($text);
		
		return $text;
	}
	
	/**
	 * Метод проверяет коректность id параметра. id > 0
	 *
	 * @param integer $id
	 * @return boolean
	 */
	public function validate_id($id=0)
	{
		$id = (int)trim($id);
		if($id == "") return false;
		if($id == 0)return false;
		if(!eregi("[0-9]+", $id))return false;
		return true;
	}

	/**
	 * Метод осуществляет проверку переменной на пустые значения
	 *
	 * @param mixed $val
	 * @return boolean
	 */
	public function is_empty($val = '')
	{
		$val = trim($val);
		return empty($val);
	}
	
	/**
	 * Метод проверяет состоит ли перименная только из букв латинского алфавита и _ или нет
	 *
	 * @param string $variable
	 * @return boolean
	 */
	public function is_valid_english_name($variable="")
	{
		if(!eregi("[a-zA-Z_]+", $variable))return false;
		else return true;
	}
}

?>