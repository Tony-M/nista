<h1>{if $MOD_ACTION=="create_category"}Создание{else}Редактирование данных{/if} категории</h1>
<form action="index.php?p=site&sp={$MOD_ACTION}" method="post" enctype="multipart/form-data">
<table width="100%" border="0">
	<tr>
		<td><a href="index.php?p=site"  class="menu_action">Отменить</a></td>
		<td align="right"><input type="image" src="{$DOCUMENT.ACP_IMG_WAY}btn_save.gif" name="btn_submit_img" title="Сохранить"></td>
	</tr>
</table>

{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}

<hr>
<table width="100%" cellpadding="0"	 cellspacing="2" background="1" style="width:100%">
	<tr>
		<td valign="top" class="form_area">
			<table width="100%">
				<tr>
					<td><span>Заглавие раздела :</span></td>
				</tr>
				<tr>
					<td>
						<input type="text" name="title" id="title" value="{$DOCUMENT.mod.data.category_info.title}" class="input" style="width:100%;">
						<input type="hidden" id="ctgr_id" name="ctgr_id" value="{$DOCUMENT.mod.data.category_info.id}">
					</td>			
				</tr>
				<tr>
					<td colspan="2"><span>Раздел категории:</span></td>
				</tr>
				<tr>
					<td colspan="2">
						{if $MOD_ACTION=="create_category"}
						<select name="subpart" id="subpart" style="width:100%;" class="input">
							{section name=prt_num loop=$DOCUMENT.mod.data.partition_tree}
								<option value="{$DOCUMENT.mod.data.partition_tree[prt_num].id}" {if $DOCUMENT.mod.data.partition_tree[prt_num].id == $DOCUMENT.mod.data.category_info.prt_id}selected style="font-weight:bold;"{/if}>|-{$DOCUMENT.mod.data.partition_tree[prt_num].tab_char}{$DOCUMENT.mod.data.partition_tree[prt_num].title}</option>
							{/section}
						</select>
						{else}
							<input type="text" value="{$DOCUMENT.mod.data.partition_info.title}" class="input" disabled>
						{/if}
					</td>
				</tr>
				
				<tr>
					<td><br><input type="submit" value="Сохранить"></td>
				</tr>
			</table>		
		</td>
	</tr>
</table>
					

</form>