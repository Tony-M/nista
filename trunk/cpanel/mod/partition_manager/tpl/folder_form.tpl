<h1>Менеджер по работе с разделами</h1>
<p>В основные функции модуля входит работа с разделами сайта</p><hr>

{if $DOCUMENT.MSG <> ""}<div class="sys_msg">{$DOCUMENT.MSG}</div>{/if}
{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}

<table>
	<tr>
		<td><a href="index.php?p=site" class="menu_action">Отменить</a></td>
		
		<td></td>
		
	</tr>
</table>
<table style="padding-top:10pt;">
	<tr>
		<td nowrap="nowrap"><b>Выбранный раздел:</b></td>
		<td nowrap="nowrap"><p>{$DOCUMENT.mod.data.partition_info.title}</p></td>
	</tr>
</table>

<input id="prt_id" name="prt_id" type="hidden" value="{$DOCUMENT.mod.data.partition_info.id}">
<div name="main_div" id="main_div">
{include file=$DOCUMENT.mod.data.sub_tpl_folder_list}
</div>
<input name="new_dir" id="new_dir" value="" type="text">
<input name="create" id="create" type="submit" class="input" value="Создать каталог" style="width:150px;" onclick="create_catalog(); return false;">