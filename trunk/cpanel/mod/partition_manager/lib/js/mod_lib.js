// Функция по включению/выключению наследования шаблона разделами
function inherit_template(inp) 
{
	if (inp )
	{
		
		$("#template").attr("disabled","disabled");
	}
   	else 
   	{
		$("#template").removeAttr("disabled");
   	}
}


// функция возвращает список подкаталогов для выбранного каталога
function get_folder_content(inp)
{
	document.getElementById( 'main_div' ).innerHTML = jQuery.ajax({ type: "POST", url: "index.php", data: "p=site&sp=ls_dir_ajax&path="+inp, async: false }).responseText;
}

function create_catalog()
{
	new_name = $('#new_dir').val();
	current_path = $('#current_path').val();
// alert(current_path);
	document.getElementById( 'main_div' ).innerHTML = jQuery.ajax({ type: "POST", url: "index.php", data: "p=site&sp=mkdir&current_path="+current_path+"&new_name="+new_name, async: false }).responseText;
	
}

function rm_catalog(catalog)
{
	if(confirm("Вы действительно хотите удалить каталог?"))	
	{
		if(catalog != "")
		{
			current_path = $('#current_path').val();
	//		alert(current_path);	
			document.getElementById( 'main_div' ).innerHTML = jQuery.ajax({ type: "POST", url: "index.php", data: "p=site&sp=rmdir&current_path="+current_path+"&rmdir_name="+catalog, async: false }).responseText;
		
		}
		else
			return false;
	}
	return false;
}


function create_catalog()
{
	new_name = $('#new_dir').val();
	current_path = $('#current_path').val();
// alert(current_path);
	document.getElementById( 'main_div' ).innerHTML = jQuery.ajax({ type: "POST", url: "index.php", data: "p=site&sp=mkdir&current_path="+current_path+"&new_name="+new_name, async: false }).responseText;
	
}

function link_path()
{
	path = $('input[name=selected_path]:checked').val();
	if(!path)path="";
	current_path = $('#current_path').val();
	id = $('#prt_id').val();
	
	document.getElementById( 'main_div' ).innerHTML = jQuery.ajax({ type: "POST", url: "index.php", data: "p=site&sp=link_path&current_path="+current_path+"&prt_id="+id+"&path="+path, async: false }).responseText;
	
}

function unlink_dir(id)
{
	if(id)
	{
		if(confirm("Вы действительно хотите удалить связь каталога с разделом?"))
		{
			current_path = $('#current_path').val();
			document.getElementById( 'main_div' ).innerHTML = jQuery.ajax({ type: "POST", url: "index.php", data: "p=site&sp=unlink_path&current_path="+current_path+"&prt_id="+id, async: false }).responseText;
		}
		
	}
	return false;
}