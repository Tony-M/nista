<?php /* Smarty version 2.6.12, created on 2009-08-01 22:14:07
         compiled from ../mod/item_manager/tpl/mod_index.tpl */ ?>
<h1>Менеджер по работе со статьями сайта</h1>
<p>В основные функции модуля входит работа с основным контентом сайта - статьями</p><hr>

<?php if ($this->_tpl_vars['DOCUMENT']['MSG'] <> ""): ?><div class="sys_msg"><?php echo $this->_tpl_vars['DOCUMENT']['MSG']; ?>
</div><?php endif;  if ($this->_tpl_vars['DOCUMENT']['ERR_MSG'] <> ""): ?><div class="sys_err_msg"><?php echo $this->_tpl_vars['DOCUMENT']['ERR_MSG']; ?>
</div><?php endif; ?>

<table>
	<tr>
		<td><a href="index.php?p=item" class="menu_action" onclick="refresh_item_list(); return false;">Обновить</a></td>
		<td><a href="" onclick="add_item();return false;" class="menu_action">Добавить статью</a></td>
		
		<td></td>
		
	</tr>
</table>
<table style="padding-top:10pt;">
	<tr>
		<td nowrap="nowrap"><b>Статистика:</b></td>
		<td nowrap="nowrap"><p>Количество статей: <?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['total_item_num']; ?>
</p></td>
	</tr>
</table>

<form method="POST" enctype="multipart/form-data" id="frm_item_list" name="frm_item_list" action="index.php?p=item&sp=update_item_status">
<h2>Список статей сайта для раздела</h2>

<select name="owner_partition" id="owner_partition" style="width:100%;" class="input" onchange="get_item_list(this.options[this.selectedIndex].value);">
	<?php unset($this->_sections['prt_num']);
$this->_sections['prt_num']['name'] = 'prt_num';
$this->_sections['prt_num']['loop'] = is_array($_loop=$this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['prt_num']['show'] = true;
$this->_sections['prt_num']['max'] = $this->_sections['prt_num']['loop'];
$this->_sections['prt_num']['step'] = 1;
$this->_sections['prt_num']['start'] = $this->_sections['prt_num']['step'] > 0 ? 0 : $this->_sections['prt_num']['loop']-1;
if ($this->_sections['prt_num']['show']) {
    $this->_sections['prt_num']['total'] = $this->_sections['prt_num']['loop'];
    if ($this->_sections['prt_num']['total'] == 0)
        $this->_sections['prt_num']['show'] = false;
} else
    $this->_sections['prt_num']['total'] = 0;
if ($this->_sections['prt_num']['show']):

            for ($this->_sections['prt_num']['index'] = $this->_sections['prt_num']['start'], $this->_sections['prt_num']['iteration'] = 1;
                 $this->_sections['prt_num']['iteration'] <= $this->_sections['prt_num']['total'];
                 $this->_sections['prt_num']['index'] += $this->_sections['prt_num']['step'], $this->_sections['prt_num']['iteration']++):
$this->_sections['prt_num']['rownum'] = $this->_sections['prt_num']['iteration'];
$this->_sections['prt_num']['index_prev'] = $this->_sections['prt_num']['index'] - $this->_sections['prt_num']['step'];
$this->_sections['prt_num']['index_next'] = $this->_sections['prt_num']['index'] + $this->_sections['prt_num']['step'];
$this->_sections['prt_num']['first']      = ($this->_sections['prt_num']['iteration'] == 1);
$this->_sections['prt_num']['last']       = ($this->_sections['prt_num']['iteration'] == $this->_sections['prt_num']['total']);
?>
		<option value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['id'] == $this->_tpl_vars['DOCUMENT']['mod']['data']['ptr_id']): ?>selected style="font-weight:bold;"<?php endif; ?>>|-<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['tab_char'];  echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['title']; ?>
</option>
	<?php endfor; endif; ?>
</select><br><br>
<div name="main_div" id="main_div">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['DOCUMENT']['mod']['data']['sub_tpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<table border="0">
	<tbody>
		<tr>
			<td>
				<img height="16" width="23" border="0" alt="" src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
el1.png"/>
			</td>
			<td>
				<select class="input_list" size="1" name="status_action" id="status_action">
					<option value="none"> </option>
					<option value="on"> enable</option>
					<option value="wait"> draft</option>
					<option value="off"> disable</option>
				</select>		
			</td>
			<td>
				<input type="submit" name="submit" id="submit" value="Применить" class="input">
			</td>
		</tr>
	</tbody>
</table>
</form>