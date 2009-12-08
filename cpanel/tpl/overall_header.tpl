<html>

<head>
	<title>{$DOCUMENT.title}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	{section name=css_num loop=$DOCUMENT.css}
		<link href="{$DOCUMENT.css[css_num]}" rel="stylesheet" type="text/css">
	{/section}

	{section name=js_num loop=$DOCUMENT.js}
		<script language="JavaScript" type="text/javascript" src="{$DOCUMENT.js[js_num]}"></script>
	{/section}
	
	
	
	{if $DOCUMENT.OPTION.xinha == 'enabled'}
		<script type="text/javascript">
		    _editor_url  = "{$SYS.LIB_DIR}xinha/"  // (preferably absolute) URL (including trailing slash) where Xinha is installed
		    _editor_lang = "ru";      // And the language we need to use in the editor.
//		    _editor_skin = "silva";   // If you want use a skin, add the name (of the folder) here
		</script>
	  	<script type="text/javascript" src="{$SYS.LIB_DIR}xinha/XinhaCore.js"></script>
	  	<script type="text/javascript" src="{$SYS.LIB_DIR}xinha/my_config.js"></script>
	{/if}
	
	<link rel="SHORTCUT ICON" href="../templates/nista2/img/favicon.ico" TYPE="image/ico">
	{$MENU_HEADER}
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-color:#ff0000;border-width:1pt;border-style:solid;height:100%">
 <tr>
     <td align="left" valign="top">
         <table width="100%" cellpadding="0" cellspacing="0" border="0">
         <tr><td style="height:44px; background-image:url({$DOCUMENT.ACP_IMG_WAY}nista_v2_2_bg_top.jpg);" align="left" valign="top"><img src="{$DOCUMENT.ACP_IMG_WAY}nista_v2_2_logo.jpg" width="287" height="44"  border="0"></td><td style="height:44px; background-image:url({$DOCUMENT.ACP_IMG_WAY}nista_v2_2_bg_top.jpg);" align="right" valign="top"><img src="{$DOCUMENT.ACP_IMG_WAY}nista_v2_2_top_pic.jpg" width="513" height="44" border="0"></td></tr>
         <tr><td colspan="2" style="height:12px; background-image:url({$DOCUMENT.ACP_IMG_WAY}nista_v2_2_grid.gif);"></td></tr>
         </table>
    </td>
 </tr>
   <tr>
    <td align="left" valign="top" style="height:20px; background-color:#f5f5f5; padding-left:10pt;">

    <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%" style="height:20px;">
       <TR>
          <TD class="td_top_menu" width="10%">{$MENU}{$MENU_FOOTER}</TD>
          <td class="td_top_menu">
          	<div id="div_ajax_activity" name="div_ajax_activity" class="ajax_activity">
          		<table border="0" cellpadding="0" cellspacing="0">
          			<tr>
          				<td><img src="{$DOCUMENT.ACP_IMG_WAY}ajax_loader.gif" width="16" height="16" border="0"></td>
          				<td nowrap="nowrap"><div id="div_ajax_num" name="div_ajax_num" class="ajax_activity_num">3</div></td>
          				<td nowrap="nowrap"><div id="div_ajax_text" name="div_ajax_text" class="ajax_activity_text">процесса</div></td>
          			</tr>
          		</table>
          	</div>
          </td>
          <TD class="td_top_menu" width="10%" align="right" valign="middle" style="padding-right:15pt; "><DIV  id=m3 ><A  onclick="javascript:do_menu('m3x')" onmouseover="do_check('m3x')" href="logout.php" class="a_top_menu" {popup text="click if u wanna logout"}><img src="{$DOCUMENT.ACP_IMG_WAY}off_16.png" width="15" height="15" border=0  hspace="5"  align="top">{$LOGOUT}</A> </DIV></TD>
       </TR>
      </table>
        <!-- tytt -->
     </td>
   </tr>
<tr>
 <td align="left" valign="middlep" style="height:40px; background-image:url({$DOCUMENT.ACP_IMG_WAY}nista_v2_2_menu_bg.gif); padding-left:10pt;">
 <table border="0" cellpadding="0" cellspacing="0">
 <tr>
  <td><a href="index.php"><img src="{$DOCUMENT.ACP_IMG_WAY}img_home_32.gif" width="32" height="32" border=0></a></td>
  <td><a href="index.php"></a></td>
  <td width="100%">&nbsp;</td>
  <td style="padding-right:15pt;"><a href=""><img src="{$DOCUMENT.ACP_IMG_WAY}question_32.gif" width="32" height="32" border=0></a></td>
 </tr>
</table>

 </td>
</tr>

<tr>
<td valign="top" align="left" style="height:100%; padding-left:10pt; padding-right:10pt; padding-top:10pt;">