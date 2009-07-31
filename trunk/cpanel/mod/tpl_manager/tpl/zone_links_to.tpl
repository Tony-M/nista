<h1>Связь информационных зон и layout</h1>
<a href="index.php?p=tpl&sp=update_zone_links"  class="menu_action">Отменить</a>
{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}

<hr><br>
<b>Псевдоним зоны: </b> {$DOCUMENT.mod.data.current_zone.title}<br>
<b>Описание зоны: </b> {$DOCUMENT.mod.data.current_zone.description}<br>
<b>Имя зоны: </b> {$DOCUMENT.mod.data.current_zone.name}<br>

<form action="index.php?p=tpl&sp=zone_link_update" method="post" enctype="multipart/form-data">
<input type="hidden" value="{$DOCUMENT.mod.data.zone_name}" name="zone_name" id="zone_name">
	<h2>Информационная зона принадлежит следующим Layout</h2>
	<table border="0" cellspacing="1" cellpadding="1" width="100%" class="table_body">
				<tr>
					<td class="table_head" colspan="2">Имя Layout</td>
					<td class="table_head">Описание Layout</td>
					<td class="table_head">Файл Layout</td>
				</tr>
			
				{section name=in_layout_num loop=$DOCUMENT.mod.data.linked_layouts}
				<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
					<td class="td_body" style="width:16px;"><input type="checkbox" name="unlink_file[]" id="unlink_file[]" value="{$DOCUMENT.mod.data.linked_layouts[in_layout_num].file}"></td>
					<td class="td_body">{$DOCUMENT.mod.data.linked_layouts[in_layout_num].title}</td>
					<td class="td_body">{$DOCUMENT.mod.data.linked_layouts[in_layout_num].description}</td>
					<td class="td_body"><a href="index.php?p=tpl&sp=ls_layout_zones&file={$DOCUMENT.mod.data.linked_layouts[in_layout_num].file}">{$DOCUMENT.mod.data.linked_layouts[in_layout_num].file}</a></td>
				</tr>
				{/section}
	</table>
	<hr>
	<h2>Првязать Информационную зону следующим Layout</h2>
	<table border="0" cellspacing="1" cellpadding="1" width="100%" class="table_body">
				<tr>
					<td class="table_head" colspan="2">Имя Layout</td>
					<td class="table_head">Описание Layout</td>
					<td class="table_head">Файл Layout</td>
				</tr>
			
				{section name=not_in_layout_num loop=$DOCUMENT.mod.data.not_linked_layouts}
				<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
					<td class="td_body" style="width:16px;"><input type="checkbox" name="link_file[]" id="link_file[]" value="{$DOCUMENT.mod.data.not_linked_layouts[not_in_layout_num].file}"></td>
					<td class="td_body">{$DOCUMENT.mod.data.not_linked_layouts[not_in_layout_num].title}</td>
					<td class="td_body">{$DOCUMENT.mod.data.not_linked_layouts[not_in_layout_num].description}</td>
					<td class="td_body"><a href="index.php?p=tpl&sp=ls_layout_zones&file={$DOCUMENT.mod.data.not_linked_layouts[not_in_layout_num].file}">{$DOCUMENT.mod.data.not_linked_layouts[not_in_layout_num].file}</a></td>
				</tr>
				{/section}
	</table>
	<table width="100%">
		<tr>
			<td align="center"><input type="submit" value="Применить">&nbsp;<input type="reset" value="Отменить выбранное"></td>
		</tr>
	</table>
</form>