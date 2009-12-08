<h1>Менеджер по работе с разделами</h1>
<p>В основные функции модуля входит работа с разделами сайта</p><hr>

{if $DOCUMENT.MSG <> ""}<div class="sys_msg">{$DOCUMENT.MSG}</div>{/if}
{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}

<table>
	<tr>
		<td><a href="index.php?p=site" class="menu_action">Обновить</a></td>
		<td><a href="index.php?p=site&sp=add_partition" class="menu_action">Добавить раздел</a></td>
		<td><a href="index.php?p=site&sp=ls_category" class="menu_action">Список категорий</a></td>
		<td><a href="index.php?p=site&sp=add_category" class="menu_action">Добавить категорию</a></td>
		<td></td>
		
	</tr>
</table>
<table style="padding-top:10pt;">
	<tr>
		<td nowrap="nowrap"><b>Статистика:</b></td>
		<td nowrap="nowrap"><p>Разделов сайта: {$DOCUMENT.mod.data.total_prt_num}</p></td>
	</tr>
</table>

<form method="POST" enctype="multipart/form-data" id="frm_prt_list" name="frm_prt_list" action="index.php?p=site&sp=update_prt">
<h2>Список разделов сайта</h2>
	<table border="0" cellspacing="1" cellpadding="0" width="100%" class="table_body">
		<tr>
			<td class="table_head" style="width:48px;" colspan="3">Сост</td>
			<td class="table_head">Заглавие</td>
			<td class="table_head">Линк</td>
			<td class="table_head" style="width:90px;" colspan="5">&nbsp;</td>
		</tr>
		{section name=prt_num loop=$DOCUMENT.mod.data.partition_tree}
		<tr onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
			<td class="td_body"  style="width:16px;"><input type="checkbox" value="{$DOCUMENT.mod.data.partition_tree[prt_num].id}" name="prt_id[]" id="prt_id[]"></td>
			<td class="td_body"  style="width:16px;">
				{if $DOCUMENT.mod.data.partition_tree[prt_num].status == "off"}<img src="{$DOCUMENT.ACP_IMG_WAY}unpublish.gif" width="16" height="16" alt="Отключено" title="Отключено"> {/if}
				{if $DOCUMENT.mod.data.partition_tree[prt_num].status == "wait"}<img src="{$DOCUMENT.ACP_IMG_WAY}draft.gif" width="16" height="16" alt="В черновиках" title="В черновиках"> {/if}
				{if $DOCUMENT.mod.data.partition_tree[prt_num].status == "on"}<img src="{$DOCUMENT.ACP_IMG_WAY}publish.gif" width="16" height="16" alt="Опубликован" title="Опубликован"> {/if}
			</td>
			<td class="td_body" style="width: 16px; background-image: url({$DOCUMENT.ACP_IMG_WAY}{if $DOCUMENT.mod.data.partition_tree[prt_num].has_child=='yes'}plus1.gif{else}line.gif{/if}); background-repeat: repeat-y;">&nbsp;</td>
			<td class="td_body" style="padding-left:{$DOCUMENT.mod.data.partition_tree[prt_num].tab}5px;">{$DOCUMENT.mod.data.partition_tree[prt_num].title}</td>
			<td class="td_body">{$DOCUMENT.mod.data.partition_tree[prt_num].link}&nbsp;</td>
			<td class="td_body" style="width: 16px;"><a href="index.php?p=menu&sp=ln&{$DOCUMENT.mod.data.partition_tree[prt_num].object_link}"><img src="{$DOCUMENT.ACP_IMG_WAY}menu_ln.gif" width="16" height="16" alt="Создать пункт меню" title="Создать пункт меню" border="0"></a></td>
			<td class="td_body" style="width: 16px;"><a href="index.php?p=site&sp=ls_category&id={$DOCUMENT.mod.data.partition_tree[prt_num].id}"><img src="{$DOCUMENT.ACP_IMG_WAY}shape_group.gif" width="16" height="16" alt="Категории раздела" title="Категории раздела" border="0"></a></td>
			<td class="td_body" style="width: 16px;"><a href="index.php?p=site&sp=edit_partition&id={$DOCUMENT.mod.data.partition_tree[prt_num].id}"><img src="{$DOCUMENT.ACP_IMG_WAY}edit_16.png" width="16" height="16" alt="Редактировать" title="Редактировать" border="0"></a></td>
			<td class="td_body" style="width: 16px;">
				{if $DOCUMENT.mod.data.partition_tree[prt_num].link!=""}
					<a href="index.php?p=site&sp=choose_folder&prt_id={$DOCUMENT.mod.data.partition_tree[prt_num].id}"><img src="{$DOCUMENT.ACP_IMG_WAY}dir.gif" width="16" height="16" alt="Редактировать назначенный каталог" title="Редактировать назначенный каталог" border="0"></a>
					{else}
					<a href="index.php?p=site&sp=choose_folder&prt_id={$DOCUMENT.mod.data.partition_tree[prt_num].id}"><img src="{$DOCUMENT.ACP_IMG_WAY}no_dir.gif" width="16" height="16" alt="Назначить каталог" title="Назначить каталог" border="0"></a>
				{/if}
			</td>
			<td class="td_body" style="width: 26px;" align="right"><a href="" onclick="unlink_dir('{$DOCUMENT.mod.data.partition_tree[prt_num].id}'); return false;"><img src="{$DOCUMENT.ACP_IMG_WAY}unlink_dir.gif" width="16" height="16" alt="Удалить привязку к каталогу" title="Удалить привязку к каталогу" border="0"></a></td>
		</tr>
		{/section}
	</table>
<table border="0">
	<tbody>
		<tr>
			<td>
				<img height="16" width="23" border="0" alt="" src="{$DOCUMENT.ACP_IMG_WAY}el1.png"/>
			</td>
			<td>
				<select class="input_list" size="1" name="status_action" id="status_action">
					<option value="none"> </option>
					<option value="on"> enable</option>
					<option value="wait"> draft</option>
					<option value="off"> disable</option>
				</select>		
			</td>
			<td>
				<input type="submit" name="submit" id="submit" value="Применить" class="input">
			</td>
		</tr>
	</tbody>
</table>
</form>