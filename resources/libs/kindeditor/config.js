var KEConfig = {
	mini: {
		height:200,
        resizeType: 1,
		allowFileManager: false,
		allowUpload: false,
		filterMode: true,
		items: ['plainpaste', 'wordpaste', '|', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'insertorderedlist',
	        'insertunorderedlist', 'bold', 'italic', 'underline', 'strikethrough', '|', 'image', 'flash', 'media',
	        'link', 'unlink', '|', 'selectall', 'clearhtml', 'removeformat']
	},
	common: {
		height:400,
        resizeType: 1,
		allowFileManager: false,
		allowUpload: false,
		filterMode: true,
		cssPath: ['http://s.24beta.cn/libs/bootstrap/css/bootstrap.min.css', 'http://s.24beta.cn/styles/beta-main.css'],
		items: ['undo', 'redo', '|', 'cut', 'copy', 'paste',
	        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
	        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
	        'superscript', '|', 'selectall', 'clearhtml', 'removeformat', 'quickformat', 'fullscreen', 'preview', '/',
	        'forecolor', 'hilitecolor', 'bold',
	        'italic', 'underline', 'strikethrough', '|', 'image',
	        'flash', 'media', 'table', 'hr', 'emoticons', 'link', 'unlink', '|', 'about']
	},
	admin: {
		height:250,
        resizeType: 1,
		allowFileManager: false,
		allowUpload: false,
		filterMode: true,
		allowImageUpload: true,
		allowFlashUpload: true,
		allowMediaUpload: true,
		uploadJson: 'javascript:void(0)',
		items: ['source', '|', 'undo', 'redo', '|', 'cut', 'copy', 'paste',
	        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
	        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
	        'superscript', '|', 'selectall', 'clearhtml', 'removeformat', 'quickformat', '/',
	        'forecolor', 'hilitecolor', 'bold', 'italic', 'underline', 'strikethrough', '|', 'image',
	        'flash', 'media', 'table', 'hr', 'emoticons', 'link', 'unlink', '|', 'map', 'code', 'pagebreak', '|', 'fullscreen', 'preview', 'about'],
	        
	}
};