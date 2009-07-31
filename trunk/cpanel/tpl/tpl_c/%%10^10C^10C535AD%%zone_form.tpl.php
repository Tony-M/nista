<?php /* Smarty version 2.6.12, created on 2009-06-08 20:57:18
         compiled from ../mod/tpl_manager/tpl/zone_form.tpl */ ?>
<h1>Создание/редактирование информационной зоны</h1>
<a href="index.php?p=tpl"  class="menu_action">Отменить</a>
<?php if ($this->_tpl_vars['DOCUMENT']['ERR_MSG'] <> ""): ?><div class="sys_err_msg"><?php echo $this->_tpl_vars['DOCUMENT']['ERR_MSG']; ?>
</div><?php endif; ?>
<form action="index.php?p=tpl&sp=<?php echo $this->_tpl_vars['MOD_ACTION']; ?>
" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<td>Имя информационной зоны* :</td>
			<td>
				<input type="hidden" name="current_name" id="current_name" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['current_zone']['name']; ?>
" maxlength="50" size="50">
				<input type="text" name="name" id="name" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['current_zone']['name']; ?>
" maxlength="50" size="50" <?php if ($this->_tpl_vars['DOCUMENT']['mod']['data']['current_zone']['name'] != ''): ?>disabled<?php endif; ?>>
			</td>			
		</tr>
		<tr>
			<td>Название информационной зоны*:</td>
			<td><input type="text" name="title" id="title" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['current_zone']['title']; ?>
" maxlength="200" size="70"></td>			
		</tr>
		<tr>
			<td>Краткое описание зоны :</td>
			<td><input type="text" name="description" id="description" value="<?php echo $this->_tpl_vars['DOCUMENT']['mod']['data']['current_zone']['description']; ?>
" maxlength="300" size="70"></td>			
		</tr>
		
		<tr>
			<td colspan="2"><input type="submit" value="Сохранить"></td>
		</tr>
	</table>
</form>