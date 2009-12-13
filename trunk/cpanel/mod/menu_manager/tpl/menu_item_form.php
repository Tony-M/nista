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
					<td><input type="text" maxlength="255" class="input" name="title" id="title" value="{$DOCUMENT.mod.data.menu_item}"></td>
				</tr>
				<tr>
					<td valign="middle">
						<span>Всплывающая подсказка: </span> 
						<input type="text" name="alt" id="alt" value="{$DOCUMENT.mod.data.menu_item}" class="input_nw" maxlength="255">
						<span>Show title:</span>
						<input type="checkbox" value="show" checked name="show_title" id="show_title">
					</td>
				</tr>
				<tr>
					<td>
						<span>Дополнительный текст:</span>
						<textarea name="text" id="text" cols="5" class="input"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<span>URL:</span><span class="red">*</span>
						<input name="link_url" id="link_url" class="input" value="{$DOCUMENT.SERVER_URL}{$DOCUMENT.mod.data.object.object_url}">
					</td>
				</tr>
				<tr>
					<td>
						<span>Имя окна или фрейма, куда браузер будет загружать документ:</span>
						<select name="target" id="target" class="input_nw">
							<option value="_self">_self</option>
							<option value="_parent">_parent</option>
							<option value="_top">_top</option>
							<option value="_blank">_blank</option>
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
			<h3><a href="#">Привязать к меню</a></h3>
			<div>
				<span>Выберите меню из списка:</span>
				<select name="menu_list" id="menu_list" class="input">
					<option value="0"></option>
					{section name=m_num loop=$DOCUMENT.mod.data.menu_containers}
						<option value="{$DOCUMENT.mod.data.menu_containers[m_num].menu_id}" title="{$DOCUMENT.mod.data.menu_containers[m_num].comment}">{$DOCUMENT.mod.data.menu_containers[m_num].title}</option>
					{/section}
				</select><br><br>
				<div align="right">
				<input type="button" class="input_nw" name="select_menu" id="select_menu" value="Выбрать" onclick="append_menu_item_table(1); return false;">
				</div>
			</div>
			<h3><a href="#">Привязать к меню раздела</a></h3>
			<div>
				<span>Выберите раздел сайта:</span>
				<select id="prt_id" name="prt_id" class="input" onchange="get_menu_list_for_partition(this.options[this.selectedIndex].value);">
					<option value="0"></option>
					{section name=prt_num loop=$DOCUMENT.mod.data.partition_tree}
						<option value="{$DOCUMENT.mod.data.partition_tree[prt_num].id}">|--{$DOCUMENT.mod.data.partition_tree[prt_num].tab_char}{$DOCUMENT.mod.data.partition_tree[prt_num].title}</option>
					{/section}
				</select>
				<br><br>
				<span>Выберите меню из списка:</span>
				<select name="prt_menu_list" id="prt_menu_list" class="input">
					<option value="0"></option>
					<option value=""></option>
				</select>
				<br><br>
				<div align="right">
				<input type="button" class="input_nw" name="select_menu" id="select_menu" value="Выбрать" onclick="append_menu_item_table_for_selected_prt(); return false;">
				</div>
			
			</div>
			</div>
			
		</td>
	</tr>
</table>

<p class="comment">
<span class="red">*</span>
- Поля обязательные к заполнению.
</p>

<table class="form" width="100%" border="0" id="link_table" name="link_table">
	<tr>
		<td colspan="3"><h2>Список меню:<span class="red"> *</span></h2></td>
	</tr>
	<tr>
		<td class="table_head" style="width:40px;">Удалить</td>
		<td class="table_head">Меню</td>
		<td class="table_head">Привязать к разделам, содержащим данное меню</td>
		<td class="table_head" style="width:60px;">Статус</td>
	</tr>
</table>
<input type="submit" name="ok" id="ok" value="Сохранить">
</form>