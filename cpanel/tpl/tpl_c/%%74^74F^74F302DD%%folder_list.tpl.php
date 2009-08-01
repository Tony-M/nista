<?php /* Smarty version 2.6.12, created on 2009-08-01 22:13:30
         compiled from ../mod/partition_manager/tpl/folder_list.tpl */ ?>
<?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['msg'] <> ""): ?><div class="sys_msg"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['msg']; ?>
</div><?php endif;  if ($this->_tpl_vars['DOCUMENT']['mod']['data']['errmsg'] <> ""): ?><div class="sys_err_msg"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['errmsg']; ?>
</div><?php endif; ?>
<input name="current_path" id="current_path" type="hidden" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['current_path']; ?>
">
<div name="div_full_path" id="div_full_path" class="form_area">
<a href="" onclick="get_folder_content(''); return false;">..</a> / 
<?php unset($this->_sections['full_path_num']);
$this->_sections['full_path_num']['name'] = 'full_path_num';
$this->_sections['full_path_num']['loop'] = is_array($_loop=$this->_tpl_vars['DOCUMENT']['mod']['data']['linked_full_path_to']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['full_path_num']['show'] = true;
$this->_sections['full_path_num']['max'] = $this->_sections['full_path_num']['loop'];
$this->_sections['full_path_num']['step'] = 1;
$this->_sections['full_path_num']['start'] = $this->_sections['full_path_num']['step'] > 0 ? 0 : $this->_sections['full_path_num']['loop']-1;
if ($this->_sections['full_path_num']['show']) {
    $this->_sections['full_path_num']['total'] = $this->_sections['full_path_num']['loop'];
    if ($this->_sections['full_path_num']['total'] == 0)
        $this->_sections['full_path_num']['show'] = false;
} else
    $this->_sections['full_path_num']['total'] = 0;
if ($this->_sections['full_path_num']['show']):

            for ($this->_sections['full_path_num']['index'] = $this->_sections['full_path_num']['start'], $this->_sections['full_path_num']['iteration'] = 1;
                 $this->_sections['full_path_num']['iteration'] <= $this->_sections['full_path_num']['total'];
                 $this->_sections['full_path_num']['index'] += $this->_sections['full_path_num']['step'], $this->_sections['full_path_num']['iteration']++):
$this->_sections['full_path_num']['rownum'] = $this->_sections['full_path_num']['iteration'];
$this->_sections['full_path_num']['index_prev'] = $this->_sections['full_path_num']['index'] - $this->_sections['full_path_num']['step'];
$this->_sections['full_path_num']['index_next'] = $this->_sections['full_path_num']['index'] + $this->_sections['full_path_num']['step'];
$this->_sections['full_path_num']['first']      = ($this->_sections['full_path_num']['iteration'] == 1);
$this->_sections['full_path_num']['last']       = ($this->_sections['full_path_num']['iteration'] == $this->_sections['full_path_num']['total']);
?>
<a href="" onclick="get_folder_content('<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['linked_full_path_to'][$this->_sections['full_path_num']['index']]['path']; ?>
'); return false;"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['linked_full_path_to'][$this->_sections['full_path_num']['index']]['title']; ?>
</a> /
<?php endfor; endif; ?>
</div>

<div class="form_area" style="margin-top:3pt;">
	<table  border="0" cellspacing="1" cellpadding="0" width="100%" >
		<tr>
			<td class="table_head" style="width:80px;">Состояние</td>
			<td class="table_head">Каталог</td>
			<td class="table_head">Привязанный раздел</td>
			
			<td class="table_head"  style="width:95px;">Права доступа</td>
			<td class="table_head"></td>
		</tr>
		<?php unset($this->_sections['file_list_num']);
$this->_sections['file_list_num']['name'] = 'file_list_num';
$this->_sections['file_list_num']['loop'] = is_array($_loop=$this->_tpl_vars['DOCUMENT']['mod']['data']['catalog_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['file_list_num']['show'] = true;
$this->_sections['file_list_num']['max'] = $this->_sections['file_list_num']['loop'];
$this->_sections['file_list_num']['step'] = 1;
$this->_sections['file_list_num']['start'] = $this->_sections['file_list_num']['step'] > 0 ? 0 : $this->_sections['file_list_num']['loop']-1;
if ($this->_sections['file_list_num']['show']) {
    $this->_sections['file_list_num']['total'] = $this->_sections['file_list_num']['loop'];
    if ($this->_sections['file_list_num']['total'] == 0)
        $this->_sections['file_list_num']['show'] = false;
} else
    $this->_sections['file_list_num']['total'] = 0;
if ($this->_sections['file_list_num']['show']):

            for ($this->_sections['file_list_num']['index'] = $this->_sections['file_list_num']['start'], $this->_sections['file_list_num']['iteration'] = 1;
                 $this->_sections['file_list_num']['iteration'] <= $this->_sections['file_list_num']['total'];
                 $this->_sections['file_list_num']['index'] += $this->_sections['file_list_num']['step'], $this->_sections['file_list_num']['iteration']++):
$this->_sections['file_list_num']['rownum'] = $this->_sections['file_list_num']['iteration'];
$this->_sections['file_list_num']['index_prev'] = $this->_sections['file_list_num']['index'] - $this->_sections['file_list_num']['step'];
$this->_sections['file_list_num']['index_next'] = $this->_sections['file_list_num']['index'] + $this->_sections['file_list_num']['step'];
$this->_sections['file_list_num']['first']      = ($this->_sections['file_list_num']['iteration'] == 1);
$this->_sections['file_list_num']['last']       = ($this->_sections['file_list_num']['iteration'] == $this->_sections['file_list_num']['total']);
?>
			<tr  onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
				<td class="td_body" align="center">
					<?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['catalog_list'][$this->_sections['file_list_num']['index']]['status'] == 'sys'): ?><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
lock.gif" width="16" height="16" alt="Системный каталог. Закрыт" title="Системный каталог. Закрыт"><?php endif; ?>
					<?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['catalog_list'][$this->_sections['file_list_num']['index']]['status'] == 'busy'): ?><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
link.gif" width="16" height="16" alt="Каталог занят" title="Каталог занят"><?php endif; ?>
					<?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['catalog_list'][$this->_sections['file_list_num']['index']]['status'] == ""): ?><input name="selected_path" id="selected_path" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['catalog_list'][$this->_sections['file_list_num']['index']]['path']; ?>
" type="radio"><?php endif; ?></td>	
				<td class="td_body"><a <?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['catalog_list'][$this->_sections['file_list_num']['index']]['status'] != 'sys'): ?>href="" onclick="get_folder_content('<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['catalog_list'][$this->_sections['file_list_num']['index']]['path']; ?>
'); return false;"<?php endif; ?>><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['catalog_list'][$this->_sections['file_list_num']['index']]['title']; ?>
</a> </td>
				<td class="td_body"><a href="index.php?p=site&sp=edit_partition&id=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['catalog_list'][$this->_sections['file_list_num']['index']]['partition_id']; ?>
"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['catalog_list'][$this->_sections['file_list_num']['index']]['partition_title']; ?>
</a>&nbsp;</td>
				
				<td class="td_body" align="center"><span><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['catalog_list'][$this->_sections['file_list_num']['index']]['r'];  echo $this->_tpl_vars['DOCUMENT']['mod']['data']['catalog_list'][$this->_sections['file_list_num']['index']]['w']; ?>
</span></td>
				<td class="td_body" style="width: 25px;" align="right"><?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['catalog_list'][$this->_sections['file_list_num']['index']]['status'] != 'sys'): ?><a href="" onclick="rm_catalog('<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['catalog_list'][$this->_sections['file_list_num']['index']]['path']; ?>
'); return false;"><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
trash_(delete)_16x16.gif" width="16" height="16" border="0" alt="Удалить" title="Удалить"></a><?php else: ?>&nbsp;<?php endif; ?></td>				
			</tr>
		<?php endfor; endif; ?>
	</table>
</div>