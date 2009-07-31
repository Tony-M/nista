<?php
if ( !defined('IN_NISTA') )  die("Hacking attempt");

// указываем путь к библиотекам

$SYS['CONFIG_DIR'] = 'etc/';
define('CONFIG_DIR', $SYS['CONFIG_DIR']);

$SYS['LIB_DIR'] = 'lib/';
define('LIB_DIR', $SYS['LIB_DIR']);

$SYS['JS_DIR'] = 'lib/js/';
define('JS_DIR', $SYS['JS_DIR']);

$SYS['MOD_DIR'] = 'mod/';
define('MOD_DIR', $SYS['MOD_DIR']);

$SYS['LANG_DIR'] = 'lang/';
define('LANG_DIR', $SYS['LANG_DIR']);

$SYS['TPL_DIR'] = 'tpl/';
define('TPL_DIR', $SYS['TPL_DIR']);

$SYS['CSS_DIR'] = $SYS['TPL_DIR'].'css/';
define('CSS_DIR', $SYS['CSS_DIR']);





$DOCUMENT['title'] = 'Night Stalker v3';
$DOCUMENT['ACP_IMG_WAY'] = TPL_DIR.'img/';

?>
