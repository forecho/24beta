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

};

var BetaComment = {
	create: function(event){
		event.preventDefault();
		if ($(this).find('div.error').length > 0) {
			$('.beta-alert-message .text').html($('.ajax-jsstr .ajax-rules-invalid').text());
			$('.beta-alert-message').removeClass('success').addClass('error').show();
			return false;
		}
		
		var tthis = this;
		var jqXhr = $.ajax({
			type: 'post',
			url: $(tthis).attr('action'),
			data: $(this).serialize(),
			dataType: 'json',
			cache: false,
			beforeSend: function(){
				$('.beta-alert-message .text').html($('.ajax-jsstr .ajax-send').text());
				$('.beta-alert-message').removeClass('error').addClass('success').show();
			}
		});
		jqXhr.done(function(data){
			$('.beta-alert-message .text').html(data.text);
			if (data.errno == 0) {
				$(tthis).find('.beta-captcha').val('');
				$(tthis).find('textarea').val('');
				$(tthis).find('.comment-clearfix').removeClass('error').removeClass('success');
				$('.beta-alert-message').removeClass('error').addClass('success').show();
			}
			else {
				$('.beta-alert-message').removeClass('success').addClass('error').show();
			}
		});
		jqXhr.fail(function(){
			$('.beta-alert-message .text').html($('.ajax-jsstr .ajax-fail').text());
			$('.beta-alert-message').removeClass('success').addClass('error').show();
		});
		return false;
	},
	usernameValidate: function() {
		var name = $.trim($(this).val());
		if (name.length == 0) return true;
		
		if (name.length > 50) {
			$(this).parents('.comment-input').find('.help-inline').hide();
			$(this).parents('.comment-clearfix').removeClass('success').addClass('error');
			return false;
		}
		else {
			$(this).parents('.comment-input').find('.help-inline').hide();
			$(this).parents('.comment-clearfix').removeClass('error').addClass('success');
			return true;
		}
			
	},
	siteValidate: function() {
		var url = $.trim($(this).val());
		if (url.length == 0) return true;
		
		if (Beta24.urlValidate(url)) {
			$(this).parents('.comment-input').find('.help-inline').hide();
			$(this).parents('.comment-clearfix').removeClass('error').addClass('success');
			return true;
		}
		else {
			$(this).parents('.comment-input').find('.help-inline').hide();
			$(this).parents('.comment-clearfix').removeClass('success').addClass('error');
			return false;
		}
	},
	emailValidate: function(){
		var email = $.trim($(this).val());
		if (email.length == 0) return true;
		
		if (Beta24.emailValidate(email)) {
			$(this).parents('.comment-input').find('.help-inline').hide();
			$(this).parents('.comment-clearfix').removeClass('error').addClass('success');
			return true;
		}
		else {
			var input = $(this).parents('.comment-input');
			input.find('.help-info').hide();
			input.find('.help-error').show();
			$(this).parents('.comment-clearfix').removeClass('success').addClass('error');
			return false;
		}
	},
	captchaValidate: function(){
		var captcha = $.trim($(this).val());
		if (captcha.length == 4) {
			$(this).parents('.comment-input').find('.help-inline').hide();
			$(this).parents('.comment-clearfix').removeClass('error').addClass('success');
			return true;
		}
		else {
			var input = $(this).parents('.comment-input');
			input.find('.help-info').hide();
			input.find('.help-error').show();
			$(this).parents('.comment-clearfix').removeClass('success').addClass('error');
			return false;
		}
	},
	contentValidate: function() {
		var content = $.trim($(this).val());
		var minlen = parseInt($(this).attr('minlen'));
		minlen = (isNaN(minlen) || minlen == 0) ? 5 : minlen;
		if (content.length > minlen) {
			$(this).parents('.comment-clearfix').removeClass('error').addClass('success');
			return true;
		}
		else {
			$(this).parents('.comment-clearfix').removeClass('success').addClass('error');
			return false;
		}
	}
};


