<h1>Список категорий для раздела "{$DOCUMENT.mod.data.partition_info.title}"</h1>
<form action="index.php?p=site&sp=rm_category" method="post" enctype="multipart/form-data">
<table width="100%" border="0">
	<tr>
		<td><a href="index.php?p=site"  class="menu_action">Отменить</a></td>
		
	</tr>
</table>

{if $DOCUMENT.MSG <> ""}<div class="sys_msg">{$DOCUMENT.MSG}</div>{/if}
{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}


<hr>
<h2>Список категорий</h2>
<table border="0" cellspacing="1" cellpadding="0" width="100%" class="table_body">
		<tr>			
			<td class="table_head" style="width:16px;">&nbsp;</td>
			<td class="table_head">Заглавие</td>
			<td class="table_head" style="width:32px;" colspan="2">&nbsp;</td>
		</tr>
		{section name=ctgr_num loop=$DOCUMENT.mod.data.category_list}
			<tr  onMouseOver="this.style.background='#F4FAFF'" onMouseOut="this.style.background='none'">
				<td class="td_body" style="width:16px;"><input type="checkbox" id="id[]" name="id[]" value="{$DOCUMENT.mod.data.category_list[ctgr_num].id}"></td>
				<td class="td_body">{$DOCUMENT.mod.data.category_list[ctgr_num].title}</td>
				<td class="td_body" style="width: 16px;"><a href="index.php?p=site&sp=edit_category&id={$DOCUMENT.mod.data.category_list[ctgr_num].id}"><img src="{$DOCUMENT.ACP_IMG_WAY}edit_16.png" width="16" height="16" alt="Редактировать" title="Редактировать" border="0"></a></td>
				<td class="td_body" style="width:16px;"><a href="index.php?p=site&sp=rm_category&id={$DOCUMENT.mod.data.category_list[ctgr_num].id}"><img src="{$DOCUMENT.ACP_IMG_WAY}delete.gif" width="16" height="16" border="0" alt="удалить" title="удалить"></a></td>
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
				<span>С отмеченными: </span>		
			</td>
			<td>
				<input type="image" src="{$DOCUMENT.ACP_IMG_WAY}delete_16x16.gif" title="Удалить" name="remove" id="remove">
			</td>
		</tr>
	</tbody>
</table>				

</form>