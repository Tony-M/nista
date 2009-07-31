<h1>{if $MOD_ACTION=="create_partition"}Создание{else}Редактирование данных{/if} раздела сайта</h1>
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
			<table>
				<tr>
					<td><span>Заглавие раздела :</span></td>
				</tr>
				<tr>
					<td>
						<input type="text" name="title" id="title" value="{$DOCUMENT.mod.data.partition_info.title}" class="input" style="width:100%;">
						<input type="hidden" id="prt_id" name="prt_id" value="{$DOCUMENT.mod.data.partition_info.id}">
					</td>			
				</tr>
				<tr>
					<td><span>Описание раздела :</span></td>
				</tr>
				<tr>
					<td><textarea id="text" name="text" rows="20" cols="50" style="width:100%">{$DOCUMENT.mod.data.partition_info.text}</textarea></td>			
				</tr>
				
				<tr>
					<td><input type="submit" value="Сохранить"></td>
				</tr>
			</table>		
		</td>
		<td style="width:300px;" valign="top"  class="form_area">
			<table width="100%">
				<tr>
					<td colspan="2"><span>Ключевые слова<span></td>
				</tr>
				<tr>
					<td colspan="2"><textarea id="meta_keyword" name="meta_keyword" class="input" style="width:100%;">{$DOCUMENT.mod.data.partition_info.meta_keyword}</textarea></td>
				</tr>
				<tr>
					<td colspan="2"><span>Описание</span></td>
				</tr>
				<tr>
					<td colspan="2"><textarea id="meta_description" name="meta_description" class="input" style="width:100%;">{$DOCUMENT.mod.data.partition_info.meta_description}</textarea></td>
				</tr>
				<tr>
					<td colspan="2"><span>Сделать подразделом:</span></td>
				</tr>
				<tr>
					<td colspan="2">
						<select name="subpart" id="subpart" style="width:100%;" class="input">
							{section name=prt_num loop=$DOCUMENT.mod.data.partition_tree}
								<option value="{$DOCUMENT.mod.data.partition_tree[prt_num].id}" {if $DOCUMENT.mod.data.partition_tree[prt_num].id == $DOCUMENT.mod.data.partition_info.pid}selected style="font-weight:bold;"{/if}>|-{$DOCUMENT.mod.data.partition_tree[prt_num].tab_char}{$DOCUMENT.mod.data.partition_tree[prt_num].title}</option>
							{/section}
						</select>
					</td>
				</tr>
				<tr>
					<td><span>Наследовать шаблон:</span></td>
					<td>
						<input type="checkbox" name="inherit_tpl" id="inherit_tpl" value="yes"  onclick="inherit_template(this.checked);">
					</td>
				</tr>
				<tr>
					<td><span>Шаблон раздела:</span></td>
					<td>
						<select id="template" name="template" class="input">
							{section name=tpl_num loop=$DOCUMENT.mod.data.template_list}
								<option value="{$DOCUMENT.mod.data.template_list[tpl_num].file}"  {if $DOCUMENT.mod.data.template_list[tpl_num].file == $DOCUMENT.mod.data.partition_info.template}selected style="font-weight:bold;"{/if}>{$DOCUMENT.mod.data.template_list[tpl_num].title}</option>
							{/section}
						</select>
					</td>
				</tr>
				<tr>
					<td align="right"  nowrap="nowrap"><span>Публиковать:</span></td>
					<td width="90%"><input type="checkbox" value="on" name="publish" id="publish" {if $DOCUMENT.mod.data.partition_info.status=="on"}checked{/if}></td>
				</tr>
				<tr>
					<td align="right" nowrap="nowrap"><span>Уровень доступа:</span></td>
					<td width="90%">
						<select class="input_list" name="access_level" id="access_level">
							{foreach from=$DOCUMENT.POST_LIST key=post_list_title item=post_list_id}	
								<option value="{$post_list_id}" {if $post_list_id == $DOCUMENT.mod.data.partition_info.access_level}selected style="font-weight:bold;"{/if}>{$post_list_title}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td align="right"  nowrap="nowrap"><span>Псевдоним автора:</span></td>
					<td width="90%"><input type="text" name="penname" id="penname" value="{$DOCUMENT.mod.data.partition_info.penname}" class="input" maxlength="255"></td>
				</tr>
				
				<tr>
					<td></td>
					<td></td>
				</tr><tr>
					<td></td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</form>