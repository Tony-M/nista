var ajax_task_num = 0; // количество запросов ajax к серверу в данный момент времени
var ajax_task_indicator_visible = 0 // флаг отображения индикатора ajax запросов 0 - hidden 1 - visible

function add_ajax_task()
{
	
	ajax_task_num++;
	
	refresh_ajax_activity();
}

function refresh_ajax_activity()
{
	document.getElementById( 'div_ajax_num' ).innerHTML = ajax_task_num;
	document.getElementById( 'div_ajax_text' ).innerHTML = "Процессов выполняется";
	
	if((!ajax_task_indicator_visible) && (ajax_task_num))
	{
		show_ajax_activity_indicator();		
	}
	
	if((ajax_task_indicator_visible) && (ajax_task_num==0))
	{
		hide_ajax_activity_indicator();
	}
}

function show_ajax_activity_indicator()
{
	if(!ajax_task_indicator_visible)
	{
		ajax_task_indicator_visible=1;
		$('#div_ajax_activity').show(2);
	}
}

function hide_ajax_activity_indicator()
{
	if(ajax_task_indicator_visible)
	{
		ajax_task_indicator_visible=0;
		$('#div_ajax_activity').hide(2);
	}
}

function remove_ajax_task()
{
	if(ajax_task_num>0)
		ajax_task_num--;
	refresh_ajax_activity()
}

function drop_all_ajax_task()
{
	ajax_task_num==0
	refresh_ajax_activity();
}