<table border="0" cellspacing="1" cellpadding="0" width="100%" class="table_body">
	<tr>
		<td class="table_head" style="width:32px;" colspan="2">Сост</td>
		<td class="table_head" colspan="2">Заглавие раздела</td>
	</tr>
	{section name=item_prt_num loop=$DOCUMENT.mod.data.partitions}
	<tr class="tr">
		<td class="td_body"  style="width:16px;"><input type="checkbox" value="{$DOCUMENT.mod.data.data.partitions[item_prt_num].menu_id}" name="it_id[]" id="it_id[]"></td>
		<td class="td_body" style="width:16px;">
				{if $DOCUMENT.mod.data.partitions[item_prt_num].status == "off"}<img src="{$DOCUMENT.ACP_IMG_WAY}unpublish.gif" width="16" height="16" alt="Отключено" title="Отключено"> {/if}
				{if $DOCUMENT.mod.data.partitions[item_prt_num].status == "wait"}<img src="{$DOCUMENT.ACP_IMG_WAY}draft.gif" width="16" height="16" alt="В черновиках" title="В черновиках"> {/if}
				{if $DOCUMENT.mod.data.partitions[item_prt_num].status == "on"}<img src="{$DOCUMENT.ACP_IMG_WAY}publish.gif" width="16" height="16" alt="Опубликован" title="Опубликован"> {/if}
			</td>
		<td class="td_body"><a index="#" >{if $DOCUMENT.mod.data.partitions[item_prt_num].prt_id != 0}{$DOCUMENT.mod.data.partitions[item_prt_num].partition.title}{else}Все разделы{/if}</a></td>
		<td  class="td_body" style="width:50px;">
			<input value="{$DOCUMENT.mod.data.partitions[item_prt_num].rid}" name="rid[]" id="rid[]" type="hidden" maxlength="11">
			<select id="rid_status[]" class="input_list" name="rid_status[]" size="1" onchange="update_rid_status(this.options[this.selectedIndex].value , '{$DOCUMENT.mod.data.partitions[item_prt_num].rid}', this);">
			<option value="none"> </option>
			<option value="on"> enable</option>
			<option value="wait"> draft</option>
			<option value="off"> disable</option>
			</select>
		</td>
	</tr>
	{/section}
</table>