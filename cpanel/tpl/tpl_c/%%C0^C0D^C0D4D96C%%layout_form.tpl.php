<?php /* Smarty version 2.6.12, created on 2009-06-04 18:16:55
         compiled from ../mod/tpl_manager/tpl/layout_form.tpl */ ?>
<h1>Загрузка/редактирование Layout</h1>
<a href="index.php?p=tpl"  class="menu_action">Отменить</a>
<?php if ($this->_tpl_vars['DOCUMENT']['ERR_MSG'] <> ""): ?><div class="sys_err_msg"><?php echo $this->_tpl_vars['DOCUMENT']['ERR_MSG']; ?>
</div><?php endif; ?>
<form action="index.php?p=tpl&sp=<?php echo $this->_tpl_vars['MOD_ACTION']; ?>
" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<td>Имя шаблона* :</td>
			<td><input type="text" name="title" id="title" value="" maxlength="200" size="70"></td>			
		</tr>
		<tr>
			<td>Краткое описание шаблона :</td>
			<td><input type="text" name="description" id="description" value="" maxlength="300" size="70"></td>			
		</tr>
		<tr>
			<td>Файл шаблона* :</td>
			<td><input type="file" name="tpl_file"></td>			
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Сохранить"></td>
		</tr>
	</table>
</form>