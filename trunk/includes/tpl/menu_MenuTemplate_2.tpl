<table width="100%" border="1">
	<tr>
		{if $MENU_CONTAINER.show_title=='1'}<td>{$MENU_CONTAINER.title}</td>{/if}
		{section name=mi_num loop=$MENU_ITEMS}
			<td><a href="{$MENU_ITEMS[mi_num].url}">{$MENU_ITEMS[mi_num].title}</a></td>
		{/section}
	</tr>
</table>