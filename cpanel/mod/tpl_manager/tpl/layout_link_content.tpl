<h1>Список привязанных к layout информационных зон</h1>
<a href="index.php?p=tpl&sp=update_zone_links"  class="menu_action">Отменить</a>
{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}

<hr><br>
<b>Псевдоним Layout: </b> {$DOCUMENT.mod.data.current_layout.title}<br>
<b>Описание Layout: </b> {$DOCUMENT.mod.data.current_layout.description}<br>
<b>Имя файла Layout: </b> {$DOCUMENT.mod.data.current_layout.file}<br>

<form action="index.php?p=tpl&sp=update_link_layout" method="post" enctype="multipart/form-data">
<input type="hidden" value="{$DOCUMENT.mod.data.current_layout.file}" name="layout_file" id="layout_file">
	<h2>Layout содержит следующие информационные зоны</h2>
	<table border="0" cellspacing="1" cellpadding="1" width="100%" class="table_body">
				<tr>
					<td class="table_head" colspan="2">Имя Зоны</td>
					<td class="table_head">Псевдоним Зоны</td>
					<td class="table_head">Описание зоны</td>
				</tr>
			
				{section name=in_layout_num loop=$DOCUMENT.mod.data.linked_zones}
				<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
					<td class="td_body" style="width:16px;"><input type="checkbox" name="unlink_zone[]" id="unlink_zone[]" value="{$DOCUMENT.mod.data.linked_zones[in_layout_num].name}"></td>
					<td class="td_body"><a href="index.php?p=tpl&sp=ls_zone_link&zone_name={$DOCUMENT.mod.data.linked_zones[in_layout_num].name}">{$DOCUMENT.mod.data.linked_zones[in_layout_num].name}</a></td>
					<td class="td_body">{$DOCUMENT.mod.data.linked_zones[in_layout_num].title}</td>
					<td class="td_body">{$DOCUMENT.mod.data.linked_zones[in_layout_num].description}</td>
				</tr>
				{/section}
	</table>
	<hr>
	<h2>Привязать Информационную зону следующим Layout</h2>
	<table border="0" cellspacing="1" cellpadding="1" width="100%" class="table_body">
				<tr>
					<td class="table_head" colspan="2">Имя Layout</td>
					<td class="table_head">Описание Layout</td>
					<td class="table_head">Файл Layout</td>
				</tr>
			
				{section name=not_in_layout_num loop=$DOCUMENT.mod.data.unlinked_zones}
				<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
					<td class="td_body" style="width:16px;"><input type="checkbox" name="link_zone[]" id="link_zone[]" value="{$DOCUMENT.mod.data.unlinked_zones[not_in_layout_num].name}"></td>
					<td class="td_body"><a href="index.php?p=tpl&sp=ls_zone_link&zone_name={$DOCUMENT.mod.data.unlinked_zones[not_in_layout_num].name}">{$DOCUMENT.mod.data.unlinked_zones[not_in_layout_num].name}<a/></td>
					<td class="td_body">{$DOCUMENT.mod.data.unlinked_zones[not_in_layout_num].title}</td>
					<td class="td_body">{$DOCUMENT.mod.data.unlinked_zones[not_in_layout_num].description}</td>
				</tr>
				{/section}
	</table>
	<table width="100%">
		<tr>
			<td align="center"><input type="submit" value="Применить">&nbsp;<input type="reset" value="Отменить выбранное"></td>
		</tr>
	</table>
</form>