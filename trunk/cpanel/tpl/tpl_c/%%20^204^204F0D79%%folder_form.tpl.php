<?php /* Smarty version 2.6.12, created on 2009-08-01 22:13:30
         compiled from ../mod/partition_manager/tpl/folder_form.tpl */ ?>
<h1>Менеджер по работе с разделами</h1>
<p>В основные функции модуля входит работа с разделами сайта</p><hr>

<?php if ($this->_tpl_vars['DOCUMENT']['MSG'] <> ""): ?><div class="sys_msg"><?php echo $this->_tpl_vars['DOCUMENT']['MSG']; ?>
</div><?php endif;  if ($this->_tpl_vars['DOCUMENT']['ERR_MSG'] <> ""): ?><div class="sys_err_msg"><?php echo $this->_tpl_vars['DOCUMENT']['ERR_MSG']; ?>
</div><?php endif; ?>

<table>
	<tr>
		<td><a href="index.php?p=site" class="menu_action">К списку разделов</a></td>
		
		<td></td>
		
	</tr>
</table>
<table style="padding-top:10pt;">
	<tr>
		<td nowrap="nowrap"><b>Выбранный раздел:</b></td>
		<td nowrap="nowrap"><p><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_info']['title']; ?>
</p></td>
	</tr>
</table>

<input id="prt_id" name="prt_id" type="hidden" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_info']['id']; ?>
">
<div name="main_div" id="main_div">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['DOCUMENT']['mod']['data']['sub_tpl_folder_list'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<input name="new_dir" id="new_dir" value="" type="text">
<input name="create" id="create" type="submit" class="input" value="Создать каталог" style="width:150px;" onclick="create_catalog(); return false;">
<input type="submit" id="apply" name="apply" onclick="link_path(); return false;" value="Применить">