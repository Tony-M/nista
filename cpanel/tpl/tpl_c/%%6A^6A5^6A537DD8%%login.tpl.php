<?php /* Smarty version 2.6.12, created on 2009-05-31 21:29:42
         compiled from login.tpl */ ?>
<html>

<head>
  <title><?php echo $this->_tpl_vars['DOCUMENT']['title']; ?>
</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<?php unset($this->_sections['css_num']);
$this->_sections['css_num']['name'] = 'css_num';
$this->_sections['css_num']['loop'] = is_array($_loop=$this->_tpl_vars['DOCUMENT']['css']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['css_num']['show'] = true;
$this->_sections['css_num']['max'] = $this->_sections['css_num']['loop'];
$this->_sections['css_num']['step'] = 1;
$this->_sections['css_num']['start'] = $this->_sections['css_num']['step'] > 0 ? 0 : $this->_sections['css_num']['loop']-1;
if ($this->_sections['css_num']['show']) {
    $this->_sections['css_num']['total'] = $this->_sections['css_num']['loop'];
    if ($this->_sections['css_num']['total'] == 0)
        $this->_sections['css_num']['show'] = false;
} else
    $this->_sections['css_num']['total'] = 0;
if ($this->_sections['css_num']['show']):

            for ($this->_sections['css_num']['index'] = $this->_sections['css_num']['start'], $this->_sections['css_num']['iteration'] = 1;
                 $this->_sections['css_num']['iteration'] <= $this->_sections['css_num']['total'];
                 $this->_sections['css_num']['index'] += $this->_sections['css_num']['step'], $this->_sections['css_num']['iteration']++):
$this->_sections['css_num']['rownum'] = $this->_sections['css_num']['iteration'];
$this->_sections['css_num']['index_prev'] = $this->_sections['css_num']['index'] - $this->_sections['css_num']['step'];
$this->_sections['css_num']['index_next'] = $this->_sections['css_num']['index'] + $this->_sections['css_num']['step'];
$this->_sections['css_num']['first']      = ($this->_sections['css_num']['iteration'] == 1);
$this->_sections['css_num']['last']       = ($this->_sections['css_num']['iteration'] == $this->_sections['css_num']['total']);
?>
		<link href="<?php echo $this->_tpl_vars['DOCUMENT']['css'][$this->_sections['css_num']['index']]; ?>
" rel="stylesheet" type="text/css">
	<?php endfor; endif; ?>

	<?php unset($this->_sections['js_num']);
$this->_sections['js_num']['name'] = 'js_num';
$this->_sections['js_num']['loop'] = is_array($_loop=$this->_tpl_vars['DOCUMENT']['js']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['js_num']['show'] = true;
$this->_sections['js_num']['max'] = $this->_sections['js_num']['loop'];
$this->_sections['js_num']['step'] = 1;
$this->_sections['js_num']['start'] = $this->_sections['js_num']['step'] > 0 ? 0 : $this->_sections['js_num']['loop']-1;
if ($this->_sections['js_num']['show']) {
    $this->_sections['js_num']['total'] = $this->_sections['js_num']['loop'];
    if ($this->_sections['js_num']['total'] == 0)
        $this->_sections['js_num']['show'] = false;
} else
    $this->_sections['js_num']['total'] = 0;
if ($this->_sections['js_num']['show']):

            for ($this->_sections['js_num']['index'] = $this->_sections['js_num']['start'], $this->_sections['js_num']['iteration'] = 1;
                 $this->_sections['js_num']['iteration'] <= $this->_sections['js_num']['total'];
                 $this->_sections['js_num']['index'] += $this->_sections['js_num']['step'], $this->_sections['js_num']['iteration']++):
$this->_sections['js_num']['rownum'] = $this->_sections['js_num']['iteration'];
$this->_sections['js_num']['index_prev'] = $this->_sections['js_num']['index'] - $this->_sections['js_num']['step'];
$this->_sections['js_num']['index_next'] = $this->_sections['js_num']['index'] + $this->_sections['js_num']['step'];
$this->_sections['js_num']['first']      = ($this->_sections['js_num']['iteration'] == 1);
$this->_sections['js_num']['last']       = ($this->_sections['js_num']['iteration'] == $this->_sections['js_num']['total']);
?>
		<script language="JavaScript" type="text/javascript" src="<?php echo $this->_tpl_vars['DOCUMENT']['js'][$this->_sections['js_num']['index']]; ?>
"></script>
	<?php endfor; endif; ?>
	
	<link rel="SHORTCUT ICON" href="../templates/nista2/img/favicon.ico" TYPE="image/ico">
</head>

<body>
<input type="hidden" id="redirect" name="redirect" value="ddd<?php echo $this->_tpl_vars['REDIRECT_TO']; ?>
">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="height:100%; width:100%;">
<tr><td align="center" valign="middle" style="height:100%; width:100%;">

<table width="400" cellpadding="0" cellspacing="0" border="0"  style="height:250px; width:400px;">
<tr>
<td><img src="<?php echo $this->_tpl_vars['DOCUMENT']['TEMPLATE_IMG_DIR_LINK']; ?>
login_top.jpg" width="400" height="34"  border="0"></td>
</tr>
<tr>
<td><img src="<?php echo $this->_tpl_vars['DOCUMENT']['TEMPLATE_IMG_DIR_LINK']; ?>
login_main.jpg" width="400" height="123"  border="0"></td>
</tr>
<tr>
<td style="height:71px; background-image:url(<?php echo $this->_tpl_vars['DOCUMENT']['TEMPLATE_IMG_DIR_LINK']; ?>
login_bg.jpg);" valign="bottom">

<form name="FormName" action="index.php" method="post">
<table width="100%" cellpadding="0" cellspacing="4" border="0">
<tr><td align="right" style="padding-left:15pt;"> <a class="a_login_label">Login</a></td><td style="padding-left:15pt;"><input name="lgn" type="text" value="root"  class="input_login"></td></tr>
<tr><td align="right" style="padding-left:15pt;"><a class="a_login_label">Password</a></td><td style="padding-left:15pt;"><input name="pswd" type="password"  value="builder" class="input_login">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Enter" class="btn_login" style="background-image:url(<?php echo $this->_tpl_vars['DOCUMENT']['TEMPLATE_IMG_DIR_LINK']; ?>
btn_login.gif);">   </td></tr>

</table>
</form>

</td>
</tr>
<tr>
<td><img src="<?php echo $this->_tpl_vars['DOCUMENT']['TEMPLATE_IMG_DIR_LINK']; ?>
login_footer.jpg" width="400" height="22"  border="0"></td>
</tr>
<tr><td style="padding-left:15pt; padding-right:15pt;"><a class="a_login_error"><?php echo $this->_tpl_vars['message']; ?>
</a></td></tr>
</table>

</td></tr>


</table>


</body>

</html>