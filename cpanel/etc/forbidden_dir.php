<?php
if ( !defined('IN_NISTA') )  die("Hacking attempt");
// Перечень системных каталогов, которые нельзя давать пользователю для доступа

$SYS['FORBIDDEN_DIR'][] = substr($SYS['ADMIN_WAY'],0,strlen($SYS['ADMIN_WAY'])-1);
$SYS['FORBIDDEN_DIR'][] = "/includes";
$SYS['FORBIDDEN_DIR'][] = "/img";
$SYS['FORBIDDEN_DIR'][] = "/uploads";

?>
