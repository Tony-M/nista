<?php /* Smarty version 2.6.12, created on 2009-06-05 22:53:45
         compiled from ../mod/tpl_manager/tpl/zone_links_to.tpl */ ?>
<h1>Связь информационных зон и layout</h1>
<a href="index.php?p=tpl&sp=update_zone_links"  class="menu_action">Отменить</a>
<?php if ($this->_tpl_vars['DOCUMENT']['ERR_MSG'] <> ""): ?><div class="sys_err_msg"><?php echo $this->_tpl_vars['DOCUMENT']['ERR_MSG']; ?>
</div><?php endif; ?>

<hr><br>
<b>Псевдоним зоны: </b> <?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['current_zone']['title']; ?>
<br>
<b>Описание зоны: </b> <?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['current_zone']['description']; ?>
<br>
<b>Имя зоны: </b> <?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['current_zone']['name']; ?>
<br>

<form action="index.php?p=tpl&sp=zone_link_update" method="post" enctype="multipart/form-data">
<input type="hidden" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['zone_name']; ?>
" name="zone_name" id="zone_name">
	<h2>Информационная зона принадлежит следующим Layout</h2>
	<table border="0" cellspacing="1" cellpadding="1" width="100%" class="table_body">
				<tr>
					<td class="table_head" colspan="2">Имя Layout</td>
					<td class="table_head">Описание Layout</td>
					<td class="table_head">Файл Layout</td>
				</tr>
			
				<?php unset($this->_sections['in_layout_num']);
$this->_sections['in_layout_num']['name'] = 'in_layout_num';
$this->_sections['in_layout_num']['loop'] = is_array($_loop=$this->_tpl_vars['DOCUMENT']['mod']['data']['linked_layouts']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['in_layout_num']['show'] = true;
$this->_sections['in_layout_num']['max'] = $this->_sections['in_layout_num']['loop'];
$this->_sections['in_layout_num']['step'] = 1;
$this->_sections['in_layout_num']['start'] = $this->_sections['in_layout_num']['step'] > 0 ? 0 : $this->_sections['in_layout_num']['loop']-1;
if ($this->_sections['in_layout_num']['show']) {
    $this->_sections['in_layout_num']['total'] = $this->_sections['in_layout_num']['loop'];
    if ($this->_sections['in_layout_num']['total'] == 0)
        $this->_sections['in_layout_num']['show'] = false;
} else
    $this->_sections['in_layout_num']['total'] = 0;
if ($this->_sections['in_layout_num']['show']):

            for ($this->_sections['in_layout_num']['index'] = $this->_sections['in_layout_num']['start'], $this->_sections['in_layout_num']['iteration'] = 1;
                 $this->_sections['in_layout_num']['iteration'] <= $this->_sections['in_layout_num']['total'];
                 $this->_sections['in_layout_num']['index'] += $this->_sections['in_layout_num']['step'], $this->_sections['in_layout_num']['iteration']++):
$this->_sections['in_layout_num']['rownum'] = $this->_sections['in_layout_num']['iteration'];
$this->_sections['in_layout_num']['index_prev'] = $this->_sections['in_layout_num']['index'] - $this->_sections['in_layout_num']['step'];
$this->_sections['in_layout_num']['index_next'] = $this->_sections['in_layout_num']['index'] + $this->_sections['in_layout_num']['step'];
$this->_sections['in_layout_num']['first']      = ($this->_sections['in_layout_num']['iteration'] == 1);
$this->_sections['in_layout_num']['last']       = ($this->_sections['in_layout_num']['iteration'] == $this->_sections['in_layout_num']['total']);
?>
				<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
					<td class="td_body" style="width:16px;"><input type="checkbox" name="unlink_file[]" id="unlink_file[]" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['linked_layouts'][$this->_sections['in_layout_num']['index']]['file']; ?>
"></td>
					<td class="td_body"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['linked_layouts'][$this->_sections['in_layout_num']['index']]['title']; ?>
</td>
					<td class="td_body"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['linked_layouts'][$this->_sections['in_layout_num']['index']]['description']; ?>
</td>
					<td class="td_body"><a href="index.php?p=tpl&sp=ls_layout_zones&file=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['linked_layouts'][$this->_sections['in_layout_num']['index']]['file']; ?>
"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['linked_layouts'][$this->_sections['in_layout_num']['index']]['file']; ?>
</a></td>
				</tr>
				<?php endfor; endif; ?>
	</table>
	<hr>
	<h2>Првязать Информационную зону следующим Layout</h2>
	<table border="0" cellspacing="1" cellpadding="1" width="100%" class="table_body">
				<tr>
					<td class="table_head" colspan="2">Имя Layout</td>
					<td class="table_head">Описание Layout</td>
					<td class="table_head">Файл Layout</td>
				</tr>
			
				<?php unset($this->_sections['not_in_layout_num']);
$this->_sections['not_in_layout_num']['name'] = 'not_in_layout_num';
$this->_sections['not_in_layout_num']['loop'] = is_array($_loop=$this->_tpl_vars['DOCUMENT']['mod']['data']['not_linked_layouts']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['not_in_layout_num']['show'] = true;
$this->_sections['not_in_layout_num']['max'] = $this->_sections['not_in_layout_num']['loop'];
$this->_sections['not_in_layout_num']['step'] = 1;
$this->_sections['not_in_layout_num']['start'] = $this->_sections['not_in_layout_num']['step'] > 0 ? 0 : $this->_sections['not_in_layout_num']['loop']-1;
if ($this->_sections['not_in_layout_num']['show']) {
    $this->_sections['not_in_layout_num']['total'] = $this->_sections['not_in_layout_num']['loop'];
    if ($this->_sections['not_in_layout_num']['total'] == 0)
        $this->_sections['not_in_layout_num']['show'] = false;
} else
    $this->_sections['not_in_layout_num']['total'] = 0;
if ($this->_sections['not_in_layout_num']['show']):

            for ($this->_sections['not_in_layout_num']['index'] = $this->_sections['not_in_layout_num']['start'], $this->_sections['not_in_layout_num']['iteration'] = 1;
                 $this->_sections['not_in_layout_num']['iteration'] <= $this->_sections['not_in_layout_num']['total'];
                 $this->_sections['not_in_layout_num']['index'] += $this->_sections['not_in_layout_num']['step'], $this->_sections['not_in_layout_num']['iteration']++):
$this->_sections['not_in_layout_num']['rownum'] = $this->_sections['not_in_layout_num']['iteration'];
$this->_sections['not_in_layout_num']['index_prev'] = $this->_sections['not_in_layout_num']['index'] - $this->_sections['not_in_layout_num']['step'];
$this->_sections['not_in_layout_num']['index_next'] = $this->_sections['not_in_layout_num']['index'] + $this->_sections['not_in_layout_num']['step'];
$this->_sections['not_in_layout_num']['first']      = ($this->_sections['not_in_layout_num']['iteration'] == 1);
$this->_sections['not_in_layout_num']['last']       = ($this->_sections['not_in_layout_num']['iteration'] == $this->_sections['not_in_layout_num']['total']);
?>
				<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
					<td class="td_body" style="width:16px;"><input type="checkbox" name="link_file[]" id="link_file[]" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['not_linked_layouts'][$this->_sections['not_in_layout_num']['index']]['file']; ?>
"></td>
					<td class="td_body"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['not_linked_layouts'][$this->_sections['not_in_layout_num']['index']]['title']; ?>
</td>
					<td class="td_body"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['not_linked_layouts'][$this->_sections['not_in_layout_num']['index']]['description']; ?>
</td>
					<td class="td_body"><a href="index.php?p=tpl&sp=ls_layout_zones&file=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['not_linked_layouts'][$this->_sections['not_in_layout_num']['index']]['file']; ?>
"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['not_linked_layouts'][$this->_sections['not_in_layout_num']['index']]['file']; ?>
</a></td>
				</tr>
				<?php endfor; endif; ?>
	</table>
	<table width="100%">
		<tr>
			<td align="center"><input type="submit" value="Применить">&nbsp;<input type="reset" value="Отменить выбранное"></td>
		</tr>
	</table>
</form>