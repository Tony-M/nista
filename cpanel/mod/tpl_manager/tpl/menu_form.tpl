<h1>Создание/редактирование шаблона меню</h1>
<a href="index.php?p=tpl"  class="menu_action">Отменить</a><hr>
{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}
<form action="index.php?p=tpl&sp={$MOD_ACTION}" method="post" enctype="multipart/form-data">
<table><tr><td  class="form_area">
	<table>
		<tr>
			<td><span>Имя шаблона меню* :</span></td>
			<td>
				<input type="hidden" name="current_name" id="current_name" value="{$DOCUMENT.mod.data.current_menu.name}" maxlength="50" size="50">
				<input type="text" class="input" name="name" id="name" value="{$DOCUMENT.mod.data.current_menu.name}" maxlength="50" size="50" {if $DOCUMENT.mod.data.current_menu.name != ''}disabled{/if}>
			</td>			
		</tr>
		<tr>
			<td><span>Название шаблона меню*:</span></td>
			<td><input type="text" class="input" name="title" id="title" value="{$DOCUMENT.mod.data.current_menu.title}" maxlength="200" size="70"></td>			
		</tr>
		<tr>
			<td><span>Краткое описание шаблона:</span></td>
			<td><input type="text" class="input" name="description" id="description" value="{$DOCUMENT.mod.data.current_menu.description}" maxlength="300" size="70"></td>			
		</tr>
		<tr>
			<td><span>Файл шаблона* :</span></td>
			<td><input type="file" name="tpl_file" class="input"></td>			
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Сохранить" ></td>
		</tr>
	</table>
</td></tr></table>
</form>