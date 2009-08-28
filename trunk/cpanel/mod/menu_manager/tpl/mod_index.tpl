<h1>Менеджер по работе меню</h1>
<p>В задачи модуля входит работа с меню сайта</p><hr>

{if $DOCUMENT.MSG <> ""}<div class="sys_msg">{$DOCUMENT.MSG}</div>{/if}
{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}

<table>
	<tr>
		<td><a href="index.php?p=menu" class="menu_action" onclick="refresh_menu_list(); return false;">Обновить</a></td>
		<td><a href="index.php?p=menu&sp=add_menu" class="menu_action">Создать меню</a></td>
		
		<td></td>
		
	</tr>
</table>
<table style="padding-top:10pt;">
	<tr>
		<td nowrap="nowrap"><b>Статистика:</b></td>
		<td nowrap="nowrap"><p>Количество меню: {$DOCUMENT.mod.data.total_menu_num}</p></td>
	</tr>
</table>

<form method="POST" enctype="multipart/form-data" id="frm_menu_list" name="frm_menu_list" action="index.php?p=menu&sp=update_menu_status">
<h2>Список меню сайта</h2>
<select name="owner_partition" id="owner_partition" style="width:100%;" class="input" onchange="get_item_list(this.options[this.selectedIndex].value);">
	<option value="0" {if $DOCUMENT.mod.data.ptr_id=='0'}selected style="font-weight:bold;"{/if}>Все меню</option>
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