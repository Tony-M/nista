<?php /* Smarty version 2.6.12, created on 2009-08-01 22:11:12
         compiled from overall_header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'popup', 'overall_header.tpl', 44, false),)), $this); ?>
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
	
	<?php if ($this->_tpl_vars['DOCUMENT']['OPTION']['xinha'] == 'enabled'): ?>
		<script type="text/javascript">
		    _editor_url  = "<?php echo $this->_tpl_vars['SYS']['LIB_DIR']; ?>
xinha/"  // (preferably absolute) URL (including trailing slash) where Xinha is installed
		    _editor_lang = "ru";      // And the language we need to use in the editor.
//		    _editor_skin = "silva";   // If you want use a skin, add the name (of the folder) here
		</script>
	  	<script type="text/javascript" src="<?php echo $this->_tpl_vars['SYS']['LIB_DIR']; ?>
xinha/XinhaCore.js"></script>
	  	<script type="text/javascript" src="<?php echo $this->_tpl_vars['SYS']['LIB_DIR']; ?>
xinha/my_config.js"></script>
	<?php endif; ?>
	
	<link rel="SHORTCUT ICON" href="../templates/nista2/img/favicon.ico" TYPE="image/ico">
	<?php echo $this->_tpl_vars['MENU_HEADER']; ?>

</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-color:#ff0000;border-width:1pt;border-style:solid;height:100%">
 <tr>
     <td align="left" valign="top">
         <table width="100%" cellpadding="0" cellspacing="0" border="0">
         <tr><td style="height:44px; background-image:url(<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
nista_v2_2_bg_top.jpg);" align="left" valign="top"><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
nista_v2_2_logo.jpg" width="287" height="44"  border="0"></td><td style="height:44px; background-image:url(<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
nista_v2_2_bg_top.jpg);" align="right" valign="top"><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
nista_v2_2_top_pic.jpg" width="513" height="44" border="0"></td></tr>
         <tr><td colspan="2" style="height:12px; background-image:url(<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
nista_v2_2_grid.gif);"></td></tr>
         </table>
    </td>
 </tr>
   <tr>
    <td align="left" valign="top" style="height:20px; background-image:url(<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
nista_v2_2_top_menu_bg.jpg); padding-left:10pt;">

    <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%" style="height:20px;">
       <TR>
          <TD class="td_top_menu" width="10%"><?php echo $this->_tpl_vars['MENU'];  echo $this->_tpl_vars['MENU_FOOTER']; ?>
</TD>
          <TD class="td_top_menu" width="10%" align="right" valign="middle" style="padding-right:15pt; "><DIV  id=m3 ><A  onclick="javascript:do_menu('m3x')" onmouseover="do_check('m3x')" href="logout.php" class="a_top_menu" <?php echo smarty_function_popup(array('text' => 'click if u wanna logout'), $this);?>
><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
off_16.png" width="15" height="15" border=0  hspace="5"  align="top"><?php echo $this->_tpl_vars['LOGOUT']; ?>
</A> </DIV></TD>
       </TR>
      </table>
        <!-- tytt -->
     </td>
   </tr>
<tr>
 <td align="left" valign="middlep" style="height:40px; background-image:url(<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
nista_v2_2_menu_bg.gif); padding-left:10pt;">
 <table border="0" cellpadding="0" cellspacing="0">
 <tr>
  <td><a href="index.php"><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
img_home_32.gif" width="32" height="32" border=0></a></td>
  <td><a href="index.php"></a></td>
  <td width="100%">&nbsp;</td>
  <td style="padding-right:15pt;"><a href=""><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
question_32.gif" width="32" height="32" border=0></a></td>
 </tr>
</table>

 </td>
</tr>

<tr>
<td valign="top" align="left" style="height:100%; padding-left:10pt; padding-right:10pt; padding-top:10pt;">