<h1>{if $MOD_ACTION=="create_item"}Создание{else}редактирование{/if} пункта меню</h1>
<p>Для объекта:
<ul>
<li><b>Тип: </b> "{$DOCUMENT.mod.data.object.object_type}" </li>
<li><b>Заглавие: </b> "{$DOCUMENT.mod.data.object.object_title}"</li>
</ul>
</p>
<hr>
<form action="index.php?p=menu&sp=create_item" method="POST" enctype="multipart/form-data" id="menu_form" name="menu_form">

{section name=obj_link_num loop=$DOCUMENT.mod.data.object_link}
	<input name="obj[]" id="obj[]" type="hidden" value="{$DOCUMENT.mod.data.object_link[obj_link_num]}">
{/section}
<input name="page_referer" id="page_referer" type="hidden" value="{$DOCUMENT.mod.data.http_referer}">

<table class="form" width="100%" border="0">
	<tr>
		<td valign="top">
			<table width="100%" border="0">
				<tr>
					<td><span>Title:</span><span class="red">*</span></td>
				</tr>
				<tr>
					<td><input type="text" maxlength="255" class="input" name="title" id="title" value="{$DOCUMENT.mod.data.menu_item.title}"></td>
				</tr>
				<tr>
					<td valign="middle">
						<span>Всплывающая подсказка: </span> 
						<input type="text" name="alt" id="alt" value="{$DOCUMENT.mod.data.menu_item.alt}" class="input_nw" maxlength="255">
						<span>Show title:</span>
						<input type="radio" value="show" {if $DOCUMENT.mod.data.menu_item.show_title=='1'}checked{/if}{if $MOD_ACTION=='create_item'}checked{/if} name="show_title" id="show_title">
						<span>Hide title:</span>
						<input type="radio" value="hide" {if $DOCUMENT.mod.data.menu_item.show_title=='0'}checked{/if} name="show_title" id="show_title">
					</td>
				</tr>
				<tr>
					<td>
						<span>Дополнительный текст:</span>
						<textarea name="text" id="text" cols="5" class="input">{$DOCUMENT.mod.data.menu_item.text}</textarea>
					</td>
				</tr>
				<tr>
					<td>
						<span>URL:</span><span class="red">*</span>
						<input name="link_url" id="link_url" class="input" value="{if $DOCUMENT.mod.data.menu_item.url==''}{$DOCUMENT.SERVER_URL}{$DOCUMENT.mod.data.object.object_url}{else}{$DOCUMENT.mod.data.menu_item.url}{/if}">
					</td>
				</tr>
				<tr>
					<td>
						<span>Имя окна или фрейма, куда браузер будет загружать документ:</span>
						<select name="target" id="target" class="input_nw">
							<option value="_self" {if $DOCUMENT.mod.data.menu_item.target=='_self'}selected{/if}>_self</option>
							<option value="_parent" {if $DOCUMENT.mod.data.menu_item.target=='_parent'}selected{/if}>_parent</option>
							<option value="_top" {if $DOCUMENT.mod.data.menu_item.target=='_top'}selected{/if}>_top</option>
							<option value="_blank" {if $DOCUMENT.mod.data.menu_item.target=='_blank'}selected{/if}>_blank</option>
						</select>
					</td>
				</tr>
			</table>
		
		
		</td>
		<td style="width:350px;" valign="top">
			
			{literal}
				<script type="text/javascript">
					$(function(){
					  $("#accordion").accordion();
					});
				</script>
			{/literal}
			
			<div id="accordion">
				<h3><a href="#">Иконка</a></h3>
				<div>
				<a>Загрузить новое изображение :</a>
				<br/>
				<br/>
				<input type="hidden" value="300000" name="MAX_FILE_SIZE"/>
				<span>File:</span>
				<input type="file" name="ico_img" class="input">
			</div>
			<h3><a href="#"></a></h3>
			<div>
				 
			</div>
			
			
			</div>
			
		</td>
	</tr>
</table>

<p class="comment">
<span class="red">*</span>
- Поля обязательные к заполнению.
</p>


<input type="submit" name="ok" id="ok" value="Сохранить">
</form>