<?php /* Smarty version 2.6.12, created on 2009-06-25 19:48:04
         compiled from ../mod/partition_manager/tpl/partition_form.tpl */ ?>
<h1><?php if ($this->_tpl_vars['MOD_ACTION'] == 'create_partition'): ?>Создание<?php else: ?>Редактирование данных<?php endif; ?> раздела сайта</h1>
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
			<table>
				<tr>
					<td><span>Заглавие раздела :</span></td>
				</tr>
				<tr>
					<td>
						<input type="text" name="title" id="title" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_info']['title']; ?>
" class="input" style="width:100%;">
						<input type="hidden" id="prt_id" name="prt_id" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_info']['id']; ?>
">
					</td>			
				</tr>
				<tr>
					<td><span>Описание раздела :</span></td>
				</tr>
				<tr>
					<td><textarea id="text" name="text" rows="20" cols="50" style="width:100%"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_info']['text']; ?>
</textarea></td>			
				</tr>
				
				<tr>
					<td><input type="submit" value="Сохранить"></td>
				</tr>
			</table>		
		</td>
		<td style="width:300px;" valign="top"  class="form_area">
			<table width="100%">
				<tr>
					<td colspan="2"><span>Ключевые слова<span></td>
				</tr>
				<tr>
					<td colspan="2"><textarea id="meta_keyword" name="meta_keyword" class="input" style="width:100%;"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_info']['meta_keyword']; ?>
</textarea></td>
				</tr>
				<tr>
					<td colspan="2"><span>Описание</span></td>
				</tr>
				<tr>
					<td colspan="2"><textarea id="meta_description" name="meta_description" class="input" style="width:100%;"><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_info']['meta_description']; ?>
</textarea></td>
				</tr>
				<tr>
					<td colspan="2"><span>Сделать подразделом:</span></td>
				</tr>
				<tr>
					<td colspan="2">
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
" <?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['id'] == $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_info']['pid']): ?>selected style="font-weight:bold;"<?php endif; ?>>|-<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['tab_char'];  echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_tree'][$this->_sections['prt_num']['index']]['title']; ?>
</option>
							<?php endfor; endif; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><span>Наследовать шаблон:</span></td>
					<td>
						<input type="checkbox" name="inherit_tpl" id="inherit_tpl" value="yes"  onclick="inherit_template(this.checked);">
					</td>
				</tr>
				<tr>
					<td><span>Шаблон раздела:</span></td>
					<td>
						<select id="template" name="template" class="input">
							<?php unset($this->_sections['tpl_num']);
$this->_sections['tpl_num']['name'] = 'tpl_num';
$this->_sections['tpl_num']['loop'] = is_array($_loop=$this->_tpl_vars['DOCUMENT']['mod']['data']['template_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['tpl_num']['show'] = true;
$this->_sections['tpl_num']['max'] = $this->_sections['tpl_num']['loop'];
$this->_sections['tpl_num']['step'] = 1;
$this->_sections['tpl_num']['start'] = $this->_sections['tpl_num']['step'] > 0 ? 0 : $this->_sections['tpl_num']['loop']-1;
if ($this->_sections['tpl_num']['show']) {
    $this->_sections['tpl_num']['total'] = $this->_sections['tpl_num']['loop'];
    if ($this->_sections['tpl_num']['total'] == 0)
        $this->_sections['tpl_num']['show'] = false;
} else
    $this->_sections['tpl_num']['total'] = 0;
if ($this->_sections['tpl_num']['show']):

            for ($this->_sections['tpl_num']['index'] = $this->_sections['tpl_num']['start'], $this->_sections['tpl_num']['iteration'] = 1;
                 $this->_sections['tpl_num']['iteration'] <= $this->_sections['tpl_num']['total'];
                 $this->_sections['tpl_num']['index'] += $this->_sections['tpl_num']['step'], $this->_sections['tpl_num']['iteration']++):
$this->_sections['tpl_num']['rownum'] = $this->_sections['tpl_num']['iteration'];
$this->_sections['tpl_num']['index_prev'] = $this->_sections['tpl_num']['index'] - $this->_sections['tpl_num']['step'];
$this->_sections['tpl_num']['index_next'] = $this->_sections['tpl_num']['index'] + $this->_sections['tpl_num']['step'];
$this->_sections['tpl_num']['first']      = ($this->_sections['tpl_num']['iteration'] == 1);
$this->_sections['tpl_num']['last']       = ($this->_sections['tpl_num']['iteration'] == $this->_sections['tpl_num']['total']);
?>
								<option value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['template_list'][$this->_sections['tpl_num']['index']]['file']; ?>
"  <?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['template_list'][$this->_sections['tpl_num']['index']]['file'] == $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_info']['template']): ?>selected style="font-weight:bold;"<?php endif; ?>><?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['template_list'][$this->_sections['tpl_num']['index']]['title']; ?>
</option>
							<?php endfor; endif; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right"  nowrap="nowrap"><span>Публиковать:</span></td>
					<td width="90%"><input type="checkbox" value="on" name="publish" id="publish" <?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['partition_info']['status'] == 'on'): ?>checked<?php endif; ?>></td>
				</tr>
				<tr>
					<td align="right" nowrap="nowrap"><span>Уровень доступа:</span></td>
					<td width="90%">
						<select class="input_list" name="access_level" id="access_level">
							<?php $_from = $this->_tpl_vars['DOCUMENT']['POST_LIST']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['post_list_title'] => $this->_tpl_vars['post_list_id']):
?>	
								<option value="<?php echo $this->_tpl_vars['post_list_id']; ?>
" <?php if ($this->_tpl_vars['post_list_id'] == $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_info']['access_level']): ?>selected style="font-weight:bold;"<?php endif; ?>><?php echo $this->_tpl_vars['post_list_title']; ?>
</option>
							<?php endforeach; endif; unset($_from); ?>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right"  nowrap="nowrap"><span>Псевдоним автора:</span></td>
					<td width="90%"><input type="text" name="penname" id="penname" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['partition_info']['penname']; ?>
" class="input" maxlength="255"></td>
				</tr>
				
				<tr>
					<td></td>
					<td></td>
				</tr><tr>
					<td></td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</form>