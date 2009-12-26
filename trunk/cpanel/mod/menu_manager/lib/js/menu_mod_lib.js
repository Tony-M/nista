

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
		var otvet = jQuery.ajax({ type: "POST", url: "index.php", data: "p=menu&sp=get_zones&prt_id="+opt_value, async: false }).responseText;
		obj.html(otvet);		
	}
	else
		return false;
	
}	
// функция добавляет в таблицу привязку к меню по всем его разделам сразу
function append_menu_item_table(partition_id)
{
	var menu_title = $('#menu_list option:selected').text();
	var menu_id = parseInt($('#menu_list option:selected').val());
	
	if(menu_title == "")return false;
	if(menu_id == 0)return false;
	
	var flag =0;

	$('#menu_form input[name=mc_id[]]').each(function(n,element)
	{  
		if($(element).val()==menu_id)flag=1;
    });

	if(flag)
	{
		alert ("Данное меню уже выбрано");
		return false;
	}
	
	var new_row = "";
	new_row = '<tr>';
	new_row += '<td style="width:40px; height:16px;" align="center" valign="top"><input id="remove_row" type="image" onclick="delete_row_from_link_table(this); return false;" src="tpl/img/minus.gif" name="remove_row"/></td>';
	new_row += '<td valign="middle"><input type="hidden" name="mc_id[]" id="mc_id[]" maxlength="11" value="'+menu_id+'"><span>'+menu_title+'</span></td>';
	new_row += '<td valign="top"><input type="hidden" name="mc_prt_id[]" id="mc_prt_id[]" maxlength="11" value="0"><span>Все разделы</span></td>';
	new_row += '<td valign="top"><select id="it_status[]" name="it_status[]" class="input_nw"><option value="off" selected>Отключён</option><option value="wait">Черновик</option><option value="on">Активен</option></select></td>';
	new_row += '</tr>';
	
	$("#link_table").append(new_row);
	
}

//функция добавляет в таблицу привязку к меню определённого размера
function append_menu_item_table_for_selected_prt()
{
	var menu_title = $('#prt_menu_list option:selected').text();
	var menu_id = parseInt($('#prt_menu_list option:selected').val());
	var partition_title = $('#prt_id option:selected').text();
	var partition_id = parseInt($('#prt_id option:selected').val());
	
	if(menu_title == "")return false;
	if(menu_id == 0)return false;
	
	var flag =0;
	
	$('#menu_form input[name=mc_id[]]').each(function(n,element)
	{  
		if($(element).val()==menu_id)
		{
			
			var in_table_prt_id = $('#menu_form input[name=mc_prt_id[]]').eq(n).val();
			
			if(in_table_prt_id == 0)
			{
				alert("Данное меню уже выбрано и привязано ко всем разделам");
				flag = 1;
				return false;
			}
			
			if(in_table_prt_id == partition_id)
			{
				flag = 1;
				alert("Данное меню уже выбрано и привязано к данному разделу");
				return false;
			}
		}
    });

    if(!flag)
    {
		var new_row = "";
		new_row = '<tr>';
		new_row += '<td style="width:40px; height:16px;" align="center" valign="top"><input id="remove_row" type="image" onclick="delete_row_from_link_table(this); return false;" src="tpl/img/minus.gif" name="remove_row"/></td>';
		new_row += '<td valign="middle"><input type="hidden" name="mc_id[]" id="mc_id[]" maxlength="11" value="'+menu_id+'"><span>'+menu_title+'</span></td>';
		new_row += '<td valign="top"><input type="hidden" name="mc_prt_id[]" id="mc_prt_id[]" maxlength="11" value="' + partition_id + '"><span>'+ partition_title +'</span></td>';
		new_row += '<td valign="top"><select id="it_status[]" name="it_status[]" class="input_nw"><option value="off" selected>Отключён</option><option value="wait">Черновик</option><option value="on">Активен</option></select></td>';
		new_row += '</tr>';
		
		$("#link_table").append(new_row);
    }
}

function delete_row_from_link_table(obj) {
	var row_num = -1;
	
	$('#link_table tr').each(function() 
		{
			row_num++;
		}
	);
	
	if(row_num >0)
	{
    	var row = obj.parentNode.parentNode;
    	$(row).remove();
	}
 
	return false;
}

function get_menu_list_for_partition(inp)
{
	var prt_id = parseInt(inp);
	
	
	$("#prt_menu_list").attr("disabled","disabled");
	$('#prt_menu_list').children().remove();
	
	var param = "p=menu&sp=get_prt_menu&id="+prt_id;
	
	if(prt_id)
	{
		add_ajax_task();
		
		var result= "";
		
		$.ajax({ type: "GET", url: "index.php", data: ""+param, dataType: "xml", success: function(xml) 
		{	
			//alert("ok");
			$(xml).find('item').each(function()
			{ 
				var title = $(this).attr('title');
				var id = $(this).attr('id');
				var comment = $(this).attr('comment');
				result = result + '<option value="' + id + '" title="' + comment + '">' + title + '</option>';
			});
		
		$("#prt_menu_list").removeAttr("disabled");
		$('#prt_menu_list').children().remove();
		$('#prt_menu_list').append('<option value=""></option>') ;
		$('#prt_menu_list').append(result) ;
		$('#prt_menu_list option:first').attr('selected', 'selected');
		}, complete: function(){remove_ajax_task()}
		
		});
		
		
		
	}
	else
	{
		
	}
}

function get_partitions_for_item(id , obj)
{
	$('#div_prt_list').html("");
	if(id)
	{		
		var param = "p=menu&sp=get_item_prt&it_id="+id;
		
		add_ajax_task();
		var otvet = jQuery.ajax({ type: "POST", url: "index.php", data: param,  async: false , complete: function(){remove_ajax_task()}}).responseText;
		
		$('#div_prt_list').html(otvet);
		mark_row(obj);
	}
}

function mark_row(obj)
{
	var row = obj.parentNode.parentNode;
	var row_num = -1;
    $('#item_table_tr tr').each(function() 
		{
			row_num++; 
			var find_num = 'tr:eq('+row_num+')'
			if(row_num > 0)
			{
				var tr = $('#item_table_tr').find(find_num);
				
				$(tr).removeClass("tr_selected");
				$(tr).addClass("tr");
				
			}
			
		}
	);

	$(row).removeClass("tr");
	$(row).addClass("tr_selected");
}

//функция обновляет статус выбранного relation меню по его id и изменяет картинку статуса
function update_rid_status(status , rid, obj)
{
	var param = "p=menu&sp="
	var otvet = jQuery.ajax({ type: "POST", url: "index.php", data: param,  async: false , complete: function(){remove_ajax_task()}}).responseText;
	
	
	
	
}
/*
function get_xml_city_range(inp)
{
	//var response = jQuery.ajax({ type: "POST", url: "index.php", data: "action=get_city_range&cid="+inp, dataType: "xml", }).responseText;
	//alert(inp);
	$('#ajax_img_1').show(2);
	$("#city").attr("disabled","disabled");
	$('#city').children().remove();
	
	var param = "action=get_city_range&cid="+inp;
	if(inp != "")
	{		
		var result = "";
		$.ajax({ type: "GET", url: "index.php", data: "action=get_city_range&cid="+inp, dataType: "xml", success: function(xml) 
		{	
			//alert("ok");
			$(xml).find('item').each(function()
			{ 
				var title = $(this).attr('title');
				var id = $(this).attr('kay');
				result = result + '<option value="' + id + '">' + title + '</option>';
			});
		
		$("#city").removeAttr("disabled");
		$('#newcity').val("");
		$("#newcity").attr("disabled","disabled");
		$("#ocity").removeAttr("checked");
		$("#ocity").removeAttr("disabled");
		$('#city').children().remove();
		$('#city').append('<option value=""></option>') ;
		$('#city').append(result) ;
		$('#city option:first').attr('selected', 'selected');
		}, complete: function(){$('#ajax_img_1').hide(2);}
		
		});
	}
	else
	{  //alert ("Shit happens. Keep smiling!!")
		$("#city").attr("disabled","disabled");
		$("#ocity").attr("disabled","disabled");
		$('#newcity').val("");
		$("#newcity").attr("disabled","disabled");
		$("#ocity").removeAttr("checked");
		$('#ajax_img_1').hide(2);
	}
	
}	
*/