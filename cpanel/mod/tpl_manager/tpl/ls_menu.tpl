<h1>Менеджер по работе с шаблонами меню</h1>
<p>Вы имеете возможность осуществлять основные операции с шаблонами отображения меню.</p><hr>

{if $DOCUMENT.MSG <> ""}<div class="sys_msg">{$DOCUMENT.MSG}</div>{/if}
{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}

<table>
	<tr>
		<td><a href="index.php?p=tpl" class="menu_action">Вернуться к шаблонам сайта</a></td>
		<td><a href="index.php?p=tpl&sp=ls_menu" class="menu_action">Обновить</a></td>
		<td></td>
		
	</tr>
</table>
<table width="100%">
	<tr>
		<td valign="top" width="60%">
			<h2>Список шаблонов меню</h2>
			<table border="0" cellspacing="1" cellpadding="1" width="100%" class="table_body">
				<tr>
					<td class="table_head">Имя меню</td>
					<td class="table_head">Название меню</td>
					<td class="table_head">описание меню</td>
					<td class="table_head">Файл layout</td>
					<td class="table_head" style="width:16px">&nbsp;</td>
				</tr>
			
				{section name=menu_num loop=$DOCUMENT.mod.data.file_content.menu}
				<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
					<td class="td_body">{$DOCUMENT.mod.data.file_content.menu[menu_num].name}</td>
					<td class="td_body">{$DOCUMENT.mod.data.file_content.menu[menu_num].title}</td>
					<td class="td_body">{$DOCUMENT.mod.data.file_content.menu[menu_num].description}</td>
					<td class="td_body">{$DOCUMENT.mod.data.file_content.menu[menu_num].file}</td>
					<td style="width:16px;"><a href="index.php?p=tpl&sp=edit_menu&menu_name={$DOCUMENT.mod.data.file_content.menu[menu_num].name}"><img src="{$DOCUMENT.ACP_IMG_WAY}edit_16.png" height="16" width="16" border="0" title="Редактировать" alt="Редактировать"></a></td>
				</tr>
				{/section}
			</table>
			<h2>Список информационных зон</h2>
			
			<table border="0" cellspacing="1" cellpadding="1" width="100%" class="table_body">
				<tr>
					<td class="table_head">Имя Зоны</td>
					<td class="table_head">Псевдоним Зоны</td>
					<td class="table_head">Описание Зоны</td>
					<td class="table_head" style="width:16px">&nbsp;</td>
				</tr>
			
				{section name=zone_num loop=$DOCUMENT.mod.data.file_content.zone}
				<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
					<td class="td_body"><a href="index.php?p=tpl&sp=ls_zone_link&zone_name={$DOCUMENT.mod.data.file_content.zone[zone_num].name}">{$DOCUMENT.mod.data.file_content.zone[zone_num].name}</a></td>
					<td class="td_body">{$DOCUMENT.mod.data.file_content.zone[zone_num].title}</td>
					<td class="td_body">{$DOCUMENT.mod.data.file_content.zone[zone_num].description}</td>
					<td style="width:16px;"><a href="index.php?p=tpl&sp=edit_zone&zone_name={$DOCUMENT.mod.data.file_content.zone[zone_num].name}"><img src="{$DOCUMENT.ACP_IMG_WAY}edit_16.png" height="16" width="16" border="0" title="Редактировать" alt="Редактировать"></a></td>
				</tr>
				{/section}
			</table>
		</td>
		<td width="40%" valign="top">
			<h2>Привязка информационных зон к layout</h2>
			<table border="0" cellspacing="1" cellpadding="1" width="100%" class="table_body">
				<tr>
					<td class="table_head">Имя Lyout</td>
					<td class="table_head">Имя Зоны</td>
				</tr>
			
				{section name=layout_link_num loop=$DOCUMENT.mod.data.file_content.layout_zone_link}
				<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
					<td class="td_body" valign="top"><a href="index.php?p=tpl&sp=ls_layout_zones&file={$DOCUMENT.mod.data.file_content.layout_zone_link[layout_link_num].file}">{$DOCUMENT.mod.data.file_content.layout_zone_link[layout_link_num].file}</a>&nbsp;</td>
					<td class="td_body" valign="top">
						{section name=zone_link_num loop=$DOCUMENT.mod.data.file_content.layout_zone_link[layout_link_num].contain}
							<a href="index.php?p=tpl&sp=ls_zone_link&zone_name={$DOCUMENT.mod.data.file_content.layout_zone_link[layout_link_num].contain[zone_link_num]}">{$DOCUMENT.mod.data.file_content.layout_zone_link[layout_link_num].contain[zone_link_num]}</a><br>
						{/section}&nbsp;</td>
					
				</tr>
				{/section}
			</table>
		</td>
	</tr>
</table>