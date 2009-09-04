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


function clone_row(obj)
{
	var row = obj.parentNode.parentNode;
	$(row).clone().insertAfter($(row));
	$(row).next('tr').find('td:eq(1)').find('select').children().remove();
	$(row).next('tr').find('td:eq(1)').find('select').append('<option value=""></option>') ;	
}

function delete_row(obj) {
	var row_num = sumTR();
	if(row_num >1)
	{
    	var row = obj.parentNode.parentNode;
    	$(row).remove();
	}
}

function sumTR() 
{
	sum = -1;
	$('#tb_data tr').each(function() 
		{
			sum++;
		}
	);
	return sum;
} 


function get_zones(obj, opt_value)
{			
	obj.find('select').children().remove();
	obj.find('select').append('<option value=""></option>') ;

	if(opt_value != "")
	{		
		var otvet = jQuery.ajax({ type: "POST", url: "index.php", data: "p=menu&sp=get_zones&file="+opt_value, async: false }).responseText;
		obj.html(otvet);		
	}
	else
		return false;
	
}	