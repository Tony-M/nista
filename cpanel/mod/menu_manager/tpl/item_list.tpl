<h1>Список пунктов меню</h1>
<p>На данной странице отображены пункты для меню <b>"{$DOCUMENT.mod.data.menu_data.title}"</b></p><hr>
<table>
	<tr>
		<td><a class="menu_action" href="index.php?p=menu">К списку меню</a></td>
	</tr>
</table><br>
{if $DOCUMENT.MSG <> ""}<div class="sys_msg">{$DOCUMENT.MSG}</div>{/if}
{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}
<table width="100%" class="form">
	<tr>
		<td width="50%" valign="top">
			<h2>Список пунктов меню</h2>
			<table border="0" cellspacing="1" cellpadding="0" width="100%" class="table_body" id="item_table_tr">
				<tr>
					<td class="table_head" style="width:82px;" colspan="3">Сост</td>
					<td class="table_head">Заглавие пункта меню</td>
				</tr>
				{section name=item_num loop=$DOCUMENT.mod.data.menu_item_list}
				<tr class="tr">
					<td class="td_body"  style="width:16px;"><input type="checkbox" value="{$DOCUMENT.mod.data.menu_item_list[item_num].menu_id}" name="it_id[]" id="it_id[]"></td>
						<td class="td_body"  style="width:50px;" valign="middle">
							<select id="status_action" class="input_list_transp" name="status_action" size="1" onchange="update_menu_item_status(this.options[this.selectedIndex].value , '{$DOCUMENT.mod.data.menu_item_list[item_num].menu_id}', this);">
								<option value="none"> </option>
								<option value="on" {if $DOCUMENT.mod.data.menu_item_list[item_num].status == "on"}selected{/if}> enable</option>
								<option value="wait" {if $DOCUMENT.mod.data.menu_item_list[item_num].status == "wait"}selected{/if}> draft</option>
								<option value="off" {if $DOCUMENT.mod.data.menu_item_list[item_num].status == "off"}selected{/if}> disable</option>
							</select>
						
						</td>
						<td class="td_body"  style="width:16px;">
							{if $DOCUMENT.mod.data.menu_item_list[item_num].status == "off"}<img src="{$DOCUMENT.ACP_IMG_WAY}unpublish.gif" width="16" height="16" alt="Отключено" title="Отключено"> {/if}
							{if $DOCUMENT.mod.data.menu_item_list[item_num].status == "wait"}<img src="{$DOCUMENT.ACP_IMG_WAY}draft.gif" width="16" height="16" alt="В черновиках" title="В черновиках"> {/if}
							{if $DOCUMENT.mod.data.menu_item_list[item_num].status == "on"}<img src="{$DOCUMENT.ACP_IMG_WAY}publish.gif" width="16" height="16" alt="Опубликован" title="Опубликован"> {/if}
						</td>
					<td class="td_body"><a index="#" onclick="get_partitions_for_item('{$DOCUMENT.mod.data.menu_item_list[item_num].menu_id}', this); return false;">{$DOCUMENT.mod.data.menu_item_list[item_num].title}</a></td>
				</tr>
				{/section}
			</table>		
		</td>
		<td width="50%" valign="top">
			<h2>Список разделов, к которым привязан пункт меню</h2>
			<div id="div_prt_list" name="div_prt_list"></div>
		</td>
	</tr>
</table>

