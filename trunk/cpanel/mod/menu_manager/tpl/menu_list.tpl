<table border="0" cellspacing="1" cellpadding="0" width="100%" class="table_body">
		<tr>
			<td class="table_head" style="width:48px;" colspan="3">Сост</td>
			<td class="table_head">Заглавие</td>
			<td class="table_head" style="width:57px;" colspan="3">&nbsp;</td>
		</tr>
		{section name=mc_num loop=$DOCUMENT.mod.data.menu_containers}
		<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
			<td class="td_body"  style="width:16px;"><input type="checkbox" value="{$DOCUMENT.mod.data.menu_containers[mc_num].id}" name="menu_id[]" id="menu_id[]"></td>
			<td class="td_body"  style="width:16px;">
				{if $DOCUMENT.mod.data.menu_containers[mc_num].status == "off"}<img src="{$DOCUMENT.ACP_IMG_WAY}unpublish.gif" width="16" height="16" alt="Отключено" title="Отключено"> {/if}
				{if $DOCUMENT.mod.data.menu_containers[mc_num].status == "wait"}<img src="{$DOCUMENT.ACP_IMG_WAY}draft.gif" width="16" height="16" alt="В черновиках" title="В черновиках"> {/if}
				{if $DOCUMENT.mod.data.menu_containers[mc_num].status == "on"}<img src="{$DOCUMENT.ACP_IMG_WAY}publish.gif" width="16" height="16" alt="Опубликован" title="Опубликован"> {/if}
			</td>
			<td class="td_body" style="width: 16px; background-image: url({$DOCUMENT.ACP_IMG_WAY}{if $DOCUMENT.mod.data.menu_containers[mc_num].has_child=='yes'}plus1.gif{else}line.gif{/if}); background-repeat: repeat-y;">&nbsp;</td>
			<td class="td_body" style="padding-left:{$DOCUMENT.mod.data.menu_containers[mc_num].tab}5px;">{$DOCUMENT.mod.data.menu_containers[mc_num].title}</td>
			<td class="td_body" style="width: 16px;"><a href="index.php?p=menu&sp=ls_category&id={$DOCUMENT.mod.data.menu_containers[mc_num].menu_id}"><img src="{$DOCUMENT.ACP_IMG_WAY}shape_group.gif" width="16" height="16" alt="Категории раздела" title="Категории раздела" border="0"></a></td>
			<td class="td_body" style="width: 16px;"><a href="index.php?p=menu&sp=edit_menu&id={$DOCUMENT.mod.data.menu_containers[mc_num].menu_id}"><img src="{$DOCUMENT.ACP_IMG_WAY}edit_16.png" width="16" height="16" alt="Редактировать" title="Редактировать" border="0"></a></td>
			<td class="td_body" style="width: 25px;" align="right"><a href="" onclick="delete_menu({$DOCUMENT.mod.data.menu_containers[mc_num].menu_id}); return false;"><img src="{$DOCUMENT.ACP_IMG_WAY}trash_(delete)_16x16.gif" width="16" height="16" border="0" alt="Удалить" title="Удалить"></a></td>
		</tr>
		{/section}
</table>