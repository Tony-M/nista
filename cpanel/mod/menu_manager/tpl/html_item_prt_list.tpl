<input type="hidden" maxlength="11" value="{$DOCUMENT.mod.data.item_id}" name="selected_item_id" id="selected_item_id">
<table border="0" cellspacing="1" cellpadding="0" width="100%" class="table_body">
	<tr>
		<td class="table_head" style="width:32px;" colspan="2">Сост</td>
		<td class="table_head" colspan="2">Заглавие раздела</td>
	</tr>
	{section name=item_prt_num loop=$DOCUMENT.mod.data.partitions}
	<tr class="tr">
		<td class="td_body"  style="width:16px;"><a href="" onclick="remove_mitem_relation(this, '{$DOCUMENT.mod.data.partitions[item_prt_num].rid}', '{$DOCUMENT.mod.data.partitions[item_prt_num].prt_id}');return false;"><img src="{$DOCUMENT.ACP_IMG_WAY}trash_(delete)_16x16.gif" width="16" height="16" border="0" alt="Удалить привязку" title="Удалить привязку"></a></td>
		<td class="td_body" style="width:16px;">
				{if $DOCUMENT.mod.data.partitions[item_prt_num].status == "off"}<img src="{$DOCUMENT.ACP_IMG_WAY}unpublish.gif" width="16" height="16" alt="Отключено" title="Отключено"> {/if}
				{if $DOCUMENT.mod.data.partitions[item_prt_num].status == "wait"}<img src="{$DOCUMENT.ACP_IMG_WAY}draft.gif" width="16" height="16" alt="В черновиках" title="В черновиках"> {/if}
				{if $DOCUMENT.mod.data.partitions[item_prt_num].status == "on"}<img src="{$DOCUMENT.ACP_IMG_WAY}publish.gif" width="16" height="16" alt="Опубликован" title="Опубликован"> {/if}
			</td>
		<td class="td_body"><a index="#" >{if $DOCUMENT.mod.data.partitions[item_prt_num].prt_id != 0}{$DOCUMENT.mod.data.partitions[item_prt_num].partition.title}{else}Все разделы{/if}</a></td>
		<td  class="td_body" style="width:60px;">
			<input value="{$DOCUMENT.mod.data.partitions[item_prt_num].rid}" name="rid[]" id="rid[]" type="hidden" maxlength="11">
			<select id="rid_status[]" class="input_list_transp" name="rid_status[]" size="1" onchange="update_rid_status(this.options[this.selectedIndex].value , '{$DOCUMENT.mod.data.partitions[item_prt_num].rid}', this);" >
			<option value="none"> </option>
			<option value="on" {if $DOCUMENT.mod.data.partitions[item_prt_num].status == 'on'}selected{/if}> enable</option>
			<option value="wait" {if $DOCUMENT.mod.data.partitions[item_prt_num].status == 'wait'}selected{/if}> draft</option>
			<option value="off" {if $DOCUMENT.mod.data.partitions[item_prt_num].status == 'off'}selected{/if}> disable</option>
			</select>
		</td>
	</tr>
	{/section}
</table>
<br>
<table border="0" width="100%">
<tr>
<td width="100%">
<select id="partition_id" name="prtition_id" class="input">
	<option value="--"></option>
	<option value="0">Все разделы</option>
	{section name=p_num loop=$DOCUMENT.mod.data.partitions_for_menu}
			{if $DOCUMENT.mod.data.partitions_for_menu[p_num].not_subprt=="yes"}
					<option value="--">--</option>
			{/if}
			<option value="{$DOCUMENT.mod.data.partitions_for_menu[p_num].id}">
				|-{$DOCUMENT.mod.data.partitions_for_menu[p_num].tab_char}{$DOCUMENT.mod.data.partitions_for_menu[p_num].title}
			</option>
	{/section}
</select>
</td>
<td>
<input type="button" value="Привязать" title="Привязать к разделу" onclick="add_rel(); return false;">
</td>
</tr>
</table>
