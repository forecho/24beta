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

var BetaAdmin = {
	deletePost: function(event){
		event.preventDefault();

		var confirm = window.confirm(event.data.onfirmText);
	    if (!confirm) return ;
		
		var tthis = $(this);
		var jqXhr = $.ajax({
		    url: $(this).attr('href'),
		    dataType: 'jsonp',
		    type: 'post',
		    cache: false,
		    beforeSend: function(){}
		});
		jqXhr.done(function(data){
			if (data.errno == 0)
				tthis.parents('tr').fadeOut('fast', function(){$(this).remove();});
			else
				alert('error');
		});
		jqXhr.fail(function(){
			alert('fail');
		});
	},
	ajaxSetPostBoolColumn: function(event) {
		event.preventDefault();
		var tthis = $(this);
		var jqXhr = $.ajax({
		    url: $(this).attr('href'),
		    dataType: 'jsonp',
		    type: 'post',
		    cache: false,
		    beforeSend: function(){}
		});
		jqXhr.done(function(data){
			if (data.errno == 0)
			    tthis.text(data.label);
			else
				alert('error');
		});
		jqXhr.fail(function(){
			alert('fail');
		});
	}
};