<h1>{if $MOD_ACTION=="create_menu"}Создание{else}редактирование{/if} меню</h1>
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
					<td>
						<div align="justify">
							<input type="hidden" name="menu_id" id="menu_id" value="{$DOCUMENT.menu_id}" maxlength="11">
							<input type="text" name="title" id="title" maxlength="255" size="70" class="input_nw" value="{$DOCUMENT.title}">
							<select id="show_title" name="show_title"  class="input_nw">
								<option value="show" {if $DOCUMENT.show_title=="show"}selected{/if}>Отображать</option>
								<option value="hide" {if $DOCUMENT.show_title=="hide"}selected{/if}>Скрывать</option>
							</select>
						</div>
					</td>			
				</tr>
				<tr>
					<td><span>Комментарий к меню (для себя) :</span></td>
					<td><input type="text" name="comment" id="comment" value="{$DOCUMENT.comment}" maxlength="255" size="70"  class="input_nw"></td>			
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