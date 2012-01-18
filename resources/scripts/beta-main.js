var Beta24 = {

};

var BetaPost = {

};

var BetaComment = {
	create: function(event){
		event.preventDefault();
		var tthis = this;
		var jqXhr = $.ajax({
			type: 'post',
			url: $(tthis).attr('action'),
			data: $(this).serialize(),
			dataType: 'json',
			cache: false,
			beforeSend: function(){
				console.log('beforeSend');
			}
		});
		jqXhr.done(function(data){
			if (data == '1') {
				$(tthis).find('.beta-captcha').val('');
				$(tthis).find('textarea').val('');
			}
			else
				alert('error');
		});
		jqXhr.fail(function(){
			alert('fail');
		});
	}
};