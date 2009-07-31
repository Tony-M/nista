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
*        library for working with user details                                 *
*******************************************************************************/

if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");

class user_class extends base_validation {
	
	private $DATA = array();
	private $SESSION_USER_VALID = "val_user";
				
	public function __construct()
	{
		$this->DATA = array();
		$this->DATA['password_lenght'] = 6; // длинна ппароля
		$this->DATA['18plus'] = 18;//возраст
	}
	
	public function debug($inp = "#none")
	{
		echo "<pre>";
		if($inp == "#none")print_r($this->DATA);
		else print_r($inp);
		echo "</pre>";
		
	}
	
	/**
	 * Метод задаёт логин пользователя
	 *
	 * @param string $login
	 * @return boolean
	 */
	public function set_login($login="")
	{
		$login = trim($login);
		$this->DATA['login'] = $login;
		
		return true;		
	}
	
	/**
	 * метод задаёт почту-логин пользователя
	 *
	 * @param string $email
	 * @return boolean
	 */
	public function set_email($email="")
	{
		if(!$this->validate_email($email)) return false;
		
		$query = "select LOWER(email) from ".$this->TBL_NISTA_USERS." where email='".strtolower($email)."'";
		
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			mysql_free_result($result_id);
			return false;
		}
		
		$this->DATA['email'] = $email;
		
		return true;
	}
	
	
	
	/**
	 * Метод задаёт пароль пользователя
	 *
	 * @param string $password
	 * @return boolean
	 */
	public function set_password($password = "")
	{
		$password = trim($password);
		if(strlen($password) < $this->DATA['password_lenght']) return false;
		
		$this->DATA['password_to_email'] = $password;
		
		$pass =  $this->make_password($password);
		if($pass != false) 
		{
			
			$this->DATA['password'] = $pass;
			return true;
		}
		return false;
	}
	
	/**
	 * Метод осуществляет проверку паролей на эквивалентность
	 *
	 * @param string $pas1
	 * @param string $pas2
	 * @return boolean
	 */
	public function compare_passwords($pas1="", $pas2="")
	{
		if($pas1 == $pas2) return  true;
		else return false;
	}
	
	/**
	 * Метод осуществляет проверку старого пароля с текущим при смене пароля или подтверждении важных операций
	 *
	 * @param string $oldpassword
	 * @return boolean
	 */
	public function check_old_password($oldpassword = "")
	{
		$oldpassword = trim($oldpassword);
		$pass = $this->make_password($oldpassword);
		
		if($pass != false)
		{
			if($pass == $this->DATA['passwd'])
				return true;
			else 
				return false;
		}
		
		return false;
	}
	
	/**
	 * Метод обновляет пароль пользователя на новое значение
	 *
	 * @return boolean
	 */
	public function update_password()
	{
		if($this->DATA['password'] != "")
		{
			$query = "update ".$this->TBL_NISTA_USERS." set passwd='".$this->DATA['password']."' where uid='".$this->DATA['uid']."' and status='activ'";
			if(mysql_query($query))
			{
				return true;
				//return $this->login();
			}
		}
		return false;
	}
	
	/**
	 * метод генерации пароля на базе заданного пользователем
	 *
	 * @param string $password
	 * @return String or False on fail
	 */
	private function make_password($password = "")
	{
		$password = trim($password);
		if(strlen($password) < $this->DATA['password_lenght'])return false;
		
		
		$password = substr(md5($password), 0, 40);
		
		return $password;
	}
	
	/**
	 * Метод задаёт имя пользователя
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function set_name($name = "")
	{
		$name = trim($name);
		
		if(!eregi("[а-яА-Яa-zA-Z\-]+", $name))return false;
		
		$this->DATA['name'] = htmlspecialchars($name);
		return true;
	}
	
	/**
	 * метод задаёт фамилию пользователя
	 *
	 * @param string  $surname
	 * @return boolean
	 */
	public function set_surname($surname = "")
	{
		$surname = trim($surname);
		
		if(!eregi("[а-яА-Яa-zA-Z\-]+", $surname))return false;
		
		$this->DATA['surname'] = htmlspecialchars($surname);
		return true;
	}
	
	/**
	 * Метод задаёт отчество пользоватея
	 *
	 * @param string $patronimyc
	 * @return boolean
	 */
	public function set_patronimyc($patronimyc = "")
	{
		$patronimyc = trim($patronimyc);
		
		if(!eregi("[а-яА-Яa-zA-Z\-]+", $patronimyc))return false;
		
		$this->DATA['patronimyc'] = htmlspecialchars($patronimyc);
		return true;
	}
	
	
	public function set_sex($sex = "")
	{
		$sex = strtolower(trim($sex));
		
		if(($sex!="m") && ($sex != "f"))return false;
		
		$this->DATA['sex'] = $sex;
		return true;
	}
	
	/**
	 * Метод задаёт день рождения пользователя
	 *
	 * @param int $day
	 * @return boolean
	 */
	public function set_day($day="none")
	{
		$day = trim($day);
		
		if(!eregi("[0-9]+", $day))return false;
		
		if($day > 31) return false;
		if($day < 1) return false;
		
		//if(strlen($day)==1)$day = "0".$day;
		
		$this->DATA['day'] = $day;
		
		return true;
	}
	
	/**
	 * Метод задаёт месяц рождения пользователя
	 *
	 * @param int $month
	 * @return boolean
	 */
	public function set_month($month="none")
	{
		$month = trim($month);
		
		if(!eregi("[0-9]+", $month))return false;
		
		if($month > 12) return false;
		if($month < 1) return false;
		
		//if(strlen($month)==1)$month = "0".$month;
		
		$this->DATA['month'] = $month;
		
		return true;
	}
	
	/**
	 * Метод задаёт год рождения пользователя
	 *
	 * @param integer $year
	 * @return boolean
	 */
	public function set_year($year="none")
	{
		$year = trim($year);
		
		if(!eregi("[0-9]+", $year))return false;
		
		$this->DATA['year'] = $year;
		return true;
	}
	
	/**
	 * Метод задаёт страну пользователя
	 *
	 * @param string $country
	 * @return boolean
	 */
	public function set_country($country = "")
	{
		$country = trim($country);
		if(!eregi("[0-9]+", $country))return false;
		
		if(!$this->validate_country_by_id($country))return false;
		$this->DATA['country'] = $country;
		return true;
	}
	
	
	/**
	 * Метод задаёт город пользователя
	 *
	 * @param string $city
	 * @return boolean
	 */
	public function set_city($city = "")
	{
		$city = trim($city);
		//echo $city."<br>";
		if(!eregi("[0-9а-яА-Яa-zA-Z\-]+", $city))return false;
//		echo $city."<br>";
		$this->DATA['city'] = $city;
		return true;
	}
	
	/**
	 * Метод возвращает список месяцев
	 *
	 * @return array
	 */
	public function get_month_range()
	{
		$result[0]['title'] = "Январь";
		$result[0]['value'] = "1";
		$result[1]['title'] = "Февраль";
		$result[1]['value'] = "2";
		$result[2]['title'] = "Март";
		$result[2]['value'] = "3";
		$result[3]['title'] = "Апрель";
		$result[3]['value'] = "4";
		$result[4]['title'] = "Май";
		$result[4]['value'] = "5";
		$result[5]['title'] = "Июнь";
		$result[5]['value'] = "6";
		$result[6]['title'] = "Июль";
		$result[6]['value'] = "7";
		$result[7]['title'] = "Август";
		$result[7]['value'] = "8";
		$result[8]['title'] = "Сентябрь";
		$result[8]['value'] = "9";
		$result[9]['title'] = "Октябрь";
		$result[9]['value'] = "10";
		$result[10]['title'] = "Ноябрь";
		$result[10]['value'] = "11";
		$result[11]['title'] = "Декабрь";
		$result[11]['value'] = "12";
		return $result;
	}
	
	/**
	 * Метод возвращает диапозон лет
	 *
	 * @return array
	 */
	public function get_year_range()
	{
		$start_year = date("Y") - $this->DATA['18plus'];
		$result = array();
		// годы
		for($i=0; $i<=100; $i++)
			$result[]=$start_year - $i;
			
		return $result;
	}
	
	/**
	 * Метод возвращает диапозон дней
	 *
	 * @return array
	 */
	public function get_day_range()
	{
		$result = array();
		for($i=1; $i<32; $i++)
			$result[]= $i;	
			
		return $result;
	}
	
	/**
	 * Метод возвращает диапозон стран
	 * 
	 * @return  array
	 */
	public function get_country_range()
	{
		$result = array();
		
		$query = "select * from ".$this->TBL_Z_COUNTRY." order by title asc";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$i=0;
			while($tmp = mysql_fetch_array($result_id,MYSQL_ASSOC))
			{
				$result[$i]['title'] = $tmp['title'];
				$result[$i]['kay'] = $tmp['cid'];
				$i++;
			}
		}
		else return false;
		
		
		return $result;
	}
	
	public function get_xml_city_range($country_id=1)
	{
		$country_id = trim($country_id);
		
		if(!eregi("[0-9]+", $country_id))return false;
		
		if($country_id == 0)return false;
		
		$query = "select * from ".$this->TBL_Z_CITY." where country_id='".$country_id."' order by title asc";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result = array();
			
			$i = 0;
			
			$xml = new XMLWriter();
			$xml->openMemory();
			
			$xml->startDocument('1.0', 'UTF-8');
			
    		$xml->endDtd();
			
    		$xml->startElement('items');
    		
    		
			while($tmp = mysql_fetch_array($result_id, MYSQL_ASSOC))
			{
				$xml->startElement('item');
				//$xml->writeElement ('title', $tmp['title']);
				$xml->writeAttribute( 'kay', $tmp['city_id']);
				$xml->writeAttribute( 'title', $tmp['title']);
				$xml->endElement(); 
				
				//$result[$i]['title'] = $tmp['title'];
				//$result[$i]['kay'] = $tmp['city_id'];
				
				$i++;
			}
			
			$xml->endElement(); 
   
   			//$xml->endDtd();
   			 
   			mysql_free_result($result_id);
			
   			return  $xml->outputMemory(true);
			
		}
		
		
//		$result = array();
//		$result[0]['title'] = "Москва";
//		$result[0]['kay'] = "1";
//		$result[1]['title'] = "Санкт Петербург";
//		$result[1]['kay'] = "2";
		return false;
	}
	
	public function get_city_range($country_id=0)
	{
		$country_id = trim($country_id);
		
		if(!eregi("[0-9]+", $country_id))return false;
		
		if($country_id == 0)return false;
		
		$query = "select * from ".$this->TBL_Z_CITY." where country_id='".$country_id."' order by title asc";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result = array();
			
			$i = 0;
			   		
			while($tmp = mysql_fetch_array($result_id, MYSQL_ASSOC))
			{
				$result[$i]['title'] = $tmp['title'];
				$result[$i]['kay'] = $tmp['city_id'];
				
				$i++;
			}
			   			 
   			mysql_free_result($result_id);
			
   			return  $result;
			
		}
		
		return false;
	}
	
	/**
	 * метод проверяет существует введённая дата или это вымысел
	 *
	 * @return boolean
	 */
	public function check_user_date()
	{
		if(!eregi("[0-9]+",$this->DATA['year']))return false; 
		if(!eregi("[0-9]+",$this->DATA['month']))return false;
		if(!eregi("[0-9]+",$this->DATA['day']))return false;
		
		$day_month[1] = 31;
		$day_month[2] = 28;
		$day_month[3] = 31;
		$day_month[4] = 30;
		$day_month[5] = 31;
		$day_month[6] = 30;
		$day_month[7] = 31;
		$day_month[8] = 31;
		$day_month[9] = 30;
		$day_month[10] = 31;
		$day_month[11] = 30;
		$day_month[12] = 31;
		
		if ($this->DATA['year']%4 == 0)
		{
			//высокосный год
			if($this->DATA['month'] != 2)
			{
				if(($this->DATA['day'] >= 0) && ($this->DATA['day'] <= $day_month[$this->DATA['month']]))
					return true; 
				else 
					return false;
			}
			else 
			{
				if(($this->DATA['day'] >= 0) && ($this->DATA['day'] <= 29))
					return true;
				else 
					return false;
			}
			
		}
		else 
		{
			if(($this->DATA['day'] >= 0) && ($this->DATA['day'] <= $day_month[$this->DATA['month']]))
				return true;
			else 
				return false;
		}
	}
	
	/**
	 * Метод фильтрует по возрастному цензу
	 * true -  человек прошёл тест
	 * false - возрастные ограничения
	 *
	 * @return boolean
	 */
	public function check_user_age()
	{
		if(!eregi("[0-9]+",$this->DATA['year']))return false;
		if(!eregi("[0-9]+",$this->DATA['month']))return false;
		if(!eregi("[0-9]+",$this->DATA['day']))return false;
		
		$dif = $this->DATA['18plus'] * 365 + 5;
		$dif = $dif * 24 * 3600; // разница в 18 лет в секундах
				
		$today = mktime(0,0,0,date('m'), date('d'), date("Y"));
		$user_birthdate = mktime(0,0,0,$this->DATA['month'], $this->DATA['day'], $this->DATA['year']);
		if($dif >($today - $user_birthdate)) 
			return  false; // "малолетка";
			
		return true;
		
		
	}
	
	/**
	 * Метод регистрирует нового пользователя в системе, создавая его ему новую учётную запись
	 * Возвращает False в случае неудачи
	 * String = user_id + activation_code
	 * @return String or false
	 */
	public function register_new_user()
	{
		$query_user = "insert into ".$this->TBL_NISTA_USERS." set ";
		
		if($this->DATA['email'] == "")
			return false;
		else 
			$query_user .= " email='".$this->DATA['email']."' ";
				
		if(strlen($this->DATA['password']) <= 25) // 25 т к я ваще хз но мд5 дает походу 32 знака
			return false;
		else 
			$query_user .= ", passwd='".$this->DATA['password']."'";
			
		
		if($this->DATA['name'] == "")
			return false;
		else 
			$query_user .= ", name='".$this->DATA['name']."' ";
			
		if($this->DATA['surname'] == "")
			return false;
		else 
			$query_user .= ", surname='".$this->DATA['surname']."' ";
			
		if($this->DATA['patronimyc'] == "")
			return false;
		else 
			$query_user .= ", patronimyc='".$this->DATA['patronimyc']."' ";
			
		if($this->DATA['sex'] == "")
			return false;
		else 
			$query_user .= ", sex='".$this->DATA['sex']."' ";
			
		
		
		if((strlen($this->DATA['year'])==4) && (strlen($this->DATA['month'])>=1) && (strlen($this->DATA['day'])>=1))	
		{
			$birthday = $this->DATA['year']."-".$this->DATA['month']."-".$this->DATA['day'];
			$query_user .= ", birthday='".$birthday."' ";			
		}
		else 
			return false;
			
		$query_user .= ", datecreated='".date("Y-m-d H:i:s")."' ";
		
		$query_user .= ", status='new' ";
		
		$activation = $this->get_activation_code();
		if(strlen($activation) >30)
		{
			$query_user .= ", activation='".$activation."'";
		}
		
		if((!eregi("[0-9]+", $this->DATA['country'])) || ($this->DATA['country'] == 0)) return false;
		$query_user .= ", country_id='".$this->DATA['country']."' ";
		
		$city_id = $this->get_city_id_or_create();
		if($city_id == false)
			return false;
		else 
		{
			$query_user .= ", city_id='".$city_id."'";
		}
		//echo $query_user;
		if(mysql_query($query_user))
		{
			$user_id = mysql_insert_id();
			return $user_id."_".$activation;
		}
		else 
			return false;	
	}
	
	/**
	 * Метод возвращает код используемый для активации записей
	 *
	 * @return string
	 */
	public function get_activation_code()
	{
		if(($this->DATA['email'] == "") || (strlen($this->DATA['password'])<=25) ) 	return false;
	
		$password_hash = crypt($this->DATA['password'], substr($this->DATA['password'], 7, 10));
		
		$email_hash = crypt($this->DATA['email'], substr($this->DATA['password'],3, 7));		
		$date_hash = crypt(date("Y-m-d H:i:s"), substr($this->DATA['password'], 5, 9));
		
		$link = md5($password_hash."_".$email_hash).md5($date_hash);
		
		return $link;
	}
	
	/**
	 * Метод имеет в качестве аргумента строко $this->DATA['city'] которая представляет
	 * собой либо id города, либо его название(title) (для нового города). Метод проверяет 
	 * есть ли город с таким id или title для указанной страны. Если города нет, то он создаётся.
	 * В итоге вовращается id в случае удачи или FALSE в случае если город с таким id не существует
	 * или не привязан к указанной стране, или неудаётся его создать. 
	 *
	 * @return integer or FALSE
	 */
	public function get_city_id_or_create()
	{
		$query = "select * from ".$this->TBL_Z_CITY." where country_id='".$this->DATA['country']."' and city_id='".$this->DATA['city']."'";
		
		if(eregi("[0-9]+",$this->DATA['city']))
		{
			if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
			{
				mysql_free_result($result_id);
				return $this->DATA['city'];
			}
			return false;
		}
		else 
		{
			$query = "select city_id from ".$this->TBL_Z_CITY." where country_id='".$this->DATA['country']."' and LOWER(title)='".strtolower($this->DATA['city'])."'";
			if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
			{
				$city_from_db = mysql_fetch_array($result_id, MYSQL_ASSOC);				
				mysql_free_result($result_id);

				$this->DATA['city'] = $city_from_db['city_id'];
				return $this->DATA['city'];
			}
			else 
			{
				$query = "insert into ".$this->TBL_Z_CITY." set country_id='".$this->DATA['country']."', title='".$this->DATA['city']."'";
				if(mysql_query($query))
				{
					$this->DATA['city'] = mysql_insert_id();
					return $this->DATA['city'];
				}
				return false;
			}			
		}		
	}
	
	/**
	 * Метод возвращает пароль пользователя для отправки в письме
	 *
	 * @return string
	 */
	public function get_password_to_email()
	{
		return $this->DATA['password_to_email'];
	}
	
	/**
	 * Метод возвращает логин пользователя для отправки в письме
	 *
	 * @return string
	 */
	public function get_login_to_email()
	{
		return $this->DATA['email'];
	}
	
	/**
	 * Метод задаёт активационный код, полученный пользователем в письме
	 *
	 * @param string $code
	 * @return boolean
	 */
	public function set_activation_code($code = "")
	{
		$code = trim($code);
		if($code == "")return false;
		if(!eregi("[0-9a-zA-Z_]+",$code))return false;
		
		$und_pos = strpos($code, "_");
		$len = strlen($code);
		
		$this->DATA['activation']['uid']= htmlspecialchars(trim(substr($code, 0,$und_pos)));
		$this->DATA['activation']['code']= htmlspecialchars(trim(substr($code, $und_pos - $len +1)));
		
		return true;
	}
	
	/**
	 * Метод возвращает идентификатор пользователя на базе активационного кода.
	 * Код можно задать напрямую или посредством метода set_activation_code
	 * 
	 * @param string $code
	 * @return Integer or FALSE
	 */
	public function get_user_id_by_activation_code($code="")
	{
		$code = trim($code);
		if($code != "")
		{
			if(!eregi("[0-9a-zA-Z_]+",$code))return false;
			
			$und_pos = strpos($code, "_");
			$len = strlen($code);
			
			$id = htmlspecialchars(trim(substr($code, 0,$und_pos)));
		}
		else 
			$id = $this->DATA['activation']['uid'];
			
		if(!eregi("[0-9]+", $id))
			return false;
		else
			return $id;
	}
	
	/**
	 * Метод активирует пользователя в системе
	 *
	 * @return boolean
	 */
	public function activate_user()
	{
		$query = "select * from ".$this->TBL_NISTA_USERS." where status='new' and activation='".$this->DATA['activation']['code']."' and uid='".$this->DATA['activation']['uid']."'";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
			mysql_free_result($result_id);
		else 
			return false;
		
		$query = "update ".$this->TBL_NISTA_USERS." set activation='', status='active' where  status='new' and activation='".$this->DATA['activation']['code']."' and uid='".$this->DATA['activation']['uid']."'";
		if(mysql_query($query))
			return $this->DATA['activation']['uid'];
		else return false;
	}
	
	/**
	 * Метод проверяет является ли данный пользователь вновьзарегистрированным/неактивированным
	 *
	 * @param integer $uid
	 * @return boolean
	 */
	public  function is_new_user($uid=0)
	{
		if((eregi("[0-9]+", $this->DATA['user'])) && ($this->DATA['user'] != ""))
			$user_id = $this->DATA['user'];
			
		if((eregi("[0-9]+", $uid)) && ($uid != "") && ($uid != 0))
			$user_id = $uid;
			
		if(!eregi("[0-9]+", $user_id))
			return false;
		
		$query = "select * from ".$this->TBL_NISTA_USERS." where uid='".$user_id."' and status='new'";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			mysql_free_result($result_id);
			return true;
		}
		else 
			return false;
	}
	
	/**
	 * Метод выдаёт данные пользователя по его ID
	 *
	 * @param integer $id
	 * @return array or False
	 */
	public function get_user_by_id($id = 0)
	{
		if($id == 0) return  false;
		if(!eregi("[0-9]+", $id)) return false;
		
		$query = "select * from ".$this->TBL_NISTA_USERS." where uid='".$id."'";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$user_data = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);
		}
		$this->DATA['user'] = $user_data;
		return $user_data;
	}
	
	/**
	 * Метод возвращает идентификатор пользователя uid
	 *
	 * @return string
	 */
	public function get_user_id()
	{
		return 	$this->DATA['user']['uid'];
	}
	
	/**
	 * Метод возвращает email пользователя
	 *
	 * @return string
	 */
	public function get_user_email()
	{
		return 	$this->DATA['user']['email'];
	}
	
	
	
	/**
	 * Метод осуществляет авторизацию пользователя в системе
	 *
	 * @return boolean
	 */
	public function login()
	{	
		if(($this->DATA['login'] == "") || ($this->DATA['password']==""))
			return false;
			
		$query = "select * from ".$this->TBL_NISTA_USERS." where LOWER(login)='".strtolower($this->DATA['login'])."' and passwd='".$this->DATA['password']."' ";
		$query .= " and back_status='activ'";
//		echo $query."<br>";
		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)==1))
		{
			$user = mysql_fetch_array($result_id, MYSQL_ASSOC);
			
			mysql_free_result($result_id);
			
			if(!session_id())session_start();
			
			$_SESSION['VALID_USER'] = $this->SESSION_USER_VALID;
			$_SESSION['UNAME'] = $user['login'];
			
			$LOGIN_DATE = date("Y-m-d H:i:s");
			
			$ip = $this->get_client_ip();			
			
			$_SESSION['CODE'] = $SECRET_DATA_TO_CHECK = md5($LOGIN_DATE.$user['passwd'].$ip);
			
			$query = "update ".$this->TBL_NISTA_USERS." set back_ip='".$ip."' , back_secret_code='".htmlspecialchars($_SESSION['CODE'])."', 	last_back_action_at='".$LOGIN_DATE."' , back_login_time='".$LOGIN_DATE."' where uid='".$user['uid']."'";
//			echo $query."<br>";
			if(mysql_query($query))
				return true;
			else 
			{
				$_SESSION = array();
				@session_destroy();
				return false;
			}						
		}
		else 
			return false;
	}
	
	/**
	 * Метод возвращает текущий ip-адрес клиента
	 *
	 * @return string
	 */
	public function get_client_ip()
	{
        /*if($ip_address=getenv("http_client_ip"));
       	elseif($ip_address=getenv("http_x_forwarded_for"));
       	else
       	{
        	$ip_address=getenv("remote_addr");
       	}
       	if($ip_address=="unknown")
       	{
        	$ip_address=getenv("remote_addr");
       	}*/
       	return getenv ("REMOTE_ADDR");
	}//end of function
	
	/**
	 * Метод отображает активность пользователя в системе
	 *
	 * @param integer $uid
	 * @return boolean
	 */
	private function show_my_online_presence($uid =0)
	{
			if((!eregi("[0-9]+", $uid)) || ($uid == 0))return false;
			
	        $my_ip = $this->get_client_ip();

	        $ACTIVITY_DATE = date("Y-m-d H:i:s");
	        
	        $query = "update ".$this->TBL_NISTA_USERS." set    	last_back_action_at='".$ACTIVITY_DATE."'  where uid='".$uid."'";
//			echo $query."<br>";
	        return mysql_query($query);
	}
	
	/**
	 * Метод осуществляет выход пользователя из системы - завершение сеанса
	 *
	 */
	public function logout()
 	{
        if(!session_id())session_start();
        $_SESSION = array();
          
        @session_destroy();
    }
    
    /**
     * Метод осущесвляет проверку авторизованости пользователя в системе.
     * Возвращает TRUE если пользователь успешно авторизован
     * False - если пользователь не авторизован
     *
     * @return bolean
     */
    public function check_valid_user()
    {
    	if (isset($_SESSION['VALID_USER']) && ($_SESSION['VALID_USER'] != "") && ($_SESSION['VALID_USER'] == $this->SESSION_USER_VALID))
      	{
      		$ip = $this->get_client_ip();
      		
      		$query = "select * from ".$this->TBL_NISTA_USERS." where back_secret_code='".htmlspecialchars($_SESSION['CODE'])."' and login='".htmlspecialchars($_SESSION['UNAME'])."' ";
      		$query .= " and back_status='activ'";
//	      	echo $query."<br>";
      		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)==1))
      		{
      			$user = mysql_fetch_array($result_id, MYSQL_ASSOC);
      			
      			mysql_free_result($result_id);
      			
      			$this->show_my_online_presence($user['uid']);
      			
      			foreach ($user as $key => $value)
      				$this->DATA[$key] = $value;
      			
      			return $user;
      		}
      		else return false;
      	}
      	else return false;
    }
    
    /**
     * Метод возвращает данные пользователя для размещения их на сайте
     *
     * @param array $my_data
     * @return array
     */
    public function get_my_public_data($my_data = '')
    {
    	if($my_data == '')return false;
    	if(!is_array($my_data))return false;
    	
    	$result = array();
    	
    	$result = $my_data;
    	
    	if(trim($result['main_photo'])=="none")
		{
			if($my_data['sex']=="m")
			{
				$result['main_photo']=$SYS['HTTP_HOST']."/account/get_photo.php?photo=man_no_photo"; 
				$result['main_photo_sm']=$SYS['HTTP_HOST']."/account/get_photo.php?photo=man_no_photo_sm"; 
			}
			else
			{
				$result['main_photo']=$SYS['HTTP_HOST']."/account/get_photo.php?photo=woman_no_photo";  
				$result['main_photo_sm']=$SYS['HTTP_HOST']."/account/get_photo.php?photo=woman_no_photo_sm";  
			}
			$result['main_photo_w'] = 320;
			$result['main_photo_h'] = 320;
			$result['main_photo_sm_w'] = 128;
			$result['main_photo_sm_h'] = 128;
		}
		else 
		{
			$root_way = str_repeat ("../", substr_count($_SERVER['PHP_SELF'], "/")-1);
			if(file_exists($root_way."photos/".$result['main_photo'].".jpg"))
			{ 
				$size = getimagesize($root_way."photos/".$result['main_photo'].".jpg"); 
				$size_sm = getimagesize($root_way."photos/".substr($result['main_photo'],0, strlen($result['main_photo'])-4)."sm.jpg"); 
				
				$result['main_photo_sm']=$SYS['HTTP_HOST']."/account/get_photo.php?photo=".substr($result['main_photo'],0, strlen($result['main_photo'])-4)."sm"; 
				$result['main_photo']=$SYS['HTTP_HOST']."/account/get_photo.php?photo=".$result['main_photo']; 
				$result['main_photo_w'] = $size[0];
				$result['main_photo_h'] = $size[1];
				
				
				
				
				$result['main_photo_sm_w'] = $size_sm[0];
				$result['main_photo_sm_h'] = $size_sm[1];
			}
			else 
			{
				if($my_data['sex']=="m")
				{
					$result['main_photo']=$SYS['HTTP_HOST']."/account/get_photo.php?photo=man_no_photo"; 
					$result['main_photo_sm']=$SYS['HTTP_HOST']."/account/get_photo.php?photo=man_no_photo_sm"; 
				}
				else
				{
					$result['main_photo']=$SYS['HTTP_HOST']."/account/get_photo.php?photo=woman_no_photo"; 
					$result['main_photo_sm']=$SYS['HTTP_HOST']."/account/get_photo.php?photo=woman_no_photosm"; 
				}
				$result['main_photo_w'] = 320;
				$result['main_photo_h'] = 320;
				$result['main_photo_sm_w'] = 128;
				$result['main_photo_sm_h'] = 128;
			}
		}
		
		// **** Вычисляем возраст *****
		$b_year = substr($result['birthday'],0, 4);
		$b_month = substr($result['birthday'], 8,2);
    	
		$b_date = mktime(0,0,0,substr($result['birthday'], 5,2), substr($result['birthday'], 8,2), substr($result['birthday'], 0,4));
    	$to_date = mktime(0,0,0, date("m") , date("j"), date("Y"));
    	$b_diff = ($to_date - $b_date) / 31536000; 
    	$dot_position = strpos($b_diff, ".");
    	if($dot_position)
    	{
    		$b_diff = substr($b_diff, 0, $dot_position);
    	}
    	
    	$result['age'] = $b_diff;
    	// -----------------------------
    	 
    	$query = "select tb1.title as city_title, tb2.title as county_title from ".$this->TBL_Z_CITY." as tb1, ".$this->TBL_Z_COUNTRY." as tb2 where tb1.city_id='".$result['city_id']."' and tb2.cid='".$result['country_id']."'";
    	//echo $query."<br>";
    	if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)==1))
    	{
    		$tmp = mysql_fetch_array($result_id, MYSQL_ASSOC);
    		mysql_free_result($result_id);
    		$result['city_title'] = TRIM($tmp['city_title']);
    		$result['county_title'] = trim($tmp['county_title']);
    	}
    	
    	
    	
    	
    	return $result;
    }
    
    public function update_my_personal_data()
    {
    	$query_user = "update ".$this->TBL_NISTA_USERS." set ";
    	
    	if($this->DATA['name'] == "")
			return false;
		else 
			$query_user .= " name='".$this->DATA['name']."' ";
			
		if($this->DATA['surname'] == "")
			return false;
		else 
			$query_user .= ", surname='".$this->DATA['surname']."' ";
			
		if($this->DATA['patronimyc'] == "")
			return false;
		else 
			$query_user .= ", patronimyc='".$this->DATA['patronimyc']."' ";
			
		if($this->DATA['sex'] == "")
			return false;
		else 
			$query_user .= ", sex='".$this->DATA['sex']."' ";
			
		
		
		if((strlen($this->DATA['year'])==4) && (strlen($this->DATA['month'])>=1) && (strlen($this->DATA['day'])>=1))	
		{
			$birthday = $this->DATA['year']."-".$this->DATA['month']."-".$this->DATA['day'];
			$query_user .= ", birthday='".$birthday."' ";			
		}
		else 
			return false;
			
		if((!eregi("[0-9]+", $this->DATA['country'])) || ($this->DATA['country'] == 0)) return false;
		$query_user .= ", country_id='".$this->DATA['country']."' ";
		
		$city_id = $this->get_city_id_or_create();
		if($city_id == false)
			return false;
		else 
		{
			$query_user .= ", city_id='".$city_id."'";
		}
		
		$query_user .= " where uid='".$this->DATA['uid']."' and status='activ'";
		//echo $query_user;
		return mysql_query($query_user);
    }
    
    /**
     * Метод проверяет существует ли такой город в такой стране
     *
     * @param integer $city_id
     * @param integer $country_id
     * @return boolean
     */
    public function check_city_country($city_id = 0, $country_id = 0)
    {
    	$city_id = trim($city_id);
    	$country_id = trim($country_id);
    	
    	if(!eregi("[0-9]+", $city_id))return false;
    	if(!eregi("[0-9]+", $country_id))return false;
    	if($city_id == 0) return false;
    	if($country_id == 0)return false;
    	
    	$query = "select * from ".$this->TBL_Z_CITY." where city_id='".$city_id."' and country_id='".$country_id."'";
    	if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)==1))
    	{
    		mysql_free_result($result_id);
    		return true;
    	}
    	else 
    		return false;
    }
    
    
}
?>