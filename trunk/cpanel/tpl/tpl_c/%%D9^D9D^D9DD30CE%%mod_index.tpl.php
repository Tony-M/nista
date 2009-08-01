<?php /* Smarty version 2.6.12, created on 2009-08-01 22:11:12
         compiled from ../mod/partition_manager/tpl/mod_index.tpl */ ?>
<h1>Менеджер по работе с разделами</h1>
<p>В основные функции модуля входит работа с разделами сайта</p><hr>

<?php if ($this->_tpl_vars['DOCUMENT']['MSG'] <> ""): ?><div class="sys_msg"><?php echo $this->_tpl_vars['DOCUMENT']['MSG']; ?>
</div><?php endif;  if ($this->_tpl_vars['DOCUMENT']['ERR_MSG'] <> ""): ?><div class="sys_err_msg"><?php echo $this->_tpl_vars['DOCUMENT']['ERR_MSG']; ?>
</div><?php endif; ?>

<table>
	<tr>
		<td><a href="index.php?p=site" class="menu_action">Обновить</a></td>
		<td><a href="index.php?p=site&sp=add_partition" class="menu_action">Добавить раздел</a></td>
		<td><a href="index.php?p=site&sp=ls_category" class="menu_action">Список категорий</a></td>
		<td><a href="index.php?p=site&sp=add_category" class="menu_action">Добавить категорию</a></td>
		<td></td>
		
	</tr>
</table>
<table style="padding-top:10pt;">
	<tr>
		<td nowrap="nowrap"><b>Статистика:</b></td>
		<td nowrap="nowrap"><p>Разделов сайта: <?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['total_prt_num']; ?>
</p></td>
	</tr>
</table>

<form method="POST" enctype="multipart/form-data" id="frm_prt_list" name="frm_prt_list" action="index.php?p=site&sp=update_prt">
<h2>Список разделов сайта</h2>
	<table border="0" cellspacing="1" cellpadding="0" width="100%" class="table_body">
		<tr>
			<td class="table_head" style="width:48px;" colspan="3">Сост</td>
			<td class="table_head">Заглавие</td>
			<td class="table_head">Линк</td>
			<td class="table_head" style="width:74px;" colspan="4">&nbsp;</td>
		</tr>
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
		<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
			<td class="td_body"  style="width:16px;"><input type="checkbox" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['id']; ?>
" name="prt_id[]" id="prt_id[]"></td>
			<td class="td_body"  style="width:16px;">
				<?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['status'] == 'off'): ?><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
unpublish.gif" width="16" height="16" alt="Отключено" title="Отключено"> <?php endif; ?>
				<?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['status'] == 'wait'): ?><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
draft.gif" width="16" height="16" alt="В черновиках" title="В черновиках"> <?php endif; ?>
				<?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['status'] == 'on'): ?><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
publish.gif" width="16" height="16" alt="Опубликован" title="Опубликован"> <?php endif; ?>
			</td>
			<td class="td_body" style="width: 16px; background-image: url(<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY'];  if ($this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['has_child'] == 'yes'): ?>plus1.gif<?php else: ?>line.gif<?php endif; ?>); background-repeat: repeat-y;">&nbsp;</td>
			<td class="td_body" style="padding-left:<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['tab']; ?>
5px;"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['title']; ?>
</td>
			<td class="td_body"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['link']; ?>
&nbsp;</td>
			<td class="td_body" style="width: 16px;"><a href="index.php?p=site&sp=ls_category&id=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['id']; ?>
"><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
shape_group.gif" width="16" height="16" alt="Категории раздела" title="Категории раздела" border="0"></a></td>
			<td class="td_body" style="width: 16px;"><a href="index.php?p=site&sp=edit_partition&id=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['id']; ?>
"><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
edit_16.png" width="16" height="16" alt="Редактировать" title="Редактировать" border="0"></a></td>
			<td class="td_body" style="width: 16px;">
				<?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['link'] != ""): ?>
					<a href="index.php?p=site&sp=choose_folder&prt_id=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['id']; ?>
"><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
dir.gif" width="16" height="16" alt="Редактировать назначенный каталог" title="Редактировать назначенный каталог" border="0"></a>
					<?php else: ?>
					<a href="index.php?p=site&sp=choose_folder&prt_id=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['id']; ?>
"><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
no_dir.gif" width="16" height="16" alt="Назначить каталог" title="Назначить каталог" border="0"></a>
				<?php endif; ?>
			</td>
			<td class="td_body" style="width: 26px;" align="right"><a href="" onclick="unlink_dir('<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['id']; ?>
'); return false;"><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
unlink_dir.gif" width="16" height="16" alt="Удалить привязку к каталогу" title="Удалить привязку к каталогу" border="0"></a></td>
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