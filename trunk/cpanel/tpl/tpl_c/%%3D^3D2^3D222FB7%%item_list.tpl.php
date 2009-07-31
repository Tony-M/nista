<?php /* Smarty version 2.6.12, created on 2009-07-12 12:42:21
         compiled from ../mod/item_manager/tpl/item_list.tpl */ ?>
<input type="hidden" name="prt_id" id="prt_id" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['ptr_id']; ?>
">
<?php ob_start(); ?>
	<div style="margin-left:10pt; background-color:#ffffff; "><center>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['DOCUMENT']['mod']['data']['sub_tpl_pagination_item_list'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</center></div>
<?php $this->_smarty_vars['capture']['menu_item_page_nums'] = ob_get_contents(); ob_end_clean();  echo $this->_smarty_vars['capture']['menu_item_page_nums']; ?>


<table border="0" cellspacing="1" cellpadding="0" width="100%" class="table_body">
		<tr>
			<td class="table_head" style="width:48px;" colspan="3">Сост</td>
			<td class="table_head">Заглавие</td>
			<td class="table_head" style="width:57px;" colspan="3">&nbsp;</td>
		</tr>
		<?php unset($this->_sections['item_num']);
$this->_sections['item_num']['name'] = 'item_num';
$this->_sections['item_num']['loop'] = is_array($_loop=$this->_tpl_vars['DOCUMENT']['mod']['data']['item_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['item_num']['show'] = true;
$this->_sections['item_num']['max'] = $this->_sections['item_num']['loop'];
$this->_sections['item_num']['step'] = 1;
$this->_sections['item_num']['start'] = $this->_sections['item_num']['step'] > 0 ? 0 : $this->_sections['item_num']['loop']-1;
if ($this->_sections['item_num']['show']) {
    $this->_sections['item_num']['total'] = $this->_sections['item_num']['loop'];
    if ($this->_sections['item_num']['total'] == 0)
        $this->_sections['item_num']['show'] = false;
} else
    $this->_sections['item_num']['total'] = 0;
if ($this->_sections['item_num']['show']):

            for ($this->_sections['item_num']['index'] = $this->_sections['item_num']['start'], $this->_sections['item_num']['iteration'] = 1;
                 $this->_sections['item_num']['iteration'] <= $this->_sections['item_num']['total'];
                 $this->_sections['item_num']['index'] += $this->_sections['item_num']['step'], $this->_sections['item_num']['iteration']++):
$this->_sections['item_num']['rownum'] = $this->_sections['item_num']['iteration'];
$this->_sections['item_num']['index_prev'] = $this->_sections['item_num']['index'] - $this->_sections['item_num']['step'];
$this->_sections['item_num']['index_next'] = $this->_sections['item_num']['index'] + $this->_sections['item_num']['step'];
$this->_sections['item_num']['first']      = ($this->_sections['item_num']['iteration'] == 1);
$this->_sections['item_num']['last']       = ($this->_sections['item_num']['iteration'] == $this->_sections['item_num']['total']);
?>
		<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
			<td class="td_body"  style="width:16px;"><input type="checkbox" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['item_list'][$this->_sections['item_num']['index']]['id']; ?>
" name="item_id[]" id="item_id[]"></td>
			<td class="td_body"  style="width:16px;">
				<?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['item_list'][$this->_sections['item_num']['index']]['status'] == 'off'): ?><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
unpublish.gif" width="16" height="16" alt="Отключено" title="Отключено"> <?php endif; ?>
				<?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['item_list'][$this->_sections['item_num']['index']]['status'] == 'wait'): ?><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
draft.gif" width="16" height="16" alt="В черновиках" title="В черновиках"> <?php endif; ?>
				<?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['item_list'][$this->_sections['item_num']['index']]['status'] == 'on'): ?><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
publish.gif" width="16" height="16" alt="Опубликован" title="Опубликован"> <?php endif; ?>
			</td>
			<td class="td_body" style="width: 16px; background-image: url(<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY'];  if ($this->_tpl_vars['DOCUMENT']['mod']['data']['item_list'][$this->_sections['item_num']['index']]['has_child'] == 'yes'): ?>plus1.gif<?php else: ?>line.gif<?php endif; ?>); background-repeat: repeat-y;">&nbsp;</td>
			<td class="td_body" style="padding-left:<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['item_list'][$this->_sections['item_num']['index']]['tab']; ?>
5px;"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['item_list'][$this->_sections['item_num']['index']]['title']; ?>
</td>
			<td class="td_body" style="width: 16px;"><a href="index.php?p=item&sp=ls_category&id=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['item_list'][$this->_sections['item_num']['index']]['id']; ?>
"><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
shape_group.gif" width="16" height="16" alt="Категории раздела" title="Категории раздела" border="0"></a></td>
			<td class="td_body" style="width: 16px;"><a href="index.php?p=item&sp=edit_item&id=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['item_list'][$this->_sections['item_num']['index']]['id']; ?>
"><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
edit_16.png" width="16" height="16" alt="Редактировать" title="Редактировать" border="0"></a></td>
			<td class="td_body" style="width: 25px;" align="right"><a href="" onclick="delete_item(<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['item_list'][$this->_sections['item_num']['index']]['id']; ?>
); return false;"><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
trash_(delete)_16x16.gif" width="16" height="16" border="0" alt="Удалить" title="Удалить"></a></td>
		</tr>
		<?php endfor; endif; ?>
</table>
<?php echo $this->_smarty_vars['capture']['menu_item_page_nums']; ?>