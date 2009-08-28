<table cellpadding="5" cellspacing="2" bgcolor="#ffffff" >
<tr>
<td></td>
{if $DOCUMENT.mod.data.menu_page_list.first <> ""}<td><a href="" onclick="get_menu_list_by_page({$DOCUMENT.mod.data.menu_page_list.first});return false;"> В начало </a></td>{/if}
{if $DOCUMENT.mod.data.menu_page_list.show_left_dots == "1"}<td><a>...</a></td>{/if}
{if $DOCUMENT.mod.data.menu_page_list.previous != ""}<td><a href="" onclick="get_menu_list_by_page({$DOCUMENT.mod.data.menu_page_list.previous});return false;">Предыдущая </a></td>{/if}

{section name=pg_list_num loop=$DOCUMENT.mod.data.menu_page_list.pg_list}
<td>{if $DOCUMENT.mod.data.menu_page_list.pg_list[pg_list_num] == $DOCUMENT.mod.data.menu_page_list.current_pg}<b>{/if}<a href="" onclick="get_menu_list_by_page({$DOCUMENT.mod.data.menu_page_list.pg_list[pg_list_num]});return false;">{$DOCUMENT.mod.data.menu_page_list.pg_list[pg_list_num]}</a>{if $DOCUMENT.mod.data.menu_page_list.pg_list[pg_list_num] == $DOCUMENT.mod.data.menu_page_list.current_pg}</b>{/if}</td>
{/section}

{if $DOCUMENT.mod.data.menu_page_list.next != ""}<td><a href="" onclick="get_menu_list_by_page({$DOCUMENT.mod.data.menu_page_list.next});return false;">Следующая </a></td>{/if}
{if $DOCUMENT.mod.data.menu_page_list.show_right_dots == "1"}<td><a>...</a></td>{/if}
{if $DOCUMENT.mod.data.menu_page_list.last != ""}<td><a href="" onclick="get_menu_list_by_page({$DOCUMENT.mod.data.menu_page_list.last}); return false;">В конец </a></td>{/if}
</tr>
</table>
