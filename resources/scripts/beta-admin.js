$(function(){
	var tip = $('#beta-admin-tip');
	if (tip.length == 0) {
		var html = '<div id="beta-admin-tip"></div>';
		$('body').append(html);
		tip = $('#beta-admin-tip');
	}
	$(document).ajaxStart(function(){
		tip.stop(true, true);
		tip.html('发送数据中...').fadeIn('fast');
	});
	
	$(document).ajaxSuccess(function(){
		tip.html('请求成功.');
	});
	
	$(document).ajaxError(function(){
		tip.html('发生错误.');
	});
	
	$(document).ajaxStop(function(){
		tip.html('请求完成.').delay(5000).fadeOut('slow');
	});
	
	$(document).on('click', '#beta-reload-current', function(event){
		window.location.reload();
	});
	
	$('[rel=tooltip]').tooltip();
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
				BetaAdmin.showAjaxMessage('发生错误.');
		});
		jqXhr.fail(function(){
			BetaAdmin.showAjaxMessage('请求错误.');
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
				BetaAdmin.showAjaxMessage('发生错误.');
		});
		jqXhr.fail(function(){
			BetaAdmin.showAjaxMessage('请求错误.');
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
			BetaAdmin.showAjaxMessage('请求错误.');
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
			BetaAdmin.showAjaxMessage('请求错误.');
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
			BetaAdmin.showAjaxMessage('请求错误.');
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
			BetaAdmin.showAjaxMessage('请求错误.');
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
				BetaAdmin.showAjaxMessage('发生错误.');
		});
		jqXhr.fail(function(){
			BetaAdmin.showAjaxMessage('请求错误.');
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
				BetaAdmin.showAjaxMessage('发生错误.');
		});
		jqXhr.fail(function(){
			BetaAdmin.showAjaxMessage('请求错误.');
		});
	},
	deleteMultiPosts: function(event) {
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
			BetaAdmin.showAjaxMessage('请求错误.');
		});
	},
	recommendMultiPosts: function(event) {
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
			BetaAdmin.showAjaxMessage('请求错误.');
		});
	},
	hottestMultiPosts: function(event) {
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
			BetaAdmin.showAjaxMessage('请求错误.');
		});
	},
	verifyMultiPosts: function(event) {
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
			BetaAdmin.showAjaxMessage('请求错误.');
		});
	},
	rejectMultiPosts: function(event) {
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
			BetaAdmin.showAjaxMessage('请求错误.');
		});
	}
};