var ajax_upload_form = new function(){

		this.uid=0;
		this.button = null;
		this.wrapper = null;
		this.form = null;
		this.input = null;
		this.iframe = null;
		this.spinlock = false;
		this.globalrandom = 0;
		
		this.settings = {
			// You can return false to cancel upload
			onSubmit: function(file, extension) {},
			// Fired when file upload is completed
			onComplete: function(file, response) {},
			// Fired when server returns the "success" string
			onSuccess: function(file){},
			// Fired when server return something else
			onError: function(file, response){}
		};

		// Merge the users options with our defaults

		this.upload = function(form,options) {
			this.form = $(form);
			$.extend(this.settings, options);

			ajax_upload_form.submit();
			return true;
		};
		this.get_uid = function(){
			return this.uid++;
		};
		
		this.create_iframe  = function() {

			var name = 'iframe_au' + this.get_uid();
			this.iframe =
				$('<iframe name="' + name + '"></iframe>')
				.css('display', 'none')
				.appendTo('body');
		};

		this.submit = function(){
			var self = this;
			var settings = this.settings;

			this.create_iframe();
			this.form.attr('target',this.iframe.attr('name'));

			var iframe = this.iframe;
			iframe.load(function(){
				
				var response = iframe.contents();
				
				
				settings.onComplete.call(self, response);
				if (response == 'success'){
					settings.onSuccess.call(self, response );
				} else {
					settings.onError.call(self, response);
				}

				// CLEAR ( ,   FF2 )
				setTimeout(function(){
					iframe.remove();
				}, 1);
			});

		};

		this.file_from_path = function(file){
			var i = file.lastIndexOf('\\');
			if (i !== -1 ){
				return file.slice(i+1);
			}
			return file;
		};
		
		this.get_ext = function(file){
			var i = file.lastIndexOf('.');

			if (i !== -1 ){
				return file.slice(i+1);
			}
			return '';
		};
};
	
