var Beta24 = {
	urlValidate: function(url) {
		var pattern = /http:\/\/[\w-]*(\.[\w-]*)+/ig;
		return pattern.test(url);
	},
	emailValidate: function(email) {
		var pattern = /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/ig;
		return pattern.test(email);
	}
};

var BetaPost = {
	increaseVisitNums: function(id, url) {
		if (id <= 0 || url.length == 0) return false;
		var data = 'id=' + id;
		var jqXhr = $.post(url, data, undefined, 'jsonp');
		jqXhr.done(function(data){});
	}
};

var BetaComment = {
	create: function(event){
		event.preventDefault();
		var msg = $(this).next('.beta-alert-message');
		if (msg.length == 0)
			msg = $('#beta-create-message').clone().removeAttr('id');
		$(this).after(msg);
		
		if ($(this).find('div.error').length > 0) {
			msg.find('.text').html($('.ajax-jsstr .ajax-rules-invalid').text());
			msg.removeClass('success').addClass('error').show();
			return false;
		}
		else {
			var contentEl = $(this).find('.comment-content');
			var content = $.trim(contentEl.val());
			var minlen = parseInt(contentEl.attr('minlen'));
			minlen = (isNaN(minlen) || minlen == 0) ? 5 : minlen;
			if (content.length < minlen) {
				msg.find('.text').html($('.ajax-jsstr .ajax-rules-invalid').text());
				msg.removeClass('success').addClass('error').show();
				contentEl.focus();
				return false;
			}
			var captchaEl = $(this).find('.beta-captcha');
			var captcha = $.trim(captchaEl.val());
			if (captcha.length != 4) {
				msg.find('.text').html($('.ajax-jsstr .ajax-rules-invalid').text());
				msg.removeClass('success').addClass('error').show();
				captchaEl.focus();
				return false;
			}
		}

		var tthis = this;
		var jqXhr = $.ajax({
			type: 'post',
			url: $(tthis).attr('action'),
			data: $(this).serialize(),
			dataType: 'jsonp',
			cache: false,
			beforeSend: function(jqXhr){
				msg.find('.text').html($('.ajax-jsstr .ajax-send').text());
				msg.removeClass('error').addClass('success').show();
			}
		});
		jqXhr.done(function(data){
			msg.find('.text').html(data.text);
			if (data.errno == 0) {
				$(tthis).find('.beta-captcha').val('');
				$(tthis).find('textarea').val('');
				$(tthis).find('.comment-clearfix').removeClass('error').removeClass('success');
				msg.removeClass('error').addClass('success').show();
				$('#beta-comment-list').after(data.html);
			}
			else {
				msg.removeClass('success').addClass('error').show();
				$(tthis).find('.refresh-captcha').click();
			}
		});
		jqXhr.fail(function(event, jqXHR, ajaxSettings, thrownError){
			jqXhr.abort();
			msg.find('.text').html($('.ajax-jsstr .ajax-fail').text());
			msg.removeClass('success').addClass('error').show();
		});
		return false;
	},
	reply: function() {
		var form = $(this).parents('.beta-comment-item').next('form');
		if (form.length == 0) {
			form = $('#comment-form').clone().removeAttr('id').addClass('comment-reply-form').attr('action', $(this).attr('data-url'));;
			$(this).parents('.beta-comment-item').after(form);
		}
		else if (form.filter(':visible').length == 0)
			form.show();
		else
			form.hide();
		
	},
	rating: function(event) {
		event.preventDefault();
		var tthis = this;
		var url = $(this).attr('data-url');
		var jqXhr = $.ajax({
			url: url,
			dataType: 'jsonp',
			type: 'post',
			cache: false,
			beforeSend: function(jqXhr) {
				var msg = $(tthis).parents('.beta-comment-item').next('.beta-alert-message');
				if (msg.length == 0)
					msg = $('#beta-comment-message').clone().removeAttr('id');
				msg.find('.text').html($('.ajax-jsstr .ajax-send').text());
				msg.removeClass('error').addClass('success');
				$(tthis).parents('.beta-comment-item').after(msg);
				msg.show();
			}
		});
		jqXhr.done(function(data){
			var msg = $(tthis).parents('.beta-comment-item').next('.beta-alert-message');
			if (msg.length == 0)
				msg = $('#beta-comment-message').clone().removeAttr('id');
			msg.find('.text').html(data.text);
			if (data.errno == 0) {
				if (msg.hasClass('error')) msg.removeClass('error');
				if (!msg.hasClass('success')) msg.addClass('success');
			}
			else {
				if (msg.hasClass('success')) msg.removeClass('success');
				if (!msg.hasClass('error')) msg.addClass('error');
			}
			$(tthis).parents('.beta-comment-item').after(msg);
			msg.show();
		});
		jqXhr.fail(function(event, jqXHR, ajaxSettings, thrownError){
			var msg = $(tthis).parents('.beta-comment-item').next('.beta-alert-message');
			if (msg.length == 0)
				msg = $('#beta-comment-message').clone().removeAttr('id');
			msg.find('.text').html($('.ajax-jsstr .ajax-fail').text());
			if (msg.hasClass('success')) msg.removeClass('success');
			if (!msg.hasClass('error')) msg.addClass('error');
			$(tthis).parents('.beta-comment-item').after(msg);
			msg.show();
		});
	},
	usernameValidate: function(event) {
		var name = $.trim($(this).val());
		var help = $(this).parents('.comment-input').find('.help-inline');
		var helperror = $(this).parents('.comment-input').find('.help-error');
		var clearfix = $(this).parents('.comment-clearfix');
		if (name.length == 0) {
			helperror.hide();
			clearfix.removeClass('error').removeClass('success');
			return true;
		}

		help.hide();
		if (name.length > 50) {
			helperror.show();
			$(this).parents('.comment-clearfix').removeClass('success').addClass('error');
			return false;
		}
		else {
			clearfix.removeClass('error').addClass('success');
			return true;
		}

	},
	siteValidate: function(event) {
		var url = $.trim($(this).val());
		var help = $(this).parents('.comment-input').find('.help-inline');
		var helperror = $(this).parents('.comment-input').find('.help-error');
		var clearfix = $(this).parents('.comment-clearfix');

		if (url.length == 0) {
			helperror.hide();
			clearfix.removeClass('error').removeClass('success');
			return true;
		}

		help.hide();
		if (Beta24.urlValidate(url)) {
			clearfix.removeClass('error').addClass('success');
			return true;
		}
		else {
			helperror.show();
			clearfix.removeClass('success').addClass('error');
			return false;
		}
	},
	emailValidate: function(event){
		var email = $.trim($(this).val());
		var help = $(this).parents('.comment-input').find('.help-inline');
		var helperror = $(this).parents('.comment-input').find('.help-error');
		var clearfix = $(this).parents('.comment-clearfix');
		if (email.length == 0) {
			helperror.hide();
			clearfix.removeClass('error').removeClass('success');
			return true;
		}

		help.hide();
		if (Beta24.emailValidate(email)) {
			clearfix.removeClass('error').addClass('success');
			return true;
		}
		else {
			helperror.show();
			clearfix.removeClass('success').addClass('error');
			return false;
		}
	},
	captchaValidate: function(event){
		var captcha = $.trim($(this).val());
		var help = $(this).parents('.comment-input').find('.help-inline');
		var helperror = $(this).parents('.comment-input').find('.help-error');
		var clearfix = $(this).parents('.comment-clearfix');

		help.hide();
		if (captcha.length == 4) {
			clearfix.removeClass('error').addClass('success');
			return true;
		}
		else {
			helperror.show();
			clearfix.removeClass('success').addClass('error');
			return false;
		}
	},
	contentValidate: function(event) {
		var content = $.trim($(this).val());
		var minlen = parseInt($(this).attr('minlen'));
		var clearfix = $(this).parents('.comment-clearfix');
		minlen = (isNaN(minlen) || minlen == 0) ? 5 : minlen;
		if (content.length > minlen) {
			clearfix.removeClass('error').addClass('success');
			return true;
		}
		else {
			clearfix.removeClass('success').addClass('error');
			return false;
		}
	}
};


