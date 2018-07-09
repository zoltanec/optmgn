/*
 * Upload image module
 */
(function(D) {
	D.register('media-ajaxupload', new function() {
		var self = this;

		self.onready = function() {
			self.form_start('local');
		};

		//Инициализация jquery form
		self.form_start = function(mode) {
			var jquery_form_url = '';
			switch (mode) {
				case 'official': jquery_form_url = 'http://malsup.github.com/min/jquery.form.min.js'; break;
				case 'yandex': jquery_form_url = 'http://yastatic.net/jquery/form/3.14/jquery.form.min.js'; break;
				case 'local' : jquery_form_url = D.www+'/jscripts/jquery.form.js'; break;
			}
			//Получаем необходимые скрипты и инициализируем форму
			$.getScript(jquery_form_url,function(){
				$.getScript(D.www+'/jscripts/jquery.MultiFile.js');
				//http://github.com/fyneworks/multifile/blob/master/jQuery.MultiFile.min.js
				self.form_init();
			});
		};

		self.form_init = function() {
			//Настройки jquery.form
			var options = {
				success: self.form_response,
				timeout: 10000,
				clearForm: true
			};
			//Привязываем событие отправки формы
			$(document).on('submit', 'form.upload', function(event) {
				$(this).ajaxSubmit(options);
				return false;
			});
		};

		self.form_response = function(answer){
			console.log(answer);
			if(answer.status=='OK'){
                if(answer.mode == 'iteration') {
                    $('.list-images').html('');
                    var src = $('.list-images').attr('data-src');
                    for(var i = 0;i < answer.total; i++) {
                        var image = $('<img src = "' + src + answer.fileId + i + '.jpg" style="vertical-align: middle; max-width: 120px;" />');
                        $('.list-images').append(image);
                    }
				} else {
                    if(!$('img#icon').length)
                        alert('Файл загружен');
                    var icon_url = $('img#icon').attr('src');
                    $('img#icon').attr('src', icon_url + '?clear' + Math.random());
                }
			} else alert('Произошла ошибка!');
			$('input:file').MultiFile('reset');
		};
	});
})(D);