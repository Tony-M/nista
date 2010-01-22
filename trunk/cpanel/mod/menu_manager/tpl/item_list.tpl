<h1>Список пунктов меню</h1>
<p>На данной странице отображены пункты для меню <b>"{$DOCUMENT.mod.data.menu_data.title}"</b></p><hr>
<table>
	<tr>
		<td><a class="menu_action" href="index.php?p=menu">К списку меню</a></td>
		<td><a class="menu_action" href="index.php?p=menu&sp=new_mitem&menu_id={$DOCUMENT.mod.data.menu_container_id}">Создать пункт меню (URL)</a></td>
	</tr>
</table><br>
{if $DOCUMENT.MSG <> ""}<div class="sys_msg">{$DOCUMENT.MSG}</div>{/if}
{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}
<table width="100%" class="form">
	<tr>
		<td width="50%" valign="top">
			<h2>Список пунктов меню</h2>
			<input type="hidden" name="current_menu_id" id="current_menu_id" value="{$DOCUMENT.mod.data.menu_data.menu_id}" maxlength="11">
			<table border="0" cellspacing="1" cellpadding="0" width="100%" class="table_body" id="item_table_tr">
				<thead>
				<tr>
					<td class="table_head" style="width:150px;" colspan="6">Действия</td>
					<td class="table_head">Заглавие пункта меню</td>
				</tr>
				</thead>
				<tbody>
				{section name=item_num loop=$DOCUMENT.mod.data.menu_item_list}
				<tr class="tr">
						<td class="td_body"  style="width:16px;"><a href="#up" href="" onclick="move_mitem(this, '{$DOCUMENT.mod.data.menu_item_list[item_num].menu_id}','up'); return false;"><img src="{$DOCUMENT.ACP_IMG_WAY}up.gif" width="16" height="16" border="0" alt="Переместить вверх" title="Переместить вверх"></a></td>
						<td class="td_body"  style="width:16px;"><a href="#down" href="" onclick="move_mitem(this, '{$DOCUMENT.mod.data.menu_item_list[item_num].menu_id}','down'); return false;"><img src="{$DOCUMENT.ACP_IMG_WAY}down.gif" width="16" height="16" border="0" alt="Переместить вниз" title="Переместить вниз"></a></td>
						<td class="td_body"  style="width:16px;"><a href="index.php?p=menu&sp=edit_mitem&menu_id={$DOCUMENT.mod.data.menu_item_list[item_num].menu_id}"><img src="{$DOCUMENT.ACP_IMG_WAY}edit_16.png" width="16" height="16" border="0" alt="Редактировать" title="Редактировать"></a></td>
						
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
						<td class="td_body"  style="width:36px;" align="center"><a href="" onclick="remove_mitem(this, '{$DOCUMENT.mod.data.menu_item_list[item_num].menu_id}'); return false;"><img src="{$DOCUMENT.ACP_IMG_WAY}trash_(delete)_16x16.gif" width="16" height="16" border="0" alt="Удалить пункт меню" title="Удалить пункт меню"></a></td>
					<td class="td_body"><a index="#" onclick="get_partitions_for_item('{$DOCUMENT.mod.data.menu_item_list[item_num].menu_id}', this); return false;">{$DOCUMENT.mod.data.menu_item_list[item_num].title}</a></td>
				</tr>
				{/section}
				</tbody>
			</table>		
		</td>
		<td width="50%" valign="top">
			<h2>Список разделов, к которым привязан пункт меню</h2>
			<div id="div_prt_list" name="div_prt_list"></div>
		</td>
	</tr>
</table>

