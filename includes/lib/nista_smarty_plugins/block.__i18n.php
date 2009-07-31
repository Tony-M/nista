<?php  
/** 
* Smarty plugin 
* @package Smarty 
* @subpackage plugins 
*/  
   
/** 
* Smarty {__i18n} plugin 
* 
* Type:     function 
* Name:     hello_world 
* Purpose:  outputs "Hello, world!" 
* @author Novice <admin at i-novice dot net> 
* @param array 
* @param Smarty 
* @return string 
*/  
function smarty_block___i18n($params, $content, &$smarty) 
{  
	$result ="";
	if ($content) {
        global $I18N;
                  
        if(count($params))
        {
        	if($params['type']!="")
        	{
        		foreach ($I18N as $i18n_item_group)
        		{
        			foreach ($i18n_item_group as $i18n_item)
        			{
        				//echo "<pre>";print_r($i18n_item);
        				if(trim($i18n_item['source'])==trim($content))
        					$i18n_block = $i18n_item;
        			}
        		}
        	}
        	
        	if($params['lang']!="")
        	{
        		$result = $i18n_block[strtoupper($params['lang'])];
        		if($result == "")$result = $i18n_block['source']; 
        	} 
        	else   
        		$result = $i18n_block['source'];    	
        }
    }
    echo $result;  
}  
?>  