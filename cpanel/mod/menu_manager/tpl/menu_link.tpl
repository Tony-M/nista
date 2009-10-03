<h1>Привязка меню к разделам сайта</h1>
<a href="index.php?p=menu"  class="menu_action">Отменить</a>
<hr>
{if $DOCUMENT.ERR_MSG <> ""}<div class="sys_err_msg">{$DOCUMENT.ERR_MSG}</div>{/if}
{if $DOCUMENT.MSG <> ""}<div class="sys_msg">{$DOCUMENT.MSG}</div>{/if}
<form action="index.php?p=menu&sp={$MOD_ACTION}" method="post" enctype="multipart/form-data">
<input type="hidden" value="{$DOCUMENT.mod.data.menu_id}" maxlength="11" name="menu_id" id="menu_id">
	<table width="100%">
		<tr>
			<td class="form_area">
			<input type="submit" value="Сохранить">
			<table border="0" cellspacing="1" cellpadding="0" width="100%" id="tb_data" name="tb_data">
				<tr>
					<td class="table_head">Раздел</td>
					<td class="table_head">Информационная зона</td>
					<td class="table_head">Шаблон меню</td>
					<td class="table_head">Действия</td>
				</tr>
				<tr>
					<td class="td_body">
						<select id="prt_id[]" name="prt_id[]"  class="input" onchange="get_zones($(this).parent().next(), this.options[this.selectedIndex].value );">
							<option value="0"></option>
							{section name=prt_num loop=$DOCUMENT.mod.data.partition_tree}
								<option value="{$DOCUMENT.mod.data.partition_tree[prt_num].id}">|-{$DOCUMENT.mod.data.partition_tree[prt_num].tab_char}{$DOCUMENT.mod.data.partition_tree[prt_num].title}</option>
								{/section}
						</select>
					</td>
					<td class="td_body"><select name="zone_name[]" id="zone_name[]" class="input">
				<option value=""></option></select>
						
					</td>
					<td class="td_body">
						<select id="menu_tpl[]" name="menu_tpl[]"  class="input">
							<option value="0"></option>
							{section name=menu_tpl_num loop=$DOCUMENT.mod.data.menu_tpl_list}
								<option value="{$DOCUMENT.mod.data.menu_tpl_list[menu_tpl_num].file}" title="{$DOCUMENT.mod.data.menu_tpl_list[menu_tpl_num].description}">{$DOCUMENT.mod.data.menu_tpl_list[menu_tpl_num].title}</option>
							{/section}
						</select>
					</td>
					<td class="td_body" align="center">
						<input type="image" name="clone_row" id="clone_row" src="{$DOCUMENT.ACP_IMG_WAY}plus.gif" onclick="clone_row(this);return false;">
						<input type="image" name="remove_row" id="remove_row" src="{$DOCUMENT.ACP_IMG_WAY}minus.gif" onclick="delete_row(this);return false;">
					</td>					
				</tr>
				
				{section name=link_num loop=$DOCUMENT.mod.data.menu_links}
				
				<tr>
					<td class="td_body">
						<select id="prt_id[]" name="prt_id[]"  class="input" onchange="get_zones($(this).parent().next(), this.options[this.selectedIndex].value );">
							<option value="0"></option>
							{section name=prt_num loop=$DOCUMENT.mod.data.partition_tree}
								<option value="{$DOCUMENT.mod.data.partition_tree[prt_num].id}"{if $DOCUMENT.mod.data.partition_tree[prt_num].id==$DOCUMENT.mod.data.menu_links[link_num].prt_id}selected style="font-weight:bold;"{/if}>|-{$DOCUMENT.mod.data.partition_tree[prt_num].tab_char}{$DOCUMENT.mod.data.partition_tree[prt_num].title}</option>
							{/section}
						</select>
					</td>
					<td class="td_body">
						<select name="zone_name[]" id="zone_name[]" class="input">
							<option value=""></option>
							{section name=zone_num loop=$DOCUMENT.mod.data.menu_links[link_num].zones_list}	
								<option value="{$DOCUMENT.mod.data.menu_links[link_num].zones_list[zone_num].name}" title="{$DOCUMENT.mod.data.menu_links[link_num].zones_list[zone_num].description}" {if $DOCUMENT.mod.data.menu_links[link_num].zones_list[zone_num].name==$DOCUMENT.mod.data.menu_links[link_num].zone_name}selected style="font-weight:bold"{/if}>{$DOCUMENT.mod.data.menu_links[link_num].zones_list[zone_num].title}</option>
							{/section}
						</select>
						
					</td>
					<td class="td_body">
						<select id="menu_tpl[]" name="menu_tpl[]"  class="input">
							<option value="0"></option>
							{section name=menu_tpl_num loop=$DOCUMENT.mod.data.menu_tpl_list}
								<option value="{$DOCUMENT.mod.data.menu_tpl_list[menu_tpl_num].file}" {if $DOCUMENT.mod.data.menu_tpl_list[menu_tpl_num].file==$DOCUMENT.mod.data.menu_links[link_num].tpl_file}selected style="font-weight:bold;"{/if} title="{$DOCUMENT.mod.data.menu_tpl_list[menu_tpl_num].description}">{$DOCUMENT.mod.data.menu_tpl_list[menu_tpl_num].title}</option>
							{/section}
						</select>
					</td>
					<td class="td_body" align="center">
						<input type="image" name="clone_row" id="clone_row" src="{$DOCUMENT.ACP_IMG_WAY}plus.gif" onclick="clone_row(this);return false;">
						<input type="image" name="remove_row" id="remove_row" src="{$DOCUMENT.ACP_IMG_WAY}minus.gif" onclick="delete_row(this);return false;">
					</td>					
				</tr>
				
				{/section}
				
				
			</table>
			<input type="submit" value="Сохранить">
			</td>
		</tr>
	</table>
	
</form>
<p class="comment"><span class="red">*</span> - Поля обязательные к заполнению.</p>