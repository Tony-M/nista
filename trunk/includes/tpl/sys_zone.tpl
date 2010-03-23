{section name=zone_num loop=$DOCUMENT.zone_content}
	{if $DOCUMENT.zone_content[zone_num].title == $zone_name}
		{section name=value_num loop=$DOCUMENT.zone_content[zone_num].value.menu_container}
			{if $DOCUMENT.zone_content[zone_num].value.menu_container[value_num].tpl_file != ''}
				{assign var="MENU_CONTAINER" value=$DOCUMENT.zone_content[zone_num].value.menu_container[value_num]}
				{assign var="MENU_ITEMS" value=$DOCUMENT.zone_content[zone_num].value.menu_container[value_num].items}
				{include file= $MENU_CONTAINER.tpl_file}
			{/if}
		{/section}
	{/if}
{/section}