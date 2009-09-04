<select name="zone_name[]" id="zone_name[]" class="input">
	<option value=""></option>
	{section name=z_num loop=$DOCUMENT.mod.data.info_zones}
		<option value="{$DOCUMENT.mod.data.info_zones[z_num].name}">{$DOCUMENT.mod.data.info_zones[z_num].title}</option>
	{/section}
</select>