<?php
/*******************************************************************************
*                Script for combining mysql functions    s                     *
********************************************************************************
*     Developed by Tony-M Studio (c)                                           *
*     Made by Morozov Anton Andreevich                                         *
*     on 15.02.2005 at 21:45                                                   *
*     Test: working propertly                                                  *
*     Description:                                                             *
*         all functions for working with mysql                                 *
*******************************************************************************/
if(!defined('IN_SITE')) header("Location: http://".$_SERVER['SERVER_NAME']."");
class func_lib_mysql{
  function db_connect()
  {
    global  $DOMAIN_NAME , $USER_NAME, $USER_PASSWORD, $DATABASE;
    // connecting (trying) to database
    $result = mysql_pconnect($DOMAIN_NAME , $USER_NAME, $USER_PASSWORD);

    if (!$result) return false;
    if (!mysql_select_db($DATABASE)) return false;

    return $result;

  }
}// end of class func_lib_mysql




?>