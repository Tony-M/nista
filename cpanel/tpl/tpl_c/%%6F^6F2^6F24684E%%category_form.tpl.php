<?php /* Smarty version 2.6.12, created on 2009-06-25 22:58:42
         compiled from ../mod/partition_manager/tpl/category_form.tpl */ ?>
<h1><?php if ($this->_tpl_vars['MOD_ACTION'] == 'create_category'): ?>Создание<?php else: ?>Редактирование данных<?php endif; ?> категории</h1>
<form action="index.php?p=site&sp=<?php echo $this->_tpl_vars['MOD_ACTION']; ?>
" method="post" enctype="multipart/form-data">
<table width="100%" border="0">
	<tr>
		<td><a href="index.php?p=site"  class="menu_action">Отменить</a></td>
		<td align="right"><input type="image" src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
btn_save.gif" name="btn_submit_img" title="Сохранить"></td>
	</tr>
</table>

<?php if ($this->_tpl_vars['DOCUMENT']['ERR_MSG'] <> ""): ?><div class="sys_err_msg"><?php echo $this->_tpl_vars['DOCUMENT']['ERR_MSG']; ?>
</div><?php endif; ?>

<hr>
<table width="100%" cellpadding="0"	 cellspacing="2" background="1" style="width:100%">
	<tr>
		<td valign="top" class="form_area">
			<table width="100%">
				<tr>
					<td><span>Заглавие раздела :</span></td>
				</tr>
				<tr>
					<td>
						<input type="text" name="title" id="title" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['category_info']['title']; ?>
" class="input" style="width:100%;">
						<input type="hidden" id="ctgr_id" name="ctgr_id" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['category_info']['id']; ?>
">
					</td>			
				</tr>
				<tr>
					<td colspan="2"><span>Раздел категории:</span></td>
				</tr>
				<tr>
					<td colspan="2">
						<?php if ($this->_tpl_vars['MOD_ACTION'] == 'create_category'): ?>
						<select name="subpart" id="subpart" style="width:100%;" class="input">
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
" <?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['id'] == $this->_tpl_vars['DOCUMENT']['mod']['data']['category_info']['prt_id']): ?>selected style="font-weight:bold;"<?php endif; ?>>|-<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['tab_char'];  echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['title']; ?>
</option>
							<?php endfor; endif; ?>
						</select>
						<?php else: ?>
							<input type="text" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_info']['title']; ?>
" class="input" disabled>
						<?php endif; ?>
					</td>
				</tr>
				
				<tr>
					<td><br><input type="submit" value="Сохранить"></td>
				</tr>
			</table>		
		</td>
	</tr>
</table>
					

</form>