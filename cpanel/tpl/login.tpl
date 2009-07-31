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
	
	<link rel="SHORTCUT ICON" href="../templates/nista2/img/favicon.ico" TYPE="image/ico">
</head>

<body>
<input type="hidden" id="redirect" name="redirect" value="ddd{$REDIRECT_TO}">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="height:100%; width:100%;">
<tr><td align="center" valign="middle" style="height:100%; width:100%;">

<table width="400" cellpadding="0" cellspacing="0" border="0"  style="height:250px; width:400px;">
<tr>
<td><img src="{$DOCUMENT.TEMPLATE_IMG_DIR_LINK}login_top.jpg" width="400" height="34"  border="0"></td>
</tr>
<tr>
<td><img src="{$DOCUMENT.TEMPLATE_IMG_DIR_LINK}login_main.jpg" width="400" height="123"  border="0"></td>
</tr>
<tr>
<td style="height:71px; background-image:url({$DOCUMENT.TEMPLATE_IMG_DIR_LINK}login_bg.jpg);" valign="bottom">

<form name="FormName" action="index.php" method="post">
<table width="100%" cellpadding="0" cellspacing="4" border="0">
<tr><td align="right" style="padding-left:15pt;"> <a class="a_login_label">Login</a></td><td style="padding-left:15pt;"><input name="lgn" type="text" value="root"  class="input_login"></td></tr>
<tr><td align="right" style="padding-left:15pt;"><a class="a_login_label">Password</a></td><td style="padding-left:15pt;"><input name="pswd" type="password"  value="builder" class="input_login">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Enter" class="btn_login" style="background-image:url({$DOCUMENT.TEMPLATE_IMG_DIR_LINK}btn_login.gif);">   </td></tr>

</table>
</form>

</td>
</tr>
<tr>
<td><img src="{$DOCUMENT.TEMPLATE_IMG_DIR_LINK}login_footer.jpg" width="400" height="22"  border="0"></td>
</tr>
<tr><td style="padding-left:15pt; padding-right:15pt;"><a class="a_login_error">{$message}</a></td></tr>
</table>

</td></tr>


</table>


</body>

</html>