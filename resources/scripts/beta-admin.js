$(function(){
	var tip = $('#beta-admin-tip');
	if (tip.length == 0) {
		var html = '<div id="beta-admin-tip"></div>';
		$('body').append(html);
	}
	$(document).ajaxStart(function(){
		tip.html('sending...').fadeIn('fast');
	});
	
	$(document).ajaxSuccess(function(){
		tip.html('Success.');
	});
	
	$(document).ajaxError(function(){
		tip.html('Error.');
	});
	
	$(document).ajaxStop(function(){
		tip.html('done.');
	});
});

var BetaAdmin = {
	showAjaxMessage: function(text){
		if (text.length > 0) {
			$('#beta-admin-tip').html(text);
		}
	},
	selectAll: function(event){
		var checked = ($(':checkbox:not(:checked)').length > 0) ? true : false;
		$(':checkbox').attr('checked', checked);
	},
	reverseSelect: function(event) {
		$(':checkbox').each(function(index, element){
			$(element).attr('checked', !$(element).attr('checked'));
		});
	},
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
	deleteComment: function(event) {
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
				tthis.parents('tr').remove();
			else
				BetaAdmin.showAjaxMessage('error');
		});
		jqXhr.fail(function(){
			BetaAdmin.showAjaxMessage('fail');
		});
	},
	deleteMultiComments: function(event) {
		event.preventDefault();
		
		var checkboxs = $('input:checked');
		if (checkboxs.length == 0) return;
		
		var confirm = window.confirm(event.data.onfirmText);
		if (!confirm) return ;
		
		var commentIds = [];
		checkboxs.each(function(index, element){
			commentIds.push($(element).val());
		});

		var tthis = $(this);
		var jqXhr = $.ajax({
			url: $(this).attr('data-src'),
			dataType: 'jsonp',
			type: 'post',
			cache: false,
			data: $.param({ids:commentIds}),
			beforeSend: function(){}
		});
		jqXhr.done(function(data){
			$.each(data.success, function(index, value){
				$(':checkbox[value='+ value +']').parents('tr').remove();
			});
		}),
		jqXhr.fail(function(){
			BetaAdmin.showAjaxMessage('fail');
		});
	},
	verifyMultiComments: function(event) {
		event.preventDefault();
		
		var checkboxs = $('input:checked');
		if (checkboxs.length == 0) return;
		
		var commentIds = [];
		checkboxs.each(function(index, element){
			commentIds.push($(element).val());
		});
		
		var tthis = $(this);
		var jqXhr = $.ajax({
			url: $(this).attr('data-src'),
			dataType: 'jsonp',
			type: 'post',
			cache: false,
			data: $.param({ids:commentIds}),
			beforeSend: function(){}
		});
		jqXhr.done(function(data){
			$.each(data.success, function(index, value){
				$(':checkbox[value='+ value +']').parents('tr').remove();
			});
		}),
		jqXhr.fail(function(){
			BetaAdmin.showAjaxMessage('fail');
		});
	},
	recommendMultiComments: function(event) {
		event.preventDefault();
		
		var checkboxs = $('input:checked');
		if (checkboxs.length == 0) return;
		
		var commentIds = [];
		checkboxs.each(function(index, element){
			commentIds.push($(element).val());
		});
		
		var tthis = $(this);
		var jqXhr = $.ajax({
			url: $(this).attr('data-src'),
			dataType: 'jsonp',
			type: 'post',
			cache: false,
			data: $.param({ids:commentIds}),
			beforeSend: function(){}
		});
		jqXhr.done(function(data){
			$.each(data.success, function(index, value){
				$(':checkbox[value='+ value +']').parents('tr').remove();
			});
		}),
		jqXhr.fail(function(){
			BetaAdmin.showAjaxMessage('fail');
		});
	},
	hottestMultiComments: function(event) {
		event.preventDefault();
		
		var checkboxs = $('input:checked');
		if (checkboxs.length == 0) return;
		
		var commentIds = [];
		checkboxs.each(function(index, element){
			commentIds.push($(element).val());
		});
		
		var tthis = $(this);
		var jqXhr = $.ajax({
			url: $(this).attr('data-src'),
			dataType: 'jsonp',
			type: 'post',
			cache: false,
			data: $.param({ids:commentIds}),
			beforeSend: function(){}
		});
		jqXhr.done(function(data){
			$.each(data.success, function(index, value){
				$(':checkbox[value='+ value +']').parents('tr').remove();
			});
		}),
		jqXhr.fail(function(){
			BetaAdmin.showAjaxMessage('fail');
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
			if (data.errno == BETA_NO)
			    tthis.text(data.label);
			else
				BetaAdmin.showAjaxMessage('error');
		});
		jqXhr.fail(function(){
			BetaAdmin.showAjaxMessage('fail');
		});
	},
	ajaxSetCommentBoolColumn: function(event) {
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
			if (data.errno == BETA_NO)
			    tthis.text(data.label);
			else
				BetaAdmin.showAjaxMessage('error');
		});
		jqXhr.fail(function(){
			BetaAdmin.showAjaxMessage('fail');
		});
	}
};