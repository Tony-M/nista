<h1>Создание/редактирование меню</h1>
<a href="index.php?p=menu"  class="menu_action">Отменить</a>
<hr>
{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}
<form action="index.php?p=menu&sp={$MOD_ACTION}" method="post" enctype="multipart/form-data">
	<table width="100%">
		<tr>
			<td class="form_area">
			<table>
				<tr>
					<td><span>Заголовок Меню<span class="red">*</span> :</span></td>
					<td><input type="text" name="title" id="title" value="" maxlength="255" size="70"></td>			
				</tr>
				<tr>
					<td><span>Комментарий к меню (для себя) :</span></td>
					<td><input type="text" name="comment" id="comment" value="" maxlength="255" size="70"></td>			
				</tr>
				<tr>
					<td><span>Файл шаблона<span class="red">*</span> :</span></td>
					<td>
						<select id="template" name="template" >
							<option value=""></option>
							{section name=tpl_num loop=$DOCUMENT.mod.data.template_content.menu}
								<option value="{$DOCUMENT.mod.data.template_content.menu[tpl_num].file}">{$DOCUMENT.mod.data.template_content.menu[tpl_num].title}</option>
							{/section}
						</select>
					</td>			
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Сохранить"></td>
				</tr>
			</table>
			
			</td>
		</tr>
	</table>
	
</form>
<p class="comment"><span class="red">*</span> - Поля обязательные к заполнению.</p>