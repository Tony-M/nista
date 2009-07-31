
// функция возвращает список статей для данного раздела
function get_item_list(inp)
{
	//var response = jQuery.ajax({ type: "POST", url: "index.php", data: "action=get_city_range&cid="+inp, dataType: "xml", }).responseText;
	//alert(response);
	if(inp != "")
	{		
		document.getElementById( 'main_div' ).innerHTML = jQuery.ajax({ type: "POST", url: "index.php", data: "p=item&sp=get_ls_item&prt_id="+inp, async: false }).responseText;

	}
	else
		return false;
	
}	
// функция обновления содержимого списка статей
function refresh_item_list()
{
	inp = $('#prt_id').val();

	if(inp=="")return false;
	else
	{
		get_item_list(inp);
	}
}
// функция листаетс страници статей в пагинаторе
function get_item_list_by_page(page)
{
	inp = $('#prt_id').val();

	if(inp=="")return false;
	else
	{
		if(page != "")
		{		
			document.getElementById( 'main_div' ).innerHTML = jQuery.ajax({ type: "POST", url: "index.php", data: "p=item&sp=get_ls_item&prt_id="+inp+"&page="+page, async: false }).responseText;
			//alert("p=item&sp=get_ls_item&prt_id="+inp+"page="+page);
		}
		else
			return false;
	}
}



//функция подгружает категории для выбранного раздела при создании\редактировании стаьи
function get_category_for_partition(inp)
{
	//var response = jQuery.ajax({ type: "POST", url: "index.php", data: "action=get_city_range&cid="+inp, dataType: "xml", }).responseText;
	//alert(response);
	var param = "p=item&sp=get_ls_category&prt_id="+inp;
	if(inp != "")
	{	
		$('#category_id').children().remove();
		$('#category_id').append('<option value="0"></option>') ;	
		
		var result = "";
		$.ajax({ type: "GET", url: "index.php", data: "p=item&sp=get_ls_category&prt_id="+inp, dataType: "xml", success: function(xml) 
		{	
			$(xml).find('item').each(function()
			{ 
				var title = $(this).attr('title');
				var id = $(this).attr('kay');
				result = result + '<option value="' + id + '">' + title + '</option>';
			});
		
		if(result != "")
		{
			$("#category_id").removeAttr("disabled");
			
			$('#category_id').append(result) ;
			$('#category_id option:first').attr('selected', 'selected');
		}
		else
			$("#category_id").attr("disabled","disabled");		
		}
		});
	}
	else
	{
		$("#category_id").attr("disabled","disabled");
	}
	
}

function add_item()
{
	document.location.href = "index.php?p=item&sp=add_item&prt_id="+$("#prt_id").val();
}

function delete_item(id)
{
	if(confirm("Уверены, что хотите удалить статью?"))
	{
		document.location.href = "index.php?p=item&sp=rm_item&item_id="+id+"&prt_id="+$("#prt_id").val();	
	}
	
}