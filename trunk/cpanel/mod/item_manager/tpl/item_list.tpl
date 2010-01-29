<input type="hidden" name="prt_id" id="prt_id" value="{$DOCUMENT.mod.data.ptr_id}">
{capture name=menu_item_page_nums}
	<div style="margin-left:10pt; background-color:#ffffff; "><center>
	{include file=$DOCUMENT.mod.data.sub_tpl_pagination_item_list}
	</center></div>
{/capture}
{$smarty.capture.menu_item_page_nums}

<table border="0" cellspacing="1" cellpadding="0" width="100%" class="table_body">
		<tr>
			<td class="table_head" style="width:48px;" colspan="3">Сост</td>
			<td class="table_head">Заглавие</td>
			<td class="table_head" style="width:77px;" colspan="3">&nbsp;</td>
		</tr>
		{section name=item_num loop=$DOCUMENT.mod.data.item_list}
		<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
			<td class="td_body"  style="width:16px;"><input type="checkbox" value="{$DOCUMENT.mod.data.item_list[item_num].id}" name="item_id[]" id="item_id[]"></td>
			<td class="td_body"  style="width:16px;">
				{if $DOCUMENT.mod.data.item_list[item_num].status == "off"}<img src="{$DOCUMENT.ACP_IMG_WAY}unpublish.gif" width="16" height="16" alt="Отключено" title="Отключено"> {/if}
				{if $DOCUMENT.mod.data.item_list[item_num].status == "wait"}<img src="{$DOCUMENT.ACP_IMG_WAY}draft.gif" width="16" height="16" alt="В черновиках" title="В черновиках"> {/if}
				{if $DOCUMENT.mod.data.item_list[item_num].status == "on"}<img src="{$DOCUMENT.ACP_IMG_WAY}publish.gif" width="16" height="16" alt="Опубликован" title="Опубликован"> {/if}
			</td>
			<td class="td_body" style="width: 16px; background-image: url({$DOCUMENT.ACP_IMG_WAY}{if $DOCUMENT.mod.data.item_list[item_num].has_child=='yes'}plus1.gif{else}line.gif{/if}); background-repeat: repeat-y;">&nbsp;</td>
			<td class="td_body" style="padding-left:{$DOCUMENT.mod.data.item_list[item_num].tab}5px;">{$DOCUMENT.mod.data.item_list[item_num].title}</td>
			<td class="td_body" style="width: 16px;"><a href="index.php?p=menu&sp=ln&{$DOCUMENT.mod.data.item_list[item_num].object_link}"><img src="{$DOCUMENT.ACP_IMG_WAY}menu_ln.gif" width="16" height="16" alt="Создать пункт меню" title="Создать пункт меню" border="0"></a></td>
			<td class="td_body" style="width: 16px;"><a href="index.php?p=item&sp=edit_item&id={$DOCUMENT.mod.data.item_list[item_num].id}"><img src="{$DOCUMENT.ACP_IMG_WAY}edit_16.png" width="16" height="16" alt="Редактировать" title="Редактировать" border="0"></a></td>
			<td class="td_body" style="width: 45px;" align="right"><a href="" onclick="delete_item({$DOCUMENT.mod.data.item_list[item_num].id}); return false;"><img src="{$DOCUMENT.ACP_IMG_WAY}trash_(delete)_16x16.gif" width="16" height="16" border="0" alt="Удалить" title="Удалить"></a></td>
		</tr>
		{/section}
</table>
{$smarty.capture.menu_item_page_nums}