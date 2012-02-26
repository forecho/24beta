$(function(){
	var tip = $('#beta-admin-tip');
	if (tip.length == 0) {
		var html = '<div id="beta-admin-tip"></div>';
		$('body').append(html);
	}
	$(document).ajaxStart(function(){
		$('#beta-admin-tip').html('sending...').fadeIn('fast');
	});
	
	$(document).ajaxSuccess(function(){
		$('#beta-admin-tip').html('Success.');
	});
	
	$(document).ajaxError(function(){
		$('#beta-admin-tip').html('Error.');
	});
	
	$(document).ajaxStop(function(){
		$('#beta-admin-tip').html('done.');
	});
});