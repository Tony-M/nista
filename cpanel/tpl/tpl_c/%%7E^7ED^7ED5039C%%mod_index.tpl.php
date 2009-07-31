<?php /* Smarty version 2.6.12, created on 2009-06-07 00:54:12
         compiled from ../mod/tpl_manager/tpl/mod_index.tpl */ ?>
<h1>Менеджер по работе с шаблонами</h1>
<p>В основные функции модуля входит работа с элементами layout и Информационных зон.</p><hr>

<?php if ($this->_tpl_vars['DOCUMENT']['MSG'] <> ""): ?><div class="sys_msg"><?php echo $this->_tpl_vars['DOCUMENT']['MSG']; ?>
</div><?php endif;  if ($this->_tpl_vars['DOCUMENT']['ERR_MSG'] <> ""): ?><div class="sys_err_msg"><?php echo $this->_tpl_vars['DOCUMENT']['ERR_MSG']; ?>
</div><?php endif; ?>

<table>
	<tr>
		<td><a href="index.php?p=tpl" class="menu_action">Обновить</a></td>
		<td><a href="index.php?p=tpl&sp=add_tpl" class="menu_action">Добавить Layout</a></td>
		<td><a href="index.php?p=tpl&sp=add_zone" class="menu_action">Добавить Информационную зону</a></td>
		<td></td>
		
	</tr>
</table>
<table width="100%">
	<tr>
		<td valign="top" width="60%">
			<h2>Список layout</h2>
			<table border="0" cellspacing="1" cellpadding="1" width="100%" class="table_body">
				<tr>
					<td class="table_head">Имя layout</td>
					<td class="table_head">Описание layout</td>
					<td class="table_head">Файл layout</td>
				</tr>
			
				<?php unset($this->_sections['layout_num']);
$this->_sections['layout_num']['name'] = 'layout_num';
$this->_sections['layout_num']['loop'] = is_array($_loop=$this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['layout']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['layout_num']['show'] = true;
$this->_sections['layout_num']['max'] = $this->_sections['layout_num']['loop'];
$this->_sections['layout_num']['step'] = 1;
$this->_sections['layout_num']['start'] = $this->_sections['layout_num']['step'] > 0 ? 0 : $this->_sections['layout_num']['loop']-1;
if ($this->_sections['layout_num']['show']) {
    $this->_sections['layout_num']['total'] = $this->_sections['layout_num']['loop'];
    if ($this->_sections['layout_num']['total'] == 0)
        $this->_sections['layout_num']['show'] = false;
} else
    $this->_sections['layout_num']['total'] = 0;
if ($this->_sections['layout_num']['show']):

            for ($this->_sections['layout_num']['index'] = $this->_sections['layout_num']['start'], $this->_sections['layout_num']['iteration'] = 1;
                 $this->_sections['layout_num']['iteration'] <= $this->_sections['layout_num']['total'];
                 $this->_sections['layout_num']['index'] += $this->_sections['layout_num']['step'], $this->_sections['layout_num']['iteration']++):
$this->_sections['layout_num']['rownum'] = $this->_sections['layout_num']['iteration'];
$this->_sections['layout_num']['index_prev'] = $this->_sections['layout_num']['index'] - $this->_sections['layout_num']['step'];
$this->_sections['layout_num']['index_next'] = $this->_sections['layout_num']['index'] + $this->_sections['layout_num']['step'];
$this->_sections['layout_num']['first']      = ($this->_sections['layout_num']['iteration'] == 1);
$this->_sections['layout_num']['last']       = ($this->_sections['layout_num']['iteration'] == $this->_sections['layout_num']['total']);
?>
				<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
					<td class="td_body"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['layout'][$this->_sections['layout_num']['index']]['title']; ?>
</td>
					<td class="td_body"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['layout'][$this->_sections['layout_num']['index']]['description']; ?>
</td>
					<td class="td_body"><a href="index.php?p=tpl&sp=ls_layout_zones&file=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['layout'][$this->_sections['layout_num']['index']]['file']; ?>
"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['layout'][$this->_sections['layout_num']['index']]['file']; ?>
<a/></td>
				</tr>
				<?php endfor; endif; ?>
			</table>
			<h2>Список информационных зон</h2>
			
			<table border="0" cellspacing="1" cellpadding="1" width="100%" class="table_body">
				<tr>
					<td class="table_head">Имя Зоны</td>
					<td class="table_head">Псевдоним Зоны</td>
					<td class="table_head">Описание Зоны</td>
					<td class="table_head" style="width:16px">&nbsp;</td>
				</tr>
			
				<?php unset($this->_sections['zone_num']);
$this->_sections['zone_num']['name'] = 'zone_num';
$this->_sections['zone_num']['loop'] = is_array($_loop=$this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['zone']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['zone_num']['show'] = true;
$this->_sections['zone_num']['max'] = $this->_sections['zone_num']['loop'];
$this->_sections['zone_num']['step'] = 1;
$this->_sections['zone_num']['start'] = $this->_sections['zone_num']['step'] > 0 ? 0 : $this->_sections['zone_num']['loop']-1;
if ($this->_sections['zone_num']['show']) {
    $this->_sections['zone_num']['total'] = $this->_sections['zone_num']['loop'];
    if ($this->_sections['zone_num']['total'] == 0)
        $this->_sections['zone_num']['show'] = false;
} else
    $this->_sections['zone_num']['total'] = 0;
if ($this->_sections['zone_num']['show']):

            for ($this->_sections['zone_num']['index'] = $this->_sections['zone_num']['start'], $this->_sections['zone_num']['iteration'] = 1;
                 $this->_sections['zone_num']['iteration'] <= $this->_sections['zone_num']['total'];
                 $this->_sections['zone_num']['index'] += $this->_sections['zone_num']['step'], $this->_sections['zone_num']['iteration']++):
$this->_sections['zone_num']['rownum'] = $this->_sections['zone_num']['iteration'];
$this->_sections['zone_num']['index_prev'] = $this->_sections['zone_num']['index'] - $this->_sections['zone_num']['step'];
$this->_sections['zone_num']['index_next'] = $this->_sections['zone_num']['index'] + $this->_sections['zone_num']['step'];
$this->_sections['zone_num']['first']      = ($this->_sections['zone_num']['iteration'] == 1);
$this->_sections['zone_num']['last']       = ($this->_sections['zone_num']['iteration'] == $this->_sections['zone_num']['total']);
?>
				<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
					<td class="td_body"><a href="index.php?p=tpl&sp=ls_zone_link&zone_name=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['zone'][$this->_sections['zone_num']['index']]['name']; ?>
"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['zone'][$this->_sections['zone_num']['index']]['name']; ?>
</a></td>
					<td class="td_body"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['zone'][$this->_sections['zone_num']['index']]['title']; ?>
</td>
					<td class="td_body"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['zone'][$this->_sections['zone_num']['index']]['description']; ?>
</td>
					<td style="width:16px;"><a href="index.php?p=tpl&sp=edit_zone&zone_name=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['zone'][$this->_sections['zone_num']['index']]['name']; ?>
"><img src="<?php echo $this->_tpl_vars['DOCUMENT']['ACP_IMG_WAY']; ?>
edit_16.png" height="16" width="16" border="0" title="Редактировать" alt="Редактировать"></a></td>
				</tr>
				<?php endfor; endif; ?>
			</table>
		</td>
		<td width="40%" valign="top">
			<h2>Привязка информационных зон к layout</h2>
			<table border="0" cellspacing="1" cellpadding="1" width="100%" class="table_body">
				<tr>
					<td class="table_head">Имя Lyout</td>
					<td class="table_head">Имя Зоны</td>
				</tr>
			
				<?php unset($this->_sections['layout_link_num']);
$this->_sections['layout_link_num']['name'] = 'layout_link_num';
$this->_sections['layout_link_num']['loop'] = is_array($_loop=$this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['layout_zone_link']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['layout_link_num']['show'] = true;
$this->_sections['layout_link_num']['max'] = $this->_sections['layout_link_num']['loop'];
$this->_sections['layout_link_num']['step'] = 1;
$this->_sections['layout_link_num']['start'] = $this->_sections['layout_link_num']['step'] > 0 ? 0 : $this->_sections['layout_link_num']['loop']-1;
if ($this->_sections['layout_link_num']['show']) {
    $this->_sections['layout_link_num']['total'] = $this->_sections['layout_link_num']['loop'];
    if ($this->_sections['layout_link_num']['total'] == 0)
        $this->_sections['layout_link_num']['show'] = false;
} else
    $this->_sections['layout_link_num']['total'] = 0;
if ($this->_sections['layout_link_num']['show']):

            for ($this->_sections['layout_link_num']['index'] = $this->_sections['layout_link_num']['start'], $this->_sections['layout_link_num']['iteration'] = 1;
                 $this->_sections['layout_link_num']['iteration'] <= $this->_sections['layout_link_num']['total'];
                 $this->_sections['layout_link_num']['index'] += $this->_sections['layout_link_num']['step'], $this->_sections['layout_link_num']['iteration']++):
$this->_sections['layout_link_num']['rownum'] = $this->_sections['layout_link_num']['iteration'];
$this->_sections['layout_link_num']['index_prev'] = $this->_sections['layout_link_num']['index'] - $this->_sections['layout_link_num']['step'];
$this->_sections['layout_link_num']['index_next'] = $this->_sections['layout_link_num']['index'] + $this->_sections['layout_link_num']['step'];
$this->_sections['layout_link_num']['first']      = ($this->_sections['layout_link_num']['iteration'] == 1);
$this->_sections['layout_link_num']['last']       = ($this->_sections['layout_link_num']['iteration'] == $this->_sections['layout_link_num']['total']);
?>
				<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
					<td class="td_body" valign="top"><a href="index.php?p=tpl&sp=ls_layout_zones&file=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['layout_zone_link'][$this->_sections['layout_link_num']['index']]['file']; ?>
"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['layout_zone_link'][$this->_sections['layout_link_num']['index']]['file']; ?>
</a>&nbsp;</td>
					<td class="td_body" valign="top">
						<?php unset($this->_sections['zone_link_num']);
$this->_sections['zone_link_num']['name'] = 'zone_link_num';
$this->_sections['zone_link_num']['loop'] = is_array($_loop=$this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['layout_zone_link'][$this->_sections['layout_link_num']['index']]['contain']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['zone_link_num']['show'] = true;
$this->_sections['zone_link_num']['max'] = $this->_sections['zone_link_num']['loop'];
$this->_sections['zone_link_num']['step'] = 1;
$this->_sections['zone_link_num']['start'] = $this->_sections['zone_link_num']['step'] > 0 ? 0 : $this->_sections['zone_link_num']['loop']-1;
if ($this->_sections['zone_link_num']['show']) {
    $this->_sections['zone_link_num']['total'] = $this->_sections['zone_link_num']['loop'];
    if ($this->_sections['zone_link_num']['total'] == 0)
        $this->_sections['zone_link_num']['show'] = false;
} else
    $this->_sections['zone_link_num']['total'] = 0;
if ($this->_sections['zone_link_num']['show']):

            for ($this->_sections['zone_link_num']['index'] = $this->_sections['zone_link_num']['start'], $this->_sections['zone_link_num']['iteration'] = 1;
                 $this->_sections['zone_link_num']['iteration'] <= $this->_sections['zone_link_num']['total'];
                 $this->_sections['zone_link_num']['index'] += $this->_sections['zone_link_num']['step'], $this->_sections['zone_link_num']['iteration']++):
$this->_sections['zone_link_num']['rownum'] = $this->_sections['zone_link_num']['iteration'];
$this->_sections['zone_link_num']['index_prev'] = $this->_sections['zone_link_num']['index'] - $this->_sections['zone_link_num']['step'];
$this->_sections['zone_link_num']['index_next'] = $this->_sections['zone_link_num']['index'] + $this->_sections['zone_link_num']['step'];
$this->_sections['zone_link_num']['first']      = ($this->_sections['zone_link_num']['iteration'] == 1);
$this->_sections['zone_link_num']['last']       = ($this->_sections['zone_link_num']['iteration'] == $this->_sections['zone_link_num']['total']);
?>
							<a href="index.php?p=tpl&sp=ls_zone_link&zone_name=<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['layout_zone_link'][$this->_sections['layout_link_num']['index']]['contain'][$this->_sections['zone_link_num']['index']]; ?>
"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['file_content']['layout_zone_link'][$this->_sections['layout_link_num']['index']]['contain'][$this->_sections['zone_link_num']['index']]; ?>
</a><br>
						<?php endfor; endif; ?>&nbsp;</td>
					
				</tr>
				<?php endfor; endif; ?>
			</table>
		</td>
	</tr>
</table>