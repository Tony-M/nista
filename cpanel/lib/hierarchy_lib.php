<?php
if(!defined('IN_NISTA')) header("Location: http://".$_SERVER['SERVER_NAME']."");
class hierarchy_manager{
    // Данные в своей иерархии могут представлять собой основные типы информации:
    // данные - data
    // структура данных  - structure
	private $TYPE = array ("data"=>"data",
						   "structure"=>"structure");

   	protected  $STATUS = array ("on"=>1,
   								"wait"=>2,
   								"off"=>3,
   								"*"=>4,
   								"del"=>5);
	public $TBL_NISTA_OBJECT_HIERARCHY = "tbl_nista_object_hierarchy";

	public function __construct($name = "nista2_hierarchy_object")
	{		$this->name = $name;

	}

	public final function set_new_element($object_id, $mod_id, $type="", $owner_id="self", $status="off") // создание нового элемента иерархии
	{		
		Global $TBL_NISTA_OBJECT_HIERARCHY;
        //echo  $mod_id;
        if(!array_key_exists($status, $this->STATUS) )return false;
		//if(($status!="off") && ($status!="on") && ($status!="wait"))return false;
       	if($owner_id == "0") return false;
		if(!ereg("[0-9]", $object_id))return false;
		if(!ereg("[0-9]", $mod_id))return false;     //echo "dtyt";

        $new_sequense_value = $this->get_sequence_for_new_level();

	    $query = "insert into ".$TBL_NISTA_OBJECT_HIERARCHY." set object_id='".$object_id."', mod_id='".$mod_id."', type='".$type."', sequence='".$new_sequense_value."' , status='".$status."'";
	    if($owner_id!="self")$query.=" , owner_id='".$owner_id."'";
		//echo $query;

        $result_id= mysql_query($query);
        $last_id = mysql_insert_id();

		if($result_id && ($owner_id=="self"))
		{
			$query = "update ".$TBL_NISTA_OBJECT_HIERARCHY." set  owner_id='".$last_id."' where level_id='".$last_id."'";
			$result_id = mysql_query($query);
			return $last_id;
		}
		else
		{			
			if($result_id) return $last_id;
			else return false;
		}


	}

	public final function set_element($level_id, $owner_id="self", $mod_id, $type="",  $status="off") // изменение информации элемента иерархии
	{		Global $TBL_NISTA_OBJECT_HIERARCHY;

         // echo "ow=".$level_id."<br>";
		if(!array_key_exists($status, $this->STATUS) )return false;
		if(!ereg("[0-9]", trim($level_id) ) )return false;          //echo "tyt";

		//if($owner_id == 0) return false;
		if(!ereg("[0-9]", trim($mod_id)))return false;
		if(!ereg("[0-9a-zA-Z_]", trim($type)))return false;

		$query = "update ".$TBL_NISTA_OBJECT_HIERARCHY." set ";
		if($type!="")$query.= " type='".$type."' ";
		$query.= ", status ='".$status."' ";
		if(ereg("[0-9]", $owner_id))$query.= ", owner_id ='".$owner_id."' ";
        $query.= " where level_id='".$level_id."'";
        //echo $query."<br>";
        $result_id = mysql_query($query);
        if($owner_id=="self")
		{

			$query = "update ".$TBL_NISTA_OBJECT_HIERARCHY." set  owner_id='".$level_id."' where level_id='".$level_id."'";
			$result_id = mysql_query($query);
			//echo $query;
			return true;
		}

	}

	public final function set_link($level_id="none", $owner_id="none", $mod_id, $status="off", $type="#link")
	{		Global $TBL_NISTA_OBJECT_HIERARCHY;

		if(!ereg("[0-9]", trim($level_id)))return false;
		if(!ereg("[0-9]", trim($owner_id)))return false;
        		if(!ereg("[0-9]", $mod_id))return false;
        		if(!array_key_exists($status, $this->STATUS) )return false;

		$new_sequense_value = $this->get_sequence_for_new_level();

  		$query = "insert into ".$TBL_NISTA_OBJECT_HIERARCHY." set object_id='".$level_id."',  owner_id='".$owner_id."' , type='".$type."', sequence='".$new_sequense_value."' , status='".$status."', mod_id='".$mod_id."'";        //echo $query;
        		if(mysql_query($query))return true;
        		else return false;
	}
	
	public final  function update_owner_of_level($level_id="none", $owner_id="none")
	{
		Global $TBL_NISTA_OBJECT_HIERARCHY;
		
		if(!eregi("[0-9]", $level_id))return false;
		if(eregi("[0-9]", $owner_id))
		{		
			$query = "update ".$TBL_NISTA_OBJECT_HIERARCHY." set owner_id='".$owner_id."' where level_id='".$level_id."'";
			mysql_query($query);
		}
		elseif ($owner_id == "none")
		{
			$query = "delete from ".$TBL_NISTA_OBJECT_HIERARCHY." where level_id='".$level_id."'";
			return mysql_query($query);
		}
		return false;
		
	}
	
	

	public final function set_level_status ($level_id=0, $status="off")
	{		Global $TBL_NISTA_OBJECT_HIERARCHY;
		if(!ereg("[0-9]", trim($level_id)))return false;
		if(!array_key_exists($status, $this->STATUS) )return false;

		$query = "update ".$TBL_NISTA_OBJECT_HIERARCHY." set status='".$status."' where level_id='".$level_id."'";
		return mysql_query($query);	}


	public final function set_sequence_for_level($level_id="none", $direction = "none")
	{		Global $TBL_NISTA_OBJECT_HIERARCHY;

		$direction = trim(strtolower($direction));

		if(!ereg("[0-9]", trim($level_id)))return false;

		if(($direction == "up")||($direction == "down"))
		{
			if($direction == "up")
			{				$direction="<";
				$order= "desc";
			}
			if($direction == "down")
			{				$direction=">";
				$order = "asc";
			}
			$query = "select * from ".$TBL_NISTA_OBJECT_HIERARCHY." where level_id='".$level_id."'";
			//echo $query."<br>";
   			if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
   			{   				$current_level = mysql_fetch_array($result_id, MYSQL_ASSOC);
   				mysql_free_result($result_id);

   				//поскольку возможен случай смены последовательности у записей нулевого и вложенных уровней то получаем :
                if($current_level['level_id'] != $current_level['owner_id'])
                {
	   				$query = "select * from ".$TBL_NISTA_OBJECT_HIERARCHY." where owner_id='".$current_level['owner_id']."' and sequence".$direction."'".$current_level['sequence']."' order by sequence ".$order." limit 1";
	   				//echo $query."<br>";
	   				if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
	   				{	   					$next_level =  mysql_fetch_array($result_id, MYSQL_ASSOC);
	   					mysql_free_result($result_id);
						$tmp = $next_level['sequence'];
						$next_level['sequence'] = $current_level['sequence'];
						$current_level['sequence'] = $tmp;

						$query = "update ".$TBL_NISTA_OBJECT_HIERARCHY." set sequence='".$current_level['sequence']."' where level_id='".$current_level['level_id']."'";
						//echo $query."<br>";
						if(!mysql_query($query)) return false;

						$query = "update ".$TBL_NISTA_OBJECT_HIERARCHY." set sequence='".$next_level['sequence']."' where level_id='".$next_level['level_id']."'";
						//echo $query."<br>";
						if(!mysql_query($query)) return false;
	   				}
	   				else
	   					return false;
	   			}
	   			else
	   			{        			$query = "select * from ".$TBL_NISTA_OBJECT_HIERARCHY." where level_id=owner_id and mod_id='".$current_level['mod_id']."' and type='".$current_level['type']."' and sequence".$direction."'".$current_level['sequence']."' order by sequence ".$order." limit 1";
	   				//echo $query."<br>";
	   				if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
	   				{
	   					$next_level =  mysql_fetch_array($result_id, MYSQL_ASSOC);
	   					mysql_free_result($result_id);

						$tmp = $next_level['sequence'];
						$next_level['sequence'] = $current_level['sequence'];
						$current_level['sequence'] = $tmp;

						$query = "update ".$TBL_NISTA_OBJECT_HIERARCHY." set sequence='".$current_level['sequence']."' where level_id='".$current_level['level_id']."'";
						//echo $query."<br>";
						if(!mysql_query($query)) return false;

						$query = "update ".$TBL_NISTA_OBJECT_HIERARCHY." set sequence='".$next_level['sequence']."' where level_id='".$next_level['level_id']."'";
						//echo $query."<br>";
						if(!mysql_query($query)) return false;
	   				}
	   				else
	   					return false;
	   			}
   			}
   			else
   				return false;
		}

	}

	public final function rm_level($level_id=0)
	{		Global $TBL_NISTA_OBJECT_HIERARCHY;
		if(!ereg("[0-9]", $level_id))return false;

		$query = "delete from ".$TBL_NISTA_OBJECT_HIERARCHY." where level_id='".$level_id."'";  // !!!!!!!!   нужно сделать проверку привязанных записей к данной и перелинковку....
		//echo $query."<br>";
		return mysql_query($query);	
	}

	public final function get_full_tree_for($level_id="*", $mod_id="0", $type="", $status="on", $tab="0")
	{  		Global $TBL_NISTA_OBJECT_HIERARCHY;
  		$result_array = Array();
        //echo $mod_id;

  		if(!array_key_exists(trim($status), $this->STATUS) )return false;
  		if(!ereg("[0-9]", trim($mod_id)))return false;
  		if(!ereg("[0-9a-zA-Z_]", trim($type)))return false;
    	if( (!ereg("[0-9]", trim($level_id))) && ($level_id!="*") )return false;

        if($level_id=="*")$query = "select * from ".$TBL_NISTA_OBJECT_HIERARCHY." where level_id=owner_id and mod_id='".$mod_id."' and type='".$type."'";
     	else $query = "select * from ".$TBL_NISTA_OBJECT_HIERARCHY." where level_id='".$level_id."' and mod_id='".$mod_id."' and type='".$type."'";

     	if($status!="*") $query.= " and status='".$status."'";
        $query.= " order by sequence asc";
     	//echo $query."<br>";
     	if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
     	{     		while($tmp_data=mysql_fetch_array($result_id, MYSQL_ASSOC))
     		{
        		$result_array[] = array_merge($tmp_data, array('tab' => $tab));

				$next_level_result = $this->get_tree_for($tmp_data['level_id'], $mod_id, $type, $status, $tab="0");
				//$result_array = $result_array + $next_level_result;
				if(is_array($next_level_result))
				{					$result_array = array_merge($result_array, $next_level_result);
				}       		}
     	}
        //echo "<pre>";
       		//print_r($result_array);
       		//echo "</pre><br><br>";


		//return $result_array;
        //$result_array = array(array("a"=>"i", "b"=>"wanna"),array("aa"=>"be", "bb"=>"a"),array("aaa"=>"gabber", "bbb"=>"baby"));
		return $result_array;
	}

	public final function get_tree_for($level_id="*", $mod_id="0", $type="", $status="on", $tab="0")
	{		Global $TBL_NISTA_OBJECT_HIERARCHY;

		if(!array_key_exists(trim($status), $this->STATUS) )return false;
  		if(!ereg("[0-9]", trim($mod_id)))return false;
  		if(!ereg("[0-9a-zA-Z_]", trim($type)))return false;
    	if( (!ereg("[0-9]", trim($level_id))) && ($level_id=="*") )return false;

		$query = "select * from ".$TBL_NISTA_OBJECT_HIERARCHY." where level_id!=owner_id and owner_id='".$level_id."' and mod_id='".$mod_id."' and type='".$type."'";
		if($status!="*") $query.= " and status='".$status."'";
		$query.= " order by sequence asc";
        //echo $query."<br>";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$tab++;
			while($tmp_data=mysql_fetch_array($result_id, MYSQL_ASSOC))
     		{
        		$result_array[] = array_merge($tmp_data, array('tab' => $tab));

				$next_level_result = $this->get_tree_for($tmp_data['level_id'], $mod_id, $type, $status, $tab);
				if(is_array($next_level_result))$result_array = array_merge($result_array, $next_level_result);
				//$result_array = $result_array + $next_level_result;
       		}
            //print_r($result_array);
       		return $result_array;
    	}
	}

	public final function get_level_info_for_object($object_id = "none", $type="menu" , $owner_id="self")        //  надо переписать более умно
	{		Global $TBL_NISTA_OBJECT_HIERARCHY;

		$owner_id = trim($owner_id);
		if( (!ereg("[0-9]", $owner_id)) && ($owner_id != "self") )return false;
		if(!ereg("[0-9]", $object_id))  return false;

		if($owner_id == "self")$owner = "level_id = owner_id";
		else $owner = "owner_id ='".$owner_id."'";
		$query = "select * from ".$TBL_NISTA_OBJECT_HIERARCHY." where object_id='".$object_id."' and type='".$type."' and ".$owner;
        		//echo $query."<br>";
		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{			$result=array();
			while($tmp_data =mysql_fetch_array($result_id, MYSQL_ASSOC))
				$result = $tmp_data; // было $result[] = $tmp_data;

			mysql_free_result($result_id);
			return $result;
		}
		else
			return false;
	}

	public final function get_max_level_sequence()
	{
		Global $TBL_NISTA_OBJECT_HIERARCHY;

		$query = "select max(sequence) from ".$TBL_NISTA_OBJECT_HIERARCHY;
  		//echo $query;
  		if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{			$seq = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);

			return $seq['max(sequence)'];
		}
		else
			return false;
	}

    public final function get_sequence_for_new_level()
    {    	$seq = $this->get_max_level_sequence();
    	if($seq)
    	{    		$seq++;
    		return $seq;
    	}
    	else
    		return false;
    }

    public final function get_info_for_level($level_id=0)
    {    	Global $TBL_NISTA_OBJECT_HIERARCHY;

    	if(!ereg("[0-9]", trim($level_id))  )return false;

    	$query = "select * from ".$TBL_NISTA_OBJECT_HIERARCHY." where level_id='".$level_id."'";
    	//echo $query."<br>";
    	if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result = mysql_fetch_array($result_id, MYSQL_ASSOC);
			mysql_free_result($result_id);

			return $result;
		}
		else
			return false;    }

    public final function get_owners_for_level($level_id=0, $mod_id="*", $type="*" )
    {    	Global $TBL_NISTA_OBJECT_HIERARCHY;

    	if(!ereg("[0-9]", trim($level_id))  )return false;
    	if( (!ereg("[0-9]",  $mod_id)) && ( $mod_id != "*") )return false;

    	$query = "select * from ".$TBL_NISTA_OBJECT_HIERARCHY." where object_id='".$level_id."'";
    	if($mod_id != "*")$query .= " and mod_id='".$mod_id."'";
    	if($type != "*")$query .= " and type='".$type."'";
        	$query .= " order by sequence asc";
        	//echo $query."<br>";
     	if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result= Array();
			while($tmp  = mysql_fetch_array($result_id, MYSQL_ASSOC))
				$result[] = $tmp ;

			mysql_free_result($result_id);

			return $result;
		}
		else
			return false;
    }
    
    public function get_children_by_owner_id($level_id=0, $mod_id='*', $type="*")
    {
    	if(!ereg("[0-9]", trim($level_id))  )return false;
    	if( (!ereg("[0-9]",  $mod_id)) && ( $mod_id != "*") )return false;
    	
    	$query = "select * from ".$this->TBL_NISTA_OBJECT_HIERARCHY." where owner_id='".$level_id."'";
    	if($mod_id != "*")$query .= " and mod_id='".$mod_id."'";
    	if($type != "*")$query .= " and type='".$type."'";
        $query .= " order by sequence asc";
        //echo $query."<br>";
     	if(($result_id = mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			$result= Array();
			while($tmp  = mysql_fetch_array($result_id, MYSQL_ASSOC))
			{	
				if($tmp['type']!='#link')
					$result[] = $tmp ;
				else 
				{
					$query = "select * from ".$this->TBL_NISTA_OBJECT_HIERARCHY." where level_id='".$tmp['object_id']."'";
					if($mod_id != "*")$query .= " and mod_id='".$mod_id."'";
					//echo $query."<br>";
					if(($result_idd=mysql_query($query)) && (mysql_num_rows($result_idd)>0))
					{
						$tmpp = mysql_fetch_array($result_idd, MYSQL_ASSOC);
						$result[] = $tmpp;
						mysql_free_result($result_idd);
					}
				}
			}

			mysql_free_result($result_id);

			return $result;
		}
		else
			return false;
    }

	public function get_free_obj_list($mod_id=0, $type='*', $status='*')
	{
		if( (!ereg("[0-9]",  $mod_id)) && ( $mod_id != "*") )return false;
		
		$query = "select * from ".$this->TBL_NISTA_OBJECT_HIERARCHY." where mod_id='".$mod_id."' and level_id=owner_id";
		if($type != '*')$query .= " and type='".$type."'";
		if($status!= '*')$query .= " and status='".$status."'";
		$query .= "and level_id not in (select object_id from ".$this->TBL_NISTA_OBJECT_HIERARCHY." where mod_id='".$mod_id."' and type='#link')";
		
		$result = array();
		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			while($tmp  = mysql_fetch_array($result_id, MYSQL_ASSOC))
				$result[]=$tmp;
			
			mysql_free_result(($result_id));
			return  $result;
			
		}
	}
	
	public  function get_self_obj_list($mod_id=0, $type='*', $status='*')
	{
		//возвращает список исходных объектов
		if( (!ereg("[0-9]",  $mod_id)) && ( $mod_id != "*") )return false;
		$query = "select * from ".$this->TBL_NISTA_OBJECT_HIERARCHY." where mod_id='".$mod_id."' and level_id=owner_id";
		if($type != '*')$query .= " and type='".$type."'";
		if($status!= '*')$query .= " and status='".$status."'";
		$result = array();
		
		if(($result_id=mysql_query($query)) && (mysql_num_rows($result_id)>0))
		{
			while($tmp  = mysql_fetch_array($result_id, MYSQL_ASSOC))
				$result[]=$tmp;
			
			mysql_free_result(($result_id));
			return  $result;
			
		}
	}
	/**
	 * Функция удаляет для данной level_id все её ссылки на другие объекты
	 *
	 * @param integer $level_id
	 * @return boolean
	 */
	public final function rm_all_my_links_by_my_level($level_id = 0)
	{
		if(!eregi("[0-9]+",$level_id))return false;
		if ($level_id == 0)return false;
		
		$query = "delete from ".$this->TBL_NISTA_OBJECT_HIERARCHY." where type='#link' and object_id='".$level_id."'" ;
		//echo  $query."<br>";
		
		return mysql_query($query);
	}
	
	/**
	 * Функция перемещает в корзину все связи от объектов ссылающихся на текущую запись
	 *
	 * @param integer $level_id
	 * @return boolean
	 */
	public final function delete_links_on_me_by_my_level_id($level_id = 0)
	{
		if(!eregi("[0-9]+",$level_id))return false;
		if ($level_id == 0)return false;
		
		$query = "update ".$this->TBL_NISTA_OBJECT_HIERARCHY." set status='del' where  type='#link' and owner_id='".$level_id."'" ;
		//echo  $query."<br>";
		return mysql_query($query);
	}


}//end of class

?>