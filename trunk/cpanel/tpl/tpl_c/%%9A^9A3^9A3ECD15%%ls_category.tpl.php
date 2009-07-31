<?php /* Smarty version 2.6.12, created on 2009-06-25 22:46:11
         compiled from ../mod/partition_manager/tpl/ls_category.tpl */ ?>
<h1>Список категорий для раздела "<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_info']['title']; ?>
"</h1>
<form action="index.php?p=site&sp=rm_category" method="post" enctype="multipart/form-data">
<table width="100%" border="0">
	<tr>
		<td><a href="index.php?p=site"  class="menu_action">Отменить</a></td>
		
	</tr>
</table>

<?php if ($this->_tpl_vars['DOCUMENT']['MSG'] <> ""): ?><div class="sys_msg"><?php echo $this->_tpl_vars['DOCUMENT']['MSG']; ?>
</div><?php endif;  if ($this->_tpl_vars['DOCUMENT']['ERR_MSG'] <> ""): ?><div class="sys_err_msg"><?php echo $this->_tpl_vars['DOCUMENT']['ERR_MSG']; ?>
</div><?php endif; ?>


<hr>
<h2>Список категорий</h2>
<table border="0" cellspacing="1" cellpadding="0" width="100%" class="table_body">
		<tr>			
			<td class="table_head" style="width:16px;">&nbsp;</td>
			<td class="table_head">Заглавие</td>
			<td class="table_head" style="width:32px;" colspan="2">&nbsp;</td>
		</tr>
		<?php unset($this->_sections['ctgr_num']);
$this->_sections['ctgr_num']['name'] = 'ctgr_num';
$this->_sections['ctgr_num']['loop'] = is_array($_loop=$this->_tpl_vars['DOCUMENT']['mod']['data']['category_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ctgr_num']['show'] = true;
$this->_sections['ctgr_num']['max'] = $this->_sections['ctgr_num']['loop'];
$this->_sections['ctgr_num']['step'] = 1;
$this->_sections['ctgr_num']['start'] = $this->_sections['ctgr_num']['step'] > 0 ? 0 : $this->_sections['ctgr_num']['loop']-1;
if ($this->_sections['ctgr_num']['show']) {
    $this->_sections['ctgr_num']['total'] = $this->_sections['ctgr_num']['loop'];
    if ($this->_sections['ctgr_num']['total'] == 0)
        $this->_sections['ctgr_num']['show'] = false;
} else
    $this->_sections['ctgr_num']['total'] = 0;
if ($this->_sections['ctgr_num']['show']):

            for ($this->_sections['ctgr_num']['index'] = $this->_sections['ctgr_num']['start'], $this->_sections['ctgr_num']['iteration'] = 1;
                 $this->_sections['ctgr_num']['iteration'] <= $this->_sections['ctgr_num']['total'];
                 $this->_sections['ctgr_num']['index'] += $this->_sections['ctgr_num']['step'], $this->_sections['ctgr_num']['iteration']++):
$this->_sections['ctgr_num']['rownum'] = $this->_sections['ctgr_num']['iteration'];
$this->_sections['ctgr_num']['index_prev'] = $this->_sections['ctgr_num']['index'] - $this->_sections['ctgr_num']['step'];
$this->_sections['ctgr_num']['index_next'] = $this->_sections['ctgr_num']['index'] + $this->_sections['ctgr_num']['step'];
$this->_sections['ctgr_num']['first']      = ($this->_sections['ctgr_num']['iteration'] == 1);
$this->_sections['ctgr_num']['last']       = ($this->_sections['ctgr_num']['iteration'] == $this->_sections['ctgr_num']['total']);
?>
			<tr  onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
				<td class="td_body" style="width:16px;"><input type="checkbox" id="id[]" name="id[]" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['category_list'][$this->_sections['ctgr_num']['index']]['id']; ?>
"></td>
				<td class="td_body"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['category_list'][$this->_sections['ctgr_num']['index']]['title']; ?>
</td>
				<td class="td_body" style="width: 16px;"><a href="index.php?p=site&sp=edit_category&id=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['category_list'][$this->_sections['ctgr_num']['index']]['id']; ?>
"><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
edit_16.png" width="16" height="16" alt="Редактировать" title="Редактировать" border="0"></a></td>
				<td class="td_body" style="width:16px;"><a href="index.php?p=site&sp=rm_category&id=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['category_list'][$this->_sections['ctgr_num']['index']]['id']; ?>
"><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
delete.gif" width="16" height="16" border="0" alt="удалить" title="удалить"></a></td>
			</tr>
		<?php endfor; endif; ?>
		
</table>
<table border="0">
	<tbody>
		<tr>
			<td>
				<img height="16" width="23" border="0" alt="" src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
el1.png"/>
			</td>
			<td>
				<span>С отмеченными: </span>		
			</td>
			<td>
				<input type="image" src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
delete_16x16.gif" title="Удалить" name="remove" id="remove">
			</td>
		</tr>
	</tbody>
</table>				

</form>