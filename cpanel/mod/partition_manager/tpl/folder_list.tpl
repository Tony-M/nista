{if $DOCUMENT.mod.data.msg <> ""}<div class="sys_msg">{$DOCUMENT.mod.data.msg}</div>{/if}
{if $DOCUMENT.mod.data.errmsg <> ""}<div class="sys_err_msg">{$DOCUMENT.mod.data.errmsg}</div>{/if}
<input name="current_path" id="current_path" type="hidden" value="{$DOCUMENT.mod.data.current_path}">
<div name="div_full_path" id="div_full_path" class="form_area">
<a href="" onclick="get_folder_content(''); return false;">..</a> / 
{section name=full_path_num loop=$DOCUMENT.mod.data.linked_full_path_to}
<a href="" onclick="get_folder_content('{$DOCUMENT.mod.data.linked_full_path_to[full_path_num].path}'); return false;">{$DOCUMENT.mod.data.linked_full_path_to[full_path_num].title}</a> /
{/section}
</div>

<div class="form_area" style="margin-top:3pt;">
	<table  border="0" cellspacing="1" cellpadding="0" width="100%" >
		<tr>
			<td class="table_head" style="width:80px;">Состояние</td>
			<td class="table_head">Каталог</td>
			<td class="table_head">Привязанный раздел</td>
			
			<td class="table_head"  style="width:95px;">Права доступа</td>
			<td class="table_head"></td>
		</tr>
		{section name=file_list_num loop=$DOCUMENT.mod.data.catalog_list}
			<tr  onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
				<td class="td_body" align="center">
					{if $DOCUMENT.mod.data.catalog_list[file_list_num].status == "sys"}<img src="{$DOCUMENT.ACP_IMG_WAY}lock.gif" width="16" height="16" alt="Системный каталог. Закрыт" title="Системный каталог. Закрыт">{/if}
					{if $DOCUMENT.mod.data.catalog_list[file_list_num].status == "busy"}<img src="{$DOCUMENT.ACP_IMG_WAY}link.gif" width="16" height="16" alt="Каталог занят" title="Каталог занят">{/if}
					{if $DOCUMENT.mod.data.catalog_list[file_list_num].status == ""}<input name="selected_path" id="selected_path" value="{$DOCUMENT.mod.data.catalog_list[file_list_num].path}" type="radio">{/if}</td>	
				<td class="td_body"><a {if $DOCUMENT.mod.data.catalog_list[file_list_num].status != "sys"}href="" onclick="get_folder_content('{$DOCUMENT.mod.data.catalog_list[file_list_num].path}'); return false;"{/if}>{$DOCUMENT.mod.data.catalog_list[file_list_num].title}</a> </td>
				<td class="td_body"><a href="index.php?p=site&sp=edit_partition&id={$DOCUMENT.mod.data.catalog_list[file_list_num].partition_id}">{$DOCUMENT.mod.data.catalog_list[file_list_num].partition_title}</a>&nbsp;</td>
				
				<td class="td_body" align="center"><span>{$DOCUMENT.mod.data.catalog_list[file_list_num].r}{$DOCUMENT.mod.data.catalog_list[file_list_num].w}</span></td>
				<td class="td_body" style="width: 25px;" align="right">{if $DOCUMENT.mod.data.catalog_list[file_list_num].status != "sys"}<a href="" onclick="rm_catalog('{$DOCUMENT.mod.data.catalog_list[file_list_num].path}'); return false;"><img src="{$DOCUMENT.ACP_IMG_WAY}trash_(delete)_16x16.gif" width="16" height="16" border="0" alt="Удалить" title="Удалить"></a>{else}&nbsp;{/if}</td>				
			</tr>
		{/section}
	</table>
</div>