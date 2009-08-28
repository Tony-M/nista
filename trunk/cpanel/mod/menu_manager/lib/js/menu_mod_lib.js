// функция листаетс страници контейнера меню в пагинаторе
function get_menu_list_by_page(page)
{
	prt_id = $('#prt_id').val();

	if(prt_id=="")return false;
	else
	{
		if(page != "")
		{		
			document.getElementById( 'main_div' ).innerHTML = jQuery.ajax({ type: "POST", url: "index.php", data: "p=menu&sp=get_ls_menu&prt_id="+prt_id+"&page="+page, async: false }).responseText;
			//alert("p=item&sp=get_ls_item&prt_id="+prt_id+"page="+page);
		}
		else
			return false;
	}
}


