<h1>Создание/редактирование информационной зоны</h1>
<a href="index.php?p=tpl"  class="menu_action">Отменить</a>
{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}
<form action="index.php?p=tpl&sp={$MOD_ACTION}" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<td>Имя информационной зоны* :</td>
			<td>
				<input type="hidden" name="current_name" id="current_name" value="{$DOCUMENT.mod.data.current_zone.name}" maxlength="50" size="50">
				<input type="text" name="name" id="name" value="{$DOCUMENT.mod.data.current_zone.name}" maxlength="50" size="50" {if $DOCUMENT.mod.data.current_zone.name != ''}disabled{/if}>
			</td>			
		</tr>
		<tr>
			<td>Название информационной зоны*:</td>
			<td><input type="text" name="title" id="title" value="{$DOCUMENT.mod.data.current_zone.title}" maxlength="200" size="70"></td>			
		</tr>
		<tr>
			<td>Краткое описание зоны :</td>
			<td><input type="text" name="description" id="description" value="{$DOCUMENT.mod.data.current_zone.description}" maxlength="300" size="70"></td>			
		</tr>
		
		<tr>
			<td colspan="2"><input type="submit" value="Сохранить"></td>
		</tr>
	</table>
</form>