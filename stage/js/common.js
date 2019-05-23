// JavaScript Document
var error	=	0;
function displaysuccess(id)
{
	$('#'+id).html('<div class="tick_icon"><img src="includes/images/blue_tick.png" width="12" height="12" /></div>');
	error = 0;
}
function displayerror(id,msg)
{
	$('#'+id).html('<div class="form_table_col1"><div class="tickred_icon"><img src="includes/images/red_arrwo.png" width="12" height="12" /></div><div class="error_text">'+msg+'</div></div></div>');
	error =	1;
}