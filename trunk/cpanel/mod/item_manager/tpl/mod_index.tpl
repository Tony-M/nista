<h1>Менеджер по работе со статьями сайта</h1>
<p>В основные функции модуля входит работа с основным контентом сайта - статьями</p><hr>

{if $DOCUMENT.MSG <> ""}<div class="sys_msg">{$DOCUMENT.MSG}</div>{/if}
{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}

<table>
	<tr>
		<td><a href="index.php?p=item" class="menu_action" onclick="refresh_item_list(); return false;">Обновить</a></td>
		<td><a href="" onclick="add_item();return false;" class="menu_action">Добавить статью</a></td>
		
		<td></td>
		
	</tr>
</table>
<table style="padding-top:10pt;">
	<tr>
		<td nowrap="nowrap"><b>Статистика:</b></td>
		<td nowrap="nowrap"><p>Количество статей: {$DOCUMENT.mod.data.total_item_num}</p></td>
	</tr>
</table>

<form method="POST" enctype="multipart/form-data" id="frm_item_list" name="frm_item_list" action="index.php?p=item&sp=update_item_status">
<h2>Список статей сайта для раздела</h2>

<select name="owner_partition" id="owner_partition" style="width:100%;" class="input" onchange="get_item_list(this.options[this.selectedIndex].value);">
	{section name=prt_num loop=$DOCUMENT.mod.data.partition_tree}
		<option value="{$DOCUMENT.mod.data.partition_tree[prt_num].id}" {if $DOCUMENT.mod.data.partition_tree[prt_num].id == $DOCUMENT.mod.data.ptr_id}selected style="font-weight:bold;"{/if}>|-{$DOCUMENT.mod.data.partition_tree[prt_num].tab_char}{$DOCUMENT.mod.data.partition_tree[prt_num].title}</option>
	{/section}
</select><br><br>
<div name="main_div" id="main_div">
{include file=$DOCUMENT.mod.data.sub_tpl}
</div>
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