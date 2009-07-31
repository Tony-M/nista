<html>

<head>
  <title>{$title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="{$template_way}corpstyle.css" rel="stylesheet" type="text/css">
<link rel="SHORTCUT ICON" href="{$template_way}img/favicon.ico" TYPE="image/ico">
<SCRIPT SRC="{$template_way}sub_menu_top.js"></script>
<SCRIPT SRC="{$template_way}js.js"></script>
<SCRIPT SRC="http://{$smarty.server.SERVER_NAME}/includes/js/jquery-1.2.js"></script>
{section name=sys_js_lib_array_num loop=$SYS_JS_LIB_ARRAY}
	<SCRIPT SRC="http://{$smarty.server.SERVER_NAME}{$SYS_JS_LIB_ARRAY[sys_js_lib_array_num]}"></script>
{/section}
</head>

<body>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-color:#ff0000;border-width:1pt;border-style:solid;height:100%">
 <tr>
     <td align="left" valign="top">
         <table width="100%" cellpadding="0" cellspacing="0" border="0">
         <tr><td style="height:44px; background-image:url({$template_way}img/nista_v2_2_bg_top.jpg);" align="left" valign="top"><img src="{$template_way}img/nista_v2_2_logo.jpg" width="287" height="44"  border="0"></td></tr>
         <tr><td colspan="1" style="height:12px; background-image:url({$template_way}img/nista_v2_2_grid.gif);"></td></tr>
         </table>
    </td>
 </tr>

<tr>
<td valign="top" align="left" style="height:100%; padding-left:10pt; padding-right:10pt; padding-top:10pt;">